<?php
/**
 * Plugin Name: SangMeLima Core
 * Plugin URI: https://sangmelima.org
 * Description: Plugin principal pour l'application d'évangélisation SangMeLima
 * Version: 1.0.0
 * Author: Xavier Soh
 * Author URI: https://xaviersoh.com
 * License: GPL v2 or later
 * Text Domain: sangmelima-core
 */

// Sécurité
if (!defined('ABSPATH')) {
    exit;
}

// Constantes
define('SANGMELIMA_PLUGIN_VERSION', '1.0.0');
define('SANGMELIMA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SANGMELIMA_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SANGMELIMA_PLUGIN_BASENAME', plugin_basename(__FILE__));

// ========================================
// CHARGEMENT DES FICHIERS
// ========================================
// Charger les fichiers admin
if (is_admin()) {
    require_once SANGMELIMA_PLUGIN_DIR . 'admin/csv-export.php';
}

// Charger les includes
require_once SANGMELIMA_PLUGIN_DIR . 'includes/appointment-cancellation.php';

// ========================================
// ACTIVATION & DÉSACTIVATION
// ========================================
register_activation_hook(__FILE__, 'sangmelima_activate');
register_deactivation_hook(__FILE__, 'sangmelima_deactivate');

function sangmelima_activate() {
    // Créer les tables de base de données
    sangmelima_create_tables();

    // Créer les rôles
    sangmelima_create_roles();

    // Planifier les tâches cron
    if (!wp_next_scheduled('sangmelima_daily_tasks')) {
        wp_schedule_event(time(), 'daily', 'sangmelima_daily_tasks');
    }

    // Flush rewrite rules
    flush_rewrite_rules();
}

function sangmelima_deactivate() {
    // Nettoyer les tâches cron
    wp_clear_scheduled_hook('sangmelima_daily_tasks');

    flush_rewrite_rules();
}

// ========================================
// CRÉATION DES TABLES
// ========================================
function sangmelima_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Table des groupes de prière
    $table_prayer_groups = $wpdb->prefix . 'prayer_groups';
    $sql_groups = "CREATE TABLE $table_prayer_groups (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        description text,
        creator_id bigint(20) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        is_public tinyint(1) DEFAULT 1,
        max_members int DEFAULT 50,
        PRIMARY KEY (id),
        KEY creator_id (creator_id)
    ) $charset_collate;";

    // Table des membres des groupes
    $table_group_members = $wpdb->prefix . 'prayer_group_members';
    $sql_members = "CREATE TABLE $table_group_members (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        group_id bigint(20) NOT NULL,
        user_id bigint(20) NOT NULL,
        joined_at datetime DEFAULT CURRENT_TIMESTAMP,
        role varchar(20) DEFAULT 'member',
        PRIMARY KEY (id),
        UNIQUE KEY group_user (group_id, user_id)
    ) $charset_collate;";

    // Table des rendez-vous spirituels
    $table_appointments = $wpdb->prefix . 'spiritual_appointments';
    $sql_appointments = "CREATE TABLE $table_appointments (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        date_time datetime NOT NULL,
        duration int DEFAULT 60,
        status varchar(20) DEFAULT 'pending',
        payment_status varchar(20) DEFAULT 'unpaid',
        amount decimal(10,2),
        notes text,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id),
        KEY date_time (date_time)
    ) $charset_collate;";

    // Table des dons
    $table_donations = $wpdb->prefix . 'donations';
    $sql_donations = "CREATE TABLE $table_donations (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        donor_name varchar(255),
        donor_email varchar(255),
        amount decimal(10,2) NOT NULL,
        donation_type varchar(50) DEFAULT 'support',
        payment_method varchar(50),
        payment_id varchar(255),
        status varchar(20) DEFAULT 'pending',
        message text,
        is_anonymous tinyint(1) DEFAULT 0,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY donor_email (donor_email),
        KEY status (status)
    ) $charset_collate;";

    // Table des participations aux neuvaines
    $table_neuvaine_participants = $wpdb->prefix . 'neuvaine_participants';
    $sql_participants = "CREATE TABLE $table_neuvaine_participants (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        neuvaine_id bigint(20) NOT NULL,
        user_id bigint(20) NOT NULL,
        current_day int DEFAULT 1,
        completed_days text,
        joined_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY neuvaine_user (neuvaine_id, user_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_groups);
    dbDelta($sql_members);
    dbDelta($sql_appointments);
    dbDelta($sql_donations);
    dbDelta($sql_participants);
}

// ========================================
// CRÉATION DES RÔLES
// ========================================
function sangmelima_create_roles() {
    // Rôle pour les accompagnateurs spirituels
    add_role('spiritual_advisor', __('Accompagnateur spirituel', 'sangmelima-core'), array(
        'read' => true,
        'edit_posts' => true,
        'manage_appointments' => true
    ));

    // Rôle pour les modérateurs
    add_role('prayer_moderator', __('Modérateur de prière', 'sangmelima-core'), array(
        'read' => true,
        'moderate_prayers' => true,
        'manage_groups' => true
    ));
}

// ========================================
// INTÉGRATION API AELF
// ========================================
class SangMeLima_AELF_API {

    private $api_base = 'https://api.aelf.org/v1';

    public function get_daily_readings($date = null) {
        if (!$date) {
            $date = date('Y-m-d');
        }

        $cache_key = 'aelf_readings_' . $date;
        $cached = get_transient($cache_key);

        if ($cached) {
            return $cached;
        }

        $response = wp_remote_get($this->api_base . '/messes/' . $date);

        if (!is_wp_error($response)) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            if ($data) {
                set_transient($cache_key, $data, 12 * HOUR_IN_SECONDS);
                return $data;
            }
        }

        return false;
    }

    public function get_gospel($date = null) {
        $readings = $this->get_daily_readings($date);

        if ($readings && isset($readings['messes'][0]['lectures'])) {
            foreach ($readings['messes'][0]['lectures'] as $lecture) {
                if ($lecture['type'] == 'evangile') {
                    return $lecture;
                }
            }
        }

        return false;
    }

    public function get_prayer_of_day() {
        // Récupérer une prière aléatoire du jour
        $args = array(
            'post_type' => 'priere',
            'posts_per_page' => 1,
            'orderby' => 'rand'
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $query->the_post();
            $prayer = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'content' => get_the_content(),
                'excerpt' => get_the_excerpt()
            );
            wp_reset_postdata();
            return $prayer;
        }

        return false;
    }
}

// ========================================
// AJAX HANDLERS
// ========================================

// Rejoindre une neuvaine
add_action('wp_ajax_join_neuvaine', 'sangmelima_join_neuvaine');
add_action('wp_ajax_nopriv_join_neuvaine', 'sangmelima_join_neuvaine');

function sangmelima_join_neuvaine() {
    check_ajax_referer('sangmelima_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error(__('Vous devez être connecté', 'sangmelima-core'));
    }

    $neuvaine_id = intval($_POST['neuvaine_id']);
    $user_id = get_current_user_id();

    global $wpdb;
    $table = $wpdb->prefix . 'neuvaine_participants';

    // Vérifier si déjà inscrit
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM $table WHERE neuvaine_id = %d AND user_id = %d",
        $neuvaine_id, $user_id
    ));

    if (!$exists) {
        $result = $wpdb->insert(
            $table,
            array(
                'neuvaine_id' => $neuvaine_id,
                'user_id' => $user_id,
                'current_day' => 1
            )
        );

        if ($result) {
            // Incrémenter le compteur de participants
            $count = get_post_meta($neuvaine_id, 'participants', true);
            update_post_meta($neuvaine_id, 'participants', intval($count) + 1);

            wp_send_json_success(__('Vous avez rejoint la neuvaine', 'sangmelima-core'));
        }
    }

    wp_send_json_error(__('Erreur lors de l\'inscription', 'sangmelima-core'));
}

// Traiter les dons
add_action('wp_ajax_process_donation', 'sangmelima_process_donation');
add_action('wp_ajax_nopriv_process_donation', 'sangmelima_process_donation');

function sangmelima_process_donation() {
    check_ajax_referer('donation_nonce', 'nonce');

    $amount = floatval($_POST['amount']);
    $donation_type = sanitize_text_field($_POST['donation_type']);
    $donor_name = sanitize_text_field($_POST['donor_name']);
    $donor_email = sanitize_email($_POST['donor_email']);
    $payment_method = isset($_POST['payment_method']) ? sanitize_text_field($_POST['payment_method']) : 'stripe';

    global $wpdb;
    $table = $wpdb->prefix . 'donations';

    $data = array(
        'donor_name' => $donor_name,
        'donor_email' => $donor_email,
        'amount' => $amount,
        'donation_type' => $donation_type,
        'payment_method' => $payment_method,
        'status' => 'pending'
    );

    if (isset($_POST['message'])) {
        $data['message'] = sanitize_textarea_field($_POST['message']);
    }

    if (isset($_POST['anonymous'])) {
        $data['is_anonymous'] = 1;
    }

    $result = $wpdb->insert($table, $data);

    if ($result) {
        $donation_id = $wpdb->insert_id;

        // Redirection selon la méthode de paiement
        switch ($payment_method) {
            case 'stripe':
                wp_send_json_success(array(
                    'redirect' => add_query_arg(array(
                        'donation_id' => $donation_id,
                        'amount' => $amount
                    ), home_url('/payment/stripe'))
                ));
                break;

            case 'paypal':
                wp_send_json_success(array(
                    'redirect' => add_query_arg(array(
                        'donation_id' => $donation_id,
                        'amount' => $amount
                    ), home_url('/payment/paypal'))
                ));
                break;

            case 'orange_money':
                wp_send_json_success(array(
                    'redirect' => add_query_arg(array(
                        'donation_id' => $donation_id,
                        'amount' => $amount
                    ), home_url('/payment/orange-money'))
                ));
                break;
        }
    }

    wp_send_json_error(__('Erreur lors du traitement du don', 'sangmelima-core'));
}

// Newsletter
add_action('wp_ajax_sangmelima_newsletter', 'sangmelima_newsletter_subscribe');
add_action('wp_ajax_nopriv_sangmelima_newsletter', 'sangmelima_newsletter_subscribe');

// Lecture AELF
add_action('wp_ajax_get_aelf_reading', 'sangmelima_get_aelf_reading');
add_action('wp_ajax_nopriv_get_aelf_reading', 'sangmelima_get_aelf_reading');

// Réservation de rendez-vous
add_action('wp_ajax_book_appointment', 'sangmelima_book_appointment');
add_action('wp_ajax_nopriv_book_appointment', 'sangmelima_book_appointment');

// Simulation de paiement
add_action('wp_ajax_simulate_payment', 'sangmelima_simulate_payment');
add_action('wp_ajax_nopriv_simulate_payment', 'sangmelima_simulate_payment');

function sangmelima_get_aelf_reading() {
    check_ajax_referer('sangmelima_nonce', 'nonce');

    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'evangile';
    $date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : date('Y-m-d');

    // Valider le format de date
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        $date = date('Y-m-d');
    }

    // Utiliser la classe AELF
    $aelf = new SangMeLima_AELF_API();
    $readings = $aelf->get_daily_readings($date);

    if ($readings && isset($readings['messes'][0]['lectures'])) {
        $evangile = null;

        // Chercher l'évangile
        foreach ($readings['messes'][0]['lectures'] as $lecture) {
            if ($lecture['type'] === 'evangile') {
                $evangile = $lecture;
                break;
            }
        }

        if ($evangile) {
            $html = sprintf(
                '<h4>%s</h4><p class="reference"><strong>%s</strong></p><div class="lecture-content">%s</div>',
                esc_html($evangile['titre']),
                esc_html($evangile['ref']),
                wp_kses_post(substr($evangile['contenu'], 0, 300)) . '...'
            );
            wp_send_json_success($html);
        } else {
            // Prendre la première lecture
            $lecture = $readings['messes'][0]['lectures'][0];
            $html = sprintf(
                '<h4>%s</h4><p class="reference"><strong>%s</strong></p><div class="lecture-content">%s</div>',
                esc_html($lecture['titre']),
                esc_html($lecture['ref']),
                wp_kses_post(substr($lecture['contenu'], 0, 300)) . '...'
            );
            wp_send_json_success($html);
        }
    }

    wp_send_json_error(__('Lectures non disponibles pour le moment', 'sangmelima-core'));
}

function sangmelima_newsletter_subscribe() {
    check_ajax_referer('sangmelima_newsletter', 'newsletter_nonce');

    $email = sanitize_email($_POST['email']);

    if (!is_email($email)) {
        wp_send_json_error(__('Email invalide', 'sangmelima-core'));
    }

    // Sauvegarder l'email (utiliser MailChimp, SendinBlue ou autre service)
    $subscribers = get_option('sangmelima_newsletter_subscribers', array());

    if (!in_array($email, $subscribers)) {
        $subscribers[] = $email;
        update_option('sangmelima_newsletter_subscribers', $subscribers);

        // Envoyer un email de bienvenue
        wp_mail(
            $email,
            __('Bienvenue dans notre communauté', 'sangmelima-core'),
            __('Merci de votre inscription à notre newsletter.', 'sangmelima-core')
        );

        wp_send_json_success(__('Inscription réussie', 'sangmelima-core'));
    }

    wp_send_json_error(__('Cet email est déjà inscrit', 'sangmelima-core'));
}

// Gérer la réservation de rendez-vous
function sangmelima_book_appointment() {
    check_ajax_referer('rdv_booking', 'rdv_nonce');

    // Récupérer les données
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $date = sanitize_text_field($_POST['date']);
    $time = sanitize_text_field($_POST['time']);
    $platform = sanitize_text_field($_POST['platform']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    $donation_amount = floatval($_POST['donation_amount']);

    // Créer l'utilisateur si pas connecté
    $user_id = get_current_user_id();
    if (!$user_id) {
        // Vérifier si l'email existe
        $user = get_user_by('email', $email);
        if (!$user) {
            // Créer un nouvel utilisateur
            $user_id = wp_create_user($email, wp_generate_password(), $email);
            wp_update_user(array(
                'ID' => $user_id,
                'display_name' => $name,
                'first_name' => $name
            ));
        } else {
            $user_id = $user->ID;
        }
    }

    // Enregistrer le rendez-vous dans la base de données
    global $wpdb;
    $table = $wpdb->prefix . 'spiritual_appointments';

    // Générer un token d'annulation unique
    $cancellation_token = bin2hex(random_bytes(32));

    $result = $wpdb->insert(
        $table,
        array(
            'user_id' => $user_id,
            'date_time' => $date . ' ' . $time . ':00',
            'status' => 'pending',
            'payment_status' => 'pending',
            'amount' => $donation_amount,
            'notes' => json_encode(array(
                'platform' => $platform,
                'subject' => $subject,
                'message' => $message,
                'phone' => $phone
            )),
            'cancellation_token' => $cancellation_token
        )
    );

    if ($result) {
        $appointment_id = $wpdb->insert_id;

        // Générer le lien d'annulation
        $cancellation_url = add_query_arg(array(
            'cancel_appointment' => 1,
            'token' => $cancellation_token
        ), home_url());

        // Envoyer l'email de confirmation
        $to = $email;
        $subject_email = __('Confirmation de votre rendez-vous spirituel', 'sangmelima-core');
        $message_email = sprintf(
            __("Bonjour %s,\n\nVotre rendez-vous spirituel est confirmé pour le %s à %s.\n\nPlateforme : %s\nDon suggéré : %s €\n\nVous recevrez le lien de connexion 30 minutes avant le rendez-vous.\n\nPour annuler votre rendez-vous (possible jusqu'à 24h avant) :\n%s\n\nCordialement,\nL'équipe SangMeLima", 'sangmelima-core'),
            $name,
            date_i18n('j F Y', strtotime($date)),
            $time,
            ucfirst($platform),
            $donation_amount,
            $cancellation_url
        );

        wp_mail($to, $subject_email, $message_email);

        // Envoyer aussi à l'administrateur
        $admin_email = get_option('admin_email');
        wp_mail(
            $admin_email,
            __('Nouveau rendez-vous spirituel', 'sangmelima-core'),
            sprintf(
                __("Un nouveau rendez-vous a été réservé par %s pour le %s à %s.\n\nEmail : %s\nTéléphone : %s\nSujet : %s\nMessage : %s\nDon : %s €", 'sangmelima-core'),
                $name,
                date_i18n('j F Y', strtotime($date)),
                $time,
                $email,
                $phone,
                $subject,
                $message,
                $donation_amount
            )
        );

        // Rediriger vers la page de paiement si un don est prévu
        if ($donation_amount > 0) {
            wp_send_json_success(array(
                'message' => __('Rendez-vous confirmé ! Redirection vers le paiement...', 'sangmelima-core'),
                'redirect' => add_query_arg(array(
                    'amount' => $donation_amount,
                    'type' => 'rdv',
                    'ref' => 'RDV-' . $appointment_id,
                    'method' => 'stripe'
                ), home_url('/simulation-paiement'))
            ));
        } else {
            wp_send_json_success(array(
                'message' => __('Votre rendez-vous est confirmé !', 'sangmelima-core')
            ));
        }
    }

    wp_send_json_error(__('Erreur lors de la réservation', 'sangmelima-core'));
}

// Simuler un paiement
function sangmelima_simulate_payment() {
    $amount = floatval($_POST['amount']);
    $type = sanitize_text_field($_POST['type']);
    $reference = sanitize_text_field($_POST['reference']);
    $method = sanitize_text_field($_POST['method']);
    $status = sanitize_text_field($_POST['status']);

    // Enregistrer dans la table des dons
    global $wpdb;
    $table = $wpdb->prefix . 'donations';

    $result = $wpdb->insert(
        $table,
        array(
            'amount' => $amount,
            'donation_type' => $type,
            'payment_method' => $method,
            'payment_id' => $reference,
            'status' => $status === 'success' ? 'completed' : 'failed',
            'created_at' => current_time('mysql')
        )
    );

    // Si c'est un RDV, mettre à jour le statut de paiement
    if ($type === 'rdv' && strpos($reference, 'RDV-') === 0) {
        $appointment_id = str_replace('RDV-', '', $reference);
        $appointments_table = $wpdb->prefix . 'spiritual_appointments';

        $wpdb->update(
            $appointments_table,
            array('payment_status' => $status === 'success' ? 'paid' : 'failed'),
            array('id' => $appointment_id)
        );
    }

    if ($result) {
        wp_send_json_success(array(
            'message' => __('Paiement simulé avec succès', 'sangmelima-core'),
            'transaction_id' => $wpdb->insert_id
        ));
    }

    wp_send_json_error(__('Erreur lors de la simulation', 'sangmelima-core'));
}

// ========================================
// TÂCHES CRON
// ========================================
add_action('sangmelima_daily_tasks', 'sangmelima_run_daily_tasks');

function sangmelima_run_daily_tasks() {
    // Mettre à jour le jour des neuvaines
    global $wpdb;
    $table = $wpdb->prefix . 'neuvaine_participants';

    $wpdb->query("UPDATE $table SET current_day = current_day + 1 WHERE current_day < 9");

    // Nettoyer les anciennes données
    $wpdb->query("DELETE FROM $table WHERE current_day >= 9 AND DATE_ADD(joined_at, INTERVAL 10 DAY) < NOW()");

    // Envoyer les rappels de RDV
    sangmelima_send_appointment_reminders();
}

function sangmelima_send_appointment_reminders() {
    global $wpdb;
    $table = $wpdb->prefix . 'spiritual_appointments';

    // Rappels pour demain
    $tomorrow = date('Y-m-d', strtotime('+1 day'));

    $appointments = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table
         WHERE DATE(date_time) = %s
         AND status = 'confirmed'",
        $tomorrow
    ));

    foreach ($appointments as $appointment) {
        $user = get_user_by('id', $appointment->user_id);
        if ($user) {
            wp_mail(
                $user->user_email,
                __('Rappel: Rendez-vous spirituel demain', 'sangmelima-core'),
                sprintf(
                    __('Votre rendez-vous spirituel est prévu demain à %s', 'sangmelima-core'),
                    date_i18n('H:i', strtotime($appointment->date_time))
                )
            );
        }
    }
}

// ========================================
// SHORTCODES
// ========================================

// Shortcode pour afficher l'évangile du jour
add_shortcode('evangile_du_jour', 'sangmelima_shortcode_evangile');

function sangmelima_shortcode_evangile($atts) {
    $aelf = new SangMeLima_AELF_API();
    $evangile = $aelf->get_gospel();

    if ($evangile) {
        ob_start();
        ?>
        <div class="evangile-du-jour">
            <h3><?php echo esc_html($evangile['titre']); ?></h3>
            <p class="reference"><?php echo esc_html($evangile['ref']); ?></p>
            <div class="contenu">
                <?php echo wp_kses_post($evangile['contenu']); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    return '<p>' . __('Évangile non disponible', 'sangmelima-core') . '</p>';
}

// Shortcode pour le formulaire de don
add_shortcode('formulaire_don', 'sangmelima_shortcode_donation_form');

function sangmelima_shortcode_donation_form($atts) {
    $atts = shortcode_atts(array(
        'type' => 'support',
        'amount' => '20'
    ), $atts);

    ob_start();
    ?>
    <form class="donation-form-shortcode ajax-form">
        <div class="form-group">
            <label><?php _e('Montant', 'sangmelima-core'); ?></label>
            <select name="amount">
                <option value="10">10 €</option>
                <option value="20" <?php selected($atts['amount'], '20'); ?>>20 €</option>
                <option value="30">30 €</option>
                <option value="50">50 €</option>
                <option value="100">100 €</option>
            </select>
        </div>

        <div class="form-group">
            <label><?php _e('Nom', 'sangmelima-core'); ?></label>
            <input type="text" name="donor_name" required>
        </div>

        <div class="form-group">
            <label><?php _e('Email', 'sangmelima-core'); ?></label>
            <input type="email" name="donor_email" required>
        </div>

        <input type="hidden" name="action" value="process_donation">
        <input type="hidden" name="donation_type" value="<?php echo esc_attr($atts['type']); ?>">
        <?php wp_nonce_field('donation_nonce', 'nonce'); ?>

        <button type="submit" class="btn btn-primary">
            <?php _e('Faire un don', 'sangmelima-core'); ?>
        </button>
    </form>
    <?php
    return ob_get_clean();
}

// ========================================
// ADMIN MENU
// ========================================
add_action('admin_menu', 'sangmelima_admin_menu');

function sangmelima_admin_menu() {
    add_menu_page(
        __('SangMeLima', 'sangmelima-core'),
        __('SangMeLima', 'sangmelima-core'),
        'manage_options',
        'sangmelima',
        'sangmelima_admin_dashboard',
        'dashicons-heart',
        30
    );

    add_submenu_page(
        'sangmelima',
        __('Dons', 'sangmelima-core'),
        __('Dons', 'sangmelima-core'),
        'manage_options',
        'sangmelima-donations',
        'sangmelima_admin_donations'
    );

    add_submenu_page(
        'sangmelima',
        __('Rendez-vous', 'sangmelima-core'),
        __('Rendez-vous', 'sangmelima-core'),
        'manage_options',
        'sangmelima-appointments',
        'sangmelima_admin_appointments'
    );

    add_submenu_page(
        'sangmelima',
        __('Groupes de prière', 'sangmelima-core'),
        __('Groupes de prière', 'sangmelima-core'),
        'manage_options',
        'sangmelima-groups',
        'sangmelima_admin_groups'
    );

    add_submenu_page(
        'sangmelima',
        __('Newsletter', 'sangmelima-core'),
        __('Newsletter', 'sangmelima-core'),
        'manage_options',
        'sangmelima-newsletter',
        'sangmelima_admin_newsletter'
    );
}

function sangmelima_admin_dashboard() {
    ?>
    <div class="wrap">
        <h1><?php _e('Tableau de bord SangMeLima', 'sangmelima-core'); ?></h1>

        <div class="dashboard-widgets">
            <?php
            global $wpdb;

            // Statistiques des dons
            $donations_table = $wpdb->prefix . 'donations';
            $total_donations = $wpdb->get_var("SELECT SUM(amount) FROM $donations_table WHERE status = 'completed'");
            $donations_count = $wpdb->get_var("SELECT COUNT(*) FROM $donations_table WHERE status = 'completed'");

            // Statistiques des RDV
            $appointments_table = $wpdb->prefix . 'spiritual_appointments';
            $upcoming_appointments = $wpdb->get_var("SELECT COUNT(*) FROM $appointments_table WHERE date_time > NOW() AND status = 'confirmed'");

            // Statistiques des groupes
            $groups_table = $wpdb->prefix . 'prayer_groups';
            $total_groups = $wpdb->get_var("SELECT COUNT(*) FROM $groups_table");
            ?>

            <div class="dashboard-widget">
                <h3><?php _e('Dons', 'sangmelima-core'); ?></h3>
                <p class="stat"><?php echo number_format($total_donations, 2, ',', ' '); ?> €</p>
                <p><?php echo sprintf(__('%d dons reçus', 'sangmelima-core'), $donations_count); ?></p>
            </div>

            <div class="dashboard-widget">
                <h3><?php _e('Rendez-vous', 'sangmelima-core'); ?></h3>
                <p class="stat"><?php echo $upcoming_appointments; ?></p>
                <p><?php _e('Rendez-vous à venir', 'sangmelima-core'); ?></p>
            </div>

            <div class="dashboard-widget">
                <h3><?php _e('Groupes de prière', 'sangmelima-core'); ?></h3>
                <p class="stat"><?php echo $total_groups; ?></p>
                <p><?php _e('Groupes actifs', 'sangmelima-core'); ?></p>
            </div>
        </div>

        <style>
            .dashboard-widgets {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                margin-top: 20px;
            }

            .dashboard-widget {
                background: white;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .dashboard-widget h3 {
                margin-top: 0;
            }

            .dashboard-widget .stat {
                font-size: 2em;
                font-weight: bold;
                color: #0073aa;
                margin: 10px 0;
            }
        </style>
    </div>
    <?php
}

// Charger les traductions
add_action('plugins_loaded', 'sangmelima_load_textdomain');

function sangmelima_load_textdomain() {
    load_plugin_textdomain('sangmelima-core', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
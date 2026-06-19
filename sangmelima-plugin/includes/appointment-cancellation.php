<?php
/**
 * Système d'annulation de rendez-vous
 * @package SangMeLima
 */

// Sécurité
if (!defined('ABSPATH')) {
    exit;
}

class SangMeLima_Appointment_Cancellation {

    public function __construct() {
        // Ajouter la colonne token à la table des RDV si elle n'existe pas
        add_action('init', [$this, 'maybe_add_token_column']);

        // Gérer les annulations via URL
        add_action('init', [$this, 'handle_cancellation_request']);

        // AJAX pour annulation depuis le compte utilisateur
        add_action('wp_ajax_cancel_appointment', [$this, 'ajax_cancel_appointment']);

        // Shortcode pour la page d'annulation
        add_shortcode('sangmelima_cancel_appointment', [$this, 'cancellation_page']);
    }

    /**
     * Ajouter la colonne token si elle n'existe pas
     */
    public function maybe_add_token_column() {
        global $wpdb;
        $table = $wpdb->prefix . 'spiritual_appointments';

        // Vérifier si la colonne existe
        $column_exists = $wpdb->get_var("
            SELECT COUNT(*)
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = '{$wpdb->dbname}'
            AND TABLE_NAME = '{$table}'
            AND COLUMN_NAME = 'cancellation_token'
        ");

        if (!$column_exists) {
            $wpdb->query("ALTER TABLE {$table} ADD COLUMN cancellation_token VARCHAR(64) UNIQUE");
            $wpdb->query("ALTER TABLE {$table} ADD COLUMN cancelled_at DATETIME NULL");
            $wpdb->query("ALTER TABLE {$table} ADD COLUMN cancellation_reason TEXT NULL");
        }
    }

    /**
     * Générer un token unique pour l'annulation
     */
    public function generate_cancellation_token() {
        return bin2hex(random_bytes(32));
    }

    /**
     * Gérer les demandes d'annulation via URL
     */
    public function handle_cancellation_request() {
        if (isset($_GET['cancel_appointment']) && isset($_GET['token'])) {
            $token = sanitize_text_field($_GET['token']);
            $this->process_cancellation_by_token($token);
        }
    }

    /**
     * Traiter l'annulation avec un token
     */
    public function process_cancellation_by_token($token) {
        global $wpdb;
        $table = $wpdb->prefix . 'spiritual_appointments';

        // Récupérer le RDV
        $appointment = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE cancellation_token = %s AND status != 'cancelled'",
            $token
        ));

        if (!$appointment) {
            wp_die(__('Token d\'annulation invalide ou rendez-vous déjà annulé.', 'sangmelima'));
        }

        // Vérifier si le RDV peut être annulé (au moins 24h avant)
        $appointment_time = strtotime($appointment->date_time);
        $current_time = current_time('timestamp');
        $hours_before = ($appointment_time - $current_time) / 3600;

        if ($hours_before < 24) {
            wp_die(__('Les rendez-vous ne peuvent être annulés que 24 heures avant l\'heure prévue.', 'sangmelima'));
        }

        // Afficher la page de confirmation
        if (!isset($_POST['confirm_cancellation'])) {
            $this->show_cancellation_form($appointment);
            exit;
        }

        // Traiter l'annulation confirmée
        $reason = sanitize_textarea_field($_POST['cancellation_reason'] ?? '');

        $result = $wpdb->update(
            $table,
            [
                'status' => 'cancelled',
                'cancelled_at' => current_time('mysql'),
                'cancellation_reason' => $reason
            ],
            ['id' => $appointment->id]
        );

        if ($result !== false) {
            // Envoyer les emails de notification
            $this->send_cancellation_emails($appointment, $reason);

            // Afficher la confirmation
            $this->show_cancellation_success();
        } else {
            wp_die(__('Erreur lors de l\'annulation du rendez-vous.', 'sangmelima'));
        }
    }

    /**
     * Afficher le formulaire d'annulation
     */
    private function show_cancellation_form($appointment) {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta charset="<?php bloginfo('charset'); ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php _e('Annulation de rendez-vous', 'sangmelima'); ?></title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    background: linear-gradient(135deg, #FFF8F0 0%, #FFFFFF 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .container {
                    max-width: 500px;
                    background: white;
                    border-radius: 12px;
                    padding: 40px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #8B4513;
                    margin-bottom: 30px;
                    text-align: center;
                }
                .appointment-info {
                    background: #F9F9F9;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 30px;
                }
                .info-item {
                    margin-bottom: 10px;
                    display: flex;
                    justify-content: space-between;
                }
                .info-label {
                    font-weight: 600;
                    color: #666;
                }
                .warning {
                    background: #FFF3CD;
                    border-left: 4px solid #FFC107;
                    padding: 15px;
                    margin-bottom: 30px;
                    border-radius: 4px;
                }
                .warning strong {
                    color: #856404;
                }
                form {
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                }
                label {
                    font-weight: 600;
                    color: #333;
                }
                textarea {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #DDD;
                    border-radius: 5px;
                    resize: vertical;
                    font-family: inherit;
                }
                .buttons {
                    display: flex;
                    gap: 10px;
                    margin-top: 20px;
                }
                button {
                    flex: 1;
                    padding: 12px 24px;
                    border: none;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }
                .btn-cancel {
                    background: #DC3545;
                    color: white;
                }
                .btn-cancel:hover {
                    background: #C82333;
                }
                .btn-back {
                    background: #6C757D;
                    color: white;
                }
                .btn-back:hover {
                    background: #5A6268;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1><?php _e('Annuler votre rendez-vous', 'sangmelima'); ?></h1>

                <div class="appointment-info">
                    <div class="info-item">
                        <span class="info-label"><?php _e('Date', 'sangmelima'); ?>:</span>
                        <span><?php echo date_i18n('j F Y', strtotime($appointment->date_time)); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><?php _e('Heure', 'sangmelima'); ?>:</span>
                        <span><?php echo date_i18n('H:i', strtotime($appointment->date_time)); ?></span>
                    </div>
                    <?php if ($appointment->priest_name) : ?>
                    <div class="info-item">
                        <span class="info-label"><?php _e('Avec', 'sangmelima'); ?>:</span>
                        <span><?php echo esc_html($appointment->priest_name); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="warning">
                    <strong><?php _e('Attention', 'sangmelima'); ?>:</strong>
                    <?php _e('Cette action est irréversible. Une fois annulé, vous devrez prendre un nouveau rendez-vous si vous souhaitez être accompagné.', 'sangmelima'); ?>
                </div>

                <form method="post">
                    <?php wp_nonce_field('cancel_appointment', 'cancel_nonce'); ?>

                    <label for="cancellation_reason">
                        <?php _e('Raison de l\'annulation (optionnel)', 'sangmelima'); ?>:
                    </label>
                    <textarea
                        name="cancellation_reason"
                        id="cancellation_reason"
                        rows="4"
                        placeholder="<?php _e('Nous aimerions comprendre pourquoi vous annulez...', 'sangmelima'); ?>"
                    ></textarea>

                    <div class="buttons">
                        <button type="button" class="btn-back" onclick="history.back()">
                            <?php _e('Garder le rendez-vous', 'sangmelima'); ?>
                        </button>
                        <button type="submit" name="confirm_cancellation" class="btn-cancel">
                            <?php _e('Confirmer l\'annulation', 'sangmelima'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </body>
        </html>
        <?php
    }

    /**
     * Afficher la confirmation d'annulation
     */
    private function show_cancellation_success() {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta charset="<?php bloginfo('charset'); ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php _e('Rendez-vous annulé', 'sangmelima'); ?></title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    background: linear-gradient(135deg, #FFF8F0 0%, #FFFFFF 100%);
                    min-height: 100vh;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 20px;
                }
                .container {
                    max-width: 500px;
                    background: white;
                    border-radius: 12px;
                    padding: 40px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                    text-align: center;
                }
                .success-icon {
                    width: 80px;
                    height: 80px;
                    background: #28A745;
                    border-radius: 50%;
                    margin: 0 auto 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 40px;
                    color: white;
                }
                h1 {
                    color: #333;
                    margin-bottom: 20px;
                }
                p {
                    color: #666;
                    line-height: 1.6;
                    margin-bottom: 30px;
                }
                .btn-home {
                    display: inline-block;
                    padding: 12px 30px;
                    background: #8B4513;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: all 0.3s ease;
                }
                .btn-home:hover {
                    background: #6B3410;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="success-icon">✓</div>
                <h1><?php _e('Rendez-vous annulé', 'sangmelima'); ?></h1>
                <p>
                    <?php _e('Votre rendez-vous a été annulé avec succès. Un email de confirmation vous a été envoyé.', 'sangmelima'); ?>
                </p>
                <p>
                    <?php _e('N\'hésitez pas à reprendre rendez-vous quand vous le souhaiterez. Nous restons à votre disposition pour vous accompagner.', 'sangmelima'); ?>
                </p>
                <a href="<?php echo home_url(); ?>" class="btn-home">
                    <?php _e('Retour à l\'accueil', 'sangmelima'); ?>
                </a>
            </div>
        </body>
        </html>
        <?php
        exit;
    }

    /**
     * Envoyer les emails d'annulation
     */
    private function send_cancellation_emails($appointment, $reason) {
        // Email à l'utilisateur
        $user = get_user_by('id', $appointment->user_id);
        if ($user) {
            $subject = __('Confirmation d\'annulation de votre rendez-vous', 'sangmelima');
            $message = sprintf(
                __("Bonjour %s,\n\nVotre rendez-vous du %s à %s a été annulé.\n\n%s\n\nN'hésitez pas à reprendre rendez-vous quand vous le souhaiterez.\n\nCordialement,\nL'équipe SangMeLima", 'sangmelima'),
                $user->display_name,
                date_i18n('j F Y', strtotime($appointment->date_time)),
                date_i18n('H:i', strtotime($appointment->date_time)),
                $reason ? __('Raison fournie : ', 'sangmelima') . $reason : ''
            );

            wp_mail($user->user_email, $subject, $message);
        }

        // Email à l'administrateur
        $admin_email = get_option('admin_email');
        $admin_subject = __('Annulation de rendez-vous', 'sangmelima');
        $admin_message = sprintf(
            __("Un rendez-vous a été annulé.\n\nUtilisateur : %s\nDate : %s\nHeure : %s\nRaison : %s\n\nCordialement,\nSystème SangMeLima", 'sangmelima'),
            $user ? $user->display_name : 'Unknown',
            date_i18n('j F Y', strtotime($appointment->date_time)),
            date_i18n('H:i', strtotime($appointment->date_time)),
            $reason ?: __('Non spécifiée', 'sangmelima')
        );

        wp_mail($admin_email, $admin_subject, $admin_message);
    }

    /**
     * Annulation via AJAX depuis le compte utilisateur
     */
    public function ajax_cancel_appointment() {
        check_ajax_referer('sangmelima_nonce', 'nonce');

        if (!is_user_logged_in()) {
            wp_send_json_error(__('Vous devez être connecté.', 'sangmelima'));
        }

        $appointment_id = intval($_POST['appointment_id']);
        $reason = sanitize_textarea_field($_POST['reason'] ?? '');
        $user_id = get_current_user_id();

        global $wpdb;
        $table = $wpdb->prefix . 'spiritual_appointments';

        // Vérifier que le RDV appartient à l'utilisateur
        $appointment = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$table} WHERE id = %d AND user_id = %d AND status != 'cancelled'",
            $appointment_id,
            $user_id
        ));

        if (!$appointment) {
            wp_send_json_error(__('Rendez-vous introuvable.', 'sangmelima'));
        }

        // Vérifier le délai de 24h
        $appointment_time = strtotime($appointment->date_time);
        $current_time = current_time('timestamp');
        $hours_before = ($appointment_time - $current_time) / 3600;

        if ($hours_before < 24) {
            wp_send_json_error(__('Les rendez-vous ne peuvent être annulés que 24 heures avant.', 'sangmelima'));
        }

        // Annuler le RDV
        $result = $wpdb->update(
            $table,
            [
                'status' => 'cancelled',
                'cancelled_at' => current_time('mysql'),
                'cancellation_reason' => $reason
            ],
            ['id' => $appointment_id]
        );

        if ($result !== false) {
            $this->send_cancellation_emails($appointment, $reason);
            wp_send_json_success(__('Rendez-vous annulé avec succès.', 'sangmelima'));
        }

        wp_send_json_error(__('Erreur lors de l\'annulation.', 'sangmelima'));
    }

    /**
     * Shortcode pour afficher les RDV de l'utilisateur avec option d'annulation
     */
    public function cancellation_page($atts) {
        if (!is_user_logged_in()) {
            return '<p>' . __('Vous devez être connecté pour voir vos rendez-vous.', 'sangmelima') . '</p>';
        }

        global $wpdb;
        $table = $wpdb->prefix . 'spiritual_appointments';
        $user_id = get_current_user_id();

        $appointments = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$table}
             WHERE user_id = %d
             AND status != 'cancelled'
             AND date_time > NOW()
             ORDER BY date_time ASC",
            $user_id
        ));

        ob_start();
        ?>
        <div class="my-appointments">
            <h2><?php _e('Mes rendez-vous à venir', 'sangmelima'); ?></h2>

            <?php if (empty($appointments)) : ?>
                <p><?php _e('Vous n\'avez aucun rendez-vous à venir.', 'sangmelima'); ?></p>
            <?php else : ?>
                <div class="appointments-list">
                    <?php foreach ($appointments as $apt) :
                        $can_cancel = (strtotime($apt->date_time) - current_time('timestamp')) > 86400; // 24h
                    ?>
                        <div class="appointment-item">
                            <div class="appointment-info">
                                <strong><?php echo date_i18n('j F Y à H:i', strtotime($apt->date_time)); ?></strong>
                                <?php if ($apt->priest_name) : ?>
                                    <p><?php _e('Avec', 'sangmelima'); ?> <?php echo esc_html($apt->priest_name); ?></p>
                                <?php endif; ?>
                                <p class="status">
                                    <?php _e('Statut :', 'sangmelima'); ?>
                                    <?php echo $apt->status === 'confirmed' ? __('Confirmé', 'sangmelima') : __('En attente', 'sangmelima'); ?>
                                </p>
                            </div>
                            <?php if ($can_cancel) : ?>
                                <button class="btn-cancel-apt" data-id="<?php echo $apt->id; ?>">
                                    <?php _e('Annuler', 'sangmelima'); ?>
                                </button>
                            <?php else : ?>
                                <p class="cannot-cancel">
                                    <?php _e('Annulation impossible (moins de 24h)', 'sangmelima'); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <script>
        jQuery(document).ready(function($) {
            $('.btn-cancel-apt').on('click', function() {
                var aptId = $(this).data('id');
                if (confirm('<?php _e("Êtes-vous sûr de vouloir annuler ce rendez-vous ?", "sangmelima"); ?>')) {
                    var reason = prompt('<?php _e("Raison de l\'annulation (optionnel) :", "sangmelima"); ?>');

                    $.ajax({
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                        type: 'POST',
                        data: {
                            action: 'cancel_appointment',
                            appointment_id: aptId,
                            reason: reason,
                            nonce: '<?php echo wp_create_nonce("sangmelima_nonce"); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.data);
                                location.reload();
                            } else {
                                alert(response.data);
                            }
                        }
                    });
                }
            });
        });
        </script>

        <style>
        .my-appointments {
            padding: 20px;
        }
        .appointments-list {
            margin-top: 20px;
        }
        .appointment-item {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .appointment-info strong {
            color: #8B4513;
            display: block;
            margin-bottom: 10px;
        }
        .status {
            font-size: 14px;
            color: #666;
        }
        .btn-cancel-apt {
            padding: 8px 20px;
            background: #DC3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-cancel-apt:hover {
            background: #C82333;
        }
        .cannot-cancel {
            color: #999;
            font-size: 13px;
            font-style: italic;
        }
        </style>
        <?php
        return ob_get_clean();
    }
}

// Initialiser la classe
new SangMeLima_Appointment_Cancellation();
<?php
/**
 * CSV Export Functionality
 * @package SangMeLima
 */

// Sécurité
if (!defined('ABSPATH')) {
    exit;
}

class SangMeLima_CSV_Export {

    public function __construct() {
        add_action('admin_menu', [$this, 'add_export_page']);
        add_action('admin_init', [$this, 'handle_export']);
    }

    /**
     * Ajouter la page d'export au menu admin
     */
    public function add_export_page() {
        add_submenu_page(
            'edit.php?post_type=priere',
            __('Export CSV', 'sangmelima'),
            __('Export CSV', 'sangmelima'),
            'manage_options',
            'sangmelima-export',
            [$this, 'render_export_page']
        );
    }

    /**
     * Afficher la page d'export
     */
    public function render_export_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Export des données en CSV', 'sangmelima'); ?></h1>

            <div class="card">
                <h2><?php _e('Sélectionnez les données à exporter', 'sangmelima'); ?></h2>

                <form method="post" action="">
                    <?php wp_nonce_field('sangmelima_export_csv', 'export_nonce'); ?>

                    <table class="form-table">
                        <tr>
                            <th scope="row"><?php _e('Type de données', 'sangmelima'); ?></th>
                            <td>
                                <select name="export_type" id="export_type" required>
                                    <option value=""><?php _e('-- Sélectionner --', 'sangmelima'); ?></option>
                                    <option value="users"><?php _e('Utilisateurs', 'sangmelima'); ?></option>
                                    <option value="appointments"><?php _e('Rendez-vous spirituels', 'sangmelima'); ?></option>
                                    <option value="donations"><?php _e('Dons', 'sangmelima'); ?></option>
                                    <option value="prayer_groups"><?php _e('Groupes de prière', 'sangmelima'); ?></option>
                                    <option value="prayer_intentions"><?php _e('Intentions de prière', 'sangmelima'); ?></option>
                                    <option value="neuvaines"><?php _e('Neuvaines', 'sangmelima'); ?></option>
                                    <option value="prayers"><?php _e('Prières', 'sangmelima'); ?></option>
                                    <option value="saints"><?php _e('Saints', 'sangmelima'); ?></option>
                                    <option value="magistere"><?php _e('Magistère', 'sangmelima'); ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php _e('Période', 'sangmelima'); ?></th>
                            <td>
                                <label>
                                    <?php _e('Du', 'sangmelima'); ?>:
                                    <input type="date" name="date_from" id="date_from">
                                </label>
                                <label style="margin-left: 20px;">
                                    <?php _e('Au', 'sangmelima'); ?>:
                                    <input type="date" name="date_to" id="date_to">
                                </label>
                                <p class="description">
                                    <?php _e('Laisser vide pour exporter toutes les données', 'sangmelima'); ?>
                                </p>
                            </td>
                        </tr>

                        <tr id="status_filter" style="display:none;">
                            <th scope="row"><?php _e('Statut', 'sangmelima'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="status[]" value="pending" checked>
                                    <?php _e('En attente', 'sangmelima'); ?>
                                </label><br>
                                <label>
                                    <input type="checkbox" name="status[]" value="confirmed" checked>
                                    <?php _e('Confirmé', 'sangmelima'); ?>
                                </label><br>
                                <label>
                                    <input type="checkbox" name="status[]" value="cancelled">
                                    <?php _e('Annulé', 'sangmelima'); ?>
                                </label><br>
                                <label>
                                    <input type="checkbox" name="status[]" value="completed" checked>
                                    <?php _e('Terminé', 'sangmelima'); ?>
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php _e('Options', 'sangmelima'); ?></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="include_headers" value="1" checked>
                                    <?php _e('Inclure les en-têtes de colonnes', 'sangmelima'); ?>
                                </label><br>
                                <label>
                                    <input type="checkbox" name="anonymize" value="1">
                                    <?php _e('Anonymiser les données personnelles', 'sangmelima'); ?>
                                </label>
                            </td>
                        </tr>
                    </table>

                    <p class="submit">
                        <button type="submit" name="export_csv" class="button button-primary">
                            <?php _e('Exporter en CSV', 'sangmelima'); ?>
                        </button>
                    </p>
                </form>
            </div>

            <div class="card" style="margin-top: 20px;">
                <h2><?php _e('Exports récents', 'sangmelima'); ?></h2>
                <p><?php _e('Derniers exports réalisés :', 'sangmelima'); ?></p>
                <?php $this->show_recent_exports(); ?>
            </div>
        </div>

        <script>
        jQuery(document).ready(function($) {
            $('#export_type').on('change', function() {
                var type = $(this).val();
                if (type === 'appointments' || type === 'donations') {
                    $('#status_filter').show();
                } else {
                    $('#status_filter').hide();
                }
            });
        });
        </script>
        <?php
    }

    /**
     * Gérer l'export CSV
     */
    public function handle_export() {
        if (!isset($_POST['export_csv']) || !isset($_POST['export_nonce'])) {
            return;
        }

        if (!wp_verify_nonce($_POST['export_nonce'], 'sangmelima_export_csv')) {
            wp_die(__('Erreur de sécurité', 'sangmelima'));
        }

        if (!current_user_can('manage_options')) {
            wp_die(__('Permissions insuffisantes', 'sangmelima'));
        }

        $export_type = sanitize_text_field($_POST['export_type']);
        $date_from = sanitize_text_field($_POST['date_from'] ?? '');
        $date_to = sanitize_text_field($_POST['date_to'] ?? '');
        $include_headers = isset($_POST['include_headers']);
        $anonymize = isset($_POST['anonymize']);
        $status = $_POST['status'] ?? [];

        // Sauvegarder l'export dans l'historique
        $this->save_export_history($export_type);

        // Générer le CSV selon le type
        switch ($export_type) {
            case 'users':
                $this->export_users($date_from, $date_to, $include_headers, $anonymize);
                break;
            case 'appointments':
                $this->export_appointments($date_from, $date_to, $status, $include_headers, $anonymize);
                break;
            case 'donations':
                $this->export_donations($date_from, $date_to, $status, $include_headers, $anonymize);
                break;
            case 'prayer_groups':
                $this->export_prayer_groups($include_headers);
                break;
            case 'prayer_intentions':
                $this->export_prayer_intentions($date_from, $date_to, $include_headers, $anonymize);
                break;
            case 'neuvaines':
                $this->export_neuvaines($include_headers);
                break;
            case 'prayers':
                $this->export_prayers($include_headers);
                break;
            case 'saints':
                $this->export_saints($include_headers);
                break;
            case 'magistere':
                $this->export_magistere($include_headers);
                break;
        }
    }

    /**
     * Export des utilisateurs
     */
    private function export_users($date_from, $date_to, $include_headers, $anonymize) {
        $args = ['orderby' => 'registered', 'order' => 'DESC'];

        if ($date_from && $date_to) {
            $args['date_query'] = [
                'after' => $date_from,
                'before' => $date_to,
                'inclusive' => true
            ];
        }

        $users = get_users($args);

        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // BOM pour Excel
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        if ($include_headers) {
            fputcsv($output, [
                'ID',
                $anonymize ? 'Identifiant' : 'Nom',
                $anonymize ? 'Email anonymisé' : 'Email',
                'Date d\'inscription',
                'Rôle',
                'Nombre de RDV',
                'Total des dons'
            ]);
        }

        foreach ($users as $user) {
            $appointment_count = $this->get_user_appointment_count($user->ID);
            $donation_total = $this->get_user_donation_total($user->ID);

            fputcsv($output, [
                $user->ID,
                $anonymize ? 'User_' . $user->ID : $user->display_name,
                $anonymize ? $this->anonymize_email($user->user_email) : $user->user_email,
                date_i18n('Y-m-d H:i', strtotime($user->user_registered)),
                implode(', ', $user->roles),
                $appointment_count,
                number_format($donation_total, 2, ',', ' ') . ' €'
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Export des rendez-vous
     */
    private function export_appointments($date_from, $date_to, $status, $include_headers, $anonymize) {
        global $wpdb;
        $table = $wpdb->prefix . 'spiritual_appointments';

        $where = [];
        if ($date_from && $date_to) {
            $where[] = $wpdb->prepare("date_time BETWEEN %s AND %s", $date_from, $date_to . ' 23:59:59');
        }
        if (!empty($status)) {
            $status_list = "'" . implode("','", array_map('esc_sql', $status)) . "'";
            $where[] = "status IN ($status_list)";
        }

        $where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $appointments = $wpdb->get_results("
            SELECT a.*, u.display_name, u.user_email
            FROM $table a
            LEFT JOIN {$wpdb->users} u ON a.user_id = u.ID
            $where_clause
            ORDER BY a.date_time DESC
        ");

        $filename = 'appointments_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        if ($include_headers) {
            fputcsv($output, [
                'ID RDV',
                $anonymize ? 'Participant' : 'Nom',
                $anonymize ? 'Contact' : 'Email',
                'Date et heure',
                'Durée (min)',
                'Statut',
                'Paiement',
                'Montant (€)',
                'Notes'
            ]);
        }

        foreach ($appointments as $apt) {
            fputcsv($output, [
                $apt->id,
                $anonymize ? 'User_' . $apt->user_id : $apt->display_name,
                $anonymize ? $this->anonymize_email($apt->user_email) : $apt->user_email,
                date_i18n('Y-m-d H:i', strtotime($apt->date_time)),
                $apt->duration,
                $this->translate_status($apt->status),
                $this->translate_payment_status($apt->payment_status),
                number_format($apt->amount, 2, ',', ' '),
                $apt->notes
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Export des dons
     */
    private function export_donations($date_from, $date_to, $status, $include_headers, $anonymize) {
        global $wpdb;
        $table = $wpdb->prefix . 'donations';

        $where = [];
        if ($date_from && $date_to) {
            $where[] = $wpdb->prepare("created_at BETWEEN %s AND %s", $date_from, $date_to . ' 23:59:59');
        }
        if (!empty($status)) {
            $status_list = "'" . implode("','", array_map('esc_sql', $status)) . "'";
            $where[] = "status IN ($status_list)";
        }

        $where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $donations = $wpdb->get_results("
            SELECT d.*, u.display_name, u.user_email
            FROM $table d
            LEFT JOIN {$wpdb->users} u ON d.user_id = u.ID
            $where_clause
            ORDER BY d.created_at DESC
        ");

        $filename = 'donations_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        if ($include_headers) {
            fputcsv($output, [
                'ID Don',
                $anonymize ? 'Donateur' : 'Nom',
                $anonymize ? 'Contact' : 'Email',
                'Montant (€)',
                'Type',
                'Méthode paiement',
                'Date',
                'Statut',
                'Reçu fiscal'
            ]);
        }

        foreach ($donations as $donation) {
            fputcsv($output, [
                $donation->id,
                $anonymize ? 'Donor_' . $donation->user_id : $donation->display_name,
                $anonymize ? $this->anonymize_email($donation->user_email) : $donation->user_email,
                number_format($donation->amount, 2, ',', ' '),
                $donation->type ?? 'Unique',
                $donation->payment_method ?? 'N/A',
                date_i18n('Y-m-d H:i', strtotime($donation->created_at)),
                $this->translate_status($donation->status),
                $donation->receipt_sent ? 'Oui' : 'Non'
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Export des prières (CPT)
     */
    private function export_prayers($include_headers) {
        $prayers = get_posts([
            'post_type' => 'priere',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
        ]);

        $filename = 'prayers_' . date('Y-m-d_H-i-s') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        if ($include_headers) {
            fputcsv($output, [
                'ID',
                'Titre',
                'Catégorie',
                'Auteur',
                'Date création',
                'Participants',
                'Durée (min)',
                'Statut'
            ]);
        }

        foreach ($prayers as $prayer) {
            $categories = wp_get_post_terms($prayer->ID, 'categorie_priere');
            $cat_names = wp_list_pluck($categories, 'name');

            fputcsv($output, [
                $prayer->ID,
                $prayer->post_title,
                implode(', ', $cat_names),
                get_the_author_meta('display_name', $prayer->post_author),
                date_i18n('Y-m-d H:i', strtotime($prayer->post_date)),
                get_post_meta($prayer->ID, '_prayer_participants', true) ?: 0,
                get_post_meta($prayer->ID, '_prayer_duration', true) ?: 'N/A',
                $prayer->post_status
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Utilitaires
     */
    private function anonymize_email($email) {
        $parts = explode('@', $email);
        $name = substr($parts[0], 0, 2) . '***';
        $domain = isset($parts[1]) ? '@' . substr($parts[1], 0, 3) . '***' : '';
        return $name . $domain;
    }

    private function translate_status($status) {
        $statuses = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmé',
            'cancelled' => 'Annulé',
            'completed' => 'Terminé'
        ];
        return $statuses[$status] ?? $status;
    }

    private function translate_payment_status($status) {
        $statuses = [
            'unpaid' => 'Non payé',
            'paid' => 'Payé',
            'refunded' => 'Remboursé'
        ];
        return $statuses[$status] ?? $status;
    }

    private function get_user_appointment_count($user_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'spiritual_appointments';
        return $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE user_id = %d",
            $user_id
        ));
    }

    private function get_user_donation_total($user_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'donations';
        $total = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(amount) FROM $table WHERE user_id = %d AND status = 'completed'",
            $user_id
        ));
        return $total ?: 0;
    }

    private function save_export_history($type) {
        $history = get_option('sangmelima_export_history', []);
        $history[] = [
            'type' => $type,
            'user' => wp_get_current_user()->display_name,
            'date' => current_time('mysql')
        ];
        // Garder seulement les 10 derniers
        $history = array_slice($history, -10);
        update_option('sangmelima_export_history', $history);
    }

    private function show_recent_exports() {
        $history = get_option('sangmelima_export_history', []);
        if (empty($history)) {
            echo '<p>' . __('Aucun export récent', 'sangmelima') . '</p>';
            return;
        }

        echo '<ul>';
        foreach (array_reverse($history) as $export) {
            echo '<li>';
            echo sprintf(
                __('%s - Exporté par %s le %s', 'sangmelima'),
                ucfirst($export['type']),
                $export['user'],
                date_i18n('d/m/Y à H:i', strtotime($export['date']))
            );
            echo '</li>';
        }
        echo '</ul>';
    }
}

// Initialiser la classe
new SangMeLima_CSV_Export();
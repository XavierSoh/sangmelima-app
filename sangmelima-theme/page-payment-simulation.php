<?php
/**
 * Template Name: Simulation Paiement
 * @package SangMeLima
 */

get_header();

// Récupérer les paramètres
$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 20;
$type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'donation';
$reference = isset($_GET['ref']) ? sanitize_text_field($_GET['ref']) : uniqid('PAY-');
$method = isset($_GET['method']) ? sanitize_text_field($_GET['method']) : 'stripe';
?>

<main id="main-content" class="site-main payment-simulation">
    <div class="container">
        <div class="payment-wrapper">
            <div class="card payment-card">
                <div class="payment-header">
                    <h1><?php _e('Paiement sécurisé', 'sangmelima'); ?></h1>
                    <p class="payment-method-label">
                        <?php
                        switch($method) {
                            case 'paypal':
                                echo 'PayPal';
                                break;
                            case 'orange_money':
                                echo 'Orange Money Cameroun';
                                break;
                            default:
                                echo 'Carte bancaire (Stripe)';
                        }
                        ?>
                    </p>
                </div>

                <div class="payment-amount">
                    <span class="amount-label"><?php _e('Montant à payer', 'sangmelima'); ?></span>
                    <span class="amount-value"><?php echo number_format($amount, 2, ',', ' '); ?> €</span>
                </div>

                <div class="payment-details">
                    <p><strong><?php _e('Référence', 'sangmelima'); ?>:</strong> <?php echo esc_html($reference); ?></p>
                    <p><strong><?php _e('Type', 'sangmelima'); ?>:</strong>
                        <?php
                        switch($type) {
                            case 'rdv':
                                _e('Rendez-vous spirituel', 'sangmelima');
                                break;
                            case 'mass':
                                _e('Offrande de messe', 'sangmelima');
                                break;
                            default:
                                _e('Don', 'sangmelima');
                        }
                        ?>
                    </p>
                </div>

                <!-- Simulation selon la méthode -->
                <?php if ($method === 'stripe') : ?>
                    <!-- Simulation Stripe -->
                    <form id="payment-form-simulation" class="payment-form">
                        <div class="form-group">
                            <label><?php _e('Numéro de carte', 'sangmelima'); ?></label>
                            <input type="text" placeholder="4242 4242 4242 4242" maxlength="19" class="card-number">
                            <small><?php _e('Utilisez 4242 4242 4242 4242 pour tester', 'sangmelima'); ?></small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><?php _e('Date d\'expiration', 'sangmelima'); ?></label>
                                <input type="text" placeholder="MM/AA" maxlength="5" class="card-expiry">
                            </div>
                            <div class="form-group">
                                <label><?php _e('CVC', 'sangmelima'); ?></label>
                                <input type="text" placeholder="123" maxlength="3" class="card-cvc">
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?php _e('Nom sur la carte', 'sangmelima'); ?></label>
                            <input type="text" placeholder="<?php _e('Jean Dupont', 'sangmelima'); ?>" class="card-name">
                        </div>

                        <div class="form-group">
                            <label><?php _e('Email', 'sangmelima'); ?></label>
                            <input type="email" placeholder="email@exemple.com" class="card-email" required>
                        </div>

                <?php elseif ($method === 'paypal') : ?>
                    <!-- Simulation PayPal -->
                    <form id="payment-form-simulation" class="payment-form">
                        <div class="paypal-simulation">
                            <img src="<?php echo SANGMELIMA_URI; ?>/assets/images/paypal-logo.png" alt="PayPal" style="max-width: 150px; margin: 20px auto; display: block;">

                            <div class="form-group">
                                <label><?php _e('Email PayPal', 'sangmelima'); ?></label>
                                <input type="email" placeholder="email@exemple.com" class="paypal-email" required>
                            </div>

                            <div class="form-group">
                                <label><?php _e('Mot de passe', 'sangmelima'); ?></label>
                                <input type="password" placeholder="••••••••" class="paypal-password">
                                <small><?php _e('Simulation - entrez n\'importe quel mot de passe', 'sangmelima'); ?></small>
                            </div>
                        </div>

                <?php elseif ($method === 'orange_money') : ?>
                    <!-- Simulation Orange Money -->
                    <form id="payment-form-simulation" class="payment-form">
                        <div class="orange-money-simulation">
                            <div class="om-logo" style="text-align: center; margin: 20px 0;">
                                <div style="background: #FF6600; color: white; padding: 10px 20px; display: inline-block; border-radius: 8px;">
                                    Orange Money
                                </div>
                            </div>

                            <div class="form-group">
                                <label><?php _e('Numéro de téléphone', 'sangmelima'); ?></label>
                                <input type="tel" placeholder="+237 6XX XXX XXX" class="om-phone" required>
                                <small><?php _e('Format Cameroun : +237 6XX XXX XXX', 'sangmelima'); ?></small>
                            </div>

                            <div class="form-group">
                                <label><?php _e('Code PIN', 'sangmelima'); ?></label>
                                <input type="password" placeholder="••••" maxlength="4" class="om-pin">
                                <small><?php _e('Simulation - entrez 4 chiffres', 'sangmelima'); ?></small>
                            </div>
                        </div>
                <?php endif; ?>

                        <div class="payment-actions">
                            <button type="submit" class="btn btn-primary btn-large" id="pay-button">
                                <span class="button-text"><?php _e('Payer', 'sangmelima'); ?> <?php echo number_format($amount, 2, ',', ' '); ?> €</span>
                                <span class="button-loader" style="display:none;">⏳ <?php _e('Traitement...', 'sangmelima'); ?></span>
                            </button>

                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <?php _e('Annuler', 'sangmelima'); ?>
                            </a>
                        </div>

                        <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <input type="hidden" name="reference" value="<?php echo $reference; ?>">
                        <input type="hidden" name="method" value="<?php echo $method; ?>">
                    </form>

                <div class="security-badges">
                    <p><?php _e('🔒 Paiement sécurisé - Mode simulation', 'sangmelima'); ?></p>
                    <p><small><?php _e('Aucune transaction réelle ne sera effectuée', 'sangmelima'); ?></small></p>
                </div>
            </div>

            <!-- Message de succès (caché par défaut) -->
            <div id="payment-success" class="card success-card" style="display:none;">
                <div class="success-icon">✅</div>
                <h2><?php _e('Paiement confirmé !', 'sangmelima'); ?></h2>
                <p><?php _e('Votre paiement a été traité avec succès.', 'sangmelima'); ?></p>

                <div class="success-details">
                    <p><strong><?php _e('Référence', 'sangmelima'); ?>:</strong> <span id="success-ref"></span></p>
                    <p><strong><?php _e('Montant', 'sangmelima'); ?>:</strong> <span id="success-amount"></span></p>
                    <p><strong><?php _e('Date', 'sangmelima'); ?>:</strong> <?php echo date_i18n('j F Y à H:i'); ?></p>
                </div>

                <div class="success-actions">
                    <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                        <?php _e('Retour à l\'accueil', 'sangmelima'); ?>
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary">
                        <?php _e('Imprimer le reçu', 'sangmelima'); ?>
                    </button>
                </div>

                <p class="confirmation-email">
                    <?php _e('Un email de confirmation vous a été envoyé.', 'sangmelima'); ?>
                </p>
            </div>
        </div>
    </div>
</main>

<style>
.payment-simulation {
    padding: 60px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.payment-wrapper {
    max-width: 500px;
    margin: 0 auto;
}

.payment-card {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
}

.payment-header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #E5E5E5;
}

.payment-header h1 {
    margin-bottom: 10px;
}

.payment-method-label {
    color: var(--text-light);
    font-size: 1.1rem;
}

.payment-amount {
    background: var(--bg-light);
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    margin-bottom: 20px;
}

.amount-label {
    display: block;
    color: var(--text-light);
    margin-bottom: 10px;
}

.amount-value {
    font-size: 2.5rem;
    font-weight: bold;
    color: var(--primary-color);
}

.payment-details {
    margin-bottom: 30px;
    padding: 15px;
    background: #F9F9F9;
    border-radius: 8px;
}

.payment-details p {
    margin-bottom: 5px;
}

.payment-form .form-group {
    margin-bottom: 20px;
}

.payment-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: var(--text-dark);
}

.payment-form input {
    width: 100%;
    padding: 12px;
    border: 1px solid #DDD;
    border-radius: 4px;
    font-size: 1rem;
}

.payment-form input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 15px;
}

.payment-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 30px;
}

.btn-large {
    padding: 15px 30px;
    font-size: 1.1rem;
    text-align: center;
}

.security-badges {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #E5E5E5;
    color: var(--text-light);
}

/* Message de succès */
.success-card {
    text-align: center;
    padding: 40px;
}

.success-icon {
    font-size: 4rem;
    margin-bottom: 20px;
}

.success-card h2 {
    color: #4CAF50;
    margin-bottom: 15px;
}

.success-details {
    background: var(--bg-light);
    padding: 20px;
    border-radius: 8px;
    margin: 30px 0;
    text-align: left;
}

.success-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin: 30px 0;
}

.confirmation-email {
    color: var(--text-light);
    font-style: italic;
}

/* Animation de chargement */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.button-loader {
    animation: pulse 1.5s infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .payment-wrapper {
        margin: 0 15px;
    }

    .amount-value {
        font-size: 2rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .success-actions {
        flex-direction: column;
    }
}

/* Styles pour l'impression */
@media print {
    .payment-simulation {
        background: white;
    }

    .btn,
    .payment-actions,
    .security-badges {
        display: none !important;
    }

    .success-card {
        box-shadow: none;
        border: 1px solid #000;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('payment-form-simulation');
    const payButton = document.getElementById('pay-button');

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Afficher le loader
            document.querySelector('.button-text').style.display = 'none';
            document.querySelector('.button-loader').style.display = 'inline';
            payButton.disabled = true;

            // Simuler le traitement du paiement
            setTimeout(() => {
                // Masquer le formulaire
                document.querySelector('.payment-card').style.display = 'none';

                // Afficher le message de succès
                const successCard = document.getElementById('payment-success');
                successCard.style.display = 'block';

                // Remplir les détails
                document.getElementById('success-ref').textContent = '<?php echo $reference; ?>';
                document.getElementById('success-amount').textContent = '<?php echo number_format($amount, 2, ',', ' '); ?> €';

                // Enregistrer dans la base de données (simulation)
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'simulate_payment',
                        amount: '<?php echo $amount; ?>',
                        type: '<?php echo $type; ?>',
                        reference: '<?php echo $reference; ?>',
                        method: '<?php echo $method; ?>',
                        status: 'success'
                    })
                });

                // Animation d'apparition
                successCard.style.opacity = '0';
                successCard.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    successCard.style.transition = 'all 0.5s ease';
                    successCard.style.opacity = '1';
                    successCard.style.transform = 'translateY(0)';
                }, 100);

            }, 2000); // Simuler 2 secondes de traitement
        });
    }

    // Formatage automatique du numéro de carte
    const cardInput = document.querySelector('.card-number');
    if (cardInput) {
        cardInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }

    // Formatage date d'expiration
    const expiryInput = document.querySelector('.card-expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });
    }

    // Validation basique
    const requiredFields = form?.querySelectorAll('[required]');
    requiredFields?.forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value) {
                this.style.borderColor = '#FF0000';
            } else {
                this.style.borderColor = '#DDD';
            }
        });
    });
});
</script>

<?php get_footer(); ?>
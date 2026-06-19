<?php
/**
 * Template Name: Page Dons
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main donations-page">
    <div class="container">
        <header class="page-header">
            <h1><?php _e('Soutenez notre mission', 'sangmelima'); ?></h1>
            <p class="page-subtitle">
                <?php _e('Votre générosité nous aide à poursuivre notre mission d\'évangélisation et d\'accompagnement spirituel.', 'sangmelima'); ?>
            </p>
        </header>

        <!-- Types de dons -->
        <section class="donation-types">
            <div class="donation-type-tabs">
                <button class="tab-btn active" data-tab="support">
                    <?php _e('Je soutiens', 'sangmelima'); ?>
                </button>
                <button class="tab-btn" data-tab="mass">
                    <?php _e('Offrande de messe', 'sangmelima'); ?>
                </button>
                <button class="tab-btn" data-tab="membership">
                    <?php _e('Adhésion', 'sangmelima'); ?>
                </button>
                <button class="tab-btn" data-tab="legacy">
                    <?php _e('Legs', 'sangmelima'); ?>
                </button>
            </div>

            <!-- Tab: Soutien général -->
            <div class="tab-content active" id="support-tab">
                <div class="card">
                    <h2><?php _e('Faire un don', 'sangmelima'); ?></h2>

                    <!-- Montants prédéfinis -->
                    <div class="amount-selector">
                        <button class="amount-btn" data-amount="10">10 €</button>
                        <button class="amount-btn" data-amount="20">20 €</button>
                        <button class="amount-btn" data-amount="30">30 €</button>
                        <button class="amount-btn" data-amount="50">50 €</button>
                        <button class="amount-btn active" data-amount="100">100 €</button>
                        <button class="amount-btn" data-amount="custom"><?php _e('Autre', 'sangmelima'); ?></button>
                    </div>

                    <div class="custom-amount-field" style="display:none;">
                        <input type="number" id="custom-amount" min="1" max="1000" placeholder="<?php _e('Montant personnalisé', 'sangmelima'); ?>">
                        <span>€</span>
                    </div>

                    <!-- Méthodes de paiement -->
                    <div class="payment-methods">
                        <h3><?php _e('Choisissez votre mode de paiement', 'sangmelima'); ?></h3>

                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="stripe" checked>
                                <div class="option-content">
                                    <img src="<?php echo SANGMELIMA_URI; ?>/assets/images/cards.png" alt="Carte bancaire">
                                    <span><?php _e('Carte bancaire', 'sangmelima'); ?></span>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="paypal">
                                <div class="option-content">
                                    <img src="<?php echo SANGMELIMA_URI; ?>/assets/images/paypal.png" alt="PayPal">
                                    <span>PayPal</span>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="orange_money">
                                <div class="option-content">
                                    <img src="<?php echo SANGMELIMA_URI; ?>/assets/images/orange-money.png" alt="Orange Money">
                                    <span>Orange Money Cameroun</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Formulaire de don -->
                    <form id="donation-form" class="donation-form">
                        <div class="form-group">
                            <label for="donor_name"><?php _e('Nom complet', 'sangmelima'); ?> *</label>
                            <input type="text" id="donor_name" name="donor_name" required>
                        </div>

                        <div class="form-group">
                            <label for="donor_email"><?php _e('Email', 'sangmelima'); ?> *</label>
                            <input type="email" id="donor_email" name="donor_email" required>
                        </div>

                        <div class="form-group">
                            <label for="donor_phone"><?php _e('Téléphone', 'sangmelima'); ?></label>
                            <input type="tel" id="donor_phone" name="donor_phone">
                        </div>

                        <div class="form-group">
                            <label for="message"><?php _e('Message (optionnel)', 'sangmelima'); ?></label>
                            <textarea id="message" name="message" rows="3"></textarea>
                        </div>

                        <div class="form-group checkbox-group">
                            <label>
                                <input type="checkbox" name="anonymous" value="1">
                                <?php _e('Don anonyme', 'sangmelima'); ?>
                            </label>
                        </div>

                        <input type="hidden" name="amount" id="donation_amount" value="100">
                        <input type="hidden" name="action" value="process_donation">
                        <input type="hidden" name="donation_type" value="support">
                        <?php wp_nonce_field('donation_nonce', 'nonce'); ?>

                        <button type="submit" class="btn btn-primary btn-large">
                            <?php _e('Faire un don de', 'sangmelima'); ?> <span class="amount-display">100</span> €
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tab: Offrande de messe -->
            <div class="tab-content" id="mass-tab" style="display:none;">
                <div class="card">
                    <h2><?php _e('Demander une messe', 'sangmelima'); ?></h2>

                    <form id="mass-offering-form" class="donation-form">
                        <div class="form-group">
                            <label for="mass_intention"><?php _e('Intention de messe', 'sangmelima'); ?> *</label>
                            <textarea id="mass_intention" name="mass_intention" rows="4" required
                                      placeholder="<?php _e('Pour qui souhaitez-vous faire célébrer cette messe ?', 'sangmelima'); ?>"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="mass_date"><?php _e('Date souhaitée', 'sangmelima'); ?></label>
                            <input type="date" id="mass_date" name="mass_date" min="<?php echo date('Y-m-d'); ?>">
                            <small><?php _e('Nous ferons notre possible pour respecter cette date', 'sangmelima'); ?></small>
                        </div>

                        <div class="amount-selector">
                            <button type="button" class="amount-btn" data-amount="15">15 €</button>
                            <button type="button" class="amount-btn active" data-amount="20">20 €</button>
                            <button type="button" class="amount-btn" data-amount="30">30 €</button>
                            <button type="button" class="amount-btn" data-amount="50">50 €</button>
                        </div>

                        <div class="form-group">
                            <label for="mass_donor_name"><?php _e('Votre nom', 'sangmelima'); ?> *</label>
                            <input type="text" id="mass_donor_name" name="donor_name" required>
                        </div>

                        <div class="form-group">
                            <label for="mass_donor_email"><?php _e('Votre email', 'sangmelima'); ?> *</label>
                            <input type="email" id="mass_donor_email" name="donor_email" required>
                        </div>

                        <input type="hidden" name="amount" id="mass_amount" value="20">
                        <input type="hidden" name="action" value="process_donation">
                        <input type="hidden" name="donation_type" value="mass_offering">
                        <?php wp_nonce_field('mass_offering_nonce', 'nonce'); ?>

                        <button type="submit" class="btn btn-primary btn-large">
                            <?php _e('Offrir', 'sangmelima'); ?> <span class="amount-display">20</span> €
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tab: Adhésion -->
            <div class="tab-content" id="membership-tab" style="display:none;">
                <div class="card">
                    <h2><?php _e('Devenir membre', 'sangmelima'); ?></h2>
                    <p><?php _e('En devenant membre, vous soutenez durablement notre mission et recevez nos actualités privilégiées.', 'sangmelima'); ?></p>

                    <div class="membership-plans">
                        <div class="plan-card">
                            <h3><?php _e('Membre bienfaiteur', 'sangmelima'); ?></h3>
                            <div class="plan-price">50 €/<?php _e('an', 'sangmelima'); ?></div>
                            <ul>
                                <li><?php _e('Newsletter mensuelle', 'sangmelima'); ?></li>
                                <li><?php _e('Accès prioritaire aux événements', 'sangmelima'); ?></li>
                                <li><?php _e('Carte de membre', 'sangmelima'); ?></li>
                            </ul>
                            <button class="btn btn-primary select-plan" data-amount="50">
                                <?php _e('Choisir', 'sangmelima'); ?>
                            </button>
                        </div>

                        <div class="plan-card featured">
                            <h3><?php _e('Membre donateur', 'sangmelima'); ?></h3>
                            <div class="plan-price">100 €/<?php _e('an', 'sangmelima'); ?></div>
                            <ul>
                                <li><?php _e('Tous les avantages bienfaiteur', 'sangmelima'); ?></li>
                                <li><?php _e('Rencontres spirituelles exclusives', 'sangmelima'); ?></li>
                                <li><?php _e('Livre de prières offert', 'sangmelima'); ?></li>
                            </ul>
                            <button class="btn btn-primary select-plan" data-amount="100">
                                <?php _e('Choisir', 'sangmelima'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab: Legs -->
            <div class="tab-content" id="legacy-tab" style="display:none;">
                <div class="card">
                    <h2><?php _e('Legs et donations', 'sangmelima'); ?></h2>
                    <p><?php _e('Un legs est un acte de générosité qui permet de transmettre tout ou partie de vos biens à notre œuvre après votre décès.', 'sangmelima'); ?></p>

                    <div class="info-section">
                        <h3><?php _e('Comment faire un legs ?', 'sangmelima'); ?></h3>
                        <ol>
                            <li><?php _e('Contactez-nous pour un entretien confidentiel', 'sangmelima'); ?></li>
                            <li><?php _e('Rédigez votre testament avec votre notaire', 'sangmelima'); ?></li>
                            <li><?php _e('Mentionnez notre association comme bénéficiaire', 'sangmelima'); ?></li>
                        </ol>

                        <p><?php _e('Pour toute information, contactez-nous en toute confidentialité :', 'sangmelima'); ?></p>
                        <div class="contact-info">
                            <p><strong><?php _e('Email', 'sangmelima'); ?>:</strong> legs@sangmelima.org</p>
                            <p><strong><?php _e('Téléphone', 'sangmelima'); ?>:</strong> +33 1 23 45 67 89</p>
                        </div>

                        <a href="<?php echo home_url('/contact'); ?>" class="btn btn-primary">
                            <?php _e('Nous contacter', 'sangmelima'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Campagnes en cours -->
        <section class="current-campaigns">
            <h2><?php _e('Campagnes en cours', 'sangmelima'); ?></h2>

            <div class="grid-2">
                <?php
                $campaigns = get_posts(array(
                    'post_type' => 'campaign',
                    'posts_per_page' => 2,
                    'meta_key' => 'is_active',
                    'meta_value' => 'true'
                ));

                if ($campaigns) :
                    foreach ($campaigns as $campaign) :
                        $goal = get_post_meta($campaign->ID, 'goal_amount', true) ?: 10000;
                        $raised = get_post_meta($campaign->ID, 'raised_amount', true) ?: 0;
                        $percentage = ($raised / $goal) * 100;
                ?>
                    <div class="card campaign-card">
                        <h3><?php echo esc_html($campaign->post_title); ?></h3>
                        <div class="campaign-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo min($percentage, 100); ?>%"></div>
                            </div>
                            <div class="campaign-stats">
                                <span><?php echo number_format($raised, 0, ',', ' '); ?> € <?php _e('collectés', 'sangmelima'); ?></span>
                                <span><?php _e('Objectif', 'sangmelima'); ?>: <?php echo number_format($goal, 0, ',', ' '); ?> €</span>
                            </div>
                        </div>
                        <p><?php echo esc_html($campaign->post_excerpt); ?></p>
                        <a href="<?php echo get_permalink($campaign->ID); ?>" class="btn btn-small">
                            <?php _e('Contribuer', 'sangmelima'); ?>
                        </a>
                    </div>
                <?php endforeach;
                else : ?>
                    <p><?php _e('Aucune campagne en cours actuellement.', 'sangmelima'); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Témoignages -->
        <section class="testimonials">
            <h2><?php _e('Ils nous soutiennent', 'sangmelima'); ?></h2>

            <div class="testimonials-slider">
                <div class="testimonial-card">
                    <blockquote>
                        <?php _e('Grâce à vos prières et votre accompagnement, j\'ai retrouvé la paix intérieure. Merci pour votre mission.', 'sangmelima'); ?>
                    </blockquote>
                    <cite>Marie D.</cite>
                </div>
            </div>
        </section>
    </div>
</main>

<style>
/* Styles pour la page de dons */
.donations-page {
    padding: 40px 0;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-subtitle {
    font-size: 1.1rem;
    color: var(--text-light);
    max-width: 600px;
    margin: 0 auto;
}

.donation-type-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 30px;
    overflow-x: auto;
    padding-bottom: 10px;
}

.tab-btn {
    padding: 10px 20px;
    background: white;
    border: 2px solid var(--primary-color);
    border-radius: 25px;
    color: var(--primary-color);
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.tab-btn.active {
    background: var(--primary-color);
    color: white;
}

.amount-selector {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 10px;
    margin: 20px 0;
}

.amount-btn {
    padding: 15px;
    background: white;
    border: 2px solid #DDD;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.1rem;
    font-weight: bold;
}

.amount-btn.active {
    background: var(--secondary-color);
    border-color: var(--secondary-color);
    color: white;
}

.custom-amount-field {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 20px 0;
}

.custom-amount-field input {
    flex: 1;
    padding: 10px;
    border: 2px solid #DDD;
    border-radius: 8px;
    font-size: 1.1rem;
}

.payment-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin: 20px 0;
}

.payment-option {
    cursor: pointer;
}

.payment-option input {
    display: none;
}

.option-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px;
    border: 2px solid #DDD;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.payment-option input:checked + .option-content {
    border-color: var(--primary-color);
    background: var(--bg-light);
}

.option-content img {
    width: 60px;
    height: 40px;
    object-fit: contain;
    margin-bottom: 10px;
}

.donation-form {
    margin-top: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #DDD;
    border-radius: 4px;
}

.form-group small {
    display: block;
    margin-top: 5px;
    color: var(--text-light);
    font-size: 0.9rem;
}

.checkbox-group label {
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-large {
    padding: 15px 30px;
    font-size: 1.1rem;
    width: 100%;
}

.membership-plans {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.plan-card {
    padding: 20px;
    border: 2px solid #DDD;
    border-radius: var(--border-radius);
    text-align: center;
}

.plan-card.featured {
    border-color: var(--secondary-color);
    position: relative;
}

.plan-card.featured::before {
    content: "Recommandé";
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--secondary-color);
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.8rem;
}

.plan-price {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-color);
    margin: 15px 0;
}

.plan-card ul {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}

.plan-card li {
    margin-bottom: 10px;
    padding-left: 20px;
    position: relative;
}

.plan-card li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: var(--secondary-color);
}

.campaign-card .progress-bar {
    height: 8px;
    background: #E5E5E5;
    border-radius: 4px;
    overflow: hidden;
    margin: 15px 0;
}

.campaign-stats {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: var(--text-light);
}

.testimonial-card {
    padding: 30px;
    background: var(--bg-light);
    border-radius: var(--border-radius);
    text-align: center;
}

.testimonial-card blockquote {
    font-size: 1.1rem;
    font-style: italic;
    margin-bottom: 15px;
}

.testimonial-card cite {
    font-weight: bold;
    color: var(--primary-color);
}

@media (max-width: 768px) {
    .donation-type-tabs {
        justify-content: flex-start;
    }

    .amount-selector {
        grid-template-columns: repeat(3, 1fr);
    }
}
</style>

<script>
// JavaScript pour la page de dons
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            tabButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            tabContents.forEach(content => {
                content.style.display = 'none';
            });

            document.getElementById(targetTab + '-tab').style.display = 'block';
        });
    });

    // Gestion des montants
    const amountButtons = document.querySelectorAll('.amount-btn');
    const customAmountField = document.querySelector('.custom-amount-field');
    const customAmountInput = document.getElementById('custom-amount');
    const donationAmountInput = document.getElementById('donation_amount');
    const amountDisplays = document.querySelectorAll('.amount-display');

    amountButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = this.dataset.amount;

            amountButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            if (amount === 'custom') {
                customAmountField.style.display = 'flex';
                customAmountInput.focus();
            } else {
                customAmountField.style.display = 'none';
                updateAmount(amount);
            }
        });
    });

    if (customAmountInput) {
        customAmountInput.addEventListener('input', function() {
            updateAmount(this.value || 0);
        });
    }

    function updateAmount(amount) {
        if (donationAmountInput) {
            donationAmountInput.value = amount;
        }
        amountDisplays.forEach(display => {
            display.textContent = amount;
        });
    }

    // Soumission du formulaire de don
    const donationForm = document.getElementById('donation-form');
    if (donationForm) {
        donationForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('[type="submit"]');
            const originalText = submitBtn.textContent;

            submitBtn.textContent = 'Traitement...';
            submitBtn.disabled = true;

            // Simulation de traitement
            setTimeout(() => {
                // Redirection vers la page de paiement selon la méthode choisie
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

                if (paymentMethod === 'stripe') {
                    // Intégration Stripe
                    console.log('Redirection vers Stripe...');
                } else if (paymentMethod === 'paypal') {
                    // Intégration PayPal
                    console.log('Redirection vers PayPal...');
                } else if (paymentMethod === 'orange_money') {
                    // Intégration Orange Money
                    console.log('Redirection vers Orange Money...');
                }

                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    }

    // Plans d'adhésion
    const selectPlanButtons = document.querySelectorAll('.select-plan');
    selectPlanButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const amount = this.dataset.amount;
            // Redirection vers le formulaire d'adhésion
            console.log('Adhésion:', amount + '€');
        });
    });
});
</script>

<?php get_footer(); ?>
<?php
/**
 * Template Name: Bréviaire
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main breviaire-page">
    <div class="container">
        <header class="page-header">
            <h1><?php _e('Bréviaire', 'sangmelima'); ?></h1>
            <p class="page-subtitle">
                <?php _e('La prière de l\'Église - Liturgie des Heures', 'sangmelima'); ?>
            </p>
        </header>

        <div class="breviaire-content">
            <!-- Prière du jour -->
            <section class="card featured-prayer">
                <div class="prayer-header">
                    <h2><?php _e('Prière de ce jour', 'sangmelima'); ?></h2>
                    <span class="date-badge"><?php echo date_i18n('l j F Y'); ?></span>
                </div>

                <?php
                // Récupérer la prière du jour
                $prayer = sangmelima_get_prayer_of_day();
                if ($prayer) : ?>
                    <div class="prayer-content">
                        <h3 class="prayer-title"><?php echo esc_html($prayer['title']); ?></h3>
                        <div class="prayer-text">
                            <?php echo wp_kses_post($prayer['content']); ?>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- Prière par défaut si aucune n'est définie -->
                    <div class="prayer-content">
                        <h3 class="prayer-title"><?php _e('Prière du matin', 'sangmelima'); ?></h3>
                        <div class="prayer-text">
                            <p>
                                <?php _e('Seigneur, en ce nouveau jour que Tu me donnes,
                                je viens à Toi pour Te confier ma journée.
                                Donne-moi Ta lumière pour éclairer mes pas,
                                Ta force pour surmonter les difficultés,
                                Ta paix pour apaiser mon cœur.', 'sangmelima'); ?>
                            </p>
                            <p>
                                <?php _e('Que toutes mes actions, mes paroles et mes pensées
                                soient orientées vers Toi et témoignent de Ton amour.
                                Par Jésus-Christ Notre Seigneur. Amen.', 'sangmelima'); ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="prayer-actions">
                    <button class="btn btn-small share-button" data-network="whatsapp" data-title="Prière du jour">
                        <?php _e('Partager', 'sangmelima'); ?>
                    </button>
                    <button class="btn btn-small btn-secondary" onclick="window.print()">
                        <?php _e('Imprimer', 'sangmelima'); ?>
                    </button>
                </div>
            </section>

            <!-- Offices du jour -->
            <section class="offices-section">
                <h2><?php _e('Offices du jour', 'sangmelima'); ?></h2>

                <div class="offices-grid">
                    <!-- Laudes -->
                    <div class="card office-card">
                        <div class="office-header">
                            <span class="office-icon">🌅</span>
                            <h3><?php _e('Laudes', 'sangmelima'); ?></h3>
                            <span class="office-time"><?php _e('6h00', 'sangmelima'); ?></span>
                        </div>
                        <p><?php _e('Prière du matin - Louange au Seigneur qui se lève', 'sangmelima'); ?></p>
                        <a href="https://www.aelf.org/<?php echo date('Y-m-d'); ?>/laudes"
                           target="_blank" class="btn btn-small">
                            <?php _e('Prier les Laudes', 'sangmelima'); ?> →
                        </a>
                    </div>

                    <!-- Tierce -->
                    <div class="card office-card">
                        <div class="office-header">
                            <span class="office-icon">☀️</span>
                            <h3><?php _e('Tierce', 'sangmelima'); ?></h3>
                            <span class="office-time"><?php _e('9h00', 'sangmelima'); ?></span>
                        </div>
                        <p><?php _e('Prière de la troisième heure - L\'Esprit Saint descend', 'sangmelima'); ?></p>
                        <a href="https://www.aelf.org/<?php echo date('Y-m-d'); ?>/tierce"
                           target="_blank" class="btn btn-small">
                            <?php _e('Prier Tierce', 'sangmelima'); ?> →
                        </a>
                    </div>

                    <!-- Sexte -->
                    <div class="card office-card">
                        <div class="office-header">
                            <span class="office-icon">🕐</span>
                            <h3><?php _e('Sexte', 'sangmelima'); ?></h3>
                            <span class="office-time"><?php _e('12h00', 'sangmelima'); ?></span>
                        </div>
                        <p><?php _e('Prière de midi - Au cœur du jour', 'sangmelima'); ?></p>
                        <a href="https://www.aelf.org/<?php echo date('Y-m-d'); ?>/sexte"
                           target="_blank" class="btn btn-small">
                            <?php _e('Prier Sexte', 'sangmelima'); ?> →
                        </a>
                    </div>

                    <!-- None -->
                    <div class="card office-card">
                        <div class="office-header">
                            <span class="office-icon">🌤️</span>
                            <h3><?php _e('None', 'sangmelima'); ?></h3>
                            <span class="office-time"><?php _e('15h00', 'sangmelima'); ?></span>
                        </div>
                        <p><?php _e('Prière de la neuvième heure - L\'heure de la mort du Christ', 'sangmelima'); ?></p>
                        <a href="https://www.aelf.org/<?php echo date('Y-m-d'); ?>/none"
                           target="_blank" class="btn btn-small">
                            <?php _e('Prier None', 'sangmelima'); ?> →
                        </a>
                    </div>

                    <!-- Vêpres -->
                    <div class="card office-card">
                        <div class="office-header">
                            <span class="office-icon">🌆</span>
                            <h3><?php _e('Vêpres', 'sangmelima'); ?></h3>
                            <span class="office-time"><?php _e('18h00', 'sangmelima'); ?></span>
                        </div>
                        <p><?php _e('Prière du soir - Action de grâce pour la journée', 'sangmelima'); ?></p>
                        <a href="https://www.aelf.org/<?php echo date('Y-m-d'); ?>/vepres"
                           target="_blank" class="btn btn-small">
                            <?php _e('Prier les Vêpres', 'sangmelima'); ?> →
                        </a>
                    </div>

                    <!-- Complies -->
                    <div class="card office-card">
                        <div class="office-header">
                            <span class="office-icon">🌙</span>
                            <h3><?php _e('Complies', 'sangmelima'); ?></h3>
                            <span class="office-time"><?php _e('21h00', 'sangmelima'); ?></span>
                        </div>
                        <p><?php _e('Prière avant le repos - Confiance en Dieu pour la nuit', 'sangmelima'); ?></p>
                        <a href="https://www.aelf.org/<?php echo date('Y-m-d'); ?>/complies"
                           target="_blank" class="btn btn-small">
                            <?php _e('Prier les Complies', 'sangmelima'); ?> →
                        </a>
                    </div>
                </div>
            </section>

            <!-- Guide du Bréviaire -->
            <section class="card guide-section">
                <h2><?php _e('Guide du Bréviaire', 'sangmelima'); ?></h2>

                <div class="guide-intro">
                    <p>
                        <?php _e('Le Bréviaire, ou Liturgie des Heures, est la prière quotidienne de l\'Église.
                        Elle sanctifie les différents moments de la journée et unit tous les chrétiens dans une même prière.', 'sangmelima'); ?>
                    </p>
                </div>

                <div class="guide-content">
                    <h3><?php _e('Structure de chaque office', 'sangmelima'); ?></h3>
                    <ol>
                        <li><strong><?php _e('Ouverture', 'sangmelima'); ?>:</strong> <?php _e('Dieu, viens à mon aide...', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Hymne', 'sangmelima'); ?>:</strong> <?php _e('Chant d\'entrée dans la prière', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Psaumes', 'sangmelima'); ?>:</strong> <?php _e('Prière avec les psaumes', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Lecture', 'sangmelima'); ?>:</strong> <?php _e('Parole de Dieu', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Répons', 'sangmelima'); ?>:</strong> <?php _e('Réponse à la Parole', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Cantique', 'sangmelima'); ?>:</strong> <?php _e('Magnificat, Benedictus ou Nunc dimittis', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Intercessions', 'sangmelima'); ?>:</strong> <?php _e('Prières universelles', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Notre Père', 'sangmelima'); ?>:</strong> <?php _e('Prière du Seigneur', 'sangmelima'); ?></li>
                        <li><strong><?php _e('Oraison', 'sangmelima'); ?>:</strong> <?php _e('Prière conclusive', 'sangmelima'); ?></li>
                    </ol>

                    <h3><?php _e('Comment commencer ?', 'sangmelima'); ?></h3>
                    <ul>
                        <li><?php _e('Commencez par un office : Laudes (matin) ou Vêpres (soir)', 'sangmelima'); ?></li>
                        <li><?php _e('Prenez 15-20 minutes dans le calme', 'sangmelima'); ?></li>
                        <li><?php _e('Priez lentement, en méditant les textes', 'sangmelima'); ?></li>
                        <li><?php _e('Unissez-vous à la prière de toute l\'Église', 'sangmelima'); ?></li>
                    </ul>
                </div>

                <div class="guide-footer">
                    <a href="https://www.aelf.org/page/les-heures" target="_blank" class="btn btn-primary">
                        <?php _e('En savoir plus sur la Liturgie des Heures', 'sangmelima'); ?> →
                    </a>
                </div>
            </section>

            <!-- Ressources supplémentaires -->
            <section class="resources-section">
                <h2><?php _e('Ressources', 'sangmelima'); ?></h2>

                <div class="resources-grid">
                    <a href="https://www.aelf.org" target="_blank" class="resource-card">
                        <span class="resource-icon">📚</span>
                        <h4><?php _e('AELF', 'sangmelima'); ?></h4>
                        <p><?php _e('Textes liturgiques officiels', 'sangmelima'); ?></p>
                    </a>

                    <a href="https://hozana.org/prieres/breviaire" target="_blank" class="resource-card">
                        <span class="resource-icon">🙏</span>
                        <h4><?php _e('Communautés', 'sangmelima'); ?></h4>
                        <p><?php _e('Prier avec d\'autres chrétiens', 'sangmelima'); ?></p>
                    </a>

                    <a href="#" class="resource-card download-link">
                        <span class="resource-icon">📱</span>
                        <h4><?php _e('Application', 'sangmelima'); ?></h4>
                        <p><?php _e('Télécharger pour prier hors ligne', 'sangmelima'); ?></p>
                    </a>
                </div>
            </section>
        </div>
    </div>
</main>

<style>
/* Styles spécifiques pour la page Bréviaire */
.breviaire-page {
    padding: 40px 0;
}

.featured-prayer {
    background: linear-gradient(135deg, var(--bg-light) 0%, white 100%);
    border-left: 4px solid var(--secondary-color);
}

.prayer-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.date-badge {
    background: var(--secondary-color);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
}

.prayer-title {
    color: var(--primary-color);
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.prayer-text {
    line-height: 1.8;
    font-size: 1.05rem;
    color: var(--text-dark);
}

.prayer-text p {
    margin-bottom: 15px;
}

.prayer-actions {
    margin-top: 20px;
    display: flex;
    gap: 10px;
}

/* Offices */
.offices-section {
    margin: 40px 0;
}

.offices-section h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
}

.offices-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.office-card {
    position: relative;
    transition: transform 0.3s ease;
}

.office-card:hover {
    transform: translateY(-5px);
}

.office-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.office-icon {
    font-size: 2rem;
}

.office-header h3 {
    flex: 1;
    margin: 0;
    color: var(--primary-color);
}

.office-time {
    background: var(--bg-light);
    padding: 2px 10px;
    border-radius: 12px;
    font-size: 0.9rem;
    color: var(--text-light);
}

.office-card p {
    color: var(--text-light);
    margin-bottom: 15px;
    font-size: 0.95rem;
}

/* Guide */
.guide-section {
    background: var(--bg-light);
}

.guide-intro {
    padding: 20px;
    background: white;
    border-radius: 8px;
    margin-bottom: 20px;
}

.guide-content h3 {
    color: var(--primary-color);
    margin: 25px 0 15px;
}

.guide-content ol,
.guide-content ul {
    padding-left: 25px;
}

.guide-content li {
    margin-bottom: 10px;
    line-height: 1.6;
}

.guide-footer {
    margin-top: 30px;
    text-align: center;
}

/* Ressources */
.resources-section {
    margin-top: 40px;
}

.resources-section h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
}

.resources-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.resource-card {
    display: block;
    padding: 20px;
    background: white;
    border: 2px solid var(--bg-light);
    border-radius: 12px;
    text-align: center;
    text-decoration: none;
    color: var(--text-dark);
    transition: all 0.3s ease;
}

.resource-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.resource-icon {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 10px;
}

.resource-card h4 {
    color: var(--primary-color);
    margin-bottom: 5px;
}

.resource-card p {
    font-size: 0.9rem;
    color: var(--text-light);
}

/* Responsive */
@media (max-width: 768px) {
    .offices-grid {
        grid-template-columns: 1fr;
    }

    .prayer-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .resources-grid {
        grid-template-columns: 1fr;
    }
}

/* Print styles */
@media print {
    .prayer-actions,
    .offices-section,
    .resources-section,
    .site-header,
    .site-footer {
        display: none;
    }

    .featured-prayer {
        border: 1px solid #000;
        box-shadow: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Highlight office actuel selon l'heure
    const now = new Date();
    const hours = now.getHours();

    let currentOffice = '';
    if (hours >= 5 && hours < 9) currentOffice = 'Laudes';
    else if (hours >= 9 && hours < 12) currentOffice = 'Tierce';
    else if (hours >= 12 && hours < 15) currentOffice = 'Sexte';
    else if (hours >= 15 && hours < 18) currentOffice = 'None';
    else if (hours >= 18 && hours < 21) currentOffice = 'Vêpres';
    else currentOffice = 'Complies';

    // Marquer l'office actuel
    document.querySelectorAll('.office-card h3').forEach(h3 => {
        if (h3.textContent.includes(currentOffice)) {
            h3.parentElement.parentElement.style.borderLeft = '4px solid var(--secondary-color)';
            h3.parentElement.parentElement.style.background = 'var(--bg-light)';
        }
    });

    // Download link pour installation
    document.querySelector('.download-link')?.addEventListener('click', function(e) {
        e.preventDefault();
        if (window.PWAManager && window.PWAManager.requestInstall) {
            window.PWAManager.requestInstall();
        } else {
            alert('Cette application est déjà installée ou votre navigateur ne supporte pas l\'installation.');
        }
    });
});
</script>

<?php get_footer(); ?>
<?php
/**
 * Template Name: Parole et Vie
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main parole-vie-page">
    <div class="container">
        <header class="page-header">
            <h1><?php _e('Parole et Vie', 'sangmelima'); ?></h1>
            <p class="page-subtitle">
                <?php _e('Méditations et accompagnement spirituel pour traverser les épreuves de la vie', 'sangmelima'); ?>
            </p>
        </header>

        <!-- Catégories d'épreuves -->
        <section class="epreuves-categories">
            <div class="categories-grid">
                <a href="#deuil" class="category-card">
                    <span class="category-icon">🕊️</span>
                    <h3><?php _e('Deuil et séparation', 'sangmelima'); ?></h3>
                    <p><?php _e('Trouver la paix dans la perte', 'sangmelima'); ?></p>
                </a>

                <a href="#maladie" class="category-card">
                    <span class="category-icon">🏥</span>
                    <h3><?php _e('Maladie et souffrance', 'sangmelima'); ?></h3>
                    <p><?php _e('Force et espérance dans l\'épreuve', 'sangmelima'); ?></p>
                </a>

                <a href="#famille" class="category-card">
                    <span class="category-icon">👨‍👩‍👧‍👦</span>
                    <h3><?php _e('Difficultés familiales', 'sangmelima'); ?></h3>
                    <p><?php _e('Réconciliation et pardon', 'sangmelima'); ?></p>
                </a>

                <a href="#travail" class="category-card">
                    <span class="category-icon">💼</span>
                    <h3><?php _e('Épreuves professionnelles', 'sangmelima'); ?></h3>
                    <p><?php _e('Confiance et persévérance', 'sangmelima'); ?></p>
                </a>

                <a href="#solitude" class="category-card">
                    <span class="category-icon">🌙</span>
                    <h3><?php _e('Solitude et isolement', 'sangmelima'); ?></h3>
                    <p><?php _e('Présence de Dieu dans la solitude', 'sangmelima'); ?></p>
                </a>

                <a href="#angoisse" class="category-card">
                    <span class="category-icon">💭</span>
                    <h3><?php _e('Angoisse et dépression', 'sangmelima'); ?></h3>
                    <p><?php _e('Lumière dans les ténèbres', 'sangmelima'); ?></p>
                </a>

                <a href="#discernement" class="category-card">
                    <span class="category-icon">🛤️</span>
                    <h3><?php _e('Choix et discernement', 'sangmelima'); ?></h3>
                    <p><?php _e('Écouter la voix de Dieu', 'sangmelima'); ?></p>
                </a>

                <a href="#pardon" class="category-card">
                    <span class="category-icon">🤝</span>
                    <h3><?php _e('Pardon et réconciliation', 'sangmelima'); ?></h3>
                    <p><?php _e('Guérir les blessures', 'sangmelima'); ?></p>
                </a>
            </div>
        </section>

        <!-- Méditation du jour -->
        <section class="card meditation-jour">
            <h2><?php _e('Méditation du jour', 'sangmelima'); ?></h2>
            <?php
            // Récupérer une méditation aléatoire ou du jour
            $meditation = array(
                'title' => __('La confiance au cœur de l\'épreuve', 'sangmelima'),
                'content' => __('Même si je marche dans un ravin d\'ombre et de mort, je ne crains aucun mal, car Tu es avec moi (Psaume 23). Dans nos moments les plus sombres, rappelons-nous que nous ne sommes jamais seuls. Le Seigneur marche à nos côtés, Il connaît nos souffrances et partage nos peines. Sa présence est notre force, Son amour notre consolation.', 'sangmelima'),
                'prayer' => __('Seigneur, dans cette épreuve qui me bouleverse, je m\'abandonne à Toi. Donne-moi la force de tenir, la foi pour espérer, et la paix qui vient de Toi seul. Amen.', 'sangmelima'),
                'reference' => 'Ps 23, 4'
            );
            ?>

            <div class="meditation-content">
                <h3><?php echo esc_html($meditation['title']); ?></h3>
                <div class="meditation-text">
                    <p><?php echo esc_html($meditation['content']); ?></p>
                </div>
                <div class="meditation-prayer">
                    <h4><?php _e('Prions', 'sangmelima'); ?></h4>
                    <p><?php echo esc_html($meditation['prayer']); ?></p>
                </div>
                <div class="meditation-reference">
                    <span><?php echo esc_html($meditation['reference']); ?></span>
                </div>
            </div>
        </section>

        <!-- Section Deuil -->
        <section id="deuil" class="epreuve-section">
            <h2><?php _e('Deuil et séparation', 'sangmelima'); ?></h2>

            <div class="epreuve-content">
                <div class="card parole-card">
                    <h3><?php _e('Parole de consolation', 'sangmelima'); ?></h3>
                    <blockquote>
                        "<?php _e('Heureux les affligés, car ils seront consolés.', 'sangmelima'); ?>"
                        <cite>Mt 5, 4</cite>
                    </blockquote>
                </div>

                <div class="card meditation-card">
                    <h3><?php _e('Méditation', 'sangmelima'); ?></h3>
                    <p>
                        <?php _e('La mort n\'est pas la fin, mais un passage vers la vie éternelle. Ceux que nous aimons ne sont pas partis, ils nous ont simplement précédés dans la maison du Père. Leur amour continue de vivre en nous, et nous les retrouverons dans la joie éternelle.', 'sangmelima'); ?>
                    </p>
                    <p>
                        <?php _e('Dans la douleur de la séparation, laissons le Christ nous consoler. Lui qui a pleuré la mort de Lazare comprend notre peine. Lui qui a vaincu la mort nous donne l\'espérance de la résurrection.', 'sangmelima'); ?>
                    </p>
                </div>

                <div class="card priere-card">
                    <h3><?php _e('Prière dans le deuil', 'sangmelima'); ?></h3>
                    <div class="priere-text">
                        <p><?php _e('Seigneur Jésus, Toi qui as pleuré ton ami Lazare,', 'sangmelima'); ?></p>
                        <p><?php _e('Accueille ma peine et mes larmes.', 'sangmelima'); ?></p>
                        <p><?php _e('Console mon cœur brisé par cette séparation.', 'sangmelima'); ?></p>
                        <p><?php _e('Donne-moi la force de continuer à vivre,', 'sangmelima'); ?></p>
                        <p><?php _e('Et l\'espérance de retrouver ceux que j\'aime', 'sangmelima'); ?></p>
                        <p><?php _e('Dans Ta lumière éternelle. Amen.', 'sangmelima'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Maladie -->
        <section id="maladie" class="epreuve-section">
            <h2><?php _e('Maladie et souffrance', 'sangmelima'); ?></h2>

            <div class="epreuve-content">
                <div class="card parole-card">
                    <h3><?php _e('Parole de force', 'sangmelima'); ?></h3>
                    <blockquote>
                        "<?php _e('Ma grâce te suffit, car ma puissance s\'accomplit dans la faiblesse.', 'sangmelima'); ?>"
                        <cite>2 Co 12, 9</cite>
                    </blockquote>
                </div>

                <div class="card meditation-card">
                    <h3><?php _e('Méditation', 'sangmelima'); ?></h3>
                    <p>
                        <?php _e('Dans la maladie, notre corps nous rappelle sa fragilité, mais notre âme peut s\'élever vers Dieu. Cette épreuve devient une occasion de nous rapprocher du Christ souffrant, de comprendre Sa passion et d\'unir nos souffrances aux Siennes pour le salut du monde.', 'sangmelima'); ?>
                    </p>
                </div>

                <div class="card priere-card">
                    <h3><?php _e('Prière du malade', 'sangmelima'); ?></h3>
                    <div class="priere-text">
                        <p><?php _e('Seigneur, je te confie mon corps souffrant.', 'sangmelima'); ?></p>
                        <p><?php _e('Donne-moi la patience dans cette épreuve,', 'sangmelima'); ?></p>
                        <p><?php _e('La force de supporter la douleur,', 'sangmelima'); ?></p>
                        <p><?php _e('Et la paix du cœur.', 'sangmelima'); ?></p>
                        <p><?php _e('Que Ta volonté soit faite, et si c\'est Ta volonté,', 'sangmelima'); ?></p>
                        <p><?php _e('Accorde-moi la guérison. Amen.', 'sangmelima'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Témoignages -->
        <section class="temoignages-section">
            <h2><?php _e('Témoignages de foi', 'sangmelima'); ?></h2>

            <div class="temoignages-grid">
                <div class="card temoignage-card">
                    <blockquote>
                        <?php _e('"Après la perte de mon époux, j\'ai trouvé dans la prière la force de continuer. La communauté m\'a portée, et petit à petit, la paix est revenue dans mon cœur."', 'sangmelima'); ?>
                    </blockquote>
                    <cite>Marie, 62 ans</cite>
                </div>

                <div class="card temoignage-card">
                    <blockquote>
                        <?php _e('"Face au cancer, j\'ai découvert que ma foi était mon plus grand remède. Non pas qu\'elle guérisse mon corps, mais elle apaise mon âme et me donne courage."', 'sangmelima'); ?>
                    </blockquote>
                    <cite>Paul, 45 ans</cite>
                </div>

                <div class="card temoignage-card">
                    <blockquote>
                        <?php _e('"Dans ma dépression, les psaumes sont devenus mes compagnons. Ils exprimaient ma détresse mieux que mes propres mots et m\'ont guidé vers la lumière."', 'sangmelima'); ?>
                    </blockquote>
                    <cite>Sophie, 28 ans</cite>
                </div>
            </div>
        </section>

        <!-- Ressources d'aide -->
        <section class="card ressources-aide">
            <h2><?php _e('Besoin d\'accompagnement ?', 'sangmelima'); ?></h2>

            <div class="aide-options">
                <div class="aide-item">
                    <span class="aide-icon">💬</span>
                    <h3><?php _e('Accompagnement spirituel', 'sangmelima'); ?></h3>
                    <p><?php _e('Réservez un rendez-vous pour un accompagnement personnalisé.', 'sangmelima'); ?></p>
                    <a href="<?php echo home_url('/rendez-vous-spirituels'); ?>" class="btn btn-primary">
                        <?php _e('Prendre rendez-vous', 'sangmelima'); ?>
                    </a>
                </div>

                <div class="aide-item">
                    <span class="aide-icon">👥</span>
                    <h3><?php _e('Groupes de soutien', 'sangmelima'); ?></h3>
                    <p><?php _e('Rejoignez un groupe de prière et de partage.', 'sangmelima'); ?></p>
                    <a href="<?php echo home_url('/groupes-priere'); ?>" class="btn btn-secondary">
                        <?php _e('Voir les groupes', 'sangmelima'); ?>
                    </a>
                </div>

                <div class="aide-item">
                    <span class="aide-icon">📞</span>
                    <h3><?php _e('Ligne d\'écoute', 'sangmelima'); ?></h3>
                    <p><?php _e('Un prêtre à votre écoute du lundi au samedi.', 'sangmelima'); ?></p>
                    <a href="tel:+33123456789" class="btn btn-outline">
                        <?php _e('Appeler', 'sangmelima'); ?>
                    </a>
                </div>
            </div>
        </section>
    </div>
</main>

<style>
/* Styles pour Parole et Vie */
.parole-vie-page {
    padding: 40px 0;
}

/* Catégories */
.epreuves-categories {
    margin: 40px 0;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.category-card {
    display: block;
    padding: 30px 20px;
    background: white;
    border-radius: 12px;
    text-align: center;
    text-decoration: none;
    color: var(--text-dark);
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.category-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: 15px;
}

.category-card h3 {
    color: var(--primary-color);
    margin-bottom: 10px;
}

.category-card p {
    color: var(--text-light);
    font-size: 0.9rem;
}

/* Méditation du jour */
.meditation-jour {
    background: linear-gradient(135deg, var(--bg-light) 0%, white 100%);
    border-left: 4px solid var(--secondary-color);
    margin: 40px 0;
}

.meditation-content h3 {
    color: var(--primary-color);
    margin-bottom: 20px;
}

.meditation-text {
    font-size: 1.05rem;
    line-height: 1.8;
    margin-bottom: 20px;
}

.meditation-prayer {
    background: white;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.meditation-prayer h4 {
    color: var(--secondary-color);
    margin-bottom: 10px;
}

.meditation-reference {
    text-align: right;
    font-style: italic;
    color: var(--text-light);
}

/* Sections épreuves */
.epreuve-section {
    margin: 60px 0;
    scroll-margin-top: 80px;
}

.epreuve-section h2 {
    color: var(--primary-color);
    margin-bottom: 30px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--secondary-color);
}

.epreuve-content {
    display: grid;
    gap: 20px;
}

.parole-card {
    background: var(--bg-light);
    border-left: 4px solid var(--primary-color);
}

.parole-card blockquote {
    font-size: 1.2rem;
    line-height: 1.6;
    color: var(--primary-color);
    margin: 0;
}

.parole-card cite {
    display: block;
    text-align: right;
    margin-top: 10px;
    color: var(--text-light);
    font-style: normal;
}

.meditation-card p {
    line-height: 1.8;
    margin-bottom: 15px;
}

.priere-card {
    background: linear-gradient(135deg, white 0%, var(--bg-light) 100%);
}

.priere-text {
    font-style: italic;
    line-height: 1.8;
    text-align: center;
}

.priere-text p {
    margin-bottom: 5px;
}

/* Témoignages */
.temoignages-section {
    margin: 60px 0;
    background: var(--bg-light);
    padding: 40px 20px;
    border-radius: 20px;
}

.temoignages-section h2 {
    text-align: center;
    color: var(--primary-color);
    margin-bottom: 30px;
}

.temoignages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.temoignage-card {
    background: white;
}

.temoignage-card blockquote {
    font-style: italic;
    line-height: 1.6;
    margin: 0;
}

.temoignage-card cite {
    display: block;
    text-align: right;
    margin-top: 15px;
    color: var(--primary-color);
    font-weight: bold;
    font-style: normal;
}

/* Ressources d'aide */
.ressources-aide {
    background: var(--primary-color);
    color: white;
    margin: 40px 0;
}

.ressources-aide h2 {
    color: white;
    text-align: center;
    margin-bottom: 30px;
}

.aide-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.aide-item {
    text-align: center;
}

.aide-icon {
    font-size: 3rem;
    display: block;
    margin-bottom: 15px;
}

.aide-item h3 {
    color: var(--secondary-color);
    margin-bottom: 10px;
}

.aide-item p {
    margin-bottom: 20px;
    opacity: 0.9;
}

.btn-outline {
    background: transparent;
    border: 2px solid white;
    color: white;
}

.btn-outline:hover {
    background: white;
    color: var(--primary-color);
}

/* Responsive */
@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .category-icon {
        font-size: 2rem;
    }

    .temoignages-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }

    .aide-options {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll vers les sections
    document.querySelectorAll('.categories-grid a').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });

    // Animation des cartes au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    entry.target.style.transition = 'all 0.5s ease';
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, 100);

                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observer toutes les cartes
    document.querySelectorAll('.card').forEach(card => {
        observer.observe(card);
    });
});
</script>

<?php get_footer(); ?>
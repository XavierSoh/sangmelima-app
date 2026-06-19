<?php
/**
 * Page d'accueil principale
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main">
    <div class="container">

        <!-- Section Héro avec message du jour -->
        <section class="hero-section card">
            <h1><?php _e('Bienvenue dans votre espace spirituel', 'sangmelima'); ?></h1>
            <p class="hero-subtitle"><?php _e('Ressources spirituelles, prières et accompagnement', 'sangmelima'); ?></p>
        </section>

        <!-- Contenus quotidiens -->
        <section class="daily-content">
            <h2 class="section-title"><?php _e('Aujourd\'hui', 'sangmelima'); ?></h2>

            <div class="grid-3">
                <!-- Lecture du jour -->
                <div class="card prayer-card" data-aelf="evangile">
                    <div class="card-header">
                        <h3><?php _e('Évangile du jour', 'sangmelima'); ?></h3>
                        <div class="date-selector">
                            <input type="date"
                                   id="aelf-date"
                                   class="aelf-date-input"
                                   value="<?php echo date('Y-m-d'); ?>"
                                   max="<?php echo date('Y-m-d', strtotime('+1 year')); ?>"
                                   min="<?php echo date('Y-m-d', strtotime('-2 years')); ?>">
                            <button class="btn-icon" id="reset-date" title="<?php _e('Aujourd\'hui', 'sangmelima'); ?>">
                                ↻
                            </button>
                        </div>
                    </div>
                    <div class="daily-content-body">
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                        <div class="skeleton skeleton-text"></div>
                    </div>
                    <div class="card-footer">
                        <a href="https://www.aelf.org/<?php echo date('Y-m-d'); ?>/messe" target="_blank" class="btn btn-small" id="aelf-link">
                            <?php _e('Voir plus sur AELF', 'sangmelima'); ?> →
                        </a>
                    </div>
                </div>

                <!-- Prière du jour -->
                <div class="card prayer-card">
                    <h3><?php _e('Prière du jour', 'sangmelima'); ?></h3>
                    <?php
                    $prayer = sangmelima_get_prayer_of_day();
                    if ($prayer) : ?>
                        <h4><?php echo esc_html($prayer['title']); ?></h4>
                        <div class="prayer-excerpt">
                            <?php echo wp_kses_post($prayer['excerpt']); ?>
                        </div>
                        <a href="#" class="btn btn-small view-prayer" data-prayer-id="<?php echo esc_attr($prayer['id']); ?>">
                            <?php _e('Lire la prière', 'sangmelima'); ?>
                        </a>
                    <?php else : ?>
                        <p><?php _e('Aucune prière disponible aujourd\'hui', 'sangmelima'); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Intention du jour -->
                <div class="card prayer-card">
                    <h3><?php _e('Intention de prière', 'sangmelima'); ?></h3>
                    <p class="intention-text">
                        <?php _e('Prions pour la paix dans le monde et pour tous ceux qui souffrent', 'sangmelima'); ?>
                    </p>
                    <button class="btn btn-small share-intention">
                        <?php _e('Partager mon intention', 'sangmelima'); ?>
                    </button>
                </div>
            </div>
        </section>

        <!-- Neuvaines actives -->
        <section class="neuvaines-section">
            <h2 class="section-title"><?php _e('Neuvaines en cours', 'sangmelima'); ?></h2>

            <div class="grid-2">
                <?php
                $neuvaines = new WP_Query(array(
                    'post_type' => 'neuvaine',
                    'posts_per_page' => 4,
                    'meta_key' => 'is_active',
                    'meta_value' => 'true'
                ));

                if ($neuvaines->have_posts()) :
                    while ($neuvaines->have_posts()) : $neuvaines->the_post(); ?>
                        <article class="card neuvaine-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('prayer-thumb'); ?>
                            <?php endif; ?>
                            <h3><?php the_title(); ?></h3>
                            <div class="neuvaine-meta">
                                <span class="day-indicator">
                                    <?php echo get_post_meta(get_the_ID(), 'current_day', true) ?: '1'; ?>/9
                                </span>
                                <span class="participants">
                                    <?php echo get_post_meta(get_the_ID(), 'participants', true) ?: '0'; ?>
                                    <?php _e('participants', 'sangmelima'); ?>
                                </span>
                            </div>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="btn">
                                <?php _e('Rejoindre la neuvaine', 'sangmelima'); ?>
                            </a>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="no-content"><?php _e('Aucune neuvaine active actuellement', 'sangmelima'); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Coups de cœur -->
        <section class="featured-section">
            <h2 class="section-title"><?php _e('Coups de cœur', 'sangmelima'); ?></h2>

            <div class="grid-3">
                <?php
                $featured = new WP_Query(array(
                    'post_type' => array('priere', 'saint', 'magistere'),
                    'posts_per_page' => 3,
                    'meta_key' => 'is_featured',
                    'meta_value' => 'true',
                    'orderby' => 'rand'
                ));

                if ($featured->have_posts()) :
                    while ($featured->have_posts()) : $featured->the_post();
                        $post_type = get_post_type(); ?>
                        <article class="card featured-card">
                            <span class="content-type"><?php echo esc_html(get_post_type_object($post_type)->labels->singular_name); ?></span>
                            <h3><?php the_title(); ?></h3>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php _e('Découvrir', 'sangmelima'); ?> →
                            </a>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </section>

        <!-- Accès rapides -->
        <section class="quick-access">
            <h2 class="section-title"><?php _e('Accès rapides', 'sangmelima'); ?></h2>

            <div class="quick-links">
                <a href="<?php echo home_url('/magistere'); ?>" class="quick-link-card">
                    <span class="icon">📖</span>
                    <span><?php _e('Magistère', 'sangmelima'); ?></span>
                </a>
                <a href="<?php echo home_url('/saints'); ?>" class="quick-link-card">
                    <span class="icon">✨</span>
                    <span><?php _e('Les Saints', 'sangmelima'); ?></span>
                </a>
                <a href="<?php echo home_url('/groupes-priere'); ?>" class="quick-link-card">
                    <span class="icon">🙏</span>
                    <span><?php _e('Groupes de prière', 'sangmelima'); ?></span>
                </a>
                <a href="<?php echo home_url('/accompagnement'); ?>" class="quick-link-card">
                    <span class="icon">💬</span>
                    <span><?php _e('Accompagnement', 'sangmelima'); ?></span>
                </a>
                <a href="<?php echo home_url('/faire-un-don'); ?>" class="quick-link-card">
                    <span class="icon">❤️</span>
                    <span><?php _e('Faire un don', 'sangmelima'); ?></span>
                </a>
                <a href="<?php echo home_url('/breviaire'); ?>" class="quick-link-card">
                    <span class="icon">📿</span>
                    <span><?php _e('Bréviaire', 'sangmelima'); ?></span>
                </a>
            </div>
        </section>

        <!-- Bannière d'installation PWA -->
        <div id="install-prompt" class="install-prompt">
            <p><?php _e('Installez notre application pour un accès rapide', 'sangmelima'); ?></p>
            <button id="install-btn" class="btn btn-secondary">
                <?php _e('Installer', 'sangmelima'); ?>
            </button>
            <button id="dismiss-btn" class="btn-link">
                <?php _e('Plus tard', 'sangmelima'); ?>
            </button>
        </div>
    </div>
</main>

<?php get_footer(); ?>
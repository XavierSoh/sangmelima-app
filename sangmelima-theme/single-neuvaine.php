<?php
/**
 * Template pour une neuvaine individuelle
 * @package SangMeLima
 */

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        $neuvaine_id = get_the_ID();
        $current_day = get_post_meta($neuvaine_id, 'current_day', true) ?: 1;
        $participants = get_post_meta($neuvaine_id, 'participants', true) ?: 0;
        $is_active = get_post_meta($neuvaine_id, 'is_active', true);
        $start_date = get_post_meta($neuvaine_id, 'start_date', true);
        $prayers = get_post_meta($neuvaine_id, 'daily_prayers', true);
?>

<main id="main-content" class="site-main neuvaine-single">
    <div class="container">
        <!-- En-tête de la neuvaine -->
        <header class="neuvaine-header">
            <?php if (has_post_thumbnail()) : ?>
                <div class="neuvaine-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <h1 class="neuvaine-title"><?php the_title(); ?></h1>

            <div class="neuvaine-meta">
                <span class="meta-item">
                    <strong><?php _e('Jour', 'sangmelima'); ?></strong>
                    <?php echo esc_html($current_day); ?>/9
                </span>
                <span class="meta-item">
                    <strong><?php _e('Participants', 'sangmelima'); ?></strong>
                    <?php echo esc_html($participants); ?>
                </span>
                <?php if ($start_date) : ?>
                    <span class="meta-item">
                        <strong><?php _e('Début', 'sangmelima'); ?></strong>
                        <?php echo date_i18n('j F Y', strtotime($start_date)); ?>
                    </span>
                <?php endif; ?>
            </div>

            <?php if ($is_active) : ?>
                <button class="btn btn-primary join-neuvaine" data-id="<?php echo $neuvaine_id; ?>">
                    <?php _e('Rejoindre cette neuvaine', 'sangmelima'); ?>
                </button>
            <?php endif; ?>
        </header>

        <!-- Description de la neuvaine -->
        <section class="neuvaine-description card">
            <h2><?php _e('À propos de cette neuvaine', 'sangmelima'); ?></h2>
            <div class="content-body">
                <?php the_content(); ?>
            </div>
        </section>

        <!-- Progression de la neuvaine -->
        <section class="neuvaine-progress card">
            <h2><?php _e('Progression', 'sangmelima'); ?></h2>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo ($current_day / 9) * 100; ?>%"></div>
            </div>
            <div class="progress-days">
                <?php for ($i = 1; $i <= 9; $i++) : ?>
                    <div class="day-indicator <?php echo $i <= $current_day ? 'completed' : ''; ?> <?php echo $i == $current_day ? 'current' : ''; ?>">
                        <span class="day-number"><?php echo $i; ?></span>
                        <span class="day-label"><?php echo sprintf(__('Jour %d', 'sangmelima'), $i); ?></span>
                    </div>
                <?php endfor; ?>
            </div>
        </section>

        <!-- Prière du jour -->
        <section class="daily-prayer card prayer-card">
            <h2><?php echo sprintf(__('Prière du jour %d', 'sangmelima'), $current_day); ?></h2>

            <?php if ($prayers && isset($prayers[$current_day])) : ?>
                <div class="prayer-content">
                    <?php echo wp_kses_post($prayers[$current_day]); ?>
                </div>
            <?php else : ?>
                <div class="prayer-content">
                    <p><?php _e('La prière de ce jour sera disponible bientôt.', 'sangmelima'); ?></p>
                </div>
            <?php endif; ?>

            <!-- Boutons d'action -->
            <div class="prayer-actions">
                <button class="btn btn-small mark-complete" data-day="<?php echo $current_day; ?>">
                    <?php _e('Marquer comme priée', 'sangmelima'); ?>
                </button>
                <button class="btn btn-small btn-secondary share-button"
                        data-network="whatsapp"
                        data-url="<?php the_permalink(); ?>"
                        data-title="<?php the_title(); ?>">
                    <?php _e('Partager', 'sangmelima'); ?>
                </button>
            </div>
        </section>

        <!-- Intentions de prière -->
        <section class="prayer-intentions card">
            <h2><?php _e('Intentions de prière', 'sangmelima'); ?></h2>

            <?php if (is_user_logged_in()) : ?>
                <form class="intention-form ajax-form" method="post">
                    <textarea name="intention" placeholder="<?php _e('Partagez votre intention...', 'sangmelima'); ?>" required></textarea>
                    <input type="hidden" name="action" value="add_prayer_intention">
                    <input type="hidden" name="neuvaine_id" value="<?php echo $neuvaine_id; ?>">
                    <?php wp_nonce_field('prayer_intention', 'intention_nonce'); ?>
                    <button type="submit" class="btn btn-small">
                        <?php _e('Ajouter mon intention', 'sangmelima'); ?>
                    </button>
                </form>
            <?php else : ?>
                <p><?php _e('Connectez-vous pour partager une intention de prière.', 'sangmelima'); ?></p>
                <a href="<?php echo wp_login_url(get_permalink()); ?>" class="btn btn-small">
                    <?php _e('Se connecter', 'sangmelima'); ?>
                </a>
            <?php endif; ?>

            <!-- Liste des intentions -->
            <div class="intentions-list">
                <?php
                $intentions = get_comments(array(
                    'post_id' => $neuvaine_id,
                    'status' => 'approve',
                    'type' => 'prayer_intention',
                    'number' => 10
                ));

                if ($intentions) :
                    foreach ($intentions as $intention) : ?>
                        <div class="intention-item">
                            <div class="intention-author">
                                <?php echo get_avatar($intention->comment_author_email, 40); ?>
                                <span><?php echo esc_html($intention->comment_author); ?></span>
                            </div>
                            <div class="intention-content">
                                <?php echo wp_kses_post($intention->comment_content); ?>
                            </div>
                            <div class="intention-meta">
                                <?php echo human_time_diff(strtotime($intention->comment_date), current_time('timestamp')) . ' ' . __('ago', 'sangmelima'); ?>
                            </div>
                        </div>
                    <?php endforeach;
                else : ?>
                    <p class="no-intentions"><?php _e('Aucune intention partagée pour le moment.', 'sangmelima'); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Neuvaines similaires -->
        <section class="related-neuvaines">
            <h2><?php _e('Autres neuvaines', 'sangmelima'); ?></h2>
            <div class="grid-3">
                <?php
                $related = new WP_Query(array(
                    'post_type' => 'neuvaine',
                    'posts_per_page' => 3,
                    'post__not_in' => array($neuvaine_id),
                    'meta_key' => 'is_active',
                    'meta_value' => 'true'
                ));

                if ($related->have_posts()) :
                    while ($related->have_posts()) : $related->the_post(); ?>
                        <article class="card neuvaine-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('prayer-thumb'); ?>
                            <?php endif; ?>
                            <h3><?php the_title(); ?></h3>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="btn btn-small">
                                <?php _e('Découvrir', 'sangmelima'); ?>
                            </a>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </section>
    </div>
</main>

<style>
/* Styles spécifiques pour la page neuvaine */
.neuvaine-header {
    text-align: center;
    margin-bottom: 40px;
}

.neuvaine-image img {
    width: 100%;
    max-width: 600px;
    height: auto;
    border-radius: var(--border-radius);
    margin-bottom: 20px;
}

.neuvaine-title {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 20px;
}

.neuvaine-meta {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.progress-bar {
    height: 10px;
    background: #E5E5E5;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 20px;
}

.progress-fill {
    height: 100%;
    background: var(--secondary-color);
    transition: width 0.5s ease;
}

.progress-days {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.day-indicator {
    text-align: center;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.day-indicator.completed {
    opacity: 1;
    color: var(--secondary-color);
}

.day-indicator.current {
    transform: scale(1.2);
    color: var(--primary-color);
    font-weight: bold;
}

.day-number {
    display: block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    background: #E5E5E5;
    border-radius: 50%;
    margin-bottom: 5px;
}

.day-indicator.completed .day-number {
    background: var(--secondary-color);
    color: white;
}

.prayer-content {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 20px;
    padding: 20px;
    background: var(--bg-light);
    border-radius: 8px;
}

.prayer-actions {
    display: flex;
    gap: 10px;
}

.intention-form {
    margin-bottom: 30px;
}

.intention-form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #DDD;
    border-radius: 4px;
    min-height: 80px;
    margin-bottom: 10px;
    resize: vertical;
}

.intention-item {
    padding: 15px;
    background: var(--bg-light);
    border-radius: 8px;
    margin-bottom: 15px;
}

.intention-author {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.intention-author img {
    border-radius: 50%;
}

.intention-meta {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-top: 10px;
}

@media (max-width: 768px) {
    .progress-days {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
}
</style>

<script>
// Script spécifique pour la neuvaine
document.addEventListener('DOMContentLoaded', function() {
    // Marquer comme priée
    const markCompleteBtn = document.querySelector('.mark-complete');
    if (markCompleteBtn) {
        markCompleteBtn.addEventListener('click', function() {
            const day = this.dataset.day;

            // Sauvegarder dans localStorage
            const neuvainProgress = JSON.parse(localStorage.getItem('neuvaine_progress') || '{}');
            neuvainProgress[<?php echo $neuvaine_id; ?>] = day;
            localStorage.setItem('neuvaine_progress', JSON.stringify(neuvainProgress));

            this.textContent = '✓ Priée';
            this.disabled = true;

            if (window.SangMeLima && window.SangMeLima.showNotification) {
                window.SangMeLima.showNotification('Prière marquée comme complétée', 'success');
            }
        });
    }
});
</script>

<?php
    endwhile;
endif;

get_footer(); ?>
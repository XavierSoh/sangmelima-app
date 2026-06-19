<?php
/**
 * Archive des Prières
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main archive-prayers">
    <div class="container">
        <header class="archive-header">
            <h1><?php _e('Toutes les prières', 'sangmelima'); ?></h1>
            <p class="archive-description">
                <?php _e('Découvrez notre collection de prières pour accompagner votre vie spirituelle', 'sangmelima'); ?>
            </p>
        </header>

        <?php
        // Récupérer les catégories de prières
        $categories = get_terms([
            'taxonomy' => 'categorie_priere',
            'hide_empty' => true,
            'orderby' => 'name',
            'order' => 'ASC'
        ]);

        if (!empty($categories) && !is_wp_error($categories)) : ?>
            <div class="prayer-filters">
                <button class="filter-btn active" data-category="all">
                    <?php _e('Toutes', 'sangmelima'); ?>
                </button>
                <?php foreach ($categories as $category) : ?>
                    <button class="filter-btn" data-category="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                        <span class="count">(<?php echo $category->count; ?>)</span>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            <div class="prayers-grid">
                <?php while (have_posts()) : the_post();
                    $categories = get_the_terms(get_the_ID(), 'categorie_priere');
                    $category_classes = '';
                    if ($categories) {
                        foreach ($categories as $cat) {
                            $category_classes .= ' category-' . $cat->slug;
                        }
                    }
                ?>
                    <article class="prayer-card<?php echo $category_classes; ?>" data-category="<?php echo $categories ? $categories[0]->slug : ''; ?>">
                        <div class="prayer-icon">🙏</div>
                        <h3>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <?php if ($categories) : ?>
                            <div class="prayer-category">
                                <?php echo esc_html($categories[0]->name); ?>
                            </div>
                        <?php endif; ?>

                        <div class="prayer-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </div>

                        <div class="prayer-meta">
                            <span class="prayer-duration">
                                <?php
                                $duration = get_post_meta(get_the_ID(), '_prayer_duration', true);
                                if ($duration) {
                                    echo sprintf(__('%s min', 'sangmelima'), $duration);
                                } else {
                                    echo __('2-3 min', 'sangmelima');
                                }
                                ?>
                            </span>
                            <?php
                            $participants = get_post_meta(get_the_ID(), '_prayer_participants', true);
                            if ($participants) : ?>
                                <span class="prayer-participants">
                                    <?php echo sprintf(__('%d priants', 'sangmelima'), $participants); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="btn-secondary btn-small">
                            <?php _e('Prier', 'sangmelima'); ?> →
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination([
                'mid_size' => 2,
                'prev_text' => '← ' . __('Précédent', 'sangmelima'),
                'next_text' => __('Suivant', 'sangmelima') . ' →',
                'screen_reader_text' => __('Navigation des prières', 'sangmelima')
            ]);
            ?>

        <?php else : ?>
            <div class="no-prayers">
                <p><?php _e('Aucune prière disponible pour le moment.', 'sangmelima'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.archive-prayers {
    padding: 40px 0 60px;
}

.archive-header {
    text-align: center;
    margin-bottom: 40px;
}

.archive-header h1 {
    color: var(--primary-color);
    margin-bottom: 10px;
}

.archive-description {
    color: #666;
    max-width: 600px;
    margin: 0 auto;
}

.prayer-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
    margin-bottom: 40px;
    padding: 20px;
    background: #F9F9F9;
    border-radius: 10px;
}

.filter-btn {
    padding: 8px 16px;
    background: white;
    border: 1px solid #E5E5E5;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.filter-btn:hover {
    border-color: var(--accent-gold);
}

.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.filter-btn .count {
    opacity: 0.7;
    font-size: 12px;
}

.prayers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.prayer-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.prayer-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.prayer-card.hidden {
    display: none;
}

.prayer-icon {
    font-size: 32px;
    margin-bottom: 15px;
}

.prayer-card h3 {
    margin-bottom: 10px;
    font-size: 18px;
}

.prayer-card h3 a {
    color: var(--primary-color);
    text-decoration: none;
}

.prayer-card h3 a:hover {
    color: var(--accent-gold);
}

.prayer-category {
    display: inline-block;
    padding: 4px 10px;
    background: var(--accent-gold);
    color: white;
    border-radius: 12px;
    font-size: 12px;
    margin-bottom: 15px;
}

.prayer-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 15px;
    flex-grow: 1;
}

.prayer-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    padding-top: 15px;
    border-top: 1px solid #F0F0F0;
    font-size: 13px;
    color: #999;
}

.btn-small {
    padding: 8px 16px;
    font-size: 14px;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 40px;
}

.pagination .page-numbers {
    padding: 8px 12px;
    background: white;
    border: 1px solid #E5E5E5;
    border-radius: 5px;
    text-decoration: none;
    color: var(--primary-color);
    transition: all 0.3s ease;
}

.pagination .page-numbers:hover,
.pagination .page-numbers.current {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.no-prayers {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

@media (max-width: 768px) {
    .prayers-grid {
        grid-template-columns: 1fr;
    }

    .prayer-filters {
        padding: 15px;
    }

    .filter-btn {
        font-size: 13px;
        padding: 6px 12px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const prayerCards = document.querySelectorAll('.prayer-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;

            // Filter cards
            prayerCards.forEach(card => {
                if (category === 'all') {
                    card.classList.remove('hidden');
                } else {
                    if (card.dataset.category === category) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                }
            });
        });
    });
});
</script>

<?php get_footer(); ?>
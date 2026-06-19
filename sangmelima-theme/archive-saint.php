<?php
/**
 * Archive des Saints
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main archive-saints">
    <div class="container">
        <header class="archive-header">
            <h1><?php _e('Les Saints', 'sangmelima'); ?></h1>
            <p class="archive-description">
                <?php _e('Découvrez la vie des saints et laissez-vous inspirer par leur exemple', 'sangmelima'); ?>
            </p>
        </header>

        <?php
        // Filtres par mois pour les fêtes
        $months = [
            1 => __('Janvier', 'sangmelima'),
            2 => __('Février', 'sangmelima'),
            3 => __('Mars', 'sangmelima'),
            4 => __('Avril', 'sangmelima'),
            5 => __('Mai', 'sangmelima'),
            6 => __('Juin', 'sangmelima'),
            7 => __('Juillet', 'sangmelima'),
            8 => __('Août', 'sangmelima'),
            9 => __('Septembre', 'sangmelima'),
            10 => __('Octobre', 'sangmelima'),
            11 => __('Novembre', 'sangmelima'),
            12 => __('Décembre', 'sangmelima')
        ];
        ?>

        <div class="saints-filters">
            <div class="filter-group">
                <label><?php _e('Rechercher un saint', 'sangmelima'); ?></label>
                <input type="text" id="saint-search" placeholder="<?php _e('Nom du saint...', 'sangmelima'); ?>">
            </div>

            <div class="filter-group">
                <label><?php _e('Fête en', 'sangmelima'); ?></label>
                <select id="month-filter">
                    <option value=""><?php _e('Tous les mois', 'sangmelima'); ?></option>
                    <?php foreach ($months as $num => $name) : ?>
                        <option value="<?php echo $num; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <?php if (have_posts()) : ?>
            <div class="saints-grid">
                <?php while (have_posts()) : the_post();
                    $feast_date = get_post_meta(get_the_ID(), '_saint_feast_date', true);
                    $birth_year = get_post_meta(get_the_ID(), '_saint_birth_year', true);
                    $death_year = get_post_meta(get_the_ID(), '_saint_death_year', true);
                    $patron_of = get_post_meta(get_the_ID(), '_saint_patron_of', true);

                    $feast_month = '';
                    if ($feast_date) {
                        $date_parts = explode('-', $feast_date);
                        $feast_month = intval($date_parts[1]);
                    }
                ?>
                    <article class="saint-card"
                             data-name="<?php echo esc_attr(strtolower(get_the_title())); ?>"
                             data-month="<?php echo esc_attr($feast_month); ?>">

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="saint-image">
                                <?php the_post_thumbnail('medium'); ?>
                            </div>
                        <?php else : ?>
                            <div class="saint-icon">✝️</div>
                        <?php endif; ?>

                        <div class="saint-content">
                            <h3>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <?php if ($feast_date) : ?>
                                <div class="saint-feast">
                                    <?php
                                    $date_formatted = date_i18n('j F', strtotime($feast_date));
                                    echo sprintf(__('Fête le %s', 'sangmelima'), $date_formatted);
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($birth_year && $death_year) : ?>
                                <div class="saint-dates">
                                    <?php echo $birth_year; ?> - <?php echo $death_year; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($patron_of) : ?>
                                <div class="saint-patronage">
                                    <strong><?php _e('Patron de', 'sangmelima'); ?> :</strong>
                                    <?php echo esc_html($patron_of); ?>
                                </div>
                            <?php endif; ?>

                            <div class="saint-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                            </div>

                            <div class="saint-actions">
                                <a href="<?php the_permalink(); ?>" class="btn-secondary btn-small">
                                    <?php _e('Découvrir', 'sangmelima'); ?> →
                                </a>
                                <button class="btn-prayer" data-saint="<?php the_title(); ?>">
                                    🙏 <?php _e('Prier', 'sangmelima'); ?>
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            // Pagination
            the_posts_pagination([
                'mid_size' => 2,
                'prev_text' => '← ' . __('Précédent', 'sangmelima'),
                'next_text' => __('Suivant', 'sangmelima') . ' →',
                'screen_reader_text' => __('Navigation des saints', 'sangmelima')
            ]);
            ?>

        <?php else : ?>
            <div class="no-saints">
                <p><?php _e('Aucun saint disponible pour le moment.', 'sangmelima'); ?></p>
            </div>
        <?php endif; ?>

        <!-- Saint du jour -->
        <div class="saint-of-day">
            <h2><?php _e('Saint du jour', 'sangmelima'); ?></h2>
            <?php
            // Récupérer le saint du jour
            $today = date('m-d');
            $saint_today_query = new WP_Query([
                'post_type' => 'saint',
                'posts_per_page' => 1,
                'meta_query' => [
                    [
                        'key' => '_saint_feast_date',
                        'value' => date('Y') . '-' . $today,
                        'compare' => '='
                    ]
                ]
            ]);

            if ($saint_today_query->have_posts()) :
                while ($saint_today_query->have_posts()) : $saint_today_query->the_post(); ?>
                    <div class="saint-highlight">
                        <h3><?php the_title(); ?></h3>
                        <div class="saint-highlight-content">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn-primary">
                            <?php _e('En savoir plus', 'sangmelima'); ?>
                        </a>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p><?php _e('Découvrez un saint chaque jour', 'sangmelima'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
.archive-saints {
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

.saints-filters {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-bottom: 40px;
    padding: 20px;
    background: #F9F9F9;
    border-radius: 10px;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-group label {
    font-size: 13px;
    color: #666;
    font-weight: 600;
}

.filter-group input,
.filter-group select {
    padding: 8px 12px;
    border: 1px solid #E5E5E5;
    border-radius: 5px;
    background: white;
    min-width: 200px;
}

.saints-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.saint-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.saint-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.saint-card.hidden {
    display: none;
}

.saint-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.saint-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.saint-icon {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, var(--accent-gold) 0%, var(--primary-color) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 60px;
}

.saint-content {
    padding: 20px;
}

.saint-content h3 {
    margin-bottom: 10px;
}

.saint-content h3 a {
    color: var(--primary-color);
    text-decoration: none;
}

.saint-content h3 a:hover {
    color: var(--accent-gold);
}

.saint-feast {
    color: var(--accent-gold);
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 5px;
}

.saint-dates {
    color: #999;
    font-size: 13px;
    margin-bottom: 10px;
}

.saint-patronage {
    font-size: 13px;
    color: #666;
    margin-bottom: 15px;
    padding: 8px;
    background: #F9F9F9;
    border-radius: 5px;
}

.saint-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.saint-actions {
    display: flex;
    gap: 10px;
}

.btn-prayer {
    padding: 8px 16px;
    background: #F9F9F9;
    border: 1px solid #E5E5E5;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-prayer:hover {
    background: var(--accent-gold);
    color: white;
    border-color: var(--accent-gold);
}

.saint-of-day {
    margin-top: 60px;
    padding: 40px;
    background: linear-gradient(135deg, #FFF8F0 0%, #FFFFFF 100%);
    border-radius: 12px;
    text-align: center;
}

.saint-of-day h2 {
    color: var(--primary-color);
    margin-bottom: 30px;
}

.saint-highlight {
    max-width: 600px;
    margin: 0 auto;
}

.saint-highlight h3 {
    color: var(--accent-gold);
    margin-bottom: 20px;
    font-size: 24px;
}

.saint-highlight-content {
    color: #666;
    line-height: 1.8;
    margin-bottom: 30px;
}

.no-saints {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

@media (max-width: 768px) {
    .saints-filters {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group input,
    .filter-group select {
        min-width: 100%;
    }

    .saints-grid {
        grid-template-columns: 1fr;
    }

    .saint-actions {
        flex-direction: column;
    }

    .saint-actions button,
    .saint-actions a {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('saint-search');
    const monthFilter = document.getElementById('month-filter');
    const saintCards = document.querySelectorAll('.saint-card');

    function filterSaints() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedMonth = monthFilter.value;

        saintCards.forEach(card => {
            const name = card.dataset.name;
            const month = card.dataset.month;

            let showCard = true;

            // Filter by search term
            if (searchTerm && !name.includes(searchTerm)) {
                showCard = false;
            }

            // Filter by month
            if (selectedMonth && month !== selectedMonth) {
                showCard = false;
            }

            if (showCard) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    }

    searchInput.addEventListener('input', filterSaints);
    monthFilter.addEventListener('change', filterSaints);

    // Prayer buttons
    document.querySelectorAll('.btn-prayer').forEach(btn => {
        btn.addEventListener('click', function() {
            const saintName = this.dataset.saint;
            alert('<?php _e("Prière à", "sangmelima"); ?> ' + saintName + ' <?php _e("ajoutée à vos prières", "sangmelima"); ?>');
            // TODO: Implement prayer functionality
        });
    });
});
</script>

<?php get_footer(); ?>
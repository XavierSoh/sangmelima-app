<?php
/**
 * Archive du Magistère
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main archive-magistere">
    <div class="container">
        <header class="archive-header">
            <h1><?php _e('Le Magistère de l\'Église', 'sangmelima'); ?></h1>
            <p class="archive-description">
                <?php _e('L\'enseignement officiel de l\'Église catholique à travers les documents du Pape, des conciles et de la tradition', 'sangmelima'); ?>
            </p>
        </header>

        <?php
        // Structure inspirée de catholicus.eu
        $categories = [
            'pape' => [
                'title' => __('Documents du Pape', 'sangmelima'),
                'icon' => '🗝️',
                'types' => ['encyclique', 'exhortation', 'motu-proprio', 'homelie', 'message']
            ],
            'concile' => [
                'title' => __('Conciles', 'sangmelima'),
                'icon' => '⛪',
                'types' => ['vatican-ii', 'trente', 'nicee']
            ],
            'congregation' => [
                'title' => __('Congrégations', 'sangmelima'),
                'icon' => '📋',
                'types' => ['doctrine-foi', 'culte-divin', 'eveques']
            ],
            'catechisme' => [
                'title' => __('Catéchisme', 'sangmelima'),
                'icon' => '📖',
                'types' => ['cec', 'compendium', 'youcat']
            ]
        ];

        // Récupérer les types de documents
        $doc_types = get_terms([
            'taxonomy' => 'type_magistere',
            'hide_empty' => true
        ]);
        ?>

        <!-- Navigation par catégories -->
        <div class="magistere-nav">
            <?php foreach ($categories as $cat_key => $category) : ?>
                <div class="nav-item" data-category="<?php echo esc_attr($cat_key); ?>">
                    <span class="nav-icon"><?php echo $category['icon']; ?></span>
                    <span class="nav-title"><?php echo $category['title']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Filtres avancés -->
        <div class="magistere-filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label><?php _e('Type de document', 'sangmelima'); ?></label>
                    <select id="type-filter">
                        <option value=""><?php _e('Tous les types', 'sangmelima'); ?></option>
                        <?php if ($doc_types && !is_wp_error($doc_types)) : ?>
                            <?php foreach ($doc_types as $type) : ?>
                                <option value="<?php echo esc_attr($type->slug); ?>">
                                    <?php echo esc_html($type->name); ?> (<?php echo $type->count; ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label><?php _e('Période', 'sangmelima'); ?></label>
                    <select id="period-filter">
                        <option value=""><?php _e('Toutes les périodes', 'sangmelima'); ?></option>
                        <option value="2020-2029"><?php _e('2020-2029', 'sangmelima'); ?></option>
                        <option value="2010-2019"><?php _e('2010-2019', 'sangmelima'); ?></option>
                        <option value="2000-2009"><?php _e('2000-2009', 'sangmelima'); ?></option>
                        <option value="1990-1999"><?php _e('1990-1999', 'sangmelima'); ?></option>
                        <option value="before-1990"><?php _e('Avant 1990', 'sangmelima'); ?></option>
                    </select>
                </div>

                <div class="filter-group">
                    <label><?php _e('Rechercher', 'sangmelima'); ?></label>
                    <input type="text" id="search-filter"
                           placeholder="<?php _e('Titre, auteur, thème...', 'sangmelima'); ?>">
                </div>
            </div>
        </div>

        <?php if (have_posts()) : ?>
            <div class="magistere-list">
                <?php while (have_posts()) : the_post();
                    $doc_type = get_the_terms(get_the_ID(), 'type_magistere');
                    $author = get_post_meta(get_the_ID(), '_magistere_author', true);
                    $date = get_post_meta(get_the_ID(), '_magistere_date', true);
                    $language = get_post_meta(get_the_ID(), '_magistere_language', true);
                    $doc_number = get_post_meta(get_the_ID(), '_magistere_number', true);
                ?>
                    <article class="magistere-item"
                             data-type="<?php echo $doc_type ? esc_attr($doc_type[0]->slug) : ''; ?>"
                             data-year="<?php echo $date ? date('Y', strtotime($date)) : ''; ?>"
                             data-search="<?php echo esc_attr(strtolower(get_the_title() . ' ' . $author)); ?>">

                        <div class="magistere-header">
                            <?php if ($doc_type) : ?>
                                <span class="doc-type">
                                    <?php echo esc_html($doc_type[0]->name); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($doc_number) : ?>
                                <span class="doc-number">
                                    <?php echo esc_html($doc_number); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($date) : ?>
                                <span class="doc-date">
                                    <?php echo date_i18n('j F Y', strtotime($date)); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <h3 class="magistere-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <?php if ($author) : ?>
                            <div class="magistere-author">
                                <?php echo esc_html($author); ?>
                            </div>
                        <?php endif; ?>

                        <div class="magistere-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 40); ?>
                        </div>

                        <div class="magistere-footer">
                            <div class="magistere-meta">
                                <?php if ($language && $language !== 'fr') : ?>
                                    <span class="meta-item">
                                        🌍 <?php echo strtoupper($language); ?>
                                    </span>
                                <?php endif; ?>

                                <?php
                                $themes = get_the_terms(get_the_ID(), 'theme_magistere');
                                if ($themes && !is_wp_error($themes)) : ?>
                                    <span class="meta-item">
                                        <?php
                                        $theme_names = wp_list_pluck($themes, 'name');
                                        echo implode(', ', array_slice($theme_names, 0, 3));
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="btn-read">
                                <?php _e('Lire', 'sangmelima'); ?> →
                            </a>
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
                'screen_reader_text' => __('Navigation du magistère', 'sangmelima')
            ]);
            ?>

        <?php else : ?>
            <div class="no-magistere">
                <p><?php _e('Aucun document disponible pour le moment.', 'sangmelima'); ?></p>
            </div>
        <?php endif; ?>

        <!-- Documents récents -->
        <div class="recent-documents">
            <h2><?php _e('Documents récents', 'sangmelima'); ?></h2>
            <?php
            $recent_query = new WP_Query([
                'post_type' => 'magistere',
                'posts_per_page' => 5,
                'orderby' => 'date',
                'order' => 'DESC'
            ]);

            if ($recent_query->have_posts()) : ?>
                <ul class="recent-list">
                    <?php while ($recent_query->have_posts()) : $recent_query->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                                <span class="date"><?php echo get_the_date(); ?></span>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</main>

<style>
.archive-magistere {
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
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

.magistere-nav {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    background: white;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 120px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.nav-item:hover,
.nav-item.active {
    background: var(--primary-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(139,69,19,0.2);
}

.nav-icon {
    font-size: 32px;
    margin-bottom: 8px;
}

.nav-title {
    font-size: 13px;
    font-weight: 600;
    text-align: center;
}

.magistere-filters {
    background: #F9F9F9;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 40px;
}

.filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.filter-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 13px;
    color: #666;
    font-weight: 600;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #E5E5E5;
    border-radius: 5px;
    background: white;
}

.magistere-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 40px;
}

.magistere-item {
    background: white;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.magistere-item:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.magistere-item.hidden {
    display: none;
}

.magistere-header {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    flex-wrap: wrap;
    align-items: center;
}

.doc-type {
    padding: 4px 10px;
    background: var(--accent-gold);
    color: white;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
}

.doc-number {
    color: #999;
    font-size: 13px;
}

.doc-date {
    color: #999;
    font-size: 13px;
    margin-left: auto;
}

.magistere-title {
    margin-bottom: 10px;
    font-size: 20px;
}

.magistere-title a {
    color: var(--primary-color);
    text-decoration: none;
}

.magistere-title a:hover {
    color: var(--accent-gold);
}

.magistere-author {
    color: #666;
    font-weight: 600;
    margin-bottom: 15px;
}

.magistere-excerpt {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.magistere-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #F0F0F0;
}

.magistere-meta {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.meta-item {
    font-size: 13px;
    color: #999;
}

.btn-read {
    padding: 8px 20px;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.btn-read:hover {
    background: var(--accent-gold);
}

.recent-documents {
    margin-top: 60px;
    padding: 30px;
    background: #F9F9F9;
    border-radius: 10px;
}

.recent-documents h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
}

.recent-list {
    list-style: none;
    padding: 0;
}

.recent-list li {
    padding: 15px 0;
    border-bottom: 1px solid #E5E5E5;
}

.recent-list li:last-child {
    border-bottom: none;
}

.recent-list a {
    display: flex;
    justify-content: space-between;
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.recent-list a:hover {
    color: var(--accent-gold);
}

.recent-list .date {
    color: #999;
    font-size: 13px;
}

.no-magistere {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

@media (max-width: 768px) {
    .magistere-nav {
        gap: 10px;
    }

    .nav-item {
        min-width: 100px;
        padding: 15px 10px;
    }

    .filter-row {
        grid-template-columns: 1fr;
    }

    .magistere-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .doc-date {
        margin-left: 0;
    }

    .magistere-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .btn-read {
        width: 100%;
        text-align: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeFilter = document.getElementById('type-filter');
    const periodFilter = document.getElementById('period-filter');
    const searchFilter = document.getElementById('search-filter');
    const navItems = document.querySelectorAll('.nav-item');
    const magistereItems = document.querySelectorAll('.magistere-item');

    function filterDocuments() {
        const selectedType = typeFilter.value;
        const selectedPeriod = periodFilter.value;
        const searchTerm = searchFilter.value.toLowerCase();

        magistereItems.forEach(item => {
            const itemType = item.dataset.type;
            const itemYear = parseInt(item.dataset.year);
            const itemSearch = item.dataset.search;

            let showItem = true;

            // Filter by type
            if (selectedType && itemType !== selectedType) {
                showItem = false;
            }

            // Filter by period
            if (selectedPeriod && itemYear) {
                if (selectedPeriod === 'before-1990' && itemYear >= 1990) {
                    showItem = false;
                } else if (selectedPeriod !== 'before-1990') {
                    const [startYear, endYear] = selectedPeriod.split('-').map(Number);
                    if (itemYear < startYear || itemYear > endYear) {
                        showItem = false;
                    }
                }
            }

            // Filter by search term
            if (searchTerm && !itemSearch.includes(searchTerm)) {
                showItem = false;
            }

            if (showItem) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    // Add event listeners
    typeFilter.addEventListener('change', filterDocuments);
    periodFilter.addEventListener('change', filterDocuments);
    searchFilter.addEventListener('input', filterDocuments);

    // Navigation items
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            navItems.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');

            // TODO: Filter by category
            const category = this.dataset.category;
            console.log('Filter by category:', category);
        });
    });
});
</script>

<?php get_footer(); ?>
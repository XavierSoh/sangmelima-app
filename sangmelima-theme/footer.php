<?php
/**
 * Footer du thème
 * @package SangMeLima
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <!-- Widgets Footer -->
            <div class="footer-widgets">
                <div class="footer-column">
                    <h3><?php _e('Ressources spirituelles', 'sangmelima'); ?></h3>
                    <ul>
                        <li><a href="<?php echo home_url('/prieres'); ?>"><?php _e('Prières', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/neuvaines'); ?>"><?php _e('Neuvaines', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/magistere'); ?>"><?php _e('Magistère', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/saints'); ?>"><?php _e('Les Saints', 'sangmelima'); ?></a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3><?php _e('Communauté', 'sangmelima'); ?></h3>
                    <ul>
                        <li><a href="<?php echo home_url('/groupes-priere'); ?>"><?php _e('Groupes de prière', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/accompagnement'); ?>"><?php _e('Accompagnement spirituel', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/temoignages'); ?>"><?php _e('Témoignages', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/evenements'); ?>"><?php _e('Événements', 'sangmelima'); ?></a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3><?php _e('Soutenir', 'sangmelima'); ?></h3>
                    <ul>
                        <li><a href="<?php echo home_url('/faire-un-don'); ?>"><?php _e('Faire un don', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/offrande-messe'); ?>"><?php _e('Offrande de messe', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/adhesion'); ?>"><?php _e('Adhésion', 'sangmelima'); ?></a></li>
                        <li><a href="<?php echo home_url('/legs'); ?>"><?php _e('Legs et donations', 'sangmelima'); ?></a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3><?php _e('Suivez-nous', 'sangmelima'); ?></h3>
                    <div class="social-links">
                        <a href="#" target="_blank" rel="noopener" aria-label="Facebook">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="YouTube">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="Instagram">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.405a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/>
                            </svg>
                        </a>
                        <a href="#" target="_blank" rel="noopener" aria-label="TikTok">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Newsletter -->
                    <div class="newsletter-signup">
                        <h4><?php _e('Newsletter', 'sangmelima'); ?></h4>
                        <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="newsletter-form">
                            <input type="email" name="email" placeholder="<?php _e('Votre email', 'sangmelima'); ?>" required>
                            <input type="hidden" name="action" value="sangmelima_newsletter">
                            <?php wp_nonce_field('sangmelima_newsletter', 'newsletter_nonce'); ?>
                            <button type="submit" class="btn btn-small">
                                <?php _e('S\'inscrire', 'sangmelima'); ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="site-info">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
                    <?php _e('Tous droits réservés.', 'sangmelima'); ?></p>
                </div>
                <div class="footer-links">
                    <a href="<?php echo home_url('/mentions-legales'); ?>"><?php _e('Mentions légales', 'sangmelima'); ?></a>
                    <a href="<?php echo home_url('/politique-confidentialite'); ?>"><?php _e('Confidentialité', 'sangmelima'); ?></a>
                    <a href="<?php echo home_url('/contact'); ?>"><?php _e('Contact', 'sangmelima'); ?></a>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<style>
/* Styles temporaires pour le footer */
.site-footer {
    background: var(--text-dark);
    color: white;
    padding: 40px 0 20px;
    margin-top: 60px;
}

.footer-widgets {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.footer-column h3 {
    color: var(--secondary-color);
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.footer-column ul {
    list-style: none;
    padding: 0;
}

.footer-column li {
    margin-bottom: 10px;
}

.footer-column a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-column a:hover {
    color: var(--secondary-color);
}

.social-links {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.social-links a {
    display: block;
    width: 40px;
    height: 40px;
    padding: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background: var(--secondary-color);
    transform: translateY(-3px);
}

.newsletter-form {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.newsletter-form input[type="email"] {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 4px;
}

.newsletter-form input[type="email"]::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.site-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    flex-wrap: wrap;
}

.footer-links {
    display: flex;
    gap: 20px;
}

.footer-links a {
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    font-size: 0.9rem;
}

.footer-links a:hover {
    color: var(--secondary-color);
}

@media (max-width: 768px) {
    .footer-widgets {
        grid-template-columns: 1fr;
    }

    .site-info {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .newsletter-form {
        flex-direction: column;
    }
}
</style>

<?php wp_footer(); ?>

</body>
</html>
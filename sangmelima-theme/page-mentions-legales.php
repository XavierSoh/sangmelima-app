<?php
/**
 * Template Name: Mentions Légales
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main legal-page">
    <div class="container">
        <header class="page-header">
            <h1><?php _e('Mentions légales', 'sangmelima'); ?></h1>
        </header>

        <div class="legal-content">
            <section class="legal-section">
                <h2><?php _e('Éditeur du site', 'sangmelima'); ?></h2>
                <p>
                    <strong><?php _e('Association', 'sangmelima'); ?> :</strong> SangMeLima Évangélisation<br>
                    <strong><?php _e('Responsable de publication', 'sangmelima'); ?> :</strong> Père Marc Bertrand<br>
                    <strong><?php _e('Email', 'sangmelima'); ?> :</strong> contact@sangmelima.org<br>
                    <strong><?php _e('Téléphone', 'sangmelima'); ?> :</strong> +33 1 23 45 67 89<br>
                    <strong><?php _e('Adresse', 'sangmelima'); ?> :</strong> [À compléter]
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Hébergement', 'sangmelima'); ?></h2>
                <p>
                    <strong><?php _e('Hébergeur', 'sangmelima'); ?> :</strong> [À compléter - OVH, Hostinger, etc.]<br>
                    <strong><?php _e('Adresse', 'sangmelima'); ?> :</strong> [Adresse de l'hébergeur]<br>
                    <strong><?php _e('Téléphone', 'sangmelima'); ?> :</strong> [Téléphone de l'hébergeur]
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Développement', 'sangmelima'); ?></h2>
                <p>
                    <strong><?php _e('Conception et réalisation', 'sangmelima'); ?> :</strong> Xavier Soh<br>
                    <strong><?php _e('Email', 'sangmelima'); ?> :</strong> sohfranc@gmail.com<br>
                    <strong><?php _e('Site web', 'sangmelima'); ?> :</strong> <a href="https://xaviersoh.com" target="_blank">xaviersoh.com</a>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Propriété intellectuelle', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('L\'ensemble de ce site relève de la législation française et internationale sur le droit d\'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.', 'sangmelima'); ?>
                </p>
                <p>
                    <?php _e('La reproduction de tout ou partie de ce site sur un support électronique ou papier est formellement interdite sauf autorisation expresse du responsable de publication.', 'sangmelima'); ?>
                </p>
                <p>
                    <?php _e('Les textes liturgiques sont issus de l\'AELF (Association Épiscopale Liturgique pour les pays Francophones) et utilisés avec autorisation.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Données personnelles', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Conformément au Règlement Général sur la Protection des Données (RGPD) et à la loi Informatique et Libertés, vous disposez d\'un droit d\'accès, de rectification, de suppression et d\'opposition aux données personnelles vous concernant.', 'sangmelima'); ?>
                </p>
                <p>
                    <?php _e('Pour exercer ces droits, vous pouvez nous contacter :', 'sangmelima'); ?><br>
                    - <?php _e('Par email', 'sangmelima'); ?> : privacy@sangmelima.org<br>
                    - <?php _e('Par courrier', 'sangmelima'); ?> : SangMeLima - Protection des données - [Adresse]
                </p>
                <p>
                    <?php _e('Pour plus d\'informations, consultez notre', 'sangmelima'); ?> <a href="<?php echo home_url('/politique-confidentialite'); ?>"><?php _e('politique de confidentialité', 'sangmelima'); ?></a>.
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Cookies', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Ce site utilise des cookies pour améliorer votre expérience de navigation. Les cookies sont de petits fichiers texte stockés sur votre appareil qui nous aident à :', 'sangmelima'); ?>
                </p>
                <ul>
                    <li><?php _e('Mémoriser vos préférences', 'sangmelima'); ?></li>
                    <li><?php _e('Analyser l\'utilisation du site', 'sangmelima'); ?></li>
                    <li><?php _e('Personnaliser votre expérience', 'sangmelima'); ?></li>
                    <li><?php _e('Assurer la sécurité du site', 'sangmelima'); ?></li>
                </ul>
                <p>
                    <?php _e('Vous pouvez configurer votre navigateur pour refuser les cookies ou être averti lorsqu\'un cookie est envoyé.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Responsabilité', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Les informations contenues sur ce site sont aussi précises que possible et le site est périodiquement remis à jour, mais peut toutefois contenir des inexactitudes, des omissions ou des lacunes.', 'sangmelima'); ?>
                </p>
                <p>
                    <?php _e('Si vous constatez une lacune, erreur ou ce qui paraît être un dysfonctionnement, merci de bien vouloir le signaler par email à contact@sangmelima.org en décrivant le problème de la manière la plus précise possible.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Liens hypertextes', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Les sites liés directement ou indirectement au site sangmelima.org ne sont pas sous son contrôle. Par conséquent, nous n\'assumons aucune responsabilité quant aux informations publiées sur ces sites.', 'sangmelima'); ?>
                </p>
                <p>
                    <?php _e('Les liens présents sur le site sangmelima.org peuvent orienter l\'utilisateur sur des sites extérieurs dont le contenu ne peut engager en aucune manière la responsabilité de SangMeLima.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Droit applicable', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Les présentes mentions légales sont régies par le droit français. En cas de litige et après échec de toute tentative de recherche d\'une solution amiable, les tribunaux français seront seuls compétents.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Crédits', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Icônes', 'sangmelima'); ?> : Emojis et symboles Unicode<br>
                    <?php _e('Framework CSS', 'sangmelima'); ?> : Custom CSS<br>
                    <?php _e('CMS', 'sangmelima'); ?> : WordPress<br>
                    <?php _e('Textes liturgiques', 'sangmelima'); ?> : AELF<br>
                    <?php _e('Technologies', 'sangmelima'); ?> : HTML5, CSS3, JavaScript, PHP, PWA
                </p>
            </section>

            <div class="legal-footer">
                <p>
                    <strong><?php _e('Dernière mise à jour', 'sangmelima'); ?> :</strong> <?php echo date_i18n('j F Y'); ?>
                </p>
            </div>
        </div>
    </div>
</main>

<style>
.legal-page {
    padding: 40px 0;
}

.legal-content {
    max-width: 800px;
    margin: 0 auto;
}

.legal-section {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #E5E5E5;
}

.legal-section:last-child {
    border-bottom: none;
}

.legal-section h2 {
    color: var(--primary-color);
    margin-bottom: 20px;
}

.legal-section p {
    line-height: 1.8;
    margin-bottom: 15px;
}

.legal-section ul {
    margin-left: 30px;
    margin-bottom: 15px;
}

.legal-section ul li {
    margin-bottom: 8px;
}

.legal-footer {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 2px solid var(--primary-color);
    text-align: center;
}
</style>

<?php get_footer(); ?>
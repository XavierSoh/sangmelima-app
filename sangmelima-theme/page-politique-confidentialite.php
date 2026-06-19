<?php
/**
 * Template Name: Politique de Confidentialité
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main legal-page">
    <div class="container">
        <header class="page-header">
            <h1><?php _e('Politique de confidentialité', 'sangmelima'); ?></h1>
            <p class="page-subtitle">
                <?php _e('Protection de vos données personnelles', 'sangmelima'); ?>
            </p>
        </header>

        <div class="legal-content">
            <section class="legal-section">
                <h2><?php _e('Introduction', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('SangMeLima Évangélisation s\'engage à protéger la vie privée de ses utilisateurs. Cette politique de confidentialité explique comment nous collectons, utilisons, stockons et protégeons vos données personnelles conformément au Règlement Général sur la Protection des Données (RGPD).', 'sangmelima'); ?>
                </p>
                <p>
                    <?php _e('En utilisant notre site et nos services, vous acceptez les pratiques décrites dans cette politique de confidentialité.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Responsable du traitement', 'sangmelima'); ?></h2>
                <p>
                    <strong><?php _e('Identité', 'sangmelima'); ?> :</strong> SangMeLima Évangélisation<br>
                    <strong><?php _e('Représentant', 'sangmelima'); ?> :</strong> Père Marc Bertrand<br>
                    <strong><?php _e('Contact DPO', 'sangmelima'); ?> :</strong> privacy@sangmelima.org<br>
                    <strong><?php _e('Adresse', 'sangmelima'); ?> :</strong> [À compléter]
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Données collectées', 'sangmelima'); ?></h2>
                <p><?php _e('Nous collectons les types de données suivants :', 'sangmelima'); ?></p>

                <h3><?php _e('1. Données d\'identification', 'sangmelima'); ?></h3>
                <ul>
                    <li><?php _e('Nom et prénom', 'sangmelima'); ?></li>
                    <li><?php _e('Adresse email', 'sangmelima'); ?></li>
                    <li><?php _e('Numéro de téléphone (optionnel)', 'sangmelima'); ?></li>
                    <li><?php _e('Adresse postale (pour les dons avec reçu fiscal)', 'sangmelima'); ?></li>
                </ul>

                <h3><?php _e('2. Données de connexion', 'sangmelima'); ?></h3>
                <ul>
                    <li><?php _e('Identifiant de connexion', 'sangmelima'); ?></li>
                    <li><?php _e('Mot de passe (crypté)', 'sangmelima'); ?></li>
                    <li><?php _e('Historique de connexion', 'sangmelima'); ?></li>
                    <li><?php _e('Adresse IP', 'sangmelima'); ?></li>
                </ul>

                <h3><?php _e('3. Données spirituelles', 'sangmelima'); ?></h3>
                <ul>
                    <li><?php _e('Intentions de prière (si partagées)', 'sangmelima'); ?></li>
                    <li><?php _e('Participation aux neuvaines', 'sangmelima'); ?></li>
                    <li><?php _e('Inscriptions aux groupes de prière', 'sangmelima'); ?></li>
                    <li><?php _e('Demandes d\'accompagnement spirituel', 'sangmelima'); ?></li>
                </ul>

                <h3><?php _e('4. Données de transaction', 'sangmelima'); ?></h3>
                <ul>
                    <li><?php _e('Montant des dons', 'sangmelima'); ?></li>
                    <li><?php _e('Date et heure des transactions', 'sangmelima'); ?></li>
                    <li><?php _e('Méthode de paiement (sans données bancaires complètes)', 'sangmelima'); ?></li>
                    <li><?php _e('Historique des dons', 'sangmelima'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('Finalités du traitement', 'sangmelima'); ?></h2>
                <p><?php _e('Vos données sont utilisées pour :', 'sangmelima'); ?></p>
                <ul>
                    <li><?php _e('Gérer votre compte utilisateur', 'sangmelima'); ?></li>
                    <li><?php _e('Vous permettre de participer aux activités spirituelles', 'sangmelima'); ?></li>
                    <li><?php _e('Organiser les rendez-vous d\'accompagnement spirituel', 'sangmelima'); ?></li>
                    <li><?php _e('Traiter vos dons et émettre des reçus fiscaux', 'sangmelima'); ?></li>
                    <li><?php _e('Vous envoyer la newsletter (si vous y êtes inscrit)', 'sangmelima'); ?></li>
                    <li><?php _e('Améliorer nos services', 'sangmelima'); ?></li>
                    <li><?php _e('Respecter nos obligations légales', 'sangmelima'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('Base légale du traitement', 'sangmelima'); ?></h2>
                <p><?php _e('Le traitement de vos données repose sur :', 'sangmelima'); ?></p>
                <ul>
                    <li><strong><?php _e('Votre consentement', 'sangmelima'); ?></strong> : <?php _e('pour la newsletter, le partage d\'intentions de prière', 'sangmelima'); ?></li>
                    <li><strong><?php _e('L\'exécution d\'un contrat', 'sangmelima'); ?></strong> : <?php _e('pour les rendez-vous spirituels, les dons', 'sangmelima'); ?></li>
                    <li><strong><?php _e('Nos intérêts légitimes', 'sangmelima'); ?></strong> : <?php _e('pour l\'amélioration de nos services', 'sangmelima'); ?></li>
                    <li><strong><?php _e('Obligations légales', 'sangmelima'); ?></strong> : <?php _e('pour la comptabilité, les reçus fiscaux', 'sangmelima'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('Durée de conservation', 'sangmelima'); ?></h2>
                <p><?php _e('Nous conservons vos données selon les durées suivantes :', 'sangmelima'); ?></p>
                <ul>
                    <li><?php _e('Données de compte : tant que le compte est actif + 3 ans', 'sangmelima'); ?></li>
                    <li><?php _e('Données de dons : 10 ans (obligations comptables)', 'sangmelima'); ?></li>
                    <li><?php _e('Intentions de prière : 1 an', 'sangmelima'); ?></li>
                    <li><?php _e('Historique des rendez-vous : 3 ans', 'sangmelima'); ?></li>
                    <li><?php _e('Newsletter : jusqu\'à désinscription', 'sangmelima'); ?></li>
                    <li><?php _e('Cookies : 13 mois maximum', 'sangmelima'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('Destinataires des données', 'sangmelima'); ?></h2>
                <p><?php _e('Vos données peuvent être partagées avec :', 'sangmelima'); ?></p>
                <ul>
                    <li><?php _e('Notre équipe pastorale (pour l\'accompagnement spirituel)', 'sangmelima'); ?></li>
                    <li><?php _e('Nos prestataires de paiement (Stripe, PayPal, Orange Money)', 'sangmelima'); ?></li>
                    <li><?php _e('Notre hébergeur web', 'sangmelima'); ?></li>
                    <li><?php _e('Les autorités compétentes si la loi l\'exige', 'sangmelima'); ?></li>
                </ul>
                <p>
                    <strong><?php _e('Important', 'sangmelima'); ?> :</strong> <?php _e('Nous ne vendons ni ne louons jamais vos données personnelles à des tiers.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Vos droits', 'sangmelima'); ?></h2>
                <p><?php _e('Conformément au RGPD, vous disposez des droits suivants :', 'sangmelima'); ?></p>

                <h3><?php _e('Droit d\'accès', 'sangmelima'); ?></h3>
                <p><?php _e('Vous pouvez demander une copie de toutes les données que nous détenons sur vous.', 'sangmelima'); ?></p>

                <h3><?php _e('Droit de rectification', 'sangmelima'); ?></h3>
                <p><?php _e('Vous pouvez demander la correction de données inexactes ou incomplètes.', 'sangmelima'); ?></p>

                <h3><?php _e('Droit à l\'effacement', 'sangmelima'); ?></h3>
                <p><?php _e('Vous pouvez demander la suppression de vos données dans certaines conditions.', 'sangmelima'); ?></p>

                <h3><?php _e('Droit à la limitation', 'sangmelima'); ?></h3>
                <p><?php _e('Vous pouvez demander la limitation du traitement de vos données.', 'sangmelima'); ?></p>

                <h3><?php _e('Droit à la portabilité', 'sangmelima'); ?></h3>
                <p><?php _e('Vous pouvez recevoir vos données dans un format structuré et lisible.', 'sangmelima'); ?></p>

                <h3><?php _e('Droit d\'opposition', 'sangmelima'); ?></h3>
                <p><?php _e('Vous pouvez vous opposer au traitement de vos données pour certaines finalités.', 'sangmelima'); ?></p>

                <h3><?php _e('Droit de retirer votre consentement', 'sangmelima'); ?></h3>
                <p><?php _e('Vous pouvez retirer votre consentement à tout moment pour les traitements basés sur celui-ci.', 'sangmelima'); ?></p>

                <p>
                    <strong><?php _e('Pour exercer vos droits', 'sangmelima'); ?> :</strong><br>
                    <?php _e('Contactez-nous à', 'sangmelima'); ?> : privacy@sangmelima.org<br>
                    <?php _e('Ou par courrier à', 'sangmelima'); ?> : SangMeLima - Protection des données - [Adresse]
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Sécurité des données', 'sangmelima'); ?></h2>
                <p><?php _e('Nous mettons en œuvre les mesures de sécurité suivantes :', 'sangmelima'); ?></p>
                <ul>
                    <li><?php _e('Cryptage SSL/TLS pour toutes les communications', 'sangmelima'); ?></li>
                    <li><?php _e('Mots de passe hachés et salés', 'sangmelima'); ?></li>
                    <li><?php _e('Accès restreint aux données personnelles', 'sangmelima'); ?></li>
                    <li><?php _e('Sauvegardes régulières et sécurisées', 'sangmelima'); ?></li>
                    <li><?php _e('Mise à jour régulière des systèmes', 'sangmelima'); ?></li>
                    <li><?php _e('Formation du personnel à la protection des données', 'sangmelima'); ?></li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('Cookies', 'sangmelima'); ?></h2>
                <p><?php _e('Notre site utilise les types de cookies suivants :', 'sangmelima'); ?></p>

                <h3><?php _e('Cookies essentiels', 'sangmelima'); ?></h3>
                <p><?php _e('Nécessaires au fonctionnement du site (connexion, panier, etc.)', 'sangmelima'); ?></p>

                <h3><?php _e('Cookies de préférences', 'sangmelima'); ?></h3>
                <p><?php _e('Mémorisent vos choix (langue, région, etc.)', 'sangmelima'); ?></p>

                <h3><?php _e('Cookies statistiques', 'sangmelima'); ?></h3>
                <p><?php _e('Nous aident à comprendre l\'utilisation du site (pages visitées, durée, etc.)', 'sangmelima'); ?></p>

                <p><?php _e('Vous pouvez gérer vos préférences cookies dans les paramètres de votre navigateur.', 'sangmelima'); ?></p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Mineurs', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Les mineurs de moins de 16 ans doivent obtenir le consentement de leurs parents ou tuteurs légaux avant de fournir des données personnelles sur notre site.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Transferts internationaux', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Vos données sont stockées dans l\'Union Européenne. Si un transfert hors UE est nécessaire, nous nous assurons que des garanties appropriées sont en place (clauses contractuelles types, Privacy Shield, etc.).', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Modifications', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Nous pouvons mettre à jour cette politique de confidentialité. Les modifications importantes seront notifiées par email ou via une notification sur le site.', 'sangmelima'); ?>
                </p>
            </section>

            <section class="legal-section">
                <h2><?php _e('Réclamations', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Si vous estimez que vos droits ne sont pas respectés, vous pouvez :', 'sangmelima'); ?>
                </p>
                <ul>
                    <li><?php _e('Nous contacter directement', 'sangmelima'); ?> : privacy@sangmelima.org</li>
                    <li><?php _e('Déposer une réclamation auprès de la CNIL', 'sangmelima'); ?> : www.cnil.fr</li>
                </ul>
            </section>

            <section class="legal-section">
                <h2><?php _e('Contact', 'sangmelima'); ?></h2>
                <p>
                    <?php _e('Pour toute question concernant cette politique ou vos données :', 'sangmelima'); ?><br>
                    <strong><?php _e('Email', 'sangmelima'); ?> :</strong> privacy@sangmelima.org<br>
                    <strong><?php _e('Téléphone', 'sangmelima'); ?> :</strong> +33 1 23 45 67 89<br>
                    <strong><?php _e('Courrier', 'sangmelima'); ?> :</strong> SangMeLima - Protection des données - [Adresse]
                </p>
            </section>

            <div class="legal-footer">
                <p>
                    <strong><?php _e('Date d\'entrée en vigueur', 'sangmelima'); ?> :</strong> 1er janvier 2024<br>
                    <strong><?php _e('Dernière mise à jour', 'sangmelima'); ?> :</strong> <?php echo date_i18n('j F Y'); ?>
                </p>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
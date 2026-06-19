<?php
/**
 * Template Name: Rendez-vous Spirituels
 * @package SangMeLima
 */

get_header(); ?>

<main id="main-content" class="site-main rdv-page">
    <div class="container">
        <header class="page-header">
            <h1><?php _e('Accompagnement spirituel', 'sangmelima'); ?></h1>
            <p class="page-subtitle">
                <?php _e('Prenez rendez-vous pour un accompagnement spirituel personnalisé en visioconférence', 'sangmelima'); ?>
            </p>
        </header>

        <div class="rdv-content">
            <div class="rdv-main">
                <!-- Informations sur l'accompagnement -->
                <section class="card info-section">
                    <h2><?php _e('Comment ça fonctionne ?', 'sangmelima'); ?></h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-icon">📅</span>
                            <h3><?php _e('Choisissez votre créneau', 'sangmelima'); ?></h3>
                            <p><?php _e('Sélectionnez une date et heure qui vous convient dans notre calendrier', 'sangmelima'); ?></p>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">💬</span>
                            <h3><?php _e('Échange en visioconférence', 'sangmelima'); ?></h3>
                            <p><?php _e('Session d\'1 heure en tête-à-tête par Zoom, WhatsApp ou Meet', 'sangmelima'); ?></p>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">🙏</span>
                            <h3><?php _e('Accompagnement bienveillant', 'sangmelima'); ?></h3>
                            <p><?php _e('Écoute, conseils spirituels et prière dans la confidentialité', 'sangmelima'); ?></p>
                        </div>
                    </div>
                </section>

                <!-- Calendrier de réservation -->
                <section class="card booking-section">
                    <h2><?php _e('Réserver un rendez-vous', 'sangmelima'); ?></h2>

                    <!-- Sélection du mois -->
                    <div class="month-selector">
                        <button class="month-nav prev-month" data-direction="prev">←</button>
                        <span class="current-month" id="current-month"><?php echo date_i18n('F Y'); ?></span>
                        <button class="month-nav next-month" data-direction="next">→</button>
                    </div>

                    <!-- Calendrier -->
                    <div id="booking-calendar" class="booking-calendar">
                        <!-- Généré dynamiquement par JavaScript -->
                    </div>

                    <!-- Créneaux horaires -->
                    <div id="time-slots" class="time-slots" style="display:none;">
                        <h3><?php _e('Créneaux disponibles', 'sangmelima'); ?></h3>
                        <div class="slots-grid" id="slots-grid">
                            <!-- Généré dynamiquement -->
                        </div>
                    </div>
                </section>

                <!-- Formulaire de réservation -->
                <section class="card booking-form-section" id="booking-form-section" style="display:none;">
                    <h2><?php _e('Finaliser votre rendez-vous', 'sangmelima'); ?></h2>

                    <div class="booking-summary">
                        <p><strong><?php _e('Date et heure sélectionnées', 'sangmelima'); ?>:</strong></p>
                        <p class="selected-datetime" id="selected-datetime"></p>
                    </div>

                    <form id="rdv-form" class="rdv-form">
                        <!-- Informations personnelles -->
                        <div class="form-section">
                            <h3><?php _e('Vos informations', 'sangmelima'); ?></h3>

                            <div class="form-group">
                                <label for="rdv_name"><?php _e('Nom complet', 'sangmelima'); ?> *</label>
                                <input type="text" id="rdv_name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="rdv_email"><?php _e('Email', 'sangmelima'); ?> *</label>
                                <input type="email" id="rdv_email" name="email" required>
                                <small><?php _e('Pour recevoir le lien de connexion', 'sangmelima'); ?></small>
                            </div>

                            <div class="form-group">
                                <label for="rdv_phone"><?php _e('Téléphone', 'sangmelima'); ?></label>
                                <input type="tel" id="rdv_phone" name="phone">
                                <small><?php _e('En cas de besoin de vous contacter', 'sangmelima'); ?></small>
                            </div>
                        </div>

                        <!-- Plateforme de visio -->
                        <div class="form-section">
                            <h3><?php _e('Plateforme de visioconférence', 'sangmelima'); ?></h3>

                            <div class="platform-options">
                                <label class="platform-option">
                                    <input type="radio" name="platform" value="zoom" checked>
                                    <span class="option-content">
                                        <span class="platform-name">Zoom</span>
                                    </span>
                                </label>
                                <label class="platform-option">
                                    <input type="radio" name="platform" value="whatsapp">
                                    <span class="option-content">
                                        <span class="platform-name">WhatsApp</span>
                                    </span>
                                </label>
                                <label class="platform-option">
                                    <input type="radio" name="platform" value="meet">
                                    <span class="option-content">
                                        <span class="platform-name">Google Meet</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Sujet de l'accompagnement -->
                        <div class="form-section">
                            <h3><?php _e('Votre demande', 'sangmelima'); ?></h3>

                            <div class="form-group">
                                <label for="rdv_subject"><?php _e('Sujet principal (optionnel)', 'sangmelima'); ?></label>
                                <select id="rdv_subject" name="subject">
                                    <option value=""><?php _e('-- Choisir un thème --', 'sangmelima'); ?></option>
                                    <option value="discernement"><?php _e('Discernement', 'sangmelima'); ?></option>
                                    <option value="epreuve"><?php _e('Épreuve / Souffrance', 'sangmelima'); ?></option>
                                    <option value="couple"><?php _e('Vie de couple', 'sangmelima'); ?></option>
                                    <option value="famille"><?php _e('Vie familiale', 'sangmelima'); ?></option>
                                    <option value="vocation"><?php _e('Vocation', 'sangmelima'); ?></option>
                                    <option value="priere"><?php _e('Vie de prière', 'sangmelima'); ?></option>
                                    <option value="confession"><?php _e('Préparation confession', 'sangmelima'); ?></option>
                                    <option value="autre"><?php _e('Autre', 'sangmelima'); ?></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="rdv_message"><?php _e('Message (optionnel)', 'sangmelima'); ?></label>
                                <textarea id="rdv_message" name="message" rows="4"
                                          placeholder="<?php _e('Vous pouvez partager ici ce qui vous préoccupe...', 'sangmelima'); ?>"></textarea>
                                <small><?php _e('Tout sera traité en toute confidentialité', 'sangmelima'); ?></small>
                            </div>
                        </div>

                        <!-- Participation aux frais (DON) -->
                        <div class="form-section donation-section">
                            <h3><?php _e('Participation libre aux frais', 'sangmelima'); ?></h3>
                            <p class="donation-info">
                                <?php _e('Votre don nous aide à poursuivre notre mission d\'accompagnement. Montant suggéré :', 'sangmelima'); ?>
                            </p>

                            <div class="donation-amounts">
                                <label class="donation-option">
                                    <input type="radio" name="donation_amount" value="15" checked>
                                    <span class="amount-box">15 €</span>
                                </label>
                                <label class="donation-option">
                                    <input type="radio" name="donation_amount" value="20">
                                    <span class="amount-box">20 €</span>
                                </label>
                                <label class="donation-option">
                                    <input type="radio" name="donation_amount" value="30">
                                    <span class="amount-box">30 €</span>
                                </label>
                                <label class="donation-option">
                                    <input type="radio" name="donation_amount" value="other">
                                    <span class="amount-box"><?php _e('Autre', 'sangmelima'); ?></span>
                                </label>
                            </div>

                            <div class="other-amount-field" style="display:none;">
                                <input type="number" id="other_amount" min="5" max="100"
                                       placeholder="<?php _e('Montant libre', 'sangmelima'); ?>">
                                <span>€</span>
                            </div>

                            <p class="donation-note">
                                <small><?php _e('Si vous ne pouvez pas participer financièrement, votre rendez-vous reste possible. Contactez-nous.', 'sangmelima'); ?></small>
                            </p>
                        </div>

                        <!-- Conditions -->
                        <div class="form-section">
                            <div class="form-group checkbox-group">
                                <label>
                                    <input type="checkbox" name="accept_conditions" required>
                                    <?php _e('J\'accepte que mes données soient utilisées uniquement pour ce rendez-vous', 'sangmelima'); ?>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="date" id="rdv_date">
                        <input type="hidden" name="time" id="rdv_time">
                        <input type="hidden" name="action" value="book_appointment">
                        <?php wp_nonce_field('rdv_booking', 'rdv_nonce'); ?>

                        <button type="submit" class="btn btn-primary btn-large">
                            <?php _e('Confirmer le rendez-vous', 'sangmelima'); ?>
                        </button>
                    </form>
                </section>
            </div>

            <!-- Sidebar -->
            <aside class="rdv-sidebar">
                <!-- Horaires -->
                <div class="card sidebar-card">
                    <h3><?php _e('Disponibilités', 'sangmelima'); ?></h3>
                    <ul class="availability-list">
                        <li><strong><?php _e('Lundi', 'sangmelima'); ?>:</strong> 15h - 19h</li>
                        <li><strong><?php _e('Mardi', 'sangmelima'); ?>:</strong> 9h - 12h, 15h - 19h</li>
                        <li><strong><?php _e('Mercredi', 'sangmelima'); ?>:</strong> 9h - 12h, 15h - 19h</li>
                        <li><strong><?php _e('Jeudi', 'sangmelima'); ?>:</strong> 9h - 12h, 15h - 19h</li>
                        <li><strong><?php _e('Vendredi', 'sangmelima'); ?>:</strong> 9h - 12h, 15h - 19h</li>
                        <li><strong><?php _e('Samedi', 'sangmelima'); ?>:</strong> 9h - 12h, 15h - 19h</li>
                        <li><strong><?php _e('Dimanche', 'sangmelima'); ?>:</strong> <?php _e('Fermé', 'sangmelima'); ?></li>
                    </ul>
                </div>

                <!-- FAQ -->
                <div class="card sidebar-card">
                    <h3><?php _e('Questions fréquentes', 'sangmelima'); ?></h3>

                    <div class="faq-item">
                        <h4><?php _e('Comment se déroule un rendez-vous ?', 'sangmelima'); ?></h4>
                        <p><?php _e('Le rendez-vous dure 1 heure en visioconférence. Nous échangeons dans la bienveillance et la confidentialité totale.', 'sangmelima'); ?></p>
                    </div>

                    <div class="faq-item">
                        <h4><?php _e('Puis-je annuler ?', 'sangmelima'); ?></h4>
                        <p><?php _e('Oui, vous pouvez annuler jusqu\'à 24h avant. Un email vous sera envoyé avec un lien d\'annulation.', 'sangmelima'); ?></p>
                    </div>

                    <div class="faq-item">
                        <h4><?php _e('Et si je ne peux pas payer ?', 'sangmelima'); ?></h4>
                        <p><?php _e('L\'accompagnement reste accessible à tous. Contactez-nous pour trouver une solution.', 'sangmelima'); ?></p>
                    </div>
                </div>

                <!-- Contact -->
                <div class="card sidebar-card">
                    <h3><?php _e('Besoin d\'aide ?', 'sangmelima'); ?></h3>
                    <p><?php _e('Pour toute question :', 'sangmelima'); ?></p>
                    <p><a href="mailto:accompagnement@sangmelima.org">accompagnement@sangmelima.org</a></p>
                </div>
            </aside>
        </div>
    </div>
</main>

<style>
/* Styles spécifiques pour la page RDV */
.rdv-page {
    padding: 40px 0;
}

.rdv-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 20px;
}

.info-item {
    text-align: center;
}

.info-icon {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 10px;
}

.info-item h3 {
    font-size: 1.1rem;
    margin-bottom: 10px;
    color: var(--primary-color);
}

/* Calendrier */
.month-selector {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.month-nav {
    background: var(--primary-color);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
}

.current-month {
    font-size: 1.2rem;
    font-weight: bold;
}

.booking-calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}

.calendar-header,
.calendar-day {
    padding: 10px;
    text-align: center;
    border: 1px solid #E5E5E5;
}

.calendar-header {
    background: var(--primary-color);
    color: white;
    font-weight: bold;
}

.calendar-day {
    cursor: pointer;
    transition: all 0.3s ease;
}

.calendar-day:hover:not(.disabled) {
    background: var(--bg-light);
}

.calendar-day.selected {
    background: var(--secondary-color);
    color: white;
}

.calendar-day.disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

.calendar-day.today {
    border: 2px solid var(--primary-color);
}

/* Créneaux horaires */
.slots-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 15px;
}

.time-slot {
    padding: 10px;
    text-align: center;
    border: 2px solid #E5E5E5;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.time-slot:hover:not(.disabled) {
    border-color: var(--primary-color);
    background: var(--bg-light);
}

.time-slot.selected {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.time-slot.disabled {
    opacity: 0.3;
    cursor: not-allowed;
}

/* Formulaire */
.form-section {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #E5E5E5;
}

.form-section:last-child {
    border-bottom: none;
}

.form-section h3 {
    margin-bottom: 20px;
    color: var(--primary-color);
}

.platform-options {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.platform-option input {
    display: none;
}

.platform-option .option-content {
    display: block;
    padding: 15px;
    text-align: center;
    border: 2px solid #E5E5E5;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.platform-option input:checked + .option-content {
    border-color: var(--primary-color);
    background: var(--bg-light);
}

/* Section donation */
.donation-section {
    background: var(--bg-light);
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.donation-amounts {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin: 20px 0;
}

.donation-option input {
    display: none;
}

.amount-box {
    display: block;
    padding: 15px;
    text-align: center;
    border: 2px solid var(--primary-color);
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.donation-option input:checked + .amount-box {
    background: var(--primary-color);
    color: white;
}

.other-amount-field {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 15px;
}

.other-amount-field input {
    flex: 1;
    padding: 10px;
    border: 2px solid var(--primary-color);
    border-radius: 8px;
}

.donation-note {
    margin-top: 15px;
    padding: 10px;
    background: white;
    border-radius: 4px;
}

/* Sidebar */
.rdv-sidebar {
    position: sticky;
    top: 100px;
}

.sidebar-card {
    margin-bottom: 20px;
}

.availability-list {
    list-style: none;
    padding: 0;
}

.availability-list li {
    padding: 8px 0;
    border-bottom: 1px solid #E5E5E5;
}

.availability-list li:last-child {
    border-bottom: none;
}

.faq-item {
    margin-bottom: 20px;
}

.faq-item h4 {
    color: var(--primary-color);
    margin-bottom: 10px;
}

/* Responsive */
@media (max-width: 1024px) {
    .rdv-content {
        grid-template-columns: 1fr;
    }

    .rdv-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }

    .slots-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .platform-options,
    .donation-amounts {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const availableSlots = {
        1: ['15:00', '16:00', '17:00', '18:00'], // Lundi après-midi seulement
        2: ['09:00', '10:00', '11:00', '15:00', '16:00', '17:00', '18:00'],
        3: ['09:00', '10:00', '11:00', '15:00', '16:00', '17:00', '18:00'],
        4: ['09:00', '10:00', '11:00', '15:00', '16:00', '17:00', '18:00'],
        5: ['09:00', '10:00', '11:00', '15:00', '16:00', '17:00', '18:00'],
        6: ['09:00', '10:00', '11:00', '15:00', '16:00', '17:00', '18:00'],
        0: [] // Dimanche fermé
    };

    let currentMonth = new Date();
    let selectedDate = null;
    let selectedTime = null;

    // Initialiser le calendrier
    renderCalendar();

    // Navigation mois
    document.querySelector('.prev-month').addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() - 1);
        renderCalendar();
    });

    document.querySelector('.next-month').addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() + 1);
        renderCalendar();
    });

    // Fonction pour afficher le calendrier
    function renderCalendar() {
        const year = currentMonth.getFullYear();
        const month = currentMonth.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();

        // Mettre à jour le mois affiché
        const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                           'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        document.getElementById('current-month').textContent = monthNames[month] + ' ' + year;

        // Générer le calendrier
        let html = '';

        // En-têtes des jours
        const dayNames = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        dayNames.forEach(day => {
            html += `<div class="calendar-header">${day}</div>`;
        });

        // Jours vides avant le début du mois
        for (let i = 0; i < firstDay; i++) {
            html += '<div class="calendar-day disabled"></div>';
        }

        // Jours du mois
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dayOfWeek = date.getDay();
            const isPast = date < today.setHours(0, 0, 0, 0);
            const isToday = date.toDateString() === today.toDateString();
            const hasSlots = availableSlots[dayOfWeek].length > 0;

            let classes = 'calendar-day';
            if (isPast || !hasSlots) classes += ' disabled';
            if (isToday) classes += ' today';

            html += `<div class="${classes}" data-date="${year}-${(month+1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}">${day}</div>`;
        }

        document.getElementById('booking-calendar').innerHTML = html;

        // Ajouter les événements click
        document.querySelectorAll('.calendar-day:not(.disabled)').forEach(day => {
            day.addEventListener('click', selectDate);
        });
    }

    // Sélectionner une date
    function selectDate(e) {
        // Retirer la sélection précédente
        document.querySelectorAll('.calendar-day.selected').forEach(d => {
            d.classList.remove('selected');
        });

        // Ajouter la nouvelle sélection
        e.target.classList.add('selected');
        selectedDate = e.target.dataset.date;

        // Afficher les créneaux
        showTimeSlots(selectedDate);
    }

    // Afficher les créneaux horaires
    function showTimeSlots(date) {
        const dayOfWeek = new Date(date).getDay();
        const slots = availableSlots[dayOfWeek];

        let html = '';
        slots.forEach(time => {
            html += `<div class="time-slot" data-time="${time}">${time}</div>`;
        });

        document.getElementById('slots-grid').innerHTML = html;
        document.getElementById('time-slots').style.display = 'block';

        // Ajouter les événements click
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', selectTime);
        });
    }

    // Sélectionner un créneau
    function selectTime(e) {
        // Retirer la sélection précédente
        document.querySelectorAll('.time-slot.selected').forEach(s => {
            s.classList.remove('selected');
        });

        // Ajouter la nouvelle sélection
        e.target.classList.add('selected');
        selectedTime = e.target.dataset.time;

        // Afficher le formulaire
        showBookingForm();
    }

    // Afficher le formulaire
    function showBookingForm() {
        const dateObj = new Date(selectedDate + ' ' + selectedTime);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        const formattedDate = dateObj.toLocaleDateString('fr-FR', options);

        document.getElementById('selected-datetime').textContent = formattedDate;
        document.getElementById('rdv_date').value = selectedDate;
        document.getElementById('rdv_time').value = selectedTime;
        document.getElementById('booking-form-section').style.display = 'block';

        // Scroll vers le formulaire
        document.getElementById('booking-form-section').scrollIntoView({ behavior: 'smooth' });
    }

    // Gestion du montant "Autre"
    document.querySelectorAll('input[name="donation_amount"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const otherField = document.querySelector('.other-amount-field');
            if (this.value === 'other') {
                otherField.style.display = 'flex';
            } else {
                otherField.style.display = 'none';
            }
        });
    });

    // Soumission du formulaire
    document.getElementById('rdv-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        // Ajouter le montant personnalisé si sélectionné
        if (formData.get('donation_amount') === 'other') {
            const otherAmount = document.getElementById('other_amount').value;
            formData.set('donation_amount', otherAmount);
        }

        // Envoyer via AJAX
        fetch(sangmelima_ajax.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Votre rendez-vous a été confirmé ! Vous allez recevoir un email de confirmation.');
                // Rediriger vers la page de paiement si nécessaire
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } else {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    });
});
</script>

<?php get_footer(); ?>
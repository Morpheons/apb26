<style>
    /* On force l'interactivité sur TOUTE la zone de l'événement */
    .fc-event,
    .fc-event-main,
    .fc-event-title,
    .clickable-event {
        cursor: pointer !important;
        pointer-events: auto !important;
        z-index: 10 !important;
    }
</style>

<script>
    // Ce script va écouter TOUS les clics sur la page et forcer l'action si on touche un événement
    document.addEventListener('click', function(e) {
        const eventEl = e.target.closest('.fc-event');
        if (eventEl) {
            // On essaie de trouver l'ID que Guava stocke souvent dans des attributs data
            // ou on laisse le eventClick de getOptions faire son travail maintenant que pointer-events est corrigé
            console.log('Clic physique détecté sur l\'élément agenda');
        }
    }, true); // Le 'true' ici est vital : il capture l'événement avant tout le monde
</script>

(function($){
    // Helper pour sessionStorage
    function setOnce(key) {
        try { sessionStorage.setItem(key, '1'); } catch(e){}
    }
    function wasShown(key) {
        try { return sessionStorage.getItem(key) === '1'; } catch(e){ return false; }
    }
    // Popup principal
    if (wdpPopups.main_enable && wdpPopups.is_home && !wasShown('wdp_main_popup')) {
        setTimeout(function(){
            $('#wdp-popup-main').fadeIn(180);
        }, 2000);
        $('#wdp-popup-main .wdp-close').on('click', function(){
            $('#wdp-popup-main').fadeOut(120);
            setOnce('wdp_main_popup');
        });
    }
    // Popup sortie (exit intent)
    if (wdpPopups.exit_enable && !wasShown('wdp_exit_popup')) {
        var exitShown = false;
        function showExit() {
            if (!exitShown) {
                $('#wdp-popup-exit').fadeIn(180);
                exitShown = true;
                setOnce('wdp_exit_popup');
            }
        }
        // Détection souris vers barre (desktop uniquement)
        $(document).on('mouseleave', function(e){
            if (e.clientY < 10) showExit();
        });
        $('#wdp-popup-exit .wdp-close').on('click', function(){
            $('#wdp-popup-exit').fadeOut(120);
        });
    }

    // Fermeture via la touche Escape
    $(document).on('keydown', function(e){
        if (e.key === 'Escape' || e.keyCode === 27) {
            if ($('#wdp-popup-main').is(':visible')) {
                $('#wdp-popup-main').fadeOut(120);
                setOnce('wdp_main_popup');
            }
            if ($('#wdp-popup-exit').is(':visible')) {
                $('#wdp-popup-exit').fadeOut(120);
            }
        }
    });
})(jQuery);

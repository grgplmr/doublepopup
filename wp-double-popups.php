<?php
/*
Plugin Name: WP Double Popups
Description: Affiche deux popups personnalisables (principal & sortie) avec gestion avancée depuis l’admin.
Version: 1.0.0
Author: Développeur Expert WordPress
License: GPL2

INSTALLATION :
1. Placez le dossier `wp-double-popups` dans `wp-content/plugins/`.
2. Activez le plugin depuis l’admin WordPress.
3. Rendez-vous dans Réglages > Double Popups pour configurer.
*/

// Sécurité : Bloquer l’accès direct
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WDP_VERSION', '1.0.0' );
define( 'WDP_PATH', plugin_dir_path(__FILE__) );
define( 'WDP_URL', plugin_dir_url(__FILE__) );

require_once WDP_PATH . 'includes/class-wdp-admin.php';
require_once WDP_PATH . 'includes/class-wdp-frontend.php';

// Activation : définir les options par défaut si elles n'existent pas
function wdp_activate() {
    if ( false === get_option( 'wdp_settings', false ) ) {
        $defaults = array(
            'main_enable' => 1,
            'main_text'   => '🎉 Découvrez notre événement annuel le 12 juillet à Bordeaux !',
            'main_font'   => 'Roboto',
            'main_size'   => 18,
            'main_color'  => '#222222',
            'main_bg'     => '#ffffff',
            'exit_enable' => 1,
            'exit_text'   => 'Vous nous quittez déjà ? Abonnez-vous à notre newsletter pour ne rien manquer !',
            'exit_font'   => 'Roboto',
            'exit_size'   => 18,
            'exit_color'  => '#222222',
            'exit_bg'     => '#ffffff',
        );
        add_option( 'wdp_settings', $defaults );
    }
}
register_activation_hook( __FILE__, 'wdp_activate' );

// Initialisation admin et frontend
if ( is_admin() ) {
    new WDP_Admin();
} else {
    new WDP_Frontend();
}

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

// Initialisation admin et frontend
if ( is_admin() ) {
    new WDP_Admin();
} else {
    new WDP_Frontend();
}

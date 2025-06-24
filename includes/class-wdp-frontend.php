<?php
// Sécurité
if ( ! defined( 'ABSPATH' ) ) exit;

class WDP_Frontend {

    private $option_name = 'wdp_settings';

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_footer', array( $this, 'output_popups' ) );
    }

    public function enqueue_assets() {
        // CSS
        wp_enqueue_style( 'wdp-popup-style', WDP_URL . 'assets/popups.css', array(), WDP_VERSION );
        // JS
        wp_enqueue_script( 'wdp-popup-js', WDP_URL . 'assets/popups.js', array('jquery'), WDP_VERSION, true );
        // Passer les options JS
        $settings = get_option( $this->option_name, array() );
        wp_localize_script( 'wdp-popup-js', 'wdpPopups', array(
            'main_enable' => !empty($settings['main_enable']),
            'exit_enable' => !empty($settings['exit_enable']),
            'is_home'     => is_front_page(),
            'main_once'   => 1,
            'exit_once'   => 1,
        ));
    }

    public function output_popups() {
        $settings = get_option( $this->option_name, array() );
        // Styles inline spécifiques (aucune ressource externe)
        ?>
        <!-- Popup principal -->
        <?php if ( !empty($settings['main_enable']) && is_front_page() ) : ?>
        <div id="wdp-popup-main" class="wdp-popup" style="display:none;background:<?php echo esc_attr($settings['main_bg']); ?>;color:<?php echo esc_attr($settings['main_color']); ?>;font-family:<?php echo esc_attr($settings['main_font']); ?>;font-size:<?php echo esc_attr($settings['main_size']); ?>px;">
            <button class="wdp-close" aria-label="<?php esc_attr_e( 'Fermer', 'wp-double-popups' ); ?>">&times;</button>
            <div class="wdp-content"><?php echo wp_kses_post($settings['main_text']); ?></div>
        </div>
        <?php endif; ?>
        <!-- Popup sortie -->
        <?php if ( !empty($settings['exit_enable']) ) : ?>
        <div id="wdp-popup-exit" class="wdp-popup" style="display:none;background:<?php echo esc_attr($settings['exit_bg']); ?>;color:<?php echo esc_attr($settings['exit_color']); ?>;font-family:<?php echo esc_attr($settings['exit_font']); ?>;font-size:<?php echo esc_attr($settings['exit_size']); ?>px;">
            <button class="wdp-close" aria-label="<?php esc_attr_e( 'Fermer', 'wp-double-popups' ); ?>">&times;</button>
            <div class="wdp-content"><?php echo wp_kses_post($settings['exit_text']); ?></div>
        </div>
        <?php endif; ?>
        <?php
    }
}

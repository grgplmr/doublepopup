<?php
// Sécurité
if ( ! defined( 'ABSPATH' ) ) exit;

class WDP_Admin {

    private $option_name = 'wdp_settings';

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'register_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
    }

    public function register_menu() {
        add_options_page(
            'Double Popups',
            'Double Popups',
            'manage_options',
            'wdp_settings',
            array( $this, 'settings_page' )
        );
    }

    public function register_settings() {
        register_setting( 'wdp_settings_group', $this->option_name, array( $this, 'sanitize_settings' ) );
    }

    public function sanitize_settings( $input ) {
        $output = array();

        // Main Popup
        $output['main_enable'] = !empty($input['main_enable']) ? 1 : 0;
        $output['main_text']   = wp_kses_post( $input['main_text'] );
        $output['main_font']   = sanitize_text_field( $input['main_font'] );
        $output['main_size']   = intval( $input['main_size'] );
        $output['main_color']  = sanitize_hex_color( $input['main_color'] );
        $output['main_bg']     = sanitize_hex_color( $input['main_bg'] );

        // Exit Popup
        $output['exit_enable'] = !empty($input['exit_enable']) ? 1 : 0;
        $output['exit_text']   = wp_kses_post( $input['exit_text'] );
        $output['exit_font']   = sanitize_text_field( $input['exit_font'] );
        $output['exit_size']   = intval( $input['exit_size'] );
        $output['exit_color']  = sanitize_hex_color( $input['exit_color'] );
        $output['exit_bg']     = sanitize_hex_color( $input['exit_bg'] );

        return $output;
    }

    public function enqueue_admin_assets( $hook ) {
        if ( $hook !== 'settings_page_wdp_settings' ) return;
        wp_enqueue_style( 'wdp-admin-style', WDP_URL . 'assets/admin.css', array(), WDP_VERSION );
    }

    public function settings_page() {
        $settings = get_option( $this->option_name, array(
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
        ));
        ?>
        <div class="wrap wdp-settings">
            <h1>Réglages Double Popups</h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'wdp_settings_group' ); ?>

                <h2>Popup principal (Page d’accueil)</h2>
                <label><input type="checkbox" name="wdp_settings[main_enable]" value="1" <?php checked( $settings['main_enable'], 1 ); ?>> Activer le popup principal</label>
                <br>
                <label>Texte :</label>
                <?php wp_editor( $settings['main_text'], 'wdp_settings_main_text', array(
                    'textarea_name' => 'wdp_settings[main_text]',
                    'textarea_rows' => 3,
                    'teeny' => true,
                    'media_buttons' => false
                )); ?>
                <div class="wdp-flex">
                    <div>
                        <label>Police :</label>
                        <select name="wdp_settings[main_font]">
                            <?php foreach ( $this->get_fonts() as $font ): ?>
                                <option value="<?php echo esc_attr($font); ?>" <?php selected( $settings['main_font'], $font ); ?>><?php echo esc_html($font); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Taille :</label>
                        <input type="number" name="wdp_settings[main_size]" value="<?php echo esc_attr($settings['main_size']); ?>" min="10" max="40"> px
                    </div>
                    <div>
                        <label>Couleur texte :</label>
                        <input type="color" name="wdp_settings[main_color]" value="<?php echo esc_attr($settings['main_color']); ?>">
                    </div>
                    <div>
                        <label>Fond :</label>
                        <input type="color" name="wdp_settings[main_bg]" value="<?php echo esc_attr($settings['main_bg']); ?>">
                    </div>
                </div>

                <hr>

                <h2>Popup de sortie</h2>
                <label><input type="checkbox" name="wdp_settings[exit_enable]" value="1" <?php checked( $settings['exit_enable'], 1 ); ?>> Activer le popup sortie</label>
                <br>
                <label>Texte :</label>
                <?php wp_editor( $settings['exit_text'], 'wdp_settings_exit_text', array(
                    'textarea_name' => 'wdp_settings[exit_text]',
                    'textarea_rows' => 3,
                    'teeny' => true,
                    'media_buttons' => false
                )); ?>
                <div class="wdp-flex">
                    <div>
                        <label>Police :</label>
                        <select name="wdp_settings[exit_font]">
                            <?php foreach ( $this->get_fonts() as $font ): ?>
                                <option value="<?php echo esc_attr($font); ?>" <?php selected( $settings['exit_font'], $font ); ?>><?php echo esc_html($font); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label>Taille :</label>
                        <input type="number" name="wdp_settings[exit_size]" value="<?php echo esc_attr($settings['exit_size']); ?>" min="10" max="40"> px
                    </div>
                    <div>
                        <label>Couleur texte :</label>
                        <input type="color" name="wdp_settings[exit_color]" value="<?php echo esc_attr($settings['exit_color']); ?>">
                    </div>
                    <div>
                        <label>Fond :</label>
                        <input type="color" name="wdp_settings[exit_bg]" value="<?php echo esc_attr($settings['exit_bg']); ?>">
                    </div>
                </div>
                <hr>
                <?php submit_button(); ?>
            </form>
            <h2>Aperçu (après sauvegarde des réglages)</h2>
            <div style="display:flex;gap:40px;">
                <div>
                    <strong>Popup principal</strong>
                    <div style="margin-top:10px;padding:20px;background:<?php echo esc_attr($settings['main_bg']); ?>;color:<?php echo esc_attr($settings['main_color']); ?>;font-family:<?php echo esc_attr($settings['main_font']); ?>;font-size:<?php echo esc_attr($settings['main_size']); ?>px;max-width:320px;border-radius:12px;">
                        <?php echo wp_kses_post($settings['main_text']); ?>
                    </div>
                </div>
                <div>
                    <strong>Popup sortie</strong>
                    <div style="margin-top:10px;padding:20px;background:<?php echo esc_attr($settings['exit_bg']); ?>;color:<?php echo esc_attr($settings['exit_color']); ?>;font-family:<?php echo esc_attr($settings['exit_font']); ?>;font-size:<?php echo esc_attr($settings['exit_size']); ?>px;max-width:320px;border-radius:12px;">
                        <?php echo wp_kses_post($settings['exit_text']); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function get_fonts() {
        return array(
            'Arial', 'Verdana', 'Tahoma', 'Trebuchet MS', 'Georgia', 'Times New Roman', 'Courier New', 'Roboto', 'Montserrat', 'Open Sans', 'Lato'
        );
    }
}

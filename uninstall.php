<?php
// Prevent direct file access
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Remove plugin settings
delete_option( 'wdp_settings' );

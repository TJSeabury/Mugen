<?php
/* Setup the activation hook specifically for checking for the custom.css file
 * I'm calling the same function using the activation hook - which is when the user activates the plugin,
 * and during upgrade plugin event. This ensures that the custom.css file can also be managed
 * when the plugin is updated.
 */
register_activation_hook( __FILE__, array( $this, 'activate' ) );
add_action( 'pre_set_site_transient_update_plugins', array( $this, 'activate' ) );

/**
  * Checks to see if a custom.css file exists. If not, creates it; otherwise, does nothing. This will
  * prevent customizations from being overwritten in future upgrades.
  */
 function activate() {
    $custom_css_path =  MUGEN_ROOT . '/public/css/custom.css';
    if( is_writable( $custom_css_path ) && ! file_exists( $str_custom_path ) ) {
        file_put_contents( $str_custom_path, 'body { background-color: red; }' );
    }
}

function compress( $css_partfiles, $compress = false )
{
    $o = '';
    foreach ( $css_partfiles as $file )
    {
        $o .= file_get_contents( $file );
    }
    if ( $compress )
    {
        $o = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $o ) );
    }
    return $o;
}

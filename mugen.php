<?php
/*
Plugin Name: 無限 Mugen
Plugin URI:  https://github.com/TJSeabury/Mugen
Description: Assorted content modules.
Version:     0.0.1
Author:      Tyler Seabury
Author URI:  https://github.com/TJSeabury
License:     GPL2

無限 Mugen is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
無限 Mugen is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with 無限 Mugen. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

/*
* Plugin root dir
*/
define( 'MUGEN_ROOT', __DIR__ );
define( 'MUGEN_URL', plugin_dir_url( __FILE__ ) );

require_once( MUGEN_ROOT . '/includes/utils.php' );

register_activation_hook( __FILE__, 'mugen_activate' );
register_deactivation_hook( __FILE__, 'mugen_deactivate' );
register_uninstall_hook( __FILE__, 'mugen_uninstall' );


if ( is_admin() )
{
    require_once( MUGEN_ROOT . '/admin/mugen-admin.php' );
    //add_action( 'admin_enqueue_scripts', '' );
}

add_action( 'init', 'mugen_shortcodes_init' );

add_action( 'wp_enqueue_scripts', 'mugen_styles_init' );

function mugen_styles_init() {
    wp_enqueue_style( 'mugen-aggregate-styles', MUGEN_URL . 'public/css/aggregate-styles.min.css', array(), Mugen_utils::get_file_version( MUGEN_URL . 'public/css/aggregate-styles.min.css' ) );
} 

function mugen_box_shortcode( $atts = [], $content = null, $tag = '' )
{
    $atts = array_change_key_case( (array)$atts, CASE_LOWER );
    $mugen_atts = shortcode_atts( ['title' => 'WordPress.org'], $atts, $tag );
    $o = '';
    $o .= '<div class="mugen-box">';
    $o .= '<h2>' . esc_html__( $mugen_atts['title'], 'mugen' ) . '</h2>';
    if ( !is_null( $content ) )
    {
        $o .= apply_filters( 'the_content', $content );
        $o .= do_shortcode( $content );
    }
    $o .= '</div>';
    return $o;
}

function mugen_button_shortcode( $atts = [], $content = null, $tag = '' )
{
    $atts = array_change_key_case( (array)$atts, CASE_LOWER );
    $mugen_atts = shortcode_atts( ['href' => '#'], $atts, $tag );
    $o = '';
    $o .= '<a class="mugen-button" href="' . esc_html__( $mugen_atts['href'], mugen ) . '" >';
    if ( !is_null( $content ) )
    {
        $o .= $content;
    }
    $o .= '</a>';
    return $o;
}
 
function mugen_shortcodes_init()
{
    add_shortcode( 'mugen-box', 'mugen_box_shortcode' );
    add_shortcode( 'mugen-button', 'mugen_button_shortcode' );
}

function mugen_activate()
{
    $path =  MUGEN_ROOT . '/public/css/aggregate-styles.min.css';
    if ( true /* is_writable( $path ) */ /* && !file_exists( $path ) */ )
    {
        $c = '';
        foreach( array_filter( glob( MUGEN_ROOT . '/public/css/modules/*.css' ), 'is_file' ) as $file )
        {
            $c .= file_get_contents( $file );
            $c .= "\n";
        }
        $c = str_replace( array( ' {', ': ', ', ' ), array( '{', ':', ',' ) , str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $c ) ) );
        $f = fopen( $path, 'wb' );
        fwrite( $f, $c );
        fclose( $f );
    }
}

function mugen_deactivate()
{

}

function mugen_uninstall()
{
    
}
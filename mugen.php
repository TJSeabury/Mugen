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

define( 'MUGEN_DEBUG', false );

register_activation_hook(__FILE__, 'mugen_activate');

register_deactivation_hook(__FILE__, 'mugen_deactivate');

register_uninstall_hook(__FILE__, 'mugen_uninstall');

if ( defined( 'MUGEN_DEBUG' ) && constant( 'MUGEN_DEBUG' ) )
{
    add_action( 'all', 'mugen_debug_actions' );
}

add_action( 'admin_menu', 'mugen_options_page' );

add_action('init', 'mugen_shortcodes_init');

function mugen_box_shortcode( $atts = [], $content = null, $tag = '' )
{
    $atts = array_change_key_case( (array)$atts, CASE_LOWER );
    $mugen_atts = shortcode_atts( ['title' => 'WordPress.org'], $atts, $tag );
    $o = '<style>.mugen-box{ background-color:#f2efef; box-shadow: 0 4px 4px -2px hsla(0,0%,0%,0.3), 4px 4px 8px 0 hsla(0,0%,0%,0.05), -4px 4px 8px 0 hsla(0,0%,0%,0.05) !important; padding:2rem; }</style>';
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
    $o = '<style>
    .mugen-button {
        position: relative;
        display: inline-block;
        color: white !important;
        text-transform: uppercase;
        font-weight: 100;
        letter-spacing: 2px;
        background-color: hsla(340,100%,50%,1);
        box-shadow: 0 2px 4px -2px hsla(0,0%,0%,0.3), 1px 2px 4px 0 hsla(0,0%,0%,0.1), -1px 2px 4px 0 hsla(0,0%,0%,0.1) !important;
        padding: 0.2rem 1rem;
        transition: all 150ms ease-out !important;
    }
    .mugen-button:hover {
        box-shadow: 0 4px 4px -2px hsla(0,0%,0%,0.3), 4px 4px 10px 0 hsla(0,0%,0%,0.1), -4px 4px 10px 0 hsla(0,0%,0%,0.1) !important;
        transform: translateY(-2px);
    }
    </style>';
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

function mugen_options_page_html()
{
    // check user capabilities
    if ( !current_user_can( 'manage_options' ) )
    {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "mugen_options"
            //settings_fields('mugen_options');
            // output setting sections and their fields
            // (sections are registered for "mugen", each field is registered to a specific section)
            //do_settings_sections('mugen');
            // output save settings button
            //submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

function mugen_options_page()
{
    add_menu_page(
        'Mugen',
        'Mugen Options',
        'manage_options',
        'mugen',
        'mugen_options_page_html',
        plugin_dir_url(__FILE__) . 'img/mugen-icon.png',
        20
    );
}

function mugen_activate()
{

}

function mugen_deactivate()
{

}

function mugen_uninstall()
{
    
}

function mugen_debug_actions()
{
    echo '<p>' . current_action() . '</p>';
}
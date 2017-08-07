<?php
/*
Plugin Name: 無限 Mugen
Plugin URI:  https://github.com/TJSeabury
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
            // output security fields for the registered setting "wporg_options"
            //settings_fields('wporg_options');
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            //do_settings_sections('wporg');
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
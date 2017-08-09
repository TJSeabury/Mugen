<?php

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
            // output security fields for the registered setting "mugen_options"
            settings_fields( 'mugen_options' );
            // output setting sections and their fields
            // (sections are registered for "mugen", each field is registered to a specific section)
            do_settings_sections( 'mugen' );
            // output save settings button
            submit_button( 'Save Settings' );
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
        MUGEN_URL . 'admin/img/mugen-icon.png',
        20
    );
}
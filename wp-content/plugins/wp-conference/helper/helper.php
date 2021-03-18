<?php

class ConfHelper
{
    public function __construct()
    {
        add_action('admin_menu', array($this,'top_submenu'));
    }


    public function top_submenu()
    {
        add_submenu_page(
            'conference_top',
            'Conference Help',
            'Conference Help',
            'manage_options',
            'conference_help',
            array($this, 'top_submenu_html')
        );
    }

    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
            <h1>Conference Help</h1>
            <p>ID в формах: 
                <ul>
                    <li>Поле отчество: 'otchestvo'</li>
                </ul>
            </p>
        </div> 
        <?php
    }
}
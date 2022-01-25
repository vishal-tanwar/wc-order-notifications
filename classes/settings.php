<?php
namespace WCON;

use WCON\Abs\Settings as Setting;

class Settings extends Setting{
    protected $plugin = WCON_PLUGIN_BASENAME;

    public function __construct(){

        parent::__construct();

        $this->init();
    }

    private function init(){
        add_filter("plugin_action_links_{$this->plugin}", [ $this, 'settings_link'] );
    }

    public function menu(){
        add_menu_page('Order Notification', 'Order Notification', 'manage_options', 'wcon-settings', [$this, 'template'], 'dashicons-bell', 59);
    }

    public function register_fields(){

        add_settings_section( 'wcon_settings_page_section', '', array( $this, 'setting_display' ), 'wcon_general_settings');

        $fields = array(
            array(
                'id' => 'wcon_sms_api_key',
                'setting' => 'wcon_general_settings',
                'title' => 'SMS API Key',
                'section' => 'wcon_settings_page_section',
                'type' => 'input',
                'subtype' => 'password',
                'required' => true,
                'default' =>  '',
                'attributes' => array(),
                'description' => 'Get SMS API key From <a href="https://sms.teleosms.com/Web/WebAPI/APICodes.aspx">https://sms.teleosms.com/Web/WebAPI/APICodes.aspx</a>'
            ),
            array(
                'id' => 'wcon_sms_sender_id',
                'setting' => 'wcon_general_settings',
                'title' => 'SMS Sender ID',
                'section' => 'wcon_settings_page_section',
                'type' => 'input',
                'subtype' => 'text',
                'required' => true,
                'default' =>  '',
                'attributes' => array(),
                'description' => 'Get Sender ID From <a href="https://sms.teleosms.com/Web/MT/MySenderId.aspx">https://sms.teleosms.com/Web/MT/MySenderId.aspx</a>'
            ),
            array(
                'id' => 'wcon_whatsapp_api_key',
                'setting' => 'wcon_general_settings',
                'title' => 'WhatsApp API key',
                'section' => 'wcon_settings_page_section',
                'type' => 'input',
                'subtype' => 'password',
                'required' => false,
                'default' =>  '',
                'attributes' => array(),
            )
        );

        $this->fields( $fields );
    }

    public function template(){
        require WCON_PLUGIN_INC . 'settings.php';
    }

    public function settings_link( $links ){
        $settings = "<a href='" . admin_url( 'admin.php?page=wcon-settings ') ."'>Settings</a>";
        // Add Settings Link at first
        array_unshift( $links, $settings );

        return $links;
    }
}

new Settings();
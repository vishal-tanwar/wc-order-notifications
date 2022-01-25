<?php
namespace WCON;

use WCON\Abs\Settings as Setting;

class Templates extends Setting{
    protected $plugin = WCON_PLUGIN_BASENAME;

    public function __construct(){
        parent::__construct();
    }

    public function menu(){
        $submenu = add_submenu_page('wcon-settings', 'Templates', 'Templates', 'manage_options', 'wcon-template-settings', [$this, 'template']);
    }

    public function template(){
        require WCON_PLUGIN_INC . 'templates.php';
    }

    public function register_fields(){
        add_settings_section( 'wcon_settings_page_section', '', array( $this, 'setting_display' ), 'wcon_template_settings');

        foreach ( $this->smsTemplates() as $key => $val ): 
            $customerid = "wcon_customer_template_{$key}_sms";
            $vendorid = "wcon_vendor_template_{$key}_sms";
            register_setting("wcon_template_{$key}_settings", $customerid );
            register_setting("wcon_template_{$key}_settings", $vendorid );
        endforeach;
    }

    public function smsTemplates(){
        return array(
            'new-order' => 'New Order',
            'status-change' => 'Status Change'
        );
    }

    public function editor( $title, $template, $smsFor ){
        // Customer SMS
        $id = "wcon_{$smsFor}_template_{$template}_sms";
        $value = get_option( $id );
        ?>
            <div class="wcon-template-editor">
                <div class="wcon-label"><strong><?php echo $title; ?></strong></div>
                <div class="wcon-editor">
                    <textarea id="<?php echo $id ?>" name="<?php echo $id ?>"><?php echo !empty($value) ? $value : ''; ?></textarea>
                    <p class="description">Available tags: <?php echo $this->formatted_placeholders( $smsFor ) ?></p>
                </div>
            </div>
        <?php 
    }

    protected function placeholders( $for = 'customer' ){
        $placeholders = array(
            'customer' => array(
                '{order_id}' => '',
                '{customer_name}' => '',
                '{customer_email}' => '',
                '{status}' => '',
                '{site_url}' => home_url(),
            ),
            'vendor' => array(
                '{order_id}' => '',
                '{vendor_name}' => '',
                '{vendor_email}' => '',
                '{status}' => '',
                '{site_url}' => home_url(),
            )
        );

        if( isset($placeholders[$for])){
            return $placeholders[$for];
        }
    }

    protected function formatted_placeholders( $for ){
        $placeholders = array_keys( $this->placeholders( $for ) );

        return  implode( ' ', array_map( function($p){ return "<code>$p</code>"; }, $placeholders ) );
    }

}
new Templates();
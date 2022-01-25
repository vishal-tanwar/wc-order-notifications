<?php
namespace WCON;

class SMS{

    protected $apiKey;

    protected $apiUrl = 'https://sms.teleosms.com/api/mt/SendSMS';

    protected $senderId;

    public function __construct(){
        // SMS Api Key
        $this->apiKey = get_option('wcon_sms_api_key');
        $this->senderId = get_option('wcon_sms_sender_id');

        add_action( 'woocommerce_order_status_changed', array($this, 'status_changed'), 10, 3 );
        add_action( 'woocommerce_thankyou', array($this, 'new_order'), 10, 1 );
    }


    public function status_changed( $order_id, $previous_status, $next_status ){
        
        $order = wc_get_order( $order_id );

        $cTemplate = get_option("wcon_customer_template_status-change_sms");
        $cTemplate = $this->formatTemplate( $cTemplate, array('{status}' => wc_get_order_status_name( $next_status ) ) );

        $this->send( '+918814898955', $this->formatTemplate( $cTemplate, $this->placeholders( $order )) );
    }

    public function new_order( $order_id ){
        
    }

    protected function send( $number, $message ){
        
        $data = array(
            'APIKey' => $this->apiKey,
            'number' => $number,
            'text'   => $message,
            'senderid' => $this->senderId,
            'channel' => 'Trans',
            'DCS' => 0,
            'flashsms' => 0,
            'route' => 2,
        );
        echo http_build_query( $data  );
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl . '?' . http_build_query( $data  ) );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Timeout in seconds
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $response = curl_exec($ch);
        curl_close( $ch );
    }

    protected function formatTemplate( $content, $replace ){

        $pattern = array_map( function($p){ return "/$p/i"; }, array_keys( $replace ) );
        $with = array_values( $replace );

        return preg_replace($pattern, $with, $content);
    }

    protected function placeholders( $order, $for = 'customer' ){

        $placeholders = array(
            'customer' => array(
                '{order_id}' => $order->get_id(),
                '{customer_name}' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                '{customer_email}' => $order->get_billing_email() . ' ' . $order->get_billing_phone(),
                '{site_url}' => home_url(),
            ),
            'vendor' => array(
                '{order_id}' => '',
                '{vendor_name}' => '',
                '{vendor_email}' => '',
                '{site_url}' => home_url(),
            )
        );

        if( isset($placeholders[$for])){
            return $placeholders[$for];
        }
    }
}

new SMS();
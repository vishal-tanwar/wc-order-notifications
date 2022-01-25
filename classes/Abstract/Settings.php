<?php 
namespace WCON\Abs;

abstract class Settings{
    public function __construct(){
        $this->init();
    }
    private function init(){
        add_action( 'admin_menu', [$this, 'menu'] );
        add_action('admin_init', array( $this, 'register_fields' ));
        add_filter( 'admin_enqueue_scripts', [$this, 'wcon_load_style'] );
    }


    public function wcon_load_style( $hook ){
        wp_register_style('wcon-style', WCON_PLUGIN_URL . '/assets/css/wcon-style.css', array(), time() );
        if( isset($_GET['page']) && ( $_GET['page'] == 'wcon-settings' || $_GET['page'] == 'wcon-template-settings' ) ){
            wp_enqueue_style('wcon-style');
        }

    }


    public function fields( $args ){
        foreach( $args as $arg ):

            $arg['section'] = isset($arg['section']) && !empty($arg['section']) ? $arg['section'] : 'default';
            if( isset( $arg['id'] ) && isset( $arg['setting'] ) ){
                $input = array();

                $input['id'] = $arg['id'];
                $input['name'] = isset($arg['name']) ? $arg['name'] : $input['id'];
                $input['type'] = isset( $arg['type'] ) ? $arg['type'] : 'input';
                $input['subtype'] = isset( $arg['subtype'] ) ? $arg['subtype'] : 'text';
                $input['required'] = isset( $arg['required'] ) ? $arg['required'] : false;
                $input['options'] = isset( $arg['options'] ) ? $arg['options'] : array();
                $input['attributes'] = isset( $arg['attributes'] ) ? $arg['attributes'] : array();
                $input['default'] = isset( $arg['default'] ) ? $arg['default'] : '';
                $input['description'] = isset( $arg['description'] ) ? $arg['description'] : '';

                add_settings_field(
                    $arg['id'],
                    $arg['title'],
                    array( $this, 'render_fields' ),
                    $arg['setting'],
                    $arg['section'],
                    $input
                );
                register_setting( $arg['setting'], $arg['id'] );
            }
        endforeach;
        
    }

    public function render_fields( $args ){
        $required = ($args['required']) ? 'required' : '';
        $id = $args['id'];
        $name = $args['name'];
        $subtype = $args['subtype'];
        $optionVal = get_option( $name );
        $value = !empty( $optionVal ) ? $optionVal : $args['default'];

        $attributes = '';

        foreach( $args['attributes'] as $key => $val ){
            if( $key != 'class' ){
                $attributes .= " $key='$val'";
            }
        }


        switch ( $args['type'] ) {
            case 'select':
                
                break;
            case 'select':
            
                break;
            
            default:
                echo "<input id='$id' class='wcon-field' type='$subtype' name='$name' value='$value' $attributes $required/>";
                if( $args['description'] ){
                    echo "<p class='description'>{$args['description']}</p>";
                }
                break;
        }
    }

    public function setting_display(){
        echo '';
    }

    abstract public function menu();
    abstract public function register_fields();
}
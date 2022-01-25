<?php 
    global $title; 
?>
<div class="wrap">
    <h1> <?php echo $title; ?></h1>
    <div class="wcon-settings-container"> 
        <form method="POST" action="options.php">  
            <?php 
                settings_fields( 'wcon_general_settings' );
                do_settings_sections( 'wcon_general_settings' ); 
            ?>             
            <?php submit_button(); ?>  
        </form> 
    </div>
</div>
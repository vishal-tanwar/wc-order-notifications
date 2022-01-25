<?php global $title; ?>
<div class="wrap">
    <?php if(isset($_GET['wcon-template']) && !empty($_GET['wcon-template'])): ?>
        <?php 
            $template = $_GET['wcon-template'];
        ?>
        <h2> Edit Template <?php echo $this->smsTemplates()[$template]?></h2>

        <div class="wcon-editor-section">
            <form method="POST" action="options.php">  
                <?php 
                    settings_fields( "wcon_template_{$template}_settings" );
                    do_settings_sections( "wcon_template_{$template}_settings" );
                    
                    $this->editor('Customer SMS Template', $template, 'customer' );
                    $this->editor('Vendor SMS Template', $template, 'vendor' );
                ?>             
                <?php submit_button(); ?>  
            </form> 
        </div>
    <?php else: ?>   
        <h2> Template Settings </h2>

        <div class="wcon-templates">
            <table class="form-table">
                <thead>
                    <tr>
                        <th>SMS Template</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach( $this->smsTemplates() as $slug => $name ):
                            ?>
                                <tr>
                                    <td><?php echo $name; ?></td>
                                    <td> <a href="<?php echo admin_url('admin.php?page=wcon-template-settings&wcon-template=' . $slug ); ?>" class="button wcon-button-manage">Settings</a></td>
                                </tr>
                            <?php
                        endforeach;
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</div>
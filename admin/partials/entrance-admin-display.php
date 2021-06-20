<?php
global $wpdb;
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Entrance
 * @subpackage Entrance/admin/partials
 */
?>
<?php
if(isset($_POST['add_breed'])){
    $breedname = sanitize_text_field( $_POST['add_breed'] );
    if(!$wpdb->get_var("SELECT breed_name FROM {$wpdb->prefix}entrance_breeds WHERE breed_name = '$breedname'")){
        $wpdb->insert($wpdb->prefix.'entrance_breeds',array('breed_name' => $breedname),array('%s'));
    }
}
if(isset($_POST['delete_breed'])){
    if(isset($_POST['breedid'])){
        $breedid = intval( $_POST['breedid'] );
        $wpdb->query("DELETE FROM {$wpdb->prefix}entrance_breeds WHERE ID = $breedid");
    }
}
?>
<div id="entrance_adminview">
    <div class="pagesetup">
        <h3 class="title">Form Setup</h3>
        <hr>
        <form action="options.php" method="post">
            <table class="widefat">
            <?php
            settings_fields( 'entrance_settings_section' );
            do_settings_fields( 'entrance_settings_page', 'entrance_settings_section' );
            ?>
            </table>
            <?php submit_button( 'Save' ); ?>
        </form>
    </div>
    <div class="breeds">
        <h3 class="title">Breeds</h3>
        <hr>
        <div class="add_breed">
            <form action="" method="post">
                <input type="text" name="add_breed" placeholder="Name">
                <button class="button button-secondary">Add</button>
            </form>
        </div>
        <div class="breedstable">
            <table class="widefat">
                <tbody>
                    <?php
                    $breeds = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}entrance_breeds ORDER BY ID DESC");
                    $i = 1;
                    if($breeds){
                        foreach($breeds as $breed){
                        ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                <td> <?php echo $breed->breed_name; ?> </td>
                                <td> 
                                    <form action="" method="post">
                                        <input type="hidden" name="breedid" value="<?php echo $breed->ID; ?>">
                                        <button name="delete_breed" class="button button-danger">Delete</button>
                                    </form> 
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    }else{
                        print_r("<tr><td style='text-align:left'>No breed added!</td></tr>");
                    }
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
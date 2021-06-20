<?php

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
                    for($i =0;$i < 30;$i++){
                        ?>
                        <tr>
                            <td> <?php echo $i; ?> </td>
                            <td> Breed </td>
                            <td> <form action="" method="post"><button class="button button-danger">Delete</button></form> </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
 body{
    background: linear-gradient(1deg, #E22B6E, #FC6266) !important;
 }
 h1.entry-title {
    display: none;
}
</style>
<?php global $wpdb; ?>
<div id="myaccpets">
    <div class="petpopup">
        <div class="popup-contents">
            <span class="closewindow">+</span>
            <h4>Add new</h4>
            <hr>
            <div class="item">
                <!-- Name -->
                <div class="ent-form-g">
                    <input type="text" placeholder="Pet name" name="pet_name" class="ent-petname">
                </div>

                <!-- Age -->
                <div class="ent-form-g">
                    <input type="number" placeholder="Age" name="petage" class="ent-petage">
                </div>
                
                <!-- Birthday -->
                <div class="ent-form-g">
                    <input type="date" placeholder="Birthday" name="birthday" class="ent-birthday">
                </div>
                
                <!-- Breed -->
                <div class="ent-form-g">
                    <select name="breed" id="breed">
                        <option value="-1">Breed</option>
                        <?php
                        $breeds = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}entrance_breeds ORDER BY ID DESC");
                        $i = 1;
                        if($breeds){
                            foreach($breeds as $breed){
                                echo '<option value="b1">'.$breed->breed_name.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <!-- Gender -->
                <div class="ent-form-g">
                    <select name="gender" id="gender">
                        <option value="-1">Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <button class="addpetbtn">Add</button>
        </div>
    </div>
    <div class="pets_list">
        <ul>
        <?php
            global $wpdb,$current_user;
            $pets = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}entrance_pets WHERE user_id = $current_user->ID ORDER BY ID DESC");
            if($pets){
                $i = 1;
                foreach($pets as $pet){
                    ?>
                    <li>
                        <h6 class="petname"><?php echo ucfirst($pet->pet_name) ?></h6>
                        <div class="petdetailsinlist">
                            <span><?php echo strtoupper($pet->pet_gender) ?></span> | 
                            <span><?php echo ucfirst($pet->pet_breed) ?></span> | 
                            <span><?php echo $pet->pet_age ?> Years Old</span>
                        </div>
                    </li>
                    <?php
                }
                echo '<button class="cs addpet">+</button>';
            }else{
                print_r("<button class='cs2 addpet'>Add pets</button>");
            }
        ?>
        </ul>
    </div>
</div>
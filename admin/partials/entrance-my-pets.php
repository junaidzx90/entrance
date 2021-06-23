<?php global $wpdb; ?>
<div id="myaccpets">
    <div class="petpopup">
        <div class="popup-contents">
            <span class="closewindow">+</span>
            <h4>Add new</h4>
            <hr>
            <div class="item">
                <!-- Name -->
                <div class="ent-form-g reg-form-inp">
                    <input type="text" placeholder="Pet name" name="pet_name" class="ent-petname">
                </div>

                <!-- Age -->
                <div class="ent-form-g reg-form-inp">
                    <input type="number" placeholder="Age" name="petage" class="ent-petage">
                </div>
                
                <!-- Birthday -->
                <div class="ent-form-g reg-form-inp">
                    <input type="date" placeholder="Birthday" name="birthday" class="ent-birthday">
                </div>
                
                <!-- Breed -->
                <div class="ent-form-g reg-form-inp">
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
                <div class="ent-form-g reg-form-inp">
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
    <button class="addpet">Add Pet</button>
    <table id="pets-details">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Birthday</th>
                <th>Breed</th>
                <th>Gender</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01</td>
                <td>Noti</td>
                <td>6</td>
                <td>6/3/21</td>
                <td>Demo</td>
                <td>Male</td>
            </tr>
        </tbody>
    </table>
</div>
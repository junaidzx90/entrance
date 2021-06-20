<?php
global $wpdb;
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Entrance
 * @subpackage Entrance/public/partials
 */
?>
<div id="entranse_wrap">
    <div class="entrance_container" <?php echo (is_user_logged_in()?'style="margin-top:32px;"':'') ?> >
        <div class="entrance_content" id="entrance_registration">
           
            <div class="ent-form-contents ent-register-contents">
                <div class="loading">
                    <span class="icon"><i class="fas fa-yin-yang"></i></span>
                </div>
                <div id="form-tabs">
                    <button data-name="yourdetails" class="tbbtn ent-active">
                        <span class="txt">Your Details</span>
                        <span class="icon"><i class="fas fa-info-circle"></i></span>
                    </button>
                    <button data-name="petdetails" class="tbbtn">
                        <span class="txt">Pet Details</span>
                        <span class="icon"><i class="fas fa-dog"></i></span>
                    </button>
                    <button data-name="shippingdetails" class="tbbtn">
                        <span class="txt">Shipping Details</span>
                        <span class="icon"><i class="fas fa-dolly"></i></span>
                    </button>
                </div>
                <div class="ent-header ent-register-header">
                <div class="error-show reg-error">
                <?php
                if(isset($_REQUEST['error'])){
                    echo '<div class="errors">';
                    echo '<p><span class="error-icon">⊘</span>&nbsp;'.ucfirst(str_replace('_',' ',$_REQUEST['error'])).'</p>';
                    echo '</div>';
                }
                ?>
            </div>
                    <p>Login with your social account</p>
                    <div class="sc-loginbtns">
                        <?php echo $this->entrance_social_login('g'); ?>
                        <?php echo $this->entrance_social_login('fb'); ?>
                    </div>
                    <div class="ordecoration">
                        <span class="beforeline"></span>
                        <span class="text">or</span>
                        <span class="afterline"></span>
                    </div>
                </div>

                <div class="ent-body ent-register-body">
                    <form action="" class="entranceform" method="post" id="register-form">
                        
                        <!-- Your details -->
                        <div class="tabs" id="yourdetails" data-section='1'>
                            <div class="fcontent">
                                <!-- Fname -->
                                <div class="ent-form-g reg-form-inp">
                                    <input type="text" placeholder="First Name" name="firstname" class="ent-firstname" value="">
                                </div>
                                <!-- lname -->
                                <div class="ent-form-g reg-form-inp">
                                    <input type="text" placeholder="Last Name" name="lastname" class="ent-lastname" value="">
                                </div>
                            </div>
                            <div class="fcontent">
                                <!-- phone -->
                                <div class="ent-form-g reg-form-inp">
                                    <input type="tel" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="Phone" name="phone" class="ent-phone" value="">
                                </div>
                                <!-- country -->
                                <div class="ent-form-g reg-form-inp">
                                    <select name="country" id="ent-country">
                                        <option value="-1">Country</option>
                                        <option value="Afganistan">Afghanistan</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia">Bolivia</option>
                                        <option value="Bonaire">Bonaire</option>
                                        <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                        <option value="Brunei">Brunei</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Canary Islands">Canary Islands</option>
                                        <option value="Cape Verde">Cape Verde</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Channel Islands">Channel Islands</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos Island">Cocos Island</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Cote DIvoire">Cote DIvoire</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Curaco">Curacao</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="East Timor">East Timor</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands">Falkland Islands</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Ter">French Southern Ter</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Great Britain">Great Britain</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="India">India</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea North">Korea North</option>
                                        <option value="Korea Sout">Korea South</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Macedonia">Macedonia</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Midway Islands">Midway Islands</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Nambia">Nambia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherland Antilles">Netherland Antilles</option>
                                        <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                        <option value="Nevis">Nevis</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau Island">Palau Island</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Phillipines">Philippines</option>
                                        <option value="Pitcairn Island">Pitcairn Island</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Republic of Montenegro">Republic of Montenegro</option>
                                        <option value="Republic of Serbia">Republic of Serbia</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="St Barthelemy">St Barthelemy</option>
                                        <option value="St Eustatius">St Eustatius</option>
                                        <option value="St Helena">St Helena</option>
                                        <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                        <option value="St Lucia">St Lucia</option>
                                        <option value="St Maarten">St Maarten</option>
                                        <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                        <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                        <option value="Saipan">Saipan</option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="Samoa American">Samoa American</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Swaziland">Swaziland</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Tahiti">Tahiti</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Erimates">United Arab Emirates</option>
                                        <option value="United States of America">United States of America</option>
                                        <option value="Uraguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City State">Vatican City State</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                        <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                        <option value="Wake Island">Wake Island</option>
                                        <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zaire">Zaire</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="ent-form-g reg-form-inp">
                                <input type="email" placeholder="Email" name="email" class="ent-email" value="">
                            </div>
                            <!-- Password -->
                            <div class="ent-form-g reg-form-inp">
                                <input type="password" placeholder="Password" name="password" class="ent-password">
                            </div>
                        </div><!-- //Your details -->
                        <!-- Pet details -->
                        <div class="tabs ent-none" id="petdetails" data-section='2'>
                            <span class="pets_breadcrumbs"><span data-id="1" class="badded">First dog</span></span>
                            <div id="petdetailwrap" class="">
                                <div data-id="1" class="item">
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
                            </div>
                            <button class="add_dog">+ Add dog</button>

                        </div><!-- //Pet details -->
                        <!-- Shipping details -->
                        <div class="tabs ent-none" id="shippingdetails" data-section='3'>
                            <!-- Addressline 1 -->
                            <div class="ent-form-g reg-form-inp">
                                <input type="text" placeholder="Address Line 1" name="addr_1" class="ent-addr_1">
                            </div>

                            <!-- Addressline 2 -->
                            <div class="ent-form-g reg-form-inp">
                                <input type="text" placeholder="Address Line 2" name="addr_2" class="ent-addr_2">
                            </div>

                            <!-- Pincode -->
                            <div class="ent-form-g reg-form-inp">
                                <input type="text" placeholder="Pincode" name="pincode" class="ent-pincode">
                            </div>

                            <!-- City -->
                            <div class="ent-form-g reg-form-inp">
                                <input type="text" placeholder="City" name="city" class="ent-city">
                            </div>

                            <!-- Address Type -->
                            <div class="ent-form-g reg-form-inp">
                                <select name="addr_type" id="addr_type">
                                    <option value="-1">Address Type</option>
                                    <option value="present_addr">Present address</option>
                                    <option value="permanent_addr">Permanent address</option>
                                </select>
                            </div>

                            <button class="skipbtn">Skip this step ></button>
                        </div><!-- //Shipping details -->
                        
                        <button data-name="yourdetails" class="next-btn nxtcss" type="submit" name="next_btn">NEXT</button>
                    </form>
                </div>
            </div>
            <div class="ent-already-link">
                <p>Don't have an account? <a href="<?php echo esc_url(get_page_link(get_option('entrance_login_page','#'))) ?>">LOGIN</a></p>
            </div>
        </div>
    </div>
</div>
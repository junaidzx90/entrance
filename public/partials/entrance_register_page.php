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
global $pagebg,$formbg;
?>
<style>
 body{
    background: linear-gradient(1deg, #E22B6E, #FC6266) !important;
 }
</style>
<div id="entranse_wrap">
    <div class="entrance_container" <?php echo (is_user_logged_in()?'style="margin-top:32px;"':'') ?> >
        <div class="entrance_content" id="entrance_registration">
           
            <div class="ent-form-contents ent-register-contents" style="background: <?php echo $formbg; ?> !important">
                <div class="loading">
                    <span class="icon"><i class="fas fa-yin-yang"></i></span>
                </div>
                <div id="form-tabs">
                    <style>
                        .ent-active{
                            background-color: <?php echo $formbg ?> !important;
                        }
                    </style>
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
                    <h1 class="registertitle">Sign up</h1>
                    <div class="error-show reg-error">
                        <?php
                        if(isset($_REQUEST['error'])){
                            echo '<div class="errors">';
                            echo '<p><span class="error-icon">⊘</span>&nbsp;'.ucfirst(str_replace('_',' ',$_REQUEST['error'])).'</p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <!-- <p>Login with your social account</p> -->
                    <!-- <div class="sc-loginbtns">
                        <?php //echo $this->entrance_social_login('g'); ?>
                        <?php //echo $this->entrance_social_login('fb'); ?>
                    </div>
                    <div class="ordecoration">
                        <span class="beforeline"></span>
                        <span class="text">or</span>
                        <span class="afterline"></span>
                    </div> -->
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
                                        <option value="-1">Select Country</option>
                                        <?php 
                                        $countries = array(
                                            'AX' => 'Åland Islands',
                                            'AF' => 'Afghanistan',
                                            'AL' => 'Albania',
                                            'DZ' => 'Algeria',
                                            'AD' => 'Andorra',
                                            'AO' => 'Angola',
                                            'AI' => 'Anguilla',
                                            'AQ' => 'Antarctica',
                                            'AG' => 'Antigua and Barbuda',
                                            'AR' => 'Argentina',
                                            'AM' => 'Armenia',
                                            'AW' => 'Aruba',
                                            'AU' => 'Australia',
                                            'AT' => 'Austria',
                                            'AZ' => 'Azerbaijan',
                                            'BS' => 'Bahamas',
                                            'BH' => 'Bahrain',
                                            'BD' => 'Bangladesh',
                                            'BB' => 'Barbados',
                                            'BY' => 'Belarus',
                                            'PW' => 'Belau',
                                            'BE' => 'Belgium',
                                            'BZ' => 'Belize',
                                            'BJ' => 'Benin',
                                            'BM' => 'Bermuda',
                                            'BT' => 'Bhutan',
                                            'BO' => 'Bolivia',
                                            'BQ' => 'Bonaire, Saint Eustatius and Saba',
                                            'BA' => 'Bosnia and Herzegovina',
                                            'BW' => 'Botswana',
                                            'BV' => 'Bouvet Island',
                                            'BR' => 'Brazil',
                                            'IO' => 'British Indian Ocean Territory',
                                            'VG' => 'British Virgin Islands',
                                            'BN' => 'Brunei',
                                            'BG' => 'Bulgaria',
                                            'BF' => 'Burkina Faso',
                                            'BI' => 'Burundi',
                                            'KH' => 'Cambodia',
                                            'CM' => 'Cameroon',
                                            'CA' => 'Canada',
                                            'CV' => 'Cape Verde',
                                            'KY' => 'Cayman Islands',
                                            'CF' => 'Central African Republic',
                                            'TD' => 'Chad',
                                            'CL' => 'Chile',
                                            'CN' => 'China',
                                            'CX' => 'Christmas Island',
                                            'CC' => 'Cocos (Keeling) Islands',
                                            'CO' => 'Colombia',
                                            'KM' => 'Comoros',
                                            'CG' => 'Congo (Brazzaville)',
                                            'CD' => 'Congo (Kinshasa)',
                                            'CK' => 'Cook Islands',
                                            'CR' => 'Costa Rica',
                                            'HR' => 'Croatia',
                                            'CU' => 'Cuba',
                                            'CW' => 'CuraÇao',
                                            'CY' => 'Cyprus',
                                            'CZ' => 'Czech Republic',
                                            'DK' => 'Denmark',
                                            'DJ' => 'Djibouti',
                                            'DM' => 'Dominica',
                                            'DO' => 'Dominican Republic',
                                            'EC' => 'Ecuador',
                                            'EG' => 'Egypt',
                                            'SV' => 'El Salvador',
                                            'GQ' => 'Equatorial Guinea',
                                            'ER' => 'Eritrea',
                                            'EE' => 'Estonia',
                                            'ET' => 'Ethiopia',
                                            'FK' => 'Falkland Islands',
                                            'FO' => 'Faroe Islands',
                                            'FJ' => 'Fiji',
                                            'FI' => 'Finland',
                                            'FR' => 'France',
                                            'GF' => 'French Guiana',
                                            'PF' => 'French Polynesia',
                                            'TF' => 'French Southern Territories',
                                            'GA' => 'Gabon',
                                            'GM' => 'Gambia',
                                            'GE' => 'Georgia',
                                            'DE' => 'Germany',
                                            'GH' => 'Ghana',
                                            'GI' => 'Gibraltar',
                                            'GR' => 'Greece',
                                            'GL' => 'Greenland',
                                            'GD' => 'Grenada',
                                            'GP' => 'Guadeloupe',
                                            'GT' => 'Guatemala',
                                            'GG' => 'Guernsey',
                                            'GN' => 'Guinea',
                                            'GW' => 'Guinea-Bissau',
                                            'GY' => 'Guyana',
                                            'HT' => 'Haiti',
                                            'HM' => 'Heard Island and McDonald Islands',
                                            'HN' => 'Honduras',
                                            'HK' => 'Hong Kong',
                                            'HU' => 'Hungary',
                                            'IS' => 'Iceland',
                                            'IN' => 'India',
                                            'ID' => 'Indonesia',
                                            'IR' => 'Iran',
                                            'IQ' => 'Iraq',
                                            'IM' => 'Isle of Man',
                                            'IL' => 'Israel',
                                            'IT' => 'Italy',
                                            'CI' => 'Ivory Coast',
                                            'JM' => 'Jamaica',
                                            'JP' => 'Japan',
                                            'JE' => 'Jersey',
                                            'JO' => 'Jordan',
                                            'KZ' => 'Kazakhstan',
                                            'KE' => 'Kenya',
                                            'KI' => 'Kiribati',
                                            'KW' => 'Kuwait',
                                            'KG' => 'Kyrgyzstan',
                                            'LA' => 'Laos',
                                            'LV' => 'Latvia',
                                            'LB' => 'Lebanon',
                                            'LS' => 'Lesotho',
                                            'LR' => 'Liberia',
                                            'LY' => 'Libya',
                                            'LI' => 'Liechtenstein',
                                            'LT' => 'Lithuania',
                                            'LU' => 'Luxembourg',
                                            'MO' => 'Macao S.A.R., China',
                                            'MK' => 'Macedonia',
                                            'MG' => 'Madagascar',
                                            'MW' => 'Malawi',
                                            'MY' => 'Malaysia',
                                            'MV' => 'Maldives',
                                            'ML' => 'Mali',
                                            'MT' => 'Malta',
                                            'MH' => 'Marshall Islands',
                                            'MQ' => 'Martinique',
                                            'MR' => 'Mauritania',
                                            'MU' => 'Mauritius',
                                            'YT' => 'Mayotte',
                                            'MX' => 'Mexico',
                                            'FM' => 'Micronesia',
                                            'MD' => 'Moldova',
                                            'MC' => 'Monaco',
                                            'MN' => 'Mongolia',
                                            'ME' => 'Montenegro',
                                            'MS' => 'Montserrat',
                                            'MA' => 'Morocco',
                                            'MZ' => 'Mozambique',
                                            'MM' => 'Myanmar',
                                            'NA' => 'Namibia',
                                            'NR' => 'Nauru',
                                            'NP' => 'Nepal',
                                            'NL' => 'Netherlands',
                                            'AN' => 'Netherlands Antilles',
                                            'NC' => 'New Caledonia',
                                            'NZ' => 'New Zealand',
                                            'NI' => 'Nicaragua',
                                            'NE' => 'Niger',
                                            'NG' => 'Nigeria',
                                            'NU' => 'Niue',
                                            'NF' => 'Norfolk Island',
                                            'KP' => 'North Korea',
                                            'NO' => 'Norway',
                                            'OM' => 'Oman',
                                            'PK' => 'Pakistan',
                                            'PS' => 'Palestinian Territory',
                                            'PA' => 'Panama',
                                            'PG' => 'Papua New Guinea',
                                            'PY' => 'Paraguay',
                                            'PE' => 'Peru',
                                            'PH' => 'Philippines',
                                            'PN' => 'Pitcairn',
                                            'PL' => 'Poland',
                                            'PT' => 'Portugal',
                                            'QA' => 'Qatar',
                                            'IE' => 'Republic of Ireland',
                                            'RE' => 'Reunion',
                                            'RO' => 'Romania',
                                            'RU' => 'Russia',
                                            'RW' => 'Rwanda',
                                            'ST' => 'São Tomé and Príncipe',
                                            'BL' => 'Saint Barthélemy',
                                            'SH' => 'Saint Helena',
                                            'KN' => 'Saint Kitts and Nevis',
                                            'LC' => 'Saint Lucia',
                                            'SX' => 'Saint Martin (Dutch part)',
                                            'MF' => 'Saint Martin (French part)',
                                            'PM' => 'Saint Pierre and Miquelon',
                                            'VC' => 'Saint Vincent and the Grenadines',
                                            'SM' => 'San Marino',
                                            'SA' => 'Saudi Arabia',
                                            'SN' => 'Senegal',
                                            'RS' => 'Serbia',
                                            'SC' => 'Seychelles',
                                            'SL' => 'Sierra Leone',
                                            'SG' => 'Singapore',
                                            'SK' => 'Slovakia',
                                            'SI' => 'Slovenia',
                                            'SB' => 'Solomon Islands',
                                            'SO' => 'Somalia',
                                            'ZA' => 'South Africa',
                                            'GS' => 'South Georgia/Sandwich Islands',
                                            'KR' => 'South Korea',
                                            'SS' => 'South Sudan',
                                            'ES' => 'Spain',
                                            'LK' => 'Sri Lanka',
                                            'SD' => 'Sudan',
                                            'SR' => 'Suriname',
                                            'SJ' => 'Svalbard and Jan Mayen',
                                            'SZ' => 'Swaziland',
                                            'SE' => 'Sweden',
                                            'CH' => 'Switzerland',
                                            'SY' => 'Syria',
                                            'TW' => 'Taiwan',
                                            'TJ' => 'Tajikistan',
                                            'TZ' => 'Tanzania',
                                            'TH' => 'Thailand',
                                            'TL' => 'Timor-Leste',
                                            'TG' => 'Togo',
                                            'TK' => 'Tokelau',
                                            'TO' => 'Tonga',
                                            'TT' => 'Trinidad and Tobago',
                                            'TN' => 'Tunisia',
                                            'TR' => 'Turkey',
                                            'TM' => 'Turkmenistan',
                                            'TC' => 'Turks and Caicos Islands',
                                            'TV' => 'Tuvalu',
                                            'UG' => 'Uganda',
                                            'UA' => 'Ukraine',
                                            'AE' => 'United Arab Emirates',
                                            'GB' => 'United Kingdom (UK)',
                                            'US' => 'United States (US)',
                                            'UY' => 'Uruguay',
                                            'UZ' => 'Uzbekistan',
                                            'VU' => 'Vanuatu',
                                            'VA' => 'Vatican',
                                            'VE' => 'Venezuela',
                                            'VN' => 'Vietnam',
                                            'WF' => 'Wallis and Futuna',
                                            'EH' => 'Western Sahara',
                                            'WS' => 'Western Samoa',
                                            'YE' => 'Yemen',
                                            'ZM' => 'Zambia',
                                            'ZW' => 'Zimbabwe',
                                        );

                                        foreach($countries as $key => $country){
                                            $selected = '';
                                            if($country == 'India'){
                                                $selected = 'selected';
                                            }
                                            echo '<option '.$selected.' value="'.$key.'">'.$country.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="ent-form-g reg-form-inp">
                                <input id="entemail" type="email" placeholder="Email" name="email" class="ent-email" value="">
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
                                    <span class="delete-item">
                                        <svg id="Layer_1" enable-background="new 0 0 512 512" height="16px" viewBox="0 0 512 512" width="16px" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.467-21.533-48-48-48h-64c-26.467 0-48 21.533-48 48v16h-88c-22.056 0-40 17.944-40 40v56c0 8.836 7.164 16 16 16h8.744l13.823 290.283c1.221 25.636 22.281 45.717 47.945 45.717h242.976c25.665 0 46.725-20.081 47.945-45.717l13.823-290.283h8.744c8.836 0 16-7.164 16-16v-56c0-22.056-17.944-40-40-40zm-216-16c0-8.822 7.178-16 16-16h64c8.822 0 16 7.178 16 16v16h-96zm-128 56c0-4.411 3.589-8 8-8h336c4.411 0 8 3.589 8 8v40c-4.931 0-331.567 0-352 0zm313.469 360.761c-.407 8.545-7.427 15.239-15.981 15.239h-242.976c-8.555 0-15.575-6.694-15.981-15.239l-13.751-288.761h302.44z"/><path d="m256 448c8.836 0 16-7.164 16-16v-208c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16z"/><path d="m336 448c8.836 0 16-7.164 16-16v-208c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16z"/><path d="m176 448c8.836 0 16-7.164 16-16v-208c0-8.836-7.164-16-16-16s-16 7.164-16 16v208c0 8.836 7.163 16 16 16z"/></g></svg>
                                    </span>
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
                <?php
                $url = get_page_link(get_option('entrance_login_page','#'));
                if(isset($_GET['woo'])){
                    $url = get_page_link(get_option('entrance_login_page','#')).'?woo=true';
                }
                ?>
                <p>Already have an account <a href="<?php echo esc_url($url) ?>">login</a></p>
            </div>
        </div>
    </div>
</div>
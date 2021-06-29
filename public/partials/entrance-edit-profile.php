<?php 
global $current_user; 
$user_id = $current_user->ID;

if(isset($_POST['savechanges'])){
    if(!empty($_POST['firstname'])){
        $fname = sanitize_text_field($_POST['firstname']);
        update_user_meta( $user_id, "billing_first_name", $fname );
        update_user_meta( $user_id, "first_name", $fname );
        update_user_meta( $user_id, "shipping_first_name", $fname );
    }
    if(!empty($_POST['lastname'])){
        $lname = sanitize_text_field($_POST['lastname']);
        update_user_meta( $user_id, "billing_last_name", $lname );
        update_user_meta( $user_id, "last_name", $lname );
        update_user_meta( $user_id, "shipping_last_name", $lname );
    }
    if(!empty($_POST['phone'])){
        $phone = sanitize_text_field($_POST['phone']);
        update_user_meta( $user_id, "billing_phone", $phone );
    }
    if(!empty($_POST['country'])){
        $country = sanitize_text_field($_POST['country']);
        update_user_meta( $user_id, "billing_country", $country );
        update_user_meta( $user_id, "shipping_country", Entrance_Public::entrance_get_country_name_by_code($country) );
    }

    if(!empty($_POST['shipmentaddr'])){
        $shipping_addr = sanitize_text_field($_POST['shipmentaddr']);
        update_user_meta( $user_id, "shipping_address_1", $shipping_addr);
        update_user_meta( $user_id, "billing_address_1", $shipping_addr );
    }
}
?>
<style>
 body{
    background: linear-gradient(1deg, #E22B6E, #FC6266) !important;
 }
 h1.entry-title {
    display: none;
}
</style>
<div class="edit-profile">
    <form action="" method="post" id="edit-profileform">
        <div id="edit-profile-data" data-section='1'>
            <div class="fcontent">
                <!-- Fname -->
                <div class="ent-form-g">
                    <input type="text" placeholder="First Name" name="firstname" class="ent-firstname" value="<?php echo get_user_meta($current_user->ID,'shipping_first_name',true); ?>">
                </div>
                <!-- phone -->
                <div class="ent-form-g">
                    <input type="tel" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" placeholder="Phone" name="phone" class="ent-phone" value="<?php echo get_user_meta($current_user->ID,'billing_phone',true); ?>">
                </div>
            </div>
            <div class="fcontent">
                <!-- lname -->
                <div class="ent-form-g">
                    <input type="text" placeholder="Last Name" name="lastname" class="ent-lastname" value="<?php echo get_user_meta($current_user->ID,'shipping_last_name',true); ?>">
                </div>
                
                <!-- country -->
                <div class="ent-form-g">
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
                            if(get_user_meta($current_user->ID,'shipping_country', true) == $country){
                                $selected = 'selected';
                            }
                            echo '<option '.$selected.' value="'.$key.'">'.$country.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- Email -->
        <div class="ent-form-g">
            <input id="entemail" readonly type="email" placeholder="Email" name="email" class="ent-email" value="<?php echo get_user_by( 'ID', $current_user->ID )->user_email; ?>">
        </div>
        <!-- Shipping address -->
        <div class="ent-form-g shippingaddr">
            <input type="text" placeholder="Shipping address" name="shipmentaddr" class="ent-shipmentaddr" value="<?php echo get_user_meta($current_user->ID,'shipping_address_1',true); ?>">
            <!-- <textarea data-role="none" placeholder="Shipping address" name="shippingaddr" class="ent-shippingaddr"></textarea> -->
        </div>

        <button name="savechanges" class="saveedit">Save Changes</button>
    </form>
</div>
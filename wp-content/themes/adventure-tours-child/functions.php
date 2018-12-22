<?php                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           function filter_adventure_tours_get_theme_styles( $default_set ) 
{
  $default_set['child-style'] = get_stylesheet_uri();
  return $default_set;
}
add_action( 'wp_head', 'adventure_tours_render_header_share_meta' );
add_filter( 'get-theme-styles', 'filter_adventure_tours_get_theme_styles' );
add_filter( 'wp_nav_menu_items', 'add_login_logout_link', 10, 2 ); 
function add_login_logout_link( $items, $args ) {
  if (is_user_logged_in()) 
  {
         $items .= '<li id="menu-item-2385" class="menu-item menu-item-type-post_type menu-item-object-post 
                            menu-item-has-children menu-item-2385"><a href="https://roamingclan.com/refer-and-save/">My Account</a>
                      <ul class="sub-menu">
                        <li id="menu-item-1702" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1702">
                         <a href="'.wp_logout_url( home_url() ).'" title="Logout">Logout</a>
                        </li>
                      </ul>
                    </li>';
  } 
  else {
         $items .= '<li class="right"><a href="https://roamingclan.com/login-roaming-clan-account/">'. __("Log In") .'</a></li>';
      }
   return $items;
}
?>
<?php
/**
* Add new register fields for WooCommerce registration.
*
* @return string Register fields HTML.
*/

function wooc_extra_register_fields() {
?>
<div class="flx">
  <p class="form-row form-row-first box">
     
     <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" placeholder="First Name*" required />
  </p>
  <p class="form-row form-row-last">

      <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" 
placeholder="Last Name*" required />
  </p>
  <div class="clear"></div>
</div>
<?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
?>

<?php
/**
* Save the extra register fields.
*
* @paramint $customer_id Current customer ID.
*
* @return void
*/
function wooc_save_extra_register_fields( $customer_id ) {
if ( isset( $_POST['billing_first_name'] ) ) 
{
    update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
}
if ( isset( $_POST['billing_last_name'] ) )    
{
    // WordPress default last name field.
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    // WooCommerce billing last name.
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
}
if ( isset( $_POST['billing_phone'] ) ) 
{
// WooCommerce billing phone
    update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );

}
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

add_action( 'woocommerce_edit_account_form', 'my_woocommerce_edit_account_form' );
add_action( 'woocommerce_save_account_details', 'my_woocommerce_save_account_details' );
 
function my_woocommerce_edit_account_form() {
 
  $user_id = get_current_user_id();
  $user = get_userdata( $user_id );
 
  if ( !$user )
    return;
 
  $twitter = get_user_meta( $user_id, 'twitter', true );
  $url = $user->user_url;
  $billing_phone = get_user_meta( $user_id, 'billing_phone', true );
  $gender = get_user_meta( $user_id, 'gender', true );
  $description = get_user_meta( $user_id, 'description', true );
  $visited = get_user_meta( $user_id, 'visited', true);
  $Unvisited = get_user_meta( $user_id, 'Unvisited', true);
  $bday= get_user_meta( $user_id, 'bday', true)

 
  ?>
 
  <fieldset>
    <legend>Additional information</legend>
    
  </fieldset> 
 
  <fieldset>
    <p class="form-row form-row-thirds">
      <label for="phone">Phone Number:</label>
      <input type="text" name="billing_phone" value="<?php echo esc_attr( $billing_phone ); ?>" class="input-text" />
    </p>
  </fieldset> 

  <fieldset>
    <p class="form-row form-row-thirds">
      <label for="BirthDate">Birth Date:</label>
      <input type="date" name="bday" value="<?php echo esc_attr( $bday ); ?>" class="input-text" />
    </p>
  </fieldset> 

  <fieldset>
    <p class="form-row form-row-thirds">
      <label for="Gender">Gender:</label>
      <input type="text" name="gender" value="<?php echo esc_attr( $gender ); ?>" class="input-text" />
       <input type="radio" name="gender" value="male"> Male<br>
       <input type="radio" name="gender" value="female"> Female<br>
    </p>
  </fieldset> 

  <fieldset>
    <p class="form-row form-row-thirds">
      <label for="About Me">About Me:</label>

      <textarea rows="4" cols="50" name="description" class="input-text">
<?php echo htmlspecialchars($description); ?>
</textarea>
    </p>
  </fieldset> 

  <fieldset>
    <p class="form-row form-row-thirds">
      <label for="city">Select Countries You Have visited:</label>

        <select name="visited[]" multiple>
                                      <option value="Aland Islands">Aland Islands</option>
                                      <option value="Afghanistan">Afghanistan</option>
                                      <option value="Albania">Albania</option>
                                      <option value="Algeria">Algeria</option>
                                       <option value="American Samoa">American Samoa</option>
                                      <option value="Andorra">Andorra</option>
                                      <option value="Angola">Angola</option>
                                      <option value="Anguilla">Anguilla</option>
                                      <option value="Antarctica">Antarctica</option>
                                      <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                      <option value="Argentina">Argentina</option>
                                      <option value="Armenia">Armenia</option>
                                      <option value="Aruba">Aruba</option>
                                      <option value="Australia">Australia</option>
                                      <option value="Austria">Austria</option>
                                      <option value="Azerbaijan">Azerbaijan</option>
                                      <option value="Bahamas">Bahamas</option>
                                      <option value="Bahamas">Bahrain</option>
                                      <option value="Bangladesh">Bangladesh</option>
                                      <option value="Barbados">Barbados</option>
                                      <option value="Belarus">Belarus</option>
                                      <option value="Belgium">Belau</option>
                                      <option value="Belgium">Belgium</option>
                                      <option value="Belize">Belize</option>
                                      <option value="Benin">Benin</option>
                                      <option value="Bermuda">Bermuda</option>
                                      <option value="Bhutan">Bhutan</option>
                                      <option value="Bolivia">Bolivia</option>
                                      <option value="Bonaire, Saint Eustatius and Saba">Bonaire, Saint Eustatius and Saba</option>
                                      <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                      <option value="Botswana">Botswana</option>
                                      <option value="Bouvet Island">Bouvet Island</option>
                                      <option value="Brazil">Brazil</option>
                                      
                                      <option value="Brunei">Brunei</option>
                                      <option value="Bulgaria">Bulgaria</option>
                                      <option value="Burkina Faso">Burkina Faso</option>
                                      <option value="Burundi">Burundi</option>
                                      <option value="Cambodia">Cambodia</option>
                                      <option value="Cameroon">Cameroon</option>
                                      <option value="Canada">Canada</option>
                                      <option value="Cape Verde">Cape Verde</option>
                                      <option value="Cayman Islands">Cayman Islands</option>
                                      <option value="Central African Republic">Central African Republic</option>
                                      <option value="Chad">Chad</option>
                                      <option value="Chile">Chile</option>
                                      <option value="China">China</option>
                                      <option value="Christmas Island">Christmas Island</option>
                                      <option value="Cocos_(Keeling) Islands">Cocos (Keeling) Islands</option>
                                      <option value="Colombia">Colombia</option>
                                      <option value="Comoros">Comoros</option>
                                      <option value="Congo_(Brazzaville)">Congo (Brazzaville)</option>
                                      <option value="Congo (Kinshasa)">Congo (Kinshasa)</option>
                                      <option value="Cook Islands">Cook Islands</option>
                                      <option value="Costa Rica">Costa Rica</option>
                                      <option value="Croatia">Croatia</option>
                                      <option value="Cuba">Cuba</option>
                                      <option value="Curaçao">Curaçao</option>
                                      <option value="Cyprus">Cyprus</option>
                                      <option value="Czech Republic">Czech Republic</option>
                                      <option value="Denmark">Denmark</option>
                                      <option value="Djibouti">Djibouti</option>
                                      <option value="Dominica">Dominica</option>
                                      <option value="Dominican Republic">Dominican Republic</option>
                                      <option value="Ecuador">Ecuador</option>
                                      <option value="Egypt">Egypt</option>
                                      <option value="El Salvador">El Salvador</option>
                                      <option value="Equatorial">Equatorial Guinea</option>
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
                                      <option value="French Southern Territories">French Southern Territories</option>
                                      <option value="Gabon">Gabon</option>
                                      <option value="Gambia">Gambia</option>
                                      <option value="Georgia">Georgia</option>
                                      <option value="Germany">Germany</option>
                                      <option value="Ghana">Ghana</option>
                                      <option value="Gibraltar">Gibraltar</option>
                                      <option value="Greece">Greece</option>
                                      <option value="Greenland">Greenland</option>
                                      <option value="Grenada">Grenada</option>
                                      <option value="Guadeloupe">Guadeloupe</option>
                                      <option value="Guam">Guam</option>
                                      <option value="Guatemala">Guatemala</option>
                                      <option value="Guernsey">Guernsey</option>
                                      <option value="Guinea">Guinea</option>
                                      <option value="Guinea-Bissau">Guinea-Bissau</option>
                                      <option value="Guyana">Guyana</option>
                                      <option value="Haiti">Haiti</option>
                                      <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                      <option value="Honduras">Honduras</option>
                                      <option value="Hungary">Hong Kong</option>
                                      <option value="HU">Hungary</option>
                                      <option value="Iceland">Iceland</option>
                                      <option value="India">India</option>
                                      <option value="Indonesia">Indonesia</option>
                                      <option value="Iran">Iran</option>
                                      <option value="Iraq">Iraq</option>
                                      <option value="Ireland">Ireland</option>
                                      <option value="Isle of Man">Isle of Man</option>
                                      <option value="Israel">Israel</option>
                                      <option value="Italy">Italy</option>
                                      <option value="Ivory Coast">Ivory Coast</option>
                                      <option value="Jamaica">Jamaica</option>
                                      <option value="Japan">Japan</option>
                                      <option value="Jersey">Jersey</option>
                                      <option value="Jordan">Jordan</option>
                                      <option value="Kazakhstan">Kazakhstan</option>
                                      <option value="Kenya">Kenya</option>
                                      <option value="Kiribati">Kiribati</option>
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
                                      <option value="Macao S.A.R., China">Macao S.A.R., China</option>
                                      <option value="Macedonia">Macedonia</option>
                                      <option value="Madagascar">Madagascar</option>
                                      <option value="Malawi">Malawi</option>
                                      <option value="Malaysia">Malaysia</option>
                                      <option value="Maldives">Maldives</option>
                                      <option value="Mali">Mali</option>
                                      <option value="Malta">Malta</option>
                                      <option value="Marshall Islands">Marshall Islands</option>
                                      <option value="Martinique">Martinique</option>
                                      <option value="Mauritania">Mauritania</option>
                                      <option value="Mauritius">Mauritius</option>
                                      <option value="Mayotte">Mayotte</option>
                                      <option value="Mexico">Mexico</option>
                                      <option value="Micronesia">Micronesia</option>
                                      <option value="Moldova">Moldova</option>
                                      <option value="Monaco">Monaco</option>
                                      <option value="Mongolia">Mongolia</option>
                                      <option value="Montenegro">Montenegro</option>
                                      <option value="Montserrat">Montserrat</option>
                                      <option value="Morocco">Morocco</option>
                                      <option value="Mozambique">Mozambique</option>
                                      <option value="Myanmar">Myanmar</option>
                                      <option value="Namibia">Namibia</option>
                                      <option value="Nauru">Nauru</option>
                                      <option value="Nepal">Nepal</option>
                                      <option value="Netherlands">Netherlands</option>
                                      <option value="New Caledonia">New Caledonia</option>
                                      <option value="New Zealand">New Zealand</option>
                                      <option value="Nicaragua">Nicaragua</option>
                                      <option value="Niger">Niger</option>
                                      <option value="Nigeria">Nigeria</option>
                                      <option value="Niue">Niue</option>
                                      <option value="Norfolk Island">Norfolk Island</option>
                                      <option value="North Korea">North Korea</option>
                                      <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                      <option value="Norway">Norway</option>
                                      <option value="Oman">Oman</option>
                                      <option value="Pakistan">Pakistan</option>
                                      <option value="Palestinian Territory">Palestinian Territory</option>
                                      <option value="Panama">Panama</option>
                                      <option value="Papua New Guinea">Papua New Guinea</option>
                                      <option value="Paraguay">Paraguay</option>
                                      <option value="Peru">Peru</option>
                                      <option value="Philippines">Philippines</option>
                                      <option value="Pitcairn">Pitcairn</option>
                                      <option value="Poland">Poland</option>
                                      <option value="Portugal">Portugal</option>
                                      <option value="Puerto Rico">Puerto Rico</option>
                                      <option value="Qatar">Qatar</option>
                                      <option value="Reunion">Reunion</option>
                                      <option value="Romania">Romania</option>
                                      <option value="Russia">Russia</option>
                                      <option value="Rwanda">Rwanda</option>
                                      <option value="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                      <option value="Saint Barthélemy">Saint Barthélemy</option>
                                      <option value="Saint Helena">Saint Helena</option>
                                      <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                      <option value="Saint Lucia">Saint Lucia</option>
                                      <option value="Saint Martin (Dutch part)">Saint Martin (Dutch part)</option>
                                      <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                                      <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                      <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                      <option value="Samoa">Samoa</option>
                                      <option value="San Marino">San Marino</option>
                                      <option value="Saudi Arabia">Saudi Arabia</option>
                                      <option value="Senegal">Senegal</option>
                                      <option value="Serbia">Serbia</option>
                                      <option value="Seychelles">Seychelles</option>
                                      <option value="Sierra Leone">Sierra Leone</option>
                                      <option value="Singapore">Singapore</option>
                                      <option value="Slovakia">Slovakia</option>
                                      <option value="Slovenia">Slovenia</option>
                                      <option value="Solomon Islands">Solomon Islands</option>
                                      <option value="Somalia">Somalia</option>
                                      <option value="South Africa">South Africa</option>
                                      <option value="South Georgia/Sandwich Islands">South Georgia/Sandwich Islands</option>
                                      <option value="KR">SouthKorea</option>
                                      <option value="SouthSudan">SouthSudan</option>
                                      <option value="Spain">Spain</option>
                                      <option value="SriLanka">SriLanka</option>
                                      <option value="Sudan">Sudan</option>
                                      <option value="Svalbard and Jan Mayen">Suriname</option>
                                      <option value="SJ">Svalbard and Jan Mayen</option>
                                      <option value="Swaziland">Swaziland</option>
                                      <option value="Sweden">Sweden</option>
                                      <option value="Switzerland">Switzerland</option>
                                      <option value="Syria">Syria</option>
                                      <option value="Taiwan">Taiwan</option>
                                      <option value="Tajikistan">Tajikistan</option>
                                      <option value="Tanzania">Tanzania</option>
                                      <option value="Thailand">Thailand</option>
                                      <option value="Timor-Leste">Timor-Leste</option>
                                      <option value="Togo">Togo</option>
                                      <option value="Tokelau">Tokelau</option>
                                      <option value="Tonga">Tonga</option>
                                      <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                      <option value="Tunisia">Tunisia</option>
                                      <option value="Turkey">Turkey</option>
                                      <option value="Turkmenistan">Turkmenistan</option>
                                    
                                      <option value="Tuvalu">Tuvalu</option>
                                      <option value="Uganda">Uganda</option>
                                      <option value="Ukraine">Ukraine</option>
                                      <option value="United Arab Emirates">United Arab Emirates</option>
                                      <option value="United Kingdom">United Kingdom (UK)</option>
                                      <option value="United States ">United States (US)</option>
                                      <option value="United States (US) Minor Outlying Islands">United States (US) Minor Outlying Islands</option>
                                      <option value="United States (US) Virgin Islands">United States (US) Virgin Islands</option>
                                      <option value="Uruguay">Uruguay</option>
                                      <option value="Uzbekistan">Uzbekistan</option>
                                      <option value="Vanuatu">Vanuatu</option>
                                      <option value="Vatican">Vatican</option>
                                      <option value="Venezuela">Venezuela</option>
                                      <option value="Vietnam">Vietnam</option>
                                      <option value="Wallis and Futuna">Wallis and Futuna</option>
                                      <option value="Western Sahara">Western Sahara</option>
                                      <option value="Yemen">Yemen</option>
                                      <option value="Zambia">Zambia</option>
                                      <option value="Zimbabwe">Zimbabwe</option>   
        </select>
     </p> 
</fieldset> 
<?php 

    /* foreach ($visited as $opt) {
    $sel = '';
    if (in_array($opt, $visited)) {
        $sel = ' selected="selected" ';
    }
    echo '<option ' . $sel . ' value="' . $opt . '">' . $opt . '</option>';
} */
?>
<fieldset>
    <p class="form-row form-row-thirds">
      <label for="city">Select countries you would like to visit:</label>

        <select name="Unvisited[]" multiple>
                                      <option value="Aland Islands">Aland Islands</option>
                                      <option value="Afghanistan">Afghanistan</option>
                                      <option value="Albania">Albania</option>
                                      <option value="Algeria">Algeria</option>
                                       <option value="American Samoa">American Samoa</option>
                                      <option value="Andorra">Andorra</option>
                                      <option value="Angola">Angola</option>
                                      <option value="Anguilla">Anguilla</option>
                                      <option value="Antarctica">Antarctica</option>
                                      <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                      <option value="Argentina">Argentina</option>
                                      <option value="Armenia">Armenia</option>
                                      <option value="Aruba">Aruba</option>
                                      <option value="Australia">Australia</option>
                                      <option value="Austria">Austria</option>
                                      <option value="Azerbaijan">Azerbaijan</option>
                                      <option value="Bahamas">Bahamas</option>
                                      <option value="Bahamas">Bahrain</option>
                                      <option value="Bangladesh">Bangladesh</option>
                                      <option value="Barbados">Barbados</option>
                                      <option value="Belarus">Belarus</option>
                                      <option value="Belgium">Belau</option>
                                      <option value="Belgium">Belgium</option>
                                      <option value="Belize">Belize</option>
                                      <option value="Benin">Benin</option>
                                      <option value="Bermuda">Bermuda</option>
                                      <option value="Bhutan">Bhutan</option>
                                      <option value="Bolivia">Bolivia</option>
                                      <option value="Bonaire, Saint Eustatius and Saba">Bonaire, Saint Eustatius and Saba</option>
                                      <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                      <option value="Botswana">Botswana</option>
                                      <option value="Bouvet Island">Bouvet Island</option>
                                      <option value="Brazil">Brazil</option>
                                      
                                      <option value="Brunei">Brunei</option>
                                      <option value="Bulgaria">Bulgaria</option>
                                      <option value="Burkina Faso">Burkina Faso</option>
                                      <option value="Burundi">Burundi</option>
                                      <option value="Cambodia">Cambodia</option>
                                      <option value="Cameroon">Cameroon</option>
                                      <option value="Canada">Canada</option>
                                      <option value="Cape Verde">Cape Verde</option>
                                      <option value="Cayman Islands">Cayman Islands</option>
                                      <option value="Central African Republic">Central African Republic</option>
                                      <option value="Chad">Chad</option>
                                      <option value="Chile">Chile</option>
                                      <option value="China">China</option>
                                      <option value="Christmas Island">Christmas Island</option>
                                      <option value="Cocos_(Keeling) Islands">Cocos (Keeling) Islands</option>
                                      <option value="Colombia">Colombia</option>
                                      <option value="Comoros">Comoros</option>
                                      <option value="Congo_(Brazzaville)">Congo (Brazzaville)</option>
                                      <option value="Congo (Kinshasa)">Congo (Kinshasa)</option>
                                      <option value="Cook Islands">Cook Islands</option>
                                      <option value="Costa Rica">Costa Rica</option>
                                      <option value="Croatia">Croatia</option>
                                      <option value="Cuba">Cuba</option>
                                      <option value="Curaçao">Curaçao</option>
                                      <option value="Cyprus">Cyprus</option>
                                      <option value="Czech Republic">Czech Republic</option>
                                      <option value="Denmark">Denmark</option>
                                      <option value="Djibouti">Djibouti</option>
                                      <option value="Dominica">Dominica</option>
                                      <option value="Dominican Republic">Dominican Republic</option>
                                      <option value="Ecuador">Ecuador</option>
                                      <option value="Egypt">Egypt</option>
                                      <option value="El Salvador">El Salvador</option>
                                      <option value="Equatorial">Equatorial Guinea</option>
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
                                      <option value="French Southern Territories">French Southern Territories</option>
                                      <option value="Gabon">Gabon</option>
                                      <option value="Gambia">Gambia</option>
                                      <option value="Georgia">Georgia</option>
                                      <option value="Germany">Germany</option>
                                      <option value="Ghana">Ghana</option>
                                      <option value="Gibraltar">Gibraltar</option>
                                      <option value="Greece">Greece</option>
                                      <option value="Greenland">Greenland</option>
                                      <option value="Grenada">Grenada</option>
                                      <option value="Guadeloupe">Guadeloupe</option>
                                      <option value="Guam">Guam</option>
                                      <option value="Guatemala">Guatemala</option>
                                      <option value="Guernsey">Guernsey</option>
                                      <option value="Guinea">Guinea</option>
                                      <option value="Guinea-Bissau">Guinea-Bissau</option>
                                      <option value="Guyana">Guyana</option>
                                      <option value="Haiti">Haiti</option>
                                      <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                      <option value="Honduras">Honduras</option>
                                      <option value="Hungary">Hong Kong</option>
                                      <option value="HU">Hungary</option>
                                      <option value="Iceland">Iceland</option>
                                      <option value="India">India</option>
                                      <option value="Indonesia">Indonesia</option>
                                      <option value="Iran">Iran</option>
                                      <option value="Iraq">Iraq</option>
                                      <option value="Ireland">Ireland</option>
                                      <option value="Isle of Man">Isle of Man</option>
                                      <option value="Israel">Israel</option>
                                      <option value="Italy">Italy</option>
                                      <option value="Ivory Coast">Ivory Coast</option>
                                      <option value="Jamaica">Jamaica</option>
                                      <option value="Japan">Japan</option>
                                      <option value="Jersey">Jersey</option>
                                      <option value="Jordan">Jordan</option>
                                      <option value="Kazakhstan">Kazakhstan</option>
                                      <option value="Kenya">Kenya</option>
                                      <option value="Kiribati">Kiribati</option>
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
                                      <option value="Macao S.A.R., China">Macao S.A.R., China</option>
                                      <option value="Macedonia">Macedonia</option>
                                      <option value="Madagascar">Madagascar</option>
                                      <option value="Malawi">Malawi</option>
                                      <option value="Malaysia">Malaysia</option>
                                      <option value="Maldives">Maldives</option>
                                      <option value="Mali">Mali</option>
                                      <option value="Malta">Malta</option>
                                      <option value="Marshall Islands">Marshall Islands</option>
                                      <option value="Martinique">Martinique</option>
                                      <option value="Mauritania">Mauritania</option>
                                      <option value="Mauritius">Mauritius</option>
                                      <option value="Mayotte">Mayotte</option>
                                      <option value="Mexico">Mexico</option>
                                      <option value="Micronesia">Micronesia</option>
                                      <option value="Moldova">Moldova</option>
                                      <option value="Monaco">Monaco</option>
                                      <option value="Mongolia">Mongolia</option>
                                      <option value="Montenegro">Montenegro</option>
                                      <option value="Montserrat">Montserrat</option>
                                      <option value="Morocco">Morocco</option>
                                      <option value="Mozambique">Mozambique</option>
                                      <option value="Myanmar">Myanmar</option>
                                      <option value="Namibia">Namibia</option>
                                      <option value="Nauru">Nauru</option>
                                      <option value="Nepal">Nepal</option>
                                      <option value="Netherlands">Netherlands</option>
                                      <option value="New Caledonia">New Caledonia</option>
                                      <option value="New Zealand">New Zealand</option>
                                      <option value="Nicaragua">Nicaragua</option>
                                      <option value="Niger">Niger</option>
                                      <option value="Nigeria">Nigeria</option>
                                      <option value="Niue">Niue</option>
                                      <option value="Norfolk Island">Norfolk Island</option>
                                      <option value="North Korea">North Korea</option>
                                      <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                      <option value="Norway">Norway</option>
                                      <option value="Oman">Oman</option>
                                      <option value="Pakistan">Pakistan</option>
                                      <option value="Palestinian Territory">Palestinian Territory</option>
                                      <option value="Panama">Panama</option>
                                      <option value="Papua New Guinea">Papua New Guinea</option>
                                      <option value="Paraguay">Paraguay</option>
                                      <option value="Peru">Peru</option>
                                      <option value="Philippines">Philippines</option>
                                      <option value="Pitcairn">Pitcairn</option>
                                      <option value="Poland">Poland</option>
                                      <option value="Portugal">Portugal</option>
                                      <option value="Puerto Rico">Puerto Rico</option>
                                      <option value="Qatar">Qatar</option>
                                      <option value="Reunion">Reunion</option>
                                      <option value="Romania">Romania</option>
                                      <option value="Russia">Russia</option>
                                      <option value="Rwanda">Rwanda</option>
                                      <option value="São Tomé and Príncipe">São Tomé and Príncipe</option>
                                      <option value="Saint Barthélemy">Saint Barthélemy</option>
                                      <option value="Saint Helena">Saint Helena</option>
                                      <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                      <option value="Saint Lucia">Saint Lucia</option>
                                      <option value="Saint Martin (Dutch part)">Saint Martin (Dutch part)</option>
                                      <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                                      <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                      <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                      <option value="Samoa">Samoa</option>
                                      <option value="San Marino">San Marino</option>
                                      <option value="Saudi Arabia">Saudi Arabia</option>
                                      <option value="Senegal">Senegal</option>
                                      <option value="Serbia">Serbia</option>
                                      <option value="Seychelles">Seychelles</option>
                                      <option value="Sierra Leone">Sierra Leone</option>
                                      <option value="Singapore">Singapore</option>
                                      <option value="Slovakia">Slovakia</option>
                                      <option value="Slovenia">Slovenia</option>
                                      <option value="Solomon Islands">Solomon Islands</option>
                                      <option value="Somalia">Somalia</option>
                                      <option value="South Africa">South Africa</option>
                                      <option value="South Georgia/Sandwich Islands">South Georgia/Sandwich Islands</option>
                                      <option value="KR">SouthKorea</option>
                                      <option value="SouthSudan">SouthSudan</option>
                                      <option value="Spain">Spain</option>
                                      <option value="SriLanka">SriLanka</option>
                                      <option value="Sudan">Sudan</option>
                                      <option value="Svalbard and Jan Mayen">Suriname</option>
                                      <option value="SJ">Svalbard and Jan Mayen</option>
                                      <option value="Swaziland">Swaziland</option>
                                      <option value="Sweden">Sweden</option>
                                      <option value="Switzerland">Switzerland</option>
                                      <option value="Syria">Syria</option>
                                      <option value="Taiwan">Taiwan</option>
                                      <option value="Tajikistan">Tajikistan</option>
                                      <option value="Tanzania">Tanzania</option>
                                      <option value="Thailand">Thailand</option>
                                      <option value="Timor-Leste">Timor-Leste</option>
                                      <option value="Togo">Togo</option>
                                      <option value="Tokelau">Tokelau</option>
                                      <option value="Tonga">Tonga</option>
                                      <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                      <option value="Tunisia">Tunisia</option>
                                      <option value="Turkey">Turkey</option>
                                      <option value="Turkmenistan">Turkmenistan</option>
                                    
                                      <option value="Tuvalu">Tuvalu</option>
                                      <option value="Uganda">Uganda</option>
                                      <option value="Ukraine">Ukraine</option>
                                      <option value="United Arab Emirates">United Arab Emirates</option>
                                      <option value="United Kingdom">United Kingdom (UK)</option>
                                      <option value="United States ">United States (US)</option>
                                      <option value="United States (US) Minor Outlying Islands">United States (US) Minor Outlying Islands</option>
                                      <option value="United States (US) Virgin Islands">United States (US) Virgin Islands</option>
                                      <option value="Uruguay">Uruguay</option>
                                      <option value="Uzbekistan">Uzbekistan</option>
                                      <option value="Vanuatu">Vanuatu</option>
                                      <option value="Vatican">Vatican</option>
                                      <option value="Venezuela">Venezuela</option>
                                      <option value="Vietnam">Vietnam</option>
                                      <option value="Wallis and Futuna">Wallis and Futuna</option>
                                      <option value="Western Sahara">Western Sahara</option>
                                      <option value="Yemen">Yemen</option>
                                      <option value="Zambia">Zambia</option>
                                      <option value="Zimbabwe">Zimbabwe</option>   
        </select>
     </p> 
</fieldset> 

<?php 
    
  /*  foreach ($Unvisited as $opt) {
    $sel = '';
    if (in_array($opt, $Unvisited)) {
        $sel = ' selected="selected" ';
    }
    echo '<option ' . $sel . ' value="' . $opt . '">' . $opt . '</option>';
} */
?>
<?php
}
function my_woocommerce_save_account_details( $user_id ) 
{
 
  update_user_meta( $user_id, 'twitter', htmlentities( $_POST[ 'twitter' ] ) );
  update_user_meta( $user_id, 'billing_phone', htmlentities( $_POST[ 'billing_phone' ] ) );
  update_user_meta( $user_id, 'gender', htmlentities( $_POST[ 'gender' ] ) );
  update_user_meta( $user_id, 'description', htmlentities( $_POST[ 'description' ] ) );
  update_user_meta( $user_id, 'bday', htmlentities( $_POST[ 'bday' ] ) );
  update_user_meta( $user_id, 'visited', $_POST['visited'] );
  update_user_meta( $user_id, 'Unvisited', $_POST['Unvisited']);

  $user = wp_update_user( array( 'ID' => $user_id, 'user_url' => esc_url( $_POST[ 'url' ] ) ) );
}
?>
<?php
add_filter ( 'woocommerce_account_menu_items', 'upcoming_trips' );
function upcoming_trips( $menu_links ){
 
  // we will hook "anyuniquetext123" later
  $new = array( 'upcoming_trips' => 'Upcoming Trips' );
 
  // array_slice() is good when you want to add an element between the other ones
  $menu_links = array_slice( $menu_links, 0, 1, true ) 
  + $new 
  + array_slice( $menu_links, 1, NULL, true );
  return $menu_links;
}
add_filter( 'woocommerce_get_endpoint_url', 'upcoming_trips_hook', 10, 4 );
function upcoming_trips_hook( $url_trips, $endpoint, $value, $permalink ){
 
  if( $endpoint === 'upcoming_trips' ) {
    // ok, here is the place for your custom URL, it could be external
    $url_trips = "http://roamingclan.com/upcomeing-trips/";
  }
  return $url_trips;
}
?>
<?php
add_filter ( 'woocommerce_account_menu_items', 'your_travel_blog' );
function your_travel_blog( $menu_links ){
 
  // we will hook "anyuniquetext123" later
  $new = array( 'your_travel_blog' => 'Your Travel Blog' );
 
  // array_slice() is good when you want to add an element between the other ones
  $menu_links = array_slice( $menu_links, 0, 1, true ) 
  + $new 
  + array_slice( $menu_links, 1, NULL, true );
  return $menu_links;
}
add_filter( 'woocommerce_get_endpoint_url', 'your_travel_blog_hook', 10, 4 );
function your_travel_blog_hook( $url, $endpoint, $value, $permalink ){
 
  if( $endpoint === 'your_travel_blog' ) {
    // ok, here is the place for your custom URL, it could be external
    $url = "https://roamingclan.com/your-travel-blog/";
  }
  return $url;
}
?>

<?php
add_filter ( 'woocommerce_account_menu_items', 'Refer_and_save' );
function Refer_and_save( $menu_links ){
 
  // we will hook "anyuniquetext123" later
  $new = array( 'Refer_and_save' => 'Refer And Save' );
 
  // array_slice() is good when you want to add an element between the other ones
  $menu_links = array_slice( $menu_links, 0, 1, true ) 
  + $new 
  + array_slice( $menu_links, 1, NULL, true );
  return $menu_links;
}
add_filter( 'woocommerce_get_endpoint_url', 'Refer_and_save_hook', 10, 4 );
function Refer_and_save_hook( $url, $endpoint, $value, $permalink ){
 
  if( $endpoint === 'Refer_and_save' ) {
    // ok, here is the place for your custom URL, it could be external
    $url = "https://roamingclan.com/refer-and-save/";
  }
  return $url;
}
?>

<?php
add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
function misha_remove_my_account_links( $menu_links ){
 
	//unset( $menu_links['edit-address'] ); // Addresses
  unset( $menu_links['dashboard'] ); // Dashboard
	//unset( $menu_links['payment-methods'] ); // Payment Methods
	//unset( $menu_links['orders'] ); // Orders
	//unset( $menu_links['downloads'] ); // Downloads
        //unset( $menu_links['Refer a Friend'] ); // Logout
        //unset( $menu_links['edit-account'] ); // Account details
unset( $menu_links['customer-logout'] ); // Logout
 
	return $menu_links;
 
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
 
function custom_override_checkout_fields( $fields ) {
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    return $fields;
}

function post_published_notification( $ID, $post ) {
    
   $blogusers = get_users( 'role=subscriber' );
   // Array of WP_User objects.
   foreach ( $blogusers as $user ) {
   //print_r($user->user_email);

    $email = $user->user_email;
    $title = $post->post_title;
    $permalink = get_permalink( $ID );
    $edit = get_edit_post_link( $ID, '' );
    $to[] = sprintf( '%s <%s>', $name, $email );
    $subject = sprintf( 'Published: %s', $title );
    $message = sprintf ('Your New Tour has been published. Check in Below Link' . "\n\n", $name, $title );
    $message .= sprintf( 'View: %s', $permalink );
    $headers[] = '';
    
  }
  wp_mail( $to, $subject, $message, $headers );
}
add_action( 'publish_post', 'post_published_notification', 10, 2 );
?>
<?php 
add_filter('woocommerce_registration_redirect', 'bryce_wc_register_redirect');
function bryce_wc_register_redirect( $redirect ) {
     $redirect = 'https://roamingclan.com/roamingclan-my-account/edit-account/';
     return $redirect;
}

add_filter('woocommerce_login_redirect', 'wc_login_redirect');
 
function wc_login_redirect( $redirect_to ) {
     $redirect_to = 'https://roamingclan.com/roamingclan-my-account/edit-account/';
     return $redirect_to;
}
?>
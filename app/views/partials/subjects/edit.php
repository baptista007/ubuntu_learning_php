
<?php
$comp_model = new SharedController;
$data = $this->view_data;

//$rec_id = $data['__tableprimarykey'];
$page_id = Router :: $page_id;

$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;

?>

<section class="page">
    
    <?php
    if( $show_header == true ){
    ?>
    
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            
            <div class="row ">
                
                <div class="col-lg-9 comp-grid">
                    <h3 class="record-title"><?php print_lang('edit_clients'); ?></h3>
                    
                </div>
                <div class="col-xs-3 comp-grid">
                    <button class="btn btn-block btn-primary" onclick="javascript:history.go(-1)">
                        <i class="fa fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    }
    ?>
    
    <div  class="">
        <div class="container-fluid">
            
            <div class="row ">
                
                <div class="col-md-7 comp-grid">
                    
                    <?php $this :: display_page_errors(); ?>
                    
                    <div  class="card animated fadeIn">
                        <form role="form" enctype="multipart/form-data"  class="form form-horizontal needs-validation" novalidate action="<?php print_link("clients/edit/$page_id"); ?>" method="post">
                            <div class="card-body">
                                
                                
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="name">Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input  id="name" value="<?php  echo $data['name']; ?>" type="text" placeholder="<?php print_lang('enter_name'); ?>"  required="" name="name" class="form-control " />
                                                    
                                                    
                                                    
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="main_contact_id"><?php print_lang('main_contact'); ?> <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <select required=""  name="main_contact_id" placeholder="<?php print_lang('select_a_value_'); ?>"    class="form-control">
                                                        <option selected><?php echo $data['main_contact_id']; ?></option>
                                                        
                                                        <?php
                                                        $rec = $data['main_contact_id'];
                                                        $main_contact_id_options = $comp_model -> clients_main_contact_id_option_list();
                                                        if(!empty($main_contact_id_options)){
                                                        foreach($main_contact_id_options as $arr){
                                                        $val=array_values($arr);
                                                        $selected = ( $val[0] == $rec ? 'checked' : null ) ;
                                                        ?>
                                                        <option <?php echo $selected; ?> value="<?php echo $val[0]; ?>"><?php echo (!empty($val[1]) ? $val[1] : $val[0]); ?></option>
                                                        <?php
                                                        }
                                                        }
                                                        ?>
                                                        
                                                    </select> 
                                                    
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="phone">Telephone <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input  id="phone" value="<?php  echo $data['phone']; ?>" type="text" placeholder="<?php print_lang('enter_phone'); ?>"  required="" name="phone" class="form-control " />
                                                        
                                                        
                                                        
                                                    </div>
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="mobile">Mobile <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input  id="mobile" value="<?php  echo $data['mobile']; ?>" type="text" placeholder="<?php print_lang('enter_mobile'); ?>"  required="" name="mobile" class="form-control " />
                                                            
                                                            
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="address">Address <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input  id="address" value="<?php  echo $data['address']; ?>" type="text" placeholder="<?php print_lang('enter_address'); ?>"  required="" name="address" class="form-control " />
                                                                
                                                                
                                                                
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="city">City <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input  id="city" value="<?php  echo $data['city']; ?>" type="text" placeholder="<?php print_lang('enter_city'); ?>"  required="" name="city" class="form-control " />
                                                                    
                                                                    
                                                                    
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="inactive"><?php print_lang('inactive'); ?> <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <select required=""  name="inactive" placeholder="<?php print_lang('select_a_value_'); ?>"    class="form-control">
                                                                        <option selected><?php echo $data['inactive']; ?></option>
                                                                        
                                                                        <option <?php echo $this->set_field_selected('inactive','Yes') ?> value="Yes">Yes</option>
                                                                        <option <?php echo $this->set_field_selected('inactive','No') ?> value="No">No</option>         
                                                                    </select> 
                                                                    
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="website"><?php print_lang('website'); ?> <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input  id="website" value="<?php  echo $data['website']; ?>" type="text" placeholder="<?php print_lang('enter_website'); ?>"  required="" name="website" class="form-control " />
                                                                        
                                                                        
                                                                        
                                                                    </div>
                                                                    
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="country"><?php print_lang('country'); ?> <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input  id="country" value="<?php  echo $data['country']; ?>" type="text" placeholder="<?php print_lang('enter_country'); ?>" list="country_list"  required="" name="country" class="form-control " />
                                                                            
                                                                            <datalist id="country_list">
                                                                                <option>Afghanistan,</option>
                                                                                <option>Aland Islands</option>
                                                                                <option>Albania</option>
                                                                                <option>Algeria</option>
                                                                                <option>American Samoa</option>
                                                                                <option>AndorrA</option>
                                                                                <option>Angola</option>
                                                                                <option>Anguilla</option>
                                                                                <option>Antarctica</option>
                                                                                <option>Antigua and Barbuda</option>
                                                                                <option>Argentina</option>
                                                                                <option>Armenia</option>
                                                                                <option>Aruba</option>
                                                                                <option>Australia</option>
                                                                                <option>Austria</option>
                                                                                <option>Azerbaijan</option>
                                                                                <option>Bahamas</option>
                                                                                <option>Bahrain</option>
                                                                                <option>Bangladesh</option>
                                                                                <option>Barbados</option>
                                                                                <option>Belarus</option>
                                                                                <option>Belgium</option>
                                                                                <option>Belize</option>
                                                                                <option>Benin</option>
                                                                                <option>Bermuda</option>
                                                                                <option>Bhutan</option>
                                                                                <option>Bolivia</option>
                                                                                <option>Bosnia and Herzegovina</option>
                                                                                <option>Botswana</option>
                                                                                <option>Bouvet Island</option>
                                                                                <option>Brazil</option>
                                                                                <option>British Indian Ocean Territory</option>
                                                                                <option>Brunei Darussalam</option>
                                                                                <option>Bulgaria</option>
                                                                                <option>Burkina Faso</option>
                                                                                <option>Burundi</option>
                                                                                <option>Cambodia</option>
                                                                                <option>Cameroon</option>
                                                                                <option>Canada</option>
                                                                                <option>Cape Verde</option>
                                                                                <option>Cayman Islands</option>
                                                                                <option>Central African Republic</option>
                                                                                <option>Chad</option>
                                                                                <option>Chile</option>
                                                                                <option>China</option>
                                                                                <option>Christmas Island</option>
                                                                                <option>Cocos (Keeling) Islands</option>
                                                                                <option>Colombia</option>
                                                                                <option>Comoros</option>
                                                                                <option>Congo</option>
                                                                                <option>Cook Islands</option>
                                                                                <option>Costa Rica</option>
                                                                                <option>Cote D'Ivoire</option>
                                                                                <option>Croatia</option>
                                                                                <option>Cuba</option>
                                                                                <option>Cyprus</option>
                                                                                <option>Czech Republic</option>
                                                                                <option>Denmark</option>
                                                                                <option>Djibouti</option>
                                                                                <option>Dominica</option>
                                                                                <option>Dominican Republic</option>
                                                                                <option>Ecuador</option>
                                                                                <option>Egypt</option>
                                                                                <option>El Salvador</option>
                                                                                <option>Equatorial Guinea</option>
                                                                                <option>Eritrea</option>
                                                                                <option>Estonia</option>
                                                                                <option>Ethiopia</option>
                                                                                <option>Falkland Islands (Malvinas)</option>
                                                                                <option>Faroe Islands</option>
                                                                                <option>Fiji</option>
                                                                                <option>Finland</option>
                                                                                <option>France</option>
                                                                                <option>French Guiana</option>
                                                                                <option>French Polynesia</option>
                                                                                <option>French Southern Territories</option>
                                                                                <option>Gabon</option>
                                                                                <option>Gambia</option>
                                                                                <option>Georgia</option>
                                                                                <option>Germany</option>
                                                                                <option>Ghana</option>
                                                                                <option>Gibraltar</option>
                                                                                <option>Greece</option>
                                                                                <option>Greenland</option>
                                                                                <option>Grenada</option>
                                                                                <option>Guadeloupe</option>
                                                                                <option>Guam</option>
                                                                                <option>Guatemala</option>
                                                                                <option>Guernsey</option>
                                                                                <option>Guinea</option>
                                                                                <option>Guinea-Bissau</option>
                                                                                <option>Guyana</option>
                                                                                <option>Haiti</option>
                                                                                <option>Heard Island and Mcdonald Islands</option>
                                                                                <option>Holy See (Vatican City State)</option>
                                                                                <option>Honduras</option>
                                                                                <option>Hong Kong</option>
                                                                                <option>Hungary</option>
                                                                                <option>Iceland</option>
                                                                                <option>India</option>
                                                                                <option>Indonesia</option>
                                                                                <option>Iran</option>
                                                                                <option>Iraq</option>
                                                                                <option>Ireland</option>
                                                                                <option>Isle of Man</option>
                                                                                <option>Israel</option>
                                                                                <option>Italy</option>
                                                                                <option>Jamaica</option>
                                                                                <option>Japan</option>
                                                                                <option>Jersey</option>
                                                                                <option>Jordan</option>
                                                                                <option>Kazakhstan</option>
                                                                                <option>Kenya</option>
                                                                                <option>Kiribati</option>
                                                                                <option>Korea</option>
                                                                                <option>Kuwait</option>
                                                                                <option>Kyrgyzstan</option>
                                                                                <option>Lao People's Democratic Republic</option>
                                                                                <option>Latvia</option>
                                                                                <option>Lebanon</option>
                                                                                <option>Lesotho</option>
                                                                                <option>Liberia</option>
                                                                                <option>Libyan Arab Jamahiriya</option>
                                                                                <option>Liechtenstein</option>
                                                                                <option>Lithuania</option>
                                                                                <option>Luxembourg</option>
                                                                                <option>Macao</option>
                                                                                <option>Macedonia</option>
                                                                                <option>Madagascar</option>
                                                                                <option>Malawi</option>
                                                                                <option>Malaysia</option>
                                                                                <option>Maldives</option>
                                                                                <option>Mali</option>
                                                                                <option>Malta</option>
                                                                                <option>Marshall Islands</option>
                                                                                <option>Martinique</option>
                                                                                <option>Mauritania</option>
                                                                                <option>Mauritius</option>
                                                                                <option>Mayotte</option>
                                                                                <option>Mexico</option>
                                                                                <option>Micronesia</option>
                                                                                <option>Moldova</option>
                                                                                <option>Monaco</option>
                                                                                <option>Mongolia</option>
                                                                                <option>Montserrat</option>
                                                                                <option>Morocco</option>
                                                                                <option>Mozambique</option>
                                                                                <option>Myanmar</option>
                                                                                <option>Namibia</option>
                                                                                <option>Nauru</option>
                                                                                <option>Nepal</option>
                                                                                <option>Netherlands</option>
                                                                                <option>Netherlands Antilles</option>
                                                                                <option>New Caledonia</option>
                                                                                <option>New Zealand</option>
                                                                                <option>Nicaragua</option>
                                                                                <option>Niger</option>
                                                                                <option>Nigeria</option>
                                                                                <option>Niue</option>
                                                                                <option>Norfolk Island</option>
                                                                                <option>Northern Mariana Islands</option>
                                                                                <option>Norway</option>
                                                                                <option>Oman</option>
                                                                                <option>Pakistan</option>
                                                                                <option>Palau</option>
                                                                                <option>Palestinian Territory</option>
                                                                                <option>Panama</option>
                                                                                <option>Papua New Guinea</option>
                                                                                <option>Paraguay</option>
                                                                                <option>Peru</option>
                                                                                <option>Philippines</option>
                                                                                <option>Pitcairn</option>
                                                                                <option>Poland</option>
                                                                                <option>Portugal</option>
                                                                                <option>Puerto Rico</option>
                                                                                <option>Qatar</option>
                                                                                <option>Reunion</option>
                                                                                <option>Romania</option>
                                                                                <option>Russian Federation</option>
                                                                                <option>RWANDA</option>
                                                                                <option>Saint Helena</option>
                                                                                <option>Saint Kitts and Nevis</option>
                                                                                <option>Saint Lucia</option>
                                                                                <option>Saint Pierre and Miquelon</option>
                                                                                <option>Saint Vincent and the Grenadines</option>
                                                                                <option>Samoa</option>
                                                                                <option>San Marino</option>
                                                                                <option>Sao Tome and Principe</option>
                                                                                <option>Saudi Arabia</option>
                                                                                <option>Senegal</option>
                                                                                <option>Serbia and Montenegro</option>
                                                                                <option>Seychelles</option>
                                                                                <option>Sierra Leone</option>
                                                                                <option>Singapore</option>
                                                                                <option>Slovakia</option>
                                                                                <option>Slovenia</option>
                                                                                <option>Solomon Islands</option>
                                                                                <option>Somalia</option>
                                                                                <option>South Africa</option>
                                                                                <option>South Georgia and the South Sandwich Islands</option>
                                                                                <option>Spain</option>
                                                                                <option>Sri Lanka</option>
                                                                                <option>Sudan</option>
                                                                                <option>Suriname</option>
                                                                                <option>Svalbard and Jan Mayen</option>
                                                                                <option>Swaziland</option>
                                                                                <option>Sweden</option>
                                                                                <option>Switzerland</option>
                                                                                <option>Syrian Arab Republic</option>
                                                                                <option>Taiwan</option>
                                                                                <option>Tajikistan</option>
                                                                                <option>Tanzania</option>
                                                                                <option>Thailand</option>
                                                                                <option>Timor-Leste</option>
                                                                                <option>Togo</option>
                                                                                <option>Tokelau</option>
                                                                                <option>Tonga</option>
                                                                                <option>Trinidad and Tobago</option>
                                                                                <option>Tunisia</option>
                                                                                <option>Turkey</option>
                                                                                <option>Turkmenistan</option>
                                                                                <option>Turks and Caicos Islands</option>
                                                                                <option>Tuvalu</option>
                                                                                <option>Uganda</option>
                                                                                <option>Ukraine</option>
                                                                                <option>United Arab Emirates</option>
                                                                                <option>United Kingdom</option>
                                                                                <option>United States</option>
                                                                                <option>United States Minor Outlying Islands</option>
                                                                                <option>Uruguay</option>
                                                                                <option>Uzbekistan</option>
                                                                                <option>Vanuatu</option>
                                                                                <option>Venezuela</option>
                                                                                <option>Viet Nam</option>
                                                                                <option>Virgin Islands</option>
                                                                                <option>Virgin Islands</option>
                                                                                <option>Wallis and Futuna</option>
                                                                                <option>Western Sahara</option>
                                                                                <option>Yemen</option>
                                                                                <option>Zambia</option>
                                                                                <option>Zimbabwe</option>
                                                                                
                                                                            </datalist> 
                                                                            
                                                                            
                                                                        </div>
                                                                        
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            
                                                            
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="vat"><?php print_lang('vat'); ?> <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input  id="vat" value="<?php  echo $data['vat']; ?>" type="text" placeholder="<?php print_lang('enter_vat'); ?>"  required="" name="vat" class="form-control " />
                                                                                
                                                                                
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                
                                                                
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="note"><?php print_lang('note'); ?> <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <textarea placeholder="<?php print_lang('enter_note'); ?>" required="" rows="" name="note" class=" form-control"><?php  echo $data['note']; ?></textarea>
                                                                                
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                
                                                                
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="terms"><?php print_lang('terms'); ?> <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <textarea placeholder="<?php print_lang('enter_terms'); ?>" required="" rows="" name="terms" class=" form-control"><?php  echo $data['terms']; ?></textarea>
                                                                                
                                                                                
                                                                            </div>
                                                                            
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                                
                                                                
                                                            </div>
                                                            <div class="form-group text-center">
                                                                <button class="btn btn-primary" type="submit">
                                                                    <?php print_lang('submit'); ?>
                                                                    <i class="fa fa-send"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </section>
                                
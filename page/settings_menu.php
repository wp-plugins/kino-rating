<div class="wrap">
    <div class="pl-title">
        <h2><span class="dashicons dashicons-chart-bar"></span> <?php _e('Rating displaying settings','cin-rat');?></h2>
        <div class="donate-form-kp">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                <input type="hidden" name="cmd" value="_s-xclick" />
                <input type="hidden" name="hosted_button_id" value="RU4G92USDJS38" />
                <input type="image" src="<?php echo KP_PL_URL; ?>/images/donate.png" name="submit" alt="PayPal — более безопасный и легкий способ оплаты через Интернет!" />
            </form>
        </div>
    </div>
    <form id="avk-form" action="" method="POST">
        <div>
            <fieldset>
                <legend><p><?php _e('Main settings','cin-rat')?></p></legend>
                <table class="settingRatAvk">
                    <tr>
                        <th><label id="lab_avk_select_ratings_path" for="avk_select_ratings_path"><?php _e('Show rating image:','cin-rat');?></label></th>
                        <td><?php $val = get_option('avk_select_ratings_path');?>
                            <select id="avk_select_ratings_path" class="selectavk" name="avk_select_ratings_path">
                                <option <?php selected( $val, 'kpimdb');?> value="kpimdb"><?php _e('KinoPoisk and IMDb','cin-rat');?></option>
                                <option <?php selected( $val, 'kp');?> value="kp"><?php _e('KinoPoisk','cin-rat');?></option>
                                <option <?php selected( $val, 'imdb');?> value="imdb"><?php _e('IMDb','cin-rat');?></option>
                            </select>
                        <td class="tdtri avk_select_ratings_path"><p><?php _e('Choose which site&rsquo;s rating to show in the content.','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_id_ratings" for="avk_id_ratings"><?php _e('KinoPoisk website Rating ID from','cin-rat');?></label></th>
                        <td><input id="avk_id_ratings" type="text" class="inputavk" name="avk_id_ratings" value="<?php echo get_option('avk_id_ratings');?>"/></td>
                        <td class="tdtri avk_id_ratings"><p><?php _e('For KinoPoisk rating and IMDb','cin-rat');?></p></td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend id="reskp"><p>www.kinopoisk.ru</p></legend>
                <table class="settingRatAvk">
                    <tr>
                        <th><label id="lab_avk_position_x_kp" for="avk_position_x_kp"><?php _e('Axial positioning <b>X</b>','cin-rat');?></label></th>
                        <td><input id="avk_position_x_kp" type="text" class="inputavk" name="avk_position_x_kp" value="<?php echo get_option('avk_position_x_kp');?>"/></td>
                        <td class="tdtri avk_position_x_kp"><p><?php _e('The distance from the left edge of the picture to the text','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_position_y_kp" for="avk_position_y_kp"><?php _e('Axial positioning <b>Y</b>','cin-rat');?></label></th>
                        <td><input id="avk_position_y_kp" type="text" class="inputavk" name="avk_position_y_kp" value="<?php echo get_option('avk_position_y_kp');?>"/></td>
                        <td class="tdtri avk_position_y_kp"><p><?php _e('The distance from the upper edge of the picture to the text','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_font_rat_kp" for="avk_font_rat_kp"><?php _e('Font','cin-rat');?></label></th>
                        <td>
                            <select id="avk_font_rat_kp" class="selectavk" name="avk_font_rat_kp">
                                <?php echo $this->set_select(get_option('avk_font_rat_kp'));?>
                            </select>
                        </td>
                        <td class="tdtri avk_font_rat_kp"><p><?php _e('Select the font of the text. You can use your own font: for this add font-file with &laquo;ttf&raquo; name suffix to folder FONT of this plugin.','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_font_size_kp" for="avk_font_size_kp"><?php _e('Font size','cin-rat');?></label></th>
                        <td><input id="avk_font_size_kp" type="text" class="inputavk" name="avk_font_size_kp" value="<?php echo get_option('avk_font_size_kp');?>"/></td>
                        <td class="tdtri avk_font_size_kp"><p><?php _e('Select font size','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_color_font_kp" for="avk_color_font_kp"><?php _e('Text color','cin-rat');?></label></th>
                        <td><input type="text" id="avk_color_font_kp" class="inputavk" name="avk_color_font_kp" value="<?php echo get_option('avk_color_font_kp');?>" /></td>
                        <td class="tdtri avk_color_font_kp"><div id="colorpickeravk_color_font_kp" class="colorpicker"></div></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_shadow_font_kp" for="avk_shadow_font_kp"><?php _e('Text shade','cin-rat');?></label></th>
                        <td><?php $val = get_option('avk_shadow_font_kp');?>
                            <select id="avk_shadow_font_kp" class="selectavk" name="avk_shadow_font_kp">
                                   <option <?php selected( $val, 'yes');?> value="yes"><?php _e('Enable','cin-rat');?></option>
                                   <option <?php selected( $val, 'no');?> value="no"><?php _e('Disable','cin-rat');?></option>
                            </select>
                        </td>
                        <td class="tdtri avk_shadow_font_kp"><p><?php _e('Rating text shade','cin-rat');?></p></td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend id="resimdb"><p>www.imdb.com</p></legend>
                <table class="settingRatAvk">
                    <tr>
                        <th><label id="lab_avk_position_x_imdb" for="avk_position_x_imdb"><?php _e('Axial positioning <b>X</b>','cin-rat');?></label></th>
                        <td><input id="avk_position_x_imdb" type="text" class="inputavk" name="avk_position_x_imdb" value="<?php echo get_option('avk_position_x_imdb');?>"/></td>
                        <td class="tdtri avk_position_x_imdb"><p><?php _e('The distance from the left edge of the picture to the text','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_position_y_imdb" for="avk_position_y_imdb"><?php _e('Axial positioning <b>Y</b>','cin-rat');?></label></th>
                        <td><input id="avk_position_y_imdb" type="text" class="inputavk" name="avk_position_y_imdb" value="<?php echo get_option('avk_position_y_imdb');?>"/></td>
                        <td class="tdtri avk_position_y_imdb"><p><?php _e('The distance from the upper edge of the picture to the text','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_font_rat_imdb" for="avk_font_rat_imdb"><?php _e('Font','cin-rat');?></label></th>
                        <td>
                            <select id="avk_font_rat_imdb" class="selectavk" name="avk_font_rat_imdb">
                            <?php echo $this->set_select(get_option('avk_font_rat_imdb'));?>
                            </select>
                        </td>
                        <td class="tdtri avk_font_rat_imdb"><p><?php _e('Select the font of the text. You can use your own font: for this add font-file with &laquo;ttf&raquo; name suffix to folder FONT of this plugin.','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_font_size_imdb" for="avk_font_size_imdb"><?php _e('Font size','cin-rat');?></label></th>
                        <td><input id="avk_font_size_imdb" type="text" class="inputavk" name="avk_font_size_imdb" value="<?php echo get_option('avk_font_size_imdb');?>"/></td>
                        <td class="tdtri avk_font_size_imdb"><p><?php _e('Select font size','cin-rat');?></p></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_color_font_imdb" for="avk_color_font_imdb"><?php _e('Text color','cin-rat');?></label></th>
                        <td><input type="text" id="avk_color_font_imdb" class="inputavk" name="avk_color_font_imdb" value="<?php echo get_option('avk_color_font_imdb');?>" /></td>
                        <td class="tdtri avk_color_font_imdb"><div id="colorpickeravk_color_font_imdb" class="colorpicker"></div></td>
                    </tr>
                    <tr>
                        <th><label id="lab_avk_shadow_font_imdb" for="avk_shadow_font_imdb"><?php _e('Text shade','cin-rat');?></label></th>
                        <td><?php $val = get_option('avk_shadow_font_imdb');?>
                            <select id="avk_shadow_font_imdb" class="selectavk" name="avk_shadow_font_imdb">
                                   <option <?php selected( $val, 'yes');?> value="yes"><?php _e('Enable','cin-rat');?></option>
                                   <option <?php selected( $val, 'no');?> value="no"><?php _e('Disable','cin-rat');?></option>
                            </select>
                        </td>
                        <td class="tdtri avk_shadow_font_imdb"><p><?php _e('Rating text shade','cin-rat');?></p></td>
                    </tr>
                </table>
            </fieldset>
            <input id="avk_submit" type="submit" name="avk-submit" class="button-primary" value="<?php _e('Save and generate the images','cin-rat');?>"/>
        </div>
    </form>
    <div id="avk_result" style="margin-top: 20px;"></div>
</div>
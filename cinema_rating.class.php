<?php 
/**
 * 	Plugin Name: Kino-Rating
 * 	Plugin URI: http://avkproject.ru/plugins/kinopoisk-and-wordpress.html
 *  Description: The plugin adds beautiful pictures with movie ratings.
 * 	Author: Smiling_Hemp
 * 	Version: 1.1.1
 * 	Author URI: https://profiles.wordpress.org/smiling_hemp#content-plugins
 */

/**
    Copyright (C) 20013-2015 Smiling_Hemp, avkproject.ru (support AT avkproject DOT ru)
    
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class CinemaRatingAVK{

    protected $incPage;
    protected $arrValue;
    protected $arrKP;
    protected $arrIMDb;
    protected $dataKP;
    protected $dataIMDb;
    private $__temp = 1;
    const SLUG = 'cinratavk';
    
    public function __construct(){
        /** Установка констант */
        if( !defined( 'KP_HOST' ) )    define( 'KP_HOST', $_SERVER['HTTP_HOST'] );
        if( !defined( 'KP_PL_PATH' ) ) define( 'KP_PL_PATH', plugin_dir_path( __FILE__ ) );
        if( !defined( 'KP_PL_URL' ) )  define( 'KP_PL_URL', plugin_dir_url( __FILE__ ) );
        /** Загрузка перевода */
        add_action('plugins_loaded', array(&$this, 'load_plugin_rating'));
        /** Массивы настроек */
        $this->arrValue = array(
            array("id" => 'avk_id_ratings',"std" => "543565"),
            array("id" => "avk_select_ratings_path","std" => ""),
        );
        $this->arrKP = array(
            array("id" => 'avk_position_x_kp',"std" => "15"),
            array("id" => 'avk_position_y_kp',"std" => "32"),
            array("id" => 'avk_font_rat_kp',"std" => "harrint.ttf"),
            array("id" => 'avk_font_size_kp',"std" => "14"),
            array("id" => 'avk_color_font_kp',"std" => "#fc5900"),
            array("id" => 'avk_shadow_font_kp',"std" => "no")
        );
        $this->arrIMDb = array(
            array("id" => 'avk_position_x_imdb',"std" => "55"),
            array("id" => 'avk_position_y_imdb',"std" => "23"),
            array("id" => 'avk_font_rat_imdb',"std" => "harrint.ttf"),
            array("id" => 'avk_font_size_imdb',"std" => "12"),
            array("id" => 'avk_color_font_imdb',"std" => "#ff0000"),
            array("id" => 'avk_shadow_font_imdb',"std" => "yes")
        );
        $this->dataKP = array(
                              'font'=>get_option('avk_font_rat_kp'),
                              'size'=>get_option('avk_font_size_kp'),
                              'x'=>get_option('avk_position_x_kp'),
                              'y'=>get_option('avk_position_y_kp'),
                              'color'=>get_option('avk_color_font_kp'),
                              'shadow'=>get_option('avk_shadow_font_kp')
                              );
        $this->dataIMDb = array(
                                'font'=>get_option('avk_font_rat_imdb'),
                                'size'=>get_option('avk_font_size_imdb'),
                                'x'=>get_option('avk_position_x_imdb'),
                                'y'=>get_option('avk_position_y_imdb'),
                                'color'=>get_option('avk_color_font_imdb'),
                                'shadow'=>get_option('avk_shadow_font_imdb')
                                );
        /** Действие при активации и деактивации плагина */
        register_activation_hook(__FILE__, array(&$this,'add_settings_avk'));
        register_deactivation_hook(__FILE__, array(&$this, 'del_settings_avk'));
        /** Добавление шорткода */
        add_shortcode('kpimdb', array(&$this, 'get_content'));
        /** Подключение страници плагина */
        add_action('admin_menu',array(&$this, 'add_page_settings'));
        /** Подключение AJAX для админновской части сайта */
        add_action( 'admin_enqueue_scripts', array(&$this,'avk_load_scripts') );
        /** Обработка AJAX запроса CMS WordPress в администраторской части сайта */
        add_action('wp_ajax_avk_get_results',array(&$this,'avk_admin_process_ajax'));
        /** Добавление кнопки в HTML редакторе */
        add_action('admin_footer', array(&$this,'add_quicktags_avk') );
        add_action('admin_head', array( &$this, 'add_quicktags_avk1' ) );
        /** Подключение AJAX для фронтальной части сайта */
        add_action('wp_enqueue_scripts', array(&$this, 'avk_script_client'));
        add_action('wp_ajax_loadimgrating', array(&$this,"load_img_rating_avk"));
        add_action('wp_ajax_nopriv_loadimgrating', array(&$this,"load_img_rating_avk"));
    }
        
    private function create_img( $path, $link, $data, $text, $nameImgIn, $nameImgOut ) {
        $pathInImg = $path . 'images/' . $nameImgIn . '.png';
    	$image = imagecreatefrompng($pathInImg);
        $width = imagesx($image);
        $height = imagesy($image);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $color = $this->get_dec_color($data['color']);
        $colorCustomer = imagecolorallocate($image, $color['r'], $color['g'], $color['b']);
        
        $fontPaf = $path . 'font/' . $data['font'];
        
        if($data['shadow']=='yes'){
            imagettftext($image, (int)$data['size'], 0, $data['x']+1, $data['y']+1, $black, $fontPaf, $text);
        }
        imagettftext($image, (int)$data['size'], 0, $data['x'], $data['y'], $colorCustomer, $fontPaf, $text);

        $pathImg = $path . 'images/temp/' . $nameImgOut . '.png';
        
    	imagepng( $image, $pathImg );
        imagedestroy( $image );
        return array( "width" => $width, "height" => $height );
    }
    
    /** color value HEX to DEC */
    protected function get_dec_color($colorHex){
        $colorHex = substr($colorHex, -6);
        $r = hexdec(substr($colorHex, -6,2));
        $g = hexdec(substr($colorHex, -4,2));
        $b = hexdec(substr($colorHex, 4));
        return array("r"=>$r,"g"=>$g,"b"=>$b);
    }
    
    /** Добавляет страницу плагина */
    public function add_page_settings(){
        $this->incPage = add_options_page(__( 'Main settings', 'cin-rat' ),__('Kino-Rating','cin-rat'),'manage_options','cinema-rating-avk',array(&$this,'settings_page'));
        add_action( 'admin_print_scripts-' . $this->incPage, array( &$this, 'print_scripts' ) );
        add_action( 'admin_print_styles-' . $this->incPage, array( &$this, 'print_styles' ) );
    }
    
    /** Страница плагина */
    public function settings_page(){
        include_once"page/settings_menu.php";
    }
    
    public function print_styles(){
        wp_enqueue_style  ( 'stylesheet-farbtastic-kp', KP_PL_URL . 'css/farbtastic.css', array(), '1.2' );
        wp_enqueue_style  ( 'style-admin-kp', KP_PL_URL . 'css/style.css', array(), '1.0.0' );
    }
    
    public function print_scripts(){
        $this->_avk_admin_script();
        
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'avk-farbtastic-kp', KP_PL_URL . 'js/farbtastic.js', array( 'jquery' ), '1.2' );
        wp_enqueue_script( 'avk-script-kp', KP_PL_URL . 'js/script.js', array( 'jquery' ), '1.0.0'  );
        
        wp_enqueue_script ( 'avk-ajax-kp', KP_PL_URL . 'js/ajax.js', array( 'jquery' ), '1.0.0' );
        wp_localize_script( 'avk-ajax-kp', 'kpRatingAVK', array( 'avk_kp_nonce' => wp_create_nonce( 'avk-nonce' ) ) );
    }
    
    /** Подключение скриптов */
    public function avk_load_scripts($hook){
        if($this->incPage != $hook) return;
        add_action( 'admin_footer', array(&$this,'add_avk'));
    }
    
    protected function _avk_admin_script(){
        $str1 = $str2 = '';
        foreach($this->arrValue as $arr){
            $str1 .= 'jQ'.$arr['id'].' = jQuery("#'.$arr['id'].'").attr("value");'."\n\t\t";
            $str2 .= $arr['id'].' : jQ'.$arr['id'].','."\n\t\t\t\t";
        }
        foreach($this->arrKP as $arr){
            $str1 .= 'jQ'.$arr['id'].' = jQuery("#'.$arr['id'].'").attr("value");'."\n\t\t";
            $str2 .= $arr['id'].' : jQ'.$arr['id'].','."\n\t\t\t\t";
        }
        foreach($this->arrIMDb as $arr){
            $str1 .= 'jQ'.$arr['id'].' = jQuery("#'.$arr['id'].'").attr("value");'."\n\t\t";
            $str2 .= $arr['id'].' : jQ'.$arr['id'].','."\n\t\t\t\t";
        }
        $var = '<script type="text/javascript">'."\n\t".
                'function avk_get_arr(){'."\n\t\t".
                $str1
                .'arrDataAVK = {action: "avk_get_results",
                                avk_kp_nonce: kpRatingAVK.avk_kp_nonce,
                                   '.$str2.'};
                return arrDataAVK;
                }'."\n".'</script>'."\n";
        echo $var;        
    }
    
    /** Функция обработки/вывода запроса */
    public function avk_admin_process_ajax(){
        if(!isset($_POST['avk_kp_nonce']) || wp_verify_nonce($_POST['avk_kp_nonce'],'avk_kp_nonce')) die('<p>'.__('ERROR','cin-rat').'!!!</p>');
        //сохранение настроек
        $this->save_settings($this->arrValue);
        $this->save_settings($this->arrKP);
        $this->save_settings($this->arrIMDb);
        //получение рейтинга
        $rating = $this->get_rating(get_option('avk_id_ratings'));
        //create image KinoPoisk
        $data = array('font'=>get_option('avk_font_rat_kp'),'size'=>get_option('avk_font_size_kp'),'x'=>get_option('avk_position_x_kp'),'y'=>get_option('avk_position_y_kp'),'color'=>get_option('avk_color_font_kp'),'shadow'=>get_option('avk_shadow_font_kp'));
        $varmsKP = $this->create_img(KP_PL_PATH,KP_PL_URL,$data,$rating->kp_rating.'/10','rakp','kp_ratings');
        //create image IMDb
        $data = array('font'=>get_option('avk_font_rat_imdb'),'size'=>get_option('avk_font_size_imdb'),'x'=>get_option('avk_position_x_imdb'),'y'=>get_option('avk_position_y_imdb'),'color'=>get_option('avk_color_font_imdb'),'shadow'=>get_option('avk_shadow_font_imdb'));
        $varmsIMDb = $this->create_img(KP_PL_PATH,KP_PL_URL,$data,$rating->imdb_rating.'/10','ramdb','imdb_ratings');
        //load to ajax
        $arr = array(
                    "kp"  =>'<img id="avk_img_kp" width="'.$varmsKP['width'].'px" height="'.$varmsKP['height'].'px" src="'.KP_PL_URL.'images/kp_ratings.png?i='.time().'"/>',
                    "imdb"=>'<img id="avk_img_imdb" width="'.$varmsIMDb['width'].'px" height="'.$varmsIMDb['height'].'px" src="'.KP_PL_URL.'images/imdb_ratings.png?i='.time().'"/>'               
               );
        $result = json_encode($arr, JSON_FORCE_OBJECT);
        echo $result;
        die();
    }
    
    /** Подключение AJAX скриптов для фронтальной части сайта */
    public function avk_script_client() {
        wp_register_script( 'avksc', KP_PL_URL . 'js/cl_script.js', array('jquery') );
        wp_localize_script( 'avksc', 'avkAjaxKP', array( 'ajurl' => admin_url( 'admin-ajax.php' ) ) );        
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'avksc' );
    }
    
    /** Обработка AJAX запроса для фронтальной части сайта */
    public function load_img_rating_avk(){
        //if( !defined( 'WPLANG' ) ) define( 'WPLANG', 'ru_RU' );
        $valueUrl = abs( ( int ) $_POST['rating'] );
        $rating = $this->get_rating( $valueUrl );
        $ratingImg = "";
        if( is_object( $rating ) ){
            switch( get_option('avk_select_ratings_path') ){
                case'kpimdb': //create image KP
                              $varmsKP = $this->create_img(KP_PL_PATH,KP_PL_URL,$this->dataKP,$rating->kp_rating.'/10', 'rakp', 'kp_' . $valueUrl );
                              //create image IMDb
                              $varmsIMDb = $this->create_img(KP_PL_PATH,KP_PL_URL,$this->dataIMDb,$rating->imdb_rating.'/10', 'ramdb', 'imdb_' . $valueUrl );
                              //load image content
                              $ratingImg = '<img id="avk_img_kp" title="'.__('Rating from KinoPoisk site','cin-rat').' = '.$rating->kp_rating.'" width="'.$varmsKP['width'].'px" height="'.$varmsKP['height'].'px" alt="'.$rating->kp_rating.'" src="'.KP_PL_URL.'images/temp/kp_'.$valueUrl.'.png"/>
                                            <img id="avk_img_imdb" title="'.__('Rating from KinoPoisk site','cin-rat').' = '.$rating->imdb_rating.'" style="border-radius: 5px;" width="'.$varmsIMDb['width'].'px" alt="'.$rating->imdb_rating.'" height="'.$varmsIMDb['height'].'px" src="'.KP_PL_URL.'images/temp/imdb_'.$valueUrl.'.png"/>';break;
                case'kp': //create image KP
                          $varmsKP = $this->create_img(KP_PL_PATH,KP_PL_URL,$this->dataKP,$rating->kp_rating.'/10','rakp','kp_'.$valueUrl);
                          $ratingImg = '<img id="avk_img_kp" title="'.__('Rating from KinoPoisk site','cin-rat').' = '.$rating->kp_rating.'" width="'.$varmsKP['width'].'px" height="'.$varmsKP['height'].'px" alt="'.$rating->kp_rating.'" src="'.KP_PL_URL.'images/temp/kp_'.$valueUrl.'.png"/>'; break;
                case'imdb': //create image IMDb
                            $varmsIMDb = $this->create_img(KP_PL_PATH,KP_PL_URL,$this->dataIMDb,$rating->imdb_rating.'/10','ramdb','imdb_'.$valueUrl); 
                            $ratingImg = '<img id="avk_img_imdb" title="'.__('Rating from KinoPoisk site','cin-rat').' = '.$rating->imdb_rating.'" style="border-radius: 5px;" width="'.$varmsIMDb['width'].'px" alt="'.$rating->imdb_rating.'" height="'.$varmsIMDb['height'].'px" src="'.KP_PL_URL.'images/temp/imdb_'.$valueUrl.'.png"/>'; break;
            }
        }else{
            $ratingImg = "<p>" . __('No rating','cin-rat') . "</p>";
        }
        echo $ratingImg;
        die;
    }    
    
    public function add_avk($hook){
        echo '<p style="text-align:center;position: relative;top: -10px;"><a href="http://avkproject.ru/plugins/kinopoisk-and-wordpress.html" target="_blank">'.__('Plugin homepage','cin-rat').' AVKProject.ru<a></p>';
    }
    
    protected function get_rating($num){
        $sxml = @simplexml_load_file("http://rating.kinopoisk.ru/{$num}.xml");//http://www.kinopoisk.ru/rating
        return $sxml;
    }
    
    protected function set_select($cheket){
        if(is_dir(KP_PL_PATH."font")){
            $arr = array();
            $d = dir(KP_PL_PATH."font");
            while (false !== ($entry = $d->read())) {
                if($entry =='.' || $entry =='..' || $entry == 'index.php')continue;
                $arr[$entry] = ucfirst(strtolower(substr($entry,0,strlen($entry)-4)));
            }
            $d->close();
            if(asort($arr)){
                foreach($arr as $key => $value){
                    $chek = $this->set_choose($cheket,$key,'sel');
                    $strOpt .= "<option {$chek} value=\"{$key}\">{$value}</option>";
                }
            }
        }
        return $strOpt;
    }
    
    protected function set_choose($val1, $val2,$type){
        $chek='';
        if(!empty($val1)){
            switch($type){
                case'sel': $chek = selected( $val1, $val2, false );break;
                case'che': $chek = checked(  $val1, $val2, false ); break;
                case'rad': $chek = disabled( $val1, $val2, false );break;
            }    
        }
        return $chek;
    }
    
    /** add settings plugin */
    public function add_settings_avk(){
        foreach($this->arrValue as $value){
            update_option($value['id'], $value['std']);
        }
        foreach($this->arrKP as $value){
            update_option($value['id'], $value['std']);
        }
        foreach($this->arrIMDb as $value){
            update_option($value['id'], $value['std']);
        }
    }
    
    /** save settings plugin */
    private function save_settings($option){
        foreach($option as $value){
            if(isset($_REQUEST[$value['id']])){
                update_option($value['id'], trim($_REQUEST[$value['id']]));
            }else{
                delete_option($value['id']);
            }
        }
    }
    
    /** delete settings plugin */
    public function del_settings_avk(){
        foreach($this->arrValue as $value){
            delete_option($value['id']);
        }
        foreach($this->arrKP as $value){
            delete_option($value['id']);
        }
        foreach($this->arrIMDb as $value){
            delete_option($value['id']);
        }
    }
    
    public function load_plugin_rating(){
        load_plugin_textdomain( 'cin-rat', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
    }
    
    public function add_quicktags_avk() {
        ?>
        <script type="text/javascript" charset="utf-8">
            ( function( $ ){
                $( document ).ready(function(){
                    if( typeof( QTags ) !== 'undefined' ){
                        QTags.addButton( '<?php _e('Kino-Rating','cin-rat');?>', '<?php _e('Kino-Rating', 'cin-rat');?>', '[kpimdb]', '[/kpimdb]','que-marks-key','<?php _e('KinoPoisk and IMDb rating','cin-rat');?>');
                    }
                });
            } )( jQuery )
        </script>
        <?php
    }
    
    public function add_quicktags_avk1(){
?>
        <script type='text/javascript'>
            var kpRatingButtonMceAvk = {
                    idcinema: "<?php _e('Film ID', 'cin-rat'); ?>",
                    nameButton: "<?php _e('Kino-Rating', 'cin-rat'); ?>",
                };
        </script>        
<?php
        add_filter('mce_external_plugins', array( &$this, 'mce_external_plugins' ) );
        add_filter('mce_buttons', array( &$this, 'mce_buttons' ) );
    }
    
    public function mce_external_plugins( $pluginArray ){
        $pluginArray[ 'cin_rat_button' ] = KP_PL_URL . 'js/button.js';
        return $pluginArray;
    }
    
    public function mce_buttons( $buttons ){
        array_push( $buttons, 'cin_rat_button_key' );
        return $buttons;
    }
    
    public function get_content($atts, $content){
        if (!isset($atts['name']))
			$sp_name = 'ratingAVK';
		else
			$sp_name = $atts['name'];

        $ratingImg = "";
        $ratingImg  = "\n".'<!-- Start Cinema rating from avkproject.ru -->';
        $ratingImg .= "\n".'<div id="avkkprating-' . $this->__temp . '" class="avkkprating" style="height: 44px;display: inline-block;">';
        $ratingImg .= "\n\t".'<img id="avkrating-' . $this->__temp . '" class="avkrating" src="'.KP_PL_URL.'images/load_processing.gif" title="'. __('KinoPoisk website Rating ID from','cin-rat') .'" alt="'.$content.'"/>';
        $ratingImg .= "\n".'</div>';
        $ratingImg .= "\n".'<!-- Stop Cinema rating from avkproject.ru -->';

        $this->__temp++;
        return $ratingImg;
    }
}

new CinemaRatingAVK();
?>
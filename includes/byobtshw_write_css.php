<?php

/*
 * Enqueue style-file, if it exists.
 */

function byobtshw_add_stylesheet() {
    
    if(class_exists('Thesis_CSS')){ // Test to make sure that Thesis is active
        
    
        $options = get_option('byobtshw_options');
        $css_location = $options['css_location'];

        if($css_location != 'head'){
            $custom_url = get_stylesheet_directory_uri() . '/custom/byob-custom.css';
            $custom_file = STYLESHEETPATH . '/custom/byob-custom.css';
            $custom_sample_url = get_stylesheet_directory_uri() . '/custom-sample/byob-custom.css';
            $custom_sample_file = STYLESHEETPATH . '/custom-sample/byob-custom.css';
            $plugin_url = plugin_dir_path( __FILE__ ) . 'css/byob-custom.css';
            $plugin_css_file = WP_PLUGIN_DIR . '/css/byob-custom.css';

            if ( file_exists($custom_file) ) {
                wp_register_style('byob_plugin_styles', $custom_url);
                wp_enqueue_style( 'byob_plugin_styles');
            }elseif ( file_exists($custom_sample_file) ) {
                wp_register_style('byob_plugin_styles', $custom_sample_url);
                wp_enqueue_style( 'byob_plugin_styles');
            }else{
                wp_register_style('byob_plugin_styles', $plugin_url);
                wp_enqueue_style( 'byob_plugin_styles');
            }
        }
        
    }
}
add_action('wp_print_styles', 'byobtshw_add_stylesheet');

    
function byobtshw_write_css_to_head(){
    
    if(class_exists('Thesis_CSS')){ // Test to make sure that Thesis is active
        
    
        $options = get_option('byobtshw_options');
        $css_location = $options['css_location'];

        if($css_location == 'head'){
            $header_areas = $options['header_areas'];
            $left_menu = $options['left_menu'];
            $left_search = $options['left_search'];
            $right_menu = $options['right_menu'];
            $right_search = $options['right_search'];

            $header_area_left_css = '';
            $header_area_right_css = '';
            $menu_css = '';
            $search_css = '';

            byobtshw_delete_css();


            // Write the overall header css

            $header_css = byobtshw_header_css();

            // Write the header areas css

            if ($header_areas == 'two'){

                $header_area_left_css = byobtshw_header_area_css('left');
                $header_area_right_css = byobtshw_header_area_css('right');

            }else{

                $header_area_left_css = byobtshw_header_area_css('left');
            }

            if(($left_menu) || ($right_menu)){
                $menu_css = byobtshw_nav_menu_css();
            }
            if(($left_search) || ($right_search)){
                $search_css = byobtshw_search_css();
            }

            echo '<style type="text/css">' . $header_css;
            echo $header_area_left_css;
            echo $header_area_right_css;
            echo $menu_css;
            echo $search_css . '</style>';
            
            byobtshw_fix_thesis_css();
        }
        
    }
      
}
add_action('wp_head', 'byobtshw_write_css_to_head');

function byobtshw_write_css_file(){
    
    $options = get_option('byobtshw_options');
    $header_areas = $options['header_areas'];
    $left_menu = $options['left_menu'];
    $left_search = $options['left_search'];
    $right_menu = $options['right_menu'];
    $right_search = $options['right_search'];
   
    
    // Write the overall header css
    
    $header_css = byobtshw_header_css();
    
    // Write the header areas css
    
    if ($header_areas == 'two'){
    
        $header_area_left_css = byobtshw_header_area_css('left');
        $header_area_right_css = byobtshw_header_area_css('right');
        
    }else{
    
        $header_area_left_css = byobtshw_header_area_css('left');
    }
    
    if(($left_menu) || ($right_menu)){
        $menu_css = byobtshw_nav_menu_css();
    }
    if(($left_search) || ($right_search)){
        $search_css = byobtshw_search_css();
    }
    
     // Create the CSS Block
     $css_block_start = '/*>>Start - BYOB Thesis Header Widgets CSS */';
    $css_block_end = '/*>>End - BYOB Thesis Header Widgets CSS */';
    
    $write_css = $css_block_start . "\n";
    $write_css .= $header_css . "\n";
    $write_css .= $header_area_left_css;
    $write_css .= $header_area_right_css;
    $write_css .= $menu_css;
    $write_css .= $search_css;
    $write_css .= $css_block_end . "\n";
 
     // Create the CSS Header Block
    $write_header_css = "/*\n";
    $write_header_css .= "File:		byob_custom.css \n";
    $write_header_css .= "Description:	Styles for BYOB Thesis Plugins \n";
    $write_header_css .= "More Info:	http://www.byobwebsite.com/member-benefits/plugins/ \n";
    $write_header_css .= "*/ \n\n";
    
    // Setup the CSS sheet creation
    
    $custom_file = STYLESHEETPATH . '/custom';
    $custom_sample_file = STYLESHEETPATH . '/custom-sample';
    
    if(is_writable($custom_file)){
        $location = STYLESHEETPATH . '/custom/byob-custom.css';
    }elseif(is_writable($custom_sample_file)){
        $location = STYLESHEETPATH . '/custom-sample/byob-custom.css';
    }else{
        $location = plugin_dir_path( __FILE__ ) . 'css/byob-custom.css';
    }
  
    if(!file_exists($location)){
        $write_final_css = $write_header_css . $write_css;
    }else{

        $byob_css_file = file_get_contents($location);
        $start_pos = strpos($byob_css_file, $css_block_start);
               
        if($start_pos){
            $front_piece = explode($css_block_start, $byob_css_file, 2);
            $end_piece = explode($css_block_end, $byob_css_file, 2);
            $write_final_css = $front_piece[0] . $write_css . $end_piece[1]; 
        }else{
            $write_final_css = $byob_css_file . $write_css;
        }
    }
        // Remove the blank lines

        $write_final_css = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $write_final_css);
        
        // Write the CSS to the file
        $new_file = fopen($location, 'w');
        fwrite($new_file, $write_final_css);
        fclose($new_file);
        
        byobtshw_fix_thesis_css();
}



function byobtshw_header_css(){
    $options = get_option('byobtshw_options');
    $height = $options['main_height'];
    $customize_background = $options['main_customize_background'];
    
    $widget_option = 'main';
    
    $header_css = '.custom #header{';
    if($height != ''){
        $header_css .= 'height:' . (int)$height . 'px;';
    }
    
    $header_css .= byobtshw_write_margin_css($widget_option);
    
    $header_css .= byobtshw_write_padding_css($widget_option);
    
    if($customize_background == '1'){
        $header_css .= byobtshw_write_background_css($widget_option);
    }
            
    $header_css .= "} \n";
    $header_css .= ".custom #header ul.sidebar_list{padding:0;} \n.custom #header li.widget{padding:0;margin:0}";
    if($menu_font_size != ''){
        $header_css .= '.custom #header menu a{font-size:' . (int)$menu_font_size . 'px;}';
    }
    
    return $header_css;
}

function byobtshw_header_area_css($area){
    
    $options = get_option('byobtshw_options');
    $header_areas = $options['header_areas'];
    $width = $options[$area . '_width'];
    $left_width = $options['left_width'];
    $height = $options[$area . '_height'];
    $text_align = $options[$area . '_header_area_text_align'];
    $customize_background = $options[$area .'_customize_background'];
    
    $margin_left = $options[$area . '_margin_left'];
    $margin_right = $options[$area . '_margin_right'];
    $padding_left = $options[$area . '_padding_left'];
    $padding_right = $options[$area . '_padding_right'];
    $main_margin_left = $options['main_margin_left'];
    $main_margin_right = $options['main_margin_right'];
    $main_padding_left = $options['main_padding_left'];
    $main_padding_right = $options['main_padding_right'];
    $optimal_width = $options['optimal_width'];
    
    $widget_option = $area;
    $header_area_css = '';
    
    
    if($header_areas == 'two'){
        if($area == 'left'){
            $main_padding_margin = (int)$main_margin_left + (int)$main_padding_left;
            $padding_margin = (int)$margin_left + (int)$padding_left + (int)$margin_right + (int)$padding_right;
            $calc_width = (int)$width - ($main_padding_margin + $padding_margin);
        }else{
            $main_padding_margin = (int)$main_margin_right + (int)$main_padding_right;
            $padding_margin = (int)$margin_left + (int)$padding_left + (int)$margin_right + (int)$padding_right;
            $calc_width = $optimal_width - ($left_width + $main_padding_margin + $padding_margin);
        }
    }
    
    if($left_width != '' || ($height != '') || ($background_color != '') || ($background_image != '') || ($margin_top != '') 
            || ($margin_bottom != '') || ($margin_left != '') || ($margin_right != '') || ($padding_top != '') 
            || ($padding_bottom != '') || ($padding_left != '') || ($padding_right != '')){
    
        $header_area_css = '.custom #byobtshw-header-'. $area.'{';
        
        
        if($header_areas == 'two'){
            if($left_width != ''){
                $header_area_css .= 'width:' . $calc_width . 'px;';
                $header_area_css .= 'float:left;';
            }
        }
        
        if($height != ''){
            $header_area_css .= 'height:' . (int)$height . 'px;';
        }
        
        if($customize_background == '1'){
            
            $header_area_css .= byobtshw_write_background_css($widget_option);
        }
        
        $header_area_css .= byobtshw_write_margin_css($widget_option);
    
        $header_area_css .= byobtshw_write_padding_css($widget_option);
        
        if($text_align != ''){
            $header_area_css .= 'text-align:' . $text_align . ';';
        }
        
        $header_area_css .= "} \n";
    } 
    
    return $header_area_css;
}

function byobtshw_write_margin_css($widget_option){
    $options = get_option('byobtshw_options');
    $margin_top = $options[$widget_option . '_margin_top'];
    $margin_bottom = $options[$widget_option . '_margin_bottom'];
    $margin_left = $options[$widget_option . '_margin_left'];
    $margin_right = $options[$widget_option . '_margin_right'];
    $typical_margin = '0';
    
    $margin_css = 'margin:';
    
    if($margin_top != ''){
        $margin_css .= (int)$margin_top . 'px ';
    }else{
        $margin_css .= (int)$typical_margin . 'px ';
    }
    if($margin_right != ''){
        $margin_css .= (int)$margin_right . 'px ';
    }else{
        $margin_css .= (int)$typical_margin . 'px ';
    }
    if($margin_bottom != ''){
        $margin_css .= (int)$margin_bottom . 'px ';
    }else{
        $margin_css .= (int)$typical_margin . 'px ';
    }
    if($margin_left != ''){
        $margin_css .= (int)$margin_left . 'px;';
    }else{
        $margin_css .= (int)$typical_margin . 'px;';
    }
    
    return $margin_css;
}

function byobtshw_write_padding_css($widget_option){
    $options = get_option('byobtshw_options');
    $padding_top = $options[$widget_option . '_padding_top'];
    $padding_bottom = $options[$widget_option . '_padding_bottom']; 
    $padding_left = $options[$widget_option . '_padding_left']; 
    $padding_right = $options[$widget_option . '_padding_right'];
    $typical_padding = '0';
    
    $padding_css = 'padding:';
    
    if($padding_top != ''){
        $padding_css .= (int)$padding_top . 'px ';
    }else{
        $padding_css .= (int)$typical_padding . 'px ';
    }
    if($padding_right != ''){
        $padding_css .= (int)$padding_right . 'px ';
    }else{
        $padding_css .= (int)$typical_padding . 'px ';
    }
    if($padding_bottom != ''){
        $padding_css .= (int)$padding_bottom . 'px ';
    }else{
        $padding_css .= (int)$typical_padding . 'px ';
    }
    if($padding_left != ''){
        $padding_css .= (int)$padding_left . 'px;';
    }else{
        $padding_css .= (int)$typical_padding . 'px;';
    }
   
    return $padding_css;
}

function byobtshw_write_background_css($widget_option){
    $options = get_option('byobtshw_options');
    $background_transparent = $options[$widget_option . '_background_transparent'];
    $background_color = $options[$widget_option . '_background_color'];
    $background_image = $options[$widget_option . '_background_image'];
    $background_repeat = $options[$widget_option . '_background_repeat'];
    $background_hv_position = $options[$widget_option . '_background_position_hv'];
    $x_position = $options[$widget_option . '_background_image_x_pos'];
    $y_position = $options[$widget_option . '_background_image_y_pos'];
    $x_units = $options[$widget_option . '_x_pos_units'];
    $y_units = $options[$widget_option . '_y_pos_units'];
    
    
    if($background_transparent != '1'){
        if($background_gradient !=''){
            $background_css .= $background_gradient;
        }else{
            $background_css .= 'background-color:#' . $background_color . ';';
        }
        
    }else{
        $background_css .= 'background-color:transparent;';
    }
    
    if($background_image != ''){
        $background_css .= 'background-image:url("' . $background_image . '");';
            $background_css .= 'background-repeat:' . $background_repeat . ';';

            if (($x_position) || ($y_position)) {
                $background_css .= 'background-position:';
                if (!$x_position == '' || $x_position == '0') {
                    $background_css .= $x_position . $x_units . ' ';
                }
                if (!$y_position == '' || $y_position == '0') {
                    $background_css .= $y_position . $y_units;
                }
                $background_css .= ';';
            } else {
                $background_css .= 'background-position:' . $background_hv_position . ';';
            }
    }
    
    return $background_css;
}

function byobtshw_search_css(){
    $options = get_option('byobtshw_options');
    $top_margin = $options['search_top_margin'];
    $bottom_margin = $options['search_bottom_margin'];
    $left_margin = $options['search_left_margin'];
    $search_width = $options['search_width'];
    $search_font_size = $options['search_font_size'];
    $search_padding = $options['search_padding'];
    $search_width = $options['search_width'];
    
    $search_css = '.custom #header .search_form {';
    if($top_margin){
        $search_css .= 'margin-top:' . $top_margin . 'px;';
    }
    if($bottom_margin){
        $search_css .= 'margin-bottom:' . $bottom_margin . 'px;';
    }
    if($left_margin){
        $search_css .= 'margin-left:' . $left_margin . 'px;';
    }
    $search_css .= "} \n";
    
    $search_css .= '.custom #header .search_form input[type="text"]{';
    if($search_font_size){
        $search_css .= 'font-size:' . $search_font_size . 'px;';
    }else{
        $search_css .= 'font-size:12px;';
    }
    if($search_padding){
        $search_css .= 'padding:' . $search_padding . 'px;';
    }else{
        $search_css .= 'padding:3px;';
    }
    if($search_width){
        $search_css .= 'width:' . $search_width . 'px;}';
    }else{
        $search_css .= "width:200px;} \n";
    }
    
//    $search_css .= 'clear:both;}';
    return $search_css;
    
}

function byobtshw_nav_menu_css(){
    $options = get_option('byobtshw_options');
    $top_margin = $options['menu_top_margin'];
    $bottom_margin = $options['menu_bottom_margin'];
    $left_margin = $options['menu_left_margin'];
    $menu_width = $options['menu_width'];
    
    $menu_css = '.custom #header .menu {';
    
    if($top_margin){
        $menu_css .= 'margin-top:' . $top_margin . 'px;';
    }
    if($bottom_margin){
        $menu_css .= 'margin-bottom:' . $bottom_margin . 'px;';
    }
    if($left_margin){
        $menu_css .= 'margin-left:' . $left_margin . 'px;';
    }
    if($menu_width){
        $menu_css .= 'width:' .$menu_width . 'px;';
    }
    
    $menu_css .= 'clear:both;}';
    return $menu_css;
}

function byobtshw_delete_css(){
    $custom_file = STYLESHEETPATH . '/custom';
    $custom_sample_file = STYLESHEETPATH . '/custom-sample';
     // Create the CSS Block
    $css_block_start = '/*>>Start - BYOB Thesis Header Widgets CSS */';
    $css_block_end = '/*>>End - BYOB Thesis Header Widgets CSS */';
    
    if(file_exists($custom_file)){
        $location = STYLESHEETPATH . '/custom/byob-custom.css';
    }elseif(file_exists($custom_sample_file)){
        $location = STYLESHEETPATH . '/custom-sample/byob-custom.css';
    }
  
    if(file_exists($location)){
        $byob_css_file = file_get_contents($location);
        $start_pos = strpos($byob_css_file, $css_block_start);

        if($start_pos){
            $front_piece = explode($css_block_start, $byob_css_file, 2);
            $end_piece = explode($css_block_end, $byob_css_file, 2);
            $write_final_css = $front_piece[0] .$end_piece[1]; 
            
            // Remove the blank lines

            $write_final_css = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $write_final_css);

            // Write the CSS to the file
            $new_file = fopen($location, 'w');
            fwrite($new_file, $write_final_css);
            fclose($new_file);
        }      
    }
}


function byobtshw_fix_thesis_css(){
    
    add_filter('thesis_css','byobtshw_filter_thesis_css');
    
    thesis_generate_css();
    
}

function byobtshw_filter_thesis_css($css){
    
    $changed_rules = array( '.sidebar .menu { border: none; }',
                            '.sidebar .menu li { float: none; }',
                            '.sidebar .menu li a { text-transform: none; letter-spacing: normal; padding: 0; background: transparent; border: none; }');
    
    $new_rules = array( '#sidebar_1 .menu, #sidebar_2 .menu  { border: none; }',
                        '#sidebar_1 .menu li, #sidebar_2 .menu li { float: none; }',
                        '#sidebar_1 .menu li a, #sidebar_2 .menu li a { text-transform: none; letter-spacing: normal; padding: 0; background: transparent; border: none; }');
    
    $new_css = str_replace($changed_rules, $new_rules, $css);;
    return $new_css;
}
<?php


function byobtshw_initialize_header(){
    $options = get_option('byobtshw_options');
    $header_areas = $options['header_areas'];
    $left_widgetize = $options['left_widgetize'];
    $right_widgetize = $options['right_widgetize'];
    global $optimal_width;
    
    if ($header_areas == 'two'){
        if($left_widgetize != '1'){
            byobtshw_register_left_sidebar();
        }
        if($right_widgetize != '1'){
            byobtshw_register_right_sidebar();
        }
        remove_action('thesis_hook_header','thesis_default_header');
    }else{
        if($left_widgetize != '1'){
            byobtshw_register_left_sidebar();           
        } 
        remove_action('thesis_hook_header','thesis_default_header');
    }

}
add_action('init','byobtshw_initialize_header');

function byobtshw_initialize_menu(){
    $options = get_option('byobtshw_options'); 
    $left_menu = $options['left_menu'];
    $right_menu = $options['right_menu'];
    
    if(($left_menu == '1') || ($right_menu == '1')){
        remove_action('thesis_hook_before_header', 'thesis_nav_menu');
        remove_action('thesis_hook_header', 'thesis_nav_menu');
        remove_action('thesis_hook_after_header', 'thesis_nav_menu');
    } 
}
add_action('wp_head','byobtshw_initialize_menu');

function byobtshw_create_header_html(){
    $options = get_option('byobtshw_options');
    $header_areas = $options['header_areas'];
    $left_widgetize = $options['left_widgetize'];
    $right_widgetize = $options['right_widgetize'];
    $left_menu = $options['left_menu'];
    $left_menu_location = $options['left_menu_location'];
    $left_search = $options['left_search'];
    $left_search_location = $options['left_search_location'];
    $right_menu = $options['right_menu'];
    $right_menu_location = $options['right_menu_location'];
    $right_search = $options['right_search'];
    $right_search_location = $options['right_search_location'];
    
    if($header_areas == 'two'){
        
        echo '<div id="byobtshw-header-left">';
        if( ($left_menu == '1') && ($left_menu_location == 'above')){
            echo '<div class="thesis-menu">';
            thesis_nav_menu();
            echo '</div>';
        }
        if( ($left_search == '1') && ($left_search_location == 'above')){
            thesis_search_form();
        }
        
        if($left_widgetize != '1'){
            byobtshw_add_left_header_sidebar();
        }else{
            thesis_default_header();
        }
        
        if( ($left_menu == '1') && ($left_menu_location == 'below')){
            echo '<div class="thesis-menu">';
            thesis_nav_menu();
            echo '</div>';
        }
        if( ($left_search == '1') && ($left_search_location == 'below')){
            thesis_search_form();
        }
        
        echo '<div style="clear:both;"></div></div><div id="byobtshw-header-right">';
        if( ($right_menu == '1') && ($right_menu_location == 'above')){
            echo '<div class="thesis-menu">';
            thesis_nav_menu();
            echo '</div>';
        }
        if( ($right_search == '1') && ($right_search_location == 'above')){
            thesis_search_form();
        }
        
        if($right_widgetize != '1'){
            byobtshw_add_right_header_sidebar();
        }else{
            thesis_default_header();
        }
        
        if( ($right_menu == '1') && ($right_menu_location == 'below')){
            echo '<div class="thesis-menu">';
            thesis_nav_menu();
            echo '</div>';
        }
        if( ($right_search == '1') && ($right_search_location == 'below')){
            thesis_search_form();
        }
        echo '<div style="clear:both;"></div></div>'; 
        echo '<div style="clear:both;"></div>';
        
    }else{
        echo '<div id="byobtshw-header-left">';
        if( ($left_menu == '1') && ($left_menu_location == 'above')){
            echo '<div class="thesis-menu">';
            thesis_nav_menu();
            echo '</div>';;
        }
        if( ($left_search == '1') && ($left_search_location == 'above')){
            thesis_search_form();
        }
        
        if($left_widgetize != '1'){
            byobtshw_add_left_header_sidebar();
        }else{
            thesis_default_header();
        }
        
        if( ($left_menu == '1') && ($left_menu_location == 'below')){
            echo '<div class="thesis-menu">';
            thesis_nav_menu();
            echo '</div>';
        }
        if( ($left_search == '1') && ($left_search_location == 'below')){
            thesis_search_form();
        }
        echo '<div style="clear:both;"></div></div>';
        echo '<div style="clear:both;"></div>';
    }
    
}
add_action('thesis_hook_header','byobtshw_create_header_html');




function byobtshw_add_left_header_sidebar(){

    ?>
    <div id="header-left-sidebar" class="sidebar">
        <ul class="sidebar_list">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Left Header Area Widgets') ) { ?>
                <li class="widget">
                    <div class="widget_box">
                        <h3><?php _e('Left Header Area Widgets', 'thesis'); ?></h3>
                        <p>This is your new sidebar.  Add widgets here from your WP Dashboard just like normal.</p>
                    </div>
                </li>
            <?php } ?>
        </ul>    
    </div>
<?php 
}
function byobtshw_add_right_header_sidebar(){

    ?>
    <div id="header-right-sidebar" class="sidebar">
        <ul class="sidebar_list">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Header Area Widgets') ) { ?>
                <li class="widget">
                    <div class="widget_box">
                        <h3><?php _e('Right Header Area Widgets', 'thesis'); ?></h3>
                        <p>This is your new sidebar.  Add widgets here from your WP Dashboard just like normal.</p>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php 
}

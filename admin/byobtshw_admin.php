<?php

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_init', 'byobtshw_init' )
// ------------------------------------------------------------------------------


// Init plugin options to white list our options
function byobtshw_init(){

    register_setting( 'byobtshw_plugin_options', 'byobtshw_options', 'byobtshw_validate_options' );
    wp_register_style( 'byobtshw-options-stylesheet', plugins_url('options.css', __FILE__) );
        
    wp_enqueue_style('byobtshw-options-stylesheet');
    wp_enqueue_style('thesis-options-stylesheet', THESIS_CSS_FOLDER . '/options.css');
    wp_enqueue_script('color-picker', THESIS_SCRIPTS_FOLDER . '/jscolor/jscolor.js');
    wp_enqueue_script('jquery-ui-core'); #wp
    wp_enqueue_script('jquery-ui-sortable'); #wp
    wp_enqueue_script('jquery-ui-tabs'); #wp
    wp_enqueue_script('thesis-admin-js', THESIS_SCRIPTS_FOLDER . '/thesis.js');
}


// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_menu', 'byobtshw_add_options_page');
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_menu' HOOK FIRES, AND ADDS A NEW OPTIONS
// PAGE FOR YOUR PLUGIN TO THE SETTINGS MENU.
// ------------------------------------------------------------------------------

// Add menu page
function byobtshw_add_options_page() {
    global $_registered_pages;
    global $byobtshw_options_page;
      $pages = array();
      $pages = $_registered_pages;
    if(!$_registered_pages || !key_exists('toplevel_page_byob-thesis-plugins', $pages)){
        add_menu_page( 'BYOB Thesis Plugins', 'BYOB Thesis Plugins', 'manage_options', 'byob-thesis-plugins','byobtshw_render_byob_plugins_page', BYOBTSHW_PLUGIN_URL .'images/byob-icon-small.png');
    }
    $byobtshw_options_page = add_submenu_page('byob-thesis-plugins', 'BYOB Thesis Simple Header Widgets', 'Simple Header Widgets', 'manage_options', __FILE__, 'byobtshw_render_form');
    
    add_action("load-$byobtshw_options_page", 'byobtshw_plugin_help_tabs');
  
    
    $text = '<div class="metabox-prefs"><h2>BYOB Thesis Header Widgets Help</h2>';
    $text .= '<p>This plugin allows you to add widgets to the Thesis Header without creating custom code.  With it you can do any of the following:</p>';
    $text .= '<ul><li>Divide the header into left and right sides</li>';
    $text .= '<li>Add widgets to either side or both sides</li>';
    $text .= '<li>Define the height, width, background color and background image of the header area</li>';
    $text .= '<li>Define the height, width, background color and background image of either side of the header area</li>';
    $text .= '<li>Define the padding and margins for either side of the header area and for the entire header area</li>';
    $text .= '<li>Retain the default Thesis header functions for one of the sides(either left or right)</ul></li>';
    $text .= '<p style="color:blue;">Remember you set the default Thesis header options in Thesis Design Options and Thesis Header Image</p>';
    $text .= '<h3 style="border-top:#dddddd 1px solid;padding-top:10px;">Overall Header Area</h3>';
    $text .= '<p>This section allows you to set the options for the header container.  This container holds both the left and right header areas.';
    $text .= ' This header area is then divided into left and right sides (if only one header area is selected then only the left side is created).</p>';
    $text .= '<h3 style="border-top:#dddddd 1px solid;padding-top:10px;">Header Layout</h3>';
    $text .= '<p>This section gives you a graphic representation of the header and the configuration of the header areas.';
    
    $text .= '<h3 style="border-top:#dddddd 1px solid;padding-top:10px;">Determine where to place the CSS</h3>';
    $text .= '<p>CSS is the code that determines what your website looks like.  This plugin generates custom CSS based on the settings you choose.
            The choice you make here will <strong>slightly</strong> affect the speed of your site.  You have 2 choices:</p>';
    $text .= '<ul><li><strong>In the Head</strong> - This will write the CSS code to the head section of every page.  <span style="color:blue;">Choose this option if you
            are only using one or two BYOB Thesis Plugins.</span>  It will save an HTTP request.  Which will be slightly faster</li>';
    $text .= '<li><strong>In a separate file</strong> - This will write the code to a file called byob-custom.css, located in your custom folder.
            <span style="color:blue;">Choose this if you are using more than two of the BYOB Thesis Plugins.</span>  You will get an http request but the browser will cache the
            CSS file and it will not need to download it again.  This saves time on larger files.</li></ul>';
    $text .= '<h3 style="border-top:#dddddd 1px solid;padding-top:10px;">Left Header Area</h3>';
    $text .= '<p>This section allows you to set the options for the Left Header Area.  You can choose to retain default Thesis header functions as well as include the Thesis Nav Menu and Search Form.';
    $text .= ' Additional options become available if you choose to include a menu or search form in this area.</p>';

    $text .= '</div>';
    
    add_contextual_help( $byobtshw_options_page, $text );
    
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION SPECIFIED IN: add_options_page()
// ------------------------------------------------------------------------------
// THIS FUNCTION IS SPECIFIED IN add_options_page() AS THE CALLBACK FUNCTION THAT
// ACTUALLY RENDER THE PLUGIN OPTIONS FORM AS A SUB-MENU UNDER THE EXISTING
// SETTINGS ADMIN MENU.
// ------------------------------------------------------------------------------

// Render the Plugin options form


// Render the Plugin options form
function byobtshw_render_byob_plugins_page() {
	?>
	<div class="wrap">
		
		<!-- Display Plugin Icon, Header, and Description -->
		<div class="icon32"><img src="<?php echo BYOBTSHW_PLUGIN_URL . 'images/byob-icon.png';?>" /><br></div>
		<h2>BYOB Thesis Thesis Plugins</h2>
                <h4 style="color:orange">Premium members of BYOBWebsite.com have access to a number of specialized plugins for Thesis</h4>
		<p><strong>These plugins have been created in order to extend custom functionality to beginners and to save time for experts</strong></p>
                <p><a href="http://www.byobwebsite.com/plugins/">View a Complete List of Plugins available to members</a></p>
                <p><a href="http://www.byobwebsite.com/forum/">Get support and help using these plugins at our forum</a></p>
                <h2>Current Plugins Available</h2>
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis Feature Box</h3>
                <p>This plug allows you to access the feature box without having to add your own custom programming.  You can<br />
                choose to widgetize it, add custom HTML to it, or activate plugins like the Dynamic Content Gallery.</p>
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis Footer Widgets</h3>
                <p>This plugin allows you to create up to 3 rows of widgets, each with a maximum of 5 columns of widgets in the Thesis footer.
                You can mix and match the number of widget columns in each row and can specify the width of each widget column.  You can also
                customize the styling of the widget areas.  This plugin is only available via our Facebook Fan Page</p>
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis Header Widgets</h3>
                <p>This plug allows you to create one or two widget areas in the Thesis header.  Using it any widget can be placed in the Thesis header.
                You can either retain or replace the default Thesis header behavior.  You can also add the Thesis Nav Menu and or the search form to either of the header areas.  You can also
                customize the styles for each of the header areas.</p>
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis Landing Pages</h3>
                <p>This plug allows you to create landing pages by removing the Thesis header, footer and sidebars directly <br />
                from the post or page edit screen</p>
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis Mobile Content Switcher</h3>
                <p>This plug allows you to display content designed specifically for mobile devices on any post or page.  It will automatically detect
                a mobile device and will then replace the non mobile content for the mobile content.  You can have an unlimited number of switched blocks of 
                content on any post or page</p>                
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis Navigation Menu</h3>
                <p>This plug allows you to change a number of the default Thesis settings for the navigation menu.  Using this plugin<br />
                you can locate the menu either above or below the header, make the menu span the full width of the page, center the <br />
                navigation menu, and change default menu text styling.</p>
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis Sub Sidebars</h3>
                <p>This plug allows you to create "Sub Sidebars" that can be placed within either of the default Thesis sidebars.  Once created you
                can select which Sub Sidebars will be displayed on each post or page from the post or page edit screen.  These sidebars will show up in
                your sidebar list and you can drag any widgets into the sidebars.</p>                
                <h3 style="border-top:#dddddd 1px solid;padding-top:10px;">BYOB Thesis WP Menus</h3>
                <p>This plug allows you to create an unlimited number of WordPress menus and place them virtually anywhere on your site.  It also allows
                You to create new menu styles and apply those styles to the new WordPress menus.  The process of creating a new menu style is very much
                the same as styling the Thesis Nav Menu.  It also adds additional styling options for the Thesis Nav Menu.  It can work along side of the 
                BYOB Thesis Nav Menu plugin.</p>
	</div>
	<?php	
}


function byobtshw_plugin_help_tabs() {
	global $byobtshw_options_page;
	$screen = get_current_screen();
	if($screen->id != $byobtshw_options_page)
		return;
 
	$screen->add_help_tab(array(
		'id' => 'byobtshws-overview',
		'title' => __('Overview', 'byobtshw'),
		'content' => byobtshw_help_tab_content('byobtshw-overview')
	));
	$screen->add_help_tab(array(
		'id' => 'byobtshws-overall-header',
		'title' => __('Overall Header Settings', 'byobtshw'),
		'content' => byobtshw_help_tab_content('overall-header')
	));
	$screen->add_help_tab(array(
		'id' => 'byobtshws-header-layout',
		'title' => __('Header Layout', 'byobtshw'),
		'content' => byobtshw_help_tab_content('header-layout')
	));
        $screen->add_help_tab(array(
		'id' => 'byobtshws-css-location',
		'title' => __('CSS Location Settings', 'byobtshw'),
		'content' => byobtshw_help_tab_content('css-location')
	));
        $screen->add_help_tab(array(
		'id' => 'byobtshws-left-header',
		'title' => __('Left Header Area', 'byobtshw'),
		'content' => byobtshw_help_tab_content('left-header')
	));
        $screen->add_help_tab(array(
		'id' => 'byobtshws-right-header',
		'title' => __('Right Header Area', 'byobtshw'),
		'content' => byobtshw_help_tab_content('right-header')
	));
        $screen->add_help_tab(array(
		'id' => 'byobtshws-video-tutorials',
		'title' => __('Video Tutorials', 'byobtshw'),
		'content' => byobtshw_help_tab_content('video-tutorials')
	));
}


function byobtshw_help_tab_content($tab = 'byobtshw-overview') {
	if($tab == 'byobtshw-overview') {
		ob_start(); ?>
			<h3><?php _e('Using the plugin', 'byobtshw'); ?></h3>
			<p>The BYOB Thesis Simple Header Widgets plugin allows you to:</p>
                        <ul>
                            <li>Create one or two areas in the header, either horizontally or vertically (left and right or top and bottom). You can also</li>
                            <ul>
                                <li>Define their height, width, background color, and background image</li>
                                <li>Define their padding and margins</li>
                            </ul>
                            <li>Add any number of widgets to either of your areas</li>
                            <li>Make either widget area display the default Thesis header or exclude the default Thesis header behavior entirely</li>
                            <li>Add the Thesis Navigation Menu and search form to either header area</li>
                            <li>Place the CSS either in the head or in a separate CSS filed shared by all of the BYOB Thesis plugins</li>
                        </ul>
                            
		<?php
		return ob_get_clean();
	} elseif ($tab == 'overall-header') {
		ob_start(); ?>
			<h3><?php _e('Overall Header', 'byobtshw'); ?></h3>
			<p>The Overall Header is the main container for the header.  It wraps around and contains both the Left and Right Header Areas.</p>
                        <p>Settings in this section affect the overall header only.</p>
                        <h4>Number of Header Areas</h4>
                        <p>Choose whether the overall header should contain one or two Header Areas</p>
                        <h4>Header Height</h4>
                        <p>Specify the absolute height of the overall header area in pixels.  Enter numbers only.  The number must be positive and between 20 and 999.
                        This number will be over ridden if the contents of the header require more space than is specified.  <em>For example, if you specify
                        that the header should be 200 pixels tall but the header image is 300 pixels tall the header will expand to contain the full header
                        image.</em></p>
                        <h4>Header Margin</h4>
                        <p>Specify the desired margin for any or all sides of the Overall Header Area.  This setting is optional.  The margin is automatically set to 0 if no margin is specified. 
                            Enter numbers only.  Acceptable values are between -50 and 999<br />
                        <em>NOTE:  Margin is the space <strong>outside</strong> of the header moving it away from the edges of its container</em></p>
                        <h4>Header Padding</h4>
                        <p>Specify the desired padding for any or all sides of the Overall Header Area.  This setting is optional.  The padding is automatically set to 0 if no padding is specified. 
                            Enter numbers only.  Acceptable values are between 1 and 999<br />
                        <em>NOTE:  Padding is the space <strong>inside</strong> of the header moving its contents away from the edges of the header</em></p>
                        <p>TIP: To learn more about margins and padding, visit this website:<a href="http://www.w3schools.com/css/css_boxmodel.asp" title="Visti W3 Schools" target="_blank">www.w3schools.com/css/css_boxmodel.asp</a></p>
                        <h4>Header Background Color and Image</h4>
                        <p>The Overall Header background lies behind the left and right header areas.  If you specify a background for the left or right header areas it will cover the background of the Overall Header</p>
                        <ul>
                            <li>Customize the Overall Header Background Style? – If you wish to customize the background color or add a background image to the overall Header area, check this option and click on the Big Ass Save Button. After checking the box and saving, you’ll see additional available options for you to set.</li>
                            <li>Background Color - The default background color is white. You can keep the default color, change the default by typing the appropriate color code in the box under Background Color, or you can make the color transparent. <em>NOTE: You can combine a background color with a background image. Or you can make the color transparent and use a background image</em>.</li>
                            <li>Background Image – You add a background image from your Media Library by typing the image URL in the box under Background Image. There are other options for background images.
                                <ul>
                                    <li>You can choose to have the image repeat horizontally, vertically or not at all.</li>
                                    <li> You can position your image by indicating where the image must start horizontally and/or vertically.</li>
                                    <li>Or you can position your image by indicating the starting position relative to the top left corner of the header.  The value can be positive or negative and you can choose to use either pixels or percent.</li>
                                </ul>
                                </li>
                        </ul>
                        <p><em>NOTE: You can combine repeating the background image with either the Where to start option or by specifying the position with pixels. You can position the image either both vertically and horizontally, or in only one direction. If your image doesn’t require repetition, simply choose how to position the image horizontally and/or vertically.</em></p>

		<?php
		return ob_get_clean();
	} elseif ($tab == 'header-layout') {
		ob_start(); ?>
			<h3><?php _e('Header Layout', 'byobtshw'); ?></h3>
			<p>The Header Layout section graphically represents the header area configuration.  It will display how many header areas are configured and if they stack one on top of the other or sit side by side</p>
			
		<?php
		return ob_get_clean();
	} elseif ($tab == 'css-location') {
		ob_start(); ?>
			<h3><?php _e('Custom CSS Location', 'byobtshw'); ?></h3>
			<p>Where do you want the CSS placed? – This option allows you to control where the css generated by the plugin is located.  This can speed up the time your page loads. </p>
                        <p>Pick a Location: You can choose to either place the CSS in the head of each page or in a separate file.  If this is the only BYOB Thesis plugin you’re using then select the head.  If you’re using more than 2 BYOB Thesis plugins then select the file.</p>
			
		<?php
		return ob_get_clean();
	} elseif ($tab == 'left-header') {
		ob_start(); ?>
			<h3><?php _e('Left Header Area', 'byobtshw'); ?></h3>
			<p>This section allows you to configure the Left Header Area.  If only one header area is selected this is where that header area is configured.  If no width is specified for this header area then if will be full width and will be the "top" header area.</p>
                        <h3>Thesis Defaults</h3>
                        <p>This section allows you to select which Thesis default header functions you wish to include in this header area. These settings are optional. By default no Thesis default functions are included in any header area.</p>
                        <ul>
                            <li>Retain Default Thesis Functions in this Header Area? If you select this option the header area won’t be widgetized and will display the Title and Tagline settings from Thesis Design Options.</li>
                            <li>Place Thesis Nav Menu in this Header Area? Select this option if you wish to include the main Thesis navigation menu in this header area. Once the option is selected and saved you’ll be given another set of options.
                                <ul>
                                    <li> Menu Settings – Menu Settings allows you to position your Nav Menu either at the top of the header or at the bottom.</li>
                                    <li>You may also set top, bottom, and/or left side margins in pixels for the menu.</li>
                                    <li>You may also limit the width in pixels of the menu.</li>
                                </ul>
                            </li>
                            <li>Place the Search Bar in this Header Area? Select this option if you wish to include the main Thesis search form in this header area. Once the option is selected and saved you’ll be given another set of options.
                                <ul>
                                    <li> Search Bar Settings – Here you can opt to locate your search bar at the bottom or at the top of your header.</li> 
                                    <li>You may set top, bottom, and/or left side margins in pixels. </li>
                                    <li>You may also specify the search bar font size, padding, and width in pixels.</li>
                                </ul>
                            </li>
                        </ul>
                        <h3>Left Header Area Height &amp; Width</h3>
                            <ul>
                                <li> Left Area Height: Enter the Height of Left Header Area (in pixels) – Numerals Only - This setting is optional but it can be useful in equalizing the heights of the left and right side header areas. If left blank, the header area will only be as tall as its contents require.</li>
                                <li>Left Area Width:  Enter the Width of Left Header Area (in pixels) – Numerals Only - Specify the desired width of the left header area. <strong>If a width is specified for the left header area, the right header area will sit beside the left header area and will be sized to take up the rest of the available space</strong>. If no width is specified the header areas will stack on top of each other.</li>
                            </ul>
                        <h3>Left Header Area Margin:</h3>
                        <p>You may set left, right, top, and/or bottom margins in pixels for your Left Header Area.
                        <em>NOTE: The margin in the space around the left header area pushes it away from the boundary of the overall header area</em>.</p>
                        <h3>Left Header Area Padding:</h3>
                        <p>Specify the desired padding inside of the Overall Header Area This setting is optional. The padding is automatically set to 0 if no padding is specified.  <em>NOTE: Padding is the space inside of the header moving the contents of the header inward, away from the edges of the header</em></p>
                        <h3> Left Header Background Color &amp; Image:</h3>
                        <p>Customize the Left Header Background Style?  Check box next to Customize the background style.<br />
                        <em>NOTE: Background style options available here are the same as options available in the Overall Header Background Style.</em></p>
                        <h3>Left Header Area Text Alignment</h3>
                        <p>This option allows you to specify the text alignment property for this header area. It allows you to center the contents in the header area or to align contents to the left or right.</p>
                        
			
		<?php
		return ob_get_clean();
	} elseif ($tab == 'right-header') {
		ob_start(); ?>
			<h3><?php _e('Right Header Area', 'byobtshw'); ?></h3>
			<p>Same as the Left Header Area - except that you cannot specify a width for the Right Header Area.  The Right Header Area width is either the full width of the header or is the remaining width of the header beside the left header area</p>
		<?php
		return ob_get_clean();
	} elseif ($tab == 'video-tutorials') {
		ob_start(); ?>
			<h3><?php _e('Video Tutorials', 'byobtshw'); ?></h3>
			<p>For a complete set of video tutorials on how to use this plugin please visit <a href="http://www.byobwebsite.com/plugins/byob-thesis-simple-header-widgets-plugin/" target="_blank">www.byobwebsite.com/plugins/byob-thesis-simple-header-widgets-plugin/</a></p>
		<?php
		return ob_get_clean();
	}	
}

// ------------------------------------------------------------------------------
//  CALLBACK FUNCTION for  byobtshw_render_form()
//  Tests to see if the thesis/custom/ or thesis/custom-sample/ directories exist
//  and are writeable.  If not an error message is displayed on the plugin options
//  form
// ------------------------------------------------------------------------------

function byobtshw_writeable_check(){
    $custom_file = STYLESHEETPATH . '/custom';
    $custom_sample_file = STYLESHEETPATH . '/custom-sample';
    $writeable_message = '<p>Your Thesis Custom Folder is not writeable.  For best results, change the permissions on your Thesis 
        Custom Folder.  This typically should be 755, but may need to be 775 or 777 on some hosts.  If you have problems with this
        contact your hosting provider.</p>';
    
    if(is_writable($custom_file)){
        $writeable_message = '';
    }elseif(is_writable($custom_sample_file)){
         $writeable_message = '';
    }
    
    return  $writeable_message;
}

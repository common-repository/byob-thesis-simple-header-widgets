<?php

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION SPECIFIED IN: byobtshw_plugin_startup()
// ------------------------------------------------------------------------------

function byobtshw_plugin_option_defaults(){
    $tmp = get_option('byobtshw_options');       
    if(!is_array($tmp)) {
        $arr = array( 
                        'header_areas' => 'one'
                    );
        update_option('byobtshw_options', $arr);
    }else{
        $css_location = $tmp['css_location'];
        if($css_location == 'file'){
            byobtshw_write_css_file();
        }
    }      
}



// ------------------------------------------------------------------------------
// CALLBACK FUNCTION SPECIFIED IN: add_options_page()
// ------------------------------------------------------------------------------


// Render the Plugin options form

function byobtshw_render_form() {
    
    if(!class_exists('Thesis_CSS')){ // Test to make sure that Thesis is active
        wp_die ('This plugin only works with the <strong>Thesis Theme</strong> version 1.8 or higher.');
    }
    
    $plugin_data = get_plugin_data ( BYOBTSHW_PLUGIN_DIR . 'byob-thesis-simple-header-widgets.php' , $markup = true );;
    $writeable_message = byobtshw_writeable_check();
    if($writeable_message){
        echo '<div class="warning">' . $writeable_message . '</div>';
    }
    ?>
    <div class="wrap">

            <!-- Display Plugin Icon, Header, and Description -->
            <div class="icon32"><img src="<?php echo BYOBTSHW_PLUGIN_URL . 'images/byob-icon.png';?>" /><br></div>
            <h2><?php _e('BYOB Thesis Simple Header Widgets Options - <em>Version ', 'byobtshw'); echo $plugin_data['Version']; ?></em> </h2>
            <h4 style="color:orange"><?php _e('For help using this plugin see the <em>Help</em> tab in the upper right corner of this window.', 'byobtshw');?></h4>
            
    </div>
    <div id="thesis_options" class="wrap">
    <!-- Beginning of the Plugin Options Form -->
        <form method="post" action="options.php">
            <?php 
            settings_fields('byobtshw_plugin_options');
            $options = get_option('byobtshw_options'); 
            $header_areas = $options['header_areas'];
            $css_location = $options['css_location'];
            $main_background_image = $options['main_background_image'];
            $left_background_image = $options['left_background_image'];
            $right_background_image = $options['right_background_image'];
            $left_menu = $options['left_menu'];
            $right_menu = $options['right_menu'];
            $left_search = $options['left_search'];
            $right_search = $options['right_search'];
            $left_width = $options['left_width'];
            
            

            if ($header_areas == 'two'){
                $header_location = array('left', 'right');
            }else{
                $header_location = array('left');
            }

            ?>
            <div class="options_column">  <!-- Top of the First Column in the Options Form -->
                <div class="options_module" id="overall-header">
                    <h3><?php _e('Overall Header', 'byobtshw'); ?></h3>
                    <p><?php _e('Set the options for the overall header.', 'byobtshw'); ?></p>
                    
                    <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Number of Header Areas', 'byobtshw'); ?></h4>
                        <div class="more_info">
                        <p><?php _e('Divide the Header into how many areas?', 'byobtshw'); ?></p>
                            <ul class="column_structure" id="header_areas">
                                <li>
                                    <label><input name="byobtshw_options[header_areas]" type="radio" value="one" <?php checked('one', $options['header_areas']); ?> /> One Area</label><br />
                                </li>
                                <li>
                                    <label><input name="byobtshw_options[header_areas]" type="radio" value="two" <?php checked('two', $options['header_areas']); ?> /> Two Areas</label><br />
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Header Height', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <p><?php _e('Overall Header Height:', 'byobtshw'); ?></p>
                            <p class="form_input add_margin">
                                <input type="text" class="short" name="byobtshw_options[main_height]" value="<?php echo $options['main_height']; ?>" />
                                <label for="byobtshw_options[main_height]" class="inline"><?php _e('Enter the overall height of the Header - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                            </p>
                        </div>
                    </div>
                    
                    <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Header Margin', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <?php
                            $widget_option = 'main';
                            $padding_area = 'Overall Header ';
                            byobtshw_margin_styles($widget_option, $padding_area);
                            ?>
                        </div>
                    </div>

                    <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Header Padding', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <?php
                            byobtshw_padding_styles($widget_option, $padding_area);
                            ?>
                        </div>
                    </div>

                    <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Header Background Color & Image', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <p><?php _e('Customize the Overall Header Background Style?', 'byobtshw'); ?></p>
                            <ul class="column_structure" id="menu_visibility">
                                <li>
                                    <label style="color: #ec902d;"><input name="byobtshw_options[main_customize_background]" type="checkbox" value="1" <?php if (isset($options['main_customize_background'])) { checked('1', $options['main_customize_background']); } ?> /><?php _e(' Customize the the background styles', 'byobtshw'); ?></label><br />
                                </li>
                            </ul>
                            <p class="tip"><?php _e('Check the box and hit the big save button to see the background style options.', 'byobtshw'); ?></p>
                            <?php
                            $customize = $options['main_customize_background'];
                            if($customize == '1'){
                            ?>
                                <br />
                                <h4><?php _e('Background Color', 'byobtshw'); ?></h4>
                                <?php
                                byobtshw_background_color_styles($widget_option);
                                ?>
                                <br />
                                <h4><?php _e('Background Image', 'byobtshw'); ?></h4>
                                <?php
                                byobtshw_background_image_styles($widget_option);
                                ?>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="options_module">
                    <h3><?php _e('Header Layout', 'byobtshw'); ?></h3>
                    <div class="module_subsection">
                        <ul class="column_structure">
                        <?php 
                            if($header_areas == 'two'){
                                if($left_width != ''){
                                    ?>
                                    <li>
                                        <p><span class="col_half"><?php _e('Left Header Area', 'byobtshw'); ?></span><span class="col_half no_margin"><?php _e('Right Header Area', 'byobtshw'); ?></span></p>
                                    </li>
                                    <?php
                                }else{
                                    ?>
                                    <li>
                                        <p><span class="col_full"><?php _e('Left Header Area', 'byobtshw'); ?></span></p>
                                    </li>
                                    <li>
                                        <p><span class="col_full"><?php _e('Right Header Area', 'byobtshw'); ?></span></p>
                                    </li>
                                    <li>
                                        <p class="tip"><?php _e('To make the Header Areas stack side by side, give the Left Header Area a width', 'byobtshw'); ?></p>
                                    </li>
                                    <?php
                                }
                            }else{
                                ?>
                                <li>
                                    <p><span class="col_full"><?php _e('Left Header Area', 'byobtshw'); ?></span></p>
                                </li>
                                <?php
                            }
                        ?>
                        </ul>
                    </div>
                </div>
                
                <div class="options_module" id="menu-css-location">
                    <h3><?php _e('Custom CSS Location', 'byobtshw'); ?></h3>
                        <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Where do you want the CSS placed?', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <p><?php _e('Pick a Location:', 'byobtshw'); ?></p>
                            <p><span style="font-style:italic"><?php _e('You can place the CSS either in the head of the page or in a
                                    separate file called byob-custom.css that is placed in your custom folder.', 'byobtshw'); ?></span></p>
                            <p class="form_input add_margin" id="letter_spacing">
                                <select name='byobtshw_options[css_location]'>
                                    <option value='head' <?php selected('head', $options['css_location']); ?>><?php _e('In the HEAD of the page', 'byobtshw'); ?></option>
                                    <option value='file' <?php selected('file', $options['css_location']); ?>><?php _e('In a separate CSS file', 'byobtshw'); ?></option>
                                </select>
                            </p>
                            <p style="color:orange;"><?php _e('If you are only using one or two of the BYOB Thesis Plugins then selecting the HEAD
                            will reduce HTTP requests. However if you are using more than 2 then select the separate file.  This file will be cached by the browser
                            offsetting the HTTP request with decreased load times.', 'byobtshw'); ?>
                            </p>
                        </div>
                    </div>
               </div>
            </div>  <!-- Bottom of the First Column in the Options Form -->
            
            <?php
            foreach($header_location as $location){
                if ($location == 'right'){
                    $widget_option = 'right';
                    $padding_area = 'Right Header ';
                }else{
                    $widget_option = 'left';
                    $padding_area = 'Left Header ';
                }  
                
                $menu_here = $options[$location . '_menu'];
                $search_here = $options[$location . '_search'];
            
            ?>
            <div class="options_column">  <!-- Top of the Second & Third Columns in the Options Form -->
                <?php
                    if ($location == 'left'){
                        ?>
                        <div class="options_module button_module">
                            <input type="submit" class="save_button" id="design_submit" name="submit" value="<?php thesis_save_button_text(); ?>" />
                        </div>
                        <?php
                    }
                    ?>
                
                <div class="options_module" id="<?php echo $location; ?>-header">
                    <h3><?php _e($padding_area . 'Area', 'byobtshw'); ?></h3>
                    <?php
                    if ($location == 'left'){
                        ?>
                        <p><em><?php _e('If there is only one Header Area these options control it', 'byobtshw'); ?></em></p>
                        <?php
                    }
                    ?>
                    
                    <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Thesis Defaults', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <ul class="column_structure" id="<?php echo $location; ?>-widgetize">
                                <li>
                                    <input style="margin-right:5px" name="byobtshw_options[<?php echo $location; ?>_widgetize]" type="checkbox" value="1" <?php if (isset($options[$location . '_widgetize'])) { checked('1', $options[$location . '_widgetize']); } ?> /><label><?php _e(' Retain Default Thesis Header Functions in this Header Area?', 'byobtshw'); ?></label>
                                </li>
                             </ul>
                             <p class="tip"><?php _e('Do not check the box above if you wish to add widgets to this Header Area', 'byobtshw'); ?></p>
                             <br />
                             <ul class="column_structure" id="<?php echo $location; ?>-menu">
                                <li>
                                    <input style="margin-right:5px" name="byobtshw_options[<?php echo $location; ?>_menu]" type="checkbox" value="1" <?php if (isset($options[$location . '_menu'])) { checked('1', $options[$location . '_menu']); } ?> /><label><?php _e(' Place Thesis Nav Menu in this Header Area?', 'byobtshw'); ?></label>
                                </li>
                             </ul>
                             <ul class="column_structure" id="<?php echo $location; ?>-search">
                                <li>
                                    <input style="margin-right:5px" name="byobtshw_options[<?php echo $location; ?>_search]" type="checkbox" value="1" <?php if (isset($options[$location . '_search'])) { checked('1', $options[$location . '_search']); } ?> /><label><?php _e(' Place the Search Bar in this Header Area?', 'byobtshw'); ?></label>
                                </li>
                             </ul>
                         </div>
                     </div>
                    <?php
                    if($menu_here){
                    ?>
                        <div class="module_subsection">
                            <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Menu Settings', 'byobtshw'); ?></h4>
                            <div class="more_info">
                                <p><?php _e('Select the Position of the Menu:', 'byobtshw'); ?></p>
                                <p class="form_input add_margin" id="menu_location">
                                    <select name='byobtshw_options[<?php echo $location; ?>_menu_location]'>
                                        <option value='above' <?php selected('above', $options[$location . '_menu_location']); ?>><?php _e('At the Top of the Header', 'byobtshw'); ?></option>
                                        <option value='below' <?php selected('below', $options[$location . '_menu_location']); ?>><?php _e('At the Bottom of the Header', 'byobtshw'); ?></option>
                                    </select>
                                </p>
                            <?php 
                            if (is_plugin_active('byob-thesis-nav-menu/byob-thesis-nav-menu.php')) { 
                                echo '<p style="color:orange;"><strong>The Remaining Settings for the Thesis Nav Menu are controlled by the BYOB Thesis Nav Menu Plugin</strong></p>';                        
                            }else{ 
                            ?>                         
                                <p><span style="font-style:italic"><?php _e('This can be used to separate the menu from the header or content. The left margin can be used to "center" the menu', 'byobtshw'); ?></span></p>
                                <div id="menu_top_margin">
                                    <p><?php _e('Top Margin:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[menu_top_margin]" value="<?php echo $options['menu_top_margin']; ?>" />
                                        <label for="byobtshw_options[menu_top_margin]" class="inline"><?php _e('Enter the desired margin above the menu (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="menu_bottom_margin">
                                    <p><?php _e('Bottom Margin:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[menu_bottom_margin]" value="<?php echo $options['menu_bottom_margin']; ?>" />
                                        <label for="byobtshw_options[menu_bottom_margin]" class="inline"><?php _e('Enter the desired margin below the menu (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="menu_left_margin">
                                    <p><?php _e('Left Side Margin:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[menu_left_margin]" value="<?php echo $options['menu_left_margin']; ?>" />
                                        <label for="byobtshw_options[menu_left_margin]" class="inline"><?php _e('Enter the desired margin on the left side of the menu (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="menu_width">
                                    <p><?php _e('Overall Menu Width:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[menu_width]" value="<?php echo $options['menu_width']; ?>" />
                                        <label for="byobtshw_options[menu_width]" class="inline"><?php _e('If you are using the left margin, for IE you need to specify the final menu width  (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>                      
                    <?php
                    }
                    if($search_here){
                    ?>
                        <div class="module_subsection">                                
                            <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e('Search Bar Settings', 'byobtshw'); ?></h4>
                            <div class="more_info">
                                <p><span style="font-style:italic"><?php _e('This can be used to position the Search Bar', 'byobtshw'); ?></span></p>
                                <p><?php _e('Select the Position of Search Bar:', 'byobtshw'); ?></p>
                                <p class="form_input add_margin" id="menu_location">
                                    <select name='byobtshw_options[<?php echo $location; ?>_search_location]'>
                                        <option value='above' <?php selected('above', $options[$location . '_search_location']); ?>><?php _e('At the Top of the Header', 'byobtshw'); ?></option>
                                        <option value='below' <?php selected('below', $options[$location . '_search_location']); ?>><?php _e('At the Bottom of the Header', 'byobtshw'); ?></option>
                                    </select>
                                </p>
                                <div id="search_top_margin">
                                    <p><?php _e('Top Margin:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[search_top_margin]" value="<?php echo $options['search_top_margin']; ?>" />
                                        <label for="byobtshw_options[search_top_margin]" class="inline"><?php _e('Enter the desired margin above the menu (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="search_bottom_margin">
                                    <p><?php _e('Bottom Margin:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[search_bottom_margin]" value="<?php echo $options['search_bottom_margin']; ?>" />
                                        <label for="byobtshw_options[search_bottom_margin]" class="inline"><?php _e('Enter the desired margin below the menu (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="search_left_margin">
                                    <p><?php _e('Left Side Margin:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[search_left_margin]" value="<?php echo $options['search_left_margin']; ?>" />
                                        <label for="byobtshw_options[search_left_margin]" class="inline"><?php _e('Enter the desired margin on the left side of the menu (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="search_font">
                                    <p><?php _e('Search Bar Font Size:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[search_font_size]" value="<?php echo $options['search_font_size']; ?>" />
                                        <label for="byobtshw_options[search_font_size]" class="inline"><?php _e('Enter the desired size of the font (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="search_padding">
                                    <p><?php _e('Search Bar Padding:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[search_padding]" value="<?php echo $options['search_padding']; ?>" />
                                        <label for="byobtshw_options[search_padding]" class="inline"><?php _e('Enter the desired padding within the Seach Bar (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                <div id="search_width">
                                    <p><?php _e('Search Bar Width:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[search_width]" value="<?php echo $options['search_width']; ?>" />
                                        <label for="byobtshw_options[search_width]" class="inline"><?php _e('Enter the desired width of the Search Bar (in pixels) - <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                            </div>                                
                        </div>
                    <?php
                    }
                        ?>
                    <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e($padding_area . 'Area Height & Width', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <div id="<?php echo $location; ?>_height">
                                <p><?php _e($padding_area . 'Area Height:', 'byobtshw'); ?></p>
                                <p class="form_input add_margin">
                                    <input type="text" class="short" name="byobtshw_options[<?php echo $location; ?>_height]" value="<?php echo $options[$location . '_height']; ?>" />
                                    <label for="byobtshw_options[<?php echo $location; ?>_height]" class="inline"><?php _e('Enter the height of the ' . $padding_area . ' Area- <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                </p>
                            </div>
                             <?php
                            if($header_areas == 'two' && $location == 'left'){
                                ?>
                                <div id="<?php echo $location; ?>_width">
                                    <p><?php _e($padding_area . 'Area Width:', 'byobtshw'); ?></p>
                                    <p class="form_input add_margin">
                                        <input type="text" class="short" name="byobtshw_options[<?php echo $location; ?>_width]" value="<?php echo $options[$location . '_width']; ?>" />
                                        <label for="byobtshw_options[<?php echo $location; ?>_width]" class="inline"><?php _e('Enter the width of the ' . $padding_area . ' Area- <strong>Numerals Only</strong>', 'byobtshw'); ?> </label>
                                    </p>
                                </div>
                                 <?php
                            }elseif($header_areas != 'two'){
                                ?>
                                <p class="tip"><?php _e('When there is only one Header Area, the Left Header Area is the full width of the header.', 'byobtshw'); ?></p>
                                <?php
                            }elseif($header_areas == 'two' && $location != 'left'){
                                ?>
                                <p class="tip"><?php _e('The width of the Right Header Area width is automatically calculated.  It is the difference between the width of the page less the Left Header Area.', 'byobtshw'); ?></p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                     <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e($padding_area . 'Area Margin', 'byobtshw'); ?></h4>
                        <div class="more_info">
                              <?php
                                byobtshw_margin_styles($widget_option, $padding_area);
                                ?>
                         </div>
                     </div>
                        
                     <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e($padding_area . 'Area Padding', 'byobtshw'); ?></h4>
                        <div class="more_info">
                           <?php
                            byobtshw_padding_styles($widget_option, $padding_area);
                            ?>
                        </div>
                     </div>
                        
                     <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e($padding_area . ' Background Color & Image', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <p><?php _e('Customize the ' .$location . ' Area Background Style?', 'byobtshw'); ?></p>
                            <ul class="column_structure" id="menu_visibility">
                                <li>
                                    <label style="color: #ec902d;"><input name="byobtshw_options[<?php echo $location; ?>_customize_background]" type="checkbox" value="1" <?php if (isset($options[$location . '_customize_background'])) { checked('1', $options[$location . '_customize_background']); } ?> /> <?php _e(' Customize the the background styles', 'byobtshw'); ?></label><br />
                                </li>
                            </ul>
                            <p class="tip"><?php _e('Check the box and hit the big save button to see the background style options.', 'byobtshw'); ?></p>
                            <?php
                            $customize = $options[$location . '_customize_background'];
                            if($customize == '1'){
                                ?>
                                <br />
                                <h4><?php _e('Background Color', 'byobtshw'); ?></h4>
                                <?php
                                byobtshw_background_color_styles($widget_option);
                                ?>
                                <br />
                                <h4><?php _e('Background Image', 'byobtshw'); ?></h4>
                                <?php
                                byobtshw_background_image_styles($widget_option);
                                ?>
                                <?php
                            }
                            ?>
                         </div>
                     </div>
                        
                     <div class="module_subsection">
                        <h4 class="module_switch"><a href="" title="<?php _e('Show/hide additional information', 'byobtshw'); ?>"><span class="pos">+</span><span class="neg">&#8211;</span></a><?php _e($padding_area . ' Area Text Alignment', 'byobtshw'); ?></h4>
                        <div class="more_info">
                            <p><?php _e('Text Alignment:', 'byobtshw'); ?></p>
                            <ul class="column_structure">
                                <li>
                                    <input name="byobtshw_options[<?php echo $location; ?>_header_area_text_align]" type="radio" value="left" <?php checked('left', $options[$location . '_header_area_text_align']); ?> /> <label><?php _e('  Left', 'byobtshw'); ?></label>
                                </li>
                                <li>
                                    <input name="byobtshw_options[<?php echo $location; ?>_header_area_text_align]" type="radio" value="center" <?php checked('center', $options[$location . '_header_area_text_align']); ?> /> <label><?php _e(' Center', 'byobtshw'); ?></label>
                                </li>
                                <li>
                                    <input name="byobtshw_options[<?php echo $location; ?>_header_area_text_align]" type="radio" value="right" <?php checked('right', $options[$location . '_header_area_text_align']); ?> /> <label><?php _e(' Right', 'byobtshw'); ?></label>
                                </li>
                            </ul>
                        </div>
                    </div> 
                </div>
             </div>

            <?php
            }
            ?> 
        </form>
    </div>

    <?php	
//     print_r($options);           
    if($css_location == 'file'){
        byobtshw_write_css_file();
    }
}

function byobtshw_padding_styles($widget_option, $padding_area){
    $options = get_option('byobtshw_options');
    ?>
    
    <div id="widget_top_padding">
        <p><?php _e($padding_area. ' Top Padding:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_padding_top]" value="<?php echo $options[$widget_option . '_padding_top']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_padding_top]" class="inline"><?php _e('Enter the desired padding at the top of the ' . $padding_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <div id="widget_bottom_padding">
        <p><?php _e($padding_area. ' Bottom Padding:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_padding_bottom]" value="<?php echo $options[$widget_option . '_padding_bottom']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_padding_bottom]" class="inline"><?php _e('Enter the desired padding at the bottom of the ' . $padding_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <div id="widget_left_padding">
        <p><?php _e($padding_area. ' Left Padding:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_padding_left]" value="<?php echo $options[$widget_option . '_padding_left']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_padding_left]" class="inline"><?php _e('Enter the desired padding on the left side of the ' . $padding_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <div id="widget_right_padding">
        <p><?php _e($padding_area. ' Right Padding:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_padding_right]" value="<?php echo $options[$widget_option . '_padding_right']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_padding_right]" class="inline"><?php _e('Enter the desired padding on the right side of the ' . $padding_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <?php
}

function byobtshw_margin_styles($widget_option, $margin_area){
    $options = get_option('byobtshw_options');
    ?>
    
    <div id="widget_top_margin">
        <p><?php _e($margin_area. ' Top margin:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_margin_top]" value="<?php echo $options[$widget_option . '_margin_top']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_margin_top]" class="inline"><?php _e('Enter the desired margin at the top of the ' . $margin_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <div id="widget_bottom_margin">
        <p><?php _e($margin_area. ' Bottom margin:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_margin_bottom]" value="<?php echo $options[$widget_option . '_margin_bottom']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_margin_bottom]" class="inline"><?php _e('Enter the desired margin at the bottom of the ' . $margin_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <div id="widget_left_margin">
        <p><?php _e($margin_area. ' Left margin:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_margin_left]" value="<?php echo $options[$widget_option . '_margin_left']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_margin_left]" class="inline"><?php _e('Enter the desired margin on the left side of the ' . $margin_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <div id="widget_right_margin">
        <p><?php _e($margin_area. ' Right margin:', 'thesis'); ?></p>
        <p class="form_input add_margin">
            <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_margin_right]" value="<?php echo $options[$widget_option . '_margin_right']; ?>" />
            <label for="byobtshw_options[<?php echo $widget_option; ?>_margin_right]" class="inline"><?php _e('Enter the desired margin on the right side of the ' . $margin_area . ' (in pixels) - <strong>Numerals Only</strong>', 'thesis'); ?> </label>
        </p>
    </div>
    <?php
}

function byobtshw_background_color_styles($widget_option){
    $options = get_option('byobtshw_options');
    ?>
    <p class="form_input add_margin">
        <input class="short color" type="text" name="byobtshw_options[<?php echo $widget_option; ?>_background_color]" value="<?php echo $options[$widget_option . '_background_color']; ?>" maxlength="6" />
        <label class="inline" for="byobtshw_options[<?php echo $widget_option; ?>_background_color]"><?php _e('Background Color', 'thesis'); ?></label>
    </p>
    <ul class="column_structure" id="_background_transparent">
        <li>
            <input name="byobtshw_options[<?php echo $widget_option; ?>_background_transparent]" type="checkbox" value="1" <?php if (isset($options[$widget_option . '_background_transparent'])) { checked('1', $options[$widget_option . '_background_transparent']); } ?> /><label> Make the background transparent</label><br />
        </li>
    </ul>
    <?php
}

function byobtshw_background_image_styles($widget_option){
    $options = get_option('byobtshw_options');
    ?>
    
    <p class="form_input add_margin">
        <input type="text" class="text_input" name="byobtshw_options[<?php echo $widget_option; ?>_background_image]" value="<?php echo $options[$widget_option . '_background_image']; ?>" />
        <label for="byobtshw_options[<?php echo $widget_option; ?>_background_image]" class="inline"><?php _e('Enter the URL of the background image', 'byobtshw'); ?> </label>
    </p>
    <p><?php _e('Repeat the background image to fill the available space?', 'byobtshw'); ?></p>
    <p class="form_input add_margin" id="background-repeat">
        <select name='byobtshw_options[<?php echo $widget_option; ?>_background_repeat]'>
            <option value='repeat' <?php selected('repeat', $options[$widget_option . '_background_repeat']); ?>><?php _e('Repeat in Both Directions', 'byobtshw'); ?></option>
            <option value='no-repeat' <?php selected('no-repeat', $options[$widget_option . '_background_repeat']); ?>><?php _e('No Repeat', 'byobtshw'); ?></option>
            <option value='repeat-x' <?php selected('repeat-x', $options[$widget_option . '_background_repeat']); ?>><?php _e('Repeat Horizontally', 'byobtshw'); ?></option>
            <option value='repeat-y' <?php selected('repeat-y', $options[$widget_option . '_background_repeat']); ?>><?php _e('Repeat Vertically', 'byobtshw'); ?></option>
        </select>
    </p>
    <p><?php _e('Where to start the background image:', 'byobtshw'); ?></p>
    <p class="form_input add_margin" id="background-repeat">
        <select name='byobtshw_options[<?php echo $widget_option; ?>_background_position_hv]'>
            <option value='top left' <?php selected('top left', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Top Left', 'byobtshw'); ?></option>
            <option value='top center' <?php selected('top center', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Top Center', 'byobtshw'); ?></option>
            <option value='top right' <?php selected('top right', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Top Right', 'byobtshw'); ?></option>
            <option value='center left' <?php selected('center left', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Middle Left', 'byobtshw'); ?></option>
            <option value='center center' <?php selected('center center', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Middle Center', 'byobtshw'); ?></option>
            <option value='center right' <?php selected('center right', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Middle Right', 'byobtshw'); ?></option>
            <option value='bottom left' <?php selected('bottom left', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Bottom Left', 'byobtshw'); ?></option>
            <option value='bottom center' <?php selected('bottom center', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Bottom Center', 'byobtshw'); ?></option>
            <option value='bottom right' <?php selected('bottom right', $options[$widget_option . '_background_position_hv']); ?>><?php _e('Bottom Right', 'byobtshw'); ?></option>
        </select>
    </p>
    <p><?php _e('Or specify a horizontal and vertical position from the top left corner', 'byobtshw'); ?></p>
    <p><?php _e('Horizontal Position', 'byobtshw'); ?></p>
    <p class="form_input add_margin">
        <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_background_image_x_pos]" value="<?php echo $options[$widget_option . '_background_image_x_pos']; ?>" />
        <select style="width:100px; margin-left:5px;" name='byobtshw_options[<?php echo $widget_option; ?>_x_pos_units]'>
            <option value='px' <?php selected('px', $options[$widget_option . '_x_pos_units']); ?>><?php _e('In pixels', 'byobtshw'); ?></option>
            <option value='%' <?php selected('%', $options[$widget_option . '_x_pos_units']); ?>><?php _e('Percent', 'byobtshw'); ?></option>
        </select><br />
        <label for="byobtshw_options[<?php echo $widget_option; ?>_background_image_x_pos]" class="inline"><?php _e('Positive numbers move the image toward the right - in pixels', 'byobtshw'); ?> </label>
    </p>
    <p><?php _e('Vertical Position', 'byobtshw'); ?></p>
    <p class="form_input add_margin">
        <input type="text" class="short" name="byobtshw_options[<?php echo $widget_option; ?>_background_image_y_pos]" value="<?php echo $options[$widget_option . '_background_image_y_pos']; ?>" />
        <select style="width:100px; margin-left:5px;" name='byobtshw_options[<?php echo $widget_option; ?>_y_pos_units]'>
            <option value='px' <?php selected('px', $options[$widget_option . '_y_pos_units']); ?>><?php _e('In pixels', 'byobtshw'); ?></option>
            <option value='%' <?php selected('%', $options[$widget_option . '_y_pos_units']); ?>><?php _e('Percent', 'byobtshw'); ?></option>
        </select><br />
        <label for="byobtshw_options[<?php echo $widget_option; ?>_background_image_y_pos]" class="inline"><?php _e('Positive numbers move the image toward the bottom - in pixels', 'byobtshw'); ?> </label>
    </p>
    <?php
}


// Sanitize and validate input. Accepts an array, return a sanitized array.
function byobtshw_validate_options($input) {
    
    $areas = array('main', 'left', 'right');
    $sides = array('_top', '_right', '_bottom', '_left');
    $add_ons = array('menu', 'search');
    $add_on_sides = array('_top', '_bottom', '_left');
    
    
    // calculate & store optimal width
    $calc_width = new Thesis_CSS;
    $calc_width->baselines();
    $calc_width->widths();
    $optimal_width = $calc_width->widths['container'] - ($calc_width->base['page_padding'] * 2);
    $input['optimal_width'] =  $optimal_width;
    
    // validate height
    foreach($areas as $area){
        $input[$area . '_height'] = filter_var($input[$area . '_height'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>20, "max_range"=>999)));
    }
    
    // validate width
    $input['left_width'] = filter_var($input['left_width'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>50, "max_range"=>($optimal_width - 50))));
    
    
    // validate margins
    foreach($areas as $area){
        foreach ($sides as $side){
            $input[$area . '_margin' . $side] = filter_var($input[$area . '_margin' . $side], FILTER_VALIDATE_INT, array("options" => array("min_range"=>-50, "max_range"=>999)));   
        }
    }
    
    // validate padding
    foreach($areas as $area){
        foreach ($sides as $side){
            $input[$area . '_padding' . $side] = filter_var($input[$area . '_padding' . $side], FILTER_VALIDATE_INT, array("options" => array("min_range"=>0, "max_range"=>999)));   
        }
    }
    
    // validate background image
    foreach($areas as $area){
        $input[$area . '_background_image'] =  esc_url_raw($input[$area . '_background_image']);
        $input[$area . '_background_image_x_pos'] = filter_var($input[$area . '_background_image_x_pos'], FILTER_VALIDATE_INT); 
        $input[$area . '_background_image_y_pos'] = filter_var($input[$area . '_background_image_y_pos'], FILTER_VALIDATE_INT);
    }
    
    // validate add on margins (search, menu)
    foreach($add_ons as $area){
        foreach ($add_on_sides as $side){
            $input[$area . $side . '_margin'] = filter_var($input[$area . $side . '_margin'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>-50, "max_range"=>999)));   
        }
    }
    
    // validate search font size
    $input['search_font_size'] = filter_var($input['search_font_size'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>8, "max_range"=>30)));
    
    // validate search padding
    $input['search_padding'] = filter_var($input['search_padding'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>0, "max_range"=>10)));
    
    // validate search width
    $input['search_width'] = filter_var($input['search_width'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>150, "max_range"=>500)));
    
    // validate menu width
    $input['menu_width'] = filter_var($input['menu_width'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>150, "max_range"=>$optimal_width)));   
        
        return $input;

}

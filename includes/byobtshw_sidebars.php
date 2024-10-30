<?php

function byobtshw_register_left_sidebar(){
    register_sidebar(array(
			'name' => 'Left Header Area Widgets',
                        'id' => 'header-widget-left',
			'before_widget' => '<li class="widget %2$s" id="%1$s">',
			'after_widget' => '</li>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
			));
}

function byobtshw_register_right_sidebar(){
    register_sidebar(array(
			'name' => 'Right Header Area Widgets',
                        'id' => 'header-widget-right',
			'before_widget' => '<li class="widget %2$s" id="%1$s">',
			'after_widget' => '</li>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
			));
}

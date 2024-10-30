<?php

// --------------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_uninstall_hook(__FILE__, 'byobtshw_delete_plugin_options')
// --------------------------------------------------------------------------------------


// Delete options table entries ONLY when plugin deactivated AND deleted
function byobtshw_delete_plugin_options() {
	delete_option('byobtshw_options');
}
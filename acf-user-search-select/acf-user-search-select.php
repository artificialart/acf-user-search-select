<?php

/*
Plugin Name: Advanced Custom Fields: User Search Select
Plugin URI: http://www.artificialart.co.uk
Description: Adds a User Search and Select field to Advanced Custom Fields. This field allows you to type the first 3 letters of a users name to start producing a list of results.
Version: 1.0.0
Author: Artificial Art Virtual ASP
Author URI: http://www.artificialart.co.uk
License: GPL
*/


class acf_field_user_search_select_plugin
{
	/*
	*  Construct
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function __construct()
	{
		// set text domain
		$domain = 'user-search-select';
		$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		load_textdomain( $domain, $mofile );
		
		
		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));	

		
		// version 3-
		add_action( 'init', array( $this, 'init' ));
	}
	
	
	/*
	*  Init
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function init()
	{
		if(function_exists('register_field'))
		{ 
			register_field('acf_field_location', dirname(__File__) . '/user-search-select-v3.phpp');
		}
	}
	
	/*
	*  register_fields
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function register_fields()
	{
		include_once('user-search-select-v4.php');
	}
	
}

new acf_field_user_search_select_plugin();

		
?>
<?php
/*
Plugin Name: Paste as Plain Text
Plugin URI: http://wordpress.org/plugins/paste-as-plain-text/
Description: Forces the WordPress editor to paste everything as plain text.
Version: 1.0.1
Author: Till Krüss
Author URI: http://till.kruss.me/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

class PasteAsPlainText {

	function __construct() {

		add_action( 'admin_init', array( $this, 'init' ) );

	}

	function init() {

		add_filter( 'tiny_mce_before_init', array( $this, 'force_paste_as_plain_text' ) );
		add_filter( 'teeny_mce_before_init', array( $this, 'force_paste_as_plain_text' ) );
		add_filter( 'teeny_mce_plugins', array( $this, 'load_paste_plugin' ) );
		add_filter( 'mce_buttons_2', array( $this, 'remove_button' ) );

	}

	function force_paste_as_plain_text( $mceInit ) {

		global $tinymce_version;

		if ( $tinymce_version[0] < 4 ) {
			$mceInit[ 'paste_text_sticky' ] = true;
			$mceInit[ 'paste_text_sticky_default' ] = true;
		} else {
			$mceInit[ 'paste_as_text' ] = true;
		}

		return $mceInit;
	}

	function load_paste_plugin( $plugins ) {

		return array_merge( $plugins, array( 'paste' ) );

	}

	function remove_button( $buttons ) {

		if( ( $key = array_search( 'pastetext', $buttons ) ) !== false ) {
			unset( $buttons[ $key ] );
		}

		return $buttons;

	}

}

new PasteAsPlainText();

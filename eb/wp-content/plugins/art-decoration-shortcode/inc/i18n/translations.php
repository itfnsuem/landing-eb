<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( '_WP_Editors' ) ) {
	require( ABSPATH . WPINC . '/class-wp-editor.php' );
}
function artabr_ads_button_translation() {
	$strings    = array(
		'decorations_shortcodes_title'   => __( 'Decorations Shortcodes', 'ads-shortcodes' ),
		'infobox_btn'                    => __( 'Infoboxes', 'ads-shortcodes' ),
		'warning_title'                  => __( 'Warning', 'ads-shortcodes' ),
		'warning_title_open_windows'     => __( 'Warning Window', 'ads-shortcodes' ),
		'advice_title'                   => __( 'Advice', 'ads-shortcodes' ),
		'advice_title_open_windows'      => __( 'Advice Window', 'ads-shortcodes' ),
		'note_title'                     => __( 'Note', 'ads-shortcodes' ),
		'note_title_open_windows'        => __( 'Note Window', 'ads-shortcodes' ),
		'info_title'                     => __( 'Info', 'ads-shortcodes' ),
		'info_title_open_windows'        => __( 'Info Window', 'ads-shortcodes' ),
		'custom_title'                   => __( 'Custom box', 'ads-shortcodes' ),
		'custom_title_open_windows'      => __( 'Custom box Window', 'ads-shortcodes' ),
		'label_windows_add_text'         => __( 'Add Text', 'ads-shortcodes' ),
		'addon_class'                    => __( 'Add class', 'ads-shortcodes' ),
		'title_windows_add_text'         => __( 'Title', 'ads-shortcodes' ),
		'buttons_title'                  => __( 'Buttons', 'ads-shortcodes' ),
		'buttons_title_open_windows'     => __( 'Buttons Window', 'ads-shortcodes' ),
		'buttons_inscription'            => __( 'The inscription on the button', 'ads-shortcodes' ),
		'buttons_link'                   => __( 'Add a link', 'ads-shortcodes' ),
		'buttons_effect'                 => __( 'Add hover effect', 'ads-shortcodes' ),
		'buttons_icon'                   => __( 'Add a icon', 'ads-shortcodes' ),
		'buttons_target_blank'           => __( 'Open in a new window?', 'ads-shortcodes' ),
		'columns_title'                  => __( 'Columns', 'ads-shortcodes' ),
		'columns_hedline'                => __( 'Column ', 'ads-shortcodes' ),
		'columns_add_text'               => __( 'Here some text', 'ads-shortcodes' ),
		'row_hedline'                    => __( 'Row', 'ads-shortcodes' ),
		'part_hedline'                   => __( 'Part', 'ads-shortcodes' ),
		'part_free'                      => __( 'Part free', 'ads-shortcodes' ),
		'divider_title'                  => __( 'Dividers', 'ads-shortcodes' ),
		'divider_sample'                 => __( 'Simple Divider', 'ads-shortcodes' ),
		'divider_gradient'               => __( 'Gradient Divider', 'ads-shortcodes' ),
		'divider_points'                 => __( 'Divider points', 'ads-shortcodes' ),
		'divider_dash'                   => __( 'Divider dash', 'ads-shortcodes' ),
		'divider_zigzag'                 => __( 'Divider zigzag', 'ads-shortcodes' ),
		'space_title'                    => __( 'Spacer', 'ads-shortcodes' ),
		'space_title_open_window'        => __( 'Spacer window', 'ads-shortcodes' ),
		'space_grap'                     => __( 'The size of the gap', 'ads-shortcodes' ),
		'quote_title'                    => __( 'Quotes', 'ads-shortcodes' ),
		'quote_left_title'               => __( 'Left Quote', 'ads-shortcodes' ),
		'quote_left_title_open_window'   => __( 'Left Quote Window', 'ads-shortcodes' ),
		'quote_right_title'              => __( 'Right Quote', 'ads-shortcodes' ),
		'quote_right_title_open_window'  => __( 'Right Quote Window', 'ads-shortcodes' ),
		'quote_center_title'             => __( 'Center Quote', 'ads-shortcodes' ),
		'quote_center_title_open_window' => __( 'Center Quote Window', 'ads-shortcodes' ),
		'quote_center_cite'              => __( 'Center Quote Cite', 'ads-shortcodes' ),
		'dropcaps_title'                 => __( 'Dropcaps', 'ads-shortcodes' ),
		'colorbox_title'                 => __( 'Color Box', 'ads-shortcodes' ),
		'colorbox_title_open_window'     => __( 'Color Box Window', 'ads-shortcodes' ),
		'colorbox_background'            => __( 'Background color', 'ads-shortcodes' ),
		'colorbox_text'                  => __( 'Text color', 'ads-shortcodes' ),
		'colorborder_text'               => __( 'Border color', 'ads-shortcodes' ),
		'blur_spoiler_title'             => __( 'Blur Spoiler', 'ads-shortcodes' ),
		'blur_spoiler_title_open_window' => __( 'Blur Spoiler Window', 'ads-shortcodes' ),
		'blur_spoiler_color_change'      => __( 'If required, select the color of the text', 'ads-shortcodes' ),
	);
	$locale     = _WP_Editors::$mce_locale;
	$translated = 'tinyMCE.addI18n("' . $locale . '.ads_mce_button", ' . json_encode( $strings ) . ");\n";
	
	return $translated;
}

$strings = artabr_ads_button_translation();

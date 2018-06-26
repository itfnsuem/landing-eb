<?php
/**
 * Plugin Name: Art Decoration Shortcode
 * Text Domain: ads-shortcodes
 * Domain Path: /languages
 * Plugin URI: https://wordpress.org/plugins/art-decoration-shortcode/
 * Description: Plugin shortcodes for text in articles. Contains: selection of text blocks with icons, buttons with hover effects and icons, columns, separator, text blocks with flow, letter, color text blocks.
 * Contributors: artabr
 * Version: 1.4.6
 * Author: Artem Abramovich
 * Author URI: http://wpruse.ru/?p=570
 * Tags: shortcodes, shortcode, shortcodes list, buttons, alert shortcode, notification shortcode, column shortcodes, bloginfo, box, button, buttons, hover, column, fancy, hover buttons, flexbox columns, multilingual, plugin, pullquote, responsive, responsive video, right-to-left, rss, service, services, short code, shortcode, shortcodes, siblings pages, slider, spoiler, dropcaps
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
/* ------------------------------------------------------------------------- *
	Внешний вид и ховер-эффекты для кнопок разарботаны Kyle Brumm https://codepen.io/kjbrum/pen/wBBLXx 
 	Внешний вид разделителей разработан Joey Hoer https://codepen.io/joeyhoer/pen/BmqIx
 	Флекс-сетка для колонок разработана Dave Hauser https://codepen.io/davehauser/pen/qIpoz
 	Размытый спойлер разработан Filipe Kiss https://codepen.io/filipekiss/pen/wDlBz
 	Все, что не указано отдельно разработано автором плагина
/* ------------------------------------------------------------------------- */
/*  Copyright 2016 Артем Абрамович  (email: artikus.sol@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* ------------------------------------------------------------------------- *
 *  Проверка на версию php
/* ------------------------------------------------------------------------- */
register_activation_hook( __FILE__, 'ads_check_php_version_activation_plugin' );
function ads_check_php_version_activation_plugin() {
	$php = 5.6;
	$wp  = 4.7;
	global $wp_version;
	if ( version_compare( PHP_VERSION, $php, '<' ) ) {
		$flag = 'PHP';
	} else if ( version_compare( $wp_version, $wp, '<' ) ) {
		$flag = 'WordPress';
	}
	if ( ! empty( $flag ) ) {
		$version            = 'PHP' == $flag ? $php : $wp;
		$wrong_version_text = sprintf( __( 'This plugin requires %s version %s or greater.', 'ads-shortcodes' ), $flag, $version );
		exit( $wrong_version_text );
	} else {
		set_transient( 'ads-success-notice', true, 5 );
	}
}

add_action( 'admin_notices', 'ads_success_notice_activation_plugin' );
function ads_success_notice_activation_plugin() {
	
	$plugin_data = get_plugin_data( __FILE__ );
	if ( get_transient( 'ads-success-notice' ) ) {
		
		printf( __( '<div class="updated notice is-dismissible"><p>Thank you for using the <strong>%s</strong> plugin.</p></div>', 'ads-shortcodes' ), $plugin_data['Name'] );
		delete_transient( 'ads-success-notice' );
	}
}

/* ------------------------------------------------------------------------- *
 *  Подключение переводов
/* ------------------------------------------------------------------------- */
add_action( 'plugins_loaded', 'artabr_ads_load_plugin_textdomain' );
function artabr_ads_load_plugin_textdomain() {
	load_plugin_textdomain( 'ads-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_filter( 'mce_external_languages', 'artabr_ads_button_lang' );
function artabr_ads_button_lang( $locales ) {
	$locales['ads_mce_button'] = plugin_dir_path( __FILE__ ) . 'inc/i18n/translations.php';
	
	return $locales;
}
/* ------------------------------------------------------------------------- *
 *  Подключение стилей и скриптов
/* ------------------------------------------------------------------------- */
/*
 *   Скрипты и стиля для фронтэнда
*/
add_action( 'wp_enqueue_scripts', 'artabr_style_tds', 11 );
function artabr_style_tds() {
	wp_register_style( 'tds_style_frontend', plugins_url( 'inc/tds_style.min.css', __FILE__ ) );
	wp_register_script( 'tds-script', plugins_url( 'inc/tds-script.min.js', __FILE__ ), array( 'jquery' ), null );
	wp_enqueue_script( 'tds-script' );
	wp_enqueue_style( 'tds_style_frontend' );
	wp_enqueue_style( 'dashicons' );
}

/*
 *   Скрипты и стили для бэкенда
*/
add_action( 'admin_enqueue_scripts', 'artabr_style_tds_admin' );
function artabr_style_tds_admin() {
	wp_enqueue_style( 'tds_style_backend', plugins_url( 'inc/tds_admin_style.min.css', __FILE__ ) );
}

/* ------------------------------------------------------------------------- *
 *  Подключение кнопки в редакторе
/* ------------------------------------------------------------------------- */

add_filter( 'mce_external_plugins', 'artabr_ads_add_tinymce_script' );
function artabr_ads_add_tinymce_script( $plugin_array ) {
	$plugin_array['ads_mce_button'] = plugins_url( '/inc/tds_button.js', __FILE__ );
	
	return $plugin_array;
}
add_filter( 'mce_buttons', 'artabr_ads_register_mce_button' );
function artabr_ads_register_mce_button( $buttons ) {
	array_push( $buttons, 'ads_mce_button' );
	
	return $buttons;
}

/*
 *   Инфоблоки
*/
add_shortcode( 'tds_warning', 'artabr_tds_warning' );
function artabr_tds_warning( $atts, $content = null ) {
	$atts   = shortcode_atts( array(
		'class' => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<div class="tds-message-box box-warning ' . $class . '">';
	$output .= do_shortcode( $content );
	$output .= '</div>';
	
	return apply_filters( 'tds_warning_filter_html', $output );
}

add_shortcode( 'tds_council', 'artabr_tds_council' );
function artabr_tds_council( $atts, $content = null ) {
	$atts   = shortcode_atts( array(
		'class' => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<div class="tds-message-box box-council ' . $class . '">';
	$output .= do_shortcode( $content );
	$output .= '</div>';
	
	return apply_filters( 'tds_council_filter_html', $output );
}

add_shortcode( 'tds_note', 'artabr_tds_note' );
function artabr_tds_note( $atts, $content = null ) {
	$atts   = shortcode_atts( array(
		'class' => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<div class="tds-message-box box-note ' . $class . '">';
	$output .= do_shortcode( $content );
	$output .= '</div>';
	
	return apply_filters( 'tds_note_filter_html', $output );
}

add_shortcode( 'tds_info', 'artabr_tds_info' );
function artabr_tds_info( $atts, $content = null ) {
	$atts   = shortcode_atts( array(
		'class' => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<div class="tds-message-box box-info ' . $class . '">';
	$output .= do_shortcode( $content );
	$output .= '</div>';
	
	return apply_filters( 'tds_info_filter_html', $output );
}

add_shortcode( 'ads_custom_box', 'artabr_ads_custom_box' );
function artabr_ads_custom_box( $atts, $content = null ) {
	$atts         = shortcode_atts( array(
		'title'        => '',
		'color_border' => '',
		'class'        => '',
	), $atts );
	$class        = $atts['class'] ? $atts['class'] : '';
	$color_border = '#e87e04' != $atts['color_border'] ? 'border-color:' . $atts['color_border'] . ';' : '';
	$color_title  = '#e87e04' != $atts['color_border'] ? 'style="color:' . $atts['color_border'] . ';"' : '';
	$title        = $atts['title'] ?
		'<div class="ads-custom-box-title" ' . $color_title . '>' . $atts['title'] . '</div>' : '';
	$title_padding = !$title ? 'padding: 2.2rem 2.2rem;' : '';
	$output       = '<div class="ads-custom-box custom-box ' . $class . '" style="' . $color_border . $title_padding. '">';
	$output       .= apply_filters( 'ads_custom_box_title_filter_html', $title );
	$output       .= '<div class="ads-custom-box-content">' . do_shortcode( $content ) . '</div>';
	$output       .= '</div>';
	
	return apply_filters( 'ads_custom_box_filter_html', $output );
}

/*
 *   Кнопки с ховер эффектами
*/
add_shortcode( 'ads_btn', 'artabr_ads_buttom' );
function artabr_ads_buttom( $atts ) {
	$atts = shortcode_atts( array(
		'label_btn' => 'Кнопка',
		'url'       => '#',
		'target'    => 'true',
		'icon'      => '',
		'view_btn'  => '',
		'class'        => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	if ( $atts['target'] != 'true' ) {
		$atts['target'] = '_self';
	} else {
		$atts['target'] = '_blank';
	}
	if ( isset( $atts['icon'] ) && ! empty( $atts['icon'] ) ) {
		$icon_btn = '<i class="' . $atts['icon'] . '"></i>';
	} else {
		$icon_btn = '';
	}
	if ( $atts['view_btn'] === 'adsbtn-swipe' ||
	     $atts['view_btn'] === 'adsbtn-diagonal' ||
	     $atts['view_btn'] === 'adsbtn-diagonal-close' ||
	     $atts['view_btn'] === 'adsbtn-double' ||
	     $atts['view_btn'] === 'adsbtn-slice' ||
	     $atts['view_btn'] === 'adsbtn-smoosh' ||
	     $atts['view_btn'] === 'adsbtn-collision'
	) {
		$out_btn = '<div class="ads-button">
		<a href="' . $atts['url'] . '" target="' . $atts['target'] . '" class="' . $atts['view_btn'] . ' ' . $class . '">' . $icon_btn . ' ' . $atts['label_btn'] . '</a>
		</div>';
	} elseif ( $atts['view_btn'] === 'adsbtn-alternate' ||
	           $atts['view_btn'] === 'adsbtn-vertical-overlap' ||
	           $atts['view_btn'] === 'adsbtn-horizontal-overlap' ||
	           $atts['view_btn'] === 'adsbtn-zoning' ||
	           $atts['view_btn'] === 'adsbtn-4corners'
	) {
		$out_btn = '<div class="ads-button">
		<a href="' . $atts['url'] . '" target="' . $atts['target'] . '" class="' . $atts['view_btn'] . ' ' . $class . '"><span>' . $icon_btn . ' ' . $atts['label_btn'] . '</span></a>
		</div>';
	} elseif ( $atts['view_btn'] === 'adsbtn-position-aware' ) {
		$out_btn = '<div class="ads-button">
		<a href="' . $atts['url'] . '" target="' . $atts['target'] . '" class="' . $atts['view_btn'] . ' ' . $class . '">' . $icon_btn . ' ' . $atts['label_btn'] . '<span></span></a></div>';
	} else {
		$out_btn = '<div class="ads-button">
		<a href="' . $atts['url'] . '" target="' . $atts['target'] . '" class="' . $atts['view_btn'] . ' ' . $class . '">' . $icon_btn . ' ' . $atts['label_btn'] . '</a>
		</div>';
	}
	
	return $out_btn;
}

/*
 *   Колонки
*/
add_shortcode( 'ads_row', 'artabr_ads_row' );
function artabr_ads_row( $atts, $content = null ) {
	$output = '<div class="ads-row">' . do_shortcode( $content ) . '</div>';
	
	return $output;
}

add_shortcode( 'ads_col', 'artabr_ads_col' );
function artabr_ads_col( $atts, $content = null ) {
	$atts   = shortcode_atts( array(
		'col' => 'cell',
	), $atts );
	$output = '<div class="' . $atts['col'] . '">' . do_shortcode( $content ) . '</div>';
	
	return $output;
}

/*
 *   Разделители
*/
add_shortcode( 'ads_hr', 'artabr_ads_hr' );
function artabr_ads_hr( $atts ) {
	$atts = shortcode_atts( array(
		'hr_style' => '',
		'class'        => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<div class="' . $atts['hr_style'] . ' ' . $class . '"></div>';
	
	return apply_filters( 'ads_hr_filter_html', $output );

}

/*
 *   Буквица
*/
add_shortcode( 'ads_dropcap', 'artabr_ads_dropcap' );
function artabr_ads_dropcap( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'class'        => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<span class="ads-dropcap ' . $class . '">' . do_shortcode( $content ) . '</span>';
	
	return apply_filters( 'ads_dropcap_filter_html', $output );
}

/*
 *   Плавающая цитата (левая)
*/
add_shortcode( 'ads-pullquote-left', 'artabr_ads_pullquote_left' );
function artabr_ads_pullquote_left( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'class'        => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<span class="ads-pullquote-left ' . $class . '">' . do_shortcode( $content ) . '</span>';
	
	return apply_filters( 'ads_pullquote_left_filter_html', $output );
}

/*
 *   Плавающая цитата (правая)
*/
add_shortcode( 'ads-pullquote-right', 'artabr_ads_pullquote_right' );
function artabr_ads_pullquote_right( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'class'        => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<span class="ads-pullquote-right ' . $class . '">' . do_shortcode( $content ) . '</span>';
	
	return apply_filters( 'ads_pullquote_right_filter_html', $output );
}

/*
 *   Большая цитата (по центру)
*/
add_shortcode( 'ads-quote-center', 'artabr_ads_quote_center' );
function artabr_ads_quote_center( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'quote' => '',
		'cite'  => '',
		'class' => '',
	), $atts );
	if ( isset( $atts['cite'] ) && ! empty( $atts['cite'] ) ) {
		$cite_quote = '<div class="ads-quote-center-cite"><span>' . $atts['cite'] . '</span></div>';
	} else {
		$cite_quote = '';
	}
	$class  = $atts['class'] ? $atts['class'] : '';
	$output = '<div class="ads-quote-center ' . $class . '"><span>' . do_shortcode( $content ) . '</span>' . $cite_quote . '</div>';
	
	return apply_filters( 'ads_quote_center_filter_html', $output );
}

/*
 *   Цветной блок
*/
add_shortcode( 'ads_color_box', 'artabr_ads_color_box' );
function artabr_ads_color_box( $atts, $content = null ) {
	$atts   = shortcode_atts( array(
		'color_background' => '#eee',
		'color_text'       => '#444',
	), $atts );
	$output = '<div class="ads-color-box" style="color:' . $atts['color_text'] . ';background:' .
	          $atts['color_background'] . ';">' . do_shortcode( $content ) . '</div>';
	
	return $output;
}

/*
 *   Блюр спойлер
*/
add_shortcode( 'ads_blur_spoiler', 'artabr_ads_blur_spoiler' );
function artabr_ads_blur_spoiler( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'color_blur' => '',
	), $atts );
	if ( $atts['color_blur'] ) {
		$output = '<style type="text/css">
		.ads-blur-spoiler-reverse{text-shadow: 0 0 20px ' . $atts['color_blur'] . ';}.ads-blur-spoiler-reverse:hover {color: ' . $atts['color_blur'] .';}
		</style>
		<span class="ads-blur-spoiler-reverse">' . do_shortcode( $content ) . '</span>';
	} else {
		$output = '<span class="ads-blur-spoiler">' . do_shortcode( $content ) . '</span>';
	}
	
	return $output;
}

/*
 *   Пробел
 */
add_shortcode( 'ads_space', 'artabr_ads_hr_space' );
function artabr_ads_hr_space( $atts ) {
	$atts = shortcode_atts( array(
		'space' => '5',
	), $atts );

	return '<div style="margin:' . $atts['space'] . 'px 0"></div>';
}
/*
 *   Специальный шорткод для отображения шорткодов
*/
add_shortcode( 'ads_spl', 'artabr_ads_spicial_letters' );
function artabr_ads_spicial_letters( $atts, $content = null ) {
	$atts = shortcode_atts( array(
		'class' => '',
	), $atts );
	$class  = $atts['class'] ? $atts['class'] : '';
	$content = str_replace(['[',']'], ['&#91;','&#93;'], $content);
	return '<div class="shortcode-html ' . $class . '">' . do_shortcode( $content ) . '</div>';
}




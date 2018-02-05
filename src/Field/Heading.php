<?php
/**
 * The heading field which displays a simple heading text.
 *
 * @package Meta Box
 */

namespace MetaBox\Field;

/**
 * Heading field class.
 */
class Heading extends Base {
	/**
	 * Enqueue scripts and styles.
	 */
	public static function admin_enqueue_scripts() {
		wp_enqueue_style( 'rwmb-heading', RWMB_CSS_URL . 'heading.css', array(), RWMB_VER );
	}

	/**
	 * Show begin HTML markup for fields.
	 *
	 * @param mixed $meta  Meta value.
	 * @param array $field Field parameters.
	 *
	 * @return string
	 */
	public static function begin_html( $meta, $field ) {
		$attributes = empty( $field['id'] ) ? '' : " id='{$field['id']}'";
		return sprintf( '<h4%s>%s</h4>', $attributes, $field['name'] );
	}

	/**
	 * Show end HTML markup for fields.
	 *
	 * @param mixed $meta  Meta value.
	 * @param array $field Field parameters.
	 *
	 * @return string
	 */
	public static function end_html( $meta, $field ) {
		return self::input_description( $field );
	}
}

<?php
/**
 * The advanced image upload field which uses WordPress media popup to upload and select images.
 *
 * @package Meta Box
 */

namespace MetaBox\Field;

/**
 * Image advanced field class.
 */
class SingleImage extends ImageAdvanced {
	/**
	 * Normalize parameters for field.
	 *
	 * @param array $field Field parameters.
	 *
	 * @return array
	 */
	public static function normalize( $field ) {
		$field['max_file_uploads'] = 1;
		$field['max_status']       = false;

		$field = parent::normalize( $field );

		$field['attributes'] = wp_parse_args( $field['attributes'], array(
			'class'             => '',
			'data-single-image' => 1,
		) );

		$field['attributes']['class'] .= ' rwmb-image_advanced';
		$field['multiple']            = false;

		return $field;
	}

	/**
	 * Get meta values to save.
	 *
	 * @param mixed $new     The submitted meta value.
	 * @param mixed $old     The existing meta value.
	 * @param int   $post_id The post ID.
	 * @param array $field   The field parameters.
	 *
	 * @return array|mixed
	 */
	public static function value( $new, $old, $post_id, $field ) {
		return $new;
	}

	/**
	 * Get the field value. Return meaningful info of the files.
	 *
	 * @param  array    $field   Field parameters.
	 * @param  array    $args    Not used for this field.
	 * @param  int|null $post_id Post ID. null for current post. Optional.
	 *
	 * @return mixed Full info of uploaded files
	 */
	public static function get_value( $field, $args = array(), $post_id = null ) {
		$value  = Base::get_value( $field, $args, $post_id );
		$return = Image::file_info( $value, $args );
		return $return;
	}
}

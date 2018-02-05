<?php
/**
 * The radio field.
 *
 * @package Meta Box
 */

namespace MetaBox\Field;

/**
 * Radio field class.
 */
class Radio extends InputList {
	/**
	 * Normalize parameters for field.
	 *
	 * @param array $field Field parameters.
	 *
	 * @return array
	 */
	public static function normalize( $field ) {
		$field['multiple'] = false;
		$field             = parent::normalize( $field );

		return $field;
	}
}

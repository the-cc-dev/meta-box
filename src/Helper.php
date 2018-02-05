<?php
/**
 * Helper functions.
 *
 * @package Meta Box
 */

namespace MetaBox;

/**
 * Helper class.
 */
class Helper {
	/**
	 * Convert to TitleCase, e.g. from some_thing to SomeThing.
	 *
	 * @param string $name The input string.
	 *
	 * @return string
	 */
	public static function to_title_case( $name ) {
		$name = str_replace( [ '-', '_' ], ' ', $name );
		$name = ucwords( $name );
		$name = str_replace( ' ', '', $name );

		return $name;
	}
}

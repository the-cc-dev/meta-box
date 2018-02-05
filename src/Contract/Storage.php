<?php
/**
 * Storage interface
 *
 * @package Meta Box
 */

namespace MetaBox\Contract;

/**
 * Interface RWMB_Storage_Interface
 */
interface Storage {
	/**
	 * Get value from storage.
	 *
	 * @param  int    $object_id Object id.
	 * @param  string $name      Field name.
	 * @param  array  $args      Custom arguments..
	 *
	 * @return mixed
	 */
	public function get( $object_id, $name, $args = [] );
}

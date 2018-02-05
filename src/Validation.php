<?php
/**
 * Validation module.
 *
 * @package Meta Box
 */

namespace MetaBox;

/**
 * Validation class.
 */
class Validation {

	/**
	 * Add hooks when module is loaded.
	 */
	public function __construct() {
		add_action( 'rwmb_after', [ $this, 'rules' ] );
		add_action( 'rwmb_enqueue_scripts', [ $this, 'enqueue' ] );
	}

	/**
	 * Output validation rules of each meta box.
	 * The rules are outputted in [data-rules] attribute of an hidden <script> and will be converted into JSON by JS.
	 *
	 * @param MetaBox $object Meta Box object.
	 */
	public function rules( MetaBox $object ) {
		if ( ! empty( $object->meta_box['validation'] ) ) {
			echo '<script type="text/html" class="rwmb-validation-rules" data-rules="' . esc_attr( wp_json_encode( $object->meta_box['validation'] ) ) . '"></script>';
		}
	}

	/**
	 * Enqueue scripts for validation.
	 *
	 * @param MetaBox $object Meta Box object.
	 */
	public function enqueue( MetaBox $object ) {
		if ( empty( $object->meta_box['validation'] ) ) {
			return;
		}
		wp_enqueue_script( 'jquery-validation', RWMB_JS_URL . 'jquery-validation/jquery.validate.min.js', [ 'jquery' ], '1.15.0', true );
		wp_enqueue_script( 'jquery-validation-additional-methods', RWMB_JS_URL . 'jquery-validation/additional-methods.min.js', [ 'jquery-validation' ], '1.15.0', true );
		wp_enqueue_script( 'rwmb-validate', RWMB_JS_URL . 'validate.js', [
			'jquery-validation',
			'jquery-validation-additional-methods',
		], RWMB_VER, true );

		Field\Base::localize_script( 'rwmb-validate', 'rwmbValidate', [
			'summaryMessage' => esc_html__( 'Please correct the errors highlighted below and try again.', 'meta-box' ),
		] );
	}
}

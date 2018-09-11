<?php
/**
 * The beautiful select field which uses select2 library.
 *
 * @package Meta Box
 */

/**
 * Select advanced field which uses select2 library.
 */
class RWMB_Select_Advanced_Field extends RWMB_Select_Field {
	/**
	 * Add field actions and filters.
	 */
	public static function add_actions() {
		// Add callback for ajax data source.
		add_action( 'wp_ajax_rwmb_select_advanced_callback', array( __CLASS__, 'ajax_callback' ) );
		add_action( 'wp_ajax_nopriv_rwmb_select_advanced_callback', array( __CLASS__, 'ajax_callback' ) );

		// Add callback for initial load for selected items.
		add_action( 'wp_ajax_rwmb_select_advanced_initial_callback', array( __CLASS__, 'ajax_initial_callback' ) );
		add_action( 'wp_ajax_nopriv_rwmb_select_advanced_initial_callback', array( __CLASS__, 'ajax_initial_callback' ) );
	}

	/**
	 * Get data source from a ajax callback.
	 */
	public static function ajax_callback() {
		$callback = (string) filter_input( INPUT_GET, 'callback' );
		if ( ! $callback ) {
			die;
		}
		$data = call_user_func( $callback );
		echo wp_json_encode( $data );
		die;
	}

	/**
	 * Get list of labels for selected items when initial load.
	 */
	public static function ajax_initial_callback() {
		$callback = (string) filter_input( INPUT_GET, 'callback' );
		if ( ! $callback ) {
			die;
		}
		$selected = (string) filter_input( INPUT_GET, 'selected' );
		if ( ! $selected ) {
			die;
		}
		$selected = rwmb_csv_to_array( $selected );
		$data = call_user_func( $callback, $selected );
		echo wp_json_encode( $data );
		die;
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public static function admin_enqueue_scripts() {
		parent::admin_enqueue_scripts();
		wp_enqueue_style( 'rwmb-select2', RWMB_CSS_URL . 'select2/select2.css', array(), '4.0.1' );
		wp_enqueue_style( 'rwmb-select-advanced', RWMB_CSS_URL . 'select-advanced.css', array(), RWMB_VER );

		wp_register_script( 'rwmb-select2', RWMB_JS_URL . 'select2/select2.min.js', array( 'jquery' ), '4.0.2', true );

		// Localize.
		$dependencies = array( 'rwmb-select2', 'rwmb-select' );
		$locale       = str_replace( '_', '-', get_locale() );
		$locale_short = substr( $locale, 0, 2 );
		$locale       = file_exists( RWMB_DIR . "js/select2/i18n/$locale.js" ) ? $locale : $locale_short;

		if ( file_exists( RWMB_DIR . "js/select2/i18n/$locale.js" ) ) {
			wp_register_script( 'rwmb-select2-i18n', RWMB_JS_URL . "select2/i18n/$locale.js", array( 'rwmb-select2' ), '4.0.2', true );
			$dependencies[] = 'rwmb-select2-i18n';
		}

		wp_enqueue_script( 'rwmb-select-advanced', RWMB_JS_URL . 'select-advanced.js', $dependencies, RWMB_VER, true );
	}

	/**
	 * Normalize parameters for field.
	 *
	 * @param array $field Field parameters.
	 * @return array
	 */
	public static function normalize( $field ) {
		$field = wp_parse_args( $field, array(
			'js_options'    => array(),
			'placeholder'   => __( 'Select an item', 'meta-box' ),
			'ajax_callback' => '',
		) );

		$field = parent::normalize( $field );

		$field['js_options'] = wp_parse_args( $field['js_options'], array(
			'allowClear'  => true,
			'width'       => 'none',
			'placeholder' => $field['placeholder'],
		) );

		if ( $field['ajax_callback'] ) {
			$ajax_params = array(
				'url'        => add_query_arg( array(
					'action'   => 'rwmb_select_advanced_callback',
					'callback' => $field['ajax_callback'],
				), admin_url( 'admin-ajax.php' ) ),
				'initialUrl' => add_query_arg( array(
					'action'   => 'rwmb_select_advanced_initial_callback',
					'callback' => $field['ajax_initial_callback'],
				), admin_url( 'admin-ajax.php' ) ),
				'dataType'   => 'json',
				'cache'      => true,
			);
			$field['js_options']['ajax'] = isset( $field['js_options']['ajax'] ) ? wp_parse_args( $field['js_options']['ajax'], $ajax_params ) : $ajax_params;
		}

		return $field;
	}

	/**
	 * Get the attributes for a field.
	 *
	 * @param array $field Field parameters.
	 * @param mixed $value Meta value.
	 * @return array
	 */
	public static function get_attributes( $field, $value = null ) {
		$attributes = parent::get_attributes( $field, $value );
		$attributes = wp_parse_args( $attributes, array(
			'data-options' => wp_json_encode( $field['js_options'] ),
		) );

		return $attributes;
	}
}

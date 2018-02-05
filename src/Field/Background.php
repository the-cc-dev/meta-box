<?php
/**
 * The background field.
 *
 * @package Meta Box.
 */

namespace MetaBox\Field;

/**
 * The Background field.
 */
class Background extends Base {
	/**
	 * Enqueue scripts and styles.
	 */
	public static function admin_enqueue_scripts() {
		wp_enqueue_style( 'rwmb-background', RWMB_CSS_URL . 'background.css', '', RWMB_VER );

		Color::admin_enqueue_scripts();
		File_Input::admin_enqueue_scripts();
	}

	/**
	 * Get field HTML.
	 *
	 * @param mixed $meta  Meta value.
	 * @param array $field Field settings.
	 *
	 * @return string
	 */
	public static function html( $meta, $field ) {
		$meta = wp_parse_args( $meta, array(
			'color'      => '',
			'image'      => '',
			'repeat'     => '',
			'attachment' => '',
			'position'   => '',
			'size'       => '',
		) );

		$output = '<div class="rwmb-background-row">';

		// Color.
		$color  = Color::normalize( array(
			'type'       => 'color',
			'id'         => "{$field['id']}_color",
			'field_name' => "{$field['field_name']}[color]",
		) );
		$output .= Color::html( $meta['color'], $color );

		// Image.
		$image  = File_Input::normalize( array(
			'type'        => 'file_input',
			'id'          => "{$field['id']}_image",
			'field_name'  => "{$field['field_name']}[image]",
			'placeholder' => __( 'Background Image', 'meta-box' ),
		) );
		$output .= '<div class="rwmb-background-image">';
		$output .= File_Input::html( $meta['image'], $image );
		$output .= '</div>';

		$output .= '</div><!-- .rwmb-background-row -->';
		$output .= '<div class="rwmb-background-row">';

		// Repeat.
		$repeat = Select::normalize( array(
			'type'        => 'select',
			'id'          => "{$field['id']}_repeat",
			'field_name'  => "{$field['field_name']}[repeat]",
			'placeholder' => esc_html__( '-- Background Repeat --', 'meta-box' ),
			'options'     => array(
				'no-repeat' => esc_html__( 'No Repeat', 'meta-box' ),
				'repeat'    => esc_html__( 'Repeat All', 'meta-box' ),
				'repeat-x'  => esc_html__( 'Repeat Horizontally', 'meta-box' ),
				'repeat-y'  => esc_html__( 'Repeat Vertically', 'meta-box' ),
				'inherit'   => esc_html__( 'Inherit', 'meta-box' ),
			),
		) );
		$output .= Select::html( $meta['repeat'], $repeat );

		// Position.
		$position = Select::normalize( array(
			'type'        => 'select',
			'id'          => "{$field['id']}_position",
			'field_name'  => "{$field['field_name']}[position]",
			'placeholder' => esc_html__( '-- Background Position --', 'meta-box' ),
			'options'     => array(
				'top left'      => esc_html__( 'Top Left', 'meta-box' ),
				'top center'    => esc_html__( 'Top Center', 'meta-box' ),
				'top right'     => esc_html__( 'Top Right', 'meta-box' ),
				'center left'   => esc_html__( 'Center Left', 'meta-box' ),
				'center center' => esc_html__( 'Center Center', 'meta-box' ),
				'center right'  => esc_html__( 'Center Right', 'meta-box' ),
				'bottom left'   => esc_html__( 'Bottom Left', 'meta-box' ),
				'bottom center' => esc_html__( 'Bottom Center', 'meta-box' ),
				'bottom right'  => esc_html__( 'Bottom Right', 'meta-box' ),
			),
		) );
		$output   .= Select::html( $meta['position'], $position );

		// Attachment.
		$attachment = Select::normalize( array(
			'type'        => 'select',
			'id'          => "{$field['id']}_attachment",
			'field_name'  => "{$field['field_name']}[attachment]",
			'placeholder' => esc_html__( '-- Background Attachment --', 'meta-box' ),
			'options'     => array(
				'fixed'   => esc_html__( 'Fixed', 'meta-box' ),
				'scroll'  => esc_html__( 'Scroll', 'meta-box' ),
				'inherit' => esc_html__( 'Inherit', 'meta-box' ),
			),
		) );
		$output     .= Select::html( $meta['attachment'], $attachment );

		// Size.
		$size   = Select::normalize( array(
			'type'        => 'select',
			'id'          => "{$field['id']}_size",
			'field_name'  => "{$field['field_name']}[size]",
			'placeholder' => esc_html__( '-- Background Size --', 'meta-box' ),
			'options'     => array(
				'inherit' => esc_html__( 'Inherit', 'meta-box' ),
				'cover'   => esc_html__( 'Cover', 'meta-box' ),
				'contain' => esc_html__( 'Contain', 'meta-box' ),
			),
		) );
		$output .= Select::html( $meta['size'], $size );
		$output .= '</div><!-- .rwmb-background-row -->';

		return $output;
	}

	/**
	 * Format a single value for the helper functions. Sub-fields should overwrite this method if necessary.
	 *
	 * @param array    $field   Field parameters.
	 * @param array    $value   The value.
	 * @param array    $args    Additional arguments. Rarely used. See specific fields for details.
	 * @param int|null $post_id Post ID. null for current post. Optional.
	 *
	 * @return string
	 */
	public static function format_single_value( $field, $value, $args, $post_id ) {
		$output = '';
		$value  = array_filter( $value );
		foreach ( $value as $key => $subvalue ) {
			$subvalue = 'image' === $key ? 'url( "' . esc_url( $subvalue ) . '")' : $subvalue;
			$output   .= 'background-' . $key . ': ' . $subvalue . ';';
		}
		return $output;
	}
}

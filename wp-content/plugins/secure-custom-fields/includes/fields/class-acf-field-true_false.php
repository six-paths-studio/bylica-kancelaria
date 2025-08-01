<?php

if ( ! class_exists( 'acf_field_true_false' ) ) :

	class acf_field_true_false extends acf_field {


		/**
		 * This function will setup the field type data
		 *
		 * @type    function
		 * @date    5/03/2014
		 * @since   ACF 5.0.0
		 *
		 * @param   n/a
		 * @return  n/a
		 */
		function initialize() {

			// vars
			$this->name          = 'true_false';
			$this->label         = __( 'True / False', 'secure-custom-fields' );
			$this->category      = 'choice';
			$this->description   = __( 'A toggle that allows you to pick a value of 1 or 0 (on or off, true or false, etc). Can be presented as a stylized switch or checkbox.', 'secure-custom-fields' );
			$this->preview_image = acf_get_url() . '/assets/images/field-type-previews/field-preview-true-false.png';
			$this->doc_url       = 'https://developer.wordpress.org/secure-custom-fields/features/fields/true-false/';
			$this->tutorial_url  = 'https://developer.wordpress.org/secure-custom-fields/features/fields/true-false/true-false-tutorial/';
			$this->defaults      = array(
				'default_value' => 0,
				'message'       => '',
				'ui'            => 0,
				'ui_on_text'    => '',
				'ui_off_text'   => '',
			);
		}


		/**
		 * Create the HTML interface for your field
		 *
		 * @param   $field - an array holding all the field's data
		 *
		 * @type    action
		 * @since   ACF 3.6
		 * @date    23/01/13
		 */
		function render_field( $field ) {

			// vars
			$input = array(
				'type'         => 'checkbox',
				'id'           => $field['id'],
				'name'         => $field['name'],
				'value'        => '1',
				'class'        => $field['class'],
				'autocomplete' => 'off',
			);

			$hidden = array(
				'name'  => $field['name'],
				'value' => 0,
			);

			$active = isset( $field['value'] ) && $field['value'] ? true : false;
			$switch = '';

			// checked
			if ( $active ) {
				$input['checked'] = 'checked';
			}

			// ui
			if ( isset( $field['ui'] ) && $field['ui'] ) {

				// vars
				if ( isset( $field['ui_on_text'] ) && '' === $field['ui_on_text'] ) {
					$field['ui_on_text'] = __( 'Yes', 'secure-custom-fields' );
				}
				if ( isset( $field['ui_off_text'] ) && '' === $field['ui_off_text'] ) {
					$field['ui_off_text'] = __( 'No', 'secure-custom-fields' );
				}

				// update input
				$input['class'] .= ' acf-switch-input';
				// $input['style'] = 'display:none;';
				$switch .= '<div class="acf-switch' . ( $active ? ' -on' : '' ) . '">';
				$switch .= '<span class="acf-switch-on">' . acf_maybe_get( $field, 'ui_on_text', '' ) . '</span>';
				$switch .= '<span class="acf-switch-off">' . acf_maybe_get( $field, 'ui_off_text', '' ) . '</span>';
				$switch .= '<div class="acf-switch-slider"></div>';
				$switch .= '</div>';
			}

			?>
<div class="acf-true-false">
			<?php acf_hidden_input( $hidden ); ?>
	<label>
		<input <?php echo acf_esc_attrs( $input ); ?>/>
			<?php
			if ( $switch ) {
				echo acf_esc_html( $switch );}
			?>
			<?php
			if ( acf_maybe_get( $field, 'message' ) ) :
				?>
				<span class="message"><?php echo acf_esc_html( $field['message'] ); ?></span><?php endif; ?>
	</label>
</div>
			<?php
		}


		/**
		 * Create extra options for your field. This is rendered when editing a field.
		 * The value of $field['name'] can be used (like bellow) to save extra data to the $field
		 *
		 * @type    action
		 * @since   ACF 3.6
		 * @date    23/01/13
		 *
		 * @param   $field  - an array holding all the field's data
		 */
		function render_field_settings( $field ) {
			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Message', 'secure-custom-fields' ),
					'instructions' => __( 'Displays text alongside the checkbox', 'secure-custom-fields' ),
					'type'         => 'text',
					'name'         => 'message',
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Default Value', 'secure-custom-fields' ),
					'instructions' => '',
					'type'         => 'true_false',
					'name'         => 'default_value',
				)
			);
		}

		/**
		 * Renders the field settings used in the "Presentation" tab.
		 *
		 * @since ACF 6.0
		 *
		 * @param array $field The field settings array.
		 * @return void
		 */
		function render_field_presentation_settings( $field ) {
			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'On Text', 'secure-custom-fields' ),
					'instructions' => __( 'Text shown when active', 'secure-custom-fields' ),
					'type'         => 'text',
					'name'         => 'ui_on_text',
					'placeholder'  => __( 'Yes', 'secure-custom-fields' ),
					'conditions'   => array(
						'field'    => 'ui',
						'operator' => '==',
						'value'    => 1,
					),
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Off Text', 'secure-custom-fields' ),
					'instructions' => __( 'Text shown when inactive', 'secure-custom-fields' ),
					'type'         => 'text',
					'name'         => 'ui_off_text',
					'placeholder'  => __( 'No', 'secure-custom-fields' ),
					'conditions'   => array(
						'field'    => 'ui',
						'operator' => '==',
						'value'    => 1,
					),
				)
			);

			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Stylized UI', 'secure-custom-fields' ),
					'instructions' => __( 'Use a stylized checkbox using select2', 'secure-custom-fields' ),
					'type'         => 'true_false',
					'name'         => 'ui',
					'ui'           => 1,
					'class'        => 'acf-field-object-true-false-ui',
				)
			);
		}

		/**
		 * This filter is applied to the $value after it is loaded from the db and before it is returned to the template
		 *
		 * @type    filter
		 * @since   ACF 3.6
		 * @date    23/01/13
		 *
		 * @param   $value (mixed) the value which was loaded from the database
		 * @param   $post_id (mixed) the post_id from which the value was loaded
		 * @param   $field (array) the field array holding all the field options
		 *
		 * @return  $value (mixed) the modified value
		 */
		function format_value( $value, $post_id, $field ) {

			return empty( $value ) ? false : true;
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    11/02/2014
		 * @since   ACF 5.0.0
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function validate_value( $valid, $value, $field, $input ) {

			// bail early if not required
			if ( ! $field['required'] ) {
				return $valid;
			}

			// value may be '0'
			if ( ! $value ) {
				return false;
			}

			// return
			return $valid;
		}


		/**
		 * This function will translate field settings
		 *
		 * @type    function
		 * @date    8/03/2016
		 * @since   ACF 5.3.2
		 *
		 * @param   $field (array)
		 * @return  $field
		 */
		function translate_field( $field ) {

			// translate
			$field['message']     = acf_translate( $field['message'] );
			$field['ui_on_text']  = acf_translate( $field['ui_on_text'] );
			$field['ui_off_text'] = acf_translate( $field['ui_off_text'] );

			// return
			return $field;
		}

		/**
		 * Return the schema array for the REST API.
		 *
		 * @param array $field
		 * @return array
		 */
		public function get_rest_schema( array $field ) {
			$schema = array(
				'type'     => array( 'boolean', 'null' ),
				'required' => ! empty( $field['required'] ),
			);

			if ( isset( $field['default_value'] ) && '' !== $field['default_value'] ) {
				$schema['default'] = (bool) $field['default_value'];
			}

			return $schema;
		}

		/**
		 * Apply basic formatting to prepare the value for default REST output.
		 *
		 * @param mixed          $value
		 * @param string|integer $post_id
		 * @param array          $field
		 * @return mixed
		 */
		public function format_value_for_rest( $value, $post_id, array $field ) {
			return (bool) $value;
		}
	}


	// initialize
	acf_register_field_type( 'acf_field_true_false' );
endif; // class_exists check

?>

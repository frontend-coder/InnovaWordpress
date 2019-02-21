<?php
/**
 * Redux AJAX Save Class
 *
 * @class Redux_Core
 * @version 4.0.0
 * @package Redux Framework/Classes
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Redux_AJAX_Save', false ) ) {

	/**
	 * Class Redux_AJAX_Save
	 */
	class Redux_AJAX_Save extends Redux_Class {

		/**
		 * Redux_AJAX_Save constructor.
		 * array_merge_recursive_distinct
		 *
		 * @param object $parent ReduxFrameword object.
		 */
		public function __construct( $parent ) {
			parent::__construct( $parent );

			add_action( 'wp_ajax_' . $this->args['opt_name'] . '_ajax_save', array( $this, 'save' ) );
		}

		/**
		 * AJAX callback to save the option panel values.
		 */
		public function save() {
			$core = $this->core();

			if ( isset( $_REQUEST['nonce'] ) && ! wp_verify_nonce( sanitize_key( wp_unslash( $_REQUEST['nonce'] ) ), 'redux_ajax_nonce' . $this->args['opt_name'] ) ) {
				echo wp_json_encode(
					array(
						'status' => esc_html__( 'Invalid security credential.  Please reload the page and try again.', 'redux-framework' ),
						'action' => '',
					)
				);

				die();
			}

			if ( ! Redux_Helpers::current_user_can( $core->args['page_permissions'] ) ) {
				echo wp_json_encode(
					array(
						'status' => esc_html__( 'Invalid user capability.  Please reload the page and try again.', 'redux-framework' ),
						'action' => '',
					)
				);

				die();
			}

			if ( isset( $_POST['opt_name'] ) && ! empty( $_POST['opt_name'] ) && isset( $_POST['data'] ) && ! empty( $_POST['data'] ) ) {
				$redux = Redux::instance( sanitize_text_field( wp_unslash( $_POST['opt_name'] ) ) );

				if ( ! empty( $redux->args['opt_name'] ) ) {

					$post_data = wp_unslash( $_POST['data'] ); // WPCS: XSS ok, sanitization ok.

					// New method to avoid input_var nonsense.  Thanks @harunbasic.
					$values = $this->parse_str( $post_data );

					$values = $values[ $redux->args['opt_name'] ];

					if ( function_exists( 'get_magic_quotes_gpc' ) && get_magic_quotes_gpc() ) {
						$values = array_map( 'stripslashes_deep', $values );
					}

					if ( ! empty( $values ) ) {
						try {
							if ( isset( $redux->validation_ran ) ) {
								unset( $redux->validation_ran );
							}

							$redux->options_class->set( $redux->options_class->validate_options( $values ) );

							$do_reload = false;
							if ( isset( $core->required_class->reload_fields ) && ! empty( $core->required_class->reload_fields ) ) {
								if ( ! empty( $core->transients['changed_values'] ) ) {
									foreach ( $core->required_class->reload_fields as $idx => $val ) {
										if ( array_key_exists( $val, $core->transients['changed_values'] ) ) {
											$do_reload = true;
										}
									}
								}
							}

							if ( $do_reload || ( isset( $values['defaults'] ) && ! empty( $values['defaults'] ) ) || ( isset( $values['defaults-section'] ) && ! empty( $values['defaults-section'] ) ) || ( isset( $values['import_code'] ) && ! empty( $values['import_code'] ) ) || ( isset( $values['import_link'] ) && ! empty( $values['import_link'] ) ) ) {
								echo wp_json_encode(
									array(
										'status' => 'success',
										'action' => 'reload',
									)
								);
								die();
							}

							$redux->enqueue_class->get_warnings_and_errors_array();

							$return_array = array(
								'status'   => 'success',
								'options'  => $redux->options,
								'errors'   => isset( $redux->enqueue_class->localize_data['errors'] ) ? $redux->enqueue_class->localize_data['errors'] : null,
								'warnings' => isset( $redux->enqueue_class->localize_data['warnings'] ) ? $redux->enqueue_class->localize_data['warnings'] : null,
								'sanitize' => isset( $redux->enqueue_class->localize_data['sanitize'] ) ? $redux->enqueue_class->localize_data['sanitize'] : null,
							);
						} catch ( Exception $e ) {
							$return_array = array( 'status' => $e->getMessage() );
						}
					} else {
						echo wp_json_encode(
							array(
								'status' => esc_html__( 'Your panel has no fields. Nothing to save.', 'redux-framework' ),
							)
						);
					}
				}
			}

			if ( isset( $core->transients['run_compiler'] ) && $core->transients['run_compiler'] ) {
				$core->no_output = true;
				$core->output_class->enqueue();

				try {

					// phpcs:ignore WordPress.NamingConventions.ValidVariableName
					$compiler_css = $core->compilerCSS;  // I fucking hate backward compatibility sometimes.  >:(.

					/**
					 * Action 'redux/options/{opt_name}/compiler'
					 *
					 * @param array  options
					 * @param string CSS that get sent to the compiler hook
					 */

					// phpcs:ignore WordPress.NamingConventions.ValidHookName
					do_action( 'redux/options/' . $core->args['opt_name'] . '/compiler', $core->options, $compiler_css, $core->transients['changed_values'] );

					/**
					 * Action 'redux/options/{opt_name}/compiler/advanced'
					 *
					 * @param array  options
					 * @param string CSS that get sent to the compiler hook, which sends the full Redux object
					 */

					// phpcs:ignore WordPress.NamingConventions.ValidHookName
					do_action( 'redux/options/' . $core->args['opt_name'] . '/compiler/advanced', $core );
				} catch ( Exception $e ) {
					$return_array = array( 'status' => $e->getMessage() );
				}

				unset( $core->transients['run_compiler'] );
				$core->transient_class->set();
			}

			if ( isset( $return_array ) ) {
				if ( 'success' === $return_array['status'] ) {
					$panel = new Redux_Panel( $redux );
					ob_start();
					$panel->notification_bar();
					$notification_bar = ob_get_contents();
					ob_end_clean();
					$return_array['notification_bar'] = $notification_bar;
				}

				// phpcs:ignore WordPress.NamingConventions.ValidHookName
				echo wp_json_encode( apply_filters( 'redux/options/' . $core->args['opt_name'] . '/ajax_save/response', $return_array ) );
			}

			die();
		}

		/**
		 * Parses the string into variables without the max_input_vars limitation.
		 *
		 * @since   3.5.7.11
		 * @author  harunbasic
		 * @access  private
		 *
		 * @param   string $string String of data.
		 *
		 * @return  array|false $result
		 */
		private function parse_str( $string ) {
			if ( '' === $string ) {
				return false;
			}

			$result = array();
			$pairs  = explode( '&', $string );

			foreach ( $pairs as $key => $pair ) {
				// use the original parse_str() on each element.
				parse_str( $pair, $params );

				$k = key( $params );

				if ( ! isset( $result[ $k ] ) ) {
					$result += $params;
				} elseif ( is_array( $result[ $k ] ) && is_array( $params[ $k ] ) ) {
					$result[ $k ] = $this->array_merge_recursive_distinct( $result[ $k ], $params[ $k ] );
				}
			}

			return $result;
		}

		/**
		 * Merge arrays without converting values with duplicate keys to arrays as array_merge_recursive does.
		 * As seen here http://php.net/manual/en/function.array-merge-recursive.php#92195
		 *
		 * @since   3.5.7.11
		 * @author  harunbasic
		 * @access  private
		 *
		 * @param   array $array1 array one.
		 * @param   array $array2 array two.
		 *
		 * @return  array $merged
		 */
		private function array_merge_recursive_distinct( array $array1, array $array2 ) {
			$merged = $array1;

			foreach ( $array2 as $key => $value ) {

				if ( is_array( $value ) && isset( $merged[ $key ] ) && is_array( $merged[ $key ] ) ) {
					$merged[ $key ] = $this->array_merge_recursive_distinct( $merged[ $key ], $value );
				} elseif ( is_numeric( $key ) && isset( $merged[ $key ] ) ) {
					$merged[] = $value;
				} else {
					$merged[ $key ] = $value;
				}
			}

			return $merged;
		}
	}
}

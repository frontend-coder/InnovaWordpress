<?php // phpcs:ignore WordPress.NamingConventions.ValidVariableName
/**
 * Redux Framework API Class
 * Makes instantiating a Redux object an absolute piece of cake.
 *
 * @package     Redux_Framework
 * @author      Dovy Paukstys
 * @subpackage  Core
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Don't duplicate me!
if ( ! class_exists( 'Redux', false ) ) {

	/**
	 * Redux API Class
	 * Simple API for Redux Framework
	 *
	 * @since       3.0.0
	 */
	class Redux {

		/**
		 *  Option fields.
		 *
		 * @var array
		 */
		public static $fields = array();

		/**
		 * Option sections.
		 *
		 * @var array
		 */
		public static $sections = array();

		/**
		 * Option defaults.
		 *
		 * @var array
		 */
		public static $options_defaults = array();

		/**
		 * Option help array.
		 *
		 * @var array
		 */
		public static $help = array();

		/**
		 * Option global args.
		 *
		 * @var array
		 */
		public static $args = array();

		/**
		 * Option section priorities.
		 *
		 * @var array
		 */
		public static $priority = array();

		/**
		 * Panel validations errors.
		 *
		 * @var array
		 */
		public static $errors = array();

		/**
		 * Init.
		 *
		 * @var array
		 */
		public static $init = array();

		/**
		 * Extension list.
		 *
		 * @var array
		 */
		public static $extensions = array();

		/**
		 * Extensions in use.
		 *
		 * @var array
		 */
		public static $uses_extensions = array();

		/**
		 * Extension paths.
		 *
		 * @var array
		 */
		public static $extension_paths = array();

		/**
		 * Comment.
		 *
		 * @param object $closure ?.
		 * @param array  $args    ?.
		 *
		 * @return mixed
		 */
		public function __call( $closure, $args ) {
			return call_user_func_array( $this->{$closure}->bindTo( $this ), $args );
		}

		/**
		 * Comment.
		 *
		 * @return mixed
		 */
		public function __toString() {
			return call_user_func( $this->{'__toString'}->bindTo( $this ) );
		}

		/**
		 * Code to run at creation in instance.
		 */
		public static function load() {
			add_action( 'after_setup_theme', array( 'Redux', 'createRedux' ) );
			add_action( 'init', array( 'Redux', 'createRedux' ) );
			add_action( 'switch_theme', array( 'Redux', 'createRedux' ) );

			if ( version_compare( PHP_VERSION, '5.5.0', '<' ) ) {
				include_once Redux_Core::$_dir . 'inc/lib/array_column.php';
			}
		}

		/**
		 * Init Redux object
		 *
		 * @param string $opt_name Panel opt_name.
		 */
		public static function init( $opt_name = '' ) {
			if ( ! empty( $opt_name ) ) {
				self::loadRedux( $opt_name );
				remove_action( 'setup_theme', array( 'Redux', 'createRedux' ) );
			}
		}

		/**
		 * Retrive ReduxFramework object.
		 *
		 * @param string $opt_name Panel opt_name.
		 *
		 * @return object|ReduxFramework
		 */
		public static function instance( $opt_name ) {
			return Redux_Instances::get_instance( $opt_name );
		}

		/**
		 * Retrieve all ReduxFramework Instances.
		 *
		 * @return array|ReduxFramework[]
		 */
		public static function all_instances() {
			return Redux_Instances::get_all_instances();
		}

		/**
		 * Load external extensions.
		 *
		 * @param object $redux_framework ReduxFramework object.
		 *
		 * @deprecated No longer using camcelCase naming convensions.
		 */
		public static function loadExtensions( $redux_framework ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			self::load_extensions( $redux_framework );
		}

		/**
		 * Load external extensions.
		 *
		 * @param object $redux_framework ReduxFramework object.
		 */
		public static function load_extensions( $redux_framework ) {
			$instance_extensions = self::get_extensions( $redux_framework->args['opt_name'], '' );

			if ( $instance_extensions ) {
				foreach ( $instance_extensions as $name => $extension ) {
					if ( ! class_exists( $extension['class'] ) ) {
						// In case you wanted override your override, hah.
						// phpcs:ignore WordPress.NamingConventions.ValidHookName
						$extension['path'] = apply_filters( 'redux/extension/' . $redux_framework->args['opt_name'] . '/' . $name, $extension['path'] );

						if ( file_exists( $extension['path'] ) ) {
							require_once $extension['path'];
						}
					}
					if ( ! isset( $redux_framework->extensions[ $name ] ) ) {
						if ( class_exists( $extension['class'] ) ) {
							$redux_framework->extensions[ $name ] = new $extension['class']( $redux_framework );
						} else {
							$ext_name = str_replace( 'ReduxFramework_Extension_', '', $extension['class'] );
							$ext_name = str_replace( '_', ' ', $ext_name );
							$ext_name = ucwords( $ext_name );

							// phpcs:ignore Squiz.PHP.CommentedOutCode
							/* _deprecated_file( 'The ' . esc_html( $ext_name ) . ' extension', esc_html( $extension['version'] ) . ' due to incompatibility with Redux v4', 'an updated version from https://reduxframework.com/extensions' ); */

							$old_class = str_replace( 'ReduxFramework_', 'Redux_', $extension['class'] );

							if ( class_exists( $old_class ) ) {
								$redux_framework->extensions[ $name ] = new $old_class( $redux_framework );
							} else {
								echo '<div id="message" class="error"><p>No class named <strong>' . esc_html( $extension['class'] ) . '</strong> exists. Please verify your extension path.</p></div>';
							}
						}
					}
				}
			}
		}

		/**
		 * Depreciated function to set extension path.
		 *
		 * @param      string $extension Path.
		 * @param      bool   $folder    Set if path is a folder.
		 *
		 * @deprecated No longer using cameCase naming convensions.
		 * @return bool|mixed
		 */
		public static function extensionPath( $extension, $folder = true ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			return self::extension_path( $extension, $folder = true );
		}

		/**
		 * Sets a path to an extension.
		 *
		 * @param      string $extension Path to extension.
		 * @param      bool   $folder    Set if path is a folder.
		 *
		 * @return bool|mixed
		 */
		public static function extension_path( $extension, $folder = true ) {
			if ( ! isset( self::$extensions[ $extension ] ) ) {
				return false;
			}

			$path = end( self::$extensions[ $extension ] );

			if ( ! $folder ) {
				return $path;
			}

			return str_replace( 'extension_' . $extension . '.php', '', $path );
		}

		/**
		 * Depreciated function of Load Redux Framework.
		 *
		 * @param string $opt_name Panrl opt_name.
		 *
		 * @deprecated No longer using camelCase naming convensions.
		 */
		public static function loadRedux( $opt_name = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			self::load_redux( $opt_name );
		}

		/**
		 * Load Redux Framework.
		 *
		 * @param string $opt_name Panrl opt_name.
		 */
		public static function load_redux( $opt_name = '' ) {
			if ( empty( $opt_name ) ) {
				return;
			}

			if ( ! class_exists( 'ReduxFramework' ) ) {
				if ( isset( self::$init[ $opt_name ] ) && ! empty( self::$init[ $opt_name ] ) ) {
					return;
				}

				self::$init[ $opt_name ] = 1;

				// Try to load the class if in the same directory, so the user only have to include the Redux API.
				if ( ! class_exists( 'Redux_Options_Defaults' ) ) {
					$file_check = trailingslashit( dirname( __FILE__ ) ) . 'class-redux-options-defaults.php';
					if ( file_exists( dirname( $file_check ) ) ) {
						include_once $file_check;
						$file_check = trailingslashit( dirname( __FILE__ ) ) . 'class-redux-wordpress-data.php';
						if ( file_exists( dirname( $file_check ) ) ) {
							include_once $file_check;
						}
					}
				}

				if ( class_exists( 'Redux_Options_Defaults' ) ) {
					$sections                            = self::construct_sections( $opt_name );
					$wordpress_data                      = ( ! class_exists( 'Redux_WordPress_Data' ) ) ? null : new Redux_WordPress_Data( $opt_name );
					$options_defaults_class              = new Redux_Options_Defaults();
					self::$options_defaults[ $opt_name ] = $options_defaults_class->default_values( $opt_name, $sections, $wordpress_data );
					if ( '' === self::$args[ $opt_name ]['global_variable'] && false !== self::$args[ $opt_name ]['global_variable'] ) {
						self::$args[ $opt_name ]['global_variable'] = str_replace( '-', '_', $opt_name );
					}
					if ( self::$args[ $opt_name ]['global_variable'] ) {
						$option_global = self::$args[ $opt_name ]['global_variable'];

						/**
						 * Filter 'redux/options/{opt_name}/global_variable'
						 *
						 * @param array $value option value to set global_variable with
						 */
						global $$option_global;

						// phpcs:ignore WordPress.NamingConventions.ValidHookName
						$$option_global = apply_filters( 'redux/options/' . $opt_name . '/global_variable', self::$options_defaults[ $opt_name ] );
					}

					return;
				} else {
					echo '<div id="message" class="error"><p>' . esc_html__( 'Redux Framework is not installed. Please install it.', 'redux-framework' ) . '</p></div>';

					return;
				}
			}

			$check = self::instance( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( isset( $check->api_has_run ) ) {
				return;
			}

			$args     = self::construct_args( $opt_name );
			$sections = self::construct_sections( $opt_name );

			if ( isset( self::$uses_extensions[ $opt_name ] ) && ! empty( self::$uses_extensions[ $opt_name ] ) ) {
				add_action( "redux/extensions/{$opt_name}/before", array( 'Redux', 'loadExtensions' ), 0 );
			}

			$redux                   = new ReduxFramework( $sections, $args );
			$redux->api_has_run      = 1;
			self::$init[ $opt_name ] = 1;

			if ( isset( $redux->args['opt_name'] ) && $redux->args['opt_name'] !== $opt_name ) {
				self::$init[ $redux->args['opt_name'] ] = 1;
			}
		}

		/**
		 * Depreciated Create Redux instance.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function createRedux() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			self::create_redux();
		}

		/**
		 * Create Redux instance.
		 */
		public static function create_redux() {
			foreach ( self::$sections as $opt_name => $the_sections ) {
				if ( ! empty( $the_sections ) ) {
					if ( ! self::$init[ $opt_name ] ) {
						self::loadRedux( $opt_name );
					}
				}
			}
		}

		/**
		 * Constrct global arguments.
		 *
		 * @param atring $opt_name Panel opt_name.
		 *
		 * @return array|mixed
		 */
		public static function construct_args( $opt_name ) {
			$args             = isset( self::$args[ $opt_name ] ) ? self::$args[ $opt_name ] : array();
			$args['opt_name'] = $opt_name;

			if ( ! isset( $args['menu_title'] ) ) {
				$args['menu_title'] = ucfirst( $opt_name ) . ' Options';
			}

			if ( ! isset( $args['page_title'] ) ) {
				$args['page_title'] = ucfirst( $opt_name ) . ' Options';
			}

			if ( ! isset( $args['page_slug'] ) ) {
				$args['page_slug'] = $opt_name . '_options';
			}

			return $args;
		}

		/**
		 * Construct option panel sections.
		 *
		 * @param string $opt_name Panel opt_name.
		 *
		 * @return array
		 */
		public static function construct_sections( $opt_name ) {
			$sections = array();

			if ( ! isset( self::$sections[ $opt_name ] ) ) {
				return $sections;
			}

			foreach ( self::$sections[ $opt_name ] as $section_id => $section ) {
				$section['fields'] = self::construct_fields( $opt_name, $section_id );
				$p                 = $section['priority'];

				while ( isset( $sections[ $p ] ) ) {
					$p ++;
				}

				$sections[ $p ] = $section;
			}

			ksort( $sections );

			return $sections;
		}

		/**
		 * Construct option panel fields.
		 *
		 * @param string $opt_name   Panel opt_name.
		 * @param string $section_id ID of section.
		 *
		 * @return array
		 */
		public static function construct_fields( $opt_name = '', $section_id = '' ) {
			$fields = array();

			if ( ! empty( self::$fields[ $opt_name ] ) ) {
				foreach ( self::$fields[ $opt_name ] as $key => $field ) {
					if ( $field['section_id'] === $section_id ) {
						$p = esc_html( $field['priority'] );

						while ( isset( $fields[ $p ] ) ) {
							echo intval( $p ++ );
						}

						$fields[ $p ] = $field;
					}
				}
			}

			ksort( $fields );

			return $fields;
		}

		/**
		 * Depreciated Retrieve panel section.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Section ID.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 * @return bool
		 */
		public static function getSection( $opt_name = '', $id = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			return self::get_section( $opt_name, $id );
		}

		/**
		 * Retrieve panel section.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Section ID.
		 *
		 * @return bool
		 */
		public static function get_section( $opt_name = '', $id = '' ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( $opt_name ) && ! empty( $id ) ) {
				if ( ! isset( self::$sections[ $opt_name ][ $id ] ) ) {
					$id = strtolower( sanitize_html_class( $id ) );
				}

				return isset( self::$sections[ $opt_name ][ $id ] ) ? self::$sections[ $opt_name ][ $id ] : false;
			}

			return false;
		}

		/**
		 * Create a section of the option panel.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $sections Section ID.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function setSections( $opt_name = '', $sections = array() ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::set_sections( $opt_name, $sections );
		}

		/**
		 * Create multiple sections of the option panel.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $sections Section ID.
		 */
		public static function set_sections( $opt_name = '', $sections = array() ) {
			if ( empty( $sections ) ) {
				return;
			}
			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( ! empty( $sections ) ) {
				foreach ( $sections as $section ) {
					self::set_section( $opt_name, $section );
				}
			}
		}

		/**
		 * Depreciated Retrieve all sections from the option panel.
		 *
		 * @param string $opt_name Panel opt_name.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 * @return array|mixed
		 */
		public static function getSections( $opt_name = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			return self::get_sections( $opt_name );
		}

		/**
		 * Retrieve all sections from the option panel.
		 *
		 * @param string $opt_name Panel opt_name.
		 *
		 * @return array|mixed
		 */
		public static function get_sections( $opt_name = '' ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( self::$sections[ $opt_name ] ) ) {
				return self::$sections[ $opt_name ];
			}

			return array();
		}

		/**
		 * Depreciated Remove option panel by ID.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Sectio ID.
		 * @param bool   $fields   Remove fields.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function removeSection( $opt_name = '', $id = '', $fields = false ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::remove_section( $opt_name, $id, $fields );
		}

		/**
		 * Remove option panel by ID.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Sectio ID.
		 * @param bool   $fields   Remove fields.
		 */
		public static function remove_section( $opt_name = '', $id = '', $fields = false ) {
			if ( ! empty( $opt_name ) && ! empty( $id ) ) {

				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

				if ( isset( self::$sections[ $opt_name ][ $id ] ) ) {
					$priority = '';

					foreach ( self::$sections[ $opt_name ] as $key => $section ) {
						if ( $key === $id ) {
							$priority = $section['priority'];
							self::$priority[ $opt_name ]['sections'] --;
							unset( self::$sections[ $opt_name ][ $id ] );
							continue;
						}
						if ( '' !== $priority ) {
							$new_priority                        = $section['priority'];
							$section['priority']                 = $priority;
							self::$sections[ $opt_name ][ $key ] = $section;
							$priority                            = $new_priority;
						}
					}

					if ( isset( self::$fields[ $opt_name ] ) && ! empty( self::$fields[ $opt_name ] ) && true === $fields ) {
						foreach ( self::$fields[ $opt_name ] as $key => $field ) {
							if ( $field['section_id'] === $id ) {
								unset( self::$fields[ $opt_name ][ $key ] );
							}
						}
					}
				}
			}
		}

		/**
		 * Sets a single option panel section.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $section  Section data.
		 */
		public static function setSection( $opt_name = '', $section = array() ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::set_section( $opt_name, $section );
		}

		/**
		 * Sets a single option panel section.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $section  Section data.
		 */
		public static function set_section( $opt_name = '', $section = array() ) {
			if ( empty( $section ) ) {
				return;
			}

			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( ! isset( $section['id'] ) ) {
				if ( isset( $section['type'] ) && 'divide' === $section['type'] ) {
					$section['id'] = time();
				} else {
					if ( isset( $section['title'] ) ) {
						$section['id'] = strtolower( sanitize_title( $section['title'] ) );
					} else {
						$section['id'] = time();
					}
				}

				if ( isset( self::$sections[ $opt_name ][ $section['id'] ] ) ) {
					$orig = $section['id'];
					$i    = 0;

					while ( isset( self::$sections[ $opt_name ][ $section['id'] ] ) ) {
						$section['id'] = $orig . '_' . $i;
						$i ++;
					}
				}
			}

			if ( ! empty( $opt_name ) && is_array( $section ) && ! empty( $section ) ) {
				if ( ! isset( $section['id'] ) && ! isset( $section['title'] ) ) {
					self::$errors[ $opt_name ]['section']['missing_title'] = esc_html__( 'Unable to create a section due to missing id and title.', 'redux-framework' );

					return;
				}

				if ( ! isset( $section['priority'] ) ) {
					$section['priority'] = self::get_priority( $opt_name, 'sections' );
				}

				if ( isset( $section['fields'] ) ) {
					if ( ! empty( $section['fields'] ) && is_array( $section['fields'] ) ) {
						self::process_field_array( $opt_name, $section['id'], $section['fields'] );
					}
					unset( $section['fields'] );
				}

				self::$sections[ $opt_name ][ $section['id'] ] = $section;
			} else {
				self::$errors[ $opt_name ]['section']['empty'] = esc_html__( 'Unable to create a section due an empty section array or the section variable passed was not an array.', 'redux-framework' );

				return;
			}
		}

		/**
		 * Depreciated Hides an option panel section.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Section ID.
		 * @param bool   $hide     Flag to hide/show.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function hideSection( $opt_name = '', $id = '', $hide = true ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::hide_section( $opt_name, $id, $hide );
		}

		/**
		 * Hides an option panel section.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Section ID.
		 * @param bool   $hide     Flag to hide/show.
		 */
		public static function hide_section( $opt_name = '', $id = '', $hide = true ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( $opt_name ) && ! empty( $id ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
				if ( isset( self::$sections[ $opt_name ][ $id ] ) ) {
					self::$sections[ $opt_name ][ $id ]['hidden'] = $hide;
				}
			}
		}

		/**
		 * Compiles field array data.
		 *
		 * @param string $opt_name   Panel opt_name.
		 * @param string $section_id Section ID.
		 * @param array  $fields     Field data.
		 */
		private static function process_field_array( $opt_name = '', $section_id = '', $fields = array() ) {
			if ( ! empty( $opt_name ) && ! empty( $section_id ) && is_array( $fields ) && ! empty( $fields ) ) {
				foreach ( $fields as $field ) {
					if ( ! is_array( $field ) ) {
						continue;
					}

					$field['section_id'] = $section_id;
					self::set_field( $opt_name, $field );
				}
			}
		}

		/**
		 * Depreciated Retrieves an option panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Field ID.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 * @return bool
		 */
		public static function getField( $opt_name = '', $id = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			return self::get_field( $opt_name, $id );
		}

		/**
		 * Retrieves an option panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Field ID.
		 *
		 * @return bool
		 */
		public static function get_field( $opt_name = '', $id = '' ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( $opt_name ) && ! empty( $id ) ) {
				return isset( self::$fields[ $opt_name ][ $id ] ) ? self::$fields[ $opt_name ][ $id ] : false;
			}

			return false;
		}

		/**
		 * Hides an optio panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Field ID.
		 * @param bool   $hide     Set hide/show.
		 */
		public static function hideField( $opt_name = '', $id = '', $hide = true ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::hide_field( $opt_name, $id, $hide );
		}

		/**
		 * Hides an optio panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Field ID.
		 * @param bool   $hide     Set hide/show.
		 */
		public static function hide_field( $opt_name = '', $id = '', $hide = true ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( $opt_name ) && ! empty( $id ) ) {
				if ( isset( self::$fields[ $opt_name ][ $id ] ) ) {
					// phpcs:ignore WordPress.PHP.DevelopmentFunctions
					Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

					if ( ! $hide ) {
						self::$fields[ $opt_name ][ $id ]['class'] = str_replace( 'hidden', '', self::$fields[ $opt_name ][ $id ]['class'] );
					} else {
						self::$fields[ $opt_name ][ $id ]['class'] .= 'hidden';
					}
				}
			}
		}

		/**
		 * Creates an option panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $field    Field data.
		 */
		public static function setField( $opt_name = '', $field = array() ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::set_field( $opt_name, $field );
		}

		/**
		 * Creates an option panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $field    Field data.
		 */
		public static function set_field( $opt_name = '', $field = array() ) {
			if ( empty( $field ) ) {
				return;
			}
			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( ! empty( $opt_name ) && is_array( $field ) && ! empty( $field ) ) {
				if ( ! isset( $field['priority'] ) ) {
					$field['priority'] = self::get_priority( $opt_name, 'fields' );
				}

				if ( isset( $field['id'] ) ) {
					self::$fields[ $opt_name ][ $field['id'] ] = $field;
				}
			}
		}

		/**
		 * Depreciated Removes an option panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Field ID.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 * @return bool
		 */
		public static function removeField( $opt_name = '', $id = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			return self::remove_field( $opt_name, $id );
		}

		/**
		 * Removes an option panel field.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $id       Field ID.
		 *
		 * @return bool
		 */
		public static function remove_field( $opt_name = '', $id = '' ) {

			if ( ! empty( $opt_name ) && ! empty( $id ) ) {

				self::check_opt_name( $opt_name );

				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

				if ( isset( self::$fields[ $opt_name ][ $id ] ) ) {
					foreach ( self::$fields[ $opt_name ] as $key => $field ) {
						if ( $key === $id ) {
							$priority = $field['priority'];
							self::$priority[ $opt_name ]['fields'] --;
							unset( self::$fields[ $opt_name ][ $id ] );
							continue;
						}

						if ( isset( $priority ) && '' !== $priority ) {
							$new_priority                      = $field['priority'];
							$field['priority']                 = $priority;
							self::$fields[ $opt_name ][ $key ] = $field;
							$priority                          = $new_priority;
						}
					}
				}
			}

			return false;
		}

		/**
		 * Depreciated Sets help tabs on option panel admin page.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $tab      Tab data.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function setHelpTab( $opt_name = '', $tab = array() ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::set_help_tab( $opt_name, $tab );
		}

		/**
		 * Sets help tabs on option panel admin page.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $tab      Tab data.
		 */
		public static function set_help_tab( $opt_name = '', $tab = array() ) {
			if ( empty( $tab ) ) {
				return;
			}
			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( ! empty( $opt_name ) && ! empty( $tab ) ) {
				if ( ! isset( self::$args[ $opt_name ]['help_tabs'] ) ) {
					self::$args[ $opt_name ]['help_tabs'] = array();
				}

				if ( isset( $tab['id'] ) ) {
					self::$args[ $opt_name ]['help_tabs'][] = $tab;
				} elseif ( is_array( end( $tab ) ) ) {
					foreach ( $tab as $tab_item ) {
						self::$args[ $opt_name ]['help_tabs'][] = $tab_item;
					}
				}
			}
		}

		/**
		 * Depreciated Sets the help sidebar content.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $content  Content.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function setHelpSidebar( $opt_name = '', $content = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::set_help_sidebar( $opt_name, $content );
		}

		/**
		 * Sets the help sidebar content.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $content  Content.
		 */
		public static function set_help_sidebar( $opt_name = '', $content = '' ) {
			if ( empty( $content ) || empty( $opt_name ) ) {
				return;
			}
			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( ! empty( $opt_name ) && ! empty( $content ) ) {
				self::$args[ $opt_name ]['help_sidebar'] = $content;
			}
		}

		/**
		 * Depreciated Sets option panel global arguments.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $args     Argument data.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function setArgs( $opt_name = '', $args = array() ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::set_args( $opt_name, $args );
		}

		/**
		 * Sets option panel global arguments.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $args     Argument data.
		 */
		public static function set_args( $opt_name = '', $args = array() ) {
			if ( empty( $args ) || empty( $opt_name ) ) {
				return;
			}
			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( ! empty( $opt_name ) && ! empty( $args ) && is_array( $args ) ) {
				if ( isset( self::$args[ $opt_name ] ) && isset( self::$args[ $opt_name ]['clearArgs'] ) ) {
					self::$args[ $opt_name ] = array();
				}
				self::$args[ $opt_name ] = wp_parse_args( $args, self::$args[ $opt_name ] );
			}
		}

		/**
		 * Set's developer key for premium services.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $arg      Args data.
		 */
		public static function set_developer( $opt_name = '', $arg = '' ) {
			if ( empty( $arg ) || empty( $opt_name ) ) {
				return;
			}

			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			self::$args[ $opt_name ]['developer'] = $arg;

		}

		/**
		 * Deprecated Retrives option panel global arguemnt array.
		 *
		 * @param string $opt_name Panel opt_name.
		 *
		 * @deprecated No longer camelCase naming convention.
		 * @return mixed
		 */
		public static function getArgs( $opt_name = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			return self::get_args( $opt_name );
		}

		/**
		 * Retrives option panel global arguemnt array.
		 *
		 * @param string $opt_name Panel opt_name.
		 *
		 * @return mixed
		 */
		public static function get_args( $opt_name = '' ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( $opt_name ) && ! empty( self::$args[ $opt_name ] ) ) {
				return self::$args[ $opt_name ];
			}
		}

		/**
		 * Deprecated Retrieves a single global argument.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Argument name.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function getArg( $opt_name = '', $key = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			return self::get_arg( $opt_name, $key );
		}

		/**
		 * Retrieves a single global argument.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Argument name.
		 */
		public static function get_arg( $opt_name = '', $key = '' ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( $opt_name ) && ! empty( $key ) && ! empty( self::$args[ $opt_name ] ) ) {
				return self::$args[ $opt_name ][ $key ];
			} else {
				return;
			}
		}

		/**
		 * Deprecated Retrieves single option from the database.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Option key.
		 * @param string $default  Default value.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 * @return mixed
		 */
		public static function getOption( $opt_name = '', $key = '', $default = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			return self::get_option( $opt_name, $key );
		}

		/**
		 * Retrieves single option from the database.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Option key.
		 * @param string $default  Default value.
		 *
		 * @return mixed
		 */
		public static function get_option( $opt_name = '', $key = '', $default = '' ) {
			self::check_opt_name( $opt_name );

			if ( ! empty( $opt_name ) && ! empty( $key ) ) {
				$redux = get_option( $opt_name );

				if ( isset( $redux[ $key ] ) ) {
					return $redux[ $key ];
				} else {
					return $default;
				}
			} else {
				return null;
			}
		}

		/**
		 * Deprecated Sets an option into the database.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Option key.
		 * @param string $option   Option value.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 * @return bool
		 */
		public static function setOption( $opt_name = '', $key = '', $option = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			return self::set_option( $opt_name, $key, $option );
		}

		/**
		 * Sets an option into the database.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Option key.
		 * @param string $option   Option value.
		 *
		 * @return bool
		 */
		public static function set_option( $opt_name = '', $key = '', $option = '' ) {
			if ( empty( $key ) ) {
				return false;
			}
			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( ! empty( $opt_name ) && ! empty( $key ) ) {
				$redux         = get_option( $opt_name );
				$redux[ $key ] = $option;

				return update_option( $opt_name, $redux );
			} else {
				return false;
			}
		}

		/**
		 * Get next availablt priority for field/section.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $type     Field or section.
		 *
		 * @return mixed
		 */
		public static function get_priority( $opt_name, $type ) {
			$priority                              = self::$priority[ $opt_name ][ $type ];
			self::$priority[ $opt_name ][ $type ] += 1;

			return $priority;
		}

		/**
		 * Check opt_name integrity.
		 *
		 * @param string $opt_name Panel opt_name.
		 */
		public static function check_opt_name( $opt_name = '' ) {

			if ( empty( $opt_name ) || is_array( $opt_name ) ) {
				return;
			}
			if ( ! isset( self::$sections[ $opt_name ] ) ) {
				self::$sections[ $opt_name ]             = array();
				self::$priority[ $opt_name ]['sections'] = 1;
			}
			if ( ! isset( self::$args[ $opt_name ] ) ) {
				self::$args[ $opt_name ]             = array();
				self::$priority[ $opt_name ]['args'] = 1;
			}
			if ( ! isset( self::$fields[ $opt_name ] ) ) {
				self::$fields[ $opt_name ]             = array();
				self::$priority[ $opt_name ]['fields'] = 1;
			}
			if ( ! isset( self::$help[ $opt_name ] ) ) {
				self::$help[ $opt_name ]             = array();
				self::$priority[ $opt_name ]['help'] = 1;
			}
			if ( ! isset( self::$errors[ $opt_name ] ) ) {
				self::$errors[ $opt_name ] = array();
			}
			if ( ! isset( self::$init[ $opt_name ] ) ) {
				self::$init[ $opt_name ] = false;
			}
		}

		/**
		 * Retrieve metadata from a file. Based on WP Core's get_file_data function
		 *
		 * @since 2.1.1
		 *
		 * @param string $file Path to the file.
		 *
		 * @return string
		 */
		public static function get_file_version( $file ) {
			$data = get_file_data( $file, array( 'version' ), 'plugin' );

			return $data[0];
		}

		/**
		 * Verift extension class name.
		 *
		 * @param string $opt_name   Panel opt_name.
		 * @param string $name       extension name.
		 * @param string $class_file Extension class file.
		 * @param string $instance   Redux instance.
		 */
		private static function check_extension_class_file( $opt_name, $name = '', $class_file = '', $instance = '' ) {
			if ( file_exists( $class_file ) ) {
				self::$uses_extensions[ $opt_name ] = isset( self::$uses_extensions[ $opt_name ] ) ? self::$uses_extensions[ $opt_name ] : array();

				if ( ! in_array( $name, self::$uses_extensions[ $opt_name ], true ) ) {
					self::$uses_extensions[ $opt_name ][] = $name;
				}

				self::$extensions[ $name ] = isset( self::$extensions[ $name ] ) ? self::$extensions[ $name ] : array();

				$version = Redux_Helpers::get_template_version( $class_file );

				if ( empty( $version ) && ! empty( $instance ) ) {
					if ( isset( $instance->version ) ) {
						$version = $instance->version;
					}
				}
				self::$extensions[ $name ][ $version ] = isset( self::$extensions[ $name ][ $version ] ) ? self::$extensions[ $name ][ $version ] : $class_file;

				$new_name = str_replace( '_', '-', $name );

				$api_check = str_replace( array( 'extension_' . $name, 'class-redux-extension-' . $new_name ), array( $name . '_api', 'class-redux-' . $new_name . '-api' ), $class_file );
				$api_check = str_replace( '-lite', '', $api_check );

				if ( true === self::overload_legacy_metaboxes() ) {
					$name      = '';
					$api_check = '';
				}

				if ( file_exists( $api_check ) && ! class_exists( 'Redux_' . ucfirst( $name ) ) ) {
					include_once $api_check;

					if ( 'metaboxes_lite' === $name ) {
						// phpcs:ignore WordPress.NamingConventions.ValidHookName
						do_action( 'redux/' . $opt_name . '/extensions/metaboxes/config/load', $opt_name );
					}
				}
			}
		}

		/**
		 * Check for loaded version of legacy metaboxes.
		 *
		 * @return bool
		 */
		private static function overload_legacy_metaboxes() {
			if ( true === Redux_Helpers::recursive_array_search( 'metaboxes', self::$uses_extensions ) ) {
				foreach ( self::$uses_extensions as $on => $arr ) {
					if ( in_array( 'metaboxes_lite', $arr, true ) === true ) {
						$key = array_search( 'metaboxes_lite', $arr, true );

						if ( false !== $key ) {
							unset( $arr[ $key ] );
						}

						self::$uses_extensions[ $on ] = $arr;

						return true;
					}
				}

				return false;
			}

			return false;
		}

		/**
		 * Deprecated Sets all extensions in path.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $path     Path to extension folder.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 */
		public static function setExtensions( $opt_name, $path ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			if ( ! empty( $opt_name ) ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions
				Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );
			}
			self::set_extensions( $opt_name, $path );
		}

		/**
		 * Sets all extensions in path.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $path     Path to extension folder.
		 * @param bool   $force    Make extension reload.
		 */
		public static function set_extensions( $opt_name, $path, $force = false ) {
			if ( empty( $path ) || empty( $opt_name ) ) {
				return;
			}
			if ( version_compare( PHP_VERSION, '5.5.0', '<' ) ) {
				include_once Redux_Core::$_dir . 'inc/lib/array-column.php';
			}
			self::check_opt_name( $opt_name );

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			Redux_Functions_Ex::record_caller( $opt_name, debug_backtrace()[ array_search( __FUNCTION__, array_column( debug_backtrace(), 'function' ), true ) ]['file'] );

			if ( is_dir( $path ) ) {
				$path   = trailingslashit( $path );
				$folder = str_replace( '.php', '', basename( $path ) );

				$folder_fix = str_replace( '_', '-', $folder );

				$files = array(
					$path . 'extension_' . $folder . '.php',
					$path . 'class-redux-extension-' . $folder_fix . '.php',
				);

				$ext_file = Redux_Functions::file_exists_ex( $files );

				if ( file_exists( $ext_file ) ) {
					self::check_extension_class_file( $opt_name, $folder, $ext_file );
				} else {
					$folders = scandir( $path, 1 );

					foreach ( $folders as $folder ) {
						if ( '.' === $folder[0] ) {
							continue;
						}

						$files = array(
							$path . $folder . '/extension_' . $folder . '.php',
							$path . $folder . '/class-redux-extension-' . $folder_fix . '.php',
						);

						$ext_file = Redux_Functions::file_exists_ex( $files );

						if ( file_exists( $ext_file ) ) {
							self::check_extension_class_file( $opt_name, $folder, $ext_file );
						} elseif ( is_dir( $path . $folder ) ) {
							self::set_extensions( $opt_name, $path . $folder );
							continue;
						}
					}
				}
			} elseif ( file_exists( $path ) ) {
				$name = explode( 'extension_', basename( $path ) );
				if ( isset( $name[1] ) && ! empty( $name[1] ) ) {
					$name = str_replace( '.php', '', $name[1] );
					self::check_extension_class_file( $opt_name, $name, $path );
				}
			}

			self::$extension_paths[ $opt_name ] = $path;

			if ( true === $force ) {
				if ( isset( self::$uses_extensions[ $opt_name ] ) && ! empty( self::$uses_extensions[ $opt_name ] ) ) {
					$redux = self::instance( $opt_name );

					if ( isset( $redux ) ) {
						self::overload_legacy_metaboxes();

						self::load_extensions( $redux );
					}
				}
			}
		}

		/**
		 * Retrieves all loaded extensions.
		 */
		private static function get_all_extension() {
			$redux = self::all_instances();

			foreach ( $redux as $instance ) {
				if ( ! empty( self::$uses_extensions[ $instance['args']['opt_name'] ] ) ) {
					continue;
				}
				if ( ! empty( $instance['extensions'] ) ) {
					self::get_instance_extension( $instance['args']['opt_name'], $instance );
				}
			}
		}

		/**
		 * Gets all loaded extension for the passed ReduxFramework instance.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param array  $instance ReduxFramework instance.
		 */
		public static function get_instance_extension( $opt_name, $instance = array() ) {
			if ( ! empty( self::$uses_extensions[ $opt_name ] ) || empty( $opt_name ) ) {
				return;
			}

			if ( empty( $instance ) ) {
				$instance = self::instance( $opt_name );
			}

			if ( empty( $instance ) || empty( $instance->extensions ) ) {
				return;
			}

			foreach ( $instance->extensions as $name => $extension ) {
				if ( 'widget_areas' === $name ) {
					$new = new Redux_Widget_Areas( $instance );
				}

				if ( isset( self::$uses_extensions[ $opt_name ][ $name ] ) ) {
					continue;
				}

				if ( isset( $extension->extension_dir ) ) {
					self::setExtensions( $opt_name, str_replace( $name, '', $extension->extension_dir ) );
				} elseif ( isset( $extension->_extension_dir ) ) {
					self::setExtensions( $opt_name, str_replace( $name, '', $extension->_extension_dir ) );
				}
			}
		}

		/**
		 * Deprecated Gets loaded extensions.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Extension name.
		 *
		 * @deprecated No longer using camelCase naming convention.
		 * @return array|bool|mixed
		 */
		public static function getExtensions( $opt_name = '', $key = '' ) { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
			_deprecated_function( __CLASS__ . '::' . __FUNCTION__, 'Redux 4.0.0', 'Redux::get_extensions( $opt_name, $key )' );

			return self::get_extensions( $opt_name, $key );
		}

		/**
		 * Gets loaded extensions.
		 *
		 * @param string $opt_name Panel opt_name.
		 * @param string $key      Extension name.
		 *
		 * @return array|bool|mixed
		 */
		public static function get_extensions( $opt_name = '', $key = '' ) {
			if ( empty( $opt_name ) ) {
				self::get_all_extension();

				if ( empty( $key ) ) {
					return self::$extension_paths;
				} else {
					if ( isset( self::$extension_paths[ $key ] ) ) {
						return self::$extension_paths[ $key ];
					}
				}
			} else {
				if ( empty( self::$uses_extensions[ $opt_name ] ) ) {
					self::get_instance_extension( $opt_name );
				}

				if ( empty( self::$uses_extensions[ $opt_name ] ) ) {
					return false;
				}

				$instance_extensions = array();

				foreach ( self::$uses_extensions[ $opt_name ] as $extension ) {
					$class_file                        = end( self::$extensions[ $extension ] );
					$name                              = str_replace( '.php', '', basename( $extension ) );
					$extension_class                   = 'ReduxFramework_Extension_' . $name;
					$instance_extensions[ $extension ] = array(
						'path'    => $class_file,
						'class'   => $extension_class,
						'version' => Redux_Helpers::get_template_version( $class_file ),
					);
				}

				return $instance_extensions;
			}

			return false;
		}

		/**
		 * Disable Redux demo mode.
		 */
		public static function disable_demo() {
			add_action( 'redux/loaded', 'Redux::remove_demo' );
		}

		/**
		 * Callback to remove demo mode from plugin menu.
		 */
		public static function remove_demo() {
			if ( class_exists( 'Redux_Framework_Plugin' ) ) {
				// phpcs:ignore Generic.Strings.UnnecessaryStringConcat
				call_user_func( 'remove' . '_filter', 'plugin_row_meta', array( Redux_Framework_Plugin::instance(), 'plugin_metalinks' ), null, 2 );

				remove_action( 'admin_notices', array( Redux_Framework_Plugin::instance(), 'admin_notices' ) );
			}
		}

	}

	Redux::load();
}

<?php
/**
 * Define settings for options
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_Settings_Pro' ) ) {

	/**
	 * @name PT_CV_Settings_Pro
	 * @todo Define settings for options
	 */
	class PT_CV_Settings_Pro {

		/**
		 * Advanced Order by options
		 *
		 * @return array
		 */
		static function orderby() {
			$result = array();

			$advanced_post_types = PT_CV_Values::post_types();

			foreach ( $advanced_post_types as $post_type => $name ) {
				// Get list of available order by attributes
				$post_type_filters = apply_filters( 'manage_edit-' . $post_type . '_columns', array() );
				if ( $post_type_filters ) {
					foreach ( $post_type_filters as $filter => $value ) {
						if ( $post_type == 'product' ) {
							// Remove 2 unnecessary options in Woo Product
							if ( ! in_array( $filter, array( 'price' ) ) ) {
								unset( $post_type_filters[$filter] );
							}
						}
					}
				}
				$options = $post_type_filters ? $post_type_filters : array();
				array_unshift( $options, __( '&mdash; Select &mdash;', PT_CV_DOMAIN_PRO ) );
				$result[$post_type] = array(
					array(
						'label'         => array(
							'text' => '',
						),
						'extra_setting' => array(
							'params' => array(
								'width' => 12,
							),
						),
						'params'        => array(
							array(
								'type'    => 'select',
								'name'    => $post_type . '-orderby',
								'options' => $options,
								'std'     => '',
							),
						),
					),
				);
			}

			return $result;
		}

		/**
		 * Settings of View type = Pinterest
		 *
		 * @return array
		 */
		static function view_type_settings_pinterest() {

			$prefix = 'pinterest-';

			$result = array(
				// Number of columns
				array(
					'label'  => array(
						'text' => __( 'Items per row', PT_CV_DOMAIN_PRO ),
					),
					'params' => array(
						array(
							'type'        => 'number',
							'name'        => $prefix . 'number-columns',
							'std'         => '3',
							'append_text' => '1 &rarr; 4',
							'desc'        => __( 'The number of items on each row', PT_CV_DOMAIN_PRO ),
						),
					),
				),

				// Use Shadow box or just Border
				array(
					'label'         => array(
						'text' => '',
					),
					'extra_setting' => array(
						'params' => array(
							'width' => 12,
						),
					),
					'params'        => array(
						array(
							'type'    => 'checkbox',
							'name'    => $prefix . 'box-style',
							'options' => PT_CV_Values::yes_no( 'border', __( 'Using normal border box instead of a shadow box', PT_CV_DOMAIN_PRO ) ),
							'std'     => '',
						),
					),
				),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'view_type_settings_pinterest', $result );

			return $result;
		}

		/**
		 * Settings of View type = Timeline
		 *
		 * @return array
		 */
		static function view_type_settings_timeline() {

			$prefix = 'timeline-';

			$result = array(
				PT_CV_Settings::setting_no_option(),
			);

			$result = apply_filters( PT_CV_PREFIX_ . 'view_type_settings_timeline', $result );

			return $result;
		}

		/**
		 * Font setting group
		 *
		 * @param array $prefix2 The prefix string for Meta fields option name
		 *
		 * @return array
		 */
		static function field_font_settings_group( $prefix2 ) {

			$result = array(
				'label'         => array(
					'text' => __( 'Font settings', PT_CV_DOMAIN_PRO ),
				),
				'extra_setting' => array(
					'params' => array(
						'wrap-id' => PT_CV_Html::html_group_id( 'google-fonts' ),
					),
				),
				'params'        => array(
					array(
						'type'   => 'group',
						'params' => array(

							// For Title
							self::field_settings_font(
								array(
									'label'     => __( 'of Title', PT_CV_DOMAIN_PRO ),
									'name'      => 'title',
									'font-size' => '',
									'color'     => '',
								), $prefix2
							),

							// For Content
							self::field_settings_font(
								array(
									'label'     => __( 'of Content', PT_CV_DOMAIN_PRO ),
									'name'      => 'content',
									'font-size' => '',
									'color'     => '',
									'bgcolor'   => '',
								), $prefix2
							),

							// For Meta fields
							self::field_settings_font(
								array(
									'label'     => __( 'of Meta fields', PT_CV_DOMAIN_PRO ),
									'name'      => 'meta-fields',
									'font-size' => '',
									'color'     => '',
								), $prefix2
							),

							// For Read more button
							self::field_settings_font(
								array(
									'label'     => __( 'of "Read more" button', PT_CV_DOMAIN_PRO ),
									'name'      => 'readmore',
									'depend'    => array( 'field-excerpt-readmore' ),
									'font-size' => '',
									'color'     => '#ffffff',
									'bgcolor'   => '#00aeef',
								)
							),

							// For Load more button
							self::field_settings_font(
								array(
									'label'     => __( 'of "Load more" button (pagination)', PT_CV_DOMAIN_PRO ),
									'name'      => 'more',
									'depend'    => array( 'pagination-style', 'loadmore' ),
									'font-size' => '',
									'color'     => '#ffffff',
									'bgcolor'   => '#00aeef',
								)
							),

							// For Custom fields
							self::field_settings_font(
								array(
									'label'     => __( 'of Custom fields', PT_CV_DOMAIN_PRO ),
									'name'      => 'custom-fields',
									'font-size' => '',
									'color'     => '',
								), $prefix2
							),

							// For Filter bar
							self::field_settings_font(
								array(
									'label'     => __( 'of Filter options', PT_CV_DOMAIN_PRO ),
									'name'      => 'filter-bar',
									'depend'    => array( 'enable-taxonomy-filter' ),
									'font-size' => '',
									'color'     => '',
									'bgcolor'   => '#00aeef',
								)
							),

						),
					),
				),
			);

			return $result;
		}

		/**
		 * Font setting options
		 *
		 * @param array  $args    Array of information
		 * @param string $prefix2 The prefix of parameters
		 *
		 * @return array
		 */
		static function field_settings_font( $args, $prefix2 = '' ) {

			// Span of setting value
			$setting_width = 12;

			$result = array(
				'label'         => array(
					'text' => __( $args['label'], PT_CV_DOMAIN_PRO ),
				),
				'extra_setting' => array(
					'params' => array(
						'width' => 10,
					),
				),
				'params'        => array(
					array(
						'type'   => 'group',
						'params' => array(

							// Color
							array(
								'label'         => array(
									'text' => __( 'Color', PT_CV_DOMAIN_PRO ),
								),
								'extra_setting' => array(
									'params' => array(
										'width' => $setting_width,
									),
								),
								'params'        => array(
									array(
										'type'    => 'color_picker',
										'options' => array(
											'type' => 'color',
											'name' => 'font-color-' . $args['name'],
											'std'  => $args['color'],
										),
									),
								)
							),

							// Font family
							array(
								'label'         => array(
									'text' => __( 'Font family', PT_CV_DOMAIN_PRO ),
								),
								'extra_setting' => array(
									'params' => array(
										'width' => $setting_width,
									),
								),
								'params'        => array(
									array(
										'type'                => 'select',
										'name'                => 'font-family-' . $args['name'],
										'options'             => PT_CV_Values_Pro::font_families(),
										'std'                 => '',
										'option_class_prefix' => PT_CV_PREFIX . 'font-',
									),
								),
							),

							// Font style
							array(
								'label'         => array(
									'text' => __( 'Font style', PT_CV_DOMAIN_PRO ),
								),
								'extra_setting' => array(
									'params' => array(
										'width' => $setting_width,
									),
								),
								'params'        => array(
									array(
										'type'    => 'select',
										'name'    => 'font-style-' . $args['name'],
										'options' => PT_CV_Values_Pro::font_styles(),
										'std'     => 'regular',
									),
								),
							),

							// Font size
							array(
								'label'         => array(
									'text' => __( 'Font size', PT_CV_DOMAIN_PRO ),
								),
								'extra_setting' => array(
									'params' => array(
										'width' => $setting_width,
									),
								),
								'params'        => array(
									array(
										'type'        => 'number',
										'name'        => 'font-size-' . $args['name'],
										'std'         => $args['font-size'],
										'append_text' => 'px',
									),
								),
							),

							// Background color
							isset( $args['bgcolor'] ) ? array(
								'label'         => array(
									'text' => '',
								),
								'extra_setting' => array(
									'params' => array(
										'width'      => 12,
										'wrap-class' => PT_CV_PREFIX . 'bg-color',
									),
								),
								'params'        => array(
									array(
										'type'    => 'color_picker',
										'options' => array(
											'type' => 'color',
											'name' => 'font-bgcolor-' . $args['name'],
											'std'  => $args['bgcolor'],
										),
									),
								)
							) : array(),
						),
					),
				),
				'dependence'    => array(
					$prefix2 . ( ! empty( $args['depend'][0] ) ? $args['depend'][0] : $args['name'] ), ! empty( $args['depend'][1] ) ? $args['depend'][1] : 'yes', ! empty( $args['depend'][2] ) ? $args['depend'][2] : '=',
				),
			);

			return $result;
		}

		/**
		 * View style setting options
		 *
		 * @return array
		 */
		static function view_style_settings() {

			$result = array(
				'label'         => array(
					'text' => __( 'View style', PT_CV_DOMAIN_PRO ),
				),
				'extra_setting' => array(
					'params' => array(
						'width' => 10,
					),
				),
				'params'        => array(
					array(
						'type'   => 'group',
						'params' => array(
							self::_margin_settings(),
							self::_text_align_settings(),
						),
					),
				),
			);

			return $result;
		}

		/**
		 * Animation & Effect setting options
		 *
		 * @return array
		 */
		static function animation_settings() {

			$prefix = 'anm-';

			$result = array(
				array(
					'label'  => array(
						'text' => __( 'Content animation', PT_CV_DOMAIN ),
					),
					'params' => array(
						array(
							'type'    => 'checkbox',
							'name'    => $prefix . 'content-hover',
							'options' => PT_CV_Values::yes_no( 'yes', __( 'Show content on hover thumbnail/title', PT_CV_DOMAIN ) ),
							'std'     => '',
							'desc'     => __( 'Only work with Grid layout<br>Each post must have thumbnail to make this function works correctly', PT_CV_DOMAIN_PRO ),
						),
					),
				),
			);

			return $result;
		}

		/**
		 * Margin setting
		 *
		 * @return array
		 */
		static function _margin_settings() {

			$settings = array();

			$prefix  = 'margin-value-';
			$options = array( 'top', 'left', 'bottom', 'right' );

			foreach ( $options as $option ) {
				$settings[] = array(
					'label'  => array(
						'text' => __( ucfirst( $option ), PT_CV_DOMAIN_PRO ),
					),
					'params' => array(
						array(
							'type'        => 'number',
							'name'        => $prefix . $option,
							'std'         => '',
							'append_text' => 'px',
						),
					),
				);
			}

			$result = array(
				'label'         => array(
					'text' => __( 'Margin', PT_CV_DOMAIN_PRO ),
				),
				'extra_setting' => array(
					'params' => array(
						'wrap-class' => 'form-inline',
					),
				),
				'params'        => array(
					array(
						'type'   => 'group',
						'params' => $settings,
					),
				),
			);

			return $result;
		}

		/**
		 * Text align
		 */
		static function _text_align_settings() {
			$prefix = 'style-';

			return array(
				'label'  => array(
					'text' => __( 'Text align', PT_CV_DOMAIN_PRO ),
				),
				'params' => array(
					array(
						'type'    => 'radio',
						'name'    => $prefix . 'text-align',
						'options' => PT_CV_Values_Pro::text_align(),
						'std'     => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::text_align() ),
					),
				),
			);
		}

		/**
		 * Advanced filters by Date
		 * @return array
		 */
		static function filter_date_settings() {

			$prefix = 'post_date_';

			// Date options
			$date = array(
				'date' => array(

					// Select date
					array(
						'label'  => array(
							'text' => __( 'Get posts', PT_CV_DOMAIN_PRO ),
						),
						'params' => array(
							array(
								'type'    => 'radio',
								'name'    => $prefix . 'value',
								'options' => PT_CV_Values_Pro::post_date(),
								'std'     => PT_CV_Functions::array_get_first_key( PT_CV_Values_Pro::post_date() ),
							),
						),
					),

					// Date value custom
					array(
						'label'  => array(
							'text' => '',
						),
						'params' => array(
							array(
								'type'   => 'group',
								'params' => array(

									// Custom Date
									array(
										'label'      => array(
											'text' => __( 'Select date', PT_CV_DOMAIN ),
										),
										'params'     => array(
											array(
												'type'  => 'text',
												'name'  => $prefix . 'custom_date',
												'std'   => '',
												'class' => 'datepicker',
											),
										),
										'dependence' => array( $prefix . 'value', 'custom_date' ),
									),

									// Custom Time (From - To)
									array(
										'label'         => array(
											'text' => '',
										),
										'extra_setting' => array(
											'params' => array(
												'wrap-class' => 'form-inline',
												'width'      => 12,
											),
										),
										'params'        => array(
											array(
												'type'   => 'group',
												'params' => array(

													// From
													array(
														'label'  => array(
															'text' => __( 'From', PT_CV_DOMAIN_PRO ),
														),
														'params' => array(
															array(
																'type'  => 'text',
																'name'  => $prefix . 'from',
																'std'   => '',
																'class' => 'datepicker',
															),
														),
													),

													// To
													array(
														'label'  => array(
															'text' => __( 'To', PT_CV_DOMAIN_PRO ),
														),
														'params' => array(
															array(
																'type'  => 'text',
																'name'  => $prefix . 'to',
																'std'   => '',
																'class' => 'datepicker',
															),
														),
													),
												),
											),
										),
										'dependence'    => array( $prefix . 'value', 'custom_time' ),
									),
								),
							),
						),
					),
				),
			);

			return $date;
		}

		/**
		 * Advanced filters by Custom Fields
		 * @return array
		 */
		static function filter_custom_field_settings() {

			$result = array(
				'custom_field' => array(
					array(
						'label'         => array(
							'text' => '',
						),
						'extra_setting' => array(
							'params' => array(
								'wrap-class' => PT_CV_Html::html_group_class(),
								'width'      => 12,
							),
						),
						'params'        => array(
							array(
								'type'   => 'group',
								'params' => array(
									// Custom fields list
									array(
										'label' => array(
											'text' => '',
										),
										'extra_setting' => array(
											'params' => array(
												'wrap-class' => 'form-inline',
												'width'      => 12,
											),
										),
										'params' => array(
											array(
												'type'    => 'html',
												'content' => self::custom_field_settings_header(),
											),
											array(
												'type'    => 'html',
												'content' => self::custom_field_settings_content(),
											),
											array(
												'type'    => 'html',
												'content' => self::custom_field_settings_footer(),
											),
										),
									),

									// Relation of custom fields
									array(
										'label'  => array(
											'text' => __( 'Relation', PT_CV_DOMAIN ),
										),
										'params' => array(
											array(
												'type'    => 'select',
												'name'    => 'ctf-filter-' . 'relation',
												'options' => PT_CV_Values::taxonomy_relation(),
												'std'     => 'OR',
												'class'   => 'ctf-relation',
												'desc'    => __( 'Select AND to show posts which match ALL settings of selected fields<br>Select OR to show posts which match settings of at least one selected field', PT_CV_DOMAIN ),
											),
										),
									),
								),
							),
						),
					),
				),
			);

			return $result;
		}

		/**
		 * Header text for Custom Field filter
		 */
		private static function custom_field_settings_header() {
			ob_start();
			?>
			<div class="table-responsive">
				<table class="table table-bordered-1" id="<?php echo PT_CV_PREFIX; ?>ctf-list">
					<tr>
						<th><?php _e( 'Field key', PT_CV_DOMAIN_PRO ); ?></th>
						<th><?php _e( 'Field type', PT_CV_DOMAIN_PRO ); ?></th>
						<th><?php _e( 'Operator to compare', PT_CV_DOMAIN_PRO ); ?></th>
						<th><?php _e( 'Value to compare', PT_CV_DOMAIN_PRO ); ?></th>
						<th></th>
					</tr>
			<?php
			return ob_get_clean();
		}

		/**
		 * Setting options for a Custom Field
		 * [Field key] [Field type] [Operator] [Value to compare]
		 */
		private static function custom_field_settings_content() {
			// Custom field data type
			$ctf_types = array(
				'CHAR' => 'Text',
				'NUMERIC' => 'Number',
				'DATE' => 'Date',
				'BINARY' => 'True/False',
			);

			// Comparison operator
			$ctf_operator = array(
				'=' => 'Equal ( = )',
				'!=' => 'Differ ( != )',
				'>' => 'Greater ( > )',
				'>=' => 'Greater or Equal ( >= )',
				'<' => 'Less ( < )',
				'<=' => 'Less or Equal ( <= )',
				'LIKE' => 'Like',
				'NOT LIKE' => 'Not Like',
				'IN' => 'In',
				'NOT IN' => 'Not in',
				'BETWEEN' => 'Between',
				'NOT BETWEEN' => 'Not Between',
			);

			$prefix = 'ctf-filter-';

			// Setting options definition
			$setting_options = array(
				'key' => array(
					'type' => 'select',
					'name' => $prefix . 'key[]',
					'options' => PT_CV_Values_Pro::custom_fields(),
					'class' => $prefix . 'key',
				),
				'type' => array(
					'type' => 'select',
					'name' => $prefix . 'type[]',
					'options' => $ctf_types,
				),
				'operator' => array(
					'type' => 'select',
					'name' => $prefix . 'operator[]',
					'options' => $ctf_operator,
				),
				'value' => array(
					'type' => 'text',
					'name' => $prefix . 'value[]',
					'class' => $prefix . 'value',
				),
			);

			// Get saved custom fields
			$saved_ctf = PT_CV_Functions::settings_values_by_prefix( PT_CV_PREFIX . $prefix, true );

			$number_of_fields = isset( $saved_ctf['key'] ) ? count( $saved_ctf['key'] ) : 0;

			$result = array();

			// Start from -1 to show the template row
			for ( $idx = -1; $idx < $number_of_fields; $idx++ ) {
				$options = array();

				foreach ( $setting_options as $key => $settings ) {
					$value = isset( $saved_ctf[$key][$idx] ) ? $saved_ctf[$key][$idx] : '';
					$options[] = sprintf( '<td>%s</td>', PT_Options_Framework::field_type( $settings, array(), $value ) );
				}

				$result[] = balanceTags( sprintf( '<tr class="%s">%s%s</tr>', esc_attr( $idx == -1 ? 'hidden ctf-tpl' : '' ) , implode( '', $options ), sprintf( '<td><a class="%s">x</a></td>', PT_CV_PREFIX . $prefix . 'delete' ) ) );
			}

			return implode( '', $result );
		}

		/**
		 * Footer text for Custom Field filter
		 */
		private static function custom_field_settings_footer() {
			ob_start();
			?>
				</table>

				<a id="<?php echo PT_CV_PREFIX; ?>ctf-filter-add" class="btn btn-small btn-default"><?php _e( 'Add New', PT_CV_DOMAIN_PRO ); ?></a>

				<div style='clear: both'></div><br>

				<div class='text-muted' style='width: 100%;'>
					<div style='margin-bottom: 10px;'><strong><?php _e( 'Value to compare', PT_CV_DOMAIN_PRO ); ?></strong></div>
					<li><?php _e( 'Comma-separated values', PT_CV_DOMAIN_PRO ); ?> (e.g. Lorem,Taxo,Demo) if <strong><?php _e( 'Operator to compare', PT_CV_DOMAIN_PRO ); ?></strong> is 'In', 'Not In', 'Between', 'Not Between'</li>
					<li><?php _e( 'Enter 1 for true or 0 for false', PT_CV_DOMAIN_PRO ); ?> (if <strong><?php _e( 'Field type', PT_CV_DOMAIN_PRO ); ?></strong> is 'True/False')</li>
					<li><?php _e( 'Must not empty', PT_CV_DOMAIN_PRO ); ?></li>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
	}

}
/**
 * Common scripts for Admin
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

( function ($) {
	"use strict";

	$.PT_CV_Admin_Pro = $.PT_CV_Admin_Pro || { };

	$.PT_CV_Admin_Pro = function (options) {
		this.options = options;

		var _prefix = this.options._prefix;

		this._public_trigger();
		this._custom_field();
		this._datepicker();
		this._custom_text_bg_color();
		this._duplicate_view();
		this._custom_trigger();
		this._content_type();
		this._popover();
		this._select2_for_font_families();
		this._toggle_font_styles();
		this._sortable_params();
		// this._toggle_params();
		this._pagination_disable();
		this._term_filter();
		this._filter_constraint();

		// Prevent clicking in filter options
		$('.pt-params .pt-cv-filter-bar a').click(function (e) {
			e.preventDefault();
		});

		// Select 2 - Sortable
		$('.' + _prefix + 'select2-sortable').select2Sortable({bindOrder:'sortableStop'});
	};

	$.PT_CV_Admin_Pro.prototype = {

		/**
		 * Trigger for Preview
		 */
		_public_trigger: function() {
			var _prefix = this.options._prefix;

			var $pt_cv_public_js_pro = new $.PT_CV_Public_Pro({_prefix: _prefix,_autoload: 0});
			// Enable some Pro actions in Preview panel
			$('body').bind(_prefix + 'custom-trigger', function () {
				$pt_cv_public_js_pro.quicksand_filter();
				$pt_cv_public_js_pro.grid_same_height();

				$(window).trigger('load');
			});

			// Handle scrolling in Preview panel
			$('#' + _prefix + 'preview-box').scroll(function(){
				if($(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight())
				{
					var this_ = $('.' + _prefix + 'infinite-load').next('.' + _prefix + 'pagination-wrapper').first().find('.' + _prefix + 'more');
					$pt_cv_public_js_pro._pagination_handle(this_);
				}
			});
		},

		/**
		 * Custom field management
		 * @returns {undefined}
		 */
		_custom_field: function() {
			var _prefix = this.options._prefix;
			var this_prefix = _prefix + 'ctf-filter-';

			var ctf_table = $('#' + _prefix + 'ctf-list');

			// Template HTML of Setting for a field
			var tpl = $('.ctf-tpl');
			$('.ctf-tpl').remove();

			// Enable select2 for existed key
			ctf_table.find('.' + this_prefix + 'key').select2();

			// Add field
			$('#' + this_prefix + 'add').click(function(e){
				e.preventDefault();

				// Append new row of setting to table
				ctf_table.append(tpl.clone().attr('class', ''));

				// Enable select2 for Field Name
				ctf_table.find('.' + this_prefix + 'key').last().select2();

				// Trigger change for 'Field type' to display valid Operator
				ctf_table.find('[name^="' + this_prefix + 'type"]').last().trigger('change');

				// Toggle Relation option
				toggle_relation();

				// Toggle Preview button
				$('body').trigger(_prefix + 'preview-btn-toggle');
			});

			// Delete field
			$('.pt-wrap').on('click', '.' + this_prefix + 'delete', function(e){
				e.preventDefault();

				if (confirm(PT_CV_ADMIN_PRO.message.delete)) {
					$(this).closest('tr').remove();
				}

				// Toggle Relation option
				toggle_relation();

				// Toggle Preview button
				$('body').trigger(_prefix + 'preview-btn-toggle');
			});

			// Toggle Operator base on Type
			$('.pt-wrap').on('change', '[name^="' + this_prefix + 'type"]', function(e){
				var type = $(this).val();

				var $value = $(this).closest('tr').find('[name^="' + this_prefix + 'value"]');
				if (type === 'DATE') {
					$value.datepicker({changeMonth: true,changeYear: true,dateFormat: "mm/dd/yy"});
				} else {
					$value.datepicker('destroy');
				}

				// Get operator selectbox
				var $operator = $(this).closest('tr').find('[name^="' + this_prefix + 'operator"]');
				var $options = $operator.find('option');

				// Hide all options
				$options.hide();

				// Show options for this type
				var $matched = $options.filter(function(){
					return $.inArray( $(this).attr('value'), PT_CV_ADMIN_PRO.custom_field.type_operator[type] ) >= 0;
				});
				$matched.show();

				// Set first option as value of this selectbox
				$operator.val($matched.first().attr('value'));
			});
			$('[name^="' + this_prefix + 'type"]').trigger('change');

			// Show/Hide the relation option
			var toggle_relation = function(){
				// Table of custom fields
				var ctf_list = $('#' + _prefix + 'ctf-list');
				// Number of custom fields
				var ctf_count = ctf_list.find('tr').length - 1;
				// Relation group
				var ctf_relation = $('.' + _prefix + 'ctf-relation').closest('.pt-form-group');

				if (ctf_count > 1) {
					ctf_relation.show();
				} else {
					ctf_relation.hide();
				}
			};
			toggle_relation();
		},

		/**
		 * Show datepicker
		 * @returns {undefined}
		 */
		_datepicker: function () {
			var _prefix = this.options._prefix;

			$('.' + _prefix + 'datepicker').datepicker({changeMonth: true,changeYear: true});
		},

		/**
		 * Custom text for background color
		 * @returns {undefined}
		 */
		_custom_text_bg_color: function () {
			var _prefix = this.options._prefix;

			setTimeout(function () {
				$('.wp-color-result', '.' + _prefix + 'bg-color').attr('title', 'Background Color');
			}, 500);
		},

		/**
		 * Duplicate a View
		 * @returns {undefined}
		 */
		_duplicate_view: function () {
			var _prefix = this.options._prefix;

			// If this is 'duplicate' action
			var patt = /action=duplicate/g;
			if (patt.test(window.location)) {

				$('body').css({opacity: '0.1', cursor: 'progress'});

				// Empty IDs
				$('[name="' + _prefix + 'post-id' + '"]').val(0);
				$('[name="' + _prefix + 'view-id' + '"]').val(0);

				// Append 'Copy' to View Title
				var $view_title = $('[name="' + _prefix + 'view-title' + '"]').get(0);
				var view_title = $($view_title).val();
				if (view_title !== '') {
					$($view_title).val(view_title + ' - Copy');
				}

				// Trigger submit form
				$('#' + _prefix + 'form-view').submit();
			}
		},

		/**
		 * Add custom trigger for functions
		 * @returns {undefined}
		 */
		_custom_trigger: function () {
			var $self = this;
			var _prefix = $self.options._prefix;

			// Toggle Order Advanced Settings box
			var $order_advance_settings = $('#' + _prefix + 'group-order #' + _prefix + 'group-advanced');
			$('.pt-wrap').on('content-type-change', function (e, content_type) {
				if (content_type === 'product') {
					$order_advance_settings.removeClass('hidden');
				} else {
					// Hide Order Advanced Settings box
					$order_advance_settings.addClass('hidden');
				}
			});

			// Toggle Layout format option
			$('.pt-wrap').on('toggle-layout-format', function (e, formats) {
				// Add Timeline layout to the list
				formats.push('timeline');
			});

			// Toggle Shuffle Filter last option (Group options by Taxonomy)
			$('.pt-wrap').on(_prefix + 'multiple-taxonomies', function (e, multiple, onload) {
				// Get last option wrapper
				var $shuffle_type_group = $('.' + _prefix + 'shuffle-filter-type').find('.radio').last();

				if (multiple) {
					// Show last option
					$shuffle_type_group.show();

					// Trigger select last option
					$shuffle_type_group.find('input').attr('checked', true);
					$('[name="' + _prefix + 'taxonomy-filter-type"]').trigger('change', ['trigger']);
				} else {
					// Hide last option
					$shuffle_type_group.hide();

					// Trigger select first option
					if (!onload) {
						$('.' + _prefix + 'shuffle-filter-type').find('.radio').first().find('input').attr('checked', true);
						$('[name="' + _prefix + 'taxonomy-filter-type"]').trigger('change', ['trigger']);
					}
				}
			});
		},

		/**
		 * Custom function for 'Content Type'
		 *
		 * @returns {undefined}
		 */
		_content_type: function () {
			var _prefix = this.options._prefix;

			// Create function to handle
			var fn_content_type = function (this_val) {
				if (typeof this_val === 'undefined') {
					return;
				}

				//  Content type = product
				if (this_val === 'product') {
					// Auto uncheck "Show read more" button
					var $show_read_more = $('[name="' + _prefix + 'field-excerpt-readmore' + '"]');
					$show_read_more.removeAttr('checked');
					$show_read_more.trigger('change');
				}

			};

			// Get "Content Type" input object
			var content_type = '[name="' + _prefix + 'content-type' + '"]';

			// Run on change
			$(content_type).change(function () {
				fn_content_type($(content_type + ':checked').val());
			});
		},

		/**
		 * Show popover
		 *
		 * @returns {undefined}
		 */
		_popover: function () {
			$('.pop-over-trigger').popover({placement: 'bottom', html: true, trigger: 'hover'});
		},

		/**
		 * Enable select2 for font family
		 *
		 * @returns {undefined}
		 */
		_select2_for_font_families: function () {
			var _prefix = this.options._prefix;
			$('select[name*="' + _prefix + 'font-family"]').select2({ dropdownCssClass: _prefix + 'font-family' });
		},

		/**
		 * Toggle font styles when change font family
		 *
		 * @returns {undefined}
		 */
		_toggle_font_styles: function () {
			var _prefix = this.options._prefix;

			// Get json data { name : styles } of fonts
			var $fonts = PT_CV_ADMIN_PRO.fonts.google;
			var $fonts_obj = $.parseJSON($fonts);

			// Toggle font styles when know font name
			var _fn_this_toggle = function (selected_font, this_object) {

				// Get font styles of selected font
				var font_styles = [];
				$.each($fonts_obj, function (name, styles) {
					if (name === selected_font) {
						font_styles = styles;
						return false;
					}
				});

				// Reset font styles if select Default font
				if (selected_font === '') {
					font_styles = [ 'regular', 'italic', '600' ];
				}

				// Add default style to every font families
				font_styles[font_styles.length] = '';

				// Get font styles select box object
				var $font_styles_obj = $(this_object).closest('.pt-form-group').next('.pt-form-group').find('select');

				$font_styles_obj.find('option').each(function () {

					// Show style which the selected font has
					if ($.inArray($(this).val(), font_styles) >= 0) {
						$(this).show();
					} else {
						$(this).hide();
					}
				});
			};

			// Run on page load
			$('select[name*="' + _prefix + 'font-family"]').each(function (e) {
				_fn_this_toggle($(this).val(), this);
			});

			// Run on change
			$('select[name*="' + _prefix + 'font-family"]').on('change', function (e) {
				_fn_this_toggle(e.val, this);
			});
		},

		/**
		 * Allow to sort Fields display, Meta fields
		 *
		 * @returns {undefined}
		 */
		_sortable_params: function () {
			var _prefix = this.options._prefix;

			$('.' + _prefix + 'field-display').sortable({ items: '.form-group:not(.unsortable)', update: function (event, ui) {
				$('body').trigger(_prefix + 'preview-btn-toggle');
			} });
			$('.' + _prefix + 'meta-fields-settings').sortable({ items: '.form-group', update: function (event, ui) {
				$('body').trigger(_prefix + 'preview-btn-toggle');
			} });
		},

		/**
		 * Show/hide Group of settings when click on Label
		 * @returns {undefined}
		 */
		_toggle_params: function () {
			$('.control-label').click(function () {
				$(this).next().toggle();
				$(this).toggleClass('toggle');
			});
		},

		/**
		 * Disable pagination in some cases
		 *
		 * @param string _prefix
		 * @returns {undefined}
		 */
		_pagination_disable: function () {
			var _prefix = this.options._prefix;

			var fn_selector = function (this_val) {
				var pagination_style = '[name="' + _prefix + 'pagination-style' + '"]';

				if (this_val === 'timeline') {
					// Disable other pagination options
					$(pagination_style).attr('checked', false);
					$(pagination_style).attr('disabled', true);

					// Enable Loadmore option
					$(pagination_style + '[value="loadmore"]').attr('disabled', false);
					$(pagination_style + '[value="loadmore"]').attr('checked', true);
				} else {
					$(pagination_style).removeAttr('disabled');
				}
			};

			var selector = '[name="' + _prefix + 'view-type' + '"]';

			// Run on page load
			fn_selector($(selector + ':checked').val());

			// Run on change
			$(selector).change(function () {
				fn_selector($(selector + ':checked').val());
			});
		},

		/**
		 * Auto fill Term In when select Start with, End with
		 *
		 * @returns {undefined}
		 */
		_term_filter: function () {
			var _prefix = this.options._prefix;
			$('select[name^="' + _prefix + 'term_filter' + '"]').change(function () {
				var selected_char = $(this).val();

				var wrapper = $(this).closest('[id^="' + _prefix + 'group-"]');
				// Select box to auto fill options which start with/ end with selected character
				var selectbox = wrapper.find('select').first();

				// Get current filter case: Start with/ End with
				var name = $(this).attr('name');
				var start_with = name.indexOf('start_with') > 0;

				// destroy select2
				selectbox.select2("destroy");

				selectbox.children('option').each(function () {
					var this_text = $(this).text().toLowerCase();

					// Check if current option matches with current filter
					var match = (start_with && this_text.indexOf(selected_char) === 0) || (!start_with && this_text.indexOf(selected_char) === (this_text.length - 1));

					if (match) {
						$(this).attr("selected", true);
					} else {
						$(this).removeAttr("selected");
					}
				});
				// re-init select2
				selectbox.select2();
			});
		},

		/**
		 * Show alert/disable option has constraint with "Shuffle Filter" feature
		 * @returns {undefined}
		 */
		_filter_constraint: function () {

			//--- View type: Only works with "View type" as Grid, Pinterest
			var _prefix = this.options._prefix;

			var fn_enable_disable = function (valid) {
				var $show_read_more = $('[name="' + _prefix + 'enable-taxonomy-filter' + '"]');

				if (valid) {
					// Auto Disable "Enable reorder and filter..." button
					$show_read_more.removeAttr('checked');
					$show_read_more.attr('disabled', true);
					$show_read_more.trigger('change');
				} else {
					// Enable
					$show_read_more.attr('disabled', false);
				}
			};

			// Create function to handle
			var fn_view_type = function (this_val) {
				if (typeof this_val === 'undefined') {
					return;
				}

				var expect_val = [ 'scrollable', 'collapsible', 'timeline' ];

				fn_enable_disable($.inArray(this_val, expect_val) >= 0);
			};

			// Get "Content Type" input object
			var view_type = '[name="' + _prefix + 'view-type' + '"]';

			// Run on page load
			fn_view_type($(view_type + ':checked').val());

			// Run on change
			$(view_type).change(function () {
				fn_view_type($(view_type + ':checked').val());
			});

			//--- Pagination: Only works with "Pagination" is disabled
			// Create function to handle
			var fn_pagination = function (is_check) {
				fn_enable_disable(is_check);
			};

			// Get "Content Type" input object
			var pagination = '[name="' + _prefix + 'enable-pagination' + '"]';

			// Run on page load
			fn_pagination($(pagination).is(':checked'));

			// Run on change
			$(pagination).change(function () {
				fn_pagination($(pagination).is(':checked'));
			});
		}
	};

	$(function () {
		var _prefix = PT_CV_PUBLIC._prefix;

		// Run at page load
		new $.PT_CV_Admin_Pro({_prefix: _prefix});

	});
}(jQuery) );
/**
 * Script Name: Collapsible List
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy (palaceofthemes@gmail.com)
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

( function ($) {
	"use strict";

	$.PT_CV_VT_Scrollable = $.PT_CV_VT_Scrollable || { };

	$.PT_CV_VT_Scrollable = function (options) {
		this.options = options;

		this._toggle_panel(this.options.collapse_box);
	};

	$.PT_CV_VT_Scrollable.prototype = {

		_toggle_panel: function ($selector) {
			var _prefix = this.options._prefix;

			// On show action
			$($selector + ' .panel-collapse').on('shown.bs.collapse', function () {
				$(this).prev().find(".glyphicon").removeClass("glyphicon-plus").addClass("glyphicon-minus");
			});

			// On hide action
			$($selector + ' .panel-collapse').on('hidden.bs.collapse', function () {
				$(this).prev().find(".glyphicon").removeClass("glyphicon-minus").addClass("glyphicon-plus");
			});

			var $collapse_group = $($selector).find('.panel-group').first();

			// Trigger for the first item
			if ($collapse_group.attr('data-first-open') === 'yes') {
				var $first_collapse_box = $($selector).find('.' + _prefix + 'page').length ? $($selector).find('.' + _prefix + 'page').last() : $($selector);

				setTimeout(function(){
					$first_collapse_box.find('.panel-collapse').first().collapse('show');
				}, 500);
			}

			// Multiple-open
			if ($collapse_group.attr('data-multiple-open') === 'yes') {
				$($selector + ' .panel-heading' + ', ' + $selector + ' .panel-heading a').on('click', function () {
					var $heading = $(this).is('a') ? $(this).closest('.panel-heading') : $(this);
					$heading.next().collapse('toggle');
				});
			}
		},
	};

	$(function () {
		var _prefix = PT_CV_PUBLIC._prefix;

		// Run at page load
		new $.PT_CV_VT_Scrollable({ _prefix: _prefix, collapse_box: '.' + _prefix + 'collapsible' });

		$('body').bind(_prefix + 'pagination-finished', function () {
			new $.PT_CV_VT_Scrollable({ _prefix: _prefix, collapse_box: '.' + _prefix + 'collapsible' });
		});
	});
}(jQuery) );
/**
 * Script Name: Pinterest
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy (palaceofthemes@gmail.com)
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

( function ($) {

	$.PT_CV_VT_Pinterest = $.PT_CV_VT_Pinterest || { };

	$.PT_CV_VT_Pinterest = function (options) {
		this.options = options;

		this.layout_render();
	};

	$.PT_CV_VT_Pinterest.prototype = {

		layout_render: function () {
			var _prefix = this.options._prefix;
			var $selector = this.options.container;
			var item = this.options.item;

			var $container = $($selector).find('.' + _prefix + 'page').length ? $($selector).find('.' + _prefix + 'page') : $($selector);
			$container.each(function () {
				var item_per_row = $(this).attr('data-row-item');
				if (item_per_row == false) {
					return;
				}
				var window_width = parseInt($(window).width());
				var width_percentage = 92 / Math.abs( item_per_row );

				$(this).find(item).wookmark({
					container      : $(this),
					autoResize     : true,
					flexibleWidth  : true,
					itemWidth      : ( ( window_width * width_percentage / 100 ) > 240 ) ? width_percentage + '%' : window_width * 0.863,
					offset         : 20,
					align          : 'center',
					onLayoutChanged: function () {
						// Show the Pinterest layout after finish rendering
						$($selector).removeClass(_prefix + 'opacity-hidden');
					}
				});
			});
		}
	};

	// Run when images are loaded
	$(window).load(function () {
		var _prefix = PT_CV_PUBLIC._prefix;

		new $.PT_CV_VT_Pinterest({ _prefix: _prefix, container: '.' + _prefix + 'pinterest', item: '.' + _prefix + 'content-item' });
	});

	$(function () {
		var _prefix = PT_CV_PUBLIC._prefix;

		// Recall when preview/pagination finished
		$('body').bind(_prefix + 'custom-trigger', function () {
			new $.PT_CV_VT_Pinterest({ _prefix: _prefix, container: '.' + _prefix + 'pinterest', item: '.' + _prefix + 'content-item' });
			setTimeout(function(){$(window).trigger('resize');}, 200);
		});

		// Pinterest View which is loaded by Ajax
		$('.' + _prefix + 'pinterest').livequery(function(){
			new $.PT_CV_VT_Pinterest({ _prefix: _prefix, container: $(this), item: '.' + _prefix + 'content-item' });
		});

	});
}(jQuery) );
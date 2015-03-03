/**
 * Main scripts for Front-end
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

( function ($) {
	"use strict";

	$.PT_CV_Public_Pro = $.PT_CV_Public_Pro || { };

	$.PT_CV_Public_Pro = function (options) {
		this.options = $.extend({
			_autoload : 1
		}, options);

		// Autoload all registered functions
		if (this.options._autoload !== 0) {
			this.animation();
			this.pagination();
			this.openin_lightbox();
			this.quicksand_filter();
			this.grid_same_height();
		}
	};

	$.PT_CV_Public_Pro.prototype = {

		/**
		 * Set same height for each type of fields (Title, Content...) across items
		 * @returns {undefined}
		 */
		grid_same_height: function() {
			var _prefix = this.options._prefix;

			var grid_ = '.' + _prefix + 'same-height .pt-cv-row';
			var grid_title = '.' + _prefix + 'title';
			var grid_content = '.' + _prefix + 'content';
			var grid_readmore = '.' + _prefix + 'readmore';

			// Process each Row
			$(grid_).each(function(){
				var $titles = $(this).find(grid_title);
				var $contents = $(this).find(grid_content);

				// Height of Title
				var heights_title = $titles.map(function() {
					return $(this).height();
				}).get(),
				// Height of Content
				heights_content = $contents.map(function() {
					return $(this).height();
				}).get();

				// Get max Height
				var maxHeightTitle = Math.max.apply(null, heights_title),
				maxHeightContent = Math.max.apply(null, heights_content);

				// Set max Height for all fields
				$titles.height(maxHeightTitle);
				$contents.height(maxHeightContent);

				// Stick Readmore button to bottom of Grid
				$(this).find(grid_readmore).css({'position':'absolute','bottom':'0px'});
			});
		},

		/**
		 * Animation actions
		 * @returns {undefined}
		 */
		animation: function() {
			var _prefix = this.options._prefix;

			// Do it when images are loaded
			$(window).load(function(){
				$('.' + _prefix + 'content-hover').each(function(){
					// Get height of the first thumbnail
					var thumb_height = $(this).find('.' + _prefix + 'thumbnail').first().height();

					// Set height for content block
					$(this).find('.' + _prefix + 'content').each(function(){
						$(this).css('height', thumb_height);
					});
				});
			});
		},

		/**
		 * Load more pagination
		 * @returns {undefined}
		 */
		pagination      : function () {
			this._pagination_loadmore();
			this._pagination_infinite();
		},

		/**
		 * Pagination handle
		 */
		_pagination_handle : function(this_) {
			var $self = this;

			// Prevent duplicate processing
			if ($self.doing) {
				return;
			} else {
				$self.doing = 1;
			}

			// Reset status
			var _fn_reset = function() {
				$self.doing = 0;
			};

			// Get next page
			var selected_page = parseInt(this_.attr('data-nextpages'));

			if (!selected_page) {
				_fn_reset();
				return;
			}

			var $pt_cv_public_js = new $.PT_CV_Public();

			$pt_cv_public_js._setup_pagination(this_, selected_page, function () {
				_fn_reset();

				// Update data-nextpages Or hide load more
				var nextpage = selected_page + 1;
				if (nextpage <= parseInt(this_.attr('data-totalpages'))) {
					this_.attr('data-nextpages', nextpage);
				} else {
					this_.remove();
				}
			});
		},

		/**
		 * Loadmore button pagination
		 */
		_pagination_loadmore : function() {
			var $self = this;
			var _prefix = $self.options._prefix;

			// Load more button
			$('body').on('click', '.' + _prefix + 'more', function () {
				var this_ = $(this);

				$self._pagination_handle(this_);
			});
		},

		/**
		 * Infinite loading
		 */
		_pagination_infinite : function() {
			var $self = this;
			var _prefix = $self.options._prefix;

			$(window).scroll(function () {
				if ($self._scrollTo('.' + _prefix + 'pagination-wrapper')) {
					var this_ = $('.' + _prefix + 'infinite-load').next('.' + _prefix + 'pagination-wrapper').find('.' + _prefix + 'more');
					$self._pagination_handle(this_);
				}
			});
		},

		/**
		 * Is scroll to this element
		 */
		_scrollTo : function(elem) {
			if ( $(elem).length === 0 ) {
				return false;
			}

			var docViewTop = $(window).scrollTop();
			var docViewBottom = docViewTop + $(window).height();

			var elemTop = $(elem).offset().top;
			var elemBottom = elemTop + $(elem).height();

			return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
		},

		/**
		 * Lightbox
		 *
		 * @returns {undefined}
		 */
		openin_lightbox : function () {
			var _prefix = this.options._prefix;

			$('body').on('click', '.' + _prefix + 'lightbox', function (e) {
				e.preventDefault();

				var this_ = $(this);

				var width = this_.attr('data-width');
				var height = this_.attr('data-height');
				var content_selector = this_.attr('data-content-selector');

				// If has not set Content selector, get default Lightbox
				if (!content_selector) {
					$(this).colorbox({iframe: true, width: width + "%", height: height + "%"});
				} else {
					// Create/Get custom overlay object
					var overlay_id = _prefix + 'overlay';
					var $overlay = $('#' + overlay_id).length ? $('#' + overlay_id) : $("<div/>", { id: _prefix + 'overlay' }).css({
						background: "#000",
						opacity   : 0.9,
						position  : "fixed",
						width     : "100%",
						height    : "100%",
						left      : 0,
						top       : 0,
						zIndex    : 1000000
					}).appendTo('body');

					// Show custom overlay
					$overlay.show();
					$('body').css('cursor', 'progress');

					// Create/Get object to hold content of post
					var content_id = _prefix + 'lightbox-content';
					var $container = $('#' + content_id).length ? $('#' + content_id) : $("<div/>", { id: content_id }).hide().appendTo('body');

					// Load content of post to $container
					$container.load(this_.attr('href') + ' ' + content_selector, function (response, status, xhr) {
						// Hide custom overlay
						$overlay.hide();
						$('body').css('cursor', 'default');

						if (status !== "error") {
							$(this).colorbox({
								open      : true,
								fixed     : true,
								className : _prefix + 'lightbox-dialog',
								width     : width + "%",
								height    : height + "%",
								html      : $container.html(),
								onComplete: function () {
									$('body').trigger(_prefix + 'lightbox-loaded');
								}
							});
						}
					});
				}
			});
		},
		/**
		 * Script to filter item when click on filter option
		 * @returns {undefined}
		 */
		quicksand_filter: function () {
			var _prefix = this.options._prefix;

			var $filter_bar = $('.' + _prefix + 'filter-bar');
			var $itemsHolder = $filter_bar.next('.' + _prefix + 'view').first();
			if ($itemsHolder.children('.' + _prefix + 'page').length >= 0) {
				$itemsHolder = $itemsHolder.children('.' + _prefix + 'page').first();
			}
			var $itemsClone = $itemsHolder.clone();
			var $filterClass = "";
			var $filterItem = '.' + _prefix + 'content-item';

			// Filter by single Taxonomy
			$('body').off('click', '.' + _prefix + 'filter-option').on('click', '.' + _prefix + 'filter-option', function (e) {
				e.preventDefault();

				var $filters;

				$filterClass = $(this).attr('data-value');
				if ($filterClass === 'all') {
					$filters = $itemsClone.find($filterItem);
				} else {
					$filters = $itemsClone.find($filterItem + '[data-type~=' + $filterClass + ']');
				}

				$itemsHolder.quicksand($filters, { adjustWidth: 'dynamic' });
			});

			// Style handle when click on filter options
			this._quicksand_filter_style(_prefix);

			// Filter by multiple Taxonomies
			$('body').off('click', '.' + _prefix + 'filter-group a').on('click', '.' + _prefix + 'filter-group a', function (e) {
				e.preventDefault();

				// Style handle when click on filter options
				if (!$(this).hasClass('selected')) {
					// Unselect all
					$(this).closest('ul').find('.selected').removeClass('selected');
					// Select this
					$(this).addClass('selected');
				} else {
					return;
				}

				var $filters, $final_filters, $selected_terms = [], $filter_group = $('.' + _prefix + 'filter-group');

				$filter_group.find('.selected').each(function () {
					$filterClass = $(this).attr('data-value');
					if ($filterClass !== 'all') {
						var $matched_items = $itemsClone.find($filterItem + '[data-type~=' + $filterClass + ']');
						if (typeof $filters === 'undefined') {
							$filters = $matched_items;
						} else {
							$filters = $filters.add($matched_items);
						}

						// Add this term to selected group
						$selected_terms.push($filterClass);
					}
				});

				// Get items which has all selected terms
				var length = parseInt($selected_terms.length);

				if (length) {
					$filters.each(function (i, object) {
						var types = $(object).attr('data-type');
						var found = 0;

						$.each($selected_terms, function (j, term) {
							found += (types.indexOf(term) >= 0) ? 1 : 0;
						});

						// If this items contains all selected terms
						if (found === length) {
							if (typeof $final_filters === 'undefined') {
								$final_filters = $(object);
							} else {
								$final_filters = $final_filters.add($(object));
							}
						}
					});
				} else {
					// If no terms selected, get all items
					$final_filters = $itemsClone.find($filterItem);
				}

				$itemsHolder.quicksand($final_filters, { adjustWidth: 'dynamic' });
			});
		},

		/**
		 * Style handle when click on filter options
		 *
		 * @param {type} _prefix
		 * @returns {undefined}
		 */
		_quicksand_filter_style: function (_prefix) {
			// Dropdown filter click
			$('body').on('click', '.' + _prefix + 'filter-bar .dropdown-menu li a', function (e) {
				// Add active class
				$(this).closest('.dropdown-menu').children('.active').removeClass('active');
				$(this).parent().addClass('active');

				// Update Text
				var selText = $(this).text();
				$(this).parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
			});

			// Button filter click
			$('body').on('click', '.' + _prefix + 'filter-bar button', function (e) {
				// Add active class
				$(this).parent().children('.active').removeClass('active');
				$(this).addClass('active');
			});

			// Breadcrumb filter click
			$('body').on('click', '.breadcrumb.' + _prefix + 'filter-bar a', function (e) {
				// Add active class
				$(this).closest('.breadcrumb').children('.active').removeClass('active');
				$(this).parent().addClass('active');
			});
		}
	},

	$(function () {
		var _prefix = PT_CV_PUBLIC._prefix;

		// Run at page load
		var $pt_cv_public_js_pro = new $.PT_CV_Public_Pro({ _prefix: _prefix });

		// Recall when preview/pagination finished
		$('body').bind(_prefix + 'custom-trigger', function () {
			$pt_cv_public_js_pro.grid_same_height();
		});
	});

}(jQuery) );
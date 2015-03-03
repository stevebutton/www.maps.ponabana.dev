<?php
/**
 * HTML output for specific View types
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_Html_ViewType_Pro' ) ) {

	/**
	 * @name PT_CV_Html_ViewType_Pro
	 * @todo List of functions relates to View type output
	 */
	class PT_CV_Html_ViewType_Pro {

		/**
		 * Wrap content of Timeline type
		 *
		 * @param array $content_items The array of Raw HTML output (is not wrapped) of each item
		 * @param int   $current_page  The current page
		 * @param int   $post_per_page The number of posts per page
		 *
		 * @return array Array of HTML of items
		 */
		static function timeline_wrapper( $content_items, $current_page, $post_per_page ) {
			$content = array();

			// The spine
			if ( $current_page === 1 ) {
				$content[] = sprintf( '<div class="%s"><a href="#"></a></div>', 'tl-spine' );
			}

			// Wrap all items (start)
			if ( $current_page === 1 ) {
				$content[] = sprintf( '<div class="%s">', 'tl-items' );
			} else {
				// Seperate pages, and prevent new item displays above existed item
				// $content[] = sprintf( '<div class="%s"></div>', 'tl-items-clear' );
			}

			$idx = 1;

			// Get index of item
			if ( $post_per_page % 2 == 1 ) {
				$idx = ( $current_page % 2 == 0 ) ? 2 : 1;
			}

			foreach ( $content_items as $content_item ) {
				$item_class = 'tl-item ' . ( ( $idx % 2 == 0 ) ? 'pt-right' : 'pt-left' );
				// $item_class .= ( $current_page > 1 ) ? ' tl-new-item' : '';

				$item_html = sprintf( '<div class="%s"><i class="%s"></i><div class="%s">%s</div></div>', 'tl-item-content', 'tl-pointer', PT_CV_PREFIX . 'content-item', $content_item );

				$content[] = sprintf( '<div class="%s">%s</div>', $item_class, $item_html );

				$idx ++;
			}

			// Wrap all items (close)
			if ( $current_page === 1 ) {
				$content[] = '</div>';
			}

			return $content;
		}

	}

}
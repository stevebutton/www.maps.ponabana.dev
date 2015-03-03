<?php
/**
 * WooCommerce related functions
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <palaceofthemes@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

if ( ! class_exists( 'PT_CV_WooCommerce' ) ) {

	/**
	 * @name PT_CV_WooCommerce
	 * @todo Utility functions
	 */
	class PT_CV_WooCommerce {

		/**
		 * Append query parameters to query Woo Products
		 *
		 * @param string $products_list The products list (Recent, best seller, featured... products)
		 *
		 * @return array Array of Append query parameters
		 */
		static function query_parameters( $products_list ) {
			global $woocommerce;

			$parameters = array();

			switch ( $products_list ) {
				// Recent products
				case 'recent_products':

					$parameters = array(
						'orderby' => 'date',
						'order'   => 'desc',
					);

					$meta_query = $woocommerce->query->get_meta_query();

					$parameters['meta_query'] = $meta_query;

					break;

				// Best selling products
				case 'best_selling_products':

					$parameters = array(
						'meta_key'   => 'total_sales',
						'orderby'    => 'meta_value_num',
						'meta_query' => array(
							array(
								'key'     => '_visibility',
								'value'   => array( 'catalog', 'visible' ),
								'compare' => 'IN',
							),
						)
					);

					break;

				// Top rated products
				case 'top_rated_products':

					$parameters = array(
						'meta_query' => array(
							array(
								'key'     => '_visibility',
								'value'   => array( 'catalog', 'visible' ),
								'compare' => 'IN',
							),
						)
					);

					break;

				// Featured products
				case 'featured_products':

					$parameters = array(
						'meta_query' => array(
							array(
								'key'     => '_visibility',
								'value'   => array( 'catalog', 'visible' ),
								'compare' => 'IN',
							),
							array(
								'key'   => '_featured',
								'value' => 'yes',
							),
						)
					);

					break;

				// On sale products
				case 'sale_products':

					break;
			}

			return $parameters;
		}

		/**
		 * woocommerce_order_by_rating_post_clauses function.
		 *
		 * @access public
		 *
		 * @param mixed $args
		 *
		 * @return void
		 */
		static function order_by_rating_post_clauses( $args ) {

			global $wpdb;

			$args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

			$args['join'] .= "
				LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
				LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
			";

			$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

			$args['groupby'] = "$wpdb->posts.ID";

			return $args;
		}
	}

}
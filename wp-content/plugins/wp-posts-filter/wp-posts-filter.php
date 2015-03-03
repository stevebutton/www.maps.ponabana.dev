<?php
/**
 * @package wp-posts-filter
 * @version 0.3.2
 */

/*
 * Plugin name: WP Posts Filter
 * Plugin URI: http://olezhek.net/codez/wp-posts-filter
 * Description: This plugin filters posts by category or tag to list them in the particular page.
 * Author: Oleg Lepeshchenko
 * Version: 0.3.2
 * Author URI: http://olezhek.net/
 * License: GPL2
 */

/* Copyright 2013  Oleg Lepeshchenko  (email: mail@olezhek.net)

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class wp_posts_filter {

	// since version 0.3
	protected static $file_list_mask = '/wppf\-item\-([^\.]+)\.php/i';
	protected static $templates_dir = '';
	protected static $templates_list = array( );
	protected static $date_format = '';
	protected static $default = array( );
	protected static $wppf_opts = null;
	protected static $all_categories = array( );
	protected static $all_tags = array( );
	protected static $default_template = 'default';
	// Placeholders, since version 0.3
	protected static $ph_h_tag = '#heading_tag#';
	protected static $ph_h_class = '#heading_class#';
	protected static $ph_c_tag = '#content_tag#';
	protected static $ph_c_class = '#content_class#';
	protected static $ph_plink = '#permalink#';
	protected static $ph_title = '#post_title#';
	protected static $ph_excerpt = '#post_excerpt#';
	// --- New ones
	protected static $ph_thumb = '#post_thumbnail#';
	protected static $ph_date = '#post_date#';

	public function wppf_init( ) {
		wp_enqueue_script( 'postbox' );
		wp_enqueue_script( 'link' );
		load_plugin_textdomain( 'wp-posts-filter', false, 'wp-posts-filter/languages' );
		self::$date_format = get_option( 'date_format' );
		self::$templates_dir = plugin_dir_path( __FILE__ ) . '/templates';
		self::$default = array( 'posts_per_page' => get_option( 'posts_per_page', 10 ), 'heading_tag' => 'h2', 'heading_class' => 'entry-title', 'content_tag' => 'div', 'content_class' => 'entry-content', 'template' => 'default' );
		self::$wppf_opts = get_option( 'wppf_opts', array( ) );
		self::$all_categories = get_categories( array( 'hide_empty' => 0 ) );
		self::$all_tags = get_tags( array( 'hide_empty' => 0 ) );
	}

	public function wppf_admin_init( ) {
		register_setting( 'wppf-opts', 'wppf_opts' );
		// stores to self::$templates_list
		self::wppf_get_template_list( );
	}

	public function wppf_filter_me( $query ) {
		global $paged;
		$wppf_opts = get_option( 'wppf_opts', array( ) );
		if ( is_array( $wppf_opts ) ) {
			if ( is_home( ) ) {
				if ( isset( $wppf_opts['frontpage'] ) ) {
					$filter_by = isset( $wppf_opts['frontpage']['filterby'] ) ? $wppf_opts['frontpage']['filterby'] : 'none';
					if ( $filter_by == 'cats' || $filter_by == 'both' ) {
						if ( isset( $wppf_opts['frontpage']['cats'] ) ) {
							$query->set( 'cat', implode( ',', $wppf_opts['frontpage']['cats'] ) );
						}
					}
					if ( $filter_by == 'tags' || $filter_by == 'both' ) {
						if ( isset( $wppf_opts['frontpage']['tags'] ) ) {
							$query->set( 'tag__in', $wppf_opts['frontpage']['tags'] );
						}
					}
				}
			}
		}
	}

	public function wppf_js_css( ) {
		wp_register_script( 'wppf_scripts', plugins_url( 'js/scripts.js', __FILE__ ) );
		wp_enqueue_script( 'wppf_scripts' );
		wp_register_style( 'wppf_styles', plugins_url( 'css/style.css', __FILE__ ) );
		wp_enqueue_style( 'wppf_styles' );
	}

	public function wppf_settings_page( ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'wp-posts-filter' ) );
		}
		echo '<div class="wrap">' . PHP_EOL;
		echo '<h2>' . __( 'WP Posts Filter settings', 'wp-posts-filter' ) . '</h2>' . PHP_EOL;
		echo '<form method="POST" action="options.php">' . PHP_EOL;
		settings_fields( 'wppf-opts' );
		echo '<h3>' . __( 'Global settings', 'wp-posts-filter' ) . '</h3>' . PHP_EOL;
		echo '<div class="wppf-fold">';
		echo '<h3>' . __( 'Posts per page', 'wp-posts-filter' ) . '</h3>' . PHP_EOL;
		echo '<div class="wppf-fold">';
		echo self::wppf_input( 'text', array( 'name' => "wppf_opts[posts_per_page]", 'value' => isset( self::$wppf_opts['posts_per_page'] ) ? self::$wppf_opts['posts_per_page'] : self::$default['posts_per_page'], 'size' => 3, ) );
		echo '<br /><small>' . __( 'Works for all pages except for the home page. To customize posts limit for the home page please refer to "Settings" -> "Reading" section', 'wp-posts-filter' ) . '</small><br />' . PHP_EOL;
		echo '</div>' . PHP_EOL;

		// --- Custom date settings
		echo '<h3>' . __( 'Date/time settings', 'wp-posts-filter' ) . '</h3>' . PHP_EOL;
		echo '<div class="wppf-fold">' . PHP_EOL;
		$opts = array( 'name' => "dateformat_sw", 'value' => 1, 'onClick' => 'wppf_toggle("' . 'dateformat")', 'id' => "dateformat_sw", );
		$co = array( 'name' => "wppf_opts[dateformat]", 'id' => "wppf_opts[dateformat]", 'class' => "dateformat wppf-controls" );
		if ( isset( self::$wppf_opts['dateformat'] ) ) {
			$co['value'] = self::$wppf_opts['dateformat'];
			$opts['checked'] = 'checked';
		} else {
			$co['value'] = self::$date_format;
		}
		if ( ! isset( $opts['checked'] ) ) {
			$co['disabled'] = 'disabled';
		}
		echo self::wppf_input( 'checkbox', $opts, __( 'Custom value: ', 'wp-posts-filter' ) );
		echo self::wppf_input( 'text', $co );
		echo '<br /><small>' . __( 'Needed to format the date displayed in post lists', 'wp-posts-filter' ) . '</small>';
		echo '<br /><small>' . __( 'Plugin-wide. Default value is taken from the Settings -> General -> Date format section. Syntax is the same as in WP and PHP date() function', 'wp-posts-filter' ) . '</small><br />' . PHP_EOL;
		echo '</div>' . PHP_EOL;

		// --- tags and styles settings
		$custom_options = array( 'heading_tag' => __( 'Heading tag for the posts on a page:', 'wp-posts-filter' ), 'heading_class' => __( 'Heading class for the posts on a page:', 'wp-posts-filter' ), 'content_tag' => __( 'Content tag for the posts on a page:', 'wp-posts-filter' ), 'content_class' => __( 'Content class for the posts on a page:', 'wp-posts-filter' ), );
		echo '<h3>' . __( 'Tags and styles settings', 'wp-posts-filter' ) . '</h3>' . PHP_EOL;
		echo '<div class="wppf-fold">' . PHP_EOL;
		echo '<small>' . __( 'You can set up custom styles and tags for every page you have. To perform this please refer to the page settings below', 'wp-posts-filter' ) . '</small>' . PHP_EOL;
		echo '<h4>' . __( 'Post list global template', 'wp-posts-filter' ) . '</h4>' . PHP_EOL;
		foreach ( self::$templates_list as $key => $value ) {
			$templates[$key] = $key;
		}
		self::$default['templates_list'] = $templates;
		$templates_control = array( 'name' => 'wppf_opts[template]', 'id' => 'wppf_opts[template]', 'size' => '1', 'class' => 'wppf-controls', 'selected' => isset( self::$wppf_opts['template'] ) ? self::$wppf_opts['template'] : self::$default['template'], );
		echo self::wppf_input( 'select', $templates_control, '', $templates );
		echo '<br /><small>' . __( 'Works for all pages except for the home page', 'wp-posts-filter' ) . '</small>' . '<br />' . PHP_EOL;
		foreach ( $custom_options as $custom_opt => $title ) {
			echo '<h4>' . $title . '</h4>' . PHP_EOL;
			echo self::wppf_input( 'text', array( 'name' => "wppf_opts[$custom_opt]", 'value' => isset( self::$wppf_opts[$custom_opt] ) ? self::$wppf_opts[$custom_opt] : self::$default[$custom_opt], 'class' => 'wppf-controls', ) );
			// echo '<span class="wppf-to-be-obsolete-soon">' . (isset( self::$wppf_opts[$custom_opt] ) ? self::$wppf_opts[$custom_opt] : 'None set') . '</span>';
		}
		echo '</div>' . PHP_EOL;

		echo '</div><br /><br />' . PHP_EOL;
		echo '<h3>' . __( 'Pages: ', 'wp-posts-filter' ) . '</h3>' . PHP_EOL;
		echo '<div class="wppf-fold">' . PHP_EOL;

		$allowed_cats = array( );
		$pages = get_pages( );

		echo '<div id="poststuff" class="wppf-metabox-holder">';
		add_meta_box( 'wppf_box_frontpage', __( 'Home page', 'wp-posts-filter' ) . ' <span class="postbox-title-action">[<a style="edit-box open-box" target="_blank" href="' . site_url( ) . '">' . __( 'Link', 'wp-posts-filter' ) . '</a>]</span>', array( 'wp_posts_filter', 'wppf_metabox' ), null, 'advanced', 'default', array( 'page' => 'frontpage', ) );
		foreach ( $pages as $page ) {
			add_meta_box( "wppf_box_{$page->ID}", $page->post_title . ' <span class="postbox-title-action">[<a style="edit-box open-box" target="_blank" href="' . get_page_link( $page->ID ) . '">' . __( 'Link', 'wp-posts-filter' ) . '</a>]</span>', array( 'wp_posts_filter', 'wppf_metabox' ), null, 'advanced', 'default', array( 'page' => $page->ID, ) );
		}
		do_meta_boxes( null, 'advanced', null );
		echo '</div>';
		echo '</div>' . PHP_EOL;

		echo '<div id="wppf-save-button-placeholder" align="center">' . PHP_EOL;
		if ( (float) get_bloginfo( 'version' ) >= 3.1 ) {
			submit_button( );
		} else {
			self::wppf_legacy_submit_button( );
		}
		echo '</div>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		echo '</div>' . PHP_EOL;
	}

	private function wppf_get( $what, $all, $allowed, $page = 'frontpage' ) {
		$result = '';
		$doNotCheck = true;
		if ( count( $allowed ) > 0 ) {
			$doNotCheck = false;
		}
		if ( $what == 'cats' ) {
			$title = __( 'Show pages from categories:', 'wp-posts-filter' );
		} else if ( $what == 'tags' ) {
			$title = __( 'Show pages containing tags:', 'wp-posts-filter' );
		}
		$result .= '<h4>' . $title . '</h4>' . PHP_EOL;
		$result .= '<div class="wppf-fold">' . PHP_EOL;
		$result .= '<fieldset>' . PHP_EOL;
		$checkall_opts = array( 'name' => "wppf_{$what}_{$page}_checkall", 'class' => 'checkall', );
		if ( self::wppf_check_if_all( $all, $allowed ) ) {
			$checkall_opts['checked'] = 'checked';
		}
		$result .= self::wppf_input( 'checkbox', $checkall_opts, __( 'Check all', 'wp-posts-filter' ) );
		$cnt = count( $all );
		$cols = 1;
		if ( $cnt <= 8 ) {
			$cols = 2;
		} else if ( $cnt <= 30 ) {
			$cols = 3;
		} else if ( $cnt <= 100 ) {
			$cols = 4;
		} else if ( $cnt <= 200 ) {
			$cols = 5;
		} else if ( $cnt <= 300 ) {
			$cols = 8;
		} else {
			$cols = 10;
		}
		$col_capacity = ceil( $cnt / $cols );
		$result .= '<table style="margin-left:10px;">' . PHP_EOL;
		for ( $i = 0; $i < $col_capacity; $i++ ) {
			$result .= '<tr>' . PHP_EOL;
			for ( $j = 0; $j < $cols; $j++ ) {
				$index = $j * $col_capacity + $i;
				if ( isset( $all[$index] ) ) {
					$val = $what == 'cats' ? $all[$index]->cat_ID : $all[$index]->term_id;
					$opts = array( 'name' => "wppf_opts[$page][$what][]", 'id' => "wppf_opts_{$page}_{$what}_{$val}", 'value' => $val, 'onClick' => "wppf_uncheck_check_all(\"wppf_opts_{$page}_{$what}_{$val}\")", 'class' => 'wppf_opts_checkboxes', );
					if ( ! $doNotCheck ) {
						if ( in_array( $val, $allowed ) ) {
							$opts['checked'] = 'checked';
						}
					}
					$result .= '<td>' . self::wppf_input( 'checkbox', $opts, $all[$index]->name ) . '</td>' . PHP_EOL;
				}
			}
			$result .= '</tr>' . PHP_EOL;
		}
		$result .= '</table>' . PHP_EOL;
		$result .= '</fieldset>' . PHP_EOL;
		$result .= '</div>' . PHP_EOL;
		return $result;
	}

	/**
	 * Checks whether all items are checked or not. Used for "Check all" checkbox
	 */
	private function wppf_check_if_all( $all, $allowed ) {
		$a = array( );
		foreach ( $all as $item ) {
			if ( isset( $item->cat_ID ) ) {
				$a[] = $item->cat_ID;
			} else if ( isset( $item->term_id ) ) {
				$a[] = $item->term_id;
			}
		}
		return count( array_diff( $a, $allowed ) ) != 0 ? false : true;
	}

	private function wppf_label( $text, $opts = array() ) {
		$opts_string = '';
		if ( is_array( $opts ) ) {
			foreach ( $opts as $name => $value ) {
				$opts_string .= " $name='$value'";
			}
		} else {
			return '';
		}
		return "<label$opts_string>$text</label>" . PHP_EOL;
	}

	private function wppf_input( $type, $params = array(), $text = '', $opts = array() ) {
		$result = '';
		$params_string = '';
		if ( is_array( $params ) ) {
			foreach ( $params as $name => $value ) {
				if ( $name != 'selected' ) {
					$params_string .= " $name='$value'";
				}
			}
		} else {
			return '';
		}
		$result = "<input type='$type' $params_string /> ";
		if ( $type == 'checkbox' || $type == 'radio' ) {
			if ( $text == 'cats' ) {
				$result .= __( 'Categories', 'wp-posts-filter' );
			} else if ( $text == 'tags' ) {
				$result .= __( 'Tags', 'wp-posts-filter' );
			} else if ( $text == 'both' ) {
				$result .= __( 'Both categories and tags', 'wp-posts-filter' );
			} else if ( $text == 'none' ) {
				$result .= __( 'None', 'wp-posts-filter' );
			} else {
				$result .= $text;
			}
		} else if ( $type == 'select' ) {
			$result = "<select $params_string>" . PHP_EOL;
			if ( count( $opts ) > 0 ) {
				foreach ( $opts as $opt_value => $opt_text ) {
					$o = '';
					if ( isset( $params['selected'] ) && $params['selected'] == $opt_value ) {
						$o = "selected='selected'";
					}
					$result .= "<option value='{$opt_value}' {$o}>{$opt_text}</option>" . PHP_EOL;
				}
			} else {
				$result .= "<option value='-1'>-- None --</option>" . PHP_EOL;
			}
			$result .= '</select>';
		}
		$result .= PHP_EOL;
		return $result;
	}

	private function wppf_filterby_block( $page, $selected = 'none', $set = array('tags', 'cats', 'both', 'none') ) {
		$result = '';
		foreach ( $set as $item ) {
			$params = array( 'name' => "wppf_opts[$page][filterby]", 'value' => $item, );
			if ( $selected == $item ) {
				$params['checked'] = 'checked';
			}
			$result .= self::wppf_input( 'radio', $params, $item );
			$result .= '<br />' . PHP_EOL;
		}
		return $result;
	}

	public function wppf_settings_menu( ) {
		add_options_page( __( 'WP Posts Filter Settings', 'wp-posts-filter' ), __( 'WP Posts Filter', 'wp-posts-filter' ), 'manage_options', 'wp-posts-filter', array( 'wp_posts_filter', 'wppf_settings_page' ) );
	}

	/**
	 * Replacement for get_previous_posts_link() WP function
	 */
	private function wppf_get_previous_posts_link( $label = null ) {
		global $paged;

		if ( null === $label )
			$label = __( '&laquo; Previous Page', 'wp-posts-filter' );

		if ( $paged > 1 ) {
			$attr = apply_filters( 'previous_posts_link_attributes', '' );
			return '<a href="' . self::wppf_previous_posts( false ) . "\" $attr>" . preg_replace( '/&([^#])(?![a-z]{1,8};)/', '&#038;$1', $label ) . '</a>';
		}
	}

	/**
	 * Replacement for previous_posts() WP function
	 */
	private function wppf_previous_posts( $echo = true ) {
		$output = esc_url( self::wppf_get_previous_posts_page_link( ) );

		if ( $echo )
			echo $output;
		else
			return $output;
	}

	/**
	 * Replacement for get_previous_posts_page_link() WP function.
	 *
	 */
	private function wppf_get_previous_posts_page_link( ) {
		global $paged;
		$nextpage = intval( $paged ) - 1;
		if ( $nextpage < 1 )
			$nextpage = 1;
		return get_pagenum_link( $nextpage );
	}

	/**
	 * Replacement for get_next_posts_link() WP function
	 * @param string $label
	 * @param int $max_num_pages - $wp_query->max_num_pages. The total number of pages. Is the result of $found_posts / $posts_per_page (WP_Query)
	 * @param int $max_page
	 */
	private function wppf_get_next_posts_link( $label = null, $max_num_pages, $max_page = 0 ) {
		global $paged;

		if ( ! $max_page )
			$max_page = $max_num_pages;

		if ( ! $paged )
			$paged = 1;

		$nextpage = intval( $paged ) + 1;

		if ( null === $label )
			$label = __( 'Next Page &raquo;', 'wp-posts-filter' );

		if ( $nextpage <= $max_page ) {
			$attr = apply_filters( 'next_posts_link_attributes', '' );
			return '<a href="' . self::wppf_next_posts( $max_page, false ) . "\" $attr>" . preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label ) . '</a>';
		}
	}

	/**
	 * Replacement for next_posts() WP function
	 */
	private function wppf_next_posts( $max_page = 0, $echo = true ) {
		$output = esc_url( self::wppf_get_next_posts_page_link( $max_page ) );
		if ( $echo )
			echo $output;
		else
			return $output;
	}

	/**
	 * Replacement for get_next_posts_page_link() WP function
	 */
	private function wppf_get_next_posts_page_link( $max_page = 0 ) {
		global $paged;
		if ( ! $paged )
			$paged = 1;
		$nextpage = intval( $paged ) + 1;
		if ( ! $max_page || $max_page >= $nextpage )
			return get_pagenum_link( $nextpage );
	}

	/**
	 * [wppf] shortcode
	 */
	public function wppf_shortcode( $atts ) {
		global $post, $paged;
		if ( self::$templates_dir == '' ) {
			self::$templates_dir = plugin_dir_path( __FILE__ ) . '/templates';
		}
		$result = '';
		$wppf_opts = get_option( 'wppf_opts', array( ) );
		$params = array( );
		if ( isset( $wppf_opts[$post->ID]['filterby'] ) ) {
			// --- Setup post template
			$post_template = 'default';
			if ( isset( $wppf_opts[$post->ID]['template'] ) ) {
				$post_template = $wppf_opts[$post->ID]['template'];
			} else if ( isset( $wppf_opts['template'] ) ) {
				$post_template = $wppf_opts['template'];
			}

			// --- Setup date format
			if ( isset( $wppf_opts[$post->ID]['dateformat'] ) ) {
				$date_format = $wppf_opts[$post->ID]['dateformat'];
			} else if ( isset( $wppf_opts['dateformat'] ) ) {
				$date_format = $wppf_opts['dateformat'];
			} else {
				$date_format = self::$date_format;
			}
			// --- Setup query
			if ( isset( $wppf_opts[$post->ID]['posts_per_page'] ) ) {
				$params['posts_per_page'] = $wppf_opts[$post->ID]['posts_per_page'];
			} else if ( isset( $wppf_opts['posts_per_page'] ) ) {
				$params['posts_per_page'] = $wppf_opts['posts_per_page'];
			} else {
				$params['posts_per_page'] = get_option( 'posts_per_page', 10 );
			}
			extract( shortcode_atts( array( 'heading_tag' => $wppf_opts['heading_tag'], 'heading_class' => $wppf_opts['heading_class'], 'content_tag' => $wppf_opts['content_tag'], 'content_class' => $wppf_opts['content_class'], 'per_page' => $params['posts_per_page'], 'date_format' => $date_format, 'post_template_sc' => $post_template ), $atts ) );
			if ( $wppf_opts[$post->ID]['filterby'] == 'cats' || $wppf_opts[$post->ID]['filterby'] == 'both' ) {
				if ( isset( $wppf_opts[$post->ID]['cats'] ) ) {
					$params['cat'] = implode( ',', $wppf_opts[$post->ID]['cats'] );
				}
			}
			if ( $wppf_opts[$post->ID]['filterby'] == 'tags' || $wppf_opts[$post->ID]['filterby'] == 'both' ) {
				if ( isset( $wppf_opts[$post->ID]['tags'] ) ) {
					$params['tag__in'] = implode( ',', $wppf_opts[$post->ID]['tags'] );
				}
			}
			$params['paged'] = $paged;
			$filtered_posts = new WP_Query( $params );
			if ( count( $filtered_posts->posts ) > 0 ) {
				if ( file_exists( self::$templates_dir . '/wppf-item-' . $post_template_sc . '.php' ) ) {
					// Shortcode setting
					$template_file_path = self::$templates_dir . '/wppf-item-' . $post_template_sc . '.php';
				} else if ( file_exists( self::$templates_dir . '/wppf-item-' . $post_template . '.php' ) ) {
					// Fall-back to the setting from the DB
					$template_file_path = self::$templates_dir . '/wppf-item-' . $post_template . '.php';
				} else if ( file_exists( self::$templates_dir . '/wppf-item-' . self::$default_template . '.php' ) ) {
					// Fall-back to the default setting
					$template_file_path = self::$templates_dir . '/wppf-item-' . self::$default_template . '.php';
				} else {
					// Plugin installation corrupted
					return '<h2>' . __( "Oops! Can't find either one of the templates set or the default template for the page. Looks like your WP Posts Filter installation has been damaged! Please check either the plugin installation or templates folder", 'wp-posts-filter' ) . '</h2>';
				}
				include_once $template_file_path;
				foreach ( $filtered_posts->posts as $entry ) {
					$item = str_replace( self::$ph_h_tag, $heading_tag, $item_template );
					$item = str_replace( self::$ph_h_class, $heading_class, $item );
					$item = str_replace( self::$ph_c_tag, $content_tag, $item );
					$item = str_replace( self::$ph_c_class, $content_class, $item );
					$permalink = get_permalink( $entry->ID );
					$item = str_replace( self::$ph_plink, $permalink, $item );
					$item = str_replace( self::$ph_date, self::wppf_format_post_date( $date_format, $entry->post_date ), $item );
					$ex = $entry->post_excerpt;
					if ( post_password_required( $entry->ID ) ) {
						$ex = __( 'There is no excerpt because this is a protected post.' );
					}
					if ( empty( $ex ) ) {
						$ex = self::wppf_trim_excerpt( $entry->post_content );
					}
					// If the post title is empty
					// if (empty($entry->post_title)) {
					// $entry->post_title = $permalink;
					// }
					$item = str_replace( self::$ph_excerpt, $ex, $item );
					// TODO: $thumbnail_size and $thumbnail_attributes
					if ( isset( $thumbnail_size ) ) {
						if ( isset( $thumbnail_attributes ) ) {
							$item = str_replace( self::$ph_thumb, get_the_post_thumbnail( $entry->ID, $thumbnail_size, $thumbnail_attributes ), $item );
						} else {
							$item = str_replace( self::$ph_thumb, get_the_post_thumbnail( $entry->ID, $thumbnail_size ), $item );
						}
					} else {
						if ( isset( $thumbnail_attributes ) ) {
							$item = str_replace( self::$ph_thumb, get_the_post_thumbnail( $entry->ID, 'post-thumbnail', $thumbnail_attributes ), $item );
						} else {
							$item = str_replace( self::$ph_thumb, get_the_post_thumbnail( $entry->ID, 'post-thumbnail' ), $item );
						}
					}
					$result .= str_replace( self::$ph_title, $entry->post_title, $item );

				}
				$pages = ceil( $filtered_posts->found_posts / $params['posts_per_page'] );
				if ( $pages > 1 ) {
					$nav = '<div class="navigation">' . PHP_EOL;
					$nav .= '<div class="nav-previous">' . self::wppf_get_previous_posts_link( __( '&laquo; Previous Page', 'wp-posts-filter' ) ) . '</div>';
					$nav .= '<div class="nav-next">' . self::wppf_get_next_posts_link( __( 'Next Page &raquo;', 'wp-posts-filter' ), $pages ) . '</div>';
					$nav .= '</div>' . PHP_EOL;
					$result .= $nav;
				}
			}
		}
		return $result;
	}

	public function wppf_metabox( $post, $metabox ) {
		echo '<h4>' . __( 'Filter by:', 'wp-posts-filter' ) . '</h4>' . PHP_EOL;
		echo self::wppf_filterby_block( $metabox['args']['page'], isset( self::$wppf_opts[$metabox['args']['page']]['filterby'] ) ? self::$wppf_opts[$metabox['args']['page']]['filterby'] : 'none' );
		// --- Custom option for posts_per_page
		if ( $metabox['args']['page'] != 'frontpage' ) {
			echo '<h4>' . __( 'Maximum posts per this page:', 'wp-posts-filter' ) . '</h4>' . PHP_EOL;
			echo '<div class="wppf-fold">' . PHP_EOL;
			$opts = array( 'name' => $metabox['args']['page'] . '_posts_per_page_sw', 'value' => 1, 'onClick' => 'wppf_toggle("' . $metabox['args']['page'] . '_posts_per_page")', 'id' => $metabox['args']['page'] . '_posts_per_page_sw', );
			$co = array( 'name' => "wppf_opts[{$metabox['args']['page']}][posts_per_page]", 'size' => 3, 'class' => $metabox['args']['page'] . '_posts_per_page', );
			if ( isset( self::$wppf_opts[$metabox['args']['page']]['posts_per_page'] ) ) {
				$co['value'] = self::$wppf_opts[$metabox['args']['page']]['posts_per_page'];
				$opts['checked'] = 'checked';
			} else {
				$co['value'] = self::$default['posts_per_page'];
			}
			if ( ! isset( $opts['checked'] ) ) {
				$co['disabled'] = 'disabled';
			}
			echo self::wppf_input( 'checkbox', $opts, __( 'Custom value: ', 'wp-posts-filter' ) );
			echo self::wppf_input( 'text', $co );
			echo '</div>' . PHP_EOL;
		}

		echo self::wppf_get( 'tags', self::$all_tags, self::$wppf_opts[$metabox['args']['page']]['tags'] != null ? self::$wppf_opts[$metabox['args']['page']]['tags'] : array( ), $metabox['args']['page'] );
		echo self::wppf_get( 'cats', self::$all_categories, self::$wppf_opts[$metabox['args']['page']]['cats'] != null ? self::$wppf_opts[$metabox['args']['page']]['cats'] : array( ), $metabox['args']['page'] );
		if ( $metabox['args']['page'] != 'frontpage' ) {
			// --- Custom template
			echo '<h4>' . __( 'Post list template', 'wp-posts-filter' ) . ':</h4>' . PHP_EOL;
			echo '<div class="wppf-fold">' . PHP_EOL;
			$opts = array( 'name' => $metabox['args']['page'] . "_template_sw", 'value' => 1, 'onClick' => 'wppf_toggle("' . $metabox['args']['page'] . '_template")', 'id' => $metabox['args']['page'] . "_template_sw", );
			$co = array( 'name' => "wppf_opts[{$metabox['args']['page']}][template]", 'id' => "wppf_opts[{$metabox['args']['page']}][template]", 'class' => $metabox['args']['page'] . "_template wppf-controls", 'size' => '1' );
			if ( isset( self::$wppf_opts[$metabox['args']['page']]['template'] ) ) {
				$co['value'] = self::$wppf_opts[$metabox['args']['page']]['template'];
				$opts['checked'] = 'checked';
			} else if ( isset( self::$wppf_opts['template'] ) ) {
				$co['value'] = self::$wppf_opts['template'];
			} else {
				$co['value'] = self::$default['template'];
			}
			if ( ! isset( $opts['checked'] ) ) {
				$co['disabled'] = 'disabled';
			}
			$co['selected'] = isset( self::$wppf_opts[$metabox['args']['page']]['template'] ) ? self::$wppf_opts[$metabox['args']['page']]['template'] : self::$default['template'];
			echo self::wppf_input( 'checkbox', $opts, __( 'Custom value: ', 'wp-posts-filter' ) );
			echo self::wppf_input( 'select', $co, '', self::$default['templates_list'] );
			echo '</div>';

			// --- Custom date settings
			echo '<h4>' . __( 'Date/time settings for the page', 'wp-posts-filter' ) . ':</h4>' . PHP_EOL;
			echo '<div class="wppf-fold">' . PHP_EOL;
			$opts = array( 'name' => $metabox['args']['page'] . "_dateformat_sw", 'value' => 1, 'onClick' => 'wppf_toggle("' . $metabox['args']['page'] . '_dateformat")', 'id' => $metabox['args']['page'] . "_dateformat_sw", );
			$co = array( 'name' => "wppf_opts[{$metabox['args']['page']}][dateformat]", 'id' => "wppf_opts[{$metabox['args']['page']}][dateformat]", 'class' => $metabox['args']['page'] . "_dateformat wppf-controls" );
			if ( isset( self::$wppf_opts[$metabox['args']['page']]['dateformat'] ) ) {
				$co['value'] = self::$wppf_opts[$metabox['args']['page']]['dateformat'];
				$opts['checked'] = 'checked';
			} else if ( isset( self::$wppf_opts['dateformat'] ) ) {
				$co['value'] = self::$wppf_opts['dateformat'];
			} else {
				$co['value'] = self::$date_format;
			}
			if ( ! isset( $opts['checked'] ) ) {
				$co['disabled'] = 'disabled';
			}
			echo self::wppf_input( 'checkbox', $opts, __( 'Custom value: ', 'wp-posts-filter' ) );
			echo self::wppf_input( 'text', $co );
			echo '</div>';

			// --- Custom options for heading and contents tags and styles
			$custom_options = array( 'heading_tag' => __( 'Heading tag for the posts on this page', 'wp-posts-filter' ), 'heading_class' => __( 'Heading class for the posts on this page', 'wp-posts-filter' ), 'content_tag' => __( 'Content tag for the posts on this page', 'wp-posts-filter' ), 'content_class' => __( 'Content class for the posts on this page', 'wp-posts-filter' ), );
			foreach ( $custom_options as $custom_opt => $title ) {
				echo '<h4>' . $title . ':</h4>' . PHP_EOL;
				echo '<div class="wppf-fold">' . PHP_EOL;
				$opts = array( 'name' => $metabox['args']['page'] . "_{$custom_opt}_sw", 'value' => 1, 'onClick' => 'wppf_toggle("' . $metabox['args']['page'] . '_' . $custom_opt . '")', 'id' => $metabox['args']['page'] . "_{$custom_opt}_sw", );
				$co = array( 'name' => "wppf_opts[{$metabox['args']['page']}][{$custom_opt}]", 'class' => $metabox['args']['page'] . "_{$custom_opt} wppf-controls", );
				if ( isset( self::$wppf_opts[$metabox['args']['page']][$custom_opt] ) ) {
					$co['value'] = self::$wppf_opts[$metabox['args']['page']][$custom_opt];
					$opts['checked'] = 'checked';
				} else if ( isset( self::$wppf_opts[$custom_opt] ) ) {
					$co['value'] = self::$wppf_opts[$custom_opt];
				} else {
					$co['value'] = self::$default[$custom_opt];
				}
				echo self::wppf_input( 'checkbox', $opts, __( 'Custom value: ', 'wp-posts-filter' ) );
				if ( ! isset( $opts['checked'] ) ) {
					$co['disabled'] = 'disabled';
				}
				// echo self::wppf_input( 'checkbox', $opts, __( 'Custom value: ', 'wp-posts-filter' ) );
				echo self::wppf_input( 'text', $co );
				// echo '<span class="to-be-obsolete-soon">' . $co['value'] . '</span>';
				echo '</div>' . PHP_EOL;
			}
		}
	}

	public function wppf_uninstall( ) {
		delete_option( 'wppf_opts' );
	}

	protected function wppf_get_template_list( ) {
		$items = scandir( self::$templates_dir );
		self::$templates_list = self::wppf_cleanup_file_list( $items );

	}

	/**
	 * Sorts out files whose names match the rule defined
	 */
	protected function wppf_cleanup_file_list( $items = array() ) {
		$matches = array( );
		$result = array( );
		foreach ( $items as $item ) {
			if ( preg_match( self::$file_list_mask, $item, $matches ) ) {
				$result[$matches[1]] = $matches[0];

			}
		}
		return $result;
	}

	/**
	 * outputs default submit button for the form. Works for WP ver. 3.0 only. Starting from ver.3.1
	 * submit_button() is used
	 */
	protected function wppf_legacy_submit_button( ) {
		echo '<p class="submit">' . PHP_EOL;
		echo '<input type="submit" name="submit" id="submit" class="button button-primary" value="' . __( 'Save Changes', 'wp-posts-filter' ) . '"  />' . PHP_EOL;
		echo '</p>' . PHP_EOL;
	}

	/**
	 * Based on wp_trim_excerpt() of WordPress, which is not working when called outside the Loop
	 *
	 */
	protected function wppf_trim_excerpt( $contents ) {
		if ( ! empty( $contents ) ) {
			$contents = strip_shortcodes( $contents );
			// $contents = apply_filters('the_content', $contents);
			$contents = str_replace( ']]>', ']]&gt;', $contents );
			$excerpt_length = apply_filters( 'excerpt_length', 55 );
			$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
			$contents = wp_trim_words( $contents, $excerpt_length, $excerpt_more );
		}
		return $contents;
	}

	/**
	 *
	 * Prints formatted post date
	 * Based on WP get_the_date()
	 */
	protected function wppf_format_post_date( $date_format = '', $post_date ) {
		if ( $date_format == '' ) {
			$date_format = get_option( 'date_format' );
		}
		return mysql2date( $date_format, $post_date );
	}

}

add_action( 'admin_menu', array( 'wp_posts_filter', 'wppf_settings_menu' ) );
add_action( 'admin_enqueue_scripts', array( 'wp_posts_filter', 'wppf_js_css' ) );
add_action( 'admin_init', array( 'wp_posts_filter', 'wppf_admin_init' ) );
add_action( 'pre_get_posts', array( 'wp_posts_filter', 'wppf_filter_me' ) );
add_shortcode( 'wppf', array( 'wp_posts_filter', 'wppf_shortcode' ) );
add_action( 'init', array( 'wp_posts_filter', 'wppf_init' ) );
register_uninstall_hook( __FILE__, array( 'wp_posts_filter', 'wppf_uninstall' ) );
?>
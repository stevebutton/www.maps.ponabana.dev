<?php
/**
 * Layout Name: Timeline
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy (palaceofthemes@gmail.com)
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

$html = array();

$layout = $dargs['layout-format'];

// Prevent the case: there are 2 columns but have not setting for thumbnail position
if ( $layout == '2-col' && ! isset( $dargs['field-settings']['thumbnail'] ) ) {
	$layout = '1-col';
}
?>

	<div class="<?php echo esc_attr( PT_CV_PREFIX . 'tl-content' ); ?>">
		<div class="<?php echo esc_attr( PT_CV_PREFIX . 'tl-avatar' ); ?>">
			<?php
			// Get Meta fields
			$meta_fields = isset( $fields_html['meta-fields'] ) ? $fields_html['meta-fields'] : array();

			// Author
			$author = isset( $meta_fields['author'] ) ? $meta_fields['author'] : '';
			echo balanceTags( $author );
			?>
			<div class="<?php echo esc_attr( PT_CV_PREFIX . 'tl-heading' ); ?>">
				<?php
				// Tile
				$title = isset( $fields_html['title'] ) ? $fields_html['title'] : '';
				echo balanceTags( $title );

				// Date
				$date = isset( $meta_fields['date'] ) ? $meta_fields['date'] : '';
				if ( ! empty( $date ) ) {
					$date = strip_tags( $date );
					printf( '<p>%s</p>', human_time_diff( strtotime( $date ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', PT_CV_DOMAIN_PRO ) );
				}
				?>
			</div>

		</div>
		<?php
		$content = isset( $fields_html['content'] ) ? $fields_html['content'] : '';
		$thumbnail = isset( $fields_html['thumbnail'] ) ? $fields_html['thumbnail'] : '';

		if ( ! empty ( $content ) || ! empty( $thumbnail ) ) {
			switch ( $layout ) {
				case '1-col':
					$fields_name   = array_keys( $fields_html );
					$content_idx   = array_search( 'content', $fields_name );
					$thumbnail_idx = array_search( 'thumbnail', $fields_name );

					$html[$thumbnail_idx] = $thumbnail;
					$html[$content_idx]   = $content;

					// Sort by keys, to show in right order
					ksort( $html );

					break;
				case '2-col':
					$html[] = $thumbnail;
					$html[] = $content;

					break;
			}

			echo balanceTags( implode( "\n", $html ) );
		}
		?>
	</div>
<?php
// Unset author, date in array
unset( $meta_fields['author'] );
unset( $meta_fields['date'] );

// Join other meta fields
echo balanceTags( PT_CV_Html::_field_meta_wrap( $meta_fields, '' ) );
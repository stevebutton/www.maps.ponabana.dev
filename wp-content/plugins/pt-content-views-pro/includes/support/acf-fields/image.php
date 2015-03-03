<?php
/*
 * Customized display (Object)
 */
$image = $value;

// vars
$url = $image['url'];
$title = $image['title'];
$alt = $image['alt'];
$caption = $image['caption'];

// thumbnail
$size = 'thumbnail';
$thumb = $image['sizes'][ $size ];
$width = $image['sizes'][ $size . '-width' ];
$height = $image['sizes'][ $size . '-height' ];

if( $caption ): ?>

	<div class="wp-caption">

<?php endif; ?>

<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />

<?php if( $caption ): ?>

		<p class="wp-caption-text"><?php echo $caption; ?></p>

	</div>

<?php endif; ?>
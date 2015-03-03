<?php 
// Post heading
$item_template = '<#heading_tag# class="#heading_class#">
    <a href="#permalink#" title="#post_title#">#post_title#</a>
</#heading_tag#>';

// Post excerpt
$item_template .= '<div class="wppf-post-wrapper">';
$item_template .= '<div class="wppf-post-thumbnail-wrapper">#post_thumbnail#</div><#content_tag# class="#content_class#" style="float: right;">#post_excerpt#</#content_tag#>';
$item_template .= '</div>';

?>

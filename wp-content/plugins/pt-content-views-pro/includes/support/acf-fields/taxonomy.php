<?php
/*
 * Basic display (multiple values) - Modified
 */
$terms = $value;
?>

<ul>

<?php foreach( $terms as $term ): ?>
	<li>
		<h2><?php echo $term->name; ?></h2>
		<p><?php echo $term->description; ?></p>
	</li>
<?php endforeach; ?>

</ul>
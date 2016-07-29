<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
$path = current_path();
$color = 'c6';
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php if($path==='production'){ 
$color = 'c2';
?>
<div class='container'>
<?php }else{ ?>
<div id='location-grid-wrapper' class='c3 bg bdr'>	
<?php } ?>
<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
	<div class='spacer'></div>
		<div class='inner <?php print $color; ?> bg'>
			<div class='c7 text'>
			<?php print $row; ?>
			</div>
		</div>
</div>
<?php endforeach; ?>
<div class='clearfix'></div>

</div>


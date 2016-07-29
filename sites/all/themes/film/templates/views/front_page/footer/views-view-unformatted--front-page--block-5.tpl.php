<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
<div class='clearfix'></div>
<div class='grid-16 attribution'>
	<div class='inner'>
		&#169; Innovate Limerick 2016 | Website design and build by <a href='http://openpoint.ie' target='_blank'>Openpoint</a>
	</div>
</div>

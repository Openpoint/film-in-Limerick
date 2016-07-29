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
	<div class='info_row_wrap c2 bdr'>
		<div class='container'>
			<?php print $row; ?>
			<div class='clearfix'></div>
		</div>
	</div>
  </div>
<?php endforeach; ?>

<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php if (!empty($title)): ?>
	<?php
	
	switch($title){
		case 'Location':
			$class='location c1 bg search_section';
			$class2='grid-4 widget c2 bdr w100 search-widget w100';
			$color='c2';
			$title = 'Locations';
			break;
		case 'Company':
			$class='business c2 bg search_section';
			$class2='grid-4 widget c6 bdr w100 search-widget w100';
			$color='c6';
			$title = 'Businesses';
			break;
		case 'People or Groups':
			$class='person c3 bg search_section';
			$class2='grid-4 widget c6 bdr w100 search-widget w100';
			$color='c6';
			$title = 'People';
			break;
			
		case 'Physical item':
			$class='person c4 bg search_section';
			$class2='grid-4 widget c6 bdr w100 search-widget w100';
			$color='c6';
			$title = 'Things';
			break;
	}
	?>
	<div class='<?php print $class; ?>'>
	<div class='container'>
	<div class='grid-16'><h1 class='c7 text'><?php print $title; ?></h1></div>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
	<div class='<?php print $class2; ?>'>
		<div class='spacer'></div>
		<div class='inner'>
			<?php 
			$row = str_replace('title font2 semibold padded c2 bg','title font2 semibold padded '.$color.' bg',$row);
			$row = str_replace('[col]',$color.' bg',$row);
			?>
			<?php print $row; ?>
		</div>
	</div>
<?php endforeach; ?>
<?php if (!empty($title)): ?>
	<div class='clearfix'></div>
	</div>
	</div>
<?php endif; ?>

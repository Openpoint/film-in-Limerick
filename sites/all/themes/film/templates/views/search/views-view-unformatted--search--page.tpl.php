<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
if(user_has_role(4) || user_has_role(3) || user_has_role(6) || $title === 'node:location'){
	$access = true;
}else{
	$access = false;
}

?>
<?php if (!empty($title)): ?>
	<?php 
	switch($title){
		case 'node:location':
			$class='location c1 bg search_section';
			$class2='grid-4 widget c2 bdr text w100 search-widget w100';
			$color='c2';
			$title = 'Locations';
			break;
		case 'node:business':
			$class='business c2 bg search_section';
			$class2='grid-4 widget c6 bdr text w100 search-widget w100';
			$color='c6';
			$title = 'Businesses';
			break;
		case 'node:person':
			$class='person c3 bg search_section';
			$class2='grid-4 widget c6 bdr text w100 search-widget w100';
			$color='c6';
			$title = 'People';
			break;
			
		case 'node:physical_item':
			$class='person c4 bg search_section';
			$class2='grid-4 widget c6 bdr text w100 search-widget w100';
			$color='c6';
			$title = 'Things';
			break;
	}
	?>
	<?php if($access){ ?>
		<div class='<?php print $class; ?>'>
		<div class='container'>
		<div class='grid-16'><h1 class='c7 text'><?php print $title; ?></h1></div>
	<?php } ?>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
	<?php if(strlen($row) > 0){ ?>
		<div class='<?php print $class2; ?>'>
			<div class='spacer'></div>
			<div class='inner'>
				<?php 
				$row = str_replace('title font2 semibold padded c2 bg','title font2 semibold padded '.$color.' bg',$row);
				$row = str_replace('[color]',$color.' bg',$row);
				?>
				<?php print $row; ?>
			</div>
		</div>
	<?php } ?>
<?php endforeach; ?>
<?php if (!empty($title) && $access): ?>
	<div class='clearfix'></div>
	</div>
	</div>
<?php endif; ?>

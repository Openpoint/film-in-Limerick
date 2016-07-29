<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */

$block = module_invoke('views', 'block_view', '-exp-search-page');

?>
<div id='triptych'>
	<div class='container'>
		<div id='search_bar' class='front_search'><?php print render($block['content']); ?></div>
		<div id='trip_wrap'>
			<div class='grid-trip first c7 text bdr'>
				<div class='mask'></div>
				<div class='button'>
					<h2 class='font2 bold'>Locations</h2>
					<div class='font1'>to explore</div>
					<a href='/locations'></a>
				</div>
			</div>
			<div class='grid-trip middle c7 text bdr'>
				<div class='mask'></div>
				<div class='button'>
					<h2 class='font2 bold'>Production</h2>
					<div class='font1'>resources to find</div>
					<a href='/production'></a>
				</div>
			</div>
			<div class='grid-trip last c7 text bdr'>
				<div class='mask'></div>
				<div class='button'>
					<h2 class='font2 bold'>Shot</h2>
					<div class='font1'>in Limerick</div>
					<a href='/shot'></a>
				</div>
			</div>
		</div>
	</div>
</div>

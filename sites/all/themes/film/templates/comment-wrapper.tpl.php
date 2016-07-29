<?php

/**
 * @file
 * Ideal Comments theme implementation to provide an HTML container for comments.
 *
 * Available variables:
 * - $content: The array of content-related elements for the node. Use
 *   render($content) to print them all, or
 *   print a subset such as render($content['comment_form']).
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default value has the following:
 *   - comment-wrapper: The current template type, i.e., "theming hook".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT
 *   - COMMENT_MODE_THREADED
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_comment_wrapper()
 * @see theme_comment_wrapper()
 */
?>
<div id="comments" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if ($content['comments'] && $node->type != 'forum'): ?>
    <?php print render($title_prefix); ?>
    <h2 class="title font1 semibold c1 text bdr"><?php print t('Editorial correspondence'); ?></h2>
    <?php print render($title_suffix); ?>
	<?php print render($correspondent); ?>	
  <?php endif; ?>
  <div class='c1 bdr text'>
	<div class='inner_wrap'>
	<?php print render($content['comments']); ?>
	</div>
  </div>
  <?php if ($content['comment_form']): ?>
	<div class='c2 bg' id='comment_this_form'>
		<div class='container c7 text bdr'>
			<div class='grid-16'>
				<?php if(!$content['comments']['#children']): print render($correspondent); endif; ?>
				<h2 class='font1 bold'>Start a new editorial subject</h2>
				<?php print render($content['comment_form']); ?>
			</div>
			<div class='clearfix'></div>
			
		</div>
		
    </div>
  <?php endif; ?>
</div>

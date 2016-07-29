<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */

global $user;

$viewable = true;
$login = false;
$destination = drupal_get_destination()['destination'];

if($user->uid == 0 && ($destination === 'user' || $destination === 'user/password' || $destination === 'user/register')){
	$login = true;
}
if (isset($node)) {
	if ($node->status) {
		$published = 'published';
	}else {
		$published = 'unpublished';
		//set the unpublished message
		if(user_has_role(3) || user_has_role(4)){
			$published_message = 'This content is not published.<br>Publish it from the tab at the bottom of the page.';
		}else if(user_has_role(7)){
			$published_message = 'This content is not published.<br>Publish it from the tab at the bottom of the page.<br><br>Once published an editor will be notified to review and approve it. You cannot unpublish, so be sure that all information is correct.';
		}else{
			$published_message = 'This content is not published.<br>You will be able to publish it when your account is approved.';
		}
		
	}
	
	if (isset($node->field_approved)) {
		if (!$node->field_approved['und'][0]['value']) {
			$viewable  = false;
			if($published === 'published'){
				$published = 'awaiting approval';
			}
		}
		if ($node->uid === $user->uid) {
			$viewable = true;
		}
		if (in_array("administrator", $user->roles) || in_array("editor", $user->roles)) {
			$viewable = true;
		}
	}
	
	//set the comment access
	$page['content']['system_main']['nodes'][$node->nid]['comments']['#access']=false;
	if (($node->uid === $user->uid) && $node->status) {
		$page['content']['system_main']['nodes'][$node->nid]['comments']['#access']=true;
	}
	if ((in_array("administrator", $user->roles) || in_array("editor", $user->roles)) && $node->status) {
		$page['content']['system_main']['nodes'][$node->nid]['comments']['#access']=true;
	}

} 


?>
<?php if ($page['menu_editor']) { ?>
	<div id = 'menu_editor' class='c6 bg shadow'>
		
			<div class='grid-12 c7 text'>
			<?php print render($page['menu_editor']);?>
			</div>
			<div class='grid-4 editor_left c7 text'>
				<ul>
					<li><a href='/user'><?php print $user->name; ?></a></li>
					<li><a href='/user/logout'>logout</a></li>
				</ul>
			</div>
			<div class='clearfix'></div>
		
	</div>
<?php  } //$page['menu_editor'] ?>
	<div id = 'menu'>
		<div id='m_spacer' class='c5 bg'></div>
	<?php if ($logo && !$is_front) { ?>
		<div id='home' class='leftlink w100'>
			<a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
				<img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
			</a>
		</div>
	<?php } else if ($is_front) { ?>
		<div id='limerick' class='leftlink'>
			<?php if ($page['menu_left']) { print render($page['menu_left']); } ?>
		</div>
	<?php } ?>
	<?php if (!$is_front){?>
		<div id='menu_mid' class='container c1 text'>
			<div class='grid-16'>
			<?php	if ($main_menu) {
				print theme('links__system_main_menu', array(
					'links' => $main_menu,
					'attributes' => array(
						'id' => 'main-menu',
						'class' => array(
							'links',
							'inline',
							'clearfix'
						)
					)
				));
			} ?>
			</div>
			<div class='clearfix'></div>
		</div>
	<?php } ?>
		<?php if ($page['menu_right']) { print render($page['menu_right']); } ?>
	</div>
	
<?php if (!$is_front) { ?>
	<div id = 'search_bar' class='c1 bg'>
	<?php if ($page['menu_search']) { ?>
		<div class='container'>
			<div class='grid-16'>
				<?php print render($page['menu_search']);?>
			</div>
			<div class='clearfix'></div>
		</div>
	<?php } ?>
	</div>
<?php } ?>
	<div id = 'mid_wrap' class='<?php if (isset($published)){ print $published; } ?>'>
	
	<?php if ($viewable) { ?>
		<?php if(isset($published_message)){ ?>
			<div id='published_message'>
				<div class='container c1 text font1 semibold'>
					<div class='grid-6 prefix-5'>
						<?php print $published_message; ?>
					</div>
				</div>
				<div class='clearfix'></div>
			</div>
		<?php }?>		
		<?php if ($page['featured']) { ?>
			<?php if ($messages){ ?>
		<div class='c1 bg message_wrapper'>
			<div class='container'>
				<div class='grid-16'>
				<?php print $messages; ?>
				</div>
				<div class='clearfix'></div>
			</div>
		</div>
			<?php } ?>

		<div id='featured'> 
			<?php print render($page['featured']); ?>
			<div class='clearfix'></div>
		</div>
		<?php } ?>

		<div id='content' class='<?php if ($title !== 'Search' && $title !=='Bookmarks'){ print ' container'; }?>'>
		<?php if (!$page['featured']) { ?>
			<?php if ($messages){ ?>
			<div class='c1 bg message_wrapper'>
				<div class='container'>
					<div class='grid-16'>
					<?php print $messages; ?>
					</div>
					<div class='clearfix'></div>
				</div>
			</div>
			<?php } ?>		
		<?php } ?>
		<?php if ($page['content']) {
			print render($title_prefix);
			if (isset($node) && $title && $title !== 'Search' && $title !=='Bookmarks') { ?>
				<div class='grid-16'>
					<?php if(isset($published) && $published === 'published' && ($node->type === 'location' || $node->type === 'business' || $node->type === 'person' || $node->type === 'physical_item') && $user->uid != 0){
						$bookmark = flag_create_link("bookmark_item", $node->nid);
					}else{
						$bookmark = false;
					} 
					?>
					<h1 class="title c1 text bdr font1 bold" id="page-title">
						<span class='ttext grid-14 alpha'><?php print $title; 
						if (isset($published) && $published === 'awaiting approval') {?> (Pending Approval) <?php } ?>
						</span>
						<span class='bookmark font1 normal grid-2 omega'><?php if($bookmark){ print $bookmark; } ?></span>
						<span class='clearfix'></span>
					</h1>
				</div>
				<div class='clearfix'></div>
			<?php } ?>
			<?php print render($title_suffix); ?>
			<?php if ($title === 'Search' ||  $title ==='Bookmarks'){ 
				$attrb = "id='search_wrapper'";
			}else{ 					 
				if ($page['sidebar'] || $page['sidebar_widgets'] || $page['sidebar_bottom']) {
					$attrb = "id='main-col' class='grid-10 suffix-1'";
				} else { 
					$attrb = "id='main-col' class='grid-16'";
				}
			} ?>
			<div <?php print $attrb; ?>>
				<?php print render($page['help']); ?>
				<?php if ($action_links){ ?>
					<ul class="action-links">
						<?php print render($action_links); ?>
					</ul>
				<?php } ?>
				<?php if ($tabs && $login){ ?>
				<div id="login_tabs" class='grid-8 prefix-4 c1 bdr text'>
					<?php print render($tabs); ?>
				</div>
				<div class='clearfix'></div>
				<?php } ?>
				<?php print render($page['content']);?> 
			</div> 
		<?php } ?>
		<?php if ($page['sidebar'] || $page['sidebar_widgets'] || $page['sidebar_bottom']) { ?>
			<div id='sidebar' class='grid-5'>
			<?php if ($page['sidebar']){
				print render($page['sidebar']);
			} ?>
			<?php if ($page['sidebar_widgets']){ ?> 
				<div id='sidbar_widgets' class='widget_stretch_wrapper equal_height'>
					<?php print render($page['sidebar_widgets']); ?>
					<div class='clearfix'></div>
				</div> 
			<?php } ?> 
			<?php if ($page['sidebar_bottom']){ ?>
				<div id='sidebar_bottom'> 
					<?php print render($page['sidebar_bottom']); ?>
				</div>
			<?php } ?>
			</div>
		<?php } ?>
			<div class='clearfix'></div>
		</div>

		<?php if ($page['wide_bottom2']) { ?>
		<div id='wide_bottom2'>
			<?php print render($page['wide_bottom2']); ?>
			<div class='clearfix'></div>
		</div>
		<?php } ?>
		<?php if ($page['wide_bottom']) { ?>
		<div id='wide_bottom'>
			<?php print render($page['wide_bottom']); ?>
			<div class='clearfix'></div>
		</div>
		<?php } ?>
		<?php if ($page['wide_map']) { ?>
		<div id='wide_map'>
			<?php print render($page['wide_map']); ?>
			<div class='clearfix'></div>
		</div>
		<?php } ?>
	<?php }else{ ?>
		<div class='container'>
			<div class='grid-16'>
				<h1 class='c1 text font2 bold'>"<?php print $title; ?>" is awaiting approval</h1>
			</div>
			<div class='clearfix'></div>
		</div>

	<?php } ?>
	</div>
	
	<div id='footer' class='c6 bg'>
		<?php if ($page['footer']) {
		print render($page['footer']);
		}?>
	</div>
	<?php if (gettype($tabs['#primary'])==='array' && !$login){ ?>
	<div id="tabs">
		<?php print render($tabs); ?>
	</div>
	<?php } ?>

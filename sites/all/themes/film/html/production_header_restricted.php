<?php 
//global $user;
//dpm($user);
if(!user_has_role(3) && !user_has_role(6) && !user_has_role(4)):
?>
<div class='container'>
	<div id='context_menu' class='grid-3'></div>
	<div class='grid-8 prefix-1 suffix-4'>
		
		<div id='category_lead' class='c1 text font1 semibold'>
			<h1 class='c1 text font2 bold'><a href='/production'>Production</a></h1>
			<div class='inner'>From crew to car hire and from stylists to caterers <br>– let us put you in touch with the right people.<br><br>Contact us for access to the registry.</div>
		</div>

		<div class='clearfix'></div>
		<?php 
		require_once drupal_get_path('module', 'contact') .'/contact.pages.inc';
		$form = drupal_get_form('contact_site_form');
		?>
		<div id='contact_form' class='c1 bdr text'>
			<?php print render($form); ?>
		</div> 
		<div class='clearfix'></div>
	</div>
	<div class='clearfix'></div>
	<?php if(!user_has_role(2)): ?>
	<div class='action_call font2 bold c1 bdr text'>
		<div class='spacer'></div>
		<div class='inner'>
			<a href='/user/register'><span>Register</span></a>
		</div>
	</div>
	
	<?php endif ?>
</div>
<?php endif; ?>

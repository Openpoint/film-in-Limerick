<?php global $user;
$user = user_load($user->uid);
$flag = flag_get_user_flags('user');
dpm($flag);
print flag_create_link('user_help', $user->uid);
if(!isset($flag['user_help'])){
?>
<div id='user_welcome' class='c1 bdr'>
	<h2 class='c1 text'>Welcome to Film in Limerick</h2>
	<div class='user_instructions'>
		<p class='c1 text'>Please note that approvals and correspondence may take some days depending on our editorial workload.</p>
		<p>From the menu at the top of your page you can add the content you are interested in:</p>
		<ul>
		<li>A new location <strong>(+location)</strong></li>
		<li>A new production or cast person <strong>(+person)</strong></li>
		<li>A new production business <strong>(+business)</strong></li>
		<li>A new production item <strong>(+item)</strong></li>
		</ul>
		<p>Use the tabs at the bottom of a page to perform actions such as publishing or editing.</p>
		<p>After you have published your item, an editor will review it and you will be notified of approval or any further actions required by email.</p>
		<p>After publishing your item, you can communicate with an editor using the form below your content.</p>
	</div>
</div>
<?php } ?>

<?php global $user; ?>
<p class='grid-10 prefix-3'>Film in Limerick invites you to add your locations, business or personal profile to our registry. Be seen and be found in the industry.</p>
<div class="action_call font2 bold c7 bdr text">
	<div class="spacer"></div>
	<div class="inner">
		<?php if($user->uid == 0){?>
		<a href="/user/register"><span>Register</span></a>
		<?php }else{ ?>
		<a href="/user"><span>My account</span></a>
		<?php } ?>
	</div>
</div>

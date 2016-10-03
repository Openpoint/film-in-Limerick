<?php
global $user;
?>
<div class='container'>
	<div class='grid-16'>
                
		<div id='category_lead' class='grid-6 prefix-5 c1 text font1 semibold'>
                        <h1 class='c1 text font2 bold'><a href='/locations'>Locations</a></h1>
			<div class='inner'>From dramatic, windswept coastline to urban culture, the region has it all. Explore a world of different location options here...</div>
		</div>
		<?php if($user->uid == 0){ ?>
		<div class='action_call font2 bold c1 bdr text'>
			<div class='spacer'></div>
			<div class='inner'>
				<a href='/user/register'><span>Submit a location</span></a>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class='clearfix'></div>
</div>

<?php
$destination = drupal_get_destination();
$parameters=array();
$link = rules_link_render('clear_bookmarks', 0, $destination['destination'], $parameters);
?>
<div class='c1 bg search-header'>
	<div class='container'>
		<div class='grid-16 c7 text font2 bold'>
			<h1>Bookmarks</h1>
		</div>		
		<div class='grid-16 xls_download'>
			<span class='inner c7 bdr text button download'>
				<a rel="nofollow" href='/bookmarks-xls'>Download</a>
				<span class="material-icons">&#xE2C4;</span>
			</span>
			<?php if($link){ ?>
			<span class='inner c7 bdr text button'>
				<?php print "<a rel='nofollow' href='".$link['#href']."?destination=".$destination['destination']."'>".$link['#title']."</a>"; ?>
				<span class="material-icons">&#xE5CD;</span>
			</span>
			<?php } ?>
		</div>

		<div class='clearfix'></div>
	</div>
</div>

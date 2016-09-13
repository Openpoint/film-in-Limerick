<?php 
$nodes = node_load_multiple(array(), array('type' => 'production_info'));
function cmp($a, $b) {
    if ($a->field_weight['und'][0]['value'] == $b->field_weight['und'][0]['value']) {
        return 0;
    }
    return ($a->field_weight['und'][0]['value'] < $b->field_weight['und'][0]['value']) ? -1 : 1;
}
uasort($nodes, 'cmp');
global $user;


?>
<div id='menu_right'>
	<div class='info c6 text item'>
		<div class='label'>About</div>
		<div>
			<a class="material-icons icon ope">&#xE88F;</a>
			<a class="material-icons icon close c1 text">&#xE5CD;</a>
		</div>
	</div>
	<div class='bookmarks c6 text item'>
		<a class="material-icons icon">&#xE866;</a>
		<div class='count c7 text font1 bold'></div>
		<a class='trigger' href='/bookmarks'></a>
	</div>
	<div class='menu c6 text item'>
		
		<div>	
			<a class="material-icons icon ope">&#xE5D2;</a>
			<a class="material-icons icon close c1 text">&#xE5CD;</a>
		</div>
		<div class='label'>menu</div>
	</div>
</div>
<div id='main_menu_right' class='c6 bdr'>
	<div class='m_inner c5 bg'>
		<div class='container'>
			<div class='grid-16'>
				<div class='grid-5'>
					<?php if(drupal_is_front_page()){ ?>
					<div id='tempmen'>
						<a class='fronttop c1 text font1 semibold' href='/locations'>Locations</a>
						<a class='fronttop c1 text font1 semibold' href='/production'>Production</a>
						<a class='fronttop c1 text font1 semibold' href='/shot'>Filmed</a>
					</div>
					<?php } ?>
					<h2 class='c6 text font1 semibold'>Resources</h2>
					<ul>
					<?php foreach($nodes as $nid=>$node){ ?>
						<li class='c6 text'><a href='/production#prd<?php print $nid; ?>'><?php print render($node->title);?></a></li>
					<?php } ?>
					</ul>
					<h2 class='c6 text font1 semibold'>Legal</h2>
					<ul class="legal">
						<li class='c6 text'><a href="/terms">Terms and Conditions</a></li>
						<li class='c6 text'><a href="/cookies">Cookie Policy</a></li>
					</ul>
				</div>
				<div class='grid-6 login'>
						<div class="action_call font2 bold c6 bdr text">
							<div class="spacer"></div>
							<div class="inner">
								<a href="/user" class="film-processed"><span>Login</span></a>
							</div>
						</div>					
						<div class="action_call font2 bold c6 bdr text">
							<div class="spacer"></div>
							<div class="inner">
								<a href="/user/register" class="film-processed"><span>Register</span></a>
							</div>
						</div>					
					<?php /*if($login){
						print render($login); ?>
						<div class='forgot c6 bg'><a class='c7 text' href='/user/password'>I forgot</a></div>
					
						<div class="action_call font2 bold c6 bdr text">
							<div class="spacer"></div>
							<div class="inner">
								<a href="/user/register" class="film-processed" style='margin-top:10px;'>Register</a>
							</div>
						</div>
					<?php }else if($location === 'production' && $user->uid == 0){ ?>
						<div class="action_call font2 bold c6 bdr text">
							<div class="spacer"></div>
							<div class="inner">
								<a href="/user" class="film-processed" style='margin-top:10px;'>Login</a>
							</div>
						</div>						
					<?php } */ ?>
				</div>
				<div class='grid-5 limerick'>
					<div class='w100 llogo'><a href='http://limerick.ie' target='_blank'>Limerick.ie</a></div>
					<ul>
						<li class='c6 text'><a href="http://www.limerick.ie/living" target='_blank'>Discover</a></li>
						<li class='c6 text'><a href="http://www.limerick.ie/business" target='_blank'>Business</a></li>
						<li class='c6 text'><a href="http://www.limerick.ie/council" target='_blank'>Council</a></li>						
					</ul>
				</div>
				<div class='clearfix'></div>
			</div>
			<div class='clearfix'></div>
		</div>
	</div>
</div>
<div id='main_info_right' class='c6 bdr'>
	<div class='m_inner c5 bg'>
		<div class='container'>
			<div class='grid-16'>
				<div class='grid-7 suffix-1'>
					<p>Film in Limerick is a joint venture between Limerick City and County Council and Innovate Limerick. Our goal is to facilitate the growing film and TV production industry in the region by providing a service to find locations and production resources.</p>
				</div>
				<div class='grid-7 prefix-1'>
					<p>We are actively engaged with professionals and the public at large to gather information and resources, curate it and present a reliable information resource.</p>
					<p>If you have information you would like to include, please register an account and submit it to us.</p>
					<div class="action_call font2 bold c6 bdr text">
						<div class="spacer"></div>
						<div class="inner">
							<a href="/user/register" class="film-processed"><span>Register</span></a>
						</div>
					</div>
					
				</div>
				<div class='clearfix'></div>
			</div>
			<div class='clearfix'></div>
		</div>
	</div>
</div>

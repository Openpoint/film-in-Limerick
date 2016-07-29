<?php
global $user;

//add external CDN fonts
function film_preprocess_html(&$variables) {
  drupal_add_css('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800', array('type' => 'external'));
  drupal_add_css('https://fonts.googleapis.com/css?family=Dosis:500,600,700,800', array('type' => 'external'));
  drupal_add_css('https://fonts.googleapis.com/icon?family=Material+Icons', array('type' => 'external'));
}

//modify the head to be html5 compliant
function film_html_head_alter(&$head_elements) {
	unset($head_elements['system_meta_content_type']['#attributes']['http-equiv']);
	unset($head_elements['system_meta_content_type']['#attributes']['content']);
	$head_elements['system_meta_content_type']['#attributes']['charset'] = 'utf8';
}


function makeLink($link){
	global $base_url;	
	$path = $base_url.'/'.$link['#href'].'?destination='.$link['#options']['query'];
	$newlink = array(
		'#active'=>FALSE,
		'#theme'=>'menu_local_task',
		'#link'=>array(
			'href'=>$path,
			'title'=>$link['#rules_link']->label,
			'localized_options'=>array(),
			'weight'=>'10',
			
		),
	);
	return $newlink;	
}
// Add rules links as primary tabs for nodes
function film_menu_local_tasks(&$variables){
	
	$node = menu_get_object();
		
	if($node && $node->status){
		$destination = drupal_get_destination();
		$parameters=array();
		$link_approve = rules_link_render('approve', $node->nid, $destination['destination'], $parameters);
		$link_revoke = rules_link_render('revoke', $node->nid, $destination['destination'], $parameters);

		if($link_approve){
			$newlink = makeLink($link_approve);
			array_splice($variables['primary'], 3, 0, array($newlink));			
		}
		if($link_revoke){
			$newlink = makeLink($link_revoke);
			array_splice($variables['primary'], 3, 0, array($newlink));			
		}
	
	}else{
		$destination = drupal_get_destination()['destination'];
		global $user;
		if($user->uid == 0 && ($destination === 'user' || $destination === 'user/password' || $destination === 'user/register')){
			$variables['primary'][0]['#link']['title']=t('Register');
			$variables['primary'][2]['#link']['title']=t('Password Reset');
		}
		
	}
	return theme_menu_local_tasks($variables);	
}

//Add the 'corresponding to' feature on comments
function film_preprocess_comment_wrapper(&$variables) {	
	global $user;
	$this_user=user_load($user->uid);
	$node = menu_get_object();
	$owner = user_load($node->uid);
	
    if(in_array("editor", $user->roles) || in_array("administrator", $user->roles)){
		if($node->uid !== $user->uid){
			if($owner->field_user_picture){
				$image=image_style_url('user_image', $owner->field_user_picture['und'][0]['uri']);
			}else{
				$image='/'.path_to_theme().'/images/avatar.png';
			}
			
			$owner_name = "<a href='/user/".$owner->uid."'>".$owner->field_first_name['und'][0]['value']." ".$owner->field_last_name['und'][0]['value']."</a>";
			$variables['correspondent'] = "
			<div id='correspondent' class='c1 bdr'>
				<div class='corresponding_to font1 semibold'>Hello ".$this_user->field_first_name['und'][0]['value'].", you are corresponding with:</div>
				<div class='w100 avatar c1 bdr bg'>
					<div class='spacer'></div>
					<a href='/user/".$owner->uid."'><img src='".$image."' /></a>
				</div>
				<div class='details'>
					<div class='owner_name c1 text font1 semibold'>".$owner_name."</div>
					<div class='c6 text owner_det'>Tel: ".$owner->field_telephone['und'][0]['safe_value']."</div>
					<div class='c6 text owner_det'><a href='mailto:".$owner->mail."'>".$owner->mail."</a></div>
				</div>
				<div class='clearfix'></div>
			</div>
			";
		}else{
			$variables['correspondent'] = "
			<div id='correspondent' class='c1 bdr'>
				<div class='corresponding_to font1 semibold'>Hello ".$this_user->field_first_name['und'][0]['value'].", you own this post.</div>
			</div>
			";
		}			
	}else{
		$variables['correspondent'] = NULL;
	}
}

function film_comment_load($comments) {
	dpm($comments);
}

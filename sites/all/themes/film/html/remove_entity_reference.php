<?php
/*
 * Custom functionality included into rules for removing entity references (hack because 'remove from list' not working)
 * */
 
 
$entity;

function remove($ent,$ref){
	
	global $entity;
	$entity = $ent;
	switch($entity->type){
		case 'location':
			go('field_located_under_approval',$ref);						
			break;
		case 'business':
			go('field_asocciated_approval',$ref);
			go('field_works_with_approval',$ref);
			go('field_managed_by_approval',$ref);
			go('field_item_owner_approval',$ref);
			break;
	}

	
	
	
	return $entity;

}

function go($type,$ref){
	global $entity;
	
	$item = $entity->{$type};
	if(isset($item['und'])){	
		$len = count($item['und']);

		if($len == 1){
			$entity->{$type}=[];
		}else if($len > 1){
			for($i=0;$i < $len;$i++) {
				if($item['und'][$i]['target_id'] === $ref->nid){
					unset($entity->{$type}['und'][$i]);
				}
			}		
		}
	}		
}
?>

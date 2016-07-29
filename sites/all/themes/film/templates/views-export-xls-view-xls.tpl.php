<?php

/**
 * @file views-export-xls-view-xls.tpl.php
 * Template to display a view as an xls file.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $rows: An array of row items. Each row is an array of content
 *   keyed by field ID.
 * - $header: an array of haeaders(labels) for fields.
 * - $themed_rows: a array of rows with themed fields.
 * @ingroup views_templates
 */

  $path = drupal_get_path('module', 'views_export_xls');
  $path2 = drupal_get_path('theme', 'film');
	if(current_path() === 'bookmarks-xls'){
		$filename = 'bookmarks-'.date('dMy-G_i').'.xls';
	}
	if(current_path() === 'xls-production'){
		$filename = 'production-'.date('dMy-G_i').'.xls';		
	}
	if(current_path() === 'xls-locations'){
		$filename = 'locations-'.date('dMy-G_i').'.xls';		
	}
	if(current_path() === 'search-xls'){
		$filename = 'search-'.date('dMy-G_i').'.xls';		
	}
  if (!isset($filename) || empty($filename)) {
	if($view->current_display === 'feed_1'){
		$filename = 'production_items-'.date('dMy-G_i').'.xls';
	}else{
		$filename = $view->name . '.xls';
	}
  }
  // include xls generatator class
	require_once DRUPAL_ROOT.'/sites/all/libraries/PHPExcel/Classes/PHPExcel.php';
	
	//set the access control
	if(user_has_role(4) || user_has_role(3) || user_has_role(6)){
		$access = true;
	}else{
		$access = false;
	}
  
	$themed_rows = array_merge(array($header), $themed_rows);
	
	//convert special characters back to text
	foreach($themed_rows as $key=>$row){

		if($access || (isset($row['item_bundle']) && $row['item_bundle'] === 'node:location') || (isset($row['type']) && $row['type'] === 'Location' || $key == 0)){
			foreach($row as $key2=>$item){
				$themed_rows[$key][$key2]=htmlspecialchars_decode($row[$key2],ENT_QUOTES | ENT_HTML401);
				$themed_rows[$key][$key2]=str_replace('node:person','Person',$themed_rows[$key][$key2]);
				$themed_rows[$key][$key2]=str_replace('node:physical_item','Item',$themed_rows[$key][$key2]);
				$themed_rows[$key][$key2]=str_replace('node:location','Location',$themed_rows[$key][$key2]);
				$themed_rows[$key][$key2]=str_replace('node:business','Business',$themed_rows[$key][$key2]);
			}
		}else{
			unset($themed_rows[$key]);
		}
	}
  
	$xls = new PHPExcel();
	$xls->setActiveSheetIndex(0);
	$xls->getActiveSheet()->fromArray($themed_rows, NULL, 'A1');
	
	foreach($xls->getActiveSheet()->getRowDimensions() as $rd) { 
		$rd->setRowHeight(-1); 
	}
	$xls->getActiveSheet()->getDefaultColumnDimension()->setWidth(50);
	$xls->getActiveSheet()->getStyle('A1:E999')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$xls->getActiveSheet()->getStyle('A1:E999')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$xls->getActiveSheet()->getStyle('A1:E999')->getAlignment()->setWrapText(true);
	$xls->getActiveSheet()->getStyle('A1:E999')->getAlignment()->setIndent(1);
	foreach($xls->getActiveSheet()->getRowDimensions() as $rd) { 
		$rd->setRowHeight(-1); 
	}
	$styleArray = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FFFFFF')
		),
		'fill'=> array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '000000')
		)
	);
	$xls->getActiveSheet()->getStyle("A1:Z1")->applyFromArray($styleArray);;


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0


$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel5');
$objWriter->save('php://output');


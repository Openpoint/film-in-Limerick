<?php
$path = '/'.drupal_get_path('theme','film').'/images';
$dom = new DOMDocument;
$dom->loadHTML($output);
$output = '<ul class="production">';
foreach($dom->getElementsByTagName('a') as $node){
	$ref = explode('node/',$node->getAttribute('href'))[1];
	$title = $node->nodeValue;
	$output=$output."<li><a href='/production#prd".$ref."'>".$title."</a></li>";
}
$output = $output."</ul>";
print $output;
?>
<ul class="legal">
	<li><a href="/terms">Terms and Conditions</a></li>
	<li><a href="/cookies">Cookie Policy</a></li>
</ul>
<ul class="external">
	<li class='h100'><a href="http://innovatelimerick.ie" target="_blank"><img src="<?php print $path ?>/innovate_logo.png" /></a></li>
	<li class='h100'><a href="http://limerick.ie" target="_blank"><img src="<?php print $path ?>/limerick_logo.png" /></a></li>
</ul>

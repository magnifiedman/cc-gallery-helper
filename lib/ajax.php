<?php
require_once('config.inc.php');
require_once(ROOT_PATH . 'lib/db.inc.php'); 
require_once(ROOT_PATH . 'lib/classes/gallery.class.php'); 

$r = mysql_query("
	SELECT subject,description,embed
	FROM " . GALLERIES_TABLE . "
	WHERE id = '" . $_GET['id'] . "'");
if(mysql_num_rows($r)>0){
		$return['embed'] = '<h3>' . mysql_result($r,0,'subject') . ': ' . mysql_result($r,0,'description') . '</h3>';
	  	$return['embed'] .= mysql_result($r,0,'embed');
      	$return['success'] = true;
}
else {
	$return['error'] = true;
}
echo $return['embed'];
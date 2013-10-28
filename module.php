<?
$location = 'module/';
$handle=opendir($location);
while(false!==($file=readdir($handle))){
	if(((preg_match('/.php/',$file) && preg_match('/module./',$file)) || (preg_match('/.php/',$file) 
	&& preg_match('/common./',$file))) && !preg_match('/index.php/',$file)){
		include($location.$file);
	}
}
closedir($handle);
?>

<?
//-----------------------------------------------------------------
//	disable_right_click
//-----------------------------------------------------------------
function disable_right_click(){
?>
	<script language=JavaScript>
	<!--
	//Disable right click script III- By Renigade (renigade@mediaone.net)
	//For full source code, visit http://www.dynamicdrive.com
	var message="";
	function clickIE() {if (document.all) {(message);return false;}}
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) {
	if (e.which==2||e.which==3) {(message);return false;}}}
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
	document.oncontextmenu=new Function("return false")
	-->
	</script>
<?
}
//-----------------------------------------------------------------
//	non php include
//-----------------------------------------------------------------
function non_php_include(){
	global $valid;
	if($valid == true){
		$basic_style = 'admin';
	}else{
		$basic_style = 'user';
	}
	textarea();
?>
	<!--JQuery inc-->
	<script type="text/javascript" src="js/jquery.js"></script>
	<!--JQuery Menu-->
	<script type="text/javascript" src="js/menu.js"></script>
	<!--JQuery Simple Modal-->
	<script type="text/javascript" src="js/jquery.simplemodal.js"></script>
	<script type="text/javascript" src="js/confirm.js"></script>
	<link rel="stylesheet" type="text/css" href="css/confirm.css"/>
	<!--mp3player-->
	<script type="text/javascript" src="plugin/flashmp3player/swfobject.js"></script>
	<!--flowplayer-->
	<script type="text/javascript" src="js/flowplayer-3.1.1.min.js"></script>
	<?
	if(!empty($_GET['detail'])){
	?>
	<!--JQuery Thickbox-->
	<script type="text/javascript" src="js/thickbox.js"></script>
	<link rel="stylesheet" type="text/css" href="css/thickbox.css" />
	<?
	}elseif(preg_match('/_list/',$_GET['p'])){
	?>
	<!--JQuery Table Sorter-->
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
	<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script> 
	<script type="text/javascript">
	$(function() {
		$("table")
			.tablesorter({widthFixed: true, widgets: ['zebra']})
			.tablesorterPager({container: $("#pager")});
	});
	</script>
	<link rel="stylesheet" type="text/css" href="css/table/style.css" />
	<!--JQuery Accordion-->
	<link rel="stylesheet" type="text/css" href="css/accordion.css" />
	<script type="text/javascript" src="js/jquery.accordion.js"></script>
	<script type="text/javascript">
		jQuery().ready(function(){
			// simple accordion
			jQuery('#accordion').accordion({
				<?
				if(empty($_POST['search']) && empty($_GET['search'])){
				?>
				active: true,
				<?
				}else{
				?>
				active: false,
				<? } ?>
				alwaysOpen: false,
				autoheight: true
			});
		});
	</script>
	<? } ?>
	<!--General CSS-->
	<link rel="stylesheet" type="text/css" href="css/<? echo $basic_style; ?>style.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
<?
}
//-----------------------------------------------------------------
//	disable text select
//-----------------------------------------------------------------
function disable_text_select(){
?>
	<script type="text/javascript">
	<!--
	disableSelection(document.body) //disable text selection on entire body of page
	-->
	</script>
<?
}
//-----------------------------------------------------------------
//	textarea
//-----------------------------------------------------------------
function textarea(){
?>
	<script type="text/javascript" src="plugin/tinymce/tiny_mce.js"></script>
	<script type="text/javascript">
	<!--
		tinyMCE.init({
			// General options
			mode : "textareas",
			theme : "advanced",
			plugins : "style,advlink,paste,fullscreen",	
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,cleanup,code,|,forecolor,backcolor,|,sub,sup,|,charmap",
			theme_advanced_buttons3 : "",
			theme_advanced_buttons4 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,	
			// Example content CSS (should be your site CSS)
			content_css : "css/areastyle.css"
		});
	-->
	</script>
<?
}
//-----------------------------------------------------------------
//	textarea_simple
//-----------------------------------------------------------------
function textarea_simple(){
?>
	<script type="text/javascript" src="../tinymce/tiny_mce.js"></script>
	<script type="text/javascript">
	<!--
		tinyMCE.init({
			mode : "textareas",
			theme : "simple"
		});
	-->
	</script>
<?
}
//-----------------------------------------------------------------
//	confirm_box
//-----------------------------------------------------------------
function confirm_box(){
?>
<div id='confirm' style='display:none'>
	<p class='message'></p>
	<div class='buttons'>
	<div class='no simplemodal-close'>No</div><div class='yes'>Yes</div>
</div>
<?
}
?>

<?
//-----------------------------------------------------------------
//		admin header
//-----------------------------------------------------------------
function admin_header(){
	global $valid,$member;
?>
	<div id="Header">
	<h1>Foodies</h1>
	<?
	if($valid==true){
	?>
	<ul id="jsddm">
	<li><a href="#">POS</a>
		<ul>
		<li><a href="index.php?p=order_add_console">Transaction</a></li>
		<li><a href="index.php?p=order_chart_list">Transaction list</a></li>
		<? if($_COOKIE['type']=='admin'){ ?>
		<li><a href="index.php?p=creditcard_list">Creditcard</a></li><? } ?>
		</ul>
	</li>
	<? if($_COOKIE['type']=='admin'){ ?>
	<li><a href="#">Product</a>
		<ul>
		<li><a href="index.php?p=product_list">Product</a></li>
		<li><a href="index.php?p=product_category_list">Product Category</a></li>
		<li><a href="index.php?p=discount_list">Discount</a></li>
		</ul>
	</li>
	<? } ?>
	<? if($_COOKIE['type']=='admin'){ ?>
	<li><a href="#">Administration</a>
		<ul>
		
		<li><a href="index.php?p=creditcard_reference_list">Credit Card Reference</a></li>
		<li><a href="index.php?p=admin_list">Admin</a></li>
		<li><a href="index.php?p=login_list">Login List</a></li>
		</ul>
	</li>
	<? }else{ ?>
	<li><a href="index.php?p=admin_list">Edit Your Data</a></li>
	<? } ?>
	<li><a href="#" onClick="confirm('Are You Sure to Logout?',function(){ window.location.href = 'index.php?p=logout'; })">Logout</a></li>
	</ul>
	<? } ?>
	</div>
<?
}
//-----------------------------------------------------------------
//		admin content
//-----------------------------------------------------------------
function admin_content(){
?>
	<div id="general">
		<? page_structure('main'); ?>
		<div style="clear:both;"></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		admin footer
//-----------------------------------------------------------------
function admin_footer(){
}
?>

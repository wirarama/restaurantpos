<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_product_category_list
//-----------------------------------------------------------------
function head_product_category_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM product_category WHERE id='".$_GET['delete']."'");
		mysql_query("DELETE FROM product WHERE product_category='".$_GET['delete']."'");
		header('location:index.php?p=product_category_list');
	}
}
//-----------------------------------------------------------------
//	head_product_category_add
//-----------------------------------------------------------------
function head_product_category_add(){
	if(isset($_POST['add'])){
		$no = auto_number('product_category');
		mysql_query("INSERT INTO product_category 
		VALUES('".$no."','".$_POST['name']."','".$_POST['type']."',null,'".$_COOKIE['login']."')") 
		or die(mysql_error());
		header('location:index.php?p=product_category_list');
	}
}
//-----------------------------------------------------------------
//	head_product_category_edit
//-----------------------------------------------------------------
function head_product_category_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE product_category SET 
		name='".$_POST['name']."',
		type='".$_POST['type']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=product_category_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_product_category_list
//-----------------------------------------------------------------
function main_product_category_list(){
	$title = 'Product Category List';
	$head = array('Type','Name','Product');
	$width = array('30%','60%','10%');
	$link = '<a href="index.php?p=product_category_add">Add New Product Category &raquo;</a>';
	$product1 = 'index.php?p=product_category_edit&edit=';
	$product2 = 'index.php?p=product_category_list&delete=';
	$rows = array();
	$ids = array();
	$q = mysql_query("SELECT type,name,id FROM product_category ORDER BY name ASC");
	while($data = mysql_fetch_row($q)){
		$product = mysql_num_rows(mysql_query("SELECT id FROM product WHERE product_category='".$data[2]."'"));
		$d = array($data[0],$data[1],$product);
		array_push($rows,$d);
		array_push($ids,$data[2]);
	}
	table_output($title,$product1,$product2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	main_product_category_add
//-----------------------------------------------------------------
function main_product_category_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Product Category');
	form_back('index.php?p=product_category_list','Product Category');
	form_text('Name','name',$_POST['name'],60,255);
	$type = array('beverages','foods');
	form_select_array('Type','type',$type,$type,$_POST['type']);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_product_category_edit
//-----------------------------------------------------------------
function main_product_category_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM product_category WHERE id='".$_GET['edit']."'"));
	form_header('Edit Product Category');
	form_hidden('edit',$_GET['edit']);
	form_back('index.php?p=product_category_list','Product Category');
	form_text('Name','name',$data['name'],60,255);
	$type = array('beverages','foods');
	form_select_array('Type','type',$type,$type,$data['type']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
?>

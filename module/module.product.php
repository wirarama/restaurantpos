<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_product_list
//-----------------------------------------------------------------
function head_product_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM product WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=product_list');
	}
}
//-----------------------------------------------------------------
//	head_product_add
//-----------------------------------------------------------------
function head_product_add(){
	if(isset($_POST['add'])){
		$no = auto_number('product');
		mysql_query("INSERT INTO product 
		VALUES('".$no."','".$_POST['name']."',
		'".$_POST['product_category']."','".$_POST['description']."','".$_POST['price_regular']."',
		'".$_POST['price_happy_hour']."',null,'".$_COOKIE['login']."')") or die(mysql_error());
		header('location:index.php?p=product_list');
	}
}
//-----------------------------------------------------------------
//	head_product_edit
//-----------------------------------------------------------------
function head_product_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE product SET 
		name='".$_POST['name']."',
		product_category='".$_POST['product_category']."',
		description='".$_POST['description']."',
		price_regular='".$_POST['price_regular']."',
		price_happy_hour='".$_POST['price_happy_hour']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=product_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_product_list
//-----------------------------------------------------------------
function main_product_list(){
	$title = 'Product List';
	$head = array('ID','Name','Category','Price R','Price HH');
	$width = array('10%','30%','20%','20%','20%');
	$link = '<a href="index.php?p=product_add">Add New Product &raquo;</a>';
	$product1 = 'index.php?p=product_edit&edit=';
	$product2 = 'index.php?p=product_list&delete=';
	$where = product_search_input();
	$q = mysql_query("SELECT a.name,b.name,a.price_regular,a.price_happy_hour,a.id 
	FROM product AS a,product_category AS b WHERE a.product_category=b.id 
	".$where." ORDER BY a.id ASC") or die(mysql_error());
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$id = supplyid($data[4]);
		$d = array($id,$data[0],$data[1],number_format($data[2],0,'','.'),number_format($data[3],0,'','.'));
		array_push($rows,$d);
		array_push($ids,$data[4]);
	}
	table_output($title,$product1,$product2,$head,$width,$link,$rows,$ids,null,'product');
}
//-----------------------------------------------------------------
//	main_product_add
//-----------------------------------------------------------------
function main_product_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Product');
	form_back('index.php?p=product_list','Product');
	if(!empty($_GET['product_category'])) $_POST['product_category'] = $_GET['product_category'];
	form_text('Name','name',$_POST['name'],60,255);
	form_select_db('Category','product_category','name',$_POST['product_category']);
	form_text('Price Regular','price_regular',$_POST['price_regular'],20,20);
	form_text('Price Happy Hour','price_happy_hour',$_POST['price_happy_hour'],20,20);
	form_textarea('Description','description',150,$_POST['description']);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_product_edit
//-----------------------------------------------------------------
function main_product_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM product WHERE id='".$_GET['edit']."'"));
	form_header('Edit Product');
	form_back('index.php?p=product_list','Product');
	form_hidden('edit',$_GET['edit']);
	if(empty($_POST['product_category'])) $_POST['product_category']=$data['product_category'];
	form_text('Name','name',$data['name'],60,255);
	form_select_db('Category','product_category','name',$data['product_category']);
	form_text('Price Regular','price_regular',$data['price_regular'],20,20);
	form_text('Price Happy Hour','price_happy_hour',$data['price_happy_hour'],20,20);
	form_textarea('Description','description',150,$data['description']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	product_search
//-----------------------------------------------------------------
function product_search(){
?>
	<form action="" method="GET">
	<div id="formsearch">
	<?
	form_hidden('p',$_GET['p']);
	form_text('Name','name',$_GET['name'],60,255);
	form_select_db('Category','product_category','name',$_GET['product_category']);
	form_text('Price Regular More Than','price_regular_more',$_GET['price_regular_more'],20,20);
	form_text('Price Regular Less Than','price_regular_less',$_GET['price_regular_less'],20,20);
	form_text('Price Happy Hour More Than','price_happy_hour_more',$_GET['price_happy_hour_more'],20,20);
	form_text('Price Happy Hour Less Than','price_happy_hour_less',$_GET['price_happy_hour_less'],20,20);
	form_submit_search('Search','search');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	product_search_input
//-----------------------------------------------------------------
function product_search_input(){
	$where = '';
	if(!empty($_GET['name'])){
		$where .= " AND a.name like'%".$_GET['name']."%'";
	}
	if(!empty($_GET['product_category'])){
		$where .= " AND b.id='".$_GET['product_category']."'";
	}
	if(!empty($_GET['price_regular_more'])){
		$where .= " AND a.price_regular>'".$_GET['price_regular_more']."'";
	}
	if(!empty($_GET['price_regular_less'])){
		$where .= " AND a.price_regular<'".$_GET['price_regular_less']."'";
	}
	if(!empty($_GET['price_happy_hour_more'])){
		$where .= " AND a.price_happy_hour>'".$_GET['price_happy_hour_more']."'";
	}
	if(!empty($_GET['price_happy_hour_less'])){
		$where .= " AND a.price_happy_hour<'".$_GET['price_happy_hour_less']."'";
	}
	return $where;
}
?>

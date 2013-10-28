<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_discount_list
//-----------------------------------------------------------------
function head_discount_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM discount WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=discount_list');
	}
}
//-----------------------------------------------------------------
//	head_discount_add
//-----------------------------------------------------------------
function head_discount_add(){
	if(isset($_POST['add'])){
		$start = $_POST['yfromdate'].'-'.$_POST['mfromdate'].'-'.$_POST['dfromdate'];
		$stop = $_POST['ytodate'].'-'.$_POST['mtodate'].'-'.$_POST['dtodate'];
		mysql_query("INSERT INTO discount VALUES(null,'".$_POST['product']."',null,
		'".$_POST['discount']."','".$start."','".$stop."',
		'".$_COOKIE['login']."',null)") or die(mysql_error());
		header('location:index.php?p=discount_list');
	}
}
//-----------------------------------------------------------------
//	head_discount_edit
//-----------------------------------------------------------------
function head_discount_edit(){
	if(isset($_POST['edit_send'])){
		$start = $_POST['yfromdate'].'-'.$_POST['mfromdate'].'-'.$_POST['dfromdate'];
		$stop = $_POST['ytodate'].'-'.$_POST['mtodate'].'-'.$_POST['dtodate'];
		mysql_query("UPDATE discount SET 
		product='".$_POST['product']."',
		discount='".$_POST['discount']."',
		fromdate='".$start."',
		todate='".$stop."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=discount_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_discount_list
//-----------------------------------------------------------------
function main_discount_list(){
	$title = 'Discount List';
	$head = array('Product','Discount','From','To');
	$width = array('30%','20%','25%','25%');
	$link = '<a href="index.php?p=discount_add">Add New Discount &raquo;</a>';
	$discount1 = 'index.php?p=discount_edit&edit=';
	$discount2 = 'index.php?p=discount_list&delete=';
	$where = discount_search_input();
	$q = mysql_query("SELECT b.name,a.discount,a.fromdate,a.todate,a.id 
	FROM discount AS a,product AS b WHERE b.id=a.product ".$where." ORDER BY a.id DESC");
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array($data[0],$data[1].'%',$data[2],$data[3]);
		array_push($rows,$d);
		array_push($ids,$data[4]);
	}
	table_output($title,$discount1,$discount2,$head,$width,$link,$rows,$ids,null,'discount');
}
//-----------------------------------------------------------------
//	main_discount_add
//-----------------------------------------------------------------
function main_discount_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Discount');
	form_back('index.php?p=discount_list','Discount');
	form_select_db('Product','product','name',$_POST['product']);
	form_text('Discount','discount',$_POST['discount'],5,5);
	form_date('From','fromdate');
	form_date('To','todate');
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_discount_edit
//-----------------------------------------------------------------
function main_discount_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM discount WHERE id='".$_GET['edit']."'"));
	form_header('Edit Discount');
	form_back('index.php?p=discount_list','Discount');
	form_hidden('edit',$_GET['edit']);
	form_select_db('Product','product','name',$data['product']);
	form_text('Discount','discount',$data['discount'],5,5);
	form_date('From','fromdate',$data['fromdate']);
	form_date('To','todate',$data['todate']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	discount_search
//-----------------------------------------------------------------
function discount_search(){
?>
	<form action="" method="GET">
	<div id="formsearch">
<?
	form_hidden('p',$_GET['p']);
	form_select_db('Product','product','name',$_GET['product']);
	form_text('Discount','discount',$_GET['discount'],5,5);
	form_date('From','fromdate',$_GET['fromdate']);
	form_date('To','todate',$_GET['todate']);
	form_submit_search('Search','search');
?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	discount_search_input
//-----------------------------------------------------------------
function discount_search_input(){
	$where = '';
	if(!empty($_GET['product'])){
		$where .= " AND a.product='".$_GET['name']."'";
	}
	if(!empty($_GET['discount'])){
		$where .= " AND a.discount='".$_GET['discount']."'";
	}
	if(!empty($_POST['yfromdate']) && !empty($_POST['ytodate'])){
		$start = mktime(0,0,0,$_POST['mfromdate'],$_POST['dfromdate'],$_POST['yfromdate']);
		$stop = mktime(23,59,59,$_POST['mtodate'],$_POST['dtodate'],$_POST['ytodate']);
		$where .= " AND (UNIX_TIMESTAMP(a.fromdate)>='".$start."' 
		AND UNIX_TIMESTAMP(a.todate)<='".$stop."')";
	}
	return $where;
}
?>

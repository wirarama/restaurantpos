<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_creditcard_list
//-----------------------------------------------------------------
function head_creditcard_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM creditcard WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=creditcard_list');
	}elseif(isset($_GET['credircardid'])){
		mysql_query("UPDATE creditcard SET status='valid' WHERE id='".$_GET['credircardid']."'");
		header('location:index.php?p=creditcard_list');
	}
}
//-----------------------------------------------------------------
//	head_creditcard_reference_list
//-----------------------------------------------------------------
function head_creditcard_reference_list(){
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_creditcard_list
//-----------------------------------------------------------------
function main_creditcard_list(){
	$title = 'Creditcard List';
	$head = array('Total Transaction','Creditcard','status','Date');
	$width = array('35%','25%','15%','25%');
	$where = creditcard_search_input();
	$q = mysql_query("SELECT b.id,b.price_total,a.creditcard,a.status,a.date,a.id 
	FROM creditcard AS a,trans_order AS b WHERE b.id=a.transaction ".$where." ORDER BY a.id DESC") or die(mysql_error());
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array('<a href="index.php?p=order_list&chart='.$data[0].'">'.$data[1].'</a>',$data[2],$data[3],$data[4]);
		array_push($rows,$d);
		array_push($ids,$data[5]);
	}
	table_output($title,null,null,$head,$width,null,$rows,$ids,null,'creditcard');
}
//-----------------------------------------------------------------
//	main_creditcard_reference_list
//-----------------------------------------------------------------
function main_creditcard_reference_list(){
	$title = 'Creditcard Reference List';
	$head = array('Category','Creditcard ID','Description');
	$width = array('30%','10%','60%');
	$q = mysql_query("SELECT b.name,a.code,a.description,a.id 
	FROM creditcard_id AS a,creditcard_category AS b WHERE b.id=a.category ORDER BY b.id ASC,a.id ASC") 
	or die(mysql_error());
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array($data[0],$data[1],$data[2]);
		array_push($rows,$d);
		array_push($ids,$data[3]);
	}
	table_output($title,null,null,$head,$width,null,$rows,$ids);
}
//-----------------------------------------------------------------
//	creditcard_search
//-----------------------------------------------------------------
function creditcard_search(){
?>
	<form action="" method="GET">
	<div id="formsearch">
<?
	form_hidden('p',$_GET['p']);
	form_select_db('Product','product','name',$_GET['product']);
	form_text('Creditcard','creditcard',$_GET['creditcard'],30,30);
	form_date('From','fromdate',$_GET['fromdate']);
	form_date('To','todate',$_GET['todate']);
	form_submit_search('Search','search');
?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	creditcard_search_input
//-----------------------------------------------------------------
function creditcard_search_input(){
	$where = '';
	if(!empty($_GET['product'])){
		$where .= " AND a.product='".$_GET['name']."'";
	}
	if(!empty($_GET['creditcard'])){
		$where .= " AND a.creditcard='".$_GET['creditcard']."'";
	}
	if(!empty($_POST['yfromdate']) && !empty($_POST['ytodate'])){
		$start = mktime(0,0,0,$_POST['mfromdate'],$_POST['dfromdate'],$_POST['yfromdate']);
		$stop = mktime(23,59,59,$_POST['mtodate'],$_POST['dtodate'],$_POST['ytodate']);
		$where .= " AND (UNIX_TIMESTAMP(a.date)>='".$start."' AND UNIX_TIMESTAMP(a.date)<='".$stop."')";
	}
	return $where;
}
?>

<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_order_chart_list
//-----------------------------------------------------------------
function head_order_chart_list(){
	if(!empty($_GET['delete'])){
		product_stock_delete($_GET['delete'],'trans_order_chart','order_chart');
		header('location:index.php?p=order_chart_list');
	}elseif(!empty($_GET['validate'])){
		mysql_query("UPDATE trans_order_chart SET purchase_status='valid' WHERE id='".$_GET['validate']."'");
		header('location:index.php?p=order_chart_list');
	}elseif(!empty($_GET['received'])){
		mysql_query("UPDATE trans_order_chart SET purchase_status='received' WHERE id='".$_GET['received']."'");
		$supplysummaryq = mysql_query("SELECT product,id FROM trans_supply 
		WHERE chart='".$chart_id."'") or die(mysql_error());
		while($supplysummaryd = mysql_fetch_row($supplysummaryq)){
			product_stock_update($supplysummaryd[0]);
			mysql_query("INSERT INTO transaction_history VALUES(null,'supply',
			'".$supplysummaryd[1]."','".$supplysummaryd[0]."',null,'".$_COOKIE['login']."')") 
			or die(mysql_error());
		}
		header('location:index.php?p=order_chart_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_order_chart_list
//-----------------------------------------------------------------
function main_order_chart_list(){
	$title = 'Transaction List';
	$head = array('ID','Total Price','Date');
	$width = array('10%','45%','45%');
	$where = order_chart_search_input();
	$q = mysql_query("SELECT price_total,date,id FROM trans_order_chart 
	WHERE status='valid' ".$where." ORDER BY date DESC") or die(mysql_error());
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$orderid = orderid($data[2]);
		$d = array($orderid,number_format($data[0],0,'','.'),$data[1]);
		array_push($rows,$d);
		array_push($ids,$data[2]);
	}
	table_output($title,$order_chart1,$order_chart2,$head,$width,$link,$rows,$ids,null,'order_chart');
}
//-----------------------------------------------------------------
//	order_chart_search
//-----------------------------------------------------------------
function order_chart_search(){
?>
	<form action="" method="GET">
	<div id="formsearch">
	<?
	form_hidden('p',$_GET['p']);
	form_text('Total Cost Less Than','price_totalless',$_GET['price_totalless'],10,10);
	form_text('Total Cost More Than','price_totalmore',$_GET['price_totalmore'],10,10);
	form_date_search('Search From','searchfrom');
	form_date_search('Search To','searchto');
	form_submit_search('Search','search');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	order_chart_search_input
//-----------------------------------------------------------------
function order_chart_search_input(){
	$where = '';
	if(!empty($_GET['amountmore'])){
		$where .= " AND price_total>'".$_GET['price_totalless']."'";
	}
	if(!empty($_GET['amountless'])){
		$where .= " AND price_total<'".$_GET['price_totalmore']."'";
	}
	if(!empty($_GET['status'])){
		$where .= " AND purchase_status='".$_GET['status']."'";
	}
	if(!empty($_POST['ysearchfrom']) && !empty($_POST['ysearchto'])){
		$start = mktime(0,0,0,$_POST['msearchfrom'],$_POST['dsearchfrom'],$_POST['ysearchfrom']);
		$stop = mktime(23,59,59,$_POST['msearchto'],$_POST['dsearchto'],$_POST['ysearchto']);
		$where .= " AND (UNIX_TIMESTAMP(date)>='".$start."' AND UNIX_TIMESTAMP(date)<='".$stop."')";
	}
	return $where;
}
?>

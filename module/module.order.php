<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_order_list
//-----------------------------------------------------------------
function head_order_list(){
	if(isset($_GET['delete'])){
		product_stock_delete($_GET['delete'],'trans_order','order');
		header('location:index.php?p=order_list');
	}
}
//-----------------------------------------------------------------
//	head_order_add
//-----------------------------------------------------------------
function head_order_add(){
	if(isset($_POST['add'])){
		$price_total = $_POST['amount']*$_POST['price'];
		$no = auto_number('trans_order');
		mysql_query("INSERT INTO trans_order VALUES('".$no."','".$_POST['client']."',
		'".$_POST['product']."','".$_POST['amount']."','".$_POST['price']."','".$price_total."',
		null,'".$_COOKIE['login']."')") or die(mysql_error());
		mysql_query("INSERT INTO transaction_history VALUES(null,'order',
		'".$no."','".$_POST['product']."',null,'".$_COOKIE['login']."')") or die(mysql_error());		
		product_stock_update($_POST['product']);
		header('location:index.php?p=order_list');
	}
}
//-----------------------------------------------------------------
//	head_order_add_console
//-----------------------------------------------------------------
function head_order_add_console(){
	if(empty($_COOKIE['order_chart'])){
		$chart_id = auto_number('trans_order_chart');
		mysql_query("INSERT INTO trans_order_chart VALUES('".$chart_id."',null,
		null,null,null,'".$_COOKIE['login']."',null,'temp')") 
		or die(mysql_error());
		setcookie('order_chart',$chart_id);
		header('location:index.php?p=order_add_console');
	}
	if(isset($_POST['add_food'])){
		$product = mysql_fetch_row(mysql_query("SELECT price_regular,id FROM product 
		WHERE id='".$_POST['menu_food']."'"));
		if(empty($_POST['amount_food'])) $_POST['amount_food']=1;
		$price_total = $_POST['amount_food']*$product[0];
		$chart_id = $_COOKIE['order_chart'];
		$id_exist = mysql_fetch_row(mysql_query("SELECT id,amount FROM trans_order 
		WHERE chart='".$_COOKIE['order_chart']."' AND product='".$product[1]."'"));
		if(empty($id_exist[0])){
			$no = auto_number('trans_order');
			mysql_query("INSERT INTO trans_order VALUES('".$no."',
			'".$product[1]."','".$_POST['chair_food']."','".$_POST['menu_food']."','".$_POST['type_food']."',
			'".$_POST['amount_food']."','".$_POST['special_request_food']."','".$product[0]."','".$price_total."',
			null,'".$_COOKIE['login']."','temp','".$chart_id."')") or die('yg ini'.mysql_error());
		}else{
			$newamount = $id_exist[1]+$_POST['amount'];
			$price_total = $newamount*$product[0];
			mysql_query("UPDATE trans_order SET amount='".$newamount."',
			price_total='".$price_total."' WHERE id='".$id_exist[0]."'") 
			or die(mysql_error());
		}
		header('location:index.php?p=order_add_console');
	}elseif(isset($_POST['add_beverage'])){
		$product = mysql_fetch_row(mysql_query("SELECT price_regular,id FROM product 
		WHERE id='".$_POST['menu_beverage']."'"));
		if(empty($_POST['amount_beverage'])) $_POST['amount_beverage']=1;
		$price_total = $_POST['amount_beverage']*$product[0];
		$chart_id = $_COOKIE['order_chart'];
		$id_exist = mysql_fetch_row(mysql_query("SELECT id,amount FROM trans_order 
		WHERE chart='".$_COOKIE['order_chart']."' AND product='".$product[1]."'"));
		if(empty($id_exist[0])){
			$no = auto_number('trans_order');
			mysql_query("INSERT INTO trans_order VALUES('".$no."',
			'".$product[1]."','".$_POST['chair_beverage']."','".$_POST['menu_beverage']."','".$_POST['type_beverage']."',
			'".$_POST['amount_beverage']."','".$_POST['special_request_beverage']."','".$product[0]."','".$price_total."',
			null,'".$_COOKIE['login']."','temp','".$chart_id."')") or die(mysql_error());
		}else{
			$newamount = $id_exist[1]+$_POST['amount'];
			$price_total = $newamount*$product[0];
			mysql_query("UPDATE trans_order SET amount='".$newamount."',
			price_total='".$price_total."' WHERE id='".$id_exist[0]."'") 
			or die(mysql_error());
		}
		header('location:index.php?p=order_add_console');
	}elseif(isset($_POST['summary'])){
		$orderq = mysql_query("SELECT price_total,product FROM trans_order 
		WHERE chart='".$_COOKIE['order_chart']."'") or die(mysql_error());
		$charttotal = 0;
		while($orderd = mysql_fetch_row($orderq)){
			$charttotal = $charttotal+$orderd[0];
		}
		$price_final = $charttotal;
		if(empty($_POST['creditcard'])){
			$return = $_POST['payment']-$price_final;
		}else{
			$nocreaditcard = auto_number('creditcard');
			mysql_query("INSERT INTO creditcard VALUES('".$nocreaditcard."','".$_COOKIE['order_chart']."',
			'".$_POST['creditcard']."',null,'pending','".$_COOKIE['login']."',null)") or die(mysql_error());
			$qcreditcard = mysql_query("SELECT code,id FROM creditcard_id");
			$identification = null;
			while($dcreditcard = mysql_fetch_row($qcreditcard)){
				$check_identification = mysql_fetch_row(mysql_query("SELECT id FROM creditcard 
				WHERE creditcard like'".$dcreditcard[0]."%'"));
				if(!empty($check_identification[0])){
					$identification = $dcreditcard[1];
					break;
				}
			}
			mysql_query("UPDATE creditcard SET identification='".$identification."' 
			WHERE id='".$nocreaditcard."'") or die(mysql_error());
			$_POST['payment'] = $charttotal;
			$return = '0';
		}
		mysql_query("UPDATE trans_order_chart SET price_total='".$charttotal."',
		payment='".$_POST['payment']."',pricereturn='".$return."'  
		WHERE id='".$_COOKIE['order_chart']."'") or die(mysql_error());
		header('location:index.php?p=order_add_console&summary=1');
	}elseif(isset($_POST['print'])){
		mysql_query("UPDATE trans_order_chart SET status='valid' 
		WHERE id='".$_COOKIE['order_chart']."'") or die(mysql_error());
		mysql_query("UPDATE trans_order SET status='valid' 
		WHERE chart='".$_COOKIE['order_chart']."'") or die(mysql_error());
		setcookie('order_chart','');
		header('location:index.php?p=order_add_console');
	}elseif(isset($_POST['cancel'])){
		mysql_query("DELETE FROM creditcard WHERE transaction='".$_COOKIE['order_chart']."'");
		header('location:index.php?p=order_add_console');
	}
}
//-----------------------------------------------------------------
//	head_order_edit
//-----------------------------------------------------------------
function head_order_edit(){
	if(isset($_POST['edit_send'])){
		$price_total = $_POST['amount']*$_POST['price'];
		mysql_query("UPDATE trans_order SET 
		client='".$_POST['client']."',
		product='".$_POST['product']."',
		amount='".$_POST['amount']."',
		price='".$_POST['price']."',
		price_total='".$price_total."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		mysql_query("UPDATE transaction_history SET product='".$_POST['product']."' 
		WHERE type='supply' AND relation='".$_POST['edit']."'") or die(mysql_error());
		product_stock_update($_POST['product']);
		header('location:index.php?p=order_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_order_list
//-----------------------------------------------------------------
function main_order_list(){
	$orderid = orderid($_GET['chart']);
	$title = 'Transaction List '.$orderid.'<br><a href="module/report.pdf.order.php?chart='.
		$_GET['chart'].'">[PDF]</a>';
	$title .= ' | <a href="module/report.excel.order.php?chart='.$_GET['chart'].'">[Excel]</a>';
	$head = array('Product','Amount','Price','Total','Chair','Type');
	$width = array('30%','10%','20%','20%','10%','10%');
	if($_COOKIE['type']=='admin'){
		$link = '<a href="index.php?p=order_add">Add New Transaction &raquo;</a>';
		$order1 = 'index.php?p=order_edit&edit=';
		$order2 = 'index.php?p=order_list&delete=';
	}
	list($rows,$ids) = order_data();
	table_output($title,$order1,$order2,$head,$width,$link,$rows,$ids,null,'order');
}
//-----------------------------------------------------------------
//	order_data
//-----------------------------------------------------------------
function order_data(){
	$where = order_search_input();
	$q = mysql_query("SELECT b.name,a.amount,a.price,a.price_total,a.chair,a.type,a.id 
	FROM trans_order AS a,product AS b WHERE a.product=b.id AND a.status='valid' 
	".$where." ORDER BY a.date DESC") or die(mysql_error());
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_row($q)){
		$d = array($data[0],$data[1],number_format($data[2],0,'','.'),
		number_format($data[3],0,'','.'),$data[4],$data[5]);
		array_push($rows,$d);
		array_push($ids,$data[6]);
	}
	return array($rows,$ids);
}
//-----------------------------------------------------------------
//	main_order_add
//-----------------------------------------------------------------
function main_order_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New Transaction');
	form_back('index.php?p=order_list','Transaction');
	form_select_db('Client','client','name',$_POST['client']);
	form_select_quantity_order($_POST['product'],$_POST['amount']);
	form_text('Price','price',$_POST['price'],30,60);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_order_add_console
//-----------------------------------------------------------------
function main_order_add_console(){
?>
	<form action="" method="POST">
	<div id="formborder" style="width:800px;">
	<?
	$order_chart = orderid($_COOKIE['order_chart']);
	form_header('Transaction '.$order_chart);
	if(!empty($_GET['wrong'])){
		form_chart('<span style="color:#b01515;"><b>Wrong barcode</b></span>');
	}
	form_text_side('Table Number','table_number',$_POST['table_number'],5,5);
	if(!empty($_COOKIE['order_chart'])){
		$orderq = mysql_query("SELECT b.name,a.amount,a.price_total,b.id,a.id,a.price,a.chair,a.type 
		FROM trans_order AS a,product AS b WHERE chart='".$_COOKIE['order_chart']."' 
		AND a.product=b.id") or die(mysql_error());
		$total = 0;
		while($orderd = mysql_fetch_row($orderq)){
			$chart_list_string = 'Chair '.$orderd[6].' <i>[ '.$orderd[7].' ]</i> : '.'<b>'.$orderd[0].'</b> : '.
			number_format($orderd[5],0,'','.').' x '.$orderd[1].' = '.number_format($orderd[2],0,'','.');
			$total_price = $orderd[2];
			form_chart($chart_list_string);
			$total = $total+$total_price;
		}
		form_chart('<span style="font-size:22px;">Total : <b>'.number_format($total,0,'','.').'</b></span>');
	}
	if(empty($_GET['summary'])){
		form_text_food();
		form_text_beverage();
		form_header('Payment');
		form_text_side('Payment','payment',$_POST['payment'],30,30);
		form_text_side('Creditcard','creditcard',$_POST['creditcard'],30,60);
		form_submit('Summary','summary');
	}else{
		$dcreditcard = mysql_fetch_row(mysql_query("SELECT creditcard,identification FROM creditcard 
		WHERE transaction='".$_COOKIE['order_chart']."'"));
		if(empty($dcreditcard[0])){
			$dsummary = mysql_fetch_row(mysql_query("SELECT payment,pricereturn 
			FROM trans_order_chart WHERE id='".$_COOKIE['order_chart']."'"));
			form_chart('<span style="font-size:22px;">Payment : <b>'.number_format($dsummary[0],0,'','.').'</b></span>');
			form_chart('<span style="font-size:22px;">Return : <b>'.number_format($dsummary[1],0,'','.').'</b></span>');
		}else{
			$dccidentified = mysql_fetch_row(mysql_query("SELECT b.name,a.description FROM 
			creditcard_id AS a, creditcard_category AS b 
			WHERE a.id='".$dcreditcard[1]."' AND b.id=a.category"));
			form_chart('<span style="font-size:22px;">Credit Card : <b>'.$dcreditcard[0].'</b></span>');
			form_chart('<span>CC Identified : <b>'.$dccidentified[0].
			'</b> &raquo; <b>'.$dccidentified[1].'</b></span>');
		}
		form_submit('Print','print');
		form_submit('Cancel','cancel');
	}
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_order_edit
//-----------------------------------------------------------------
function main_order_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM trans_order WHERE id='".$_GET['edit']."'"));
	form_header('Edit Transaction');
	form_back('index.php?p=order_list','Transaction');
	form_hidden('edit',$_GET['edit']);
	form_select_db('Client','client','name',$data['client']);
	form_select_quantity_order($data['product'],$data['amount']);
	form_text('Price','price',$data['price'],30,60);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	order_search
//-----------------------------------------------------------------
function order_search(){
?>
	<form action="" method="GET">
	<div id="formsearch">
	<?
	form_hidden('p',$_GET['p']);
	form_select_db('Client','client','name',$_GET['client']);
	form_select_db('Category','product_category','name',$_GET['product_category']);
	form_select_db('Product','product','name',$_GET['product']);
	form_date_search('Search From','searchfrom');
	form_date_search('Search To','searchto');
	form_text('Amount More Than','amountmore',$_GET['amountmore'],10,10);
	form_text('Amount Less Than','amountless',$_GET['amountless'],10,10);
	form_submit_search('Search','search');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	order_search_input
//-----------------------------------------------------------------
function order_search_input(){
	$where = '';
	if(!empty($_GET['client'])){
		$where .= " AND a.client ='".$_GET['client']."'";
	}
	if(!empty($_GET['product'])){
		$where .= " AND a.product='".$_GET['product']."'";
	}
	if(!empty($_GET['product_category'])){
		$where .= " AND b.product_category='".$_GET['product_category']."'";
	}
	if(!empty($_GET['amountmore'])){
		$where .= " AND a.amount>'".$_GET['amountmore']."'";
	}
	if(!empty($_GET['amountless'])){
		$where .= " AND a.amount<'".$_GET['amountless']."'";
	}
	if(!empty($_GET['chart'])){
		$where .= " AND a.chart='".$_GET['chart']."'";
	}
	if(!empty($_GET['ysearchfrom']) && !empty($_GET['ysearchto'])){
		$start = mktime(0,0,0,$_POST['msearchfrom'],$_POST['dsearchfrom'],$_POST['ysearchfrom']);
		$stop = mktime(0,0,0,$_POST['msearchto'],$_POST['dsearchto'],$_POST['ysearchto']);
		$where .= " AND (UNIX_TIMESTAMP(date)>='".$start."' AND UNIX_TIMESTAMP(date)<='".$stop."')";
	}
	return $where;
}
?>

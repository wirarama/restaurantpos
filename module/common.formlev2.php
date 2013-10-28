<?
//-----------------------------------------------------------------
//	vendorid
//-----------------------------------------------------------------
function vendorid($id){
	if($id<=9){ 
		$vendorid = '000'.$id;
	}elseif($id<=99){ 
		$vendorid = '00'.$id;
	}elseif($id<=999){ 
		$vendorid = '0'.$id;
	}
	return $vendorid;
}
//-----------------------------------------------------------------
//	supplyid
//-----------------------------------------------------------------
function supplyid($id){
	if($id<=9){ 
		$supplyid = '00000'.$id;
	}elseif($id<=99){ 
		$supplyid = '0000'.$id;
	}elseif($id<=999){ 
		$supplyid = '000'.$id;
	}elseif($id<=9999){ 
		$supplyid = '00'.$id;
	}elseif($id<=99999){ 
		$supplyid = '0'.$id;
	}
	return $supplyid;
}
//-----------------------------------------------------------------
//	orderid
//-----------------------------------------------------------------
function orderid($id){
	if($id<=9){ 
		$orderid = '00000'.$id;
	}elseif($id<=99){ 
		$orderid = '0000'.$id;
	}elseif($id<=999){ 
		$orderid = '000'.$id;
	}elseif($id<=9999){ 
		$orderid = '00'.$id;
	}elseif($id<=99999){ 
		$orderid = '0'.$id;
	}
	return $orderid;
}
//-----------------------------------------------------------------
//		form chart
//-----------------------------------------------------------------
function form_chart($text){
?>
	<div>
		<div id="label" style="border-bottom:1px solid #444;"><? echo $text; ?></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form hierarchy
//-----------------------------------------------------------------
function form_hierarchy($text){
?>
	<div>
		<div style="padding:10px;"><? echo $text; ?></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form checkbox category
//-----------------------------------------------------------------
function form_chart_checkbox_category($text,$name){
	if(preg_match('/category/',$name)){
		$color='#7bd2ff';
	}elseif(preg_match('/subclass/',$name)){
		$color='#c4ebff';
	}elseif(preg_match('/class/',$name)){
		$color='#9ddeff';
	}
?>
	<div>
		<div id="label" style="border-bottom:1px solid #444; background-color:<? echo $color; ?>;height:20px;">
		<div style="width:380px;float:left;"><b><? echo $text; ?></b></div>
		<div>
		<? 
		if($_GET['p']=='vendor_product_add'){ 
		?>
			<input type="checkbox" class="checkall">
		<?
		}
		?>
		</div>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form checkbox_product
//-----------------------------------------------------------------
function form_chart_checkbox_product($text,$name,$value1,$value2=null,$value3=null,$value4=null,$checked=null,$unit=null){
?>
	<div>
		<div id="label" style="border-bottom:1px solid #444;padding:5px 5px 5px 40px;">
		<div style="width:350px;float:left;"><? echo $text; ?></div>
		<div style="font-size:10px;">
		<? if($_GET['p']=='vendor_product_add'){ ?>
		<input type="checkbox" name="<? echo $name.$value1; ?>" value="<? echo $value1; ?>" <? echo $checked; ?>> 
		<? }else{ ?>
		<input type="hidden" name="<? echo $name.$value1; ?>" value="<? echo $value1; ?>">
		<? } ?>
		<b>Amount :</b> <input id="amount" type="text" name="<? echo $name.$value1; ?>amount" value="<? echo $value3; ?>" size="5" maxlength="5">
		<? echo $unit; ?> 
		| <b>Price :</b> <input type="text" name="<? echo $name.$value1; ?>price" value="<? echo $value2; ?>" size="10" maxlength="10"> / 
		<b>Whole Price :</b> <input type="text" name="<? echo $name.$value1; ?>wholeprice" value="<? echo $value4; ?>" size="10" maxlength="10">
		</div>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form textfield food
//-----------------------------------------------------------------
function form_text_food(){
	form_header('Foods');
?>
	<div>
		<div id="field">Chair no :&nbsp;
		<input type="text" name="chair_food" size="2" maxlength="2">&nbsp;
		Menu :&nbsp;
		<select name="menu_food">
			<?
			$query = mysql_query("SELECT a.id,b.name,a.name FROM product AS a,product_category AS b
			WHERE a.product_category=b.id AND b.type='foods' ORDER BY b.name ASC,a.name ASC");
			while($data = mysql_fetch_row($query)){
			?>
				<option value="<? echo $data[0]; ?>"><? echo $data[1].' - '.$data[2]; ?></option>
			<? } ?>
		</select>&nbsp;
		QTY :&nbsp;
		<input type="text" name="amount_food" size="2" maxlength="2">&nbsp;
		Type :&nbsp;
		<select name="type_food">
			<option value="children">children</option>
			<option value="woman">woman</option>
			<option value="man">man</option>
		</select>&nbsp;
		</div>
		<div id="field">Special Request :&nbsp;
		<input type="text" name="special_req_food" size="60" maxlength="255">&nbsp;
		<input type="submit" name="add_food" value="add">
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form textfield side
//-----------------------------------------------------------------
function form_text_side($label,$name,$value=null,$size=60,$maxlength=255,$note=null){
?>
	<div>
		<div id="label" style="float:left;width:100px;text-align:right;"><? echo $label; ?> : </div>
		<div id="field">
		<input type="text" name="<? echo $name; ?>" size="<? echo $size; ?>" maxlength="<? echo $maxlength; ?>" value="<? echo $value; ?>">
		<div style="clear:both;"></div>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form textfield beverage
//-----------------------------------------------------------------
function form_text_beverage(){
	form_header('Beverages');
?>
	<div>
		<div id="field">Chair no :&nbsp;
		<input type="text" name="chair_beverage" size="2" maxlength="2">&nbsp;
		Menu :&nbsp;
		<select name="menu_beverage">
			<?
			$query = mysql_query("SELECT a.id,b.name,a.name FROM product AS a,product_category AS b 
			WHERE a.product_category=b.id AND b.type='beverages' ORDER BY b.name ASC,a.name ASC");
			while($data = mysql_fetch_row($query)){
			?>
				<option value="<? echo $data[0]; ?>"><? echo $data[1].' - '.$data[2]; ?></option>
			<? } ?>
		</select>&nbsp;
		QTY :&nbsp;
		<input type="text" name="amount_beverage" size="2" maxlength="2">&nbsp;
		Type :&nbsp;
		<select name="type_beverage">
			<option value="children">children</option>
			<option value="woman">woman</option>
			<option value="man">man</option>
		</select>&nbsp;
		</div>
		<div id="field">Special Request :&nbsp;
		<input type="text" name="special_req_beverage" size="60" maxlength="255">&nbsp;
		<input type="submit" name="add_beverage" value="add">
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//	add_table_header
//-----------------------------------------------------------------
function add_table_header($label,$value){
	$at = '
	<div id="headtable">
		<div id="hlabel"><b>'.$label.'</b></div>
		<div id="hvalue">'.$value.'</div>
	</div>';
	return $at;
}
//-----------------------------------------------------------------
//		form select quantity order
//-----------------------------------------------------------------
function form_select_quantity_order($product=null,$amount=null){
	if(!empty($_POST['product'])) $product = $_POST['product'];
	if(!empty($_POST['amount'])) $amount = $_POST['amount'];
?>
	<div>
		<div id="label">Product : </div>
		<div id="field">
		<select name="product" onchange="submit()">
			<option value=""></option>
			<?
			$q = mysql_query("SELECT id,name FROM product ORDER BY name ASC");
			while($d = mysql_fetch_row($q)){
				if($d[0]==$product){
					$selected = 'selected';
				}else{
					$selected = null;
				}
			?>
				<option value="<? echo $d[0]; ?>" <? echo $selected; ?>><? echo $d[1]; ?></option>
			<? } ?>
		</select>
		</div>
	</div>
	<?
	if(!empty($product)){
	?>
	<div>
		<div id="label">Amount : </div>
		<div id="field">
		<select name="amount" onchange="submit()">
			<option value=""></option>
			<?
			$stock = product_stock($product);
			for($i=$stock;$i>0;$i=$i-1){
				if($i==$amount){
					$selected = 'selected';
				}else{
					$selected = null;
				}
			?>
				<option value="<? echo $i; ?>" <? echo $selected; ?>><? echo $i; ?></option>
			<? } ?>
		</select>		
		</div>
	</div>
	<? } ?>
<?
}
//-----------------------------------------------------------------
//		product_stock
//-----------------------------------------------------------------
function product_stock($product){
	$d_supply = mysql_fetch_row(mysql_query("SELECT SUM(amount) FROM trans_supply WHERE product='".$product."' AND status='valid'"));
	$d_order = mysql_fetch_row(mysql_query("SELECT SUM(amount) FROM trans_order WHERE product='".$product."' AND status='valid'"));
	$amount = $d_supply[0]-$d_order[0];
	return $amount;
}
//-----------------------------------------------------------------
//		product_stock_update
//-----------------------------------------------------------------
function product_stock_update($product){
	$stock = product_stock($product);
	$minstock = mysql_fetch_row(mysql_query("SELECT minstock FROM product WHERE id='".$product."'"));
	$percent = ($stock/$minstock[0])*100;
	mysql_query("UPDATE product SET stock='".$stock."',percent='".$percent."' WHERE id='".$product."'");
}
//-----------------------------------------------------------------
//		product_stock_delete
//-----------------------------------------------------------------
function product_stock_delete($id,$table,$type){
	$product = mysql_fetch_row(mysql_query("SELECT product FROM ".$table." WHERE id='".$id."'"));
	mysql_query("DELETE FROM transaction_history WHERE relation='".$id."' AND type='".$type."'") or die(mysql_error());
	mysql_query("DELETE FROM ".$table." WHERE id='".$id."'");
	product_stock_update($product[0]);
}
//-----------------------------------------------------------------
//		color_button
//-----------------------------------------------------------------
function color_button($link,$color,$label){
	$out = '<a href="'.$link.'">
	<div style="background-color:'.$color.';width:20px;height:20px;
		float:left;border:1px solid #BBB;margin-right:10px;">&nbsp;</div></a>
	<div style="margin-right:10px;float:left;margin-top:2px;">'.$label.'</div>';
	return $out;
}
//-----------------------------------------------------------------
//		color_button_box
//-----------------------------------------------------------------
function color_button_box($button=array()){
	$out = '<div style="text-align:left;padding:4px;border:1px solid #BBB;margin-top:5px;">';
	foreach($button AS $button1){
		$out .= $button1;
	}
	$out .= '<div style="clear:both;"></div></div>';
	return $out;
}
//-----------------------------------------------------------------
//		sub_info_list
//-----------------------------------------------------------------
function sub_info_list($label,$text){
	$out = '<div style="text-align:left;padding:4px;border:1px solid #BBB;margin:2px;">';
	$out .= '<div style="text-align:right;width:200px;float:left;margin-right:10px;"><b>'.$label.' :</b></div>';
	$out .= '<div style="width:700px;float:left;">'.$text.'</div>';
	$out .= '<div style="clear:both;"></div>';
	$out .= '</div>';
	return $out;
}
//-----------------------------------------------------------------
//		expire_distance
//-----------------------------------------------------------------
function expire_distance($time){
	$today = time();
	list($yy,$mm,$dd) = explode('-',$time);
	$expired = mktime(0,0,0,$mm,$dd,$yy);
	$distance = $expired-$today;
	if($distance<=604800){
		$alert = 'red';
	}elseif($distance>=604800 && $distance<=2678400){
		$alert = 'yellow';
	}else{
		$alert = null;
	}
	return $alert;
}
?>

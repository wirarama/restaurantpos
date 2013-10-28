<?
//-----------------------------------------------------------------
//		table output
//-----------------------------------------------------------------
function table_output($title,$content1,$content2,$head,$width,$link,$rows,$ids,$add_link=array(),
$search='none',$add_field=array(),$add_header=array(),$add_title=array(),$where_str=null,$disable_mod=null){
?>
	<div align="center">
	<div id="headtable" style="background-color:#bcd769;"><b><? echo $title; ?></b></div>
	<?
	//-----------------------------------------------------------------
	//	additional title if exist
	//-----------------------------------------------------------------
	if(count($add_title)!=0){
		foreach($add_title as $add_title1){
		echo $add_title1;
	}}
	if(!empty($link)){ 
	?>
	<div id="headtable" style="text-align:right;"><? echo $link; ?></div>
	<? } 
	//-----------------------------------------------------------------
	//	search procedure
	//-----------------------------------------------------------------
	if($search!='none' && !empty($search)){
	?>
		<div id="accordion" class="accordion">
			<a>Search : </a>
			<div>
		<?
		if($search=='general'){
			general_search();
		}elseif($search=='client'){
			client_search();
		}elseif($search=='vendor'){
			vendor_search();
		}elseif($search=='product'){
			product_search();
		}elseif($search=='supply'){
			supply_search();
		}elseif($search=='order'){
			order_search();
		}elseif($search=='discount'){
			discount_search();
		}elseif($search=='product_history'){
			product_history_search();
		}elseif($search=='creditcard'){
			creditcard_search();
		}elseif($search=='supply_chart'){
			supply_chart_search();
		}elseif($search=='order_chart'){
			order_chart_search();
		}
		?>
			</div>
		</div>
	<? }
	//-----------------------------------------------------------------
	//	additional header if exist
	//-----------------------------------------------------------------
	if(count($add_header)!=0){
		foreach($add_header as $add_header1){
	?>
	<div style="width:100%">
	<table border="0" cellspacing="1" width="100%">	
		<tr bgcolor="#CCCCCC">
		<? foreach($add_header1 as $add_header2){ ?>
			<td><b><? echo $add_header2; ?></b></td>
		<? } ?>
		</tr>
	</table>
	</div>
	<? }} ?>
	</div>
	<div style="width:100%">
	<table id="myTable" class="tablesorter" cellspacing="1" width="100%">
		<thead>
		<tr bgcolor="#CCCCCC">
			<?
			$i=0;
			foreach($head as $head1){
			?>
			<th width="<? echo $width[$i]; ?>"><b><? echo $head1; ?></b></th>
			<? $i++; } ?>
		</tr>
		</thead>
		<tbody>
		<?
		$i=0;
		$max=count($rows);
		while($i<$max){
			//----------------------------------------------------------------------
			//	set conditional background color
			//----------------------------------------------------------------------
			if($_GET['p']=='product_list'){ 
				if($rows[$i][9]<=30 && $rows[$i][7]!=0){
					$bg='style="background-color:#ff8f8f;"';
				}elseif(($rows[$i][9]>=30 && $rows[$i][9]<=50) && $rows[$i][7]!=0){
					$bg='style="background-color:#fff478;"';
				}else{
					$bg=null;
				}
				unset($rows[$i][9]);
			}elseif($_GET['p']=='supply_list'){ 
				if($rows[$i][7]=='red'){
					$bg='style="background-color:#ff8f8f;"';
				}elseif($rows[$i][7]=='yellow'){
					$bg='style="background-color:#fff478;"';
				}else{
					$bg=null;
				}
				unset($rows[$i][7]);
			}elseif($_GET['p']=='supply_chart_list'){ 
				if($rows[$i][4]=='valid'){
					$bg='style="background-color:#ffef41;"';
				}elseif($rows[$i][4]=='received'){
					$bg='style="background-color:#a9d033;"';
				}else{
					$bg=null;
				}
			}
		?>
		<tr>
			<?
			foreach($rows[$i] as $rows2){
			?>
			<td <? echo $bg; ?>><? echo $rows2; ?></td>
			<? } ?>
			<? 
			if(count($add_link)!=0){ 
				foreach($add_link as $add_link1){
				if(!empty($add_link1[2]) && !empty($add_link1[3])){
					$count_num = mysql_num_rows(mysql_query("SELECT id FROM ".$add_link1[2]." 
					WHERE ".$add_link1[3]."='".$ids[$i]."'"));
					$add_link1[1] = $add_link1[1].' <b>('.$count_num.')</b>';
				}
			if(($i%2)!=1){
				$bg_add_link = 'style="background-color:#f6ea9a;"';
			}else{
				$bg_add_link = 'style="background-color:#dbce74;"';
			}
			?>
			<td <? echo $bg_add_link; ?>><a href="<? echo $add_link1[0].$ids[$i]; ?>">
			<? echo $add_link1[1]; ?></a></td>
			<? }} ?>
			<?
			//--------------------------------------------------------------------
			//	special procedure link
			//--------------------------------------------------------------------
			if($_GET['p']=='creditcard_list'){
			$creditcard_message = 'Are You Sure to Confirm this Creditcard Payment?';
			$creditcard_link = 'index.php?p=creditcard_list&credircardid='.$ids[$i];
			?>
			<td><a href="#" onClick="confirm('<? echo $creditcard_message; ?>',function(){ window.location.href = '<? echo $creditcard_link; ?>'; })">Confirm</a></td>
			<?
			}elseif($_GET['p']=='reminder_list' && $title=='Unverified Credit Card Transaction'){
			$creditcard_message = 'Are You Sure to Confirm this Creditcard Payment?';
			$creditcard_link = 'index.php?p=reminder_list&credircardid='.$ids[$i];
			?>
			<td><a href="#" onClick="confirm('<? echo $creditcard_message; ?>',function(){ window.location.href = '<? echo $creditcard_link; ?>'; })">Confirm</a></td>
			<?
			}elseif($_GET['p']=='supply_chart_list'){
				?>
					<td><a href="index.php?p=supply_list&chart=<? echo $ids[$i]; ?>">Detail</a></td>
				<?
				if($rows[$i][4]=='input'){
					$supply_message = 'Set order status to be Valid?';
					$supply_link = 'index.php?p=supply_chart_list&validate='.$ids[$i];
					$supply_text = 'Validate';
				}elseif($rows[$i][4]=='valid'){
					$supply_message = 'Set order status to be Received?';
					$supply_link = 'index.php?p=supply_chart_list&received='.$ids[$i];
					$supply_text = 'Received';
				}
				if($rows[$i][4]=='input' || $rows[$i][4]=='valid'){
			?>
					<td><a href="#" onClick="confirm('<? echo $supply_message; ?>',function(){ window.location.href = '<? echo $supply_link; ?>'; })"><? echo $supply_text; ?></a></td>
			<?
				}
			}elseif($_GET['p']=='order_chart_list'){
				?>
				<td><a href="index.php?p=order_list&chart=<? echo $ids[$i]; ?>">Detail</a></td>
				<?
			}
			//--------------------------------------------------------------------
			//	Edit & Delete
			//--------------------------------------------------------------------
			if(empty($disable_mod)){
				if(!empty($content1)){
			?>
				<td><a href="<? echo $content1.$ids[$i]; ?>">Edit</a></td>
				<? } if(!empty($content2)){ ?>
				<td><a href="#" onClick="confirm('Are You Sure to Delete?',function(){ window.location.href = '<? echo $content2.$ids[$i]; ?>'; })">Del</a></td>
			<? }} ?>
		</tr>
		<? $i++; } ?>
		</tbody>
		<?
		//-----------------------------------------------------------------
		//	additional field if exist
		//-----------------------------------------------------------------
		if(count($add_field)!=0){
			foreach($add_field as $add_field1){
		?>
		<tfoot>
			<tr bgcolor="#CCCCCC">
			<? 
			$i = 0;
			foreach($add_field1 as $add_field2){ 
			?>
			<td width="<? echo $width[$i]; ?>"><b><? echo $add_field2; ?></b></td>
			<? $i++; } ?>
			</tr>
		</tfoot>
		<? }} ?>
	</table>
	</div>
	<div style="clear:both; margin-bottom:10px;"></div>
	<?
	if($_GET['p']!='reminder_list'){
		page_number();
	}
	?>
<?
}
//-----------------------------------------------------------------
//		page_number
//-----------------------------------------------------------------
function page_number(){
	?>
		<div id="pager" class="tablesorterPager">
			<form>
				<img src="css/icons/first.png" class="first"/>
				<img src="css/icons/prev.png" class="prev"/>
				<input type="text" class="pagedisplay" size="5" 
				style="text-align:center;" readonly="readonly" />
				<img src="css/icons/next.png" class="next"/>
				<img src="css/icons/last.png" class="last"/>
				<select class="pagesize" style="min-width:50px;">
					<option selected="selected" value="10">10</option>
					<option value="20">20</option>
					<option value="30">30</option>
					<option value="40">40</option>
				</select>
			</form>
		</div>	
	<?
}
//-----------------------------------------------------------------
//		add page str
//-----------------------------------------------------------------
function add_page_str($where_str=null){
	$add_page_str = '';
	if(isset($_GET['product'])){
		$add_page_str .= '&product='.$_GET['product'];
	}
	if(isset($_GET['orderchart'])){
		$add_page_str .= '&orderchart='.$_GET['orderchart'];
	}
	if(isset($_GET['type'])){
		$add_page_str .= '&type='.$_GET['type'];
	}
	if(isset($_GET['category'])){
		$add_page_str .= '&category='.$_GET['category'];
	}
	if(!empty($where_str)){
		$add_page_str .= '&where_str='.$where_str;
	}
	return $add_page_str;
}
//-----------------------------------------------------------------
//		general search
//-----------------------------------------------------------------
function general_search(){
?>
<form action="" method="POST" style="margin:0px;">
	<input type="text" name="find" value="<? echo $_POST['find'] ?>" size="40" maxlength="60">
	&nbsp; <input type="submit" value="find" name="find_button">
</form>
<?
}
//-----------------------------------------------------------------
//		table output product
//-----------------------------------------------------------------
function table_output_product($id,$title,$cols_header,$rows_header,$value,$price_header=array(),$price_value=array(),$bottom_link=null){
?>
	<div align="center">
	<table border="0" cellspacing="1" cellpadding="4" width="90%" bgcolor="#FFFFFF">
		<tr>
			<td style="background-color:#254ea2; color:#FFFFFF; text-align:center;"><b><? echo $title; ?></b></td>
			<?
			$i = 0;
			foreach($cols_header as $cols_header1){
				if(($i%2)==1){
					$bg = 'style="background-color:#254ea2; color:#FFFFFF;"';
				}else{
					$bg = 'style="background-color:#607ebc; color:#FFFFFF;"';
				}
			?>
			<td <? echo $bg; ?> align="center"><b><? echo $cols_header1; ?></b></td>
			<? $i++; } ?>
		</tr>
		<?
		//-------------------------------------------------------------------
		//	product values
		//-------------------------------------------------------------------
		$i = 0;
		foreach($rows_header as $rows_header1){
			if(($i%2)==1){
				$bgr = 'style="background-color:#AAAAAA;"';
			}else{
				$bgr = 'style="background-color:#CCCCCC;"';
			}
		?>
		<tr>
			<td <? echo $bgr; ?>><b><? echo $rows_header1; ?></b></td>
		<?
			$j = 0;
			foreach($value[$i] as $value1){
				if(($j%2)==1){
					if(($i%2)==1){
						$bg = 'style="background-color:#9fd2f3;"';
					}else{
						$bg = 'style="background-color:#d5edfd;"';
					}
				}else{
					if(($i%2)==1){
						$bg = 'style="background-color:#DDDDDD;"';
					}else{
						$bg = 'style="background-color:#FFFFFF;"';
					}
				}
		?>
			<td <? echo $bg; ?> align="center"><? echo $value1; ?></td>
		<?
			$j++;
			}
		?>
		</tr>
		<?
		$i++;
		}
		?>
		<?
		//-------------------------------------------------------------------
		//	price if available
		//-------------------------------------------------------------------
		if(count($price_header)!=0){
		?>
			<tr>
				<td colspan="100%" style="background-color:#a2c1ff; text-align:center;"><b>Price List</b></td>
			</tr>
		<?
			$i = 0;
			foreach($price_header as $price_header1){
				if(($i%2)==1){
					$bgr = 'style="background-color:#AAAAAA;"';
				}else{
					$bgr = 'style="background-color:#CCCCCC;"';
				}
			?>
			<tr>
				<td <? echo $bgr; ?>><b><? echo $price_header1; ?></b></td>
			<?
				$j = 0;
				foreach($price_value[$i] as $price_value1){
					if(($j%2)==1){
						if(($i%2)==1){
							$bg = 'style="background-color:#9fd2f3;"';
						}else{
							$bg = 'style="background-color:#d5edfd;"';
						}
					}else{
						if(($i%2)==1){
							$bg = 'style="background-color:#DDDDDD;"';
						}else{
							$bg = 'style="background-color:#FFFFFF;"';
						}
					}
			?>
				<td <? echo $bg; ?> align="center"><? echo $price_value1; ?></td>
			<?
				$j++;
				}
			?>
			</tr>
			<?
			$i++;
			}
		}
		//-------------------------------------------------------------------
		//	button link if available
		//-------------------------------------------------------------------
		if(!empty($bottom_link)){
		?>
		<tr>
			<td style="background-color:#678fe1;">&nbsp;</td>
		<?
		$total_cols = count($cols_header);
		for($i=0;$i<$total_cols;$i++){
			if(($i%2)==1){
				$bg = '#678fe1';
			}else{
				$bg = '#a2c1ff';
			}
		?>
			<td style="background-color:<? echo $bg; ?>; text-align:center;">
			<div class="order">
			<a href="index.php?p=product_order&product_order=<? echo $id[$i]; ?>"><b><? echo $bottom_link; ?></b></a>
			</div>
			</td>
		<? } ?>
		</tr>
		<? } ?>
	</table>
	</div>
<?
}
?>

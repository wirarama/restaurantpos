<?
//-----------------------------------------------------------------
//		form header
//-----------------------------------------------------------------
function form_header($text){
?>
	<div id="formcols1">
		<div id="formhead"><? echo $text; ?></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form back
//-----------------------------------------------------------------
function form_back($link,$text){
?>
	<div>
		<div id="field"><a href="<? echo $link; ?>">
		&laquo; Back to <? echo $text; ?> List
		</a></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form back
//-----------------------------------------------------------------
function form_plain($text){
?>
	<div id="formcols1">
		<div id="formback"><? echo $text; ?></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form plain text
//-----------------------------------------------------------------
function form_plain_text($text){
?>
	<div>
		<div id="label" style="background-color:#DDD;"><? echo $text; ?> : </div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form checkbox multiple
//-----------------------------------------------------------------
function form_checkbox_multiple($label,$data=array(),$dataname=array(),$value=null){
	if(!empty($value)){
		$value1 = explode(';',$value);
	}
?>
	<div>
		<div id="label"><? echo $label; ?> : </div>
		<div id="field">
		<?
		$i=0;
		foreach($data AS $data1){
			$dataname[$i] = str_replace(' ','_',$dataname[$i]);
			$postname = $dataname[$i];
			if(!empty($_POST[$postname]) || (!empty($value1[$i]) && $value1[$i]!='-')){
				$checked = 'checked';
			}else{
				$checked = null;
			}
		?>
			<div><input type="checkbox" name="<? echo $dataname[$i]; ?>" value="<? echo $dataname[$i]; ?>" <? echo $checked; ?>>
			&nbsp;<? echo $data[$i]; ?></div>
		<?
			$i++;
		}
		?>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form textfield
//-----------------------------------------------------------------
function form_text($label,$name,$value=null,$size=60,$maxlength=255,$note=null){
?>
	<div>
		<div id="label"><? echo $label; ?> : </div>
		<div id="field">
		<input type="text" name="<? echo $name; ?>" size="<? echo $size; ?>" maxlength="<? echo $maxlength; ?>" value="<? echo $value; ?>">
		<BR><? echo $note; ?>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form text only
//-----------------------------------------------------------------
function form_text_only($label,$value){
?>
	<div>
		<div id="label"><? echo $label; ?> : </div>
		<div id="field"><? echo $value; ?></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form checkbox
//-----------------------------------------------------------------
function form_checkbox($label,$name,$value,$checked=null,$submit=null){
?>
	<div id="formcols1">
		<div id="formback"><? echo $label; ?> : 
		<input type="checkbox" name="<? echo $name; ?>" value="<? echo $value; ?>" <? echo $submit; ?> <? echo $checked; ?>></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form password
//-----------------------------------------------------------------
function form_password($label,$name,$value=null,$size=60,$maxlength=255,$note=null){
?>
	<div>
		<div id="label"><? echo $label; ?> : </div>
		<div id="field">
		<input type="password" name="<? echo $name; ?>" size="<? echo $size; ?>" maxlength="<? echo $maxlength; ?>" value="<? echo $value; ?>">
		<BR><? echo $note; ?>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form textarea
//-----------------------------------------------------------------
function form_textarea($label,$name,$h,$value=null,$note=null){
?>
	<div>
		<div id="label"><? echo $label; ?> : </div>
		<div id="field">
		<textarea name="<? echo $name; ?>" style="height:<? echo $h; ?>px;"><? echo $value; ?></textarea>
		<BR><? echo $note; ?>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form submit
//-----------------------------------------------------------------
function form_submit($label,$name){
?>
	<div>
		<div id="label"><input type="submit" name="<? echo $name; ?>" value="<? echo $label; ?>"></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form submit search
//-----------------------------------------------------------------
function form_submit_search($label,$name){
?>
	<div>
		<div id="label">&nbsp;</div>
		<div id="field"><input type="submit" name="<? echo $name; ?>" value="<? echo $label; ?>"></div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form hidden
//-----------------------------------------------------------------
function form_hidden($name,$value){
?>
	<input type="hidden" name="<? echo $name; ?>" value="<? echo $value; ?>">
<?
}
//-----------------------------------------------------------------
//		form select db
//-----------------------------------------------------------------
function form_select_db($label,$name,$field,$value=null,$submit=null,$except=null){
?>
	<div>
		<div id="label"<?=$style1;?>><? echo $label; ?> : </div>
		<div id="field"<?=$style2;?>>
		<select name="<? echo $name; ?>" <? echo $submit; ?>>
			<option value=""></option>
			<?
			$query = mysql_query("SELECT id,".$field." FROM ".$name." ".$except." ORDER BY id");
			while($data = mysql_fetch_array($query)){
				if($data['id']==$value){
					$selected = 'selected';
				}else{
					$selected = null;
				}
			?>
				<option value="<? echo $data[id]; ?>" <? echo $selected; ?>>
				<? echo $data[$field]; ?></option>
			<? } ?>
		</select>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form select array
//-----------------------------------------------------------------
function form_select_array($label,$name,$list_id,$list_value,$value=null,$submit=null){
?>
	<div>
		<div id="label"><? echo $label; ?> : </div>
		<div id="field">
		<select name="<? echo $name; ?>" <? echo $submit; ?>>
			<option value=""></option>
			<?
			$i=0;
			foreach($list_id as $list1){
				if($list1==$value){
					$selected = 'selected';
				}else{
					$selected = null;
				}
			?>
				<option value="<? echo $list1; ?>" <? echo $selected; ?>>
				<? echo $list_value[$i]; ?></option>
			<? $i++; } ?>
		</select>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form file
//-----------------------------------------------------------------
function form_file($label,$name,$value=null,$note=null){
?>
	<div>
		<div id="label"><? echo $label; ?> : </div>
		<div id="field">
		<input name="<? echo $name; ?>" type="file" size="40" value="<? echo $value; ?>">
		<BR><? echo $note; ?>
		</div>
	</div>
<?
}
//-----------------------------------------------------------------
//		form date
//-----------------------------------------------------------------
function form_date($label,$name,$date=null,$note=null){
?>
<div id="formcols">
	<div id="label"><? echo $label; ?> : </div>
	<div id="field"><? form_date_field($label,$name,$date,$note); ?></div>
</div>
<?
}
//-----------------------------------------------------------------
//		form date search
//-----------------------------------------------------------------
function form_date_search($label,$name,$date=null,$note=null){
?>
<div id="formcols">
	<div id="label"><? echo $label; ?> : </div>
	<div id="field"><? form_date_field($label,$name,$date,$note); ?></div>
</div>
<?
}
//-----------------------------------------------------------------
//		form date field
//-----------------------------------------------------------------
function form_date_field($label,$name,$date=null,$note=null){
	global $enable_submit,$enable_time;
	if(in_array($_GET['p'],$enable_submit)){
		$submit = 'onchange="submit()"';
	}else{ $submit = null; }
	//----------------------
	$year_str = 'y'.$name;
	$_POST[$year_str] = $yy;
	//----------------------
	if(!empty($date)){
		list($yy,$mm,$dd) = explode('-',$date);
	}else{
		$year_str = 'y'.$name;
		$yy = $_POST[$year_str];
		if(!empty($_GET[$year_str])) $yy = $_GET[$year_str];
		$month_str = 'm'.$name;
		$mm = $_POST[$month_str];
		if(!empty($_GET[$month_str])) $mm = $_GET[$month_str];
		$date_str = 'd'.$name;
		$dd = $_POST[$date_str];
		if(!empty($_GET[$date_str])) $dd = $_GET[$date_str];
		if(!preg_match('/list/',$_GET['p'])){
			if(empty($yy)) $yy = date('Y');
			if(empty($mm)) $mm = date('m');
			if(empty($dd)) $dd = date('d');
		}
	}
?>
	<select name="d<? echo $name; ?>" style="min-width:60px;" <?=$submit;?>>
		<option value="">day</option>
	<?
	for($i=1;$i<=31;$i++){
		if($i == $dd){
			$selected = 'selected';
		}else{
			$selected = null;
		}
	?>
		<option value="<? echo $i; ?>" <? echo $selected; ?>><? echo $i; ?></option>
	<? } ?>
	</select>
	<!-- Month -->
	<select name="m<? echo $name; ?>" style="min-width:80px;" <?=$submit;?>>
		<option value="">month</option>
	<?
	for($i=1;$i<=12;$i++){
		if($i == $mm){
			$selected = 'selected';
		}else{
			$selected = null;
		}
	?>
		<option value="<? echo $i; ?>" <? echo $selected; ?>><? echo $i; ?></option>
	<? } ?>
	</select>
	<!-- Year -->
	<select name="y<? echo $name; ?>" style="min-width:80px;" <?=$submit;?>>
		<option value="">year</option>
	<?
	$y = date('Y')-2; //tahun sekarang
	$yn = $y+4; //4 tahun kemudian
	for($i=$y;$i<=$yn;$i++){
		if($i == $yy){
			$selected = 'selected';
		}else{
			$selected = null;
		}
	?>
		<option value="<? echo $i; ?>" <? echo $selected; ?>><? echo $i; ?></option>
	<? } ?>
	</select>
	<? echo '&nbsp;&nbsp;'.$note; ?>
<?
}
//-----------------------------------------------------------------
//		INPUT VERIFICATION
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//		post verification
//-----------------------------------------------------------------
function post_verify($label,$value){
	if(empty($value)){
		return '<font style="color:#883636">'.$label.' cannot be empty!</font>';
	}else{
		return null;
	}
}
//-----------------------------------------------------------------
//		exist verification
//-----------------------------------------------------------------
function exist_verify($label,$table_name,$field_name,$value,$except=null){
	$exist = mysql_num_rows(mysql_query("SELECT ".$field_name." FROM ".$table_name." 
	WHERE ".$field_name."='".$value."' AND id!='".$except."'"));
	if($exist!=0){
		return '<font style="color:#883636">'.$label.' <b>'.$value.'</b> already exist!</font>';
	}else{
		return null;
	}
}
//-----------------------------------------------------------------
//		same verification
//-----------------------------------------------------------------
function same_verify($label,$value1,$value2){
	if($value1!=$value2){
		return '<font style="color:#883636">'.$label.' is not same with confirmation!</font>';
	}else{
		return null;
	}
}
//-----------------------------------------------------------------
//		mail verification
//-----------------------------------------------------------------
function mail_verify($label,$value){
	if(!empty($value)){
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$value)){
			return '<font style="color:#883636">'.$label.' is not valid e-mail format!</font>';
		}else{
			return null;
		}
	}
}
//-----------------------------------------------------------------
//		number verification
//-----------------------------------------------------------------
function number_verify($label,$value){
	if(!empty($value)){
		if(!eregi("[0-9]",$value)){
			return '<font style="color:#883636">'.$label.' is only allowed for number <i>(0 to 9)</i>!</font>';
		}else{
			return null;
		}
	}
}
//-----------------------------------------------------------------
//		multi_checkbox_handler
//-----------------------------------------------------------------
function multi_checkbox_handler($data){
	$input = array();
	foreach($data AS $data1){
		$data2 = str_replace(' ','_',$data1);
		if(!empty($_POST[$data2])){
			array_push($input,$_POST[$data2]);
		}else{
			array_push($input,'-');
		}
	}
	$input1 = implode(';',$input);
	return $input1;
}
?>

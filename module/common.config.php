<?
//-----------------------------------------------------------------
//		FORM INTERFACE
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//		variabel umum
//-----------------------------------------------------------------
$zebra = 'style="background-color:#EEEEEE"';
$zebra1 = 'style="background-color:#FFFFFF"';
$must = '<span style="color:#883636">*</span>';
$error_pettern = 'style="background-color:#883636"';
$date_format = "DATE_FORMAT(date,'%d %M %Y %h:%i') AS datef";
$enable_submit = array('reservation_add','reservation_edit');
$enable_time = array();
$page=20;
//-----------------------------------------------------------------
//		login verification
//-----------------------------------------------------------------
function login_verify(){
	if(!empty($_COOKIE['login'])){
		$logged = mysql_num_rows(mysql_query("SELECT id FROM login 
		WHERE admin_id='".$_COOKIE['login']."'"));
		if($logged==0){
			mysql_query("DELETE FROM login 
			WHERE admin_id='".$_COOKIE['login']."'");
			setcookie('login','');
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}
//-----------------------------------------------------------------
//		auto_number
//-----------------------------------------------------------------
function auto_number($table){
	$ln = mysql_fetch_row(mysql_query("SELECT MAX(id) AS id FROM ".$table));
	return $ln[0]+1;
}
?>

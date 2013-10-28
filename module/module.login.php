<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_login_list
//-----------------------------------------------------------------
function head_login_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM login WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=login_list');
	}
}
//-----------------------------------------------------------------
//	head_login
//-----------------------------------------------------------------
function head_login(){
	if(isset($_POST['login'])){
		//varifikasi input
		$username_error = post_verify('Username',$_POST['username']);
		$password_error = post_verify('Password',$_POST['password']);
		//error umum
		$error_umum = '<font style="color:#883636">Username or Password is not Valid!</font>';
		//query input
		if(empty($username_error) & empty($password_error)){
			$valid = mysql_fetch_array(mysql_query("SELECT id,type FROM admin 
			WHERE username='".$_POST['username']."' 
			AND password=MD5('".$_POST['password']."')"));
			if(!empty($valid['id'])){
				mysql_query("INSERT INTO login 
				VALUES(null,'".$valid['id']."','".$_SERVER['REMOTE_ADDR']."',null)") 
				or die(mysql_error());
				setcookie('login',$valid['id']);
				setcookie('type',$valid['type']);
				header('location:index.php');
			}else{
				return $error_umum;
			}
		}else{
			return $error_umum;
		}
	}
}
//-----------------------------------------------------------------
//	head_logout
//-----------------------------------------------------------------
function head_logout(){
	mysql_query("DELETE FROM login WHERE admin_id='".$_COOKIE['login']."'");
	setcookie('login','');
	header('location:index.php');
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_login
//-----------------------------------------------------------------
function main_login(){
	global $out;
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Login');
	if(!empty($out)){
		form_plain($out);
	}
	form_text('Username','username',$_POST['username'],40,40,$username_error);
	form_password('Password','password',$_POST['password'],20,20,$password_error);
	form_submit('Login','login',$zebra);
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_logout
//-----------------------------------------------------------------
function main_logout(){
}
//-----------------------------------------------------------------
//	main_login_list
//-----------------------------------------------------------------
function main_login_list(){
	global $date_format;
	$title = 'Login List';
	$head = array('Username','From Date','IP');
	$width = array('40%','30%','30%');
	$content2 = 'index.php?p=login_list&delete=';
	$rows = array();
	$ids = array();
	$q = mysql_query("SELECT *,".$date_format." FROM login ORDER BY id DESC");
	while($data = mysql_fetch_array($q)){
		$username = mysql_fetch_row(mysql_query("SELECT username 
		FROM admin WHERE id='".$data['admin_id']."'"));
		$d = array($username[0],$data['datef'],$data['ip']);
		array_push($rows,$d);
		array_push($ids,$data['id']);
	}
	table_output($title,$content1,$content2,$head,$width,$link,$rows,$ids,null,'none');
}
?>

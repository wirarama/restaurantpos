<?
//-----------------------------------------------------------------
//	HEAD
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	head_admin_list
//-----------------------------------------------------------------
function head_admin_list(){
	if(isset($_GET['delete'])){
		mysql_query("DELETE FROM admin WHERE id='".$_GET['delete']."'");
		header('location:index.php?p=admin_list');
	}
}
//-----------------------------------------------------------------
//	head_admin_add
//-----------------------------------------------------------------
function head_admin_add(){
	if(isset($_POST['add'])){
		$no = auto_number('admin');
		mysql_query("INSERT INTO admin 
		VALUES('".$no."','".$_POST['name']."',MD5('".$_POST['password']."'),
		'".$_POST['type']."',null,'".$_COOKIE['login']."')");
		header('location:index.php?p=admin_list');
	}
}
//-----------------------------------------------------------------
//	head_admin_edit
//-----------------------------------------------------------------
function head_admin_edit(){
	if(isset($_POST['edit_send'])){
		mysql_query("UPDATE admin SET 
		password=MD5('".$_POST['password']."'),type='".$_POST['type']."' 
		WHERE id='".$_POST['edit']."'") or die(mysql_error());
		header('location:index.php?p=admin_list');
	}
}
//-----------------------------------------------------------------
//	MAIN
//-----------------------------------------------------------------
//-----------------------------------------------------------------
//	main_admin_list
//-----------------------------------------------------------------
function main_admin_list(){
	$title = 'User List';
	$head = array('User Name','Type');
	$width = array('70%','30%');
	if($_COOKIE['type']=='admin') $link = '<a href="index.php?p=admin_add">Add New User &raquo;</a>';
	$content1 = 'index.php?p=admin_edit&edit=';
	if($_COOKIE['type']=='admin') $content2 = 'index.php?p=admin_list&delete=';
	list($rows,$ids,$where) = admin_data();
	table_output($title,$content1,$content2,$head,$width,$link,$rows,$ids);
}
//-----------------------------------------------------------------
//	admin_data
//-----------------------------------------------------------------
function admin_data(){
	if($_COOKIE['type']=='admin'){
		$q = mysql_query("SELECT username,type,id FROM admin ORDER BY username DESC");
	}else{
		$q = mysql_query("SELECT username,type,id FROM admin WHERE id='".$_COOKIE['login']."'");
	}
	$rows = array();
	$ids = array();
	while($data = mysql_fetch_array($q)){
		$d = array($data[0],$data[1]);
		array_push($rows,$d);
		array_push($ids,$data[2]);
	}
	$out = array($rows,$ids,$where);
	return $out;
}
//-----------------------------------------------------------------
//	main_admin_add
//-----------------------------------------------------------------
function main_admin_add(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	form_header('Add New User');
	form_back('index.php?p=admin_list','User');
	form_text('User Name','name',$_POST['name'],40,255);
	form_password('Password','password',$_POST['password'],40,255);
	form_password('Password Confirm','password_confirm',$_POST['password_confirm'],40,255);
	$type = array('admin','user');
	form_select_array('Type','type',$type,$type,$_POST['type']);
	form_submit('Add','add');
	?>
	</div>
	</form>
<?
}
//-----------------------------------------------------------------
//	main_admin_edit
//-----------------------------------------------------------------
function main_admin_edit(){
?>
	<form action="" method="POST">
	<div id="formborder">
	<?
	$data = mysql_fetch_array(mysql_query("SELECT * FROM admin WHERE id='".$_GET['edit']."'"));
	form_header('Edit User');
	form_back('index.php?p=admin_list','User');
	form_hidden('edit',$_GET['edit']);
	form_password('Password','password','',40,255);
	form_password('Password Confirm','password_confirm','',40,255);
	$type = array('admin','user');
	form_select_array('Type','type',$type,$type,$data['type']);
	form_submit('Edit','edit_send');
	?>
	</div>
	</form>
<?
}
?>

<?
//---------------------------------------------------------------
//	task list
//---------------------------------------------------------------
function task_list($addquery=null){
	$q = mysql_query("SELECT a.title,a.start,a.stop,b.name,c.name,d.name,
	a.description,a.status,a.priority,a.id FROM 
	task AS a,client AS b,category AS c,subject AS d 
	WHERE a.client=b.id AND a.category=c.id AND a.subject=d.id ".$addquery." 
	ORDER BY a.start DESC,a.stop ASC") or die(mysql_error());
	while($d = mysql_fetch_row($q)){
		$sl = staff_list($d[9]);
		$data = array($d[0],$d[1],$d[2],$sl,$d[3],$d[4],$d[5],$d[6],$d[7],$d[8]);
		task_style($data);
	}
}
//---------------------------------------------------------------
//	task style
//---------------------------------------------------------------
function task_style($d){
	if($d[9]=='1'){
		$color = '#ffadad';
	}elseif($d[9]=='2'){
		$color = '#eacd57';
	}elseif($d[9]=='3'){
		$color = '#badb7b';
	}
	$priority = 'style="background-color:'.$color.';"';
	$zebra = 'style="background-color:#DDD;"';
	echo '<div id="taskbox">';
	echo '<h3 '.$priority.'>'.$d[0].'</h3>';
	echo '<div id="taskcolomn">';
	task_row('Time :',$d[1].' to '.$d[2]);
	task_row('Assigned To :',$d[3]);
	task_row('Client :',$d[4]);
	echo '</div><div>';
	task_row('Category :',$d[5],$zebra);
	task_row('Subject :',$d[6]);
	task_row('Status :',$d[8],$zebra);
	echo '</div>';
	task_row('Description :',$d[7]);
	echo '</div>';
}
//---------------------------------------------------------------
//	task row
//---------------------------------------------------------------
function task_row($l,$v,$z=null){
?>
<div id="taskrow" <?=$z;?>>
	<div id="tasklabel"><?=$l;?></div>
	<div id="taskvalue"><?=$v;?></div>
</div>
<?
}
?>

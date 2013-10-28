<?
mysql_connect('localhost','admin','dallas99');
mysql_select_db('uno');
$file = "creditcard";
$read = fopen($file,'r') or die("gagal gan");
$data = fread($read,filesize($file));
$data1 = explode("\n",$data);
$categ = 0;
foreach($data1 AS $data2){
	if(!empty($data2)){
		$data2 = addslashes($data2);
		if(preg_match('/ - /',$data2)){
			list($code,$description) = explode(' - ',$data2);
			mysql_query("INSERT INTO creditcard_id VALUES(null,'".$code."','".
			$description."','".$categ."')") or die(mysql_error());
		}else{
			$ln = mysql_fetch_row(mysql_query("SELECT MAX(id) AS id FROM creditcard_category"));
			$no = $ln[0]+1;
			mysql_query("INSERT INTO creditcard_category VALUES('".
			$no."','".$data2."')") or die(mysql_error());
			$categ = $no;
		}
	}
}
?>

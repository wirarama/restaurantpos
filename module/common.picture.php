<?
//----------------------------------------------------------------
//		insert_pictures
//----------------------------------------------------------------
function insert_pictures($c,$no){
	if(!empty($_FILES['pictures']['name'])){
		if(!empty($_GET['edit'])) delete_pictures($c,$no);
		$lsrc = 'content/images/img/';
		$lth = 'content/images/thumb/';
		$src = $lsrc.$_FILES['pictures']['name'];
		$th = $lth.$_FILES['pictures']['name'];
		list($d,$d1) = image_validation($_FILES['pictures']['type'],
		$_FILES['pictures']['tmp_name']);
		if(!@move_uploaded_file($_FILES['pictures']['tmp_name'],$src)) 
		die('Pictures Failed to Upload');
		$new_name = $c.$no.'.jpg';
		thumbnails($src,$th,$d1,'100','40','1');
		rename($th,$lth.$new_name);
		thumbnails($src,$src,$d,'400','60');
		rename($src,$lsrc.$new_name);
		if($c!='picture'){
			mysql_query("UPDATE ".$c." SET picture='".$new_name."' WHERE id='".$no."'") 
			or die(mysql_error());
		}else{
			if(!empty($_GET['edit'])){
				mysql_query("UPDATE picture SET name='".$_POST['name']."',picture='".$new_name."', 
				description='".$_POST['description']."' WHERE id='".$_GET['edit']."'") 
				or die(mysql_error());
			}else{
				mysql_query("INSERT INTO picture VALUES(null,'".$_POST['name']."',
				'".$_POST['content']."','".$new_name."','".$_POST['description']."')") 
				or die(mysql_error());
			}
		}
	}
}
//----------------------------------------------------------------
//		delete_pictures
//----------------------------------------------------------------
function delete_pictures($c,$no){
	$q = mysql_query("SELECT picture FROM ".$c." WHERE id='".$no."'");
	$lsrc = 'content/images/img/';
	$lth = 'content/images/thumb/';
	if(!empty($d[0])){
		if(file_exists($lsrc.$d[0])){
			unlink($lsrc.$d[0]);
			unlink($lth.$d[0]);
		}
	}
}
//----------------------------------------------------------------
//		thumbsnails
//----------------------------------------------------------------
function thumbnails($img_src,$img_th,$thumb_on,$thumb_size,$quality,$crop=null){
	$img_size = GetImageSize($img_src);
	$img_in = ImageCreateFromJPEG($img_src);
	if($thumb_on == 'y'){
		$img_x = ($thumb_size/$img_size[1])*$img_size[0];
		$img_y = $thumb_size;
	}else{
		$img_y = ($thumb_size/$img_size[0])*$img_size[1];
		$img_x = $thumb_size;
	}
	$img_out = ImageCreateTrueColor($img_x, $img_y);
	ImageCopyResampled($img_out,$img_in,0,0,0,0,$img_x,$img_y,$img_size[0],$img_size[1]);
	ImageJPEG($img_out,$img_th,$quality);
	ImageDestroy($img_out);
	ImageDestroy($img_in);
	if(!empty($crop)){
		crop($thumb_size,$thumb_size,$img_th);
	}
}
//----------------------------------------------------------------------------------------------
//		crop
//----------------------------------------------------------------------------------------------
function crop($h,$w,$filename){
	$gambar = imagecreatefromjpeg($filename); 
	$crop = imagecreatetruecolor($w,$h);
	imagecopy($crop,$gambar,0,0,0,0,$w,$h);
	ImageJPEG($crop,$filename,70);
}
//----------------------------------------------------------------
//		image validation
//----------------------------------------------------------------
function image_validation($type,$img){
	if(!ereg('jpeg',$type)) exit('Please Upload <B>JPEG</B> Format only');
	list($w,$h) = getimagesize($img);
	if($w > $h){
		$d = 'x';
		$d1 = 'y';
	}else{
		$d = 'y';
		$d1 = 'x';
	}
	$out = array($d,$d1);
	return $out;
}
?>

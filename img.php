<?
//header("Content-type: image/jpeg");
$img=$_GET["img"];
$img_name=end(explode("/",$img));
$img_type=strtolower(end(explode(".",$img_name)));
$width=$_GET["width"]; //*** Fix Width & Heigh (Autu caculate) ***//
$height=$_GET["height"];

$size=GetimageSize($img);
if($height==""){
$height=round($width*$size[1]/$size[0]);
}


if($img_type=="jpg" or $img_type=="jpeg"){
	$images_orig = ImageCreateFromJPEG($img);
}
else if($img_type=="gif"){
	$images_orig = ImageCreateFromGIF($img);
}
else if($img_type=="png"){
	$images_orig = ImageCreateFromPNG($img);
}
else{
	exit;
}

$photoX = ImagesX($images_orig);
$photoY = ImagesY($images_orig);
$images_fin = ImageCreateTrueColor($width, $height);
ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);

if($img_type=="jpg" or $img_type=="jpeg"){
	ImageJPEG($images_fin);
}
else if($img_type=="gif"){
	ImageGIF($images_fin);
}
else if($img_type=="png"){
	ImagePNG($images_fin);
}

ImageDestroy($images_orig);
ImageDestroy($images_fin);

?>
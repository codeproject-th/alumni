<?php
class img{
	public function addGDLogoLicense($filename="",$logoLicense=""){
		$x = 0;
     	$y = 0;
     	$fileName = $filename;
		$fileName_type_arr = explode('.',$fileName);
		$fileName_type = end($fileName_type_arr);
		$fileName_type = strtolower($fileName_type);
		if($fileName_type == 'jpg' || $fileName_type == 'jpeg'){
			$img = imagecreatefromJpeg($fileName);
		}else if($fileName_type == 'gif'){
			$img = imagecreatefromgif($fileName);
		}else if($fileName_type == 'png'){
			$img = imagecreatefrompng($fileName);
		}
		
		
		
		list($imgW,$imgH) = getimagesize($fileName);
     	$dimgW = $imgW/2; 
     	$dimgH = $imgH/2;
     	
     	$fileLogo = $logoLicense;
     	list($logoW,$logoH) = getimagesize($fileLogo) ;
     	$dlogoW = $logoW/2; 
     	$dlogoH = $logoH/2;
     	$x = $dimgW-$dlogoW;
     	$y = $dimgH-$dlogoH;
		$y = $imgH-200;
		$logo = imagecreatefrompng($fileLogo);
		
     	imagecolortransparent($logo,ImageColorAt($logo, 0, 0));
		imagecopymerge($img, $logo,$x,$y,0,0,$logoW,$logoH,100);
		
		if($fileName_type == 'jpg' || $fileName_type == 'jpeg'){
     		imageJpeg($img,$filename,95);
		}else if($fileName_type == 'gif'){
     		imagegif($img,$filename,95);
		}else if($fileName_type == 'png'){
			//imagesavealpha($img, true);
     		imagepng($img,$filename,95);
		}
     	
     	imagedestroy($img);
     	imagedestroy($logo);
	}
}

?>
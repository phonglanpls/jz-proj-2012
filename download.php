<?php
session_start();
 
ini_set("memory_limit","128M");
 
$id = isset( $_GET['id'] ) ? $_GET['id']:0;
 
if(!isset($_SESSION['file'][$id])){
	exit;
}else{
	$array = $_SESSION['file'][$id];
	$filename = $array['name'];
	$filepath = $array['link'];
	//unset($_SESSION['file'][$id]);
	//echo $filepath;
	//file_put_contents($filepath);
	  
	 // get file size
	// $fsize = filesize($filepath);
	// echo  $fsize;
	$ch = curl_init($filepath);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $data = curl_exec($ch);
    curl_close($ch);

    if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
        // Contains file size in bytes
        $fsize = (int)$matches[1];
    }

	 // set headers
	 header("Pragma: public");
	 header("Expires: 0");
	 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	 header("Cache-Control: public");
	 header("Content-Description: File Transfer");
	 header('Content-Type: application/octet-stream');  //application/octet-stream
	 header('Content-Disposition: attachment; filename="' . $filename . '"');
	 header("Content-Transfer-Encoding: binary");
	 header("Content-Length: " . $fsize);
	 
	 // start downloading from here
	 $file = @fopen($filepath,"rb");
	 if ($file) {
	   while(!feof($file)) {
	   print(fread($file, 8388608));//1024*1024*8
	   flush();
		 if (connection_status()!=0) {
			 @fclose($file);
			 die();
		 }
	   }
	   @fclose($file);
	 }
	 
/*	
	ob_clean();
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"".$array['name']."\"");
	readfile($array['link']);
	
	 header("Cache-Control: public");
	 header("Content-Description: File Transfer");
	 header("Content-Disposition: attachment; filename=".$array['name']);
	 header("Content-Type: video/mpeg");
	 header("Content-Transfer-Encoding: binary");
	 readfile($array['link']);

	header('Pragma: public');   // required
	header('Expires: 0');    // no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($filepath)).' GMT');
	header('Cache-Control: private',false);
	header('Content-Type: octet/stream');
	header('Content-Disposition: attachment; filename="'.basename($filename).'"');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: '.filesize($filepath));  // provide file size
	header('Connection: close');
	readfile($filepath);    // push it out
	*/	
}

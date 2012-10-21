<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Module_helper{
	var $CI;
	var $current_dbprefix = "";
	
	public function __construct( ){
		$this->CI =& get_instance();
		$this->current_dbprefix = $this->CI->db->dbprefix;
		$this->CI->db->set_dbprefix('default_');
	}
	public function __destruct() {
		$this->CI->db->set_dbprefix($this->current_dbprefix);
	}
	
	public function getTokenId($seed = ''){
		$seed = ( $seed )? $seed : rand(0,time());
		$tokenID = uniqid($seed,true);
		return md5($tokenID);
	}
	
	public function getSetting( $slug = 'server_email' ){
		$rs = $this->CI->db->where('slug',$slug)->get('settings')->result_array();
		if(count($rs)){
			$value = ($rs[0]['value'] != '') ? $rs[0]['value'] : $rs[0]['default'];
			return $value;
		}
		return '';
	}
	
	public function getTemplateMail ( $slug = '' ){
		$rs = $this->CI->db->where('slug',$slug)->get('email_templates')->result_array();
		if( count( $rs ) )
			return $rs[0];
		return '';
	}
	
	function getBlog($id, $part){ // part: title, intro, body
		$rs = $this->CI->db->where('id',$id)->get('blog')->result_array();
		if( count( $rs ) )
			return $rs[0][$part];
		return '';
	}
	
	function build_HTML_nav( $array_menu, $current ){
		$i = 0;
		$html = "";
		foreach($array_menu as $menu){
			$currentClass = ($menu['module'] == $current)? " current":"";
			if($i == 0){
				$seg = "first ";
			}elseif($i == count($array_menu)-1){
				$seg = "last ";
			}else{
				$seg = "";
			}
			 
			$class = "class=\"{$seg}item{$currentClass}\" ";
			
			$html .= "<li $class>"."<a href='".$menu['link']."' >".$menu['title']."</a>".$menu['extra']."</li>";
			$i++;
		}
		return $html;
	}
	/**
	 * Function create thumbnail
	 * @access 
	 * @return 
	 */
	public function createThumbnail($sImagePath, $thumbPath ,$wScale = '100', $hScale = '')
	{
		$typeFile= array( "jpg", "jpeg", "png", "gif", "bmp" );
		if(
			!in_array(strtolower(substr($sImagePath, -3)), $typeFile) && 
			!in_array(strtolower(substr($sImagePath, -4)), $typeFile)
		) return 'none';
		$sOriginalFileName = $sImagePath ;
		$sExtension = substr( $sImagePath, ( strrpos($sImagePath, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension ) ;
		switch($sExtension){
			case 'jpg':
			case 'jpeg':
				if (function_exists("imagejpeg")) {
					$srcImg = imagecreatefromjpeg("$sImagePath") or die( "File Not Found" );
					$sizeImage = $this->imageResize($sImagePath, $wScale, $hScale);
					$thumbImg = imagecreatetruecolor($sizeImage['w'], $sizeImage['h']);
					imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $sizeImage['w'], $sizeImage['h'], imagesx($srcImg), imagesy($srcImg));
					imagejpeg($thumbImg, "$thumbPath");
				}
				break;
			case 'gif':
				if (function_exists("imagegif")) {
					$srcImg = imagecreatefromgif("$sImagePath") or die( "File Not Found" );
					$sizeImage = $this->imageResize($sImagePath, $wScale, $hScale);
					$thumbImg = imagecreatetruecolor($sizeImage['w'], $sizeImage['h']);
					imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $sizeImage['w'], $sizeImage['h'], imagesx($srcImg), imagesy($srcImg));
					imagegif($thumbImg, "$thumbPath");
				}
				break;
			case 'png':
				if (function_exists("imagepng")) {
					$srcImg = imagecreatefrompng("$sImagePath") or die( "File Not Found" );
					$sizeImage = $this->imageResize($sImagePath, $wScale, $hScale);
					$thumbImg = imagecreatetruecolor($sizeImage['w'], $sizeImage['h']);
					imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $sizeImage['w'], $sizeImage['h'], imagesx($srcImg), imagesy($srcImg));
					imagepng($thumbImg, "$thumbPath");
				}
				break;
			case 'bmp':
				if (function_exists("imagewbmp")) {
					$srcImg = imagecreatefromwbmp("$sImagePath") or die( "File Not Found" );
					$sizeImage = $this->imageResize($sImagePath, $wScale, $hScale);
					$thumbImg = imagecreatetruecolor($sizeImage['w'], $sizeImage['h']);
					imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $sizeImage['w'], $sizeImage['h'], imagesx($srcImg), imagesy($srcImg));
					imagewbmp($thumbImg, "$thumbPath");
				}
				break;
			default:
				return $msg = "GD library does not support in this PHP server";
				break;
		}
	}
	
	private function imageResize($sImagePath, $wScale = '100', $hScale = '')
	{
		if(empty($hScale)) $hScale = $wScale;
		$newSize = array();
		$size	 = getimagesize($sImagePath);
		if($size[0] > $size[1]){
			if($size[0] > $wScale) $newSize['w'] = $wScale;
			else $newSize['w'] = $size[0];
			$newSize['h'] = round( $newSize['w'] * $size[1]/$size[0] );
			if( $newSize['h'] > $hScale ) {
				$olderSize = $newSize;
				$newSize['h'] = $hScale;
				$newSize['w'] = round( $newSize['h'] * $olderSize['w']/$olderSize['h'] );
			}
			// Add New
		}
		else{
			if($size[1] > $hScale) $newSize['h'] = $hScale;
			else $newSize['h'] = $size[1];
			$newSize['w'] = round( $newSize['h'] * $size[0]/$size[1] );
			if( $newSize['w'] > $wScale ) {
				$olderSize = $newSize;
				$newSize['w'] = $hScale;
				$newSize['h'] = round( $newSize['w'] * $olderSize['h']/$olderSize['w'] );
			}
		}
		return $newSize;
	}
	
	/**
	 * Function process File
	 */
	function uploadFile( $temp_file, $file_name, $folder, $aTypeUpload = "" )
	{
		if( empty( $aTypeUpload ) ) $typeUpload= array( "jpg", "jpeg", "png", "gif", "bmp" );
		else $typeUpload = $aTypeUpload;
		
		if(
			!in_array(strtolower(substr($file_name, -3)), $typeUpload) && 
			!in_array(strtolower(substr($file_name, -4)), $typeUpload)
		) return '';
		
		
		$sExtension = substr( $file_name, ( strrpos($file_name, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension ) ;
		
		$iCounter = 0 ;
		$sServerDir = $folder;
		$file_name = ( $this->removeExtension($file_name) )."_".time().".".$sExtension;
		$sOriginalFileName = $file_name ;
		while ( true )
		{
			// Compose the file path.
			$sFilePath = $sServerDir . $file_name ;
		
			// If a file with that name already exists.
			if ( is_file( $sFilePath ) )
			{
				$iCounter++ ;
				$file_name = $this->removeExtension( $sOriginalFileName ) . '_' . $iCounter . '.' . $sExtension ;
			}
			else
			{
				move_uploaded_file( $temp_file, $sFilePath ) ;
		
				if ( is_file( $sFilePath ) )
				{
					$oldumask = umask(0) ;
					chmod( $sFilePath, 0777 ) ;
					umask( $oldumask ) ;
				}
				clearstatcache();
				break ;
			}
			clearstatcache();
		}
		
		return $file_name;
	}
	
	function removeExtension( $fileName )
	{
		$fileName =  substr( $fileName, 0, strrpos( $fileName, '.' ) ) ;
		$fileName = slugify( normal_chars($fileName) );
		return $fileName;
	}

	
	
}

?>
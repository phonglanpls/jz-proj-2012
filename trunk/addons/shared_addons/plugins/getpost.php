<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Get Post Plugin
 */
class Plugin_Getpost extends Plugin
{
	/**
	 * Make thumbnail
	 *
	 * Usage:
	 * {pyro:getpost:mkthumb src="/uploads/file/file.jpg" w="200" h="200"}
	 *
	 * @param	int
	 * @return	string
	 */
	function mkthumb(){
		$file = $this->attribute('src', 'String');
		$w = 	$this->attribute('w', 'Number');
		$h = 	$this->attribute('h', 'Number');
		return thumb( site_url().$file, $w, $h);
	}
	/**
	 * Get Title of post
	 *
	 * Usage:
	 * {pyro:getpost:title id="1"}
	 *
	 * @param	int
	 * @return	string
	 */
	function title()
	{	
		$id = $this->attribute('id', 'Number'); 
		$data = $this->_fetchDataObj($id);
	 
		if($data->title)
			return $data->title;
		
		return ;
	}
	
	/**
	 * Get Intro of post
	 * 
	 * Usage:
	 * {pyro:getpost:intro id="1"}
	 * 
	 * @param	int	
	 * @return	string
	 */
	function intro(){
		$id = $this->attribute('id' , 'Number');
		$data = $this->_fetchDataObj($id);
		
		if($data->intro)
			return $data->intro;
		
		return;
	}
	
	/**
	 * Get Body of post
	 * 
	 * Usage:
	 * {pyro:getpost:body id="1"}
	 * 
	 * @param	int
	 * @return	string
	 * 
	 */
	function body(){
		$id = $this->attribute('id' , 'Number');
		$data = $this->_fetchDataObj($id);
		
		if($data->body)
			return str_replace( '{###BASE_URI###}', site_url(), $data->body);
		
		return;
	}
	/**
	 * Function get data from post
	 * input: id
	 * output: object data
	 */ 
	 function _fetchDataObj($id){
	 	$id = (int) $id;
		$rs = $this->db->where('id',$id)->get('blog')->result();
		return $rs[0];
	 }
	 
	 function _getContent($slug){
		$rs = $this->db->where('slug',$slug)->get('blog')->result();
		return $rs[0];
	 }
	 
	 
	 /**
	 * Get title of post
	 * 
	 * Usage:
	 * {pyro:getpost:title_slug slug="slug-here"}
	 * 
	 * @param	int
	 * @return	string
	 * 
	 */
	 function title_slug(){
		$slug = $this->attribute('slug' , 'String');
		$data = $this->_getContent($slug);
		
		if($data->title)
			return str_replace( '{###BASE_URI###}', site_url(), $data->title);
		
		return;
	 }
	 
	 /**
	 * Get intro of post
	 * 
	 * Usage:
	 * {pyro:getpost:intro_slug slug="slug-here"}
	 * 
	 * @param	int
	 * @return	string
	 * 
	 */
	 function intro_slug(){
		$slug = $this->attribute('slug' , 'String');
		$data = $this->_getContent($slug);
		
		if($data->intro)
			return str_replace( '{###BASE_URI###}', site_url(), $data->intro);
		
		return;
	 }
	 
	 /**
	 * Get Body of post
	 * 
	 * Usage:
	 * {pyro:getpost:body_slug slug="slug-here"}
	 * 
	 * @param	int
	 * @return	string
	 * 
	 */
	 function body_slug(){
		$slug = $this->attribute('slug' , 'String');
		$data = $this->_getContent($slug);
		
		if($data->body)
			return str_replace( '{###BASE_URI###}', site_url(), $data->body);
		
		return;
	 }
}

/* End of file example.php */
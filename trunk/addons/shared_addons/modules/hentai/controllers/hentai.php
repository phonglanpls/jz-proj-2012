<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
* @author DANG DINH HUNG
*
*/
class Hentai extends Public_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('hentai_m') ); 
		
		$this->template
			->title($GLOBALS['global']['HOME_PAGE']['site_title'])
			->append_metadata( js('swf.js', 'hentai') )	
			->append_metadata( js('hentai.js', 'hentai') );
			
			
		if($GLOBALS['global']['HENTAI']['show'] != 1){
			show_404();
		}	

		if(isLogin()){
			$currenturl = fullURL();
			if(false !== strpos($currenturl,'/hentai/category/')){
				$redr = str_replace( '/hentai/category/','/user/hentai/',$currenturl);
				redirect($redr);
				die; 
			}
			
			redirect('user/hentai');
			exit;
		}	
	}
	
	public function index()
	{
		$this->template->build('index');
	}
	
	function category(){
		$task = $this->uri->segment(3,'');
		$is_async = $this->input->get('is_async','');
		 
		switch($task){
			default:
				$this->template->build('index');
				break;	
			case 'category':
				$this->load->view( 'show_categories' );
				break;
			case 'series':	
				$id_series = $this->uri->segment(4,0);
				$seriesdata = $this->mod_io_m->init('id_series',$id_series,TBL_SERIES);
				if(!$seriesdata){
					show_404();
					exit;
				}
				$this->template
					->title($seriesdata->name)
					->build('series');
				break;	
			case 'show_video_episode':
				$this->load->view( 'video_episode' );
				break;
			case 'video':
				$id_video = $this->uri->segment(4,0);
				$videodata = $this->mod_io_m->init('id_video',$id_video,TBL_VIDEO);
				if(!$videodata){
					show_404();
					exit;
				}
				$this->template
					->title($videodata->name)
					->build('video');
				break;
			case 'show_watching_video':	
				$this->load->view("show_user_watching_video", array('video_id'=>$this->input->get('id_video')));
				break; 
		
		}	
	}
	
	//end class
}
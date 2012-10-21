<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 	PyroCMS
 * @subpackage  Templates Module
 * @category	Module
 */
class Admin extends Admin_Controller {
	public $task;
	
    function __construct()
    {
        parent::__construct();

        $this->lang->load('juzon');
        $this->load->model('juzon_config_m');
		$this->load->model('juzon_user_m');
		$this->load->model('juzon_gift_m');
		$this->load->model('juzon_hentai_m');
		$this->load->model('juzon_broadcast_m');
		$this->load->model('juzon_report_m');
		
		$this->task = $this->uri->segment(4,'');
		
		$this->template
			->title('Juzon data management')
			->append_metadata( js('index.js', 'juzon') )
			->append_metadata( js('site.js', 'juzon') )
			->append_metadata( js('helper.js', 'juzon') )
			->append_metadata( js('jquery.form.js', 'juzon') )
            ->append_metadata( '<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css" />' )
			->append_metadata( '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>')
			->append_metadata( '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>' )
            ->append_metadata( '<script type="text/javascript" src="'.site_url().'/media/js/jquery.gmap.js"></script>' )
            ->append_metadata( '<script src="https://www.google.com/jsapi?key={{sys:getGoogleAPIKey}}" type="text/javascript"></script>' )
			->append_metadata( css('index.css', 'juzon') );
			
    }

    public function index()
    {
		redirect(site_url("admin/juzon/config"));
    }

	function config(){	
		 
		switch($this->task){
			default:
				$this->template->build('admin/config/index');
                break;
			case 'edit':
				$this->template->build('admin/config/edit_page'); 
                break;
			case 'submit_config':	
				$this->juzon_config_m->submit_config();
				break;
			case 'callFuncOpenDialogEditAnnouncement':
				$this->load->view('admin/config/callFuncOpenDialogEditAnnouncement');
				break;
			case 'saveAnnouncement':
				$this->juzon_config_m->saveAnnouncement();
				break;	
			case 'sendAnnouncementEmail':
				$this->juzon_config_m->sendAnnouncementEmail();
				break;
				
			case 'question_idea':	
				$this->template->build('admin/config/question_idea/index');
                break;
			case 'callFuncOpenDialogEditQuestion':
			case 'callFuncOpenDialogAddNewQuestion':
				$this->load->view('admin/config/question_idea/callFuncOpenDialogEditQuestion');
				break;
			case 'saveQuestionIdea':
				$this->juzon_config_m->saveQuestionIdea();
				break;
			case 'callFuncDeleteQuestion':
				$this->juzon_config_m->deleteQuestionIdea();
				break;
			
			case 'pet_lock':
				$this->template->build('admin/config/pet_lock/index');
                break;
			case 'callFuncToggleStatusLock':
				$this->juzon_config_m->toggleStatusLock();
				break;
			case 'callFuncDeleteLock':
				$this->juzon_config_m->deleteLock();
				break;
			case 'callFuncOpenDialogAddNewLock':
			case 'callFuncOpenDialogEditLock':
				$this->load->view('admin/config/pet_lock/callFuncOpenDialogAddEditLock');
				break;
			case 'savePetLock':
				$this->juzon_config_m->savePetLock();
				break;
				
			case 'callFuncToggleHentaiSection':
				$this->juzon_config_m->toggleHentaiSection();
				break;
		}		
	}
	

	function user(){
	   $this->load->model("user/online_m");
		switch($this->task){
			default:
				$this->template->build('admin/user/index');
                break;
			case 'callFuncToggleStatusLock':
				$this->juzon_user_m->toggleStatusLock();
				break;
			case 'switch_user':
				$this->juzon_user_m->switchUser();
				break;
			case 'callFuncManageCashUser':
				$this->load->view('admin/user/callFuncManageCashUser');
				break;
			case 'saveCashUser':	
				$this->juzon_user_m->saveCashUser();
				break;
            case 'callFuncShowGoogleMapUser':
                $this->load->view('admin/user/callFuncShowGoogleMapUser');
				break;    
            case 'switch_user_fb':
                $this->juzon_user_m->switchUserFB();
				break;   
            case 'switch_user_tt':
                $this->juzon_user_m->switchUserTT();
				break;     
		}		
	}
	
	
	function transaction(){
		switch($this->task){
			default:
				$this->template->build('admin/transaction/index');
                break;
		}		
	}
	
	function gift(){
		switch($this->task){
			default:
				$this->template->build('admin/gift/index');
                break;
			case 'callFuncEditGift':
			case 'callFuncAddGift':
				$this->load->view('admin/gift/callFuncOpenDialogAddEditGift');
				break;
			case 'saveGift':
				$this->juzon_gift_m->saveGift();
				break;
			case 'callFuncDeleteGift':	
				$this->juzon_gift_m->deleteGift();
				break;
				
			case 'categories':
				$this->template->build('admin/gift/categories/index');
                break;
			case 'callFuncAddNewCategory':
			case 'callFuncEditCategory':
				$this->load->view('admin/gift/categories/callFuncOpenDialogAddEditCategories');
				break;
			case 'saveCategory':
				$this->juzon_gift_m->saveCategory();
				break;
			case 'callFuncDeleteCategory':
				$this->juzon_gift_m->deleteCategory();
				break;
				
			case 'report':
				$this->template->build('admin/gift/report/index');
                break;
		}		
	}
	
	
	function hentai(){
		switch($this->task){
			default:
				$this->template->build('admin/hentai/index');
                break;
			case 'callFuncEditCategory':
				$this->load->view('admin/hentai/callFuncOpenDialogEditCategory');
				break;
			case 'saveCategory':
				$this->juzon_hentai_m->saveCategory();
				break;
				
			case 'series':
				$this->template->build('admin/hentai/series/index');
                break;
			case 'callFuncEditSeries':
			case 'callFuncAddNewSeries':
				$this->load->view('admin/hentai/series/callFuncOpenDialogAddEditSeries');
				break;
			case 'saveSeries':
				$this->juzon_hentai_m->saveSeries();
				break;
			case 'callFuncDeleteSeries':
				$this->juzon_hentai_m->deleteSeries();
				break;
				
			case 'video':
				$this->template->build('admin/hentai/video/index');
                break;
			case 'callFuncAddNewVideo':
			case 'callFuncEditVideo':	
				$this->load->view('admin/hentai/video/callFuncOpenDialogAddEditVideo');
				break;
			case 'loadCorrespondSeries':
				$this->juzon_hentai_m->loadCorrespondSeries();
				break;
			case 'saveVideo':
				$this->juzon_hentai_m->saveVideo();
				break;
			case 'callFuncDeleteVideo':
				$this->juzon_hentai_m->deleteVideo();
				break;	
		}		
	}
	
	function broadcast(){
		switch($this->task){
			default:
				$this->template
							//->append_metadata( $this->load->view('fragments/wysiwyg'),$this->data,TRUE )
							->build('admin/broadcast/index');
				break;
			case 'sendemail':	
				$this->juzon_broadcast_m->sendemail();
				break;	
			
		}		
	}
	
	function report(){
		switch($this->task){
			default:
				$this->template->build('admin/report/index');
				break;
				
			case 'login':
				$this->template->build('admin/report/login/index');
				break;
			case 'callFuncDeleteLoginItem':
				$this->juzon_report_m->deleteLoginItem();	
				break;
				
			case 'blockedip':
				$this->template->build('admin/report/blockedip/index');
				break;
			case 'callFuncOpenDialogAddIP':
				$this->load->view('admin/report/blockedip/callFuncOpenDialogAddIP');
				break;
			case 'saveIPBlocked':
				$this->juzon_report_m->saveIPBlocked();	
				break;
			case 'callFuncDeleteIP':
				$this->juzon_report_m->deleteIP();	
				break;
				
			case 'abuse':
				$this->template->build('admin/report/abuse/index');
				break;
            case 'log_login':
                $this->template->build('admin/report/log_login/index');
				break;    
            case 'callFuncDeleteLoginLogItem':
                $this->juzon_report_m->deleteLoginLogItem();	
				break;   
			case 'callFuncDeleteReportAbuseItem':
				$this->juzon_report_m->deleteReportAbuseItem();	
				break; 
		}		
	}
	
	function transaction_flow(){
		switch($this->task){
			default:
				$this->template->build('admin/transaction_flow/index');
				break;
			case 'callFuncDetectAccount':
				$this->load->view('admin/transaction_flow/callFuncDetectAccount');
				break;
		}		
	}
	
	
}
/* End of file controllers/admin.php */
<?php defined('BASEPATH') or exit('No direct script access allowed');

class Backstage_m extends MY_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getBackstageList($cat='',$keyword='',$offset=0,$records_p_page=0){
		$image_type = $GLOBALS['global']['IMAGE_STATUS']['private'];
		 
		$sql = "SELECT res. * , jct.id_collection FROM 
			(SELECT * FROM (SELECT u.username,u.id_user,u.status,g.id_image,g.id_wall,g.image,g.comment,g.price,g.image_type,g.v_count,g.rate_num,g.rating,g.added_date FROM ".TBL_USER." u,".
							TBL_GALLERY." g WHERE g.image_type =$image_type AND g.id_user = u.id_user AND g.is_deleted=0) AS list 
						LEFT JOIN (SELECT id_wall AS id_backstage, count(COMMENT) comments FROM ".TBL_PHOTO_COMMENT." GROUP BY id_wall) AS comm 
						ON list.id_image = comm.id_backstage) AS res LEFT JOIN 
						( SELECT id_collection,id_image FROM ".TBL_COLLECTION." WHERE id_user =".getAccountUserId().") AS jct 
						ON res.id_image = jct.id_image WHERE res.id_user !=".getAccountUserId()." AND res.status=0 ";
		 
		//$sql = "SELECT g.* FROM ".TBL_GALLERY." g,".TBL_USER." u WHERE g.image_type=$image_type AND g.id_user=u.id_user AND u.status=0 AND g.id_user!=".getAccountUserId();
		
		$search_cond = $cond = '';				
		if($cat){
			if($cat == $GLOBALS['global']['BACKSTAGE_LIST']['most_viewed']){
				$cond =" ORDER BY  v_count DESC";
			}elseif($cat == $GLOBALS['global']['BACKSTAGE_LIST']['random']){
				$cond=" ORDER BY  RAND()";
			}else{
				$cond=" ORDER BY id_image DESC";
			}
		}else{
			$cond=" ORDER BY id_image DESC";
		}
		if($keyword){
			$keyword = trim($keyword,' ');
			$search_cond = " AND (username like '%$keyword%' OR comment like '%$keyword%')";
		}
		$sql.=$search_cond;
		$sql.=$cond;
		
		if($records_p_page){
			$sql .= " LIMIT ".$offset.",".$records_p_page."";
		}
		
		return $this->db->query($sql)->result();
	}	
	
	function getMyBackstagePhoto(){
		$image_type = $GLOBALS['global']['IMAGE_STATUS']['private'];
		 
		$sql = "SELECT res. * , jct.id_collection FROM 
			(SELECT * FROM (SELECT u.username,u.id_user,u.status,g.id_image,g.id_wall,g.image,g.comment,g.price,g.image_type,g.v_count,g.rate_num,g.rating,g.added_date FROM ".TBL_USER." u,".
							TBL_GALLERY." g WHERE g.image_type =$image_type AND g.id_user = u.id_user AND g.is_deleted=0) AS list 
						LEFT JOIN (SELECT id_wall AS id_backstage, count(COMMENT) comments FROM ".TBL_PHOTO_COMMENT." GROUP BY id_wall) AS comm 
						ON list.id_image = comm.id_backstage) AS res LEFT JOIN 
						( SELECT id_collection,id_image FROM ".TBL_COLLECTION." WHERE id_user =".getAccountUserId().") AS jct 
						ON res.id_image = jct.id_image WHERE res.id_user =".getAccountUserId()." AND res.status=0 ORDER BY id_image DESC";
		return $this->db->query($sql)->result(); 
	}
	
	function getUserBackstagePhoto($id_user){
		$image_type = $GLOBALS['global']['IMAGE_STATUS']['private'];
		 
		$sql = "SELECT res. * , jct.id_collection FROM 
			(SELECT * FROM (SELECT u.username,u.id_user,u.status,g.id_image,g.id_wall,g.image,g.comment,g.price,g.image_type,g.v_count,g.rate_num,g.rating,g.added_date FROM ".TBL_USER." u,".
							TBL_GALLERY." g WHERE g.image_type =$image_type AND g.id_user = u.id_user AND g.is_deleted=0) AS list 
						LEFT JOIN (SELECT id_wall AS id_backstage, count(COMMENT) comments FROM ".TBL_PHOTO_COMMENT." GROUP BY id_wall) AS comm 
						ON list.id_image = comm.id_backstage) AS res LEFT JOIN 
						( SELECT id_collection,id_image FROM ".TBL_COLLECTION." WHERE id_user =".$id_user.") AS jct 
						ON res.id_image = jct.id_image WHERE res.id_user =".$id_user." AND res.status=0 ORDER BY id_image DESC";
		return $this->db->query($sql)->result(); 
	}
	
	function isMyBackstagePhoto($id_photo){
		$image_type = $GLOBALS['global']['IMAGE_STATUS']['private'];
		$sql = "SELECT g.* FROM ".TBL_GALLERY." g,".TBL_USER." u WHERE g.image_type=$image_type AND g.id_user=u.id_user AND u.status=0 AND g.id_user=".getAccountUserId()." AND g.id_image=$id_photo AND g.is_deleted=0";
		$res= $this->db->query($sql)->result(); 
		return $res?true:false;
	}
	
	function deleteMyBackstagePhoto($id_photo){
		$this->db->where('id_image',$id_photo)->update(TBL_GALLERY,array('is_deleted'=>1));
		$this->db->where('post_id',$id_photo)->where('post_code',$GLOBALS['global']['CHATTER_CODE']['backstage_photo'])
			->delete(TBL_WALL);
	}
    
    function getUserArrayBuyBackstagePhoto($id_photo){
        $image_type = $GLOBALS['global']['IMAGE_STATUS']['private'];
		$sql = "SELECT u.id_user,u.username,c.added_date FROM ".TBL_GALLERY." g,".TBL_USER." u, ".TBL_COLLECTION." c WHERE g.image_type=$image_type AND u.status=0 AND c.id_image =g.id_image AND c.id_user=u.id_user AND g.id_image=$id_photo AND g.is_deleted=0";
		$res= $this->db->query($sql)->result(); 
        return $res;
    }
	
	function buyBackstagePhoto(){
		$this->load->model( 'user/collection_m' );
		
		$id_photo = $this->input->post('id_photo',0);
		$gallerydata = $this->gallery_io_m->init('id_image',$id_photo);
		$userdataobj = getAccountUserDataObject(true);
		
		$price = $gallerydata->price;
		$id_owner = $gallerydata->id_user;
		
		if($this->collection_m->isMyCollectionPhoto($id_photo)){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'This photo was in your collection.'
				)
			);
			exit;
		}
		
		if($userdataobj->cash < $price){
			echo json_encode(
				array(
					'result' => 'ERROR',
					'message' => 'Your cash is not to buy this backstage photo.'
				)
			);
			exit;
		}
		
		/* update collection data */	
		$data['id_user'] = getAccountUserId();
		$data['id_image'] = $id_photo;
		$data['coll_type'] = $GLOBALS['global']['COLLECTION_TYPE']['photo'];
		$data['added_date'] = mysqlDate();		
		$id_collection = $this->mod_io_m->insert_map($data,TBL_COLLECTION);
		unset($data);
		
		/* update views gallery */
		$this->db->query("UPDATE ".TBL_GALLERY." SET v_count= v_count+1 WHERE id_image=$id_photo");
		
		/*update user amount cash */
		$site_amount = ($GLOBALS['global']['BACKSTG_PRICE']['site']*$price)/100;
		$owner_amount = ($GLOBALS['global']['BACKSTG_PRICE']['owner']*$price)/100;
		
		$this->db->query("UPDATE ".TBL_USER." SET cash= cash+$owner_amount WHERE id_user=$id_owner");
		$this->db->query("UPDATE ".TBL_USER." SET cash= cash-$price WHERE id_user=".$userdataobj->id_user);		
		
		/*update transaction data */
		$data['id_owner'] = $userdataobj->id_user; 
		$data['id_user'] = $id_owner; 
		$data['amount'] = $price;
		$data['trans_type'] = $GLOBALS['global']['TRANS_TYPE']['backstg_photo'];
		$data['site_amt'] = $site_amount;
		$data['user_amt'] = $owner_amount; 
		$data['image'] = $gallerydata->image;
		$data['trans_date'] = mysqlDate();
		$data['ip'] = $this->geo_lib->getIpAddress();
		$id_transaction = $this->mod_io_m->insert_map($data,TBL_TRANSACTION);
		
		debug("id_collection=$id_collection  | id_transaction=$id_transaction | id_owner:$id_owner | site_amount:$site_amount | owner_amount:$owner_amount");
		
		$ownerdata = $this->user_io_m->init('id_user',$id_owner);
		$CMCHATMSG = str_replace(array('$u1','$u2','$p3'),array($userdataobj->username,$ownerdata->username,$price),language_translate('hook_chat_buy_backstage'));
		
		echo json_encode(
			array(
				'result' => 'ok',
				'message' => 'Buy backstage photo successfully.',
				'id_user' => $id_owner,
				'CMCHATMSG' => $CMCHATMSG
			)
		);
		
		$this->email_sender->juzonSendEmail_JUZ_WHO_BOUGHT_MY_BACKSTAGE_PHOTO($id_buyer = $userdataobj->id_user, $id_seller = $id_owner, $id_photo, $data['amount']);
		
		exit;
	}
	
	
	
	
	
	
	
//endclass
}	
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript" src="<?php echo site_url();?>/media/js/wallet.js"></script> 
	
<div id="body-content">
   <?php 
        $this->load->view("user/partial/left");
        //{{getpost:title_slug slug="how-to-earn-j"}}
        //{{getpost:body_slug slug="how-to-earn-j"}}
        $userdataobj = getAccountUserDataObject(true);
   ?>
 
	<div id="body">
		<div class="body">
			<div id="content">
				<?php $this->load->view("user/partial/top"); ?>
				<div class="clear"></div>
				
				<div class="filter-split">
					<h3>How to earn J$</h3>
					
					<div class="clear"></div>
					
					<div class="information-content">
                        <br /> <br />  
						You can earn J$ thru the methods below :
                        <br /><br />     
                         
                        1) Buy J$ or complete offer ( the fastest) =&gt; <a href="javascript:void(0);" onclick="callFuncTrialPay_addCampaign('<?php echo buildTrialPayParam('TOPLEFT');?>');">'ADD J$'</a> 
					    <br /><br />  
                        
                        2) Invite Your Friends - each successful invite will earn you <a href="<?php echo site_url('user/invite_friends')?>"><?php echo currencyDisplay($GLOBALS['global']['USER_CASH']['invite_cash']);?>J$</a> cash 
                        <br /><br />
                        
                        3) Backstage - You add your backstage photo. When someone buys your backstage photo, <br />
                            you will earn <a href="<?php echo site_url('user/backstage/?s=spc1')?>"><?php echo $GLOBALS['global']['BACKSTG_PRICE']['owner'];?>% revenue of J$ cash</a>  
                            e.g you set your backstage photo at 6J$. <br />
                            When other user buys it, you earn <?php echo currencyDisplay ( 6*($GLOBALS['global']['BACKSTG_PRICE']['owner']/100) );?>J$ of each sale. More users buy it, more J$ cash for you <br />
                            note : admin take <?php echo currencyDisplay( 6*($GLOBALS['global']['BACKSTG_PRICE']['site']/100) );?>J$ as tax
                        <br /><br />
                        
                        4) Map Flirts - You set <?php echo $userdataobj->map_access;?>J$ for your map location. When someone buys your map location, <br /> 
                        you will earn <a href="<?php echo site_url('user/map_flirts');?>"><?php echo $GLOBALS['global']['MAP_PRICE']['user'];?>% revenue of J$ cash</a>
                        e.g you set your map location at 7J$. <br />
                        When other user buys it, you earn <?php echo currencyDisplay(7*($GLOBALS['global']['MAP_PRICE']['user']/100));?>J$ of each sale. <br />
                        More users buy it, more J$ cash for you <br />
                        note : admin take <?php echo currencyDisplay( 7*($GLOBALS['global']['MAP_PRICE']['site']/100) );?>J$ as tax    
                        <br /><br />
                   
                        5) <a href="<?php echo site_url("user/pets")?>">Pet Sales</a> <br />
                        a) You invest by buying a pet. When someone buys the pet from you, you will earn a profit. Buy more valuable pets, earn more J$ cash <br />
                        b) As someone buys you as pet, you will also earn J$. More people buy you, more J$ for you <br />
                        note : admin take <?php echo $GLOBALS['global']['PET_VALUE']['tax_trans'];?>% as tax
                        <br /><br />
                        
                        6) <a href="<?php echo site_url("user/mypets")?>">Pet Lock</a> <br /> 
                        After owner buys you as a pet, the owner can choose to lock you ( so no other user can buy you) for a certain time frame by paying J$ cash <br />
                        You as a pet being locked, will earn the J$ cash <br />
                        note : admin take <?php echo $GLOBALS['global']['LOCKPET']['site'];?>% as tax
                        <br /><br />
                        
                        7) <a href="<?php echo site_url("user/peeps")?>">Who's peeped</a> <br />  
                        Users clicked on your profile page. <br />
                        Your admirer wants to know which user clicked on your profile page. <br />
                        You set <?php echo $userdataobj->peep_access;?>J$ per clicker per 24 hours access for your admirer <br />
                        The more admirer buy access from you, the more J$ you earn  <br />
                        note : admin take <?php echo $GLOBALS['global']['PEEP_PRICE']['site'];?>% as tax
                        <br /><br />
                        
                    </div>
				</div>
				 
				<div class="clear"></div>
				 
				
			</div>
		</div>
	   <?php $this->load->view("user/partial/right");?>
	</div>
	<div class="clear"></div>
	
</div>
 
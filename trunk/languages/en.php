<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//////////////DEFINE LANGUAGE HERE/////////////////

///////////////////////////DATE TIME /////////////////////////////////////////////////////////////////
$lang['sys_datetime_1'] 	=	'January'; 
$lang['sys_datetime_2'] 	=	'February'; 
$lang['sys_datetime_3'] 	=	'March'; 
$lang['sys_datetime_4'] 	=	'April'; 
$lang['sys_datetime_5'] 	=	'May'; 
$lang['sys_datetime_6'] 	=	'June'; 
$lang['sys_datetime_7'] 	=	'July'; 
$lang['sys_datetime_8'] 	=	'August'; 
$lang['sys_datetime_9'] 	=	'September'; 
$lang['sys_datetime_10'] 	=	'October'; 
$lang['sys_datetime_11'] 	=	'November'; 
$lang['sys_datetime_12'] 	=	'December';

$lang['jldayOfWeek_0']		=	'Sunday';
$lang['jldayOfWeek_1']		=	'Monday';
$lang['jldayOfWeek_2']		=	'Tuesday';
$lang['jldayOfWeek_3']		=	'Wednesday';
$lang['jldayOfWeek_4']		=	'Thursday';
$lang['jldayOfWeek_5']		=	'Friday';
$lang['jldayOfWeek_6']		=	'Saturday';

$lang['sys_datetime_acrn_1'] 	=	'Jan.'; 
$lang['sys_datetime_acrn_2'] 	=	'Feb.'; 
$lang['sys_datetime_acrn_3'] 	=	'Mar.'; 
$lang['sys_datetime_acrn_4'] 	=	'Apr.'; 
$lang['sys_datetime_acrn_5'] 	=	'May.'; 
$lang['sys_datetime_acrn_6'] 	=	'Jun.'; 
$lang['sys_datetime_acrn_7'] 	=	'Jul.'; 
$lang['sys_datetime_acrn_8'] 	=	'Aug.'; 
$lang['sys_datetime_acrn_9'] 	=	'Sep.'; 
$lang['sys_datetime_acrn_10'] 	=	'Oct.'; 
$lang['sys_datetime_acrn_11'] 	=	'Nov.'; 
$lang['sys_datetime_acrn_12'] 	=	'Dec.'; 

///////////////////////////member/login /////////////////////////////////////////////////////////////////
$lang['member_login_email_format_error']	=	'Email not valid';
$lang['member_login_email_not_existed']		=	'No such email in our database. Please use facebook or twitter connect to login';
$lang['member_login_password_error']		=	'Password is not correct';	
$lang['member_login_account_blocked']		=	'Account was blocked';
$lang['member_login_email_blacklist_error']	=	'Your email was blocked';
$lang['member_login_label_email']			=	'Email';
$lang['member_login_label_password']		=	'Password';
$lang['member_login_label_forgot_password']	=	'Forgot password';
$lang['member_login_remember_me']			=	'Remember Me';
$lang['member_login_button_login']			=	'Login';
$lang['member_login_button_submit']			=	'Submit';
$lang['member_login_success']				=	'Login successfully.';
$lang['member_forgot_password_guide']		=	'Enter your account email to get password again.';	
$lang['member_forgot_password_notify']		=	'Please check your email inbox to active your password changed.';
$lang['member_active_password_notify']		=	'Your new password was activated successfully.';			
$lang['member_fb_connect_label']			=	'Facebook connection';
$lang['member_fb_connect_firstname']		=	'First Name';
$lang['member_fb_connect_lastname']			=	'Last Name';
$lang['member_fb_connect_username']			=	'User Name';
$lang['member_fb_connect_gender']			=	'Gender';
$lang['member_fb_connect_birthday']			=	'Birthday';
$lang['member_fb_connect_timezone']			=	'Your time zone';
$lang['member_fb_connect_check_username']	=	'Check Valid';
$lang['member_fb_connect_agree_terms_conditions']	=	'I agree to the <a href="javascript:void(0);" onclick="openTermsAndConditions();">Terms and Conditions</a>';
$lang['member_fb_username_error_length']	=	'Username accept from 6 to 30 character include alpha, number and -,_';
$lang['member_fb_username_error_not_available']	=	'Username is already existed in system.';
$lang['member_fb_username_available']		=	'Username is available';
$lang['member_fb_password_error']			=	'Password accept from 6 to 30 characters';
$lang['member_fb_email_error']				=	'Email is already existed in system.';
$lang['member_fb_age_error']				=	'You are minor';
$lang['member_fb_account_not_verified_error']	= 'Your facebook account was not verified.';
$lang['member_fb_register_success']			=	'Register successfully.';	
$lang['member_invitepage_title']			=	'"hey, quick fb/twitter connect, i\'ll show you inside " [$firstname $lastname]';
$lang['member_vanity_url_label']			=	'Your URL';	
$lang['member_fb_friend_request_error']		=	'You cannot join because your friends in facebook isn\'t enough. (min = $s)';
$lang['member_fb_photo_request_error']		=	'You cannot join because your photos in facebook isn\'t enough. (min = $s)';
$lang['member_tt_connect_label']			=	'Twitter connection';
$lang['member_email_error']					=	'Email is not valid';
$lang['member_tt_followers_request_error']	=	'You cannot join because your followers in twitter isn\'t enough. (min = $s)';
$lang['member_tt_mintweet_request_error']	=	'You cannot join because your tweets in twitter isn\'t enough. (min = $s)';
$lang['member_tt_mindays_request_error']	=	'You cannot join because your min days in twitter isn\'t enough. (min = $s)';
$lang['member_birthday_error']				=	'Birthday can not empty.';

$lang['member_login_guide_text']			= 	'Or <br/>- One click free sign up or login -';

$lang['member_fake_email_detected']         =   'We detected your email account was not real. Please enter new valid email then you can login again.';
$lang['member_old_fake_email']              =   'Old email';
$lang['member_new_email']                   =   'New email';
$lang['member_login_old_email_format_error']=   'Old Email not valid';
$lang['member_login_new_email_format_error']=   'New Email not valid';
$lang['member_login_old_email_blacklist_error'] =   'Your old email was blocked';
$lang['member_login_new_email_was_existed']     =   'Your new email was existed in system.';
$lang['member_login_new_email_not_valid']       =   'Your new email not valid. We can not send email to this email.';
//////////////////////////////wall///////////////////////////////////////////////////////////////////////
$lang['wall_comment_default']				=	'Give your comment...';
$lang['wall_status_share_default']			=	'Click here to share';
$lang['wall_photo_share_default']			=	'Write something about this';
//////////////////////////////wishlist///////////////////////////////////////////////////////////////////
$lang['wishlist_addto']			=	'Add To Wishlist';
$lang['wishlist_remove']		=	'Remove';
$lang['wishlist_remove_label']	=	'Remove From Wishlist';
//////////////////////////////////friend request////////////////////////////////////////////////////////
$lang['error_block_message_alert']	=	'This user had blocked you for adding friend.';
$lang['request_add_friend_success']	=	'Requested friend';
$lang['error_user_send_request_alert']	=	'This user requested you as friend.';
$lang['error_sent_request_frient_alert']	=	'You sent request to this user.';

$lang['append_invite_friend']	= '<br/>Click to invite URL <a href="{$invite_url}">here</a> if you can not see any link above.';
///////////////////////////////////Friend invite ///////////////////////////////////////////////////////
$lang['sys_search_title']					=	'Search:';
///////////////////////////////////Button//////////////////////////////////////////////////////////////
$lang['sys_button_title_edit']					=	'Edit';
$lang['sys_button_title_save']					=	'Save';
$lang['sys_button_title_cancel']				=	'Cancel';
$lang['sys_button_title_reset']					=	'Reset';
$lang['sys_button_title_delete']				=	'Delete';
$lang['sys_button_delete_confirm']				=	'Are you sure want to do this?';
$lang['sys_button_title_action']				=	'Action';
///////////////////////////////////Menu Nav Label///////////////////////////////////////////////////////
$lang['menu_nav_label_home']	=	'Home';
$lang['menu_nav_label_pets']	=	'Pets';
$lang['menu_nav_label_chat']	=	'Chat';
$lang['menu_nav_label_askme']	=	'Ask Me';
$lang['menu_nav_label_hentai']	=	'Hentai';
$lang['menu_nav_label_profile']	=	'Profile';
$lang['menu_nav_label_account']	=	'Account';
$lang['menu_nav_label_connect']	=	'Connect';
$lang['menu_nav_label_logout']	=	'Logout';
$lang['menu_nav_label_how-to-earn-J$']	=	'How to earn J$';
$lang['menu_nav_label_J$-wallet']	=	'J$ Wallet';
$lang['menu_nav_label_invite-your-friend']	=	'Invite Your Friends to Join!!!';
$lang['menu_nav_label_chatter']	=	'Chatter';
$lang['menu_nav_label_peeps']	=	'Peeps';
$lang['menu_nav_label_map_flirts']	=	'Map Flirts';
$lang['menu_nav_label_friends']	=	'Friends';
$lang['menu_nav_label_friends-request']	=	'Friends Request';
$lang['menu_nav_label_birthdays']	=	'Birthdays';
$lang['menu_nav_label_gift-box']	=	'Gift Box';
$lang['menu_nav_label_backstage']	=	'Backstage';
$lang['menu_nav_label_collection']	=	'Collection';
$lang['menu_nav_label_favourite']	=	'Who Favorite Me';
$lang['menu_nav_label_lock-pet']	=	'Lock pets';
$lang['menu_nav_label_blocklist']	=	'Block List';

//////////////////////////////////Left menu label///////////////////////////////////////////////////////
$lang['left_menu_label_cash']		=	'Cash:';
$lang['left_menu_label_value']		=	'Value:'; 
$lang['left_menu_label_wishlist']		=	'Wish List';    
$lang['left_menu_label_friendlist']		=	'Friends List';     
$lang['left_menu_label_petlist']		=	'Pet List';  
$lang['left_menu_label_viewall']		=	'View All';     
$lang['left_menu_label_friendlist_msg']		=	'There is no one in your friends list'; 
$lang['left_menu_label_petlist_msg']		=	'There is no one in your pet list';
$lang['left_menu_label_wishlist_msg']		=	'There is no one in your wish list';     
$lang['left_menu_label_owner']		=	'Owner:'; 
$lang['left_menu_label_buy_for']	=	'Buy For';   
$lang['left_menu_label_write_your_msg_here']	=	'Write Your Message Here:';      
$lang['left_menu_label_your_msg_hit_one_rd_user']	=	'(Your msg will hit one random user)';    
$lang['left_menu_label_you_have']	=	'You have ';    
$lang['left_menu_label_characters_left']	=	'characters left.';    
$lang['left_menu_label_to']	=	'To:';     
$lang['left_menu_label_send']	=	'Send :)';     

//////////////////////////////////Account////////////////////////////////////////////////////////  
$lang['contact_info_label_index']		=	'Set $1 J$ per 24 hours for other user to access your peeped. <br/> You will earn $2 % from the total J$ revenue.';   
$lang['contact_info_label_contact_info']		=	'Contact Info';
$lang['contact_info_label_f_name']		=	'First name:';
$lang['contact_info_label_l_name']		=	'Last name:';
$lang['contact_info_label_email']		=	'Email:';
$lang['contact_info_label_phone_number']		=	'Phone number:';
$lang['contact_info_label_country']		=	'Country:';
$lang['contact_info_label_state']		=	'State:';
$lang['contact_info_label_city']		=	'City:';
$lang['contact_info_label_address']		=	'Address:';
$lang['contact_info_label_zip_code']		=	'Zip code:';
$lang['contact_info_label_timezone']		=	'Timezone:';
$lang['contact_info_label_birthday']		=	'Birthday:';
$lang['email_info_label_email_setting']		=	'Email setting';
$lang['email_info_label_chatter_comment']		=	'Chatter Comment:';
$lang['email_info_label_askme_question']		=	'Askme Question:';
$lang['email_info_label_askme_answer']		=	'Askme Answer:';
$lang['email_info_label_photo_comment']		=	'Photo Comment:';
$lang['email_info_label_like_chatter']		=	'Like Chatter:';   
$lang['email_info_label_photo_rating']		=	'Photo Rating:';
$lang['email_info_label_friend_request']		=	'Friend Request:';
$lang['email_info_label_friend_confirm']		=	'Friend Confirm:';
$lang['email_info_label_send_gift']		=	'Send Gift:';
$lang['email_info_label_buy_pet']		=	'Buy Pet:';
$lang['email_info_label_lock_pet']		=	'Lock Pet:';
$lang['email_info_label_alert_me_other_buy_my_pet']		=	'Alert me when other user buy my pet:';
$lang['email_info_label_birthday_alert']		=	'Friend\'s birthday(1 days advance):';
$lang['email_info_label_who_check_me']		=	'Who checked on me:';
$lang['email_info_label_who_buy_my_map']		=	'Who bought my map location:';
$lang['email_info_label_announcement']		=	'Announcement:';
$lang['email_info_label_offline_chat']		=	'Offline Chat:';
$lang['email_info_label_who_buy_backstage']		=	'Who bought my backstage photo:';
$lang['email_info_label_who_buy_who_peep_me']		=	'Who bought who\'s peeped me :';
$lang['password_info_label_change_pw']		=	'Change password login';
$lang['password_info_label_old_pw']		=	'Old password:';
$lang['password_info_label_new_pw']		=	'New password:';
$lang['password_info_label_retype_new_pw']		=	'Re-type new password:';
$lang['password_info_label_change_pw']		=	'Change Password'; 
//////////////////////////////////Askme//////////////////////////////////////////////////////// 
$lang['askme_menu_label_question']		= 'Questions';
$lang['askme_menu_label_answer']		= 'Answers';
$lang['askme_menu_label_ask_friends']	= 'Ask Friends';
$lang['question_table_head_questions']	=	'Questions';
$lang['question_table_head_askby']		=	'Ask By';
$lang['question_table_head_datetime']	=	'Date/Time';
$lang['question_table_head_answer']		=	'Answer';
$lang['question_table_head_delete']		=	'Delete';
$lang['question_button_answer']		=	'answer';
$lang['question_button_delete']		=	'delete';
$lang['answer_table_head_questions']	=	'Questions/Answers';
$lang['answer_table_head_askby']	=	'Ask By';
$lang['answer_acr_question']	=	'Q:';
$lang['answer_acr_answer']	=	'A:';
$lang['answer_acr_anonymous']	=	'Anonymous';
$lang['askfriend_askme']	=	'Ask me';
$lang['askfriend_viewlog']	=	'View log';
//////////////////////////////////Backstage//////////////////////////////////////////////////////// 
$lang['backstage_menu_label_latest']	=	'Latest';
$lang['backstage_menu_label_most_viewed']	=	'Most viewed';
$lang['backstage_menu_label_random']	=	'Random';
$lang['backstage_menu_label_my_backstage_photos']	=	'My Backstage Photos';
$lang['backstage_menu_label_search']	=	'Search';
$lang['show_backstage_upload_backstg']	=	'Upload Backstage Photo';
$lang['show_backstage_message_backstg']	=	'Currently, there is no backstage photo';
$lang['show_backstage_views']	=	'Views:';
$lang['show_backstage_comments']	=	'Comments:';
$lang['show_backstage_rating']	=	'Rating:';
$lang['show_backstage_buyfor']	=	'Buy For';
$lang['my_backstage_message_backstg']	=	'Currently, there is no photo';
$lang['my_backstage_change_profile_alert'] = 'Somewrong here.';
$lang['show_my_backstg_photo_of']			=	"%uname's backstage photo.";
$lang['show_my_backstg_previous']			=	"&laquo; Previous";
$lang['show_my_backstg_next']			=	"Next &raquo;";
//////////////////////////////////Block////////////////////////////////////////////////////////
$lang['block_menu_label_map_location']	=	'Access Map Location';
$lang['block_menu_label_chat']	=	'Chat';
$lang['accessmap_label_thead_who_access_map']	=	'Who access my map';
$lang['accessmap_label_thead_datetime']	=	'Date/time';
$lang['accessmap_label_thead_days']	=	'Days';
$lang['accessmap_label_thead_status']	=	'Status';
$lang['accessmap_label_thead_action']	=	'Action';
$lang['accessmap_label_expires']	=	'Expire';
$lang['accessmap_label_hours_left']	=	' Hour(s) Left';
$lang['accessmap_label_days_left']	=	' Day(s) Left';

$lang['chat_block_label_username']	=	'Blocked username';

//////////////////////////////////Collection////////////////////////////////////////////////////////
$lang['collection_menu_label_photo_collection']	=	'Photo Collection';
$lang['collection_menu_label_my_photo']	=	'My Photos';
$lang['photo_collection_message']	= 	'Currently, there is no photo';
$lang['my_photo_label_upload_photo']	=	'Upload Photo';
$lang['my_photo_change_profile_alert'] = 'Please choose another profile picture before.';
//////////////////////////////////Connect////////////////////////////////////////////////////////
$lang['connect_label_facebook']	=	'You connected on Facebook as ';
$lang['connect_label_twitter']	=	'You connected on Twitter as ';
$lang['connect_label_disconnect']	= 'Disconnect';

//////////////////////////////////CHAT COMET////////////////////////////////////////////////////
$lang['hook_chat_send_gift']		=	'$u1 sent to $u2 a gift for $p3J$ $image';
$lang['hook_chat_buy_as_pet']		=	'$u1 bought $u2 as a pet for $p3J$';
$lang['hook_chat_buy_map']			=	'$u1 bought map access $u2 for $p3J$';
$lang['hook_chat_buy_backstage']	=	'$u1 bought backstage photo of $u2 for $p3J$';
$lang['hook_chat_buy_peep_access']			=	'$u1 bought peeped access $u2 for $p3J$';
$lang['hook_chat_add_chat_favourite']			=	'$u1 added $u2 to favorite';










<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php 
	$userdataobj = getAccountUserDataObject(true);
	//$listUser = $this->user_m->getListUsername();
	$listUser = $this->user_m->getListMyFriendsUsername();
?>

<div class="gift-container">
	<h3>Your balance: <?php echo currencyDisplay($userdataobj->cash);?>J$</h3>

	<div class="clear"></div>

	<div class="input">
		<label>Gift:</label> 
		<div class="inputcls" id="gift-selected">
		</div>
	</div>

	<div class="clear"></div>

	<div class="input">
		<label>To:</label> 
		<div class="inputcls">
			<textarea maxlength="200" cols="15" rows="5" style="width:300px;height:100px;" id="to_username" name="to_username"></textarea>
		</div>
	</div>
	<div class="clear"></div>

	<div class="input">
		<label>Message:</label> 
		<div class="inputcls">
			<textarea maxlength="200" cols="15" rows="5" style="width:300px;height:100px;" id="message" name="message"></textarea>		
		</div>
	</div>
	<div class="clear"></div>
	
	<div class="input" style="margin-bottom:10px;">
		<label>&nbsp;</label> 
		<div class="inputcls">
			<input type="button" value="Send" class="share-2" onclick="callFuncSendGift();"/>
			<?php echo loader_image_s("id='sendGiftContextLoader' class='hidden'");?>	
		</div>
	</div>
	<div class="clear"></div>
	
	<input type="hidden" name="id_gift" id="id_gift_send" value="0" />
	<input type="hidden" name="sending_gift_context" id="sending_gift_context" value="0" />
</div>

<script type="text/javascript">
	$(function() {
		$id_gift = $('#id_gift_send').val();
		if( $id_gift != 0){
			$imgLink = $(".image-gift[rel="+$id_gift+"]").attr('src');
			$('#gift-selected').html("<img src="+$imgLink+" />");
		}
		var availableTags = <?php echo json_encode($listUser);?>;
		
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#to_username" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 1,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
	});
	</script>
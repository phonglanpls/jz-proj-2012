<?php $this->lang->load('newsletters/newsletter'); ?>

<h2><?php echo lang('newsletters.letter_title');?></h2>
<p><?php echo lang('newsletters.subscribe_desc');?></p>

<?php echo form_open('newsletters/subscribe'); ?>
	<p>
		<label for="email"><?php echo lang('newsletters.email_label');?>:</label>
		<?php echo form_input(array('name'=>'email', 'value'=>lang('newsletters.example_email'), 'size'=>20, 'onfocus'=>"this.value=''")); ?>
	</p>
		
	<p><?php echo form_submit('btnSignup', lang('newsletters.subscribe')) ?></p>
<?php echo form_close(); ?>
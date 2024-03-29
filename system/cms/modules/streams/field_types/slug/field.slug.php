<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * PyroStreams Slug Field Type
 *
 * @package		PyroStreams
 * @author		Parse19
 * @copyright	Copyright (c) 2011 - 2012, Parse19
 * @license		http://parse19.com/pyrostreams/docs/license
 * @link		http://parse19.com/pyrostreams
 */
class Field_slug
{
	public $field_type_slug			= 'slug';
	
	public $db_col_type				= 'varchar';

	public $custom_parameters		= array( 'space_type', 'slug_field' );

	public $version					= '1.0';

	public $author					= array('name'=>'Parse19', 'url'=>'http://parse19.com');

	// --------------------------------------------------------------------------

	/**
	 * Event
	 *
	 * Add the slugify function
	 *
	 * @access	public
	 * @return	void
	 */
	public function event()
	{
		$this->CI->type->add_misc("<script>function slugify_field(str, type){return str.toLowerCase().replace(/-+/g, '').replace(/\s+/g, type).replace(/[^a-z0-9_\-]/g, '');}</script>");
	}
	
	// --------------------------------------------------------------------------

	/**
	 * Output form input
	 *
	 * @access	public
	 * @param	array
	 * @return	string
	 */
	public function form_output( $params )
	{
		$options['name'] 	= $params['form_slug'];
		$options['id']		= $params['form_slug'];
		$options['value']	= $params['value'];
		
		$jquery = "<script>$('#{$params['custom']['slug_field']}').keyup(function() {
  
 	 	$('#{$params['form_slug']}').val( slugify_field($('#{$params['custom']['slug_field']}').val(), '{$params['custom']['space_type']}') );

		});	</script>";
		
		return form_input($options)."\n".$jquery;
	}

	// --------------------------------------------------------------------------

	/**
	 * Dash or Underscore?
	 */	
	public function param_space_type( $value = null )
	{	
		$options = array(
			'-' => $this->CI->lang->line('streams.slug.dash'),
			'_' => $this->CI->lang->line('streams.slug.underscore')
		);
	
		return form_dropdown('space_type', $options, $value);
	}

	// --------------------------------------------------------------------------

	/**
	 * What field to slugify?
	 */	
	public function param_slug_field( $value = null )
	{
		$this->CI->load->model('fields_m');
	
		// Get all the fields
		$fields = $this->CI->fields_m->get_all_fields();
		
		$drop = array();
		
		foreach($fields as $field):
			
			// We don't want no slugs.
			if($field['field_type'] != 'slug'):
			
				$drop[$field['field_slug']] = $field['field_name'];
			
			endif;
		
		endforeach;
		
		return form_dropdown('slug_field', $drop, $value);
	}

}

/* End of file field.encrypt.php */
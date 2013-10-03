<?php # -*- coding: utf-8 -*-
/**
 * Post meta data handler.
 *
 * @package    T5_Public_Preview
 * @subpackage Models
 */
class T5_Post_Meta implements T5_Post_Meta_Interface
{
	/**
	 * post meta field name.
	 *
	 * @type string
	 */
	protected $key;

	/**
	 * (non-PHPdoc)
	 * @see T5_Post_Meta_Interface::set_key()
	 */
	public function set_key( $key )
	{
		$this->key = $key;
	}

	/**
	 * (non-PHPdoc)
	 * @see T5_Post_Meta_Interface::save()
	 */
	public function save( $post_id, $post )
	{
		if ( wp_is_post_autosave( $post ) )
			return;

		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		if ( ! isset ( $_POST[ $this->get_input_name() ] ) )
			return delete_post_meta( $post_id, $this->key );

		if ( 1 != $_POST[ $this->get_input_name() ] )
			return;

		update_post_meta( $post_id, $this->key, 1 );
	}

	/**
	 * (non-PHPdoc)
	 * @see T5_Post_Meta_Interface::get_value()
	 */
	public function get_value( $post_id )
	{
		$value = get_post_meta( $post_id, $this->key, TRUE );

		return (int) $value;
	}

	/**
	 * (non-PHPdoc)
	 * @see T5_Post_Meta_Interface::get_input_name()
	 */
	public function get_input_name()
	{
		return "$this->key";
	}

	/**
	 * (non-PHPdoc)
	 * @see T5_Post_Meta_Interface::delete()
	 */
	public function delete( $new_status, $old_status, $post )
	{
		if ( 'publish' !== $new_status or 'publish' === $old_status )
			return;

		delete_post_meta( $post->ID, $this->key );
	}
}
<?php # -*- coding: utf-8 -*-

class T5_Post_Meta implements T5_Post_Meta_Interface
{
	protected $key;

	public function set_key( $key )
	{
		$this->key = $key;
	}

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

	public function get_value( $post_id )
	{
		$value = get_post_meta( $post_id, $this->key, TRUE );

		return (int) $value;
	}

	public function get_input_name()
	{
		return "$this->key";
	}

	public function delete( $new_status, $old_status, $post )
	{
		if ( 'publish' !== $new_status or 'publish' === $old_status )
			return;

		delete_post_meta( $post->ID, $this->key );
	}
}
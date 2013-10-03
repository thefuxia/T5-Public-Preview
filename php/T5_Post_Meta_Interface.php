<?php # -*- coding: utf-8 -*-

interface T5_Post_Meta_Interface
{
	public function set_key( $key );

	public function save( $post_id, $post );

	public function delete( $new_status, $old_status, $post );

	public function get_nonce();

	public function get_value( $post_id );

	public function get_input_name();
}
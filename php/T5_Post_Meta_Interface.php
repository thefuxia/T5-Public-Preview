<?php # -*- coding: utf-8 -*-
/**
 * Interface for post meta data handler.
 *
 * @package    T5_Public_Preview
 * @subpackage Models
 */
interface T5_Post_Meta_Interface
{
	/**
	 * Field key for database.
	 *
	 * @param  string $key
	 * @return void
	 */
	public function set_key( $key );

	/**
	 * Save post meta.
	 *
	 * @wp-hook save_post
	 * @param   int    $post_id
	 * @param   object $post
	 * @return  void
	 */
	public function save( $post_id, $post );

	/**
	 * Delete post meta on publish.
	 *
	 * @wp-hook transition_post_status
	 * @param   string $new_status
	 * @param   string $old_status
	 * @param   object $post
	 * @return  void
	 */
	public function delete( $new_status, $old_status, $post );

	/**
	 * Get post meta value.
	 *
	 * @param  int $post_id
	 * @return string|int
	 */
	public function get_value( $post_id );

	/**
	 * Value for 'name' attribute for the element 'input'.
	 *
	 * @return string
	 */
	public function get_input_name();
}
<?php # -*- coding: utf-8 -*-
/**
 * Show endpoint content.
 *
 * @package    T5_Public_Preview
 * @subpackage Views
 */
class T5_Render_Endpoint
{
	/**
	 * Endpoint handler.
	 *
	 * @type T5_Endpoint_Interface
	 */
	protected $endpoint;

	/**
	 * Post meta handler.
	 *
	 * @type T5_Post_Meta_Interface
	 */
	protected $meta;

	/**
	 * Store endpoint handler.
	 *
	 * @param  T5_Endpoint_Interface $endpoint
	 * @return void
	 */
	public function set_endpoint_handler( T5_Endpoint_Interface $endpoint )
	{
		$this->endpoint = $endpoint;
	}

	/**
	 * Store post meta handler.
	 *
	 * @param  T5_Post_Meta_Interface $meta
	 * @return void
	 */
	public function set_post_meta_handler( T5_Post_Meta_Interface $meta )
	{
		$this->meta = $meta;
	}

	/**
	 * Create output.
	 *
	 * In fact, all this does is overwriting the main query with query_posts()
	 * or redirecting.
	 *
	 * @return void
	 */
	public function render()
	{
		$post_id = $this->endpoint->get_value();

		// Let WP raise a 404.
		if ( ! $post_id )
			return;

		// Not a valid address anymore.
		if ( 1 !== $this->meta->get_value( $post_id )
			or 'publish' === get_post_status( $post_id )
			)
		{
			wp_redirect( get_permalink( $post_id ) );
			exit;
		}

		$query = array (
			'suppress_filters' => TRUE,
			'p'                => $post_id,
			'post_type'        => 'any'
		);

		// Overwrite the main query
		query_posts( $query );

		// Prevent search engine indexing.
		add_action( 'wp_head', 'wp_no_robots' );
	}
}
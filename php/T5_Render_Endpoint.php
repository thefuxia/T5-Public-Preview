<?php # -*- coding: utf-8 -*-

class T5_Render_Endpoint
{
	protected $endpoint, $meta;

	public function set_endpoint_handler( T5_Endpoint_Interface $endpoint )
	{
		$this->endpoint = $endpoint;
	}

	public function set_post_meta_handler( T5_Post_Meta_Interface $meta )
	{
		$this->meta = $meta;
	}

	public function render()
	{
		$post_id = $this->endpoint->get_value();

		if ( ! $post_id )
			return;

		if ( 1 !== $this->meta->get_value( $post_id )
			or 'publish' === get_post_status( $post_id )
			)
		{
			wp_redirect( get_permalink( $post_id ) );
			exit;
		}

		$type = get_post_type( $post_id );

		$query = array (
			'suppress_filters' => TRUE,
			'p'                => $post_id,
			'post_type'        => 'any'
		);

		query_posts( $query );

		add_action( 'wp_head', 'wp_no_robots' );
	}

}
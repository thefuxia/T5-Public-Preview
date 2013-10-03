<?php # -*- coding: utf-8 -*-
/**
 * Endpoint handler.
 *
 * @package    T5_Public_Preview
 * @subpackage Models
 */
class T5_Endpoint implements T5_Endpoint_Interface
{
	/**
	 * Endpoint name
	 *
	 * @type string
	 */
	protected $name;

	/**
	 * Endpoint position.
	 *
	 * @type int
	 */
	protected $position;

	/**
	 * (non-PHPdoc)
	 * @see T5_Endpoint_Interface::register()
	 */
	public function register( $name, $position = EP_ROOT )
	{
		$this->name     = $name;
		$this->position = $position;

		add_rewrite_endpoint( $name, $position );
		$this->fix_failed_registration();

		add_filter( 'request', array ( $this, 'set_query_var' ) );
	}

	/**
	 * (non-PHPdoc)
	 * @see T5_Endpoint_Interface::get_url()
	 */
	public function get_url( $value )
	{
		if ( EP_ROOT === $this->position )
			return user_trailingslashit( site_url( "$this->name/$value" ) );

		return user_trailingslashit( rtrim( get_permalink( $value ), '/' ) . "/$this->name/$value" );

		// incomplete, doesn't handle terms and taxonomies
	}

	/**
	 * (non-PHPdoc)
	 * @see T5_Endpoint_Interface::get_value()
	 */
	public function get_value()
	{
		$value = (int) get_query_var( $this->name );

		// get_query_var() returns an empty string for missing values.
		return '' === $value ? FALSE : $value;
	}

	/**
	 * Set the endpoint variable to TRUE.
	 *
	 * If the endpoint was called without further parameters it does not
	 * evaluate to TRUE otherwise.
	 *
	 * @wp-hook request
	 * @param   array $vars
	 * @return  array
	 */
	public function set_query_var( Array $vars )
	{
		if ( ! empty ( $vars[ $this->name ] ) )
			return $vars;

		// When a static page was set as front page, the WordPress endpoint API
		// does some strange things. Let's fix that.
		//if ( isset ( $vars[ $this->name ] ) )			echo $vars[ $this->name ];

		if ( isset ( $vars[ $this->name ] ) )
			$vars[ $this->name ] = TRUE;

		if ( ( isset ( $vars[ 'pagename' ] ) and $this->name === $vars[ 'pagename' ] )
			or ( isset ( $vars[ 'page' ] ) and $this->name === $vars[ 'page' ] )
		)
		{
			// In some cases WP misinterprets the request as a page request and
			// returns a 404.
			$vars[ $this->name ] = trim( $vars[ 'page' ], '/' );
			$vars[ 'page' ] = $vars[ 'pagename' ] = $vars[ 'name' ] = FALSE;
		}

		return $vars;
	}

	/**
	 * Fix rules flushed by other peoples code.
	 *
	 * @wp-hook wp_loaded
	 * @return  void
	 */
	protected function fix_failed_registration()
	{
		global $wp_rewrite;

		if ( empty ( $wp_rewrite->endpoints ) )
			return flush_rewrite_rules( FALSE );

		foreach ( $wp_rewrite->endpoints as $endpoint )
		{
			if ( $endpoint[0] === $this->position && $endpoint[1] === $this->name )
				return;
		}

		flush_rewrite_rules( FALSE );
	}
}
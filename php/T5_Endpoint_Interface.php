<?php # -*- coding: utf-8 -*-
/**
 * Interface for endpoint handler.
 *
 * @package    T5_Public_Preview
 * @subpackage Models
 */
interface T5_Endpoint_Interface
{
	/**
	 * Register an endpoint.
	 *
	 * @param  string $name
	 * @param  int    $position
	 * @return void
	 */
	public function register( $name, $position = EP_ROOT );

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
	public function set_query_var( Array $vars );

	/**
	 * Get value after the endpoint in the request URL.
	 *
	 * @return int|string|bool FALSE if the value is empty.
	 */
	public function get_value();

	/**
	 * Get an URL for a given ID, eg. a post ID.
	 *
	 * @param  string|int $value
	 * @return string
	 */
	public function get_url( $value );
}
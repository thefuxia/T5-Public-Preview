<?php # -*- coding: utf-8 -*-

interface T5_Endpoint_Interface
{
	public function register( $name, $position = EP_ROOT );

	public function set_query_var( Array $vars );

	public function get_value();

	public function get_url( $value );
}
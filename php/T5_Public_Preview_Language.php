<?php # -*- coding: utf-8 -*-
class T5_Public_Preview_Language implements T5_Language_Interface
{
	protected $dir;
	/**
	 * Constructor.
	 */
	public function __construct( $dir )
	{
		$this->dir = basename( $dir ) . '/languages';
	}

	/**
	 * Loads translation file.
	 *
	 * @return bool
	 */
	public function load()
	{
		return load_plugin_textdomain( 'plugin_t5_public_preview', FALSE, $this->dir );
	}

	/**
	 * Remove translations from memory.
	 *
	 * @return void
	 */
	public function unload()
	{
		unset ( $GLOBALS['l10n']['plugin_t5_public_preview'] );
	}
}
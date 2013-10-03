<?php # -*- coding: utf-8 -*-
/**
 * Interface for translation loader.
 *
 * @package    T5_Public_Preview
 * @subpackage Models
 */
interface T5_Language_Interface
{
	/**
	 * Load language.
	 *
	 * @return bool TRUE when a mo file was found, FALSE otherwise.
	 */
	public function load();

	/**
	 * Remove translation object from memory.
	 *
	 * @return void
	 */
	public function unload();
}
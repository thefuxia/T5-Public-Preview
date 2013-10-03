<?php # -*- coding: utf-8 -*-
/**
 * Main controller.
 *
 * @package    T5_Public_Preview
 * @subpackage Controllers
 */
class T5_Public_Preview
{
	/**
	 * Path to plugin directory.
	 *
	 * @type string
	 */
	protected $dir;

	/**
	 * Constructor.
	 *
	 * @wp-hook wp_loaded
	 */
	public function __construct( $dir )
	{
		$this->dir = $dir;
	}

	/**
	 * Create objects
	 *
	 * @wp-hook wp_loaded
	 * @return  void
	 */
	public function setup()
	{
		$this->load_classes();

		$lang = new T5_Public_Preview_Language( $this->dir );
		$lang->load();

		$endpoint = new T5_Endpoint;
		// If you translate this, avoid reserved words like 'preview' or 'draft'.
		// That would mess up the global $wp_query.
		$endpoint->register(
			_x( 'post-preview', 'endpoint url prefix', 'plugin_t5_public_preview' )
		);

		$meta = new T5_Post_Meta;
		$meta->set_key( '_allow_public_preview' );

		if ( is_admin() )
		{
			$action = 'post_submitbox_misc_actions';
			add_action( 'save_post', array ( $meta, 'save' ), 10, 2 );

			$view   = new T5_Publish_Box_View;
			$view->set_language_handler( $lang );
		}
		else
		{
			$lang->unload();
			$action = 'template_redirect';
			$view   = new T5_Render_Endpoint;
		}

		$view->set_post_meta_handler( $meta );
		$view->set_endpoint_handler( $endpoint );

		add_action( $action, array ( $view, 'render' ), PHP_INT_MAX );
		add_action( 'transition_post_status', array ( $meta, 'delete' ), 10, 3 );
	}

	/**
	 * Instead of an auto-loader we load everything immediately.
	 *
	 * @wp-hook wp_loaded
	 * @return  void
	 */
	protected function load_classes()
	{
		$classes = array (
			'T5_Endpoint_Interface',
			'T5_Post_Meta_Interface',
			'T5_Language_Interface',
			'T5_Public_Preview_Language',
			'T5_Endpoint',
			'T5_Publish_Box_View',
			'T5_Render_Endpoint',
			'T5_Post_Meta',
		);

		foreach ( $classes as $class )
		{
			if ( ! class_exists( $class ) and ! interface_exists( $class ) )
				require "$this->dir/php/$class.php";
		}
	}
}
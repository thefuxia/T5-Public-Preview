<?php # -*- coding: utf-8 -*-

class T5_Public_Preview
{
	protected $dir;
	/**
	 * Constructor.
	 */
	public function __construct( $dir )
	{
		$this->dir = $dir;
	}

	public function setup()
	{
		$this->load_classes();

		$lang = new T5_Public_Preview_Language( $this->dir );
		$lang->load();

		$endpoint = new T5_Endpoint;
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
			class_exists( $class ) or require "$this->dir/php/$class.php";
	}
}
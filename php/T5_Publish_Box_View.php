<?php # -*- coding: utf-8 -*-

class T5_Publish_Box_View
{
	protected $endpoint, $meta, $lang;

	public function set_post_meta_handler( T5_Post_Meta_Interface $meta )
	{
		$this->meta = $meta;
	}

	public function set_endpoint_handler( T5_Endpoint_Interface $endpoint )
	{
		$this->endpoint = $endpoint;
	}

	public function set_language_handler( T5_Language_Interface $lang )
	{
		$this->lang = $lang;
	}

	public function render()
	{
		$post_id = get_the_ID();

		if ( 'publish' === get_post_status( $post_id ) )
			return;

		$name    = $this->meta->get_input_name();
		$id      = $name . '_id';
		$value   = esc_attr( $this->meta->get_value( $post_id ) );
		$link    = $this->get_link( $value, $post_id );
		$checked = checked( $value, 1, FALSE );

		$label = __( 'Enable public preview', 'plugin_t5_public_preview' );
		$this->lang->unload();

		print <<<EOD
<div class="misc-pub-section">
	<label for="$id">
		<input type="checkbox" $checked id="$id" name="$name" value="1" />
		$label
	</label>
	$link
</div>
EOD;
	}

	protected function get_link ( $value, $post_id )
	{
		if ( empty ( $value ) )
			return;

		$url  = $this->endpoint->get_url( $post_id );
		return "<br><a href='$url'>$url</a>";
	}
}
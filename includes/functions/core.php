<?php

if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}

// Create a metabox
// Meta Box Class: Jgj_Metabox
// Get the field value: $metavalue = get_post_meta( $post_id, $field_id, true );
class Jgj_Metabox{


	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}

	public function add_meta_boxes() {
			add_meta_box(
				'Jgj_citation',
				__( 'JGJ Citation', 'jgj-citation' ),
				array( $this, 'meta_box_callback' ),
				'post',
				'normal',
				'default'
			);
		
	}
	
	public function meta_box_callback( $post ) {
		wp_nonce_field( 'Jgj_citation_data', 'Jgj_citation_nonce' );
		$this->field_generator( $post );
	}
	public function field_generator( $post ) {
			$meta_field =array(
				'label' => __( 'Agrega aquí todas las citas', 'jgj-citation' ),
				'id' => 'meta_citation',
				'type' => 'WYSIWYG'
			);
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				if ( isset( $meta_field['default'] ) ) {
					$meta_value = $meta_field['default'];
				}
			}
			echo '<h2 class="jgj_postbox_h2">'.$label.'</h2>';
			$content   = $meta_value;
			$editor_id = $meta_field['id'];
			$settings  = '';
			wp_editor($content, $editor_id, $settings);
	}
	



	public function save_fields( $post_id ) {
		$meta_field =array(
			'label' => __( 'Agrega aquí todas las citas', 'jgj-citation' ),
			'id' => 'meta_citation',
			'type' => 'WYSIWYG'
		);

		if ( ! isset( $_POST['Jgj_citation_nonce'] ) )
			return $post_id;
		$nonce = $_POST['Jgj_citation_nonce'];
		if ( !wp_verify_nonce( $nonce, 'Jgj_citation_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		
	}
	

}

if (class_exists('Jgj_Metabox')  )  {
    $jgj_metabox =	new Jgj_Metabox;
};







// Create Shortcode jgj_citation
// Shortcode: [jgj_citation post_id="ID"]

add_action('init', 'add_shortcode_citation' );
function add_shortcode_citation(){
	add_shortcode( 'jgj_citation', 'create_citation_shortcode' );
}
function create_citation_shortcode($atts) {
	//attributes
	$postID = get_queried_object_id();
	$atts = shortcode_atts(['post_id' => $postID], $atts, 'jgj_citation' );
	
	//atts variable
    $post_id = $atts['post_id'];

	//Show Content
	$citation = get_post_meta($post_id, 'meta_citation', true);

	if ( empty($citation) ) {
		return __( 'El contenido de citas de autores está vacío', 'jgj-citation' );
	}else{
		return '<div class="citation_container">'.$citation.'</div>';
	}	
}


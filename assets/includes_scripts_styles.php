<?php

if ( ! defined('ABSPATH') ) {
    die('Direct access not permitted.');
}
function includes_scripts_styles(){
    //css
    $url_styles = plugins_url( '/css/jgj-citation.css', __FILE__ );  
    wp_register_style('jgj_citation-styles',$url_styles);
    wp_enqueue_style('jgj_citation-styles');
    //js
    $url_scripts = plugins_url( '/js/jgj-citation.js', __FILE__ );
    wp_register_script( 'jgj_citation-scripts', $url_scripts);
    wp_enqueue_script('jgj_citation-scripts');
    }
includes_scripts_styles();
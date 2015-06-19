<?php
/**
 * Plugin Name: YouTube New Generation
 * Plugin URI: http://www.feijaocosta.com.br/youtube-new-generation
 * Description: Lista os últimos vídeos de um usuário, buscando os dados utilizando a Google Api V3, e salvando os dados em cache. Após ativar o plugin, faça as configurações <a href="admin.php?page=youtube-new-generation%2Fadmin.php">aqui</a>.
 * Version: 1.0
 * Author: Feijao Costa
 * Author URI: http://br.linkedin.com/in/feijao 
 * License: GPL2
 */
 
//define('WP_DEBUG', true);

register_activation_hook( __FILE__, 'yt_nw_gen_activation' );
register_deactivation_hook( __FILE__, 'yt_nw_gen_deactivation' );


// Scheduling data update

function cron_add_custom_schedule( $schedules ) {
	$schedules['manytimes'] = array(
		'interval' => 600,
		'display' => __( 'Six Times Hourly' )
	);
	return $schedules;
}	

add_filter( 'cron_schedules', 'cron_add_custom_schedule' );	

function yt_nw_gen_update_videos() {
	$settings = json_decode(get_option('yt_nw_gen_settings'),true);
	$google_key = $settings["google_key"];
	$playlist = $settings["playlist"];
	
	$handle = wp_remote_fopen("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=$playlist&key=$google_key", "r");
	
	update_option('yt_nw_gen_videos',$handle);
}

add_action( 'yt_nw_gen_update_videos_hook', 'yt_nw_gen_update_videos' ); 


function yt_nw_gen_activation() {

	// Setting default data
	$google_key = "AIzaSyDLp2QMa1v9xnFuMrWzXL8NzLKhWieV-co";
	$youtube_user = "feijaocosta";
	

	$handle = wp_remote_fopen("https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=$youtube_user&key=$google_key", "r");
	$contents = json_decode($handle,true);
	
	$playlist = $contents["items"][0]["contentDetails"]["relatedPlaylists"]["uploads"];

	add_option('yt_nw_gen_settings', '{"google_key":"' . $google_key . '","youtube_user":"' . $youtube_user . '","playlist":"' . $playlist . '"}', '', 'yes' );
	add_option('yt_nw_gen_videos','{}', '', 'yes');
	
	wp_schedule_event( time(), 'manytimes', 'yt_nw_gen_update_videos_hook' );

	
	// Make first update
	yt_nw_gen_update_videos();	
	
}

function yt_nw_gen_deactivation() {
	delete_option('yt_nw_gen_settings');
	delete_option('yt_nw_gen_videos');
	wp_clear_scheduled_hook( 'yt_nw_gen_update_videos_hook' );
}

// Register style sheet.
add_action( 'wp_enqueue_scripts', 'yt_nw_gen_register_plugin_styles' );

/**
 * Register style sheet.
 */
function yt_nw_gen_register_plugin_styles() {
	wp_register_style( 'yt_nw_gen_style', plugins_url( 'youtube-new-generation/css/style.css' ) );
	wp_enqueue_style( 'yt_nw_gen_style' );
}


// Create Shortcode
//[yt_new]
function yt_nw_gen_show_html( $atts ){
	$atts = shortcode_atts(
		array(
			'list' => "true",
		), $atts, 'yt_new' );

	//return($atts['list']);

	$videos = json_decode(get_option('yt_nw_gen_videos'),true);
	
	if(count($videos["items"]) >0){


		if ($atts['list'] == "true"){

			$html ='		<div class="row">';
			$html .='			<div class="col">';
			$html .='				<div class="responsive-video">';
			$html .='					<iframe name="ytvideo" width="560" height="315" src="http://www.youtube.com/embed/' . $videos["items"][0]["snippet"]["resourceId"]["videoId"] . '" frameborder="0" allowfullscreen></iframe>';
			$html .='				</div>';
			$html .='			</div>';
	

			$html .='			<div class="ytn-thumbs">';
	
			foreach($videos["items"] as $video){
				$html .='		<a href="http://www.youtube.com/embed/' . $video["snippet"]["resourceId"]["videoId"] . '" target="ytvideo">';
				$html .='			<div>';
				$html .='				<img src="' . $video["snippet"]["thumbnails"]["default"]["url"] . '" alt="' . $video["snippet"]["title"] . '" class="img-responsive" align="top">';
				$html .='			</div>';
				$html .='			<p>' . $video["snippet"]["title"] . '</p>';
				$html .='		</a>';
			}

			$html .='			</div>';
			$html .='		</div>';
		
		}else{
			$html ='				<div class="responsive-video">';
			$html .='					<iframe name="ytvideo" width="560" height="315" src="http://www.youtube.com/embed/' . $videos["items"][0]["snippet"]["resourceId"]["videoId"] . '" frameborder="0" allowfullscreen></iframe>';
			$html .='				</div>';
		}
		


	}elseif(count($videos["error"]) >0){
		$html = "Erro: ";
		foreach($videos["error"]["errors"] as $error){
			$html .= $error["message"] . "<br>";
		}
	
	}else{
		$html = "Não há vídeos a serem exibidos.";
	}


	return $html;
}
add_shortcode( 'yt_new', 'yt_nw_gen_show_html' );	


add_action( 'admin_menu', 'yt_nw_gen_menu' );

function yt_nw_gen_menu() {
	add_menu_page( 'YouTube New Generation - Settings', 'YouTube New Generation', 'manage_options', 'youtube-new-generation/admin.php');
}



?>

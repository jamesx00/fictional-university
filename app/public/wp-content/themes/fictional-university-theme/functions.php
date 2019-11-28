<?php

require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

function university_custom_rest() {
	register_rest_field('post', 'authorName', array(
		'get_callback' => function() {
			return get_the_author();
		},
	));

	register_rest_field('note', 'userNoteCount', array(
		'get_callback' => function() {
			return count_user_posts(get_current_user_id(), 'note');
		},
	));
}
add_action('rest_api_init', 'university_custom_rest');

function pageBanner($args=NULL) { 
	// php logic will live here

	$title = $args['title'] ?? get_the_title();
	$subtitle = $args['subtitle'] ?? get_field('page_banner_subtitle');
	$photo = $args['photo'] ?? ( get_field('page_banner_background_image')['sizes']['pageBanner'] ?? 'https://wonderfulengineering.com/wp-content/uploads/2016/01/Desktop-Wallpaper-4.jpg') ;

	?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php echo $photo; ?>);"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php echo $title; ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $subtitle; ?></p>
			</div>
		</div>  
	</div>

<?php
}


function university_files() {


	wp_enqueue_script('main-university-javascript', get_theme_file_uri('/js/scripts-bundled.js'), array('jquery'), microtime(), true);

	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font-awesome', '//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

	wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());

	wp_localize_script('main-university-javascript', 'universityData', array(
		'root_url' => get_site_url(),
		'nonce' => wp_create_nonce('wp_rest'),
	));

}
add_action('wp_enqueue_scripts', 'university_files');

function university_features() {

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_image_size('professorLandscape', 400, 260, true);
	add_image_size('professorPortrait', 480, 650, true);
	add_image_size('pageBanner', 1500, 350, true);

}
add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query) {

	if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', -1);
	}

	$today = date('Ymd');
	if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
			'key' => 'event_date',
			'compare' => '>=',
			'value' => $today,
			'type' => 'numeric',
			)
		);	
	}

}
add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api) {
	$api['key'] = "AIzaSyCYPYWSSWYF8dof62P9AB62hKa73u2m3Xs";
	return $api;
}
add_filter('acf/fields/google_map/api', 'universityMapKey');



// redirect subscriber accounts out of admin and onto homepage
function redirectSubsToFrontEnd() {
	$currentUser = wp_get_current_user();
	if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
		wp_redirect(site_url());
		exit;
	}
}
add_action('admin_init', 'redirectSubsToFrontEnd');


function noSubsAdminBar() {
	$currentUser = wp_get_current_user();
	if (count($currentUser->roles) == 1 AND $currentUser->roles[0] == 'subscriber') {
		show_admin_bar(false);
	}
}
add_action('wp_loaded', 'noSubsAdminBar');


// customize login screen
function ourHeaderUrl() {
	return esc_url(site_url('/'));
}
add_filter('login_headerurl', 'ourHeaderUrl');

function ourLoginCss() {
	wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime()); 
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}
add_action('login_enqueue_scripts', 'ourLoginCss');


function ourLoginTitle() {
	return get_bloginfo('name');
}
add_filter('login_headertitle', 'ourLoginTitle');


// Force note posts to be private
function makeNotePrivate($data, $postarr) {

	if ($data['post_type'] == 'note') {

		if (count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']) {
			die("You have reached your note limit");
		}

		$data['post_content'] = sanitize_textarea_field($data['post_content']);
		$data['post_title'] = sanitize_text_field($data['post_title']);
	}

	if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
		$data['post_status'] = 'private';	
	}
	
	return $data;
}
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);





?>
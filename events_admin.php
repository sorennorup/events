<?php
    //*********** ADDS PLUGIN ADMINPAGE THE ADMIN MENU***********//
  

function test_plugin_setup_menu(){
	add_menu_page( 'Display plugin Setup', 'Display plugin', 'manage_options', 'Plugin', 'plugin_options_page' );
}

function add_settings_page() {
    add_options_page( 'Event settings page', 'Event Settings', 'manage_options', 'event-plugin', 'plugin_options_page' );
}
add_action( 'admin_menu', 'add_settings_page' );
 
//*********** display the admin options page*********//
function plugin_options_page() {
    ?>
	<div>
    <h2>My custom plugin</h2>
    Options relating to the Custom Plugin.
    <form action="options.php" method="post">
    	<?php settings_fields('plugin_options'); ?>
        <?php do_settings_sections('plugin'); ?>
        <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>
	</div>
	<?php
}

function plugin_admin_init(){
	register_setting( 'plugin_options', 'plugin_options', 'plugin_options_validate' );
    add_settings_section('plugin_main', 'Main Settings', 'plugin_section_text', 'plugin');
    add_settings_field('plugin_text_string', 'Plugin Text Input', 'plugin_setting_string', 'plugin', 'plugin_main');
}

function plugin_setting_string() {
    $options = get_option('plugin_options');
    echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
} 

function plugin_section_text() {
    echo '<p>Main description of this section here.</p>';
} 

function plugin_options_validate($input) {
    $newinput['text_string'] = trim($input['text_string']);
    if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
     $newinput['text_string'] = '';
}
    return $newinput;
}
// Creates custom posttype for the plugin
function custom_post_type() {
	 
	$labels = array(
		'name'                => _x( 'events', 'Post Type General Name', 'pro' ),
		'singular_name'       => _x( 'event', 'Post Type Singular Name', 'pro' ),
		'menu_name'           => __( 'events', 'pro' ),
		'parent_item_colon'   => __( 'Parent Item:', 'pro' ),
		'all_items'           => __( 'All events', 'pro' ),
		'view_item'           => __( 'Se eventsemne', 'pro' ),
		'add_new_item'        => __( 'Tilføj ny event', 'pro' ),
		'add_new'             => __( 'Tilføj nyt', 'pro' ),
		'edit_item'           => __( 'Rediger event', 'pro' ),
		'update_item'         => __( 'Opdater event ', 'pro' ),
		'search_items'        => __( 'søg efter events', 'pro' ),
		'not_found'           => __( 'Ikke fundet', 'pro' ),
		'not_found_in_trash'  => __( 'Ikke fundet i events', 'pro' ),
	);
	$args = array(
		'label'               => __( 'event' ),
		'description'         => __( 'Det sker lige nu', 'pro' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail'),
		'taxonomies'          => array( 'events_category' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'show_in_rest' => true, // turns on the new blockeditor
		'supports' => array('title','editor') //  turns on the new blockeditor
	);
	register_post_type( 'event', $args );
	flush_rewrite_rules();    // Fixes the permalink bug for custom posts
	 // "project Categories" Custom Taxonomy
    $labels = array(
        'name' => __( 'events Categories', 'taxonomy general name' ),
        'singular_name' => __( 'events Category', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Didkatik Categories' ),
    	'all_items' => __( 'All Didkatik Categories' ),
        'parent_item' => __( 'Parent events Category' ),
        'parent_item_colon' => __( 'Parent events Category:' ),
        'edit_item' => __( 'Edit events Category' ),
        'update_item' => __( 'Update events Category' ),
        'add_new_item' => __( 'Add New events Category' ),
        'new_item_name' => __( 'New events Category Name' ),
        'menu_name' => __( 'events Categories')
    );

    $args = array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column'   => false,
                'query_var' => true,
				'rewrite' => array( 'slug' => 'project-category' ),
				
    );

    register_taxonomy( 'events-category', array( 'events' ), $args );
}

add_action('admin_init', 'plugin_admin_init');

  //******CREATES A CUSTOM POST TEMPLATE
add_action( 'init', 'custom_post_type' );

?>
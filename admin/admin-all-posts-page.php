<?php
/**
	* Add new column and Show Polr URL in polr URL Column
	* polr URL is the new column name
	*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
  * @wp-hook manage_posts_columns
	* Add new column
	* polr URL is the new column name
	*/
function set_polr_columns_head($defaults) {
    $defaults['polr_shortened_url'] = 'polr URL';
    return $defaults;
}
add_filter('manage_posts_columns', 'set_polr_columns_head');


/**
  * @wp-hook manage_posts_custom_column
	* Show Polr URL in polr URL column
	*/
function set_polr_columns_content($column_name, $post_ID) {
    if ($column_name == 'polr_shortened_url') {
				$value = get_post_custom($post->ID); // Get post metadata
				$polr_link = esc_attr($value['polr_shortened_url'][0]); // Get polr_shortened_url value
        if ($polr_link) {
            echo $polr_link;
        }
    }
}
add_action('manage_posts_custom_column', 'set_polr_columns_content', 10, 2);

?>

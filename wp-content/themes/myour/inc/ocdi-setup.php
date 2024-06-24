<?php

function myour_ocdi_import_files() {
    return array(
        array(
            'import_file_name'             => esc_attr__( 'Light', 'myour' ),
            'categories'                   => array( esc_attr__( 'Main', 'myour' ) ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/02/content.xml',
            'import_preview_image_url'     => get_template_directory_uri() . '/demo/02/preview.jpg',
            'preview_url'                  => esc_url( 'https://myour.bslthemes.com/v2' ),
        ),
        array(
            'import_file_name'             => esc_attr__( 'Default', 'myour' ),
            'categories'                   => array( esc_attr__( 'Main', 'myour' ) ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/01/content.xml',
            'import_preview_image_url'     => get_template_directory_uri() . '/demo/01/preview.jpg',
            'preview_url'                  => esc_url( 'https://myour.bslthemes.com/' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'myour_ocdi_import_files' );

function myour_ocdi_after_import_setup( $selected_import ) {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'posts_per_page', 6 );

    $ocdi_fields_static = array(
    	'options_header_logo_img' => 13,
        '_options_header_logo_img' => 'field_5d11763c9ed10',
        'options_header_logo_txt' => 'Joé 
Wilson',
        '_options_header_logo_txt' => 'field_5ed3d068e1a1e',
        'options_header_download_btn' => 1,
        '_options_header_download_btn' => 'field_5ed3fb826185b',
        'options_header_download_btn_txt' => 'Download CV',
        '_options_header_download_btn_txt' => 'field_5ed3fbcb6185c',
        'options_header_download_btn_url' => '#',
        '_options_header_download_btn_url' => 'field_5ed3fc1a6185d',
        'options_header_download_btn_ico' => 'fas fa-download',
        '_options_header_download_btn_ico' => 'field_5ed3fc3c6185e',
        'options_vcard_type' => 0,
        '_options_vcard_type' => 'field_5ed3fd0eea45d',
        'options_vcard_image' => 14,
        '_options_vcard_image' => 'field_5ed404ad72663',
        'options_footer_text' => '&copy; 2020 Myour all right reserved.',
        '_options_footer_text' => 'field_5b68cceac1b66',
        'options_social_links' => 3,
        '_options_social_links' => 'field_5b68ccabc1b63',
        'options_blog_subtitle' => '',
        '_options_blog_subtitle' => 'field_5e5e39b87f0e0',
        'options_blog_categories' => 0,
        '_options_blog_categories' => 'field_5b81b6d930cb9',
        'options_blog_excerpt' => 0,
        '_options_blog_excerpt' => 'field_5b81b7ca30cba',
        'options_blog_featured_img' => 1,
        '_options_blog_featured_img' => 'field_5ee8e1ce18975',
        'options_social_share' => 'a:5:{i:0;s:8:"facebook";i:1;s:7:"twitter";i:2;s:8:"linkedin";i:3;s:6:"reddit";i:4;s:9:"pinterest";}',
        '_options_social_share' => 'field_5c610c399cf20',
        'options_p404_title' => 'Whoops!',
        '_options_p404_title' => 'field_5d180fd559b7f',
        'options_p404_content' => 'The page you\'re looking for doesn\'t exist or has been moved.',
        '_options_p404_content' => 'field_5d180feb59b80',
        'options_social_links_0_icon' => 'fab fa-facebook-f',
        '_options_social_links_0_icon' => 'field_5d879352bc7a2',
        'options_social_links_0_url' => 'https://www.facebook.com/',
        '_options_social_links_0_url' => 'field_5b68ccd7c1b65',
        'options_social_links_1_icon' => 'fab fa-instagram',
        '_options_social_links_1_icon' => 'field_5d879352bc7a2',
        'options_social_links_1_url' => 'https://www.instagram.com/',
        '_options_social_links_1_url' => 'field_5b68ccd7c1b65',
        'options_social_links_2_icon' => 'fab fa-dribbble',
        '_options_social_links_2_icon' => 'field_5d879352bc7a2',
        'options_social_links_2_url' => 'https://dribbble.com/',
        '_options_social_links_2_url' => 'field_5b68ccd7c1b65',
    );
    $ocdi_fields_to_change = array();
    
    if( 'Default' === $selected_import['import_file_name'] ) {
        $ocdi_fields_to_change = array(
            'options_theme_ui' => 0,
            '_options_theme_ui' => 'field_5f65e5ced5330',
            'options_theme_bg_color' => '#373b40',
            '_options_theme_bg_color' => 'field_5f65e689d5331',
            'options_theme_color' => '#68e0cf',
            '_options_theme_color' => 'field_5b68d509665d9',
            'options_heading_color' => '#FFFFFF',
            '_options_heading_color' => 'field_5b68d5d8665da',
            'options_text_color' => '#FFFFFF',
            '_options_text_color' => 'field_5b68d617665db',
            'options_heading_font_family' => 0,
            '_options_heading_font_family' => 'field_5b68cfc4906fc',
            'options_text_font_family' => 0,
            '_options_text_font_family' => 'field_5b68d188906fd',
            'options_heading_font_size' => '',
            '_options_heading_font_size' => 'field_5eea66185ad1d',
            'options_text_font_size' => '',
            '_options_text_font_size' => 'field_5eea66ad5ad1e',
            'options_menu_font_size' => '',
            '_options_menu_font_size' => 'field_5eea67685ad1f',
            'options_menu_font_color' => '',
            '_options_menu_font_color' => 'field_5eea679c5ad20',
            'options_menu_font_family' => 0,
            '_options_menu_font_family' => 'field_5eea67ef5ad21',
        );
    }

    if( 'Light' === $selected_import['import_file_name'] ) {
        $ocdi_fields_to_change = array(
            'options_theme_ui' => 1,
            '_options_theme_ui' => 'field_5f65e5ced5330',
            'options_theme_bg_light_color' => '#FFFFFF',
            '_options_theme_bg_light_color' => 'field_5f65e6e2d5332',
            'options_header_logo_img' => 129,
            '_options_header_logo_img' => 'field_5d11763c9ed10',
            'options_vcard_image' => 128,
            '_options_vcard_image' => 'field_5ed404ad72663',
            'options_theme_color' => '#00bf9f',
            '_options_theme_color' => 'field_5b68d509665d9',
            'options_heading_light_color' => '#262728',
            '_options_heading_light_color' => 'field_5f65e70cd5333',
            'options_text_light_color' => '#585858',
            '_options_text_light_color' => 'field_5f65e755d5334',
            'options_menu_font_light_color' => '#262728',
            '_options_menu_font_light_color' => 'field_5f65e77cd5335',
        );
    }

    global $wpdb;
    foreach ( array_merge( $ocdi_fields_static, $ocdi_fields_to_change ) as $field => $value ) {
        if ( $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->options WHERE option_name = %s", $field ) ) == 0 ) {
            $wpdb->query( $wpdb->prepare( "INSERT INTO $wpdb->options ( option_name, option_value, autoload ) VALUES (%s, %s, 'no')", $field, $value ) );
        } else {
            $wpdb->query( $wpdb->prepare( "UPDATE $wpdb->options SET option_value = %s WHERE option_name = %s", $value, $field ) );
        }
    }

}
add_action( 'pt-ocdi/after_import', 'myour_ocdi_after_import_setup' );
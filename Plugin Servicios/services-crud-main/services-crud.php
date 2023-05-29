<?php
/*
Plugin Name: CRUD Servicios
Plugin URI: https://github.com/julianloaiza/Engix/tree/main/Plugin%20Servicios
Description: El plugin "CRUD Servicios" permite a los usuarios gestionar y mostrar listados de servicios en su sitio web de WordPress.
Author: Julian Loaiza
Author URI: https://github.com/julianloaiza/
Version: 1.0
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'crud_plugin_base_URL', plugin_dir_url(__FILE__));
define( 'crud_plugin_base_PATH', plugin_dir_path(__FILE__));
define( 'crud_plugin_V', '1.0');
define( 'crud_plugin_role', 'engineer');

require_once 'helper.php';
require_once 'shortcodes.php';

// Register Custom Post Type & Custom Taxonomy
function service_crud_post_type() {

    $labels = array(
        'name'                  => _x( 'Servicios', 'Post Type General Name', 'service_crud_post_type' ),
        'singular_name'         => _x( 'Servicio', 'Post Type Singular Name', 'service_crud_post_type' ),
        'menu_name'             => __( 'Servicios', 'service_crud_post_type' ),
        'name_admin_bar'        => __( 'Servicio', 'service_crud_post_type' ),
        'archives'              => __( 'Archivos de items', 'service_crud_post_type' ),
        'attributes'            => __( 'Atributos de item', 'service_crud_post_type' ),
        'parent_item_colon'     => __( 'Item padre:', 'service_crud_post_type' ),
        'all_items'             => __( 'Todos los items', 'service_crud_post_type' ),
        'add_new_item'          => __( 'Agregar nuevo item', 'service_crud_post_type' ),
        'add_new'               => __( 'Agregar nuevo', 'service_crud_post_type' ),
        'new_item'              => __( 'Nuevo item', 'service_crud_post_type' ),
        'edit_item'             => __( 'Editar item', 'service_crud_post_type' ),
        'update_item'           => __( 'Actualizar item', 'service_crud_post_type' ),
        'view_item'             => __( 'Ver item', 'service_crud_post_type' ),
        'view_items'            => __( 'Ver items', 'service_crud_post_type' ),
        'search_items'          => __( 'Buscar item', 'service_crud_post_type' ),
        'not_found'             => __( 'No encontrado', 'service_crud_post_type' ),
        'not_found_in_trash'    => __( 'No encontrado en la papelera', 'service_crud_post_type' ),
        'featured_image'        => __( 'Imagen destacada', 'service_crud_post_type' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'service_crud_post_type' ),
        'remove_featured_image' => __( 'Eliminar imagen destacada', 'service_crud_post_type' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'service_crud_post_type' ),
        'insert_into_item'      => __( 'Insertar en el item', 'service_crud_post_type' ),
        'uploaded_to_this_item' => __( 'Subido a este item', 'service_crud_post_type' ),
        'items_list'            => __( 'Lista de items', 'service_crud_post_type' ),
        'items_list_navigation' => __( 'Navegación de la lista de items', 'service_crud_post_type' ),
        'filter_items_list'     => __( 'Filtrar lista de items', 'service_crud_post_type' ),
    );

    $rewrite = array(
        'slug'                  => 'servicios',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Servicio', 'service_crud_post_type' ),
        'description'           => __( 'Post Type Description', 'service_crud_post_type' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author', 'thumbnail' ),
        'taxonomies'            => array( 'service-category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-forms',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => $rewrite,
        'capability_type'       => 'page',
    );
    register_post_type( 'service_crud', $args );

    $labels = array(
        'name'                       => _x( 'Categorías', 'Taxonomy General Name', 'service_crud_post_type' ),
        'singular_name'              => _x( 'Categoría', 'Taxonomy Singular Name', 'service_crud_post_type' ),
        'menu_name'                  => __( 'Categoría', 'service_crud_post_type' ),
        'all_items'                  => __( 'Todos los Items', 'service_crud_post_type' ),
        'parent_item'                => __( 'Item padre', 'service_crud_post_type' ),
        'parent_item_colon'          => __( 'Item padre:', 'service_crud_post_type' ),
        'new_item_name'              => __( 'Nombre del nuevo Item', 'service_crud_post_type' ),
        'add_new_item'               => __( 'Agregar nuevo Item', 'service_crud_post_type' ),
        'edit_item'                  => __( 'Editar Item', 'service_crud_post_type' ),
        'update_item'                => __( 'Actualizar Item', 'service_crud_post_type' ),
        'view_item'                  => __( 'Ver Item', 'service_crud_post_type' ),
        'separate_items_with_commas' => __( 'Separar items con comas', 'service_crud_post_type' ),
        'add_or_remove_items'        => __( 'Agregar o eliminar items', 'service_crud_post_type' ),
        'choose_from_most_used'      => __( 'Elegir de los más usados', 'service_crud_post_type' ),
        'popular_items'              => __( 'Items populares', 'service_crud_post_type' ),
        'search_items'               => __( 'Buscar Items', 'service_crud_post_type' ),
        'not_found'                  => __( 'No encontrado', 'service_crud_post_type' ),
        'no_terms'                   => __( 'No hay items', 'service_crud_post_type' ),
        'items_list'                 => __( 'Lista de items', 'service_crud_post_type' ),
        'items_list_navigation'      => __( 'Navegación de la lista de items', 'service_crud_post_type' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'service-category', array( 'service_crud' ), $args );

}
add_action( 'init', 'service_crud_post_type', 0 );

// Ajax Handlr create/update
add_action( 'wp_ajax_services_crud_servtag', 'services_crud_servtag' );
add_action( 'wp_ajax_nopriv_services_crud_servtag', 'services_crud_servtag' );
function services_crud_servtag() {
    $return = array('state'=>false);
    $post_ID = intval($_POST['services-crud-servtag-editor']);
    $post_arr = array(
        'post_title'   => sanitize_text_field($_POST['servtag-title']),
        'post_content' => sanitize_text_field($_POST['servtag-content']),
        'post_status'  => 'publish',
        'post_author'  => $_POST['serv-uidd'],
        'post_type'    => 'service_crud'
    );
    $servtagCategories = (!empty($_POST['servtag-categories']))?array_map('intval', $_POST['servtag-categories']):null;
    if ($post_ID > 0) {
        $return['state'] = true;
        $post_arr['ID'] = $post_ID;
        wp_update_post( $post_arr );
    }else{
        $return['state'] = true;
        $post_arr['ID'] = wp_insert_post( $post_arr );
    }
    // CHECK file is selected then upload and assing
    if($_FILES['servtag-image']['size'] > 0 && $_FILES['servtag-image']['error'] == 0){
        // These files need to be included as dependencies when on the front end.
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );            
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        // Let WordPress handle the upload.
        $attachment_id = media_handle_upload( 'servtag-image', $post_arr['ID'] );
        set_post_thumbnail( $post_arr['ID'], $attachment_id );
    }
    // remove al tags 
    wp_set_object_terms( $post_arr['ID'], null, 'service-category' );
    if (!empty($servtagCategories)) {
        // add tags if user selected or remove some of previus selected
        wp_set_object_terms( $post_arr['ID'], $servtagCategories, 'service-category', true );
    }
    wp_send_json($return);
}
// Ajax Handlr delete
add_action( 'wp_ajax_services_crud_servtag_delete', 'services_crud_servtag_delete' );
add_action( 'wp_ajax_nopriv_services_crud_servtag_delete', 'services_crud_servtag_delete' );
function services_crud_servtag_delete() {
    $return = array('state'=>false);
    $author_id = get_post_field( 'post_author', $_POST['id'] );
    if ($author_id == $_POST['uidd']) {
        $return['state'] = true;
        wp_delete_post( $_POST['id'] );
    }
    wp_send_json($return);
}

/**
* Filter the single_template with our custom function
*/
add_filter('single_template', 'services_crud_single_template');
function services_crud_single_template($single) {
    global $wp_query, $post;
    wp_register_style('services_crud-style-frontend', crud_plugin_base_URL .'frontend.css?v='.crud_plugin_V);
    wp_enqueue_style('services_crud-style-frontend');
    if ($post->post_type == 'service_crud') {
        return plugin_dir_path(__FILE__).'inc/single-service_crud.php';//die;
    }
}
add_filter('archive_template', 'services_crud_archive_template');
function services_crud_archive_template($tpl) {
    wp_register_style('services_crud-um-add', plugins_url().'/ultimate-member/assets/css/um-members.css?ver=2.5.4');
    wp_enqueue_style('services_crud-um-add');
    wp_register_style('services_crud-style-frontend', crud_plugin_base_URL .'frontend.css?v='.crud_plugin_V);
    wp_enqueue_style('services_crud-style-frontend');
    if ( is_post_type_archive ( 'service_crud' ) || is_tax( 'service-category' ) ) {
        return plugin_dir_path(__FILE__).'inc/archive-service_crud.php';//die;
    }
}

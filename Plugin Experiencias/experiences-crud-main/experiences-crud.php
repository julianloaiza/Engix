<?php
/*
Plugin Name: CRUD Experiencias
Plugin URI: https://github.com/julianloaiza/Engix/tree/main/Plugin%20Experiencias
Description: El plugin "CRUD Experiencias" permite a los usuarios crear, gestionar y mostrar experiencias en su sitio web de WordPress.
Author: Julian Loaiza
Author URI: https://github.com/julianloaiza
Version: 1
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define( 'crudex_plugin_base_URL', plugin_dir_url(__FILE__));
define( 'crudex_plugin_V', '1.0');
define( 'crud_plugin_role', 'engineer');

require_once 'shortcodes.php';

// Register Custom Post Type
function experiences_crud_post_type() {

    $labels = array(
        'name'                  => _x( 'Experiencias', 'Post Type General Name', 'experience_crud_post_type' ),
        'singular_name'         => _x( 'Experiencia', 'Post Type Singular Name', 'experience_crud_post_type' ),
        'menu_name'             => __( 'Experiencias', 'experience_crud_post_type' ),
        'name_admin_bar'        => __( 'Experiencias', 'experience_crud_post_type' ),
        'archives'              => __( 'Archivos de Items', 'experience_crud_post_type' ),
        'attributes'            => __( 'Atributos de Item', 'experience_crud_post_type' ),
        'parent_item_colon'     => __( 'Item padre:', 'experience_crud_post_type' ),
        'all_items'             => __( 'Todos los Items', 'experience_crud_post_type' ),
        'add_new_item'          => __( 'Agregar Nuevo Item', 'experience_crud_post_type' ),
        'add_new'               => __( 'Agregar Nuevo', 'experience_crud_post_type' ),
        'new_item'              => __( 'Nuevo Item', 'experience_crud_post_type' ),
        'edit_item'             => __( 'Editar Item', 'experience_crud_post_type' ),
        'update_item'           => __( 'Actualizar Item', 'experience_crud_post_type' ),
        'view_item'             => __( 'Ver Item', 'experience_crud_post_type' ),
        'view_items'            => __( 'Ver Items', 'experience_crud_post_type' ),
        'search_items'          => __( 'Buscar Item', 'experience_crud_post_type' ),
        'not_found'             => __( 'No encontrado', 'experience_crud_post_type' ),
        'not_found_in_trash'    => __( 'No encontrado en la Papelera', 'experience_crud_post_type' ),
        'featured_image'        => __( 'Imagen Destacada', 'experience_crud_post_type' ),
        'set_featured_image'    => __( 'Establecer Imagen Destacada', 'experience_crud_post_type' ),
        'remove_featured_image' => __( 'Eliminar Imagen Destacada', 'experience_crud_post_type' ),
        'use_featured_image'    => __( 'Usar como Imagen Destacada', 'experience_crud_post_type' ),
        'insert_into_item'      => __( 'Insertar en el Item', 'experience_crud_post_type' ),
        'uploaded_to_this_item' => __( 'Subido a este Item', 'experience_crud_post_type' ),
        'items_list'            => __( 'Lista de Items', 'experience_crud_post_type' ),
        'items_list_navigation' => __( 'Navegación de la Lista de Items', 'experience_crud_post_type' ),
        'filter_items_list'     => __( 'Filtrar Lista de Items', 'experience_crud_post_type' ),
    );

    $args = array(
        'label'                 => __( 'Experiencias', 'experience_crud_post_type' ),
        'description'           => __( 'Post Type Description', 'experience_crud_post_type' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-feedback',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'page',
    );
    register_post_type( 'experience-crud', $args );

}
add_action( 'init', 'experiences_crud_post_type', 0 );

// Ajax Handlr create/update
add_action( 'wp_ajax_experiences_crud_servtag', 'experiences_crud_servtag' );
add_action( 'wp_ajax_nopriv_experiences_crud_servtag', 'experiences_crud_servtag' );
function experiences_crud_servtag() {
    $return = array('state'=>false);
    $post_ID = intval($_POST['experiences-crud-servtag-editor']);
    $post_arr = array(
        'post_title'   => sanitize_text_field($_POST['servtag-title']),
        'post_content' => sanitize_text_field($_POST['servtag-content']),
        'post_status'  => 'publish',
        'post_author'  => $_POST['serv-uidd'],
        'post_type'    => 'experience-crud'
    );
    if ($post_ID > 0) {
        $return['state'] = true;
        $post_arr['ID'] = $post_ID;
        wp_update_post( $post_arr );
    }else{
        $return['state'] = true;
        $post_arr['ID'] = wp_insert_post( $post_arr );
    }
    update_post_meta( $post_arr['ID'], '_experience_bussiness', $_POST['servtag-bussiness'] );
    update_post_meta( $post_arr['ID'], '_experience_datein', $_POST['servtag-datein'] );
    update_post_meta( $post_arr['ID'], '_experience_dateout', $_POST['servtag-dateout'] );
    wp_send_json($return);
}
// Ajax Handlr delete
add_action( 'wp_ajax_experiences_crud_servtag_delete', 'experiences_crud_servtag_delete' );
add_action( 'wp_ajax_nopriv_experiences_crud_servtag_delete', 'experiences_crud_servtag_delete' );
function experiences_crud_servtag_delete() {
    $return = array('state'=>false);
    $author_id = get_post_field( 'post_author', $_POST['id'] );
    if ($author_id == $_POST['uidd']) {
        $return['state'] = true;
        wp_delete_post( $_POST['id'] );
    }
    wp_send_json($return);
}

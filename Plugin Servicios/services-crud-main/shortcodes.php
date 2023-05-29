<?php
function services_crud( $atts ) {
    $a = shortcode_atts( array(
        'type' => 'now',
        'scale' => '0',
    ), $atts );
    
    wp_register_script('services_crud-select2-script-frontend', crud_plugin_base_URL .'select2.min.js?v='.crud_plugin_V);
    wp_enqueue_script('services_crud-select2-script-frontend');
    wp_register_script('services_crud-script-frontend', crud_plugin_base_URL .'frontend.js?v='.crud_plugin_V);
    wp_enqueue_script('services_crud-script-frontend');
    wp_register_style('services_crud-select2-style-frontend', crud_plugin_base_URL .'select2.min.css?v='.crud_plugin_V);
    wp_enqueue_style('services_crud-select2-style-frontend');
    wp_register_style('services_crud-style-frontend', crud_plugin_base_URL .'frontend.css?v='.crud_plugin_V);
    wp_enqueue_style('services_crud-style-frontend');
    ob_start();
    $result = um_get_requested_user();
    $user = wp_get_current_user();
    $profile_id = um_profile_id();

    $roles = ( array ) $user->roles;
     
    ?>
    <div class="services-crud-wrap">
        <div class="services-crud-list-services">
            <?php
            $the_query = new WP_Query( array(
                'author__in'=> array($result),
                'post_type' => 'service_crud',
                'post_status' => 'publish',
                'posts_per_page' => '-1'
            ));

            while ( $the_query->have_posts() ) :
               $the_query->the_post();
               $post_ID = get_the_ID();
               $term_obj_list = get_the_terms( $post_ID, 'service-category' );
               $terms_string = join(',', wp_list_pluck($term_obj_list, 'term_id'));
               $author_id = get_post_field( 'post_author', $post_ID );
            ?>
            <div class="services-crud-list-services-el services-crud-box">
                <div class="services-crud-list-services-el-header">
                    <div class="services-crud-categories">
                        <?php the_terms($post_ID,'service-category','','',''); ?>
                    </div>
                    <?php if($profile_id == $user->ID && in_array(crud_plugin_role, $roles)): ?>
                    <div>
                        <a href="#delete" data-servtag="<?php echo $post_ID; ?>" data-uidd="<?php echo $result; ?>" class="services-crud-link services-crud-delete">Eliminar</a>
                        <a href="#edit" data-servtag="<?php echo $post_ID; ?>" class="services-crud-edit-service-btn services-crud-link services-crud-edit"
                            data-title="<?php echo ucfirst(get_the_title()); ?>"
                            data-categories="<?php echo $terms_string; ?>"
                            data-content="<?php echo get_the_content(); ?>"
                            >Editar</a> 
                    </div>
                    <?php endif; ?>
                </div>
                <h3><?php echo ucfirst(get_the_title()); ?></h3>
                <div class="services-crud-content"> <?php the_content(); ?> </div>
                <?php if( get_the_post_thumbnail_url( $post_ID, 'full' ) != ""): ?>
                <div class="services-crud-image">
                    <div class="um-member-cover" data-ratio="2.7:1" style="background-size: cover; background-position: center;background-image: url(<?php echo get_the_post_thumbnail_url( $post_ID, 'full' ); ?>);"></div>
                </div>
                <?php endif; ?>
                         
            </div>
            <?php
               // Show Posts ...
            endwhile;

            /* Restore original Post Data 
            * NB: Because we are using new WP_Query we aren't stomping on the 
            * original $wp_query and it does not need to be reset.
            */
            wp_reset_postdata();
            ?>
        </div>
        <?php if($profile_id == $user->ID && in_array(crud_plugin_role, $roles)): ?>
        <div class="services-crud-edit-service-btn services-crud-box" 
            data-servtag="0"
            data-title=""
            data-categories=""
            data-content="">
            <span class="services-fake-icon">+</span>
            <h2>Agregar nuevo servicio</h2>
        </div>
        <div class="services-crud-editor" style="display: none;" id="services-crud-editor">
            <form class="services-crud-box">
                <input type="hidden" name="action" value="services_crud_servtag">
                <input type="hidden" name="serv-uidd" value="<?php echo $result; ?>">
                <input type="hidden" name="services-crud-servtag-editor" class="services-crud-servtag-editor" value="0">
                <div class="form-elm">
                    <b>Seleccionar Imagen</b>
                    <input type="file" name="servtag-image" class="servtag-image" placeholder="Imagen" accept="image/*">
                </div>
                <div class="form-elm">
                    <input type="text" name="servtag-title" class="servtag-title" placeholder="Título" required>
                </div>
                <div class="form-elm">
                    <textarea name="servtag-content" class="servtag-content" placeholder="Descripción" required></textarea>
                </div>
                <div class="serv-cats form-elm">
                    <b>Seleccionar Categoría</b>
                    <select multiple class="servtag-categories select-special" name="servtag-categories[]" required>
                    <?php
                        $categories = get_terms( array(
                            'taxonomy' => 'service-category',
                            'orderby' => 'name',
                            'order'   => 'ASC',
                            'hide_empty' => false
                        ) );
                        foreach( $categories as $category ) {
                            echo '<option value="'.$category->term_id . '">' . $category->name . '</option>';   
                        } 
                    ?>
                    </select>
                </div>
                <button class="um-do-search um-button" >Guardar</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        var services_crud = {
            ajax_url: "<?php echo admin_url( 'admin-ajax.php' ); ?>"
        };
    </script>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'services_crud', 'services_crud' );

function services_crud_list( $atts ) {
    $a = shortcode_atts( array(
        'type' => 'now',
        'scale' => '0',
    ), $atts );
    
    wp_register_style('services_crud-um-add', plugins_url().'/ultimate-member/assets/css/um-members.css?ver=2.5.4');
    wp_enqueue_style('services_crud-um-add');
    wp_register_script('services_crud-select2-script-frontend', crud_plugin_base_URL .'select2.min.js?v='.crud_plugin_V);
    wp_enqueue_script('services_crud-select2-script-frontend');
    wp_register_script('services_crud-script-frontend', crud_plugin_base_URL .'frontend.js?v='.crud_plugin_V);
    wp_enqueue_script('services_crud-script-frontend');
    wp_register_style('services_crud-select2-style-frontend', crud_plugin_base_URL .'select2.min.css?v='.crud_plugin_V);
    wp_enqueue_style('services_crud-select2-style-frontend');
    wp_register_style('services_crud-style-frontend', crud_plugin_base_URL .'frontend.css?v='.crud_plugin_V);
    wp_enqueue_style('services_crud-style-frontend');
    ob_start();
    $result = um_get_requested_user();
    $user = wp_get_current_user();
     
    $queryOptions = array(
        'post_type' => 'service_crud',
        'post_status' => 'publish',
        'posts_per_page' => '-1'
    );
    $search = $term_id = null;
    if (!empty($_GET['servtag-category'])) {
        $term_id = $_GET['servtag-category'];
        $queryOptions['tax_query'] = array(
            array(
                'taxonomy' => 'service-category',
                'field'    => 'ID',
                'terms'    => intval($_GET['servtag-category']),
            )
        );
    }
    if (!empty($_GET['servtag-search'])) {
        $search = $_GET['servtag-search'];
        $queryOptions['s'] = $_GET['servtag-search'];
    }
    $the_query = new WP_Query( $queryOptions );
    
    ?>
    <div class="services-crud-wrap">
        <div class="um um-directory">
            <form action="" method="get">
            <div class="um-member-directory-header um-form">
                <div class="um-member-directory-header-row um-member-directory-search-row">
                    <div class="um-member-directory-search-line">
                        <label>
                            <span>Buscar:</span>
                            <input type="search" class="um-search-line" placeholder="Buscar" value="<?php echo $search; ?>" aria-label="Buscar" name="servtag-search">
                        </label>
                        <b style="margin-right: 10px;">Categorías</b>
                        <div class="serv-caum-member-directory-search-linets" style="min-width: 230px;display:inline-block;margin-right: 10px;">
                            <select class="select-special" name="servtag-category">
                                <option value="">Todas</option>
                            <?php
                                $categories = get_terms( array(
                                    'taxonomy' => 'service-category',
                                    'orderby' => 'name',
                                    'order'   => 'ASC',
                                    'hide_empty' => false
                                ) );
                                foreach( $categories as $category ) {
                                    echo '<option value="'.$category->term_id . '" '.selected($term_id,$category->term_id,false).'>' . $category->name . '</option>';   
                                } 
                            ?>
                            </select>
                        </div>
                        <input type="submit" class="um-do-search um-button" value="Buscar">
                    </div>
                </div>
            </div>
            </form>
            <div class="um-members-wrapper">
                <div class="um-members um-members-grid masonry">
                    <?php
                    
                    while ( $the_query->have_posts() ) :
                        $the_query->the_post();
                        include crud_plugin_base_PATH.'inc/loop-service.php';
                       // Show Posts ...
                    endwhile;

                    /* Restore original Post Data 
                    * NB: Because we are using new WP_Query we aren't stomping on the 
                    * original $wp_query and it does not need to be reset.
                    */
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var services_crud = {
            ajax_url: "<?php echo admin_url( 'admin-ajax.php' ); ?>"
        };
    </script>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode( 'services_crud_list', 'services_crud_list' );
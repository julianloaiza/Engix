<?php
$post_ID = get_the_ID();
$term_obj_list = get_the_terms( $post_ID, 'service-category' );
$terms_string = join(',', wp_list_pluck($term_obj_list, 'term_id'));
$author_id = get_post_field( 'post_author', $post_ID ); 

$title = ucfirst(get_the_title());
$user_info = get_userdata(get_the_author_meta( 'ID' ));
$userName = urlencode(strtolower($user_info->user_login));
$coverIMG = get_the_post_thumbnail_url( $post_ID, 'full' );
$profileIMG = do_shortcode('[um_user user_id="'.get_the_author_meta( 'ID' ).'" meta_key="profile_photo" ]');
$profilePageID = UM()->options()->get( 'core_user' );
um_fetch_user( $author_id) ;
$profileURL = um_user_profile_url();

?>

<div class="um-member um-role-um_engineer with-cover masonry-brick">
    <div class="um-member-cover-e">
        <a href="<?php echo get_permalink(); ?>" title="<?php echo $title; ?>" style="display: block;">
            <div class="um-member-cover" data-ratio="2.7:1" style="background-size: cover; background-position: center;background-image: url(<?php echo $coverIMG; ?>);"></div>
        </a>
    </div>
    <div class="um-member-photo radius-1">
        <a href="<?php echo $profileURL; ?>" title="<?php echo $title; ?>">
            <img src="<?php echo $profileIMG; ?>" 
            class="gravatar avatar avatar-190 um-avatar um-avatar-default" width="190" height="190" alt="" 
            data-default="<?php echo home_url(); ?>/wp-content/plugins/ultimate-member/assets/img/default_avatar.jpg" 
            onerror="if ( ! this.getAttribute('data-load-error') ){ this.setAttribute('data-load-error', '1');this.setAttribute('src', this.getAttribute('data-default'));}">
        </a>
    </div>
    <div class="um-member-card ">                                                
        <div class="um-member-name">
            <a href="<?php echo get_permalink(); ?>" title="<?php echo $title; ?>">
                <?php echo $title; ?>
            </a>
        </div>
        <div class="services-crud-list-services-el-header el-header-tag-list">
            <div class="services-crud-categories">
                <?php the_terms($post_ID,'service-category','','',''); ?>
            </div>   
        </div>       
    </div>
</div>
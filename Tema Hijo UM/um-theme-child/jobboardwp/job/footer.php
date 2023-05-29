	<?php if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	if ( ! empty( $jb_job_footer['job_id'] ) ) {

		$job_id    = $jb_job_footer['job_id'];
		$job_title = ! empty( $jb_job_footer['title'] ) ? $jb_job_footer['title'] : '';
		$author_id = get_post_field( 'post_author', $job_id );
		um_fetch_user( $author_id) ;
    	$profileURL = um_user_profile_url();

		?>

		<div class="jb-job-footer">
			<div class="jb-job-footer-row">
				<?php
				if ( JB()->common()->job()->can_applied( $job_id ) ) {

					$contact = get_post_meta( $job_id, 'jb-application-contact', true );
					?>

					<div class="jb-job-apply-wrapper">

						<div> Por: <b><a href="<?php echo $profileURL; ?>"><?php the_author_meta( 'display_name' ); ?></a></b> </div>

						<input type="button" class="jb-button jb-job-apply" value="<?php esc_attr_e( 'Apply for job', 'jobboardwp' ); ?>" />
						<?php echo do_shortcode( '[ultimatemember_message_button user_id="' . $author_id . '" class="um-message-button"]' ); ?>

						<div class="jb-job-apply-description">
							<?php
							if ( is_email( $contact ) ) {
								$contact_mailto = add_query_arg(
									array(
										// translators: %1$s: application type, %2$s: home URL
										'subject' => esc_html__( sprintf( __( 'Application via %1$s job on %2$s', 'jobboardwp' ), $job_title, home_url() ), 'jobboardwp' ), // phpcs:ignore WordPress.WP.I18n.NonSingularStringLiteralText
									),
									'mailto:' . $contact
								);
								?>

								<p>
									<?php

									if (!is_user_logged_in()) {
										$applying_text = __( 'Para postularse al trabajo debe registrarse <strong><a href="' . home_url() . '/registrarse/">aquí</a></strong>.', 'jobboardwp' );
									} else {
										$applying_text = sprintf( __( 'To apply for this job <strong>email your details to</strong> <a href="%1$s">%2$s</a>.', 'jobboardwp' ), esc_attr( $contact_mailto ), $contact );
									}
									/** @noinspection HtmlUnknownTarget */
									// translators: %1$s: mailto URL, %2$s: contact email
									
									/**
									 * Filters the job application details string.
									 *
									 * @since 1.2.2
									 * @hook jb_job_application_label
									 *
									 * @param {string} $applying_text Job applying text. Base on application method (email or website URL)
									 * @param {int}    $job_id        Job ID.
									 *
									 * @return {string} Job application details.
									 */
									$applying_text = apply_filters( 'jb_job_application_label', $applying_text, $job_id );
									echo wp_kses( $applying_text, JB()->get_allowed_html( 'templates' ) );
									?>
								</p>
							<?php } else { ?>
								<p>
									<?php
									/** @noinspection HtmlUnknownTarget */
									// translators: %1$s: application's website URL, %2$s: application's website URL text
									
									if (!is_user_logged_in()) {
										$applying_text = __( 'Para postularse al trabajo debe registrarse <strong><a href="' . home_url() . '/registrarse/">aquí</a></strong>.', 'jobboardwp' );
									} else {
										$applying_text = sprintf( __( 'To apply for this job please visit <a href="%1$s">%2$s</a>.', 'jobboardwp' ), esc_attr( $contact ), $contact );
									}
										/** This filter is documented in templates/job/footer.php */
									$applying_text = apply_filters( 'jb_job_application_label', $applying_text, $job_id );
									echo wp_kses( $applying_text, JB()->get_allowed_html( 'templates' ) );
									?>
								</p>
							<?php } ?>

							<a href="javascript:void(0);" class="jb-job-apply-hide"><?php esc_html_e( 'Cancel', 'jobboardwp' ); ?></a>
						</div>
					</div>
					<div class="jb-job-after-apply-wrapper">
						<?php
						/**
						 * Fires after displaying "Apply" wrapper on the individual Job page.
						 *
						 * @since 1.1.0
						 * @hook jb_after_job_apply_block
						 *
						 * @param {int} $job_id Job ID.
						 */
						do_action( 'jb_after_job_apply_block', $job_id );
						?>
					</div>
				<?php } ?>
			</div>
		</div>

		<?php
	}

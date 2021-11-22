<?php
/**
 * Alpha Helpful Comments class
 *
 * @author     FunnyWP
 * @package    WP Alpha Core Framework
 * @subpackage Core
 * @version    1.0
 */
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'Alpha_Helpful_Comments' ) ) {
	/**
	 * Alpha Helpful Comments class
	 *
	 * @since 1.0
	 */
	class Alpha_Helpful_Comments extends Alpha_Base {

		/**
		 * Main Class construct
		 *
		 * @since 1.0
		 */
		public function __construct() {

			// Enqueue scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );

			// display comment vote
			add_action( 'woocommerce_review_after_comment_text', array( $this, 'display_comment_vote' ), 20 );

			//display helpful recommend
			add_action( 'alpha_helpful_recommended', array( $this, 'display_recommend_value' ) );

			// vote comment
			add_action( 'wp_ajax_comment_vote', array( $this, 'ajax_vote_comment' ) );
			add_action( 'wp_ajax_nopriv_comment_vote', array( $this, 'ajax_vote_comment' ) );

			// get comments
			add_action( 'wp_ajax_alpha_get_comments', array( $this, 'ajax_get_comments' ) );
			add_action( 'wp_ajax_nopriv_alpha_get_comments', array( $this, 'ajax_get_comments' ) );

			// Add Helpful Comments Filter
			add_action( 'alpha_helpful_comments_tab_nav', array( $this, 'helpful_comments_tab_nav' ) );
			add_action( 'alpha_helpful_comments_tab_content', array( $this, 'helpful_comments_tab_content' ) );
		}

		/**
		 * Load scripts
		 *
		 * @since 1.0
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'alpha-product-helpful-comments', alpha_core_framework_uri( '/addons/product-helpful-comments/product-helpful-comments' . ALPHA_JS_SUFFIX ), array( 'alpha-theme' ), ALPHA_VERSION, true );
		}

		/**
		 * Vote comment in ajax
		 *
		 * @since 1.0
		 */
		public function ajax_vote_comment() {
			if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'alpha-nonce' ) && isset( $_POST['commentvote'] ) ) {
				$comment_id    = intval( $_POST['comment_id'] );
				$comment_plus  = get_comment_meta( $comment_id, 'comment_plus', true );
				$comment_minus = get_comment_meta( $comment_id, 'comment_minus', true );

				$user_id = get_current_user_id();
				if ( 0 == $user_id ) {
					die( false );
				}

				$id_metas = get_comment_meta( $comment_id, 'help_comment_ids', true );

				if ( ! $id_metas ) {
					$id_metas = array();
				}

				if ( is_array( $id_metas ) && ! in_array( 'user_id-' . $user_id, array_keys( $id_metas ) ) ) {
					$id_metas[ 'user_id-' . $user_id ] = $_POST['commentvote'];
					if ( 'plus' == $_POST['commentvote'] ) {
						update_comment_meta( $comment_id, 'comment_plus', ++$comment_plus );
					} elseif ( 'minus' == $_POST['commentvote'] ) {
						update_comment_meta( $comment_id, 'comment_minus', ++$comment_minus );
					}
					update_comment_meta( $comment_id, 'help_comment_ids', $id_metas );

					$result = array(
						'plus'  => $comment_plus,
						'minus' => $comment_minus,
					);
					die( json_encode( $result ) );
				} elseif ( is_array( $id_metas ) ) {
					if ( $_POST['commentvote'] == $id_metas[ 'user_id-' . $user_id ] ) {
						unset( $id_metas[ 'user_id-' . $user_id ] );
						if ( 'plus' == $_POST['commentvote'] ) {
							update_comment_meta( $comment_id, 'comment_plus', --$comment_plus );
						} elseif ( 'minus' == $_POST['commentvote'] ) {
							update_comment_meta( $comment_id, 'comment_minus', --$comment_minus );
						}
						update_comment_meta( $comment_id, 'help_comment_ids', $id_metas );
					} elseif ( $_POST['commentvote'] != $id_metas[ 'user_id-' . $user_id ] ) {
						$id_metas[ 'user_id-' . $user_id ] = $_POST['commentvote'];
						if ( 'plus' == $_POST['commentvote'] ) {
							update_comment_meta( $comment_id, 'comment_plus', ++$comment_plus );
							update_comment_meta( $comment_id, 'comment_minus', --$comment_minus );
						} elseif ( 'minus' == $_POST['commentvote'] ) {
							update_comment_meta( $comment_id, 'comment_plus', --$comment_plus );
							update_comment_meta( $comment_id, 'comment_minus', ++$comment_minus );
						}
						update_comment_meta( $comment_id, 'help_comment_ids', $id_metas );
					}
					$result = array(
						'plus'  => $comment_plus,
						'minus' => $comment_minus,
					);
					die( json_encode( $result ) );
				}
			}
		}

		/**
		 * Get User IP Address
		 *
		 * @since 1.0
		 */
		public function get_user_ip() {
			foreach ( array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ) as $key ) {
				if ( true === array_key_exists( $key, $_SERVER ) ) {
					$ip = $_SERVER[ $key ];
					if ( false !== strpos( $ip, ',' ) ) {
						$ip = explode( ',', $ip )[0];
					}
					if ( $ip ) {
						substr_replace( $ip, 0, -1 );
					} //GDRP
					return esc_attr( $ip );
				}
			}
			return '127.0.0.3';
		}

		/**
		 * Get the Sorted Comments in ajax
		 *
		 * @since 1.0
		 */
		public function ajax_get_comments() {
			if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'alpha-nonce' ) ) {

				$post_id   = absint( $_POST['post_id'] );
				$page      = absint( $_POST['page'] );
				$req_posts = new WP_Query(
					array(
						'p'         => $post_id,
						'post_type' => get_post_type( $post_id ),
					)
				);

				if ( $req_posts->have_posts() ) {
					$req_posts->the_post();

					global $wp_query;
					$wp_query->is_singular = true;
					$wp_query->set( 'cpage', $page );
					$wp_query->set( 'comments_per_page', get_option( 'comments_per_page' ) );

					$comment_mode           = $_POST['mode'];
					$comment_counts         = wp_count_comments( $post_id );
					$comments               = array();
					$comments_help_positive = array();
					$comments_help_negative = array();

					ob_start();
					if ( empty( $comment_counts->approved ) ) {
						echo esc_html__( 'No comments on this post.', 'alpha-core' );
					}

					$comments_temp = get_comments(
						array(
							'post_id' => $post_id,
							'status'  => 'approve',
							'orderby' => 'comment_date',
							'order'   => 'DESC',
						)
					);

					foreach ( $comments_temp as $key => $comment ) {
						$comment->comment_rating = get_comment_meta( $comment->comment_ID, 'rating', true );
						$comment->comment_help   = get_comment_meta( $comment->comment_ID, 'comment_plus', true );
						$comment->comment_unhelp = get_comment_meta( $comment->comment_ID, 'comment_minus', true );
						if ( $comment->comment_rating > 2.9 ) {
							$comments_help_positive[ $key ] = $comment;
						} elseif ( $comment->comment_rating < 2.1 ) {
							$comments_help_negative[ $key ] = $comment;
						}
						$comments[ $key ] = $comment;
					}

					if ( count( $comments ) ) {
						if ( 'helpful-positive' == $comment_mode ) {
							usort( $comments_help_positive, array( $this, 'sort_helpful' ) );
							$comments = $comments_help_positive;
						} elseif ( 'helpful-negative' == $comment_mode ) {
							usort( $comments_help_negative, array( $this, 'sort_unhelpful' ) );
							$comments = $comments_help_negative;
						} else {
							if ( 'high-rate' == $comment_mode ) {
								usort( $comments, array( $this, 'sort_highrate' ) );
							} elseif ( 'low-rate' == $comment_mode ) {
								usort( $comments, array( $this, 'sort_lowrate' ) );
							}
						}
					}

					wp_list_comments( array( 'callback' => 'woocommerce_comments' ), $comments );

					$html = ob_get_clean();

					$wp_query->comments = $comments;
					$args               = apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'echo'      => false,
							'prev_text' => '<i class="' . ALPHA_ICON_PREFIX . '-icon-long-arrow-left"></i> ' . esc_html__( 'Prev', 'alpha-core' ),
							'next_text' => esc_html__( 'Next', 'alpha-core' ) . ' <i class="' . ALPHA_ICON_PREFIX . '-icon-long-arrow-right"></i>',
						)
					);
					$pagination         = paginate_comments_links( $args );

					if ( $pagination ) {
						if ( 1 === $page ) {
							$pagination = sprintf(
								'<span class="prev page-numbers disabled">%s</span>',
								$args['prev_text']
							) . $pagination;
						} elseif ( get_comment_pages_count() == $page ) {
							$pagination .= sprintf(
								'<span class="next page-numbers disabled">%s</span>',
								$args['next_text']
							);
						}
					}

					wp_send_json(
						array(
							'html'       => $html,
							'pagination' => $pagination,
						)
					);
				}
			}
			die;
		}

		/**
		 * sort comment by helpful
		 *
		 * @since 1.0
		 */
		public function sort_helpful( $a, $b ) {
			$ah = $a->comment_help;
			$bh = $b->comment_help;
			return $ah == $bh ? 0 : ( $ah > $bh ? -1 : 1 );
		}

		/**
		 * sort comment by unhelpful
		 *
		 * @since 1.0
		 */
		public function sort_unhelpful( $a, $b ) {
			$ah = $a->comment_unhelp;
			$bh = $b->comment_unhelp;
			return $ah == $bh ? 0 : ( $ah > $bh ? -1 : 1 );
		}

		/**
		 * sort comment by high rate
		 *
		 * @since 1.0
		 */
		public function sort_highrate( $a, $b ) {
			$ar = floatval( $a->comment_rating );
			$br = floatval( $b->comment_rating );
			return $ar == $br ? 0 : ( $ar > $br ? -1 : 1 );
		}

		/**
		 * sort comment by low rate
		 *
		 * @since 1.0
		 */

		public function sort_lowrate( $a, $b ) {
			$ar = floatval( $a->comment_rating );
			$br = floatval( $b->comment_rating );
			return $ar == $br ? 0 : ( $ar < $br ? -1 : 1 );
		}

		/**
		 * Display helpful or unhelpful vote buttons in comment.
		 *
		 * @since 1.0
		 */
		public function display_comment_vote( $comment ) {
			$comment_id           = get_comment_ID();
			$comment_help_count   = get_comment_meta( $comment_id, 'comment_plus', true );
			$comment_unhelp_count = get_comment_meta( $comment_id, 'comment_minus', true );
			$id_metas             = get_comment_meta( $comment_id, 'help_comment_ids', true );
			$user_id              = get_current_user_id();
			$status               = '';
			if ( ! empty( $id_metas[ 'user_id-' . $user_id ] ) ) {
				$status = $id_metas[ 'user_id-' . $user_id ];
			}
			?>
			<div class="review-vote" id="alpha_review_vote-<?php echo absint( $comment_id ); ?>">
				<span class="comment_help btn btn-link <?php echo ( 'plus' == $status ? 'already-voted' : '' ); ?>" data-comment_id="<?php echo absint( $comment_id ); ?>" data-count="<?php echo absint( $comment_help_count ); ?>">
					<i class="far fa-thumbs-up"></i><?php esc_html_e( 'Helpful', 'alpha-core' ); ?> (<span id="commenthelp-count-<?php echo absint( $comment_id ); ?>"><?php echo intval( $comment_help_count ); ?></span>)
				</span>
				<span class="comment_unhelp btn btn-link <?php echo ( 'minus' == $status ? 'already-voted' : '' ); ?>" data-comment_id="<?php echo absint( $comment_id ); ?>" data-count="<?php echo absint( $comment_unhelp_count ); ?>">
					<i class="far fa-thumbs-down"></i><?php esc_html_e( 'Unhelpful', 'alpha-core' ); ?> (<span id="commentunhelp-count-<?php echo absint( $comment_id ); ?>"><?php echo intval( $comment_unhelp_count ); ?></span>)
				</span>
				<?php if ( 0 == get_current_user_id() ) : ?>
					<span class="comment_alert" style="display: none;"><?php esc_html_e( 'You have to login to vote comments.', 'alpha-core' ); ?></span>
				<?php endif; ?>
			</div>
			<?php
		}

		/**
		 * Display recommended percentage on single product page
		 *
		 * @since 1.0
		 */
		public function display_recommend_value( $product ) {
			$post_id           = $product->get_id();
			$recommended_count = 0;
			$total_count       = $product->get_review_count();

			$comments_temp = get_comments(
				array(
					'post_id' => $post_id,
					'status'  => 'approve',
					'orderby' => 'comment_date',
					'order'   => 'DESC',
				)
			);

			foreach ( $comments_temp as $key => $comment ) {
				$rating = get_comment_meta( $comment->comment_ID, 'rating', true );
				if ( absint( $rating ) >= 4 ) {
					++ $recommended_count;
				}
			}

			if ( $total_count > 0 ) {
				?>
				<h4 class="recommended-value">
					<mark>
						<?php
						if ( $total_count ) {
							$v = $recommended_count * 100 / $total_count;
							if ( 100 == $v ) {
								echo '100%';
							} else {
								printf( 10 <= $v ? '%.1f%%' : '%.2f%%', $v );
							}
						} else {
							echo '0.00%';
						}
						?>
					</mark>
					<?php esc_html_e( 'Recommended', 'alpha-core' ); ?>
					<span>
						<?php
						/* translators: %1$d represents recommended count, %2$s represents total count. */
						printf( esc_html__( '(%1$d of %2$d)', 'alpha-core' ), $recommended_count, $total_count );
						?>
					</span>
				</h4>
				<?php
			}
		}

		/**
		 * Add helpful comments tab nav
		 *
		 * @since 1.0
		 */
		public function helpful_comments_tab_nav() {
			?>
			<ul id="alpha_comment_tabs" class="alpha-comment-tabs nav nav-tabs tab-nav-solid" role="tablist" data-post_id = "<?php the_ID(); ?>">
				<li class="nav-item" aria-controls="commentlist">
					<span data-href="#commentlist" class="nav-link active" data-mode="all"><?php esc_html_e( 'Show all', 'alpha-core' ); ?></span>
				</li>
				<li class="nav-item" aria-controls="commentlist-helpful-positive">
					<span data-href="#commentlist-helpful-positive" data-mode="helpful-positive" class="nav-link">
					<?php esc_html_e( 'Most Helpful Positive', 'alpha-core' ); ?>
					</span>
				</li>
				<li class="nav-item" aria-controls="commentlist-helpful-negative">
					<span data-href="#commentlist-helpful-negative" data-mode="helpful-negative" class="nav-link">
					<?php esc_html_e( 'Most Helpful Negative', 'alpha-core' ); ?>
					</span>
				</li>
				<li class="nav-item" aria-controls="commentlist-highrated">
					<span data-href="#commentlist-highrated" data-mode="high-rate" class="nav-link">
					<?php esc_html_e( 'Highest Rating', 'alpha-core' ); ?>
					</span>
				</li>
				<li class="nav-item" aria-controls="commentlist-lowrated">
					<span data-href="#commentlist-lowrated" data-mode="low-rate" class="nav-link">
					<?php esc_html_e( 'Lowest Rating', 'alpha-core' ); ?>
					</span>
				</li>
			</ul>
			<?php
		}

		/**
		 * Add Helpful comments tab content
		 *
		 * @since 1.0
		 */
		public function helpful_comments_tab_content() {
			?>
			<ol id="commentlist-helpful-positive" class="commentlist tab-pane" data-empty="<li class='review review-empty'><?php esc_html_e( 'No positive review exists.', 'alpha-core' ); ?></li>"></ol>
			<ol id="commentlist-helpful-negative" class="commentlist tab-pane" data-empty="<li class='review review-empty'><?php esc_html_e( 'No negative review exists.', 'alpha-core' ); ?></li>"></ol>
			<ol id="commentlist-highrated" class="commentlist tab-pane"></ol>
			<ol id="commentlist-lowrated" class="commentlist tab-pane"></ol>
			<?php
		}
	}
}

Alpha_Helpful_Comments::get_instance();

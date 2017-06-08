<?php
/**
 * This class is used to add post meta boxes to side bar of all post types
 *
 * @author Kyle Benk <kjbenk@gmail.com>
 */

/**
 * Global Definitions
 */

/**
 * Class used to add meta box
 *
 * @since 1.0.0
 */
class WPsite_Twitter_MetaBox extends Resharer_Base {

	/**
	 * [$prefix description]
	 * @var string
	 */
	private $prefix = 'wpsite-twitter-reshare-meta-box-';

	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->add_action( 'add_meta_boxes', 'register_meta_box', 10, 2 );
		$this->add_action( 'save_post', 'save_post' );
	}

	/**
	 * Adds the meta box container.
	 */
	public function register_meta_box( $post_type, $post ) {

		if ( in_array( $post_type, array( 'page', 'attachment' ) ) ) {
			return;
		}
		add_meta_box(
			$this->prefix . 'hashtags',
			'WPSite Content Resharer Hashtags',
			array( $this, 'render_metabox' ),
			$post_type,
			'side',
			'low'
		);
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_metabox( $post ) {

		// Use get_post_meta to retrieve an existing value from the database.
		$hashtags = get_post_meta( $post->ID, $this->prefix . 'hashtags', true );
		$hashtags = isset( $hashtags ) ? $hashtags : '';

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->prefix . 'meta-box', $this->prefix . 'meta-box-nonce' );
		?>
			<input type="text" id="<?php echo $this->prefix . 'hashtags' ?>" name="<?php echo $this->prefix . 'hashtags' ?>" value="<?php echo $hashtags ?>" placeholder="hashtag,hashtag1" size="18"/><br/>
			<em><?php esc_html_e( 'No spaces (i.e. hashtag,hashtag1) not (hashtag, hashtag1)', 'wpsite-twitter-reshare' ) ?></em>
		<?php
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_post( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST[ $this->prefix . 'meta-box-nonce' ] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST[ $this->prefix . 'meta-box-nonce' ], $this->prefix . 'meta-box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		// OK, it's safe for us to save the data now.

		// Make sure that it is set.
		if ( ! isset( $_POST[ $this->prefix . 'hashtags' ] ) ) {
			return;
		}

		// Sanitize user input.
		$hashtags = sanitize_text_field( $_POST[ $this->prefix . 'hashtags' ] );

		// Update the meta field in the database.
		if ( '' === $hashtags ) {
			delete_post_meta( $post_id, $this->prefix . 'hashtags' );
		} else {
			update_post_meta( $post_id, $this->prefix . 'hashtags', str_replace( ' ', '', $hashtags ) );
		}
	}
}

new WPsite_Twitter_MetaBox;

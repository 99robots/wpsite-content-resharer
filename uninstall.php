<?php

	/* if uninstall not called from WordPress exit */
	
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit ();
	
	/* Delete all existence of this plugin */

	global $wpdb;
	
	$prefix = 'wpsite_reshare_meta_box_';
	
	if ( !is_multisite() ) 
	{
	
		$settings = get_option('wpsite_reshare_settings');
		
		foreach ($settings['accounts'] as $account) {
			$hook = 'wpsite_reshare_' . $account['id'];
			$args = $account;
			$args['status'] = 'active';
			
			wp_clear_scheduled_hook($hook, array($args));
		}
		
		delete_option('wpsite_reshare_version');
		delete_option('wpsite_reshare_settings');
		
		/* Delete post meta data */
	        
		$posts = get_posts(array('posts_per_page' => -1));
		
		foreach ($posts as $post) {
			$post_meta = get_post_meta($post->ID);
			
			foreach ($post_meta as $key => $val) {
				if (substr($key, 0, 24) == $prefix) {
					delete_post_meta($post->ID, $key);
				}
			}
		}
	} 
	else 
	{
	
		delete_site_option('wpsite_reshare_version');
		
	    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
	    $original_blog_id = get_current_blog_id();
	
	    foreach ( $blog_ids as $blog_id ) 
	    {
	        switch_to_blog( $blog_id );
	        
	        //Delete site data here
	        
	        $settings = get_option('wpsite_reshare_settings');
		
			foreach ($settings['accounts'] as $account) {
				$hook = 'wpsite_reshare_' . $account['id'];
				$args = $account;
				$args['status'] = 'active';
				
				wp_clear_scheduled_hook($hook, array($args));
			}
	        
	        delete_option('wpsite_reshare_settings');
	        
	        /* Delete post meta data */
	        
			$posts = get_posts(array('posts_per_page' => -1));
			
			foreach ($posts as $post) {
				$post_meta = get_post_meta($post->ID);
				
				foreach ($post_meta as $key => $val) {
					if (substr($key, 0, 24) == $prefix) {
						delete_post_meta($post->ID, $key);
					}
				}
			}
	    }
	    switch_to_blog( $original_blog_id );
	}
?>
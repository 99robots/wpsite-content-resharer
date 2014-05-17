<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-post"><br/></div>
	<h2><?php _e('WPsite Twitter Reshare Accounts', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?><a class="add-new-h2" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=add', 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e('Add New', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a></h2>

<br />

<table class="wp-list-table widefat fixed posts">
	<thead>
		<tr>
			<th><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('Min Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th><?php _e('Status', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('ID', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('Label', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('Min Interval', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
			<th><?php _e('Type', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></th>
		</tr>
	</tfoot>
	<tbody><?php
		
		$wpsite_twitter_reshare_ahref_array = array();
		
		$settings = get_option('wpsite_twitter_reshare_settings');
		
		/* Default values */
		
		if ($settings === false) 
			$settings = self::$default;
			
		foreach ($settings['accounts'] as $account) {
			
			$wpsite_twitter_reshare_ahref_array[] = $account['id'];
			
			?> 
			<!-- !!!! DO NOT CHANGE CLASS NAME !!! -->
				<!-- This will result in the delete link not showing up on hove, if class must be changed contact kjbenk@gmail.com first -->
			<tr class="wpsite_twitter_reshare_admin_accounts_delete_tr wpsite_twitter_reshare_admin_accounts_delete_tr<?php echo $account['id']; ?>">
			<!-- !!!! DO NOT CHANGE CLASS NAME !!! -->
			
				<!-- Status -->
				
				<td>
					<label><?php echo (isset($account['status']) && $account['status'] != '' ? __($account['status'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br />
					<!-- Activate / Deactivate -->
					
					<a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=activate&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_activate'); ?>"><?php echo $account['status'] == 'active' ? __('Deactivate', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : __('Activate', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a>
				</td>
			
				<!-- Account ID -->
				
				<td>
					
					<!-- ID Name -->
					
					<a href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><strong><?php _e($account['id'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></strong></a><br />
					
					<!-- Edit -->
					
					<!-- <a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=edit&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_add_edit'); ?>"><?php _e('Edit', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> -->
				</td>
				
				<!-- Label -->
				
				<td> 
					<label><?php echo (isset($account['label']) && $account['label'] != '' ? __($account['label'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br/>
					<!-- Delete -->
					
					<label class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" style="color:red;"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
					<label id="wpsite_twitter_reshare_delete_url_<?php echo $account['id']; ?>" style="display:none;"><?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=delete&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_delete'); ?></label>
					
					<!-- <a style="color:red" class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=delete&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_delete'); ?>"><?php _e('Delete', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> -->
				</td>
				
				
				<!-- Minimun Interval -->
				
				<td> 
					<label><?php echo (isset($account['general']['min_interval']) && $account['general']['min_interval'] != '' ? __($account['general']['min_interval'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?></label><br />
					
					<!-- Reshare Now -->
					
					<a class="wpsite_twitter_reshare_admin_delete_ahref wpsite_twitter_reshare_admin_delete_ahref<?php echo $account['id']; ?>" href="<?php echo wp_nonce_url($_SERVER['PHP_SELF'] . '?page=' . self::$account_dashboard_page . '&action=reshare&account=' . $account['id'], 'wpsite_twitter_reshare_admin_settings_reshare_now'); ?>"><?php _e('Reshare Now', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></a> 
				</td>
				
				<!-- Type -->
				
				<td> <?php echo (isset($account['type']) && $account['type'] != '' ? __($account['type'], WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN) : ''); ?> </td>
			</tr><?php
		}
			
	?></tbody>
</table>
</div>
<label style="color:red"><?php _e('**Please note that if plugin is deleted then all WPsite Twitter Reshare accounts will be deleted.  Also, if this plugin is deactivated, then all WPsite Twitter Reshare accounts will be deactivated as well.', WPSITE_TWITTER_RESHARE_PLUGIN_TEXT_DOMAIN); ?></label>
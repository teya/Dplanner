<?php /* Template name: Clients */ ?><?php get_header(); ?><div class="clients">	<a id="create_clients" class="button_1" href="/add-client/">+ Create Client</a></div><div class="display_main"><?php 		$table_name = $wpdb->prefix . "custom_client"; 		$clients = $wpdb->get_results("SELECT * FROM {$table_name}");		$client_names = $wpdb->get_results("SELECT client_name FROM {$table_name} GROUP BY client_name");				foreach ($client_names as $client_name):		//print_r($client_name);?>	<div class="display_section">		<h2 class="display_title"><?php echo $client_name->client_name; ?></h2>		<?php foreach ($clients as $client): ?>			<?php if ($client->client_name == $client_name->client_name): ?>		<div class="display_list">			<a class="button_2 display_button" href="/edit-client/?id=<?php echo $client->ID ?>">Edit</a>			<h3 class="display_subtitle"><?php echo $client->client_contact_person; ?></h3>		</div>		<div class="display_separator"></div>			<?php endif; ?>		<?php endforeach; ?>	</div>	<?php endforeach; ?></div><?php get_footer(); ?>
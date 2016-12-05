<?php /* Template name: Import */ ?>
<?php get_header(); ?>
<div class="kanbanflow_import">
<?php	
$token = "apiToken=e1f2928c903625d1b6b2e7b00ec12031";
$url="https://kanbanflow.com/api/v1/board?" . $token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);

$result_array = json_decode($result, true);
$counter = 1;
	foreach($result_array['columns'] as $column){
		$get_task_by_column = "https://kanbanflow.com/api/v1/tasks?" . $token . "&columnId=" . $column['uniqueId'];
		
		$ch2 = curl_init();
		curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch2, CURLOPT_URL,$get_task_by_column);
		$result2 = curl_exec($ch2);
		
		$task = json_decode($result2, true);
		foreach($task as $task_col){
			if($task_col['swimlaneName'] == 'Website Dev'):
		?>
		<div class="website_dev">
			<?php if($counter == 1): ?>
			<h1 class="task_div"><?php echo $task_col['swimlaneName']; ?></h1>
			<?php endif; ?>
			<div class="column">
				<h3 class="task_heading"><?php echo $task_col['columnName']; ?></h3>
				<?php foreach($task_col['tasks'] as $single_task):?>
				<?php 

				$get_task_by_date = "https://kanbanflow.com/api/v1/tasks/". $single_task['_id'] ."/events?from=".date("Y-m-d")."T00:00Z&" . $token;
				$ch3 = curl_init();
				
				curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);  
				curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);  
				curl_setopt($ch3, CURLOPT_URL,$get_task_by_date); 
				$result3 = curl_exec($ch3);
				
				$task_now = json_decode($result3, true);
				foreach ($task_now as $item){
					if ($item != null){
						foreach($item as $event_item){
							
							foreach($event_item['detailedEvents'] as $item){								
								$get_task_item = "https://kanbanflow.com/api/v1/tasks/" . $item['taskId'] . "?&" . $token;
								$ch4 = curl_init();
								
								curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false);  
								curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);  
								curl_setopt($ch4, CURLOPT_URL,$get_task_item); 
								$result4 = curl_exec($ch4);
								
								$item_now = json_decode($result4, true);?>
								<li><?php echo $item_now['name']; ?></li>
				<?php								
							}							
						}
					}					
				}
				
				?>
				
				<?php endforeach;?>
			</div>
		</div>
		<?php endif; ?>		
<?php } ?>
<?php $counter++; } ?>
</div>
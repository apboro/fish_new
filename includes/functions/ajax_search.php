<?php
	$search = $_POST['search'];
	$tovar_query=tep_db_query("SELECT products_model FROM `products` WHERE `products_model` LIKE 'scatex21%'");
	//$result = tep_db_fetch_array($tovar_query);
 	//print_r($result);
		?>
		<div class="search_result">
			<table>
				<?php while ($result = tep_db_fetch_array($tovar_query)){
				      foreach ($result as $row): ?>
				<tr>
					<td class="search_result-name">
						<a href="#"><?php echo $row['products_model']; ?></a>
					</td>
					<td class="search_result-btn">
						<a href="#">Добавить</a>
						
					</td>
					
				</tr>
				<?php endforeach; }?>
			</table>
		</div>

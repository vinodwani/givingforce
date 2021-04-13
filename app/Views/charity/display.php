<!DOCTYPE html>
<html lang="en">
<head> 
	<meta charset="UTF-8">
	<title>Create Application for Corporate donation to Charity</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
	<link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet" type="text/css">
	
	<link type="text/css" rel="stylesheet" href="<?= base_url(); ?>/assets/jquery-ui-1.12.1/jquery-ui.css" />
	
	<!-- STYLES -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

	<!--load jquery-->
	<script src="<?= base_url(); ?>/assets/js/jquery.js"></script>
	<script src="<?= base_url(); ?>/assets/js/charity.js"></script>
	<!--load jquery ui js file-->
	<script src="<?= base_url(); ?>/assets/jquery-ui-1.12.1/jquery-ui.js"></script>
</head>
<body>
<!-- CONTENT -->
<div>
	<?php $attributes = array('name' => 'charityForm', 'id' => 'charityForm');
	echo form_open('', $attributes);?>
	<div class="container">
		<div>
			<div class="card-header"><h1>Charity List</h1></div>
			<?php if (count($result) > 0) {?>
			<table id="articles">
				<thead>
					<th>Charity Name</th>
					<th>Country Name</th>
					<th>Is Approved</th>
					<th>Action</th>
				</thead>
				<tbody>
				<?php foreach ($result as $row) { 
					$content = ($row->is_approved == 1)? 'Disapprove' : 'Approve';
					$data = array(
						'name' => 'button',
						'id' => 'charityStatus',
						'value' => (int)$row->is_approved,
						'content' => $content
					);
					?>
					<tr id=<?=$row->charity_id;?>>
						<td><?=$row->charity_name;?></td>
						<td><?=$row->country_name;?></td>
						<td id='charityFlag_<?=$row->charity_id?>'><?=($row->is_approved)? 'Yes' : 'No';?></td>
						<td><?=form_button($data);?></td>
					</tr>                  
				<?php } ?>              
				</tbody>
			</table>
			<?php } ?>
		</div>
	</div>
	<?=form_close();?>
</div>
<script>
    var base_url = "<?= base_url(); ?>";
</script>
</body>
</html>

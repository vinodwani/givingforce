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
	<!--load jquery ui js file-->
	<script src="<?= base_url(); ?>/assets/jquery-ui-1.12.1/jquery-ui.js"></script>
</head>
<body>
<!-- CONTENT -->
<div>
	<?php
	$attributes = array('name' => 'applicationForm', 'id' => 'formId');
	echo form_open(base_url().'/application/save', $attributes);
	$validation = \Config\Services::validation();

	if (!empty($message)) { $class = ($success === false)? 'bar error' : 'bar success'; ?>
		<div class='<?=$class;?>'><?= $message; ?></div>
	<?php 
	} else { ?>
		<div class="container mt-5">
			<table id='application_table' class='containerTableClass'>
				<tr>
					<td class="commonTdClass">Application Name : <span>*</span></td>
					<td>
						<?php echo form_input(array('name' => 'appName', 'id' => 'applicationName', 'value' => $appName)); ?>
						<!-- Error -->
						<?php if ($validation->getError('appName')) {?>
							<div class='alert alert-danger mt-2'>
							<?= $error = $validation->getError('appName'); ?>
							</div>
						<?php }?>
					</td>
				</tr>
				<tr>
					<td class="commonTdClass">Charity : <span>*</span></td>
					<td><?php $attributes = array("id" => "charityId", "class" => "charityclass");
						echo form_dropdown('charity', $charity, $charitySelected, $attributes); ?>
						<?php if($validation->getError('charity')) {?>
							<div class='alert alert-danger mt-2'>
							<?= $error = $validation->getError('charity'); ?>
							</div>
						<?php }?>
					</td>
				</tr>
				<tr>
					<td class="commonTdClass">Application Date : <span>*</span></td>
					<td><?php $attributes = 'id="app_date" placeholder="Application date"';
						echo form_input('app_date', set_value('app_date'), $attributes); ?>

						<?php if ($validation->getError('app_date')) {?>
							<div class='alert alert-danger mt-2'>
							<?= $error = $validation->getError('app_date'); ?>
							</div>
						<?php }?>
					</td>
				</tr>
				<tr>
					<td class="commonTdClass">Description : </td>
					<td> <?php 
						$data = array('name'=>'comment','rows'=>'5','cols'=>'35', 'value' => $comment);
						echo form_textarea($data);?>
					</td>
				</tr>
				<tr>
					<td class="commonTdClass">&nbsp;</td>
					<td><?php echo form_submit('submit', 'Submit Application');?></td>
				</tr>
				<?php echo form_hidden('userId', $userId); ?>
			</table>
		</div>
	<?php }
	echo form_close();
	?>
</div>

<script type="text/javascript">
$(function() {
    $("#app_date").datepicker({  maxDate: -1 });
});
</script>
</body>
</html>

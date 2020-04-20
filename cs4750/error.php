<!-- handles displaying error messages to user -->
<?php
	session_start();
	if(!empty($_SESSION['message'])) {
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}else{
		$message = NULL;
	}
?>
<?php if($message) : ?>
	<div class="alert alert-danger">
    <a class="close" href="#" data-dismiss="alert">×</a>
	<?php echo $message ?>
  	</div>
<?php endif; ?>
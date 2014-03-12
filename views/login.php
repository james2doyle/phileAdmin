<?php include 'partials/header.php'; ?>
<header>
	<div class="center">
    <img src="img/logo.png" alt="">
  </div>
  <h4>Please Enter In Your Password To Manage This Site</h4>
</header>
<form action="admin/login_form" method="post" accept-charset="utf-8">
	<input type="text" name="hun-e-p0t" value="">
	<input type="text" name="username" value="" autofocus="autofocus" placeholder="Username">
	<input type="password" name="password" value="" placeholder="Password">
	<input type="submit" class="btn btn-save" name="submit" value="Login">
	<a href="<?php echo $base_url ?>" class="btn btn-cancel">Go To Homepage</a>
</form>
<?php include 'partials/footer.php'; ?>

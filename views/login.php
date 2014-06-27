<?php
	include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="clearfix"></div>
	  <table class="item-list">
		<colgroup>
		  <col span="1" style="width: 20%;">
		  <col span="1" style="width: 80%;">
		</colgroup>
	  <tbody>
		<tr>
		  <th>Username</th>
		  <td>
			<input type="text" name="username" id="username" placeholder="Username" class="input-100 hint--error">
		  </td>
		<tr>
		  <th>Password</th>
		  <td>
			<input type="password" name="password" id="password" placeholder="Password" class="input-100">
		  </td>
		</tr>
	  </tbody>
	</table>
	<div class="editor-buttons">
	  <input type="submit" class="btn blue" value="Login" id='login'>
	</div>
  </section>
<?php include 'partials/footer.php'; ?>

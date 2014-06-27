<?php include 'partials/header.php'; ?>
<section id="content" class="content">
	<div class="breadcrumb">
		<ul>
			<li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
			<li><em><?php echo $user_name; ?></em></li>
			</ul>
		</div>
		<div class="clearfix"></div>
		<table class="item-list">
			<colgroup>
				<col span="1" style="width: 25%;">
				<col span="1" style="width: 75%;">
			</colgroup>
			<tr>
				<td><strong>Username<strong></td>
				<td>
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $user['id']; ?>">
					<input type="text" name="user_username" id="user_username" <?php if($user['username'] != '') { echo 'disabled="disabled"'; } ?> value="<?php echo $user['username']; ?>" placeholder="Username" class="input-100">
				</td>
			</tr>
			<tr>
				<td><strong>Display Name<strong></td>
				<td>
					<input type="text" name="user_displayname" id="user_displayname" value="<?php echo $user['displayname']; ?>" placeholder="Display Name" class="input-100">
				</td>
			</tr>
			<tr>
				<td><strong>Email<strong></td>
				<td>
					<input type="text" name="user_email" id="user_email" value="<?php echo $user['email']; ?>" placeholder="Email" class="input-100">
				</td>
			</tr>
			<tr>
				<td><strong>Password<strong></td>
				<td>
					<input type="password" name="user_password" id="user_password" placeholder="Password" class="input-100">
				</td>
			</tr>
		</table>
		<div class="editor-buttons">
			<button type="button" id="save-user" class="btn publish-btn blue">Save</button>
			<button type="button" id="cancel-edit" class="btn cancel-btn gray">Cancel</button>
		</div>
	</section>
	<?php include 'partials/footer.php'; ?>

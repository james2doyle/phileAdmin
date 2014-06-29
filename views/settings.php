<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
		<form name="form_settings" id="form_settings">
		  <div class="breadcrumb">
			<ul>
			  <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
			  <li>Admin Settings</li>
			</ul>
		  </div>
		  <div class="clearfix"></div>
		  <table class="item-list" id="safe_settingsX">
			<colgroup>
			  <col span="1" style="width: 5%;">
			  <col span="1" style="width: 40%;">
			  <col span="1" style="width: 55%;">
		    </colgroup>
		  <thead>
			<tr>
			  <th></th>
			  <th>Key</th>
			  <th>Value</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php foreach ($safe_settings as $key => $value): ?>
			<tr id="<?php echo $key ?>">
			  <td align="center" class="actions">
				<a class="btn red small hint--right delete-setting" data-hint="Delete Key"><span class="oi" data-glyph="delete"></span></a>
			  </td>
			  <td><?php echo $key ?></td>
			  <td><input type="text" name="safe_settings[<?php echo $key ?>]" value="<?php echo $value ?>" placeholder="<?php echo $value ?>" class="input-100"></td>
			</tr>
		  <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="editor-buttons">
		  <button type="button" class="btn blue add-setting" data-url="safe_settingsX">Add Setting</button>
		  <button type="button" class="btn green save-settings">Save Settings</button>
		</div>
		<h3>Required Fields</h3>
		<p>Fields for new pages</p>
		<table class="item-list" id="required_fieldsX">
			<colgroup>
			<col span="1" style="width: 5%;">
			<col span="1" style="width: 40%;">
			<col span="1" style="width: 55%;">
		  </colgroup>
		  <thead>
			<tr>
			  <th></th>
			  <th>Key</th>
			  <th>Value</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php foreach ($required_fields as $field): ?>
			<tr>
			  <td align="center" class="actions">
				<a class="btn red small hint--right delete-setting" data-hint="Delete Key"><span class="oi" data-glyph="delete"></span></a>
			  </td>
			  <td><?php echo $field['name'] ?></td>
				<?php if(strlen($field['default']) <= 50) { ?>
				   <td><input type="text" name="required_fields[<?php echo $field['name'] ?>]" value="<?php echo $field['default'] ?>" placeholder="<?php echo $field['default'] ?>" class="input-100"></td>
				<?php } else { ?>
				   <td style="vertical-align: top">
						<textarea name="required_fields[<?php echo $field['name'] ?>]" placeholder="<?php echo $field['default'] ?>" class="input-100"><?php echo $field['default'] ?></textarea>
					</td>
				<?php } ?>
			</tr>
		  <?php endforeach; ?>
		  </tbody>
		</table>
		<div class="editor-buttons">
		  <button type="button" class="btn blue add-setting" data-url="required_fieldsX">Add Setting</button>
		  <button type="button" class="btn green save-settings">Save Settings</button>
		</div>
	</form>
  </section>
<?php include 'partials/footer.php'; ?>

<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="breadcrumb">
        <ul>
          <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
          <li>Listing Plugins</li>
        </ul>
      </div>
      <div class="clearfix"></div>
	  <form name="form_plugins" id="form_plugins">
		  <table class="item-list">
			<colgroup>
			<col span="1" style="width: 5%;">
			<col span="1" style="width: 35%;">
			<col span="1" style="width: 15%;">
			<col span="1" style="width: 20%;">
			<col span="1" style="width: 10%;">
			<col span="1" style="width: 10%;">
			<col span="1" style="width: 5%;">
		  </colgroup>
		  <thead>
			<tr>
			  <th></th>
			  <th>Name</th>
			  <th>Namespace</th>
			  <th>Author</th>
			  <th align="right">Version</th>
			  <th align="right">Status</th>
			  <th></th>
			</tr>
		  </thead>
		  <tbody>
		  <?php foreach ($plugins_list as $plugin): ?>
			<tr id="<?php echo $plugin->slug ?>">
			  <td align="center" class="actions">
				<?php if(in_array($plugin->name, $unsafe_plugins)) { ?>
						<a class="btn gray small hint--right" data-hint="Delete Plugin (protected)" data-url="<?php echo $plugin->name; ?>"><span class="oi" data-glyph="delete"></span></a>
				<?php } else { ?>
						<a class="btn red small hint--right delete-plugin" data-hint="Delete Plugin" data-url="<?php echo $plugin->name; ?>"><span class="oi" data-glyph="delete"></span></a>
				<?php } ?>
			  </td>
			  <td><?php echo $plugin->name ?></td>
			  <td><?php echo ($plugin->namespace) ? $plugin->namespace: ucfirst(explode('\\', $plugin->name)[0]); ?></td>
			  <td><?php if ($plugin->author): ?><a href="<?php echo $plugin->author['homepage'] ?>" target="_blank"><?php echo $plugin->author['name'] ?></a><?php else: ?>Undefined<?php endif ?></td>
			  <td align="right"><?php echo ($plugin->version) ? $plugin->version: 'Undefined'; ?></td>
			  <td align="right">
			  <?php if(in_array($plugin->name, $unsafe_plugins)) { ?>
				<span class="green"><strong>Enabled</strong></span>
				<input type="hidden" name="plugin_active[<?php echo $plugin->id ?>]" value="1" />
			  <?php } else { ?>
				<select name="plugin_active[<?php echo $plugin->id ?>]" class="plugin_active <?php echo ($plugin->active) ? 'green' : 'red'; ?>">
					<option value="1" class="green" <?php echo ($plugin->active) ? 'selected' : ''; ?>> Enabled </option>
					<option value="0" class="red" <?php echo (!$plugin->active) ? 'selected' : ''; ?>> Disabled </option>
				</select>
			  <?php } ?>
			  </td>
			  <td align="center" class="actions">
				<?php if ($plugin->url): ?>
					<a href="<?php echo $plugin->url ?>" target="_blank" class="btn purple small hint--left" data-hint="View Homepage"><span class="oi" data-glyph="globe"></span></a>
				<?php else: ?>
					<div class="hint--left" data-hint="No URL Set"><span class="oi" data-glyph="globe"></span></div>
				<?php endif ?>
			  </td>
			</tr>
		  <?php endforeach; ?>
		  </tbody>
		</table>
		<p class="red"><small>Disabling plugins at random can cause undesired consequences for your site.</small></p>
	</form>
    <div class="editor-buttons">
		<button type="button" class="btn green" id="save-plugins">Save Plugins Config</button>
    </div>
  </section>
<?php include 'partials/footer.php'; ?>

<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="breadcrumb">
        <ul>
          <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
          <li>Listing Plugins</li>
        </ul>
      </div>
      <div class="clearfix"></div>
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
          <th align="center"><input type="checkbox" id="check-all" value=""></th>
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
          <td align="center">
            <input type="checkbox" class="row-select" value="<?php echo $plugin->slug ?>">
          </td>
          <td><?php echo $plugin->name ?></td>
          <td><?php echo ($plugin->namespace) ? $plugin->namespace: ucfirst(explode('\\', $plugin->name)[0]); ?></td>
          <td><?php if ($plugin->author): ?><a href="<?php echo $plugin->author['homepage'] ?>" target="_blank"><?php echo $plugin->author['name'] ?></a><?php else: ?>Undefined<?php endif ?></td>
          <td align="right"><?php echo ($plugin->version) ? $plugin->version: 'Undefined'; ?></td>
          <td align="right">
          	<?php $style = ($plugin->active) ? array('block', 'none'): array('none', 'block') ?>
            <strong style="display: <?php echo $style[0] ?>" class="green">Enabled</strong>
            <strong style="display: <?php echo $style[1] ?>" class="red">Disabled</strong>
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
    <p class="red"><small>Turning off plugins at random can cause undesired consequences for your site.</small></p>
    <!-- <div class="editor-buttons">
      <button type="button" class="btn red" id="delete-selected" disabled>Toggle Selected</button>
    </div> -->
  </section>
<?php include 'partials/footer.php'; ?>

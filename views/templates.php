<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="breadcrumb">
        <ul>
          <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
          <li>Listing Templates</li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <table class="item-list">
        <colgroup>
        <col span="1" style="width: 5%;">
        <col span="1" style="width: 25%;">
        <col span="1" style="width: 65%;">
        <col span="1" style="width: 5%;">
      </colgroup>
      <thead>
        <tr>
          <th align="center"><input type="checkbox" id="check-all" value=""></th>
          <th>Name</th>
          <th>Path</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($templates as $template): ?>
        <tr id="<?php echo $template->slug ?>">
          <td align="center">
            <input type="checkbox" class="row-select" value="<?php echo $template->slug ?>" data-url="<?php echo $template->path ?>">
          </td>
          <td><?php echo $template->slug ?></td>
          <td><?php echo $template->path ?></td>
          <td align="right" class="actions">
            <a href="edit?url=<?php echo $template->path ?>&type=template" class="btn blue small hint--left" data-hint="Edit Template"><span class="oi" data-glyph="code"></span></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div class="editor-buttons">
      <a href="create?type=template" class="btn blue" id="create-template">Create Template</a>
      <button type="button" class="btn red right" id="delete-selected" disabled>Delete Selected</button>
    </div>
  </section>
<?php include 'partials/footer.php'; ?>

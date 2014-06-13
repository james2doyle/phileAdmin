<?php include 'partials/header.php'; ?>
    <section id="content" class="content">
      <div class="breadcrumb">
        <ul>
          <li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
          <li>Listing Pages</li>
        </ul>
      </div>
      <div class="clearfix"></div>
      <table class="item-list">
        <colgroup>
        <col span="1" style="width: 5%;">
        <col span="1" style="width: 25%;">
        <col span="1" style="width: 25%;">
        <col span="1" style="width: 20%;">
        <col span="1" style="width: 15%;">
        <col span="1" style="width: 10%;">
      </colgroup>
      <thead>
        <tr>
          <th align="center"><input type="checkbox" id="check-all" value=""></th>
          <th>Name</th>
          <th>Filename</th>
          <th>Layout</th>
          <th align="right">Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($pages as $page): ?>
        <tr id="<?php echo $page->slug ?>">
          <td align="center">
            <input type="checkbox" class="row-select" value="<?php echo $page->slug ?>" data-url="<?php echo $page->getURL() ?>.md">
          </td>
          <td><?php echo $page->getMeta()->title ?></td>
          <td><?php echo $page->getURL() ?>.md</td>
          <td><?php echo ($page->getMeta()->template) ? $page->getMeta()->template: 'index' ?>.html</td>
          <td align="right"><strong class="<?php echo $page->status[0] ?>"><?php echo $page->status[1] ?></strong></td>
          <td class="actions">
            <a href="edit?url=<?php echo $page->getURL() ?>&type=page" class="btn blue small hint--left" data-hint="Edit Page"><span class="oi" data-glyph="code"></span></a>
            <a href="<?php echo $base_url .'/'. $page->getURL() ?>" target="_blank" class="btn yellow small hint--left" data-hint="View Page"><span class="oi" data-glyph="eye"></span></a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <div class="editor-buttons">
      <a href="create?type=page" class="btn blue">New Page</a>
      <button type="button" class="btn red right" id="delete-selected" disabled>Delete Selected</button>
    </div>
  </section>
<?php include 'partials/footer.php'; ?>

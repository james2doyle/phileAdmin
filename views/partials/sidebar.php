<div class="side-menu">
  <div class="center">
    <a href="<?php echo $base_url ?>" class="side-logo"><img src="<?php echo $asset_path; ?>img/logo.png" width="114" height="114"></a>
  </div>
  <a href="<?php echo $base_url; ?>"><i class="fa fa-home"></i> View Site</a>
  <a href="pages" <?php if(strtolower($title) == 'pages'): ?>class="active"<?php endif; ?>><i class="fa fa-file-text"></i> Pages</a>
  <a href="media" <?php if(strtolower($title) == 'media'): ?>class="active"<?php endif; ?>><i class="fa fa-picture-o"></i> Media</a>
  <a href="settings" <?php if(strtolower($title) == 'settings'): ?>class="active"<?php endif; ?>><i class="fa fa-cogs"></i> Settings</a>
</div>

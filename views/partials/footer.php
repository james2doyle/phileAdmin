  <script src="<?php echo $asset_path; ?>js/jquery.min.js"></script>
  <script src="<?php echo $asset_path; ?>js/jquery.transit.js"></script>
  <script src="<?php echo $asset_path; ?>js/jquery.sortable.js"></script>
  <script src="<?php echo $asset_path; ?>js/jquery.dropzone.js"></script>
  <script src="<?php echo $asset_path; ?>js/behave.js"></script>
  <script src="<?php echo $asset_path; ?>js/script.js"></script>
  <?php if (strtolower($title) == 'editor'): ?>
    <script src="<?php echo $asset_path; ?>js/highlight.custom.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  <?php endif ?>
</body>
</html>

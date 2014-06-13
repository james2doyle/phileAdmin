<?php include 'partials/header.php'; ?>
<section id="content" class="content">
	<div class="breadcrumb">
		<ul>
			<li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
			<li><?php echo $title ?> <em><?php
				$page_title = (method_exists($current_page, 'getTitle')) ? $current_page->getTitle(): $title;
				echo $page_title; ?></em></li>
			</ul>
		</div>
		<div class="clearfix"></div>
		<?php if($type == 'page'): ?>
			<div class="editor-controls" id="editor-control">
				<a href="#bold" data-hint="Bold" class="hint--top"><span class="oi" data-glyph="bold"></span></a>
				<a href="#italic" data-hint="Italic" class="hint--top"><span class="oi" data-glyph="italic"></span></a>
				<a href="#strikethrough" data-hint="Strikethrough" class="hint--top"><span class="oi" data-glyph="ellipses"></span></a>
				<a href="#code" data-hint="Inline Code" class="hint--top"><span class="oi" data-glyph="code"></span></a>
				<a href="#quote" data-hint="Blockquote" class="hint--top"><span class="oi" data-glyph="double-quote-sans-left"></span></a>
				<a href="#ul-list" data-hint="Unordered list" class="hint--top"><span class="oi" data-glyph="list"></span></a>
				<a href="#ol-list" data-hint="Ordered list" class="hint--top"><span class="oi" data-glyph="list-rich"></span></a>
				<a href="#link" data-hint="Link" class="hint--top"><span class="oi" data-glyph="link-intact"></span></a>
				<a href="#image" data-hint="Image" class="hint--top"><span class="oi" data-glyph="image"></span></a>
				<a href="#h1" data-hint="Heading 1" class="hint--top"><span class="oi" data-glyph="header"></span><strong>1</strong></a>
				<a href="#h2" data-hint="Heading 2" class="hint--top"><span class="oi" data-glyph="header"></span><strong>2</strong></a>
				<a href="#h3" data-hint="Heading 3" class="hint--top"><span class="oi" data-glyph="header"></span><strong>3</strong></a>
				<a href="#h4" data-hint="Heading 4" class="hint--top"><span class="oi" data-glyph="header"></span><strong>4</strong></a>
				<a href="#h5" data-hint="Heading 5" class="hint--top"><span class="oi" data-glyph="header"></span><strong>5</strong></a>
				<a href="#h6" data-hint="Heading 6" class="hint--top"><span class="oi" data-glyph="header"></span><strong>6</strong></a>
				<a href="#hr" data-hint="Horizontal Rule" class="hint--top"><span class="oi" data-glyph="minus"></span></a>
				<a href="#markdown" data-href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" data-hint="Markdown Reference" class="hint--top"><strong>M</strong></a>
				<a href="#plugins" data-hint="Plugins Enabled" class="hint--top last"><span class="oi" data-glyph="puzzle-piece"></span></a>
				<div class="toggle-controls">
					<a href="#code" data-hint="Edit Code" class="hint--top active"><span class="oi" data-glyph="code"></span></a>
					<a href="#preview" data-hint="Preview Output" class="hint--top"><span class="oi" data-glyph="eye"></span></a>
				</div>
			</div>
		<?php endif; ?>
		<div class="editor-wrap">
			<form id="code" class="pane form" style="display: block">
				<?php if($type == 'page'): ?><small>There is a 500ms delay on the Markdown render function.</small><?php endif; ?>
				<textarea class="editor-code" id="editor-area"><?php echo $current_page->markdown; ?></textarea>
			</form>
			<div id="preview" class="pane">
				<?php echo (method_exists($current_page, 'getContent')) ? $current_page->getContent(): $current_page->content; ?>
			</div>
		</div>
		<div class="editor-buttons">
			<?php if($type == 'page' && !$is_temp): ?>
				<button type="button" id="save-file" data-url="<?php echo $current_page->getFilePath() ?>" <?php if ($is_temp): ?>data-temp="1"<?php endif ?> class="btn publish-btn blue">Save</button>
				<!-- <button type="button" id="save-draft" class="btn save-btn yellow">Save Draft</button> -->
			<?php elseif($is_temp): ?>
				<button type="button" id="save-as" data-url="<?php echo $save_path ?>" class="btn publish-btn yellow">Save As</button>
			<?php else: ?>
				<button type="button" id="save-file" data-url="<?php echo $current_page->path ?>" class="btn publish-btn blue">Save</button>
			<?php endif; ?>
			<button type="button" id="delete-file" class="btn delete-btn red" data-url="<?php echo (method_exists($current_page, 'getFilePath')) ? $current_page->getFilePath(): $current_page->path; ?>">Delete</button>
		</div>
	</section>
	<?php include 'partials/footer.php'; ?>

<?php include 'partials/header.php'; ?>
<section id="content" class="content">
	<div class="breadcrumb">
		<ul>
			<li><a href="#">Photos</a></li><span class="oi" data-glyph="chevron-right"></span>
			<li>Listing Photos</li>
		</ul>
	</div>
	<div class="clearfix"></div>
	<div class="editor-controls">
		<a href="#" id="upload-files" class="hint--top" data-hint="Upload File"><span class="oi" data-glyph="data-transfer-upload"></span></a>
		<a href="#" id="download-selected" class="hint--top" data-hint="Download Selected"><span class="oi" data-glyph="data-transfer-download"></span></a>
		<a href="#" id="view-selected" class="hint--top" data-hint="View Selected"><span class="oi" data-glyph="image"></span></a>
		<a href="#" id="file-info" class="hint--top" data-hint="File Info"><span class="oi" data-glyph="info"></span></a>
		<a href="#" class="hint--top" data-hint="Clear Selected" id="clear-selected"><span class="oi" data-glyph="ban"></span></a>
		<a href="#" class="hint--top last" data-hint="Delete File" id="delete-photos"><span class="oi" data-glyph="x"></span></a>
		<label class="range-input"><input type="range" id="column-count" value="6" step="2" min="2" max="6"><span id="column-count-val">6</span></label>
	</div>
	<form action="upload" method="post" enctype="multipart/form-data" class="dropzone center form" id="media-upload">
		<div class="drop-icon"><span class="oi" data-glyph="data-transfer-upload"></span></div>
	</form>
	<div class="photo-list columns-6">
		<?php if(count($photos) > 0):
		foreach($photos as $photo): ?>
			<div class="photo-item" id="<?php echo $photo->slug ?>">
				<img src="<?php echo $photo->url ?>" width="<?php echo $photo->info[0] ?>" height="<?php echo $photo->info[1] ?>">
				<p><input type="checkbox" name="" value="<?php echo $photo->slug ?>" data-url="<?php echo $photo->path ?>"> <?php echo $photo->name ?></p>
			</div>
		<?php endforeach;
		endif; ?>
	</div>
</section>
<?php include 'partials/footer.php'; ?>

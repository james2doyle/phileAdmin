<?php include 'partials/header.php'; ?>
<section id="content" class="content">
	<div class="breadcrumb">
		<ul>
			<li><a href="#"><?php echo $title ?></a></li><span class="oi" data-glyph="chevron-right"></span>
			<li>Listing Files</li>
		</ul>
		<small>For images, visit the <a href="photos">Photos</a> page.</small>
	</div>
	<div class="clearfix"></div>
	<p>Drop files to upload.</p>
	<form action="upload" method="post" enctype="multipart/form-data" class="dropzone center form" id="media-upload">
		<div class="drop-icon"><span class="oi" data-glyph="data-transfer-upload"></span></div>
	</form>
	<table class="item-list">
		<colgroup>
		<col span="1" style="width: 5%;">
		<col span="1" style="width: 23%;">
		<col span="1" style="width: 12%;">
		<col span="1" style="width: 7%;">
		<col span="1" style="width: 38%;">
		<col span="1" style="width: 5%;">
	</colgroup>
	<thead>
		<tr>
			<th align="center"><input type="checkbox" id="check-all" value=""></th>
			<th>Name</th>
			<th>Filetype</th>
			<th align="right">Size</th>
			<th>Path</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php if($files !== false):
		foreach ($files as $file): ?>
			<tr id="<?php echo $file->slug ?>">
				<td align="center">
					<input type="checkbox" class="row-select" value="<?php echo $file->slug ?>" data-url="<?php echo $file->path ?>">
				</td>
				<td><?php echo $file->name ?></td>
				<td><?php echo $file->mime ?></td>
				<td align="right"><?php echo $file->size ?></td>
				<td><input type="text" name="" value="<?php echo $file->path ?>" placeholder="<?php echo $file->path ?>" class="input-100"></td>
				<td align="right" class="actions">
					<a href="<?php echo $file->url ?>" target="_blank" class="btn yellow small hint--left" data-hint="View File"><span class="oi" data-glyph="eye"></span></a>
				</td>
			</tr>
		<?php endforeach;
		endif; ?>
	</tbody>
</table>
<div class="editor-buttons">
	<button type="button" class="btn blue" id="upload-files">Upload File</button>
	<button type="button" class="btn red right" id="delete-selected" disabled>Delete Selected</button>
</div>
</section>
<?php include 'partials/footer.php'; ?>

Dropzone.options.mediaUpload = {
	init: function() {
		this.on('success', function(file, res) {
			var photos = $('body').hasClass('photos');
			var files = $('body').hasClass('files');
			if (photos) {
				$('.photo-list').prepend(res.message);
			} else if (files) {
				$('.item-list').find('tbody').prepend(res.message);
			}
		});
	}
};
$(document).ready(function() {
	$.fx.speeds._default = 200;
	$('.toggle-controls').on('click', 'a', function(event) {
		event.preventDefault();
		$(this).siblings('a.active').removeClass('active');
		$('.pane').toggle();
		$(this).toggleClass('active');
		return false;
	});
	$('#check-all').on('click', function() {
		// set the state of the other checkboxes to this parent one
		$('.row-select').prop('checked', $(this).prop('checked'));
		// disabled is the opposite of the checked
		$('#delete-selected').prop('disabled', !$(this).prop('checked'));
	});
	$('.item-list').on('click', '.row-select', function() {
		var checked = false;
		// if there is one checked item, let me know
		$(this).each(function(i, e) {
			if ($(this).prop('checked')) {
				checked = true;
			}
		});
		// the final state of the button
		$('#delete-selected').prop('disabled', !checked);
	});

	function deleteFile(url) {
		return $.post('delete_file', {
			value: url
		});
	}

	function handleDelete(i, e, items, plugins) {
		var $input = $(e).find('input');
		if ($input.prop('checked')) {
			items.push({
				value: $input.attr('data-url')
			});
			deleteFile($input.attr('data-url')).then(function() {
				var $target = $('#' + $input.val());
				if (plugins) {
					$target.find('strong').toggle();
					items.forEach(function(index) {
						index.status = $target.find('strong:visible').text();
					});
				} else {
					$target.transition({
						scale: 0
					}, 500, 'ease', function() {
						$(e).remove();
					});
				}
			}, function function_name(argument) {
				vex.dialog.alert('<p>Error Deleting File</p>');
			});
		}
		$input.each(function(index, el) {
			$(el).prop('checked', false);
		});
	}

	function deleteItems($parent) {
		var plugins = $('body').hasClass('plugins');
		var count = $parent.find('input').filter(':checked').length;
		if(count == 0) return false;
		vex.dialog.confirm({
			message: 'Are you absolutely sure you want to ' + ((plugins) ? 'toggle' : 'delete') + ' ' + count + ' item' + ((count > 1) ? 's' : '') + '?',
			callback: function(value) {
				if (value) {
					var items = [];
					$parent.each(function(i, e) {
						handleDelete(i, e, items, plugins);
					});
					$('#delete-selected').prop('disabled', true);
					$('#check-all').prop('checked', false);
				}
			}
		});
	}
	$('#delete-selected').on('click', function() {
		deleteItems($('.item-list').find('tbody').find('tr'));
	});
	$('.content').on('click', '.photo-item', function() {
		var $input = $(this).find('input');
		// simple toggle of the checked attr
		$input.prop('checked', !$input.prop('checked'));
		$(this).toggleClass('selected');
	});
	$('#delete-photos').on('click', function(event) {
		event.preventDefault();
		deleteItems($('.photo-item'));
		return false;
	});
	$('#clear-selected').on('click', function(event) {
		event.preventDefault();
		$('.photo-item').each(function(index, el) {
			$(el).find('input').prop('checked', false);
			$(el).removeClass('selected');
		});
		return false;
	});
	$('#column-count').on('input', function() {
		$('.photo-list').attr('class', 'photo-list');
		$('.photo-list').addClass('columns-' + $(this).val());
		$('#column-count-val').text($(this).val());
		// Store the choice of columns
		store.set('photo-columns', $(this).val());
	});
	// set the default style for vex
	vex.defaultOptions.className = 'vex-theme-default';
	$('.view-image').on('click', function(event) {
		event.preventDefault();
		var url = $(this).attr('data-url');
		vex.dialog.alert('<p class="center"><img src="' + url + '" /></p>');
		return false;
	});
	$('#add-setting').on('click', function(event) {
		event.preventDefault();
		var template = '<tr id="key"><td align="center"><input type="checkbox" class="row-select" value="key"></td><td><input type="text" name="" value="Key For New Setting" placeholder="Key For New Setting" class="input-100"></td><td><input type="text" name="" value="Value For New Setting" placeholder="Value For New Setting" class="input-100"></td></tr>';
		var key = $('.item-list').find('tbody').append(template).find('tr').last().find('input')[1];
		key.setSelectionRange(0, key.value.length);
		return false;
	});
	$('#file-info').on('click', function(event) {
		event.preventDefault();
		$('.photo-list').find('.selected').each(function(index, el) {
			var val = $(el).find('input').attr('data-url');
			$.post('file_info', {
				value: val
			}).then(function(res) {
				res.message.forEach(function(template) {
					vex.dialog.alert(template);
					$('.input-100, .input-hidden').on('click', function(event) {
						this.setSelectionRange(0, this.value.length);
					});
				});
			}, function(err) {
				console.log(err);
			});
		});
		return false;
	});
	$('#view-selected').on('click', function(event) {
		event.preventDefault();
		$('.photo-list').find('.selected').each(function(index, el) {
			var val = $(el).find('img').attr('src');
			var name = $(el).find('input').attr('data-url');
			vex.dialog.alert('<div class="center"><img src="' + val + '" width="320" /><input type="text" value="' + name + '" placeholder="' + name + '" class="input-hidden" /></div>');
			$('.input-hidden').on('click', function(event) {
				this.setSelectionRange(0, this.value.length);
			});
		});
		return false;
	});
	$('#download-selected').on('click', function(event) {
		event.preventDefault();
		var photos = $('body').hasClass('photos');
		var files = $('body').hasClass('files');
		if (photos) {
			$('.photo-list').find('.selected').each(function(index, el) {
				var val = $(el).find('input').attr('data-url');
				var win = window.open('download?url=' + val, '_blank');
				win.focus();
			});
		}
		return false;
	});

	$('#upload-files').on('click', function(event) {
		event.preventDefault();
		$('#media-upload').trigger('click');
		return false;
	});
	$('#save-file').on('click', function(event) {
		event.preventDefault();
		$.post('save', {
			path: $(this).attr('data-url'),
			pageType: pageType,
			value: $('#editor-area').val()
		}).then(function(res) {
			console.log(res);
			vex.dialog.alert('<p>File Saved Succcessfully</p>');
			setTimeout(function() {
				vex.close();
			}, 1500);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('<p>Error Saving File</p>');
			setTimeout(function() {
				vex.close();
			}, 1500);
		});
		return false;
	});
	$('#save-as').on('click', function(event) {
		event.preventDefault();
		var url = $(this).attr('data-url');
		vex.dialog.prompt({
			message: 'Give this file a name:',
			placeholder: 'File name',
			callback: function(value) {
				if(value == false) return false;
				if(value.indexOf('-') === -1) {
					value += $('#default-extension').val()
				}
				$.post('save', {
					path: url + value,
					filename: value,
					pageType: pageType,
					value: $('#editor-area').val()
				}).then(function(res) {
					console.log(res);
					vex.dialog.alert(res.message);
					setTimeout(function() {
						vex.close();
						window.location.href = 'edit?url='+res.path+'&type=' + pageType;
					}, 1500);
				}, function(err) {
					console.log(err);
					vex.dialog.alert('<p>Error saving file</p>');
					setTimeout(function() {
						vex.close();
					}, 1500);
				});
			}
		});
		return false;
	});
	
	$('#cancel-edit').on('click', function(event) {
		window.history.back();
	});
	
	$('#delete-file').on('click', function(event) {
		event.preventDefault();
		$.post('delete', {
			path: $(this).attr('data-url')
		}).then(function(res) {
			console.log(res);
			vex.open({
				content: '<p>File Deleted Succcessfully</p>',
				afterClose: function() {
					window.history.back();
				}
			});
			setTimeout(function() {
				vex.close();
				window.history.back();
			}, 1500);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('<p>Error Deleting File</p>');
			setTimeout(function() {
				vex.close();
			}, 1500);
		});
		return false;
	});

	function loadPhotoColumns() {
		if (store.get('photo-columns')) {
			var val = store.get('photo-columns');
			$('.photo-list').removeClass('columns-6').addClass('columns-' + val);
			$('#column-count').val(val);
			$('#column-count-val').text(val);
		}
	}
	$('.input-100').on('click', function(event) {
		this.setSelectionRange(0, this.value.length);
	});
	loadPhotoColumns();
});

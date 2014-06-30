// dropzone for Photos and Files pages
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
	var TIMEOUT_LENGTH = 1500;
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
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('<p>Error Saving File</p>');
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
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
					}, TIMEOUT_LENGTH);
				}, function(err) {
					console.log(err);
					vex.dialog.alert('<p>Error saving file</p>');
					setTimeout(function() {
						vex.close();
					}, TIMEOUT_LENGTH);
				});
			}
		});
		return false;
	});
	
	
	$('#login').on('click', function(event) {
		event.preventDefault();
		$.post('validate_login', {
			username: $('#username').val(),
			password: $('#password').val()
		}).then(function(res) {
			console.log(res);
			vex.dialog.alert(res.message);
			setTimeout(function() {
				vex.close();
				window.location.href = '';
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('Error saving user: ' + err.responseJSON.message);
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
		});
		return false;
	});
	var counterSettings = 0;
	$('.add-setting').on('click', function(event) {
		event.preventDefault();
		counterSettings++;
		var template = '<tr><td align="center" class="actions"><a class="btn red small hint--right delete-setting" data-hint="Delete Key"><span class="oi" data-glyph="delete"></span></a></td><td><input type="text" name="'+$(this).attr('data-url')+'key['+counterSettings+']" value="" placeholder="New Key Name" class="input-100"></td><td><input type="text" name="'+$(this).attr('data-url')+'value['+counterSettings+']" value="" placeholder="New Key Value" class="input-100"></td></tr>';
		var tableID = '#'+$(this).attr('data-url');
		$(tableID).find('tbody').append(template).find('tr').last().find('input')[1];
		return false;
	});
	$('.delete-setting').on('click', function() {
		$(this).parent().parent().remove();
	});
	$('.save-settings').on('click', function(event) {
		event.preventDefault();
		$.post('save_settings', {
			settings : $("#form_settings").serialize()
		}).then(function(res) {
			console.log(res);
			vex.dialog.alert(res.message);
			setTimeout(function() {
				vex.close();
				location.reload();
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('Error saving settings');
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
		});
		return false;
	});
	$('.save-config').on('click', function(event) {
		event.preventDefault();
		$.post('save_config', {
			config : $("#form_config").serialize()
		}).then(function(res) {
			console.log(res);
			vex.dialog.alert(res.message);
			setTimeout(function() {
				vex.close();
				location.reload();
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('Error saving config');
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
		});
		return false;
	});
	$('#save-user').on('click', function(event) {
		event.preventDefault();
		$.post('save_user', {
			user_id: $('#user_id').val(),
			username: $('#user_username').val(),
			display_name: $('#user_displayname').val(),
			email: $('#user_email').val(),
			password: $('#user_password').val()
		}).then(function(res) {
			console.log(res);
			vex.dialog.alert(res.message);
			setTimeout(function() {
				vex.close();
				location.reload();
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('Error saving user: ' + err.responseJSON.message);
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
		});
		return false;
	});
	$('#save-user').on('click', function(event) {
		event.preventDefault();
		$.post('save_user', {
			user_id: $('#user_id').val(),
			username: $('#user_username').val(),
			display_name: $('#user_displayname').val(),
			email: $('#user_email').val(),
			password: $('#user_password').val()
		}).then(function(res) {
			console.log(res);
			vex.dialog.alert(res.message);
			setTimeout(function() {
				vex.close();
				location.reload();
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('Error saving user: ' + err.responseJSON.message);
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
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
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('<p>Error Deleting File</p>');
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
		});
		return false;
	});
	$(".plugin_active").change(function() {
		$(this).removeClass();
		$(this).addClass($(this).attr('name') + ' ' + $("option:selected", this).attr('class'));
	});
	$('.delete-plugin').on('click', function(event) {
		event.preventDefault();
		var plugin_slug = $(this).attr('data-url');
		vex.dialog.confirm({
			message: 'Are you absolutely sure you want to delete this plugin?',
			callback: function(value) {
				if (value) {
					$.post('delete_plugin', {
						slug : plugin_slug
					}).then(function(res) {
						console.log(res);
						vex.dialog.alert(res.message);
						$(this).parent().parent().remove();
						setTimeout(function() {
							vex.close();
							location.reload();
						}, TIMEOUT_LENGTH);
					}, function(err) {
						console.log(err);
						vex.dialog.alert('Error deleting plugin');
						setTimeout(function() {
							vex.close();
						}, TIMEOUT_LENGTH);
					});
				}
			}
		});
		return false;
	});
	$('#save-plugins').on('click', function(event) {
		event.preventDefault();
		$.post('save_plugins', {
			plugins : $("#form_plugins").serialize()
		}).then(function(res) {
			console.log(res);
			vex.dialog.alert(res.message);
			setTimeout(function() {
				vex.close();
				location.reload();
			}, TIMEOUT_LENGTH);
		}, function(err) {
			console.log(err);
			vex.dialog.alert('Error saving plugins config');
			setTimeout(function() {
				vex.close();
			}, TIMEOUT_LENGTH);
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

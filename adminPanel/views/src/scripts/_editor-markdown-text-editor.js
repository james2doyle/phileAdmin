document.addEventListener('DOMContentLoaded', function() {

	// => http://stackoverflow.com/a/7592235/1163000
	String.prototype.capitalize = function(lower) {
		return (lower ? this.toLowerCase() : this).replace(/(?:^|\s)\S/g, function(a) {
			return a.toUpperCase();
		});
	};

	var myTextArea = $('#editor-area')[0],
		myButton = $('#editor-control > a'),
		myEditor = new Editor(myTextArea);

	var controls = {
		'bold': function() {
			myEditor.wrap('**', '**');
		},
		'italic': function() {
			myEditor.wrap('*', '*');
		},
		'strikethrough': function() {
			myEditor.wrap('~~', '~~');
		},
		'code': function() {
			myEditor.wrap('`', '`');
		},
		// 'code-block': function() {
		//     myEditor.indent('    ');
		// },
		'quote': function() {
			myEditor.indent('\n> ');
		},
		'ul-list': function() {
			var sel = myEditor.selection(),
				added = "";
			if (sel.value.length > 0) {
				myEditor.indent('', function() {
					myEditor.replace(/^[^\n\r]/gm, function(str) {
						added += '* ';
						return str.replace(/^/, '* ');
					});
					myEditor.select(sel.start, sel.end + added.length);
				});
			} else {
				var placeholder = '* List Item';
				myEditor.indent(placeholder, function() {
					myEditor.select(sel.start + 2, sel.start + placeholder.length);
				});
			}
		},
		'ol-list': function() {
			var sel = myEditor.selection(),
				ol = 0,
				added = "";
			if (sel.value.length > 0) {
				myEditor.indent('', function() {
					myEditor.replace(/^[^\n\r]/gm, function(str) {
						ol++;
						added += ol + '. ';
						return str.replace(/^/, ol + '. ');
					});
					myEditor.select(sel.start, sel.end + added.length);
				});
			} else {
				var placeholder = '1. List Item';
				myEditor.indent(placeholder, function() {
					myEditor.select(sel.start + 3, sel.start + placeholder.length);
				});
			}
		},
		'link': function() {
			var sel = myEditor.selection();
			var placeholder = 'Link text goes here...';
			var title = "The title for this page";
			var url = "http://";
			myEditor.wrap('\n\n[' + (sel.value.length === 0 ? placeholder : ''), '](' + url + (title !== "" ? ' \"' + title + '\"' : '') + ')\n\n', function() {
				myEditor.select(sel.start + 3, (sel.value.length === 0 ? sel.start + placeholder.length + 3 : sel.end + 1));
			});
		},
		'image': function() {
			var sel = myEditor.selection();
			var url = "http://";
			var placeholder = "Description of image";
			var title = "The title for this image";
			myEditor.wrap('\n\n![' + (sel.value.length === 0 ? placeholder : ''), '](' + url + (title !== "" ? ' \"' + title + '\"' : '') + ')\n\n', function() {
				myEditor.select(sel.start + 4, (sel.value.length === 0 ? sel.start + placeholder.length + 4 : sel.end + 4));
			});
		},
		'h1': function() {
			heading('#');
		},
		'h2': function() {
			heading('##');
		},
		'h3': function() {
			heading('###');
		},
		'h4': function() {
			heading('####');
		},
		'h5': function() {
			heading('#####');
		},
		'h6': function() {
			heading('######');
		},
		'hr': function() {
			myEditor.insert('\n---\n\n');
		},
		'markdown': function() {
			// hack to open new tab
			var win = window.open(this.dataset.href, '_blank');
			win.focus();
			return true;
		},
		'plugins': function() {
			vex.dialog.alert('<h3>The following helper plugins are enabled:</h3><p>Please read the documentation for these plugins in order to better understand how they work.</p><ul><li><a href="https://github.com/PhileCMS/phileRender" target="_blank">phileRender</a></li><li><a href="https://github.com/PhileCMS/phileInlineImage" target="_blank">phileInlineImage</a></li><li><a href="https://github.com/PhileCMS/phileContentVariables" target="_blank">phileContentVariables</a></li></ul>');
		},
		'undo': function() {
			myEditor.undo();
		},
		'redo': function() {
			myEditor.redo();
		}
	};

	function heading(key) {
		if (myEditor.selection().value.length > 0) {
			myEditor.wrap(key + ' ', "");
		} else {
			var placeholder = key + ' Heading ' + key.length + '\n\n';
			myEditor.insert(placeholder, function() {
				var s = myEditor.selection().start;
				myEditor.select(s - placeholder.length + key.length + 1, s - 2);
			});
		}
	}

	function click(elem) {
		var hash = elem.hash.replace('#', "");
		if (controls[hash]) {
			elem.onclick = function() {
				controls[hash].call(this);
				delayer.call(myEditor.area);
				return false;
			};
		}
	}

	for (var i = 0, len = myButton.length; i < len; ++i) {
		click(myButton[i]);
		myButton[i].href = 'javascript:;';
	}

	function delayer() {
		// do an ajax save when this input is changed
		var val = this.value;
		// clear the timeout so we dont fire in succession
		clearTimeout(this.delayer);
		this.delayer = setTimeout(function() {
			$.post('parse_markdown', {
				content: val
			}).then(function(res) {
				$('#preview').html(res.content);
			}, function(err) {
				console.log(err);
			});
		}, 500);
	}

	var pressed = 0;
	if (typeof(myEditor.area) !== 'undefined') {
		myEditor.area.onkeydown = function(e) {

			// Update history data on every 5 key presses
			// if (pressed < 5) {
			//   pressed++;
			// } else {
			//   myEditor.updateHistory();
			//   pressed = 0;
			// }

			// Press `Shift + Tab` to outdent
			if (e.shiftKey && e.keyCode == 9) {
				// Outdent from quote
				// Outdent from ordered list
				// Outdent from unordered list
				// Outdent from code block
				myEditor.outdent('(> |[0-9]+\. |- |    )');
				return false;
			}

			// Press `Tab` to indent
			if (e.keyCode == 9) {
				myEditor.indent('    ');
				return false;
			}

		};
		myEditor.area.addEventListener('keyup', delayer);
	}
});

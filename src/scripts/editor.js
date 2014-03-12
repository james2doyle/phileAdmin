var area = document.getElementById('editor');
var editor;

function doSaveContent() {
  var data = {
    path: area.dataset.path,
    value: area.value
  };
  $.post(admin.url+'save', data).done(function(res) {
    phile.message(res.message);
  });
}

function parseMarkdown(value) {
  $.post(admin.url+'parse_markdown', { content: value }).done(function(res) {
    var $viewer = $('#viewer');
    $viewer.html(res);
    area.style.height = $viewer.outerHeight() + 30 + 'px';
  });
}

function makeEditor(callback) {
  BehaveHooks.add('keyup', function(data) {
    var val = data.editor.element.value;
    if (val !== '') {
      // clear the timeout so we dont fire in succession
      clearTimeout(this.delayer);
      this.delayer = setTimeout(function () {
        parseMarkdown(val);
      }, 500);
    }
  });
  editor = new Behave({
    textarea: area,
    replaceTab: false,
    softTabs: false,
    tabSize: 4,
    autoOpen: false,
    overwrite: true,
    autoStrip: true,
    autoIndent: false,
    fence: true
  });
  $('#save-content').on('click', doSaveContent);
  callback();
}

$(function() {
  if ($('body').hasClass('editor-template')) {
    makeEditor(function() {
      // $.get('action/cheatsheet.md', function(data) {
      //   area.innerText = data;
      //   parseMarkdown(area.value);
      // });
    area.style.height = $('#viewer').outerHeight() + 30 + 'px';
  });
  }
});

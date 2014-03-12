function addEvents() {
  $('.upload-thumb p').swappable();
}

function getFiles() {
  $.get('media_template', function(res) {
    $('#file-area').html(res);
    addEvents();
  });
}

$(function() {
  if ($('body').hasClass('media-template')) {
    if (typeof(Dropzone) !== 'undefined') {
      Dropzone.options.mediaUpload = {
        init: function() {
          this.on("complete", getFiles);
        }
      };
    }
  }
});

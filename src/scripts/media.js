function addEvents() {
  $('.upload-thumb p').last().swappable();
}

function getFiles() {
  $.get('media_template').done(function(res) {
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
    $('.upload-thumb p').swappable();
  }
});

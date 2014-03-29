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
    $('.upload-thumb').on('click', '.top-close', function(event) {
      event.preventDefault();
      var $parent = $(this).parent();
      $.post('delete_media', { filename: $parent.attr('data-path') }).then(function(res) {
        phile.message(res.message);
        $parent.transit({
          scale: 0,
          opacity: 0
        }, 400, function() {
          $parent.remove();
        });
      }, function(res) {
        phile.message(res.message);
      });
      return false;
    });
  }
});

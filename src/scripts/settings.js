function updateSettings() {
  var data = {};
  $('.settings-control').each(function(index, el) {
    data[$(el).find('.prop-key').val()] = $(el).find('.prop-value').val();
  });
  $.post('save_settings', { settings: data }).done(function(res) {
    phile.message(res.message);
  });
}

function buttonFns() {
  $('#delete-setting').on('click', function(event) {
    event.preventDefault();
    $('.settings-control').find('.prop-check').each(function(index, el) {
      if ($(el).prop('checked')) {
        $(el).parent().transit({
          opacity: 0,
          scale: 0,
          height: 0
        }, 400, function() {
          $(this).remove();
        });
      }
    });
    return false;
  });

  $('#new-setting').on('click', function(event) {
    event.preventDefault();
    $.get(admin.asset_path + 'template-input.php', function(data) {
      $('.settings-form').append(data);
      $('.settings-control').last().transit({
        x: '100%',
        opacity: 0
      }, 0).transit({
        x: 0,
        opacity: 1
      }, 400);
    });
    return false;
  });

  $('#save-setting').on('click', function(event) {
    event.preventDefault();
    updateSettings();
    return false;
  });

  $('.settings-control').on('click', '.prop-check', function() {
    if (this.checked) {
      $('#delete-setting').addClass('active');
    } else {
      // check and see if there are any checked items
      if ($('.settings-control').find('.prop-check').filter(':checked').length === 0) {
        $('#delete-setting').removeClass('active');
      }
    }
  });
}

$(function() {
  if ($('body').hasClass('settings-template')) {
    $('#check-all').on('click', function(event) {
      $('.settings-control').find('.prop-check').prop('checked', $(this).prop('checked'));
      if (this.checked) {
        $('#delete-setting').addClass('active');
      } else {
        $('#delete-setting').removeClass('active');
      }
    });
    buttonFns();
  }
});

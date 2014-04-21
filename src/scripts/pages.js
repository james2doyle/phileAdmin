function newPage() {
  var $list = $('.nested-sortable').find('li');
  var newname = prompt('Enter A New Filename. (Without the extension)', 'foldername/filename');
  if (newname !== null) {
    $.post(admin.url+'new_file', {
      filename: newname,
      id: $list.length + 1
    }).then(function(res) {
      phile.message(res.message);
      $list.last().after(res.list_item);
    },
    function(res) {
      phile.message(res.message);
    });
  }
}

function renamePage() {
  var oldfile = $('.page-controls').attr('data-url');
  var filename = prompt('Enter A New Filename. (Without the extension)', oldfile);
  if (filename !== null) {
    $.post(admin.url+'rename_file', {
      oldname: oldfile,
      newname: filename
    }).then(function(res) {
      phile.message(res.message);
      $('.page-info').find('.page-link').attr('href', res.url).text('/' + filename);
    },
    function(res) {
      phile.message(res.message);
    });
  }
}

function pageControls(active) {
  $('.page-controls').on('click', '.btn', function(event) {
    var target = this.id.split('-')[0];
    var path = $(this).parent().attr('data-url');
    event.preventDefault();
    switch(target) {
      case 'delete':
      if(confirm('Are You Sure You Want To Delete ' + active + '?')) {
        $.post(admin.url+'delete_file', { filename: path }).then(function(res) {
          phile.message(res.message);
          $('.page-info').transit({
            x: '100%',
            opacity: 0
          }, 400, function() {
            $('.nested-sortable li.active').remove();
            $('.nested-sortable li a').first().trigger('click');
          });
        }, function(res) {
          phile.message(res.message);
        });
      }
      break;
      case 'rename':
      renamePage();
    }
    return false;
  });
}

function changePage() {
  var that = this;
  $('.nested-sortable li.active').removeClass('active');
  $('.page-info').transit({
    x: '100%',
    opacity: 0
  }, 200, 'easeInOutQuad', function() {
    $(this).transit({
      x:0,
      y:'100%'
    }, 0);
    $(that).parent().addClass('active');
    $.post('get_page_info', {path: that.dataset.path }, function(res) {
      $('.page-info').html(res).transit({
        y: 0,
        opacity: 1
      }, 300, 'easeInOutQuad');
      pageControls(that.id);
    });
  });
}

function pageFunctions() {
  var activePage = $('.nested-sortable li a')[1].id;
  $('ul.nested-sortable').sortable({
    placeholder: '<li><a href="#" class="placeholder">Move Here</a></li>',
    exclude: '.excluded',
    onDrop: function  (item, targetContainer, s) {
      var clonedItem = $('<li/>').css({height: 0});
      item.before(clonedItem);
      clonedItem.transit({'height': item.height()});
      item.transit(clonedItem.position(), function() {
        clonedItem.detach();
        s(item);
      });
    }
  }).on('click', 'li a', function(event) {
    event.preventDefault();
    if ((this.id === activePage) || (this.id === 'item_root')) {
      return false;
    }
    activePage = this.id;
    changePage.call(this);
    return false;
  });
  $('#new-page').on('click', function(event) {
    event.preventDefault();
    newPage();
    return false;
  });
  pageControls(activePage);
}

$(document).ready(function() {
  if ($('body').hasClass('pages-template')) {
    // changePage.call($('.nested-sortable li a')[0]);
    pageFunctions();
    // load up the first item
    $('.nested-sortable li a').first().trigger('click');
  }
});

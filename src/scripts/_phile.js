window.phile = {
  message: function(string) {
    $('.messages').html(string).addClass('show').transition({
      translate: [0,0],
      duration: 500
    }).transition({
      translate: [0,'-150%'],
      duration: 500,
      delay: 2000
    });
  }
};

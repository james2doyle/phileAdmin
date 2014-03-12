(function() {
  $.fn.extend({
    swappable: function(options) {
      this.defaults = {
        id: 'swappable-temp-input',
        class: 'swappable-input',
        name: 'swappable-temp',
        type: 'input',
        evt: 'click',
        end: 'blur',
        detectTag: true,
        swapStart: function() {},
        swapEnd: function() {}
      };
      var settings = $.extend({}, this.defaults, options);

      function makeTemplate() {
        if (settings.type === 'input') {
          return '<input type="text" class="' + settings.class + '" name="' + settings.name + '" id="' + settings.id + '" value="' + settings.temp + '">';
        } else if (settings.type === 'textarea') {
          return '<textarea class="' + settings.class + '" name="' + settings.name + '" id="' + settings.id + '">' + settings.temp + '</textarea>';
        } else {
          // something is messed. let there be inputs
          return '<input type="text" class="' + settings.class + '" name="' + settings.name + '" id="' + settings.id + '" value="' + settings.temp + '">';
        }
      }

      function handleClick() {
        var $this = $(this);
        settings.swapStart();
        settings.temp = $this.text();
        settings.tag = (typeof(settings.detectTag) !== 'string') ? $this.prop('tagName') : settings.detectTag;
        $this.replaceWith(makeTemplate());
        var $input = $('#' + settings.id);
        // when you focus the new input/textarea
        $input.on(settings.end, function() {
          var $p = $('<' + settings.tag + '>' + settings.temp + '</' + settings.tag + '>');
          $(this).replaceWith($p);
          // call itself with the settings from the first run
          $p.swappable(settings);
          settings.swapEnd();
        }).focus();
      }
      return this.each(function() {
        $(this).on(settings.evt, handleClick);
      });
    }
  });
})();
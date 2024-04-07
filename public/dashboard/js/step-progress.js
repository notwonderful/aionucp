(function ($) {
  $.extend({
    progress: function (opt) {
      var def = {
        step: 3,
        line_w: 300,
      };

      var setting = $.extend({}, def, opt);

      function Progress() {
        this.index_w = setting.line_w / (setting.step - 1);
        this.index = 0;
        this.init();
      }

      Progress.prototype = {
        constructor: Progress,
        init: function () {
          this.render();
          this.changeLength();
        },

        render: function () {
          $(`<div class='wrap'>
					        <div class="line"></div>
					        <p class="step"></p>
					        <button class='next btn btn-danger'>Next</button>
					        <button class='prev btn btn-primary'>Prev</button>
					    </div> `).appendTo(document.body);

          $(".line").css({
            width: setting.line_w,
          });
          for (var i = 1; i <= setting.step; i++) {
            $(`<span class='flag'>${i}</span>`)
              .css({
                left: (i - 1) * this.index_w - 10,
              })
              .appendTo(".wrap");
          }
        },

        changeLength: function () {
          var _this = this;
          $(".next").click(function () {
            $(this).next().prop("disabled", false);
            _this.index += 1;
            if (_this.index >= setting.step - 1) {
              _this.index = setting.step - 1;
              $(this).prop("disabled", true);
            }
            $(this)
              .parent()
              .find(".step")
              .stop()
              .animate(
                {
                  width: _this.index * _this.index_w,
                },
                1000
              );
          });
          $(".prev").click(function () {
            $(this).prev().prop("disabled", false);

            _this.index -= 1;
            if (_this.index <= 0) {
              _this.index = 0;
              $(this).prop("disabled", true);
            }

            $(this)
              .parent()
              .find(".step")
              .stop()
              .animate(
                {
                  width: _this.index * _this.index_w,
                },
                1000
              );
          });
        },
      };
      new Progress();
    },
  });
})(jQuery);

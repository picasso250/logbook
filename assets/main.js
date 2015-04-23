$(function () {
  var alert = $('.alert');
  var postForm = $('form[method="post"][role=form]').on('submit', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $btn = $(this).find('button[type=submit]');
    $.post($this.attr('action'), $this.serialize(), function (ret) {
      if (ret.code === 0) {
        if (ret.data && ret.data.url) {
          location.href = ret.data.url;
          return;
        }
      }
      alert.removeClass('alert-hidden').text(ret.message);
    }, 'json');
  });
});

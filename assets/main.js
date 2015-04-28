$(function () {
  var alert = $('.alert');
  var postForm = $('form[method="post"][role=form]').on('submit', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $btn = $(this).find('button[type=submit]');
    $.post($this.attr('action'), $this.serialize(), function (html) {
      console.log($('#MainList'))
      $('#MainList').prepend(html)
    }, 'html');
  });
});

$(function () {
  var alert = $('.alert');
  var postForm = $('form[method="post"][role=form]').on('submit', function (e) {
    e.preventDefault();
    var $this = $(this);
    var $btn = $(this).find('button[type=submit]');
    $.post($this.attr('action'), $this.serialize(), function (html) {
      console.log($('#MainList'))
      $('#MainList').prepend(html)
      postForm.find('textarea').val('');
    }, 'html');
  });
  $('#LoginBtn').on('click', function () {
    var id = prompt("ur id");
    if (id) {
      window.location.href = '/login?user_id='+id
    };
  })
});

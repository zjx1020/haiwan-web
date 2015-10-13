$(".forgetPassword").click(function() {
  //alert("别点了，这只是逗逗你的");
  $(".forgetPasswordModal").modal();
  $("#email").val("");
  $("#email").removeAttr('style');
  $(".error").html("");
});

$(".forgetPasswordModal .confirm").click(function() {
  var email = $("#email").val();
  if (email == '') {
    $("#email").attr('style', 'border-color:red');
    $("#email").attr('placeholder', '请输入邮箱');
    return;
  } else {
    $("#email").removeAttr('style');
  }
  $.post(BASEURL + 'site/forget-password&email=' + email, function(data) {
    if (data.succ == false) {
      if (data.exist == false) {
        $("#email").attr('style', 'border-color:red');
        $(".error").html("邮箱不存在");
      } else {
        $(".error").html("操作失败，系统异常，请联系管理员！");
      }
    } else {
      alert("账号密码已发送至注册邮箱，请查收！");
      $(".forgetPasswordModal").modal('hide');
    }
  }, 'json');
});

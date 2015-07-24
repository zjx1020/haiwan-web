var id = $(".activityId").html();
$.get(BASEURL + 'activity/check-auth&id=' + id, function(data) {
  $(".cancel").hide();
  $(".finish").hide();
  if (data.canJoin) {
    $(".join").show();
  } else {
    $(".join").hide();
  }
  if (data.hasAuth) {
    $(".cancel").show();
    $(".finish").show();
  }
}, 'json');

$(".join").click(function() {
  $.post(BASEURL + 'activity/join&id=' + id, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      alert(data.msg);
      $.post(BASEURL + 'site/new-activity');
      window.location.href = window.location.href;
    }
  }, 'json');
});

$(".cancel").click(function() {
  $.post(BASEURL + 'activity/cancel&id=' + id, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      alert(data.msg);
      window.location.href = window.location.href;
    }
  }, 'json');
});

$(".finish").click(function() {
  $.post(BASEURL + 'activity/finish&id=' + id, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      alert(data.msg);
      window.location.href = window.location.href;
    }
  }, 'json');
});

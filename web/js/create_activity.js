var time = '';
var name = '';
var cost = '';
var address = '';
var description = '';

$(".create").click(function() {
  var body = document.getElementById("createActivity");
  var has_error = false;
  
  time = $("#activityform-time").val();
  if (time == '') {
    $("#activityform-time").attr('style', 'border-color:red');
    $("#activityform-time").attr('placeholder', '请输入活动时间');
    has_error = true;
  } else {
    $("#activityform-time").removeAttr('style');
  }
  name = $("#activityform-name").val();
  if (name == '') {
    $("#activityform-name").attr('style', 'border-color:red');
    $("#activityform-name").attr('placeholder', '请输入活动主题');
    has_error = true;
  } else {
    $("#activityform-name").removeAttr('style');
  }
  cost = $("#activityform-cost").val();
  if (cost == '') {
    $("#activityform-cost").attr('style', 'border-color:red');
    $("#activityform-cost").attr('placeholder', '请输入活动花费');
    has_error = true;
  } else {
    if (cost < 0) {
      $("#activityform-cost").val('');
      $("#activityform-cost").attr('style', 'border-color:red');
      $("#activityform-cost").attr('placeholder', '活动还有倒贴？');
      has_error = true;
    } else {
      $("#activityform-cost").removeAttr('style');
    }
  }
  address = $("#activityform-address").val();
  if (address == '') {
    $("#activityform-address").attr('style', 'border-color:red');
    has_error = true;
  } else {
    $("#activityform-address").removeAttr('style');
  }
  description = $("#activityform-description").val();
  if (has_error == true) {
    return;
  }
  if (cost == 0) {
    $(".confirmModal").modal();
  } else {
    submit();
  }
});

$(".confirm").click(function() {
  $(".confirmModal").modal('hide');
  submit();
});

function submit() {
  $.post(BASEURL + 'activity/create-activity&time=' + time + '&name=' + name + '&address=' + address + '&cost=' + cost + '&description=' + description, function(data) {
    if (data.succ == false) {
      if (data.exist != null && data.exist == true) {
        $("#activityform-name").val('');
        $("#activityform-name").attr('placeholder', data.msg);
        $("#activityform-name").attr('style', 'border-color:red');
        $("#activityform-time").val('');
        $("#activityform-time").attr('placeholder', data.msg);
        $("#activityform-time").attr('style', 'border-color:red');
      } else {
        alert(data.msg);
      }
    } else {
      window.location.href = BASEURL + 'site/new-activity';
    }
  }, 'json');
}

$(function() {
    $( "#activityform-time" ).datepicker();
    });

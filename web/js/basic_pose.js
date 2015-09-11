$(function() {
  init();
});

function init() {
  $.get(BASEURL + 'rookie/basic-pose', function(data) {
    var table = document.getElementById("basicPoseTable");
    clearTable(table, 0);
    for (var i = 0; i < data.length; ++i) {
      var r = table.insertRow();
      var name = r.insertCell(0);
      name.className = "col-lg-2";
      name.innerHTML = data[i].name;
      var desc = r.insertCell(1);
      desc.className = "col-lg-10";
      desc.innerHTML = data[i].description;
    }
  }, 'json');
}

$(".addPose").click(function() {
  $(".addPoseModal").modal();
  $("#name").removeAttr('style');
  $("#name").attr('placeholder', '请输入名字');
  $("#name").val('');
  $("#description").val('');
  $(".error").html("");
});

$(".addPoseModal .confirm").click(function() {
  var name = $("#name").val();
  if (name == '') {
    $("#name").attr('style', 'border-color:red');
    $("#name").attr('placeholder', '请输入名字');
    return;
  } else {
    $("#name").removeAttr('style');
  }
  var description = $("#description").val();
  
  $.post(BASEURL + 'rookie/add-pose&name=' + name + '&description=' + description, function(data) {
    if (data.succ == false) {
      if (data.exist == true) {
        $("#name").attr('style', 'border-color:red');
        $("#name").val('');
        $("#name").attr('placeholder', '该舞姿已存在');
      } else {
        $(".error").html("操作失败，系统异常，请联系管理员！");
      }
    } else {
      $(".addPoseModal").modal('hide');
      window.location.href = window.location.href; 
    }
  }, 'json');
});

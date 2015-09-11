var changeContent = new Map();

$(function() {
  init();
});

function init() {
  $.get(BASEURL + 'rookie/basic-pose', function(data) {
    var table = document.getElementById("basicPoseTable");
    clearTable(table, 1);
    for (var i = 1; i < data.length; ++i) {
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

$("#modify").click(function() {
  var table = document.getElementById("basicPoseTable");
  for (var i = 1; i < table.rows.length; ++i) {
    var descCell = table.rows[i].cells[1];
    var desc = descCell.innerHTML;
    descCell.innerHTML = '';
    var input = document.createElement("input");
    input.type = "text";
    input.value = desc;
    input.setAttribute('name', table.rows[i].cells[0].innerHTML);
    input.setAttribute('onchange', 'changeDesc(this)');
    input.className = "col-lg-10";
    descCell.appendChild(input);
  }
  if (table.rows.length > 1) {
    var modifyBtn = document.getElementById("modify");
    var saveBtn = document.getElementById("save");
    var cancelBtn = document.getElementById("cancel");
    modifyBtn.disabled = true;
    saveBtn.disabled = false;
    cancelBtn.disabled = false;
  }
});

function changeDesc(input) {
  changeContent.set(input.getAttribute('name'), input.value);
}

$("#save").click(function() {
  var names = '';
  var values = '';
  for (var key of changeContent.keys()) {
    names += key + ',';
    values += changeContent.get(key) + "delim";
  }
  names.substr(0, names.length - 1);
  values.substr(0, values.length - 5);
  $.post(BASEURL + 'rookie/update-pose&names=' + names + '&values=' + values, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      changeContent.clear();
      window.location.href = window.location.href;
    }
  }, 'json');
});

$("#cancel").click(function() {
  changeContent.clear();
  window.location.href = window.location.href;
});

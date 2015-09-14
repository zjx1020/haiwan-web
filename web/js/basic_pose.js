var changeContent = new Map();

$(function() {
  init();
});

function init() {
  $.get(BASEURL + 'rookie/basic-pose', function(data) {
    var table = document.getElementById("basicPoseTable");
    clearTable(table, 0);
    var r;
    for (var i = 0; i < data.length; ++i) {
      if (i % 3 == 0) {
        r = table.insertRow();
      } 

      var caption = document.createElement("div");
      caption.className = "caption";
      var name = document.createElement("h3"); // 舞姿图片标题
      name.innerHTML = data[i].name;
      var desc = document.createElement("p"); // 舞姿图片描述
      desc.className = data[i].name;
      desc.innerHTML = data[i].description;
      caption.appendChild(name);
      caption.appendChild(desc);

      var img = document.createElement("img");
      img.src = "images/" + data[i].name + ".jpg";
      img.alt = data[i].name + " 示例图";

      var div = document.createElement("div");
      div.className = "thumbnail";
      div.appendChild(img);
      div.appendChild(caption);

      var cell = r.insertCell(0);
      cell.setAttribute("pose_name", data[i].name);
      cell.className = "col-lg-4"; 
      cell.appendChild(div);
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
  for (var i = 0; i < table.rows.length; ++i) {
    var row = table.rows[i];
    for (var j = 0; j < row.cells.length; ++j) {
      var descCell = table.rows[i].cells[j];
      var name = descCell.getAttribute("pose_name");
      var p = document.getElementsByClassName(name)[0];
      var parent = p.parentNode;

      var input = document.createElement("input");
      input.type = "text";
      input.value = p.innerHTML;
      input.setAttribute('name', name);
      input.setAttribute('onchange', 'changeDesc(this)');
      input.className = "col-lg-12";
      parent.removeChild(p);
      parent.appendChild(input);
    }
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

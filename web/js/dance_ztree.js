var name = null;
var node = null;
function onClick(event, treeId, treeNode) {
  node = treeNode;
  name = treeNode.name.replace("*", "");
  if (treeNode.isDance != null) {
    $(".danceTitle").text(treeNode.name);
    $(".danceDescription").hide();
    $.get(BASEURL + 'dance/display-dance&name=' + treeNode.name.replace("*", ""), function(data) {
        $.each(data, function(key, val){
          $(".danceTable td." + key).text(val);
          $(".danceTable").show();
        });
        if (data.isGuest || data.isLeader) {
          $(".leadDanceTr").hide();
        } else {
          $(".leadDanceTr").show();
        }
        $.post(BASEURL + 'dance/display-teach-record&name=' + name, function(data) {
          if (data.length == 0) {
            $(".teachRecordsContent").html("暂无");
            $("#teachRecords").hide();
          } else {
            $(".teachRecordsContent").html("");
            table = document.getElementById("teachRecords");
            var length = table.rows.length;
            if (length > 1) {
              for (var i = length - 1; i >= 1; --i) {
                table.deleteRow(i);
              }
            }
            $.each(data, function(index, record) {
              var r = table.insertRow();
              var cell = r.insertCell(0);
              cell.innerHTML = record.time;
              cell = r.insertCell(1);
              cell.innerHTML = record.teacher;
            });
            $("#teachRecords").show();
          }
        }, 'json');
    }, 'json');
  } else {
    if (treeNode.level == 0) {
      $(".danceTitle").text(treeNode.name).text("舞码大全");
      $.get(BASEURL + 'dance/display-all-dance', function(data) {
          $(".danceDescription").html(data.content).show();
      }, 'json');
      $(".danceTable").hide();
      $("#teachRecords").hide();
    } else {
      $(".danceTitle").text(treeNode.name);
      $.get(BASEURL + 'dance/display-country-dance&country=' + treeNode.name, function(data) {
          $(".danceDescription").html(data.content).show();
      }, 'json');
      $(".danceTable").hide();
      $("#teachRecords").hide();
    }
  }
}

$(".leadDanceBtn").click(function() { 
  $.post(BASEURL + 'dance/add-dance-leader&name=' + name, function(data) {
    $("#leadDanceConfirmModal p.content").text(data.msg);
    $("#leadDanceConfirmModal").modal();
  }, 'json');
});

$("#leadDanceConfirmModal .confirm").click(function() {
  $("#leadDanceConfirmModal").modal('hide');
  ztree.selectNode(node);
  ztree.setting.callback.onClick(null, ztree.setting.treeId, node);
});

var setting = {
  data: {
    simpleData: {
      enable: true
    }
  },
  callback: {
    onClick: onClick
  }
};

var zNodes;
var ztree;
$.get(BASEURL + 'dance/generate-dance-tree', function(data) {
  zNodes = data.ztree;
  ztree = $.fn.zTree.init($("#danceTree"), setting, zNodes);
  if (data.hasAuth == false) {
    var leftPage = document.getElementById("leftPage");
    var button = document.getElementById("addDanceBtns");
    leftPage.removeChild(button);
  }
}, 'json');

$.get(BASEURL + 'dance/display-all-dance', function(data) {
  $(".danceDescription").html(data.content).show();
  $(".danceTable").hide();
  $("#teachRecords").hide();
}, 'json');

$(".addDance").click(function() {
  $(".addDanceModal").modal();
  $("#dance-name").removeAttr('style');
  $("#dance-name").attr('placeholder', '请输入舞名');
  $("#dance-name").val('');
  $("#dance-country").val('未知');
  initRadioValue($("#dance-kind input"));
  initRadioValue($("#dance-level input"));
  $("#dance-description").val('');
  $(".error").html("");
  $.get(BASEURL + 'dance/get-all-country', function(data) {
    var countries = data;
    var select = document.getElementById("dance-country");
    select.options.add(new Option("未知", "未知"));
    for (var i = 0; i < countries.length; ++i) {
      if (countries[i].name != '未知') {
        select.options.add(new Option(countries[i].name, countries[i].name));
      }
    }
  }, 'json');
});

function initRadioValue(radios) {
  for (var i = 0; i < radios.length; ++i) {
    if (i == 0) {
      radios[i].checked = true;
    } else {
      if (radios[i].checked == true) {
        radios[i].checked = false;
      }
    }
  }
}

function getRadioValue(radios) {
  var val = 1;
  for (var i = 0; i < radios.length; ++i) {
    if (radios[i].checked == true) {
      val = radios[i].value;
      break;
    }
  }
  return val;
}

$(".addDanceModal .confirm").click(function() {
  var name = $("#dance-name").val();
  if (name == '') {
    $("#dance-name").attr('style', 'border-color:red');
    $("#dance-name").attr('placeholder', '请输入舞名');
    return;
  } else {
    $("#dance-name").removeAttr('style');
  }
  var country = $("#dance-country").val();
  var kind = getRadioValue($("#dance-kind input"));
  var dance_level = getRadioValue($("#dance-level input"));
  var description = $("#dance-description").val();
  $.post(BASEURL + 'dance/add-dance&name=' + name + '&country=' + country + '&kind=' + kind + '&dance_level=' + dance_level + '&description=' + description, function(data) {
    if (data.succ == false) {
      if (data.exist == true) {
        $("#dance-name").attr('style', 'border-color:red');
        $("#dance-name").val('');
        $("#dance-name").attr('placeholder', '该舞已存在');
      } else {
        $(".error").html("操作失败，系统异常，请联系管理员！");
      }
    } else {
      $(".addDanceModal").modal('hide');
      window.location.href = window.location.href;
    }
  }, 'json');
});

$(".addDances").click(function() {
  $(".addDancesModal").modal();
});

$(".addDancesModal .confirm").click(function() {
  var name = $("#newDanceFile").val();
  if ($("#newDanceFile").val() == "") {
    $(".addDancesResultModal p.content").text("请选择文件");
    $(".addDancesResultModal").modal();
    return;
  }
  $("#addDancesForm").attr("action", BASEURL + "dance/upload-file");
  //$(".addNewDanceBtn").click();
  //$(".addDancesModal").modal('hide');
  //window.location.href = window.location.href;
});

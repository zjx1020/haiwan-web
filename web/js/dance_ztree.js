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
  zNodes = data;
  ztree = $.fn.zTree.init($("#danceTree"), setting, zNodes);
}, 'json');

$.get(BASEURL + 'dance/display-all-dance', function(data) {
  $(".danceDescription").html(data.content).show();
  $(".danceTable").hide();
  $("#teachRecords").hide();
}, 'json');

/*
$(".addDance").click(function() {
  $(".addDanceModal").modal();
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
  //$("#addDancesForm").attr("action", BASEURL + "dance/add-dances&name=test.xlsx");
  //$(".addNewDanceBtn").submit();
  //$(".addDancesModal").modal('hide');
  //window.location.href = window.location.href;
});
*/

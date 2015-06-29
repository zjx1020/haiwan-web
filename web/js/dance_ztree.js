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
    }, 'json');
  } else {
    if (treeNode.level == 0) {
      $(".danceTitle").text(treeNode.name).text("舞码大全");
      $.get(BASEURL + 'dance/display-all-dance', function(data) {
          $(".danceDescription").html(data.content).show();
      }, 'json');
      $(".danceTable").hide();
    } else {
      $(".danceTitle").text(treeNode.name);
      $.get(BASEURL + 'dance/display-country-dance&country=' + treeNode.name, function(data) {
          $(".danceDescription").html(data.content).show();
      }, 'json');
      $(".danceTable").hide();
    }
  }
}

$(".leadDanceBtn").click(function() { 
  $.post(BASEURL + 'dance/add-dance-leader&name=' + name, function(data) {
    $("#leadDanceConfirmModal p.leadDanceConfirmModalContent").text(data.msg);
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
}, 'json');

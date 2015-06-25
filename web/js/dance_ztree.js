function onClick(event, treeId, treeNode) {
  if (treeNode.isDance != null) {
  /*
    $(".danceTitle").text(treeNode.name);
    $(".danceDescription").hide();
    $.get(BASEURL + 'dance/display-dance&name=' + treeNode.name, function(data) {
        $.each(data, function(key, val){
          $(".danceTable td." + key).text(val);
          $(".danceTable").show();
        });
    }, 'json');
    */
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
$.get(BASEURL + 'dance/generate-dance-tree', function(data) {
  zNodes = data;
  $.fn.zTree.init($("#danceTree"), setting, zNodes);
}, 'json');

$.get(BASEURL + 'dance/display-all-dance', function(data) {
  $(".danceDescription").html(data.content).show();
}, 'json');

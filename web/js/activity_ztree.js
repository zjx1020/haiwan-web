function onClick(event, treeId, treeNode) {
  if (treeNode.id != null) {
    $(".activityTitle").text(treeNode.name);
    $(".activityDescription").hide();
    $.get(BASEURL + 'activity/display-activity&id=' + treeNode.id, function(data) {
        $.each(data.info, function(key, val){
          $(".activityTable td." + key).text(val);
        });
        $(".activityTable").show();

        if (data.teachDances != null && data.teachDances.length > 0) {
          var table = document.getElementById("teachDanceTable");
          clearTable(table, 0);
          $.each(data.teachDances, function(index, val){
            var r = table.insertRow();
            var cellName = r.insertCell(0);
            cellName.className = "col-lg-4";
            cellName = r.insertCell(1);
            cellName.innerHTML = val.name;
            cellName.className = "col-lg-2";
            cellName = r.insertCell(2);
            cellName.className = "col-lg-1";
            var cellTeacher = r.insertCell(3);
            cellTeacher.innerHTML = val.teacher;
            cellTeacher.className = "col-lg-5";
            });
          $("#teachDanceTable").show();
        } else {
          $("#teachDanceTable").hide();
        }

        if (data.reviewDances != null && data.reviewDances.length > 0) {
          table = document.getElementById("reviewDanceTable");
          clearTable(table, 0);
          var i = 0;
          var r;
          $.each(data.reviewDances, function(index, val){
              if (i == 0) {
              r = table.insertRow();
              }
              var cellName = r.insertCell(i * 2);
              cellName.className = "col-lg-1";
              cellName = r.insertCell(i * 2 + 1);
              cellName.innerHTML = val;
              cellName.className = "col-lg-2";
              i = (i + 1) % 4;
              });
          $("#reviewDanceTable").show();
        } else {
          $("#reviewDanceTable").hide();
        }

        if (data.activityDances != null && data.activityDances.length > 0) {
          table = document.getElementById("activityDanceTable");
          clearTable(table, 0);
          i = 0;
          $.each(data.activityDances, function(index, val){
              if (i == 0) {
              r = table.insertRow();
              }
              var cellName = r.insertCell(i * 2);
              cellName.className = "col-lg-1";
              cellName = r.insertCell(i * 2 + 1);
              cellName.innerHTML = val;
              cellName.className = "col-lg-2";
              i = (i + 1) % 4;
              });
          $("#activityDanceTable").show();
        } else {
          $("#activityDanceTable").hide();
        }
    }, 'json');
  } else {
    if (treeNode.level == 0) {
      $(".activityTitle").text(treeNode.name).text("海湾活动大全");
      $.get(BASEURL + 'activity/display-all-activity', function(data) {
          $(".activityDescription").html(data.content).show();
      }, 'json');
      $(".activityTable").hide();
      $("#teachDanceTable").hide();
      $("#reviewDanceTable").hide();
      $("#activityDanceTable").hide();
    } else {
      $(".activityTitle").text(treeNode.name);
      $.get(BASEURL + 'activity/display-year-activity&year=' + treeNode.name.substr(0, 4), function(data) {
          $(".activityDescription").html(data.content).show();
      }, 'json');
      $(".activityTable").hide();
      $("#teachDanceTable").hide();
      $("#reviewDanceTable").hide();
      $("#activityDanceTable").hide();
    }
  }
}

function clearTable(table, startRow) {
  var length = table.rows.length;
  if (length > startRow) {
    for (var i = length - 1; i >= startRow; --i) {
      table.deleteRow(i);
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
$.get(BASEURL + 'activity/generate-activity-tree', function(data) {
  zNodes = data;
  $.fn.zTree.init($("#activityTree"), setting, zNodes);
}, 'json');

$.get(BASEURL + 'activity/display-all-activity', function(data) {
  $(".activityDescription").html(data.content).show();
  $(".activityTable").hide();
  $("#teachDanceTable").hide();
  $("#reviewDanceTable").hide();
  $("#activityDanceTable").hide();
}, 'json');

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
            cellName.className = "col-lg-3";
            cellName = r.insertCell(1);
            //cellName.innerHTML = val.name;
            var a = document.createElement("a");
            a.href = '#';
            a.className = "dance";
            a.setAttribute("rel", "popover");
            a.setAttribute("data-content", val.desc);
            a.innerHTML = val.name;
            a.style.color = 'red';
            $(".dance").popover({trigger: 'hover'});
            cellName.appendChild(a);
            cellName.className = "col-lg-3";
            var cellTeacher = r.insertCell(2);
            cellTeacher.innerHTML = val.teacher;
            cellTeacher.className = "col-lg-6";
            });
          $("#teachDanceTable").show();
          $(".dance").popover({trigger: 'hover'});
        } else {
          $("#teachDanceTable").hide();
        }

        //if (data.reviewDances != null && data.reviewDances.length > 0) {
        if (data.reviewDances != null) {
          table = document.getElementById("reviewDanceTable");
          clearTable(table, 0);
          var i = 0;
          var r;
          $.each(data.reviewDances, function(key, val){
            if (i == 0) {
              r = table.insertRow();
            }
            var cellName = r.insertCell(i);
            var a = document.createElement("a");
            a.href = '#';
            a.className = "dance";
            a.setAttribute("rel", "popover");
            a.setAttribute("data-content", val);
            a.innerHTML = key;
            a.style.color = 'green';
            $(".dance").popover({trigger: 'hover'});
            cellName.appendChild(a);
            cellName.className = "col-lg-3";
            i = (i + 1) % 4;
          });
          $(".dance").popover({trigger: 'hover'});
          $("#reviewDanceTable").show();
        } else {
          $("#reviewDanceTable").hide();
        }

        //if (data.activityDances != null || data.activityDances.length > 0) {
        if (data.activityDances != null) {
          table = document.getElementById("activityDanceTable");
          clearTable(table, 0);
          i = 0;
          // key is danceName & val is dance descriptioin
          $.each(data.activityDances, function(key, val){
            if (i == 0) {
              r = table.insertRow();
            }
            var cellName = r.insertCell(i);
            var a = document.createElement("a");
            a.href = '#';
            a.className = "dance";
            a.setAttribute("rel", "popover");
            a.setAttribute("data-content", val);
            //a.setAttribute("data-original-title", key);
            a.innerHTML = key;
            $(".dance").popover({trigger: 'hover'});
            cellName.appendChild(a);
            cellName.className = "col-lg-3";
            i = (i + 1) % 4;
          });
          $(".dance").popover({trigger: 'hover'});
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

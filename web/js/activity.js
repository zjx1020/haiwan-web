var id = $(".activityId").html();
var dances = null;
var dancesMap = new Map();
var users = null;
var defaultReviewDanceCount = 10;
var defaultActivityDanceCount = 40;
$.get(BASEURL + 'activity/check-auth&id=' + id, function(data) {
  $(".cancel").hide();
  $(".finish").hide();
  if (data.canJoin) {
    $(".join").show();
  } else {
    $(".join").hide();
  }
  if (data.hasAuth) {
    $(".cancel").show();
    $(".finish").show();
  }
}, 'json');

$(".join").click(function() {
  $.post(BASEURL + 'activity/join&id=' + id, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      alert(data.msg);
      $.post(BASEURL + 'site/new-activity');
      window.location.href = window.location.href;
    }
  }, 'json');
});

$(".cancel").click(function() {
  $.post(BASEURL + 'activity/cancel&id=' + id, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      alert(data.msg);
      window.location.href = window.location.href;
    }
  }, 'json');
});

/*
$(".finish").click(function() {
  $.post(BASEURL + 'activity/finish&id=' + id, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      alert(data.msg);
      window.location.href = window.location.href;
    }
  }, 'json');
});
*/
$(".finish").click(function() {
  if (dances == null || users == null) {
    $.get(BASEURL + 'dance/get-activity-dance-info&reviewCnt=' + defaultReviewDanceCount + '&activityCnt=' + defaultActivityDanceCount, function(data) {
      dances = data.allDances;
      for (var i = 0; i < dances.length; ++i) {
        dancesMap.set(dances[i], i + 1);
      }
      users = data.allUsers;
      if (data.activityDances == null) {
        alert("舞码库太少，无法排舞");
        return;
      }
      displayDance(data.reviewDances, data.activityDances);
    }, 'json');
  } else {
    displayDance();
  }
});

function displayDance(reviewDances, activityDances) {
  var node = document.getElementById("newActivity");
  var child = document.getElementById("activityBtns");
  node.removeChild(child);

  var div = document.createElement("div");
  div.style.textAlign = "center";
  node.appendChild(div);
  node = div;

  var teachDanceTable = document.createElement("table");
  teachDanceTable.createCaption().innerHTML = "教学舞码";
  teachDanceTable.caption.style.textAlign = "center";
  teachDanceTable.className = "col-lg-12";
  var selector = document.createElement("select");
  for (var i = 0; i <= 4; ++i) {
    var option = new Option(i, i);
    selector.options.add(option);
  }
  selector.selectedIndex = 3;
  teachDanceTable.caption.appendChild(selector);
  var danceSelector = document.createElement("select");
  danceSelector.className = "danceSelector";
  //danceSelector.addEventListener('onchange', changeUser(this.selectedIndex));
  danceSelector.options.add(new Option("", 0));
  for (var i = 0; i < dances.length; ++i) {
    danceSelector.options.add(new Option(dances[i], i + 1));
  }
  var userSelector = document.createElement("select");
  userSelector.className = "userSelector";
  //userSelector.addEventListener('onchange', test());
  userSelector.setAttribute('onchange', 'test(this.selectedIndex)');
  userSelector.options.add(new Option("", 0));
  for (var i = 0; i < users.length; ++i) {
    userSelector.options.add(new Option(users[i], i + 1));
  }

  for (var i = 0; i < 3; ++i) {
    var r = teachDanceTable.insertRow();
    var cell = r.insertCell();
    cell.className = "col-lg-2";
    cell = r.insertCell();
    cell.className = "col-lg-4";
    cell.innerHTML = danceSelector.outerHTML;
    cell = r.insertCell();
    cell.className = "col-lg-1";
    cell.innerHTML = "教舞者：";
    cell = r.insertCell();
    cell.className = "col-lg-2";
    cell.innerHTML = userSelector.outerHTML + userSelector.outerHTML;
    cell = r.insertCell();
    cell.className = "col-lg-3";
  }
  node.appendChild(teachDanceTable);


  var reviewDanceTable = document.createElement("table");
  reviewDanceTable.createCaption().innerHTML = "复习舞码";
  reviewDanceTable.caption.style.textAlign="center";
  reviewDanceTable.className = "col-lg-12";
  selector = document.createElement("select");
  for(var i = 0; i <= 10; ++i) {
    var option = new Option(i, i);
    selector.options.add(option);
  }
  selector.selectedIndex = defaultReviewDanceCount;
  reviewDanceTable.caption.appendChild(selector);
  var col = 4;
  var row = null;
  for (var i = 0; i < selector.selectedIndex; ++i) {
    if (col == 4) {
      row = reviewDanceTable.insertRow();
      col = 0;
    }
    var cell = row.insertCell();
    cell.innerHTML = danceSelector.outerHTML;
    col += 1;
  }
  for (var i = 0; i < reviewDances.length; ++i) {
    var rowNum = Math.floor(i / 4);
    var colNum = i % 4;
    reviewDanceTable.rows[rowNum].cells[colNum].childNodes[0].selectedIndex = dancesMap.get(reviewDances[i]);
  }
  node.appendChild(reviewDanceTable);

  var activityDanceTable = document.createElement("table");
  activityDanceTable.createCaption().innerHTML = "联欢舞码";
  activityDanceTable.caption.style.textAlign = "center";
  activityDanceTable.className = "col-lg-12";
  selector = document.createElement("select");
  for(var i = 0; i <= 200; ++i) {
    var option = new Option(i, i);
    selector.options.add(option);
  }
  selector.selectedIndex = defaultActivityDanceCount;
  activityDanceTable.caption.appendChild(selector);
  col = 4;
  row = null;
  for (var i = 0; i < selector.selectedIndex; ++i) {
    if (col == 4) {
      row = activityDanceTable.insertRow();
      col = 0;
    }
    var cell = row.insertCell();
    cell.innerHTML = danceSelector.outerHTML;
    col += 1;
  }
  for (var i = 0; i < activityDances.length; ++i) {
    var rowNum = Math.floor(i / 4);
    var colNum = i % 4;
    activityDanceTable.rows[rowNum].cells[colNum].childNodes[0].selectedIndex = dancesMap.get(activityDances[i]);
  }
  node.appendChild(activityDanceTable);

  var button = document.createElement("button");
  button.className = "btn btn-primary publish";
  button.innerHTML = "发布";
  node.appendChild(button);
}

/*
$(".userSelector").change(function() {
  alert("test");
});
*/
function test(index) {
  alert(index);
}

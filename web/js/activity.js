var id = $(".activityId").html();
var dances = null;
var dancesMap = new Map();
var selectedDancesMap = new Map();
var users = null;
var defaultTeachDanceCount = 3;
var defaultReviewDanceCount = 10;
var defaultActivityDanceCount = 40;
var teachDanceCount = 3;
var reviewDanceCount = 10;
var activityDanceCount = 40;
var danceSelector = null;
var oldIndex = 0;
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
      for (var i = 0; i < data.reviewDances.length; ++i) {
        selectedDancesMap.set(data.reviewDances[i], 1);
      }
      for (var i = 0; i < data.activityDances.length; ++i) {
        selectedDancesMap.set(data.activityDances[i], 0);
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

  // 创建div，包含；教学舞码表、复习舞码表、联欢舞码表和发布按钮
  var div = document.createElement("div");
  div.id = "activityDanceInfo";
  div.style.textAlign = "center";
  node.appendChild(div);
  node = div;

  if (danceSelector == null) {
    danceSelector = document.createElement("select");
    danceSelector.className = "danceSelector";
    //danceSelector.addEventListener('onchange', changeUser(this.selectedIndex));
    danceSelector.setAttribute('onchange', 'changeDance(this)');
    danceSelector.setAttribute('onclick', 'clickDanceSelector(this.selectedIndex)');
    danceSelector.options.add(new Option("", 0));
    for (var i = 0; i < dances.length; ++i) {
      danceSelector.options.add(new Option(dances[i], i + 1));
    }
    danceSelector.selectedIndex = 0;
  }

  // 创建教学舞码表
  node.appendChild(createTeachDanceTable(danceSelector, 4, "teachDanceSelector"));

  // 创建复习舞码表
  node.appendChild(createReviewDanceTable(danceSelector, 10, "reviewDanceSelector", reviewDances));

  // 创建联欢舞码表
  node.appendChild(createActivityDanceTable(danceSelector, 200, "activityDanceSelector", activityDances)); 

  var button = document.createElement("button");
  button.className = "btn btn-primary publish";
  button.innerHTML = "发布";
  button.setAttribute('onclick', 'publish()');
  node.appendChild(button);
}

function createDanceTable(id, danceSelector, title, defaultDanceCnt, maxDanceCnt, cntSelectorName) {
  var table = document.createElement("table");
  table.id = id;
  table.createCaption().innerHTML = title;
  table.caption.style.textAlign = "center";
  table.className = "col-lg-12";
  var selector = document.createElement("select");
  for (var i = 0; i <= maxDanceCnt; ++i) {
    var option = new Option(i, i);
    selector.options.add(option);
  }
  selector.className = cntSelectorName;
  selector.setAttribute('onchange', 'changeDanceCount(this, danceSelector)');
  selector.selectedIndex = defaultDanceCnt;
  table.caption.appendChild(selector);

  return table;
}

function createTeachDanceTable(danceSelector, maxDanceCnt, cntSelectorName) {
  var table = createDanceTable("teachDanceTable", danceSelector, "教学舞码", defaultTeachDanceCount, maxDanceCnt, cntSelectorName); 
  
  addTeachDance(table, danceSelector, defaultTeachDanceCount); 

  return table;
}

function createReviewDanceTable(danceSelector, maxDanceCnt, cntSelectorName, dances) {
  var table = createDanceTable("reviewDanceTable", danceSelector, "复习舞码", defaultReviewDanceCount, maxDanceCnt, cntSelectorName); 
  
  addDance(table, danceSelector, defaultReviewDanceCount, dances);

  return table;
}

function createActivityDanceTable(danceSelector, maxDanceCnt, cntSelectorName, dances) {
  var table = createDanceTable("activityDanceTable", danceSelector, "联欢舞码", defaultActivityDanceCount, maxDanceCnt, cntSelectorName); 
  
  addDance(table, danceSelector, defaultActivityDanceCount, dances);

  return table;
}

// 格式：col-lg-2空白、col-lg-4舞蹈、col-lg-1教舞者标志、col-lg-2两个教舞者填写栏、col-lg-3空白
function addTeachDance(table, danceSelector, count) {
  var userSelector = document.createElement("select");
  userSelector.className = "userSelector";
  //userSelector.addEventListener('onchange', test());
  userSelector.setAttribute('onchange', 'changeUser(this)');
  userSelector.options.add(new Option("", 0));
  for (var i = 0; i < users.length; ++i) {
    userSelector.options.add(new Option(users[i], i + 1));
  }
  userSelector.selectedIndex = 0;

  for (var i = 0; i < count; ++i) {
    var r = table.insertRow();
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
}

// 格式：col-lg-2空白、col-lg-4舞蹈、col-lg-1教舞者标志、col-lg-2两个教舞者填写栏、col-lg-3空白
function deleteTeachDance(table, count) {
  var length = table.rows.length;
  for (var i = length - 1; length - i <= count; --i) {
    var index = table.rows[i].cells[1].firstChild.selectedIndex;
    if (index > 0) {
      selectedDancesMap.delete(dances[index - 1]);
    }
    table.deleteRow(i);
  }
}

// 格式：每行4首舞
function addDance(table, danceSelector, count, dances) {
  var col = 0;
  var row = null;
  var len = table.rows.length;
  if (len != 0) {
    var lastRowLen = table.rows[len - 1].cells.length;
    if (lastRowLen != 4) {
      col = lastRowLen;
      row = table.rows[len - 1];
    }
  }
  for (var i = 0; i < count; ++i) {
    if (row == null || col == 4) {
      row = table.insertRow();
      col = 0;
    }
    var cell = row.insertCell();
    cell.innerHTML = danceSelector.outerHTML;
    col += 1;
  }
  // 修改默认舞码条数后不再自动产出舞码
  if (dances != null) {
    for (var i = 0; i < dances.length; ++i) {
      var rowNum = Math.floor(i / 4);
      var colNum = i % 4;
      table.rows[rowNum].cells[colNum].childNodes[0].selectedIndex = dancesMap.get(dances[i]);
    }
  }
}

// 格式：每行4首舞
function deleteDance(table, count) {
  var length = table.rows.length;
  for (var i = length - 1; i >=0; --i) {
    if (count == 0) {
      break;
    }
    var cellLen = table.rows[i].cells.length;
    var j = cellLen - 1;
    for (; j >=0; --j) {
      if (count == 0) {
        break;
      }
      var index = table.rows[i].cells[j].firstChild.selectedIndex;
      if (index > 0) {
        selectedDancesMap.delete(dances[index - 1]);
      }
      table.rows[i].deleteCell(j);
      --count;
    }
    if (j < 0) {
      table.deleteRow(i);
    }
  }
}

function changeUser(select) {
  var user = users[select.selectedIndex - 1];
  var sibling = select.previousSibling == null ? select.nextSibling : select.previousSibling;
  if (select.selectedIndex == sibling.selectedIndex) {
    select.selectedIndex = 0;
    alert("\"" + user + "\"不能分身！");
  }
}

function clickDanceSelector(index) {
  oldIndex = index;
}

function changeDance(select) {
  var index = select.selectedIndex;
  if (index > 0) {
    var dance = dances[index - 1];
    if (selectedDancesMap.has(dance)) {
      select.selectedIndex = 0;
      alert("\"" + dance + "\"重复了");
    } else {
      var kind = 0;
      if (select.parentNode.parentNode.parentNode.parentNode.id == "teachDanceTable") {
        kind = 2;
      } else if (select.parentNode.parentNode.parentNode.parentNode.id == "reviewDanceTable") {
        kind = 1;
      }
      if (oldIndex != 0) {
        selectedDancesMap.delete(dances[oldIndex - 1]);
      }
      selectedDancesMap.set(dance, kind);
    }
  }
}

function changeDanceCount(select, danceSelector) {
  var table = select.parentNode.parentNode;

  if (select.className == "teachDanceSelector") {
    if (select.selectedIndex > teachDanceCount) {
      addTeachDance(table, danceSelector, select.selectedIndex - teachDanceCount);
    } else {
      deleteTeachDance(table, teachDanceCount - select.selectedIndex);
    }
    teachDanceCount = select.selectedIndex;
  } else if (select.className == "reviewDanceSelector") {
    if (select.selectedIndex > reviewDanceCount) {
      addDance(table, danceSelector, select.selectedIndex - reviewDanceCount, null);
    } else {
      deleteDance(table, reviewDanceCount - select.selectedIndex);
    }
    reviewDanceCount = select.selectedIndex;
  } else {
    if (select.selectedIndex > activityDanceCount) {
      addDance(table, danceSelector, select.selectedIndex - activityDanceCount, null);
    } else {
      deleteDance(table, activityDanceCount - select.selectedIndex);
    }
    activityDanceCount = select.selectedIndex;
  }
}

function publish() {
  // 1、检查是否有舞码未设置；2、检查教舞者数量是否和舞蹈类型匹配
  var div = document.getElementById("activityDanceInfo");
  var selects = div.getElementsByTagName("select");
  for (var i in selects) {
    var select = selects[i];
    if (select.className == 'danceSelector') {
      if (select.selectedIndex == 0) {
        alert("有舞码尚未设置");
        return;
      }
    }
  }
  for (var i in selects) {
    var select = selects[i];
    if (select.className == 'userSelector') {
      var row = select.parentNode.parentNode;
      var dance = null;
      for (var j in row.cells) {
        var cell = row.cells[j];
        if (cell.firstChild != null && cell.firstChild.className == "danceSelector") {
          dance = dances[cell.firstChild.selectedIndex - 1];
          break;
        }
      }
      if (dance.substr(dance.length - 1) == '*') {
        if (select.selectedIndex == 0) {
          alert("\"" + dance + "\"教舞者未设置");
          return;
        }
      } else {
        if (select.nextSibling == null) {
          if (select.selectedIndex != 0) {
            alert("\"" + dance + "\"是单人舞，不需要2号教舞者");
            return;
          }
        } else {
          if (select.selectedIndex == 0) {
            alert("\"" + dance + "\"教舞者未设置");
            return;
          }
        }
      }
    }
  }

  // 更新活动信息到服务器
  if (selectedDancesMap.size != (teachDanceCount + reviewDanceCount + activityDanceCount)) {
    alert("设定的舞码数和实际舞码数不相符，请联系管理员检查！");
    return;
  }
  if (activityDanceCount < 20) {
    alert("联欢舞码少于20条，请多加点舞码！");
    return;
  }
  var table = document.getElementById("teachDanceTable");
  var teachDances = '';
  for (var i = 0; i < table.rows.length; ++i) {
    var teachDance = '';
    if (table.rows[i].cells.length == 5) {
      if (i != 0) {
        teachDances += ';';
      }
      teachDance = dances[table.rows[i].cells[1].firstChild.selectedIndex - 1] + ':';
      for (var j = 0; j < table.rows[i].cells[3].childNodes.length; ++j) {
        var userIndex = table.rows[i].cells[3].childNodes[j].selectedIndex;
        if (userIndex == 0) {
          break;
        } else {
          if (j != 0) {
            teachDance += ',';
          }
          teachDance += users[userIndex - 1];
        }
      }
      teachDances += teachDance;
    }
  }
  table = document.getElementById("reviewDanceTable");
  var reviewDances = '';
  for (var i = 0; i < table.rows.length; ++i) {
    for (var j = 0; j < table.rows[i].cells.length; ++j) {
      reviewDances += dances[table.rows[i].cells[j].firstChild.selectedIndex - 1] + ',';
    }
  }
  reviewDances = reviewDances.substr(0, reviewDances.length - 1);

  table = document.getElementById("activityDanceTable");
  var activityDances = '';
  for (var i = 0; i < table.rows.length; ++i) {
    for (var j = 0; j < table.rows[i].cells.length; ++j) {
      activityDances += dances[table.rows[i].cells[j].firstChild.selectedIndex - 1] + ',';
    }
  }
  activityDances = activityDances.substr(0, activityDances.length - 1);

  $.post(BASEURL + 'activity/finish&id=' + id + '&teachDances=' + teachDances + '&reviewDances=' + reviewDances + '&activityDances=' + activityDances, function(data) {
    if (data.succ == false) {
      alert(data.msg);
    } else {
      alert(data.msg);
      window.location.href = window.location.href;
    }
  }, 'json');
}

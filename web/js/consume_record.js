var pageSize = 10;
var posSize = 5;
$.get(BASEURL + 'site/get-consume-record&offset=0&limit=' + pageSize, function(data) {
  update(data);
}, 'json');
function update(data) {
  var body = document.getElementById("consumeRecord");
  var consumeTable = document.getElementById("consumeRecordTable");
  var activityTable = document.getElementById("activityRecordTable");
  var recordPage = document.getElementById("recordPage");
  if (data.account == 'haiwan') {
    if (body.hasChildNodes(activityTable)) {
      body.removeChild(activityTable);
    }
    if (data.record.length > 0) {
      for (var i = 0; i < data.record.length; ++i) {
        var record = data.record[i];
        consumeTable.rows[i + 1].cells[0].innerHTML = record.time;
        consumeTable.rows[i + 1].cells[1].innerHTML = record.owner;
        consumeTable.rows[i + 1].cells[2].innerHTML = record.money;
        consumeTable.rows[i + 1].cells[3].innerHTML = record.description;
      }
      if (recordPage == null && data.recordCnt > pageSize) {
        consumeTable.insertAdjacentElement('afterEnd', generatePage(data.recordCnt, "recordPage"));
      } 
    }
  } else {
    if (body.hasChildNodes(consumeTable)) {
      body.removeChild(consumeTable);
    }
    if (data.record.length > 0) {
      for (var i = 0; i < data.record.length; ++i) {
        var record = data.record[i];
        activityTable.rows[i + 1].cells[0].innerHTML = record.time;
        activityTable.rows[i + 1].cells[1].innerHTML = record.title;
        activityTable.rows[i + 1].cells[2].innerHTML = record.count;
      }
      if (recordPage == null && data.recordCnt > pageSize) {
        activityTable.insertAdjacentElement('afterEnd', generatePage(data.recordCnt, "recordPage"));
      }
    }
  }
}

function generatePage(count, id) {
  var page = Math.ceil(count / pageSize);
  var nav = document.createElement('nav');
  nav.id = id;
  nav.style.textAlign = 'right';

  var ul = document.createElement('ul');
  ul.className = 'pagination'; 
  ul.setAttribute("count", page);

  // create prev
  var li = document.createElement("li");
  var a = document.createElement("a");
  a.innerHTML = '<<';
  a.href = '#';
  a.setAttribute('onclick', 'clickPage(this);return false;');
  li.className = "prev disabled";
  li.appendChild(a);
  li.setAttribute("position", 0);
  ul.appendChild(li);
  var num = page > posSize ? posSize : page;
  for (var i = 0; i < num; ++i) {
    var li = document.createElement("li");
    var a = document.createElement("a");
    a.innerHTML = i + 1;
    a.href = '#';
    a.setAttribute('onclick', 'clickPage(this);return false;');
    if (i == 0) {
      li.className = "active";
    }
    li.appendChild(a);
    li.setAttribute("position", i + 1);
    ul.appendChild(li);
  }
  // create next
  li = document.createElement("li");
  a = document.createElement("a");
  a.innerHTML = '>>';
  a.href = '#';
  a.setAttribute('onclick', 'clickPage(this);return false;');
  li.className = "next";
  li.appendChild(a);
  li.setAttribute("position", -1);
  ul.appendChild(li);

  nav.appendChild(ul); 

  return nav;
}

function clickPage(page) {
  for (var i = 0; i < page.parentNode.classList.length; ++i) {
    if (page.parentNode.classList[i] == "disabled") {
      return;
    }
  }

  var baseUrl = BASEURL + 'site/get-consume-record&offset=';
  var endUrl = '&limit=' + pageSize;

  var ul = page.parentNode.parentNode;
  var prev = ul.firstChild;
  var next = ul.lastChild;
  var selectedPage = page.parentNode;
  var oldPage = prev.nextSibling;
  for (var i in ul.childNodes) {
    var li = ul.childNodes[i];
    if (li.className == "active") {
      oldPage = li;
      break;
    }
  } 

  if (page.parentNode == prev) {
    for (var i in ul.childNodes) {
      var li = ul.childNodes[i];
      if (li.nextSibling == oldPage) {
        selectedPage = li;
        break;
      }
    }
  } else if (page.parentNode == next) {
    selectedPage = oldPage.nextSibling;
  }
  oldPage.removeAttribute("class");

  var max = ul.getAttribute("count");
  if (max > 5) {
    var min = 1;
    var midPos = 3;
    var selectedPos = selectedPage.getAttribute("position");
    var selectedNum = selectedPage.firstChild.innerHTML; 
    
    if (selectedNum - oldPage.firstChild.innerHTML < 0) { //前移
      var leftPage = selectedPage.firstChild.innerHTML - 1;
      var leftPos = selectedPage.getAttribute("position") - 1;
      if (leftPage > leftPos) {
        var move = leftPage - leftPos > midPos - 1 ? midPos - 1 : leftPage -leftPos;
        if (posSize - selectedPos > move) {
          var minPage = Number(selectedNum) - move;
          for (var i = 1; i < ul.childNodes.length - 1; ++i) {
            var li = ul.childNodes[i];
            li.firstChild.innerHTML = minPage++;
            if (li.firstChild.innerHTML == selectedNum) {
              selectedPage = li;
            }
          }
        }
      }
    } else if (selectedNum - oldPage.firstChild.innerHTML > 0) { //后移
      if (posSize - selectedPage.getAttribute("position") < max - selectedNum) {
        var move = max - selectedNum > posSize - midPos ? posSize - midPos : max - selectedNum;
        if (selectedPos - 1 > move)  {
          var maxPage = Number(selectedNum) + move;
          for (var i = ul.childNodes.length - 2; i >=1; --i) {
            var li = ul.childNodes[i];
            li.firstChild.innerHTML = maxPage--;
            if (li.firstChild.innerHTML == selectedNum) {
              selectedPage = li;
            }
          }
        }
      }
    }
  }

  selectedPage.className = "active";

  if (selectedPage.firstChild.innerHTML == min) {
    prev.className = "prev disabled";
  } else {
    prev.className = "prev";
  }
  if (selectedPage.firstChild.innerHTML == max) {
    next.className = "next disabled";
  } else {
    next.className = "next";
  }

  var offset = (selectedPage.firstChild.innerHTML - 1) * 10;
  $.get(baseUrl + offset + endUrl, function(data) {
    update(data);
  }, 'json');
}

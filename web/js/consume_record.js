var pageSize = 10;
var posSize = 5;
var users = null;
$.get(BASEURL + 'site/get-consume-record&offset=0&limit=' + pageSize, function(data) {
  update(data);
}, 'json');
function update(data) {
  var body = document.getElementById("consumeRecord");
  var consumeTable = document.getElementById("consumeRecordTable");
  var activityTable = document.getElementById("activityRecordTable");
  var recordPage = document.getElementById("recordPage");
  if (data.account == 'haiwan') {
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

function changePayerKind(radio) {
  var isVip = radio.value;
  var payer = document.getElementById("payer");
  var div = payer.parentNode;
  div.removeChild(payer);
  if (isVip == 1) {
    var select = document.createElement("select");
    select.id = "payer";
    select.className = "form-control";
    select.setAttribute('onclick', 'changePayerKind(this)');
    initSelect(select, users);
    div.appendChild(select);
  } else {
    var input = document.createElement("input");
    input.id = "payer";
    input.className = "form-control";
    input.maxLength = 32;
    input.type = "text";
    input.placeholder = "请输入付款方，不能与网站会员重名";
    div.appendChild(input);
  }
}

$(".addConsumeRecord").click(function() {
  $(".consumeRecordModal").modal();
  $(".error").html("");
  var payer = document.getElementById("payer");
  if (users == null) {
    $.get(BASEURL + 'site/get-user-info', function(data) {
      users = data;
      initSelect(payer, users);
    }, 'json');
  } else {
    initSelect(payer, users);
  }
});

function initSelect(select, values) {
  select.options.add(new Option("", 0));
  for (var i = 0; i < values.length; ++i) {
    select.options.add(new Option(values[i], i + 1));
  }
  select.selectedIndex = 0;
}

$(".consumeRecordModal .confirm").click(function() {
  var payer = $("#payer").val();
  var money = $("#money").val();
  var description = $("#description").val();
  var isVip = getRadioValue($("#payer-kind input"));

  if (payer == '') {
    $("#payer").attr('style', 'border-color:red');
    $("#payer").attr('placeholder', '请输入付款方，不能与网站会员重名');
    return;
  } else if (payer == 0) {
    $(".error").html("请选择付款会员");
    return;
  } else {
    if (isVip != 1) {
      $("#payer").removeAttr('style');
    } else {
      $(".error").html("");
      payer = users[payer - 1];
    }
  }
  if (money == '') {
    $("#money").attr('style', 'border-color:red');
    $("#money").attr('placeholder', '请输入大于0的金额');
    return;
  } else {
    if (isNaN(money)) {
      $("#money").attr('style', 'border-color:red');
      $(".error").html('请输入整数');
      return;
    } else {
      $("#money").removeAttr('style');
    }
  }
  if (description == '') {
    $("#description").attr('style', 'border-color:red');
    $("#description").attr('placeholder', '请输入本次交易描述');
    return;
  } else {
    $("#description").removeAttr('style');
  }

  $.post(BASEURL + 'site/add-consume-record&payer=' + payer + '&money=' + money + '&description=' + description + '&isVip=' + isVip, function(data) {
    if (data.succ == false) {
      if (data.nameExist) {
        $("#payer").attr('style', 'border-color:red');
        $(".error").html('付款方不能与网站会员重名');
      } else {
        $(".error").html("操作失败，系统异常，请联系管理员！");
      }
    } else {
      $(".consumeRecordModal").modal('hide');
      window.location.href = window.location.href; 
    }
  }, 'json');
});

$(".addPayConsumeRecord").click(function() {
  $(".payConsumeRecordModal").modal();
  $(".pay-error").html("");
});

$(".payConsumeRecordModal .confirm").click(function() {
  var owner = $("#owner").val();
  var money = $("#pay-money").val();
  var description = $("#pay-description").val();
  if (owner == '') {
    $("#owner").attr('style', 'border-color:red');
    $("#owner").attr('placeholder', '请输入收款方，不能与网站会员重名');
    return;
  } else {
    $("#owner").removeAttr('style');
  }
  if (money == '') {
    $("#pay-money").attr('style', 'border-color:red');
    $("#pay-money").attr('placeholder', '请输入大于0的金额');
    return;
  } else {
    if (isNaN(money)) {
      $("#pay-money").attr('style', 'border-color:red');
      $(".pay-error").html('请输入整数');
    } else {
      $("#pay-money").removeAttr('style');
    }
  }
  if (description == '') {
    $("#pay-description").attr('style', 'border-color:red');
    $("#pay-description").attr('placeholder', '请输入本次交易描述');
    return;
  } else {
    $("#pay-description").removeAttr('style');
  }

  $.post(BASEURL + 'site/add-pay-consume-record&owner=' + owner + '&money=' + money + '&description=' + description, function(data) {
    if (data.succ == false) {
      if (data.nameExist) {
        $("#owner").attr('style', 'border-color:red');
        $(".pay-error").html('收款方不能与网站会员重名');
      } else {
        $(".pay-error").html("操作失败，系统异常，请联系管理员！");
      }
    } else {
      $(".payConsumeRecordModal").modal('hide');
      window.location.href = window.location.href; 
    }
  }, 'json');
});

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

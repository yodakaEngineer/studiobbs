window.addEventListener("DOMContentLoaded", function(){
  const year = document.getElementById('js-year'),
  month = document.getElementById('js-month'),
  tbody = document.getElementById('js-calendar-body'),
  calendarTable = document.getElementById("js-calendar-table"),
  today = new Date(),
  xhr = new XMLHttpRequest();
  const dataTemplate = [
    "deleteTime",
    "deleteName",
    "deleteComment",
    "deleteContact"
  ];
  let currentYear = today.getFullYear(),
  currentMonth = today.getMonth(),
  touchStartX,
  touchStartY,
  touchMoveX,
  touchMoveY,
  thead = document.createElement("thead"),
  tr = document.createElement("tr"),
  th = document.createElement("th");

  const calendarHeading = function (y, m){
    year.textContent = y;
    month.textContent = m + 1;
  }

  const calendarBody = function (year, month, today){
    const todayYMFlag = today.getFullYear() === year && today.getMonth() === month ? true : false, // 本日の年と月が表示されるカレンダーと同じか判定
    startDate = new Date(year, month, 1), // その月の最初の日の情報
    endDate  = new Date(year, month + 1 ,0), // その月の最後の日の情報
    startDay = startDate.getDay(),// その月の最初の日の曜日を取得
    endDay = endDate.getDate();// その月の最後の日の曜日を取得
    let textDate = 1, // 日付(これがカウントアップされます)
    textSkip = true, // 日にちを埋める用のフラグ
    tableBody ='', // テーブルのHTMLを格納する変数
    textTd = '',
    td = '';
    for (let row = 0; row < 6; row++){
      let tr = '<tr>';
      for (let col = 0; col < 7; col++) {
        const addClass = todayYMFlag && textDate === today.getDate() ? 'is-today' : '';
        if (row === 0 && startDay === col){
          textSkip = false;
        }
        if (textDate > endDay) {
          textSkip = true;
        }
        textTd = textSkip ? '' : textDate++;
        td = '<td class="'+addClass+' day">'+textTd+'</td>';
        tr += td;
      }
      tr += '</tr>';
      tableBody += tr;
    }
    tbody.innerHTML = tableBody;
  }

  const confirmHead = document.getElementById("js-confirmHead"),
  reserveDay = document.getElementsByClassName("day"),
  confirmTable = document.getElementById("js-confirmTable"),
  reserveFormHead = document.getElementById("js-reserveFormHead"),
  reserveForm = document.getElementById('reserveForm');
  let jsDelete,
  dateStr;

  const callback = function (){
    jsDelete.forEach(function(x){
      x.addEventListener('click',function (){
        let deleteData = x.children,
        dataArray = [];
        deleteData = Array.from(deleteData);
        var i = 0;
        deleteData.forEach(function(value){
          var input = document.createElement('input');
          input.setAttribute("type","hidden");
          input.setAttribute("name",dataTemplate[i]);
          input.setAttribute("value",value.innerHTML);
          reserveForm.appendChild(input);
          i++;
        });
      });
    });
  };

  function clickFunc(callback) {
    for (let i = 0; i < reserveDay.length; i++) {
      if(reserveDay[i].innerHTML != ""){
        reserveDay[i].onclick = function () {
          const y = year.innerHTML,
          m = month.innerHTML,
          day = this.innerHTML;
          dateStr = y + '-' + m + '-' + day;
          let time = "",
          name = "",
          comment = "",
          contact = "";
          thead = "<thead><tr><th>時間</th><th>名前</th><th>コメント</th><th>連絡先</th></tr></thead>";
          confirmTable.innerHTML = thead;
          date ='date=' + dateStr;
          const input = document.createElement('input');
          input.setAttribute("type","hidden");
          input.setAttribute("value",dateStr);
          input.setAttribute("id","js-date");
          input.setAttribute("name","date");
          reserveForm.appendChild(input);
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 304)) { // 通信の完了時
              json = JSON.parse(xhr.responseText);
              for (var i = 0; i < json.length; i++) {
                time = json[i].time;
                name = json[i].name;
                comment = json[i].comment;
                contact = json[i].contact;
                confirmTable.innerHTML += "<tbody><tr class='js-delete'><td>"+time+"</td><td>"+name+"</td><td>"+comment+"</td><td>"+contact+"</td></tr></tbody>";
                if (confirmTable.innerHTML) {
                  jsDelete = document.getElementsByClassName('js-delete');
                  callback();
                }
              }
            }
          }
          reserveFormHead.innerHTML = currentMonth+1 + "月" + this.innerHTML + "日予約フォーム";
          confirmHead.innerHTML = currentMonth+1 + "月" + this.innerHTML + "日予約状況";
          xhr.open('POST', '../php/Ajax.php', true);
          xhr.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
          xhr.send(date);
        }
      }
    }
  };

  returnMonth = document.getElementById("js-returnMonth");
  returnMonth.addEventListener("click", function(){
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear ++;
    } else {
      currentMonth ++;
    }
    calendarHeading(currentYear, currentMonth);
    calendarBody(currentYear, currentMonth, today);
    clickFunc(callback);
  });

  skipMonth = document.getElementById("js-skipMonth");
  skipMonth.addEventListener("click", function(){
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear --;
    } else {
      currentMonth --;
    }
    calendarHeading(currentYear, currentMonth);
    calendarBody(currentYear, currentMonth, today);
    clickFunc(callback);
  });


  calendarHeading(currentYear, currentMonth);
  calendarBody(currentYear, currentMonth, today);
  clickFunc(callback);
  // スワイプ処理

  // 開始時
  calendarTable.addEventListener("touchstart", function(event) {
    // 座標の取得
    touchStartX = event.touches[0].pageX;
    touchStartY = event.touches[0].pageY;
  }, false);

  // 移動時
  calendarTable.addEventListener("touchmove", function(event) {
    event.preventDefault();
    // 座標の取得
    touchMoveX = event.changedTouches[0].pageX;
    touchMoveY = event.changedTouches[0].pageY;
  }, false);

  // 終了時
  calendarTable.addEventListener("touchend", function(event) {
    // 移動量の判定
    if(touchMoveX){
      if (touchStartX > touchMoveX && touchStartX > (touchMoveX + 120)) {
        //右から左に指が移動した場合
        if (currentMonth === 11) {
          currentMonth = 0;
          currentYear ++;
        } else {
          currentMonth ++;
        }
      } else if (touchStartX < touchMoveX && (touchStartX + 120) < touchMoveX) {
        //左から右に指が移動した場合
        if (currentMonth === 0) {
          currentMonth = 11;
          currentYear --;
        } else {
          currentMonth --;
        }
      }
      calendarHeading(currentYear, currentMonth);
      calendarBody(currentYear, currentMonth, today);
      clickFunc();
      touchMoveX = null;
    }
  }, false);
});

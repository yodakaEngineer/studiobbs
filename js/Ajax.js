submit = document.getElementById("submit");
time = document.getElementById("time");
name = document.getElementById("name");
comment = document.getElementById("comment");
contact = document.getElementById("contact");
const values = {
  submit:submit.val,
  date:date,
  time:time.val,
  name:name.val,
  comment:comment.val,
  contact:contact.val
};

submit.onclick = function () {
  const req = new XMLHttpRequest();
  req.open('POST', 'Ajax.php', true);
  req.setRequestHeader('content-type','application/x-www-form-urlencoded;charset=UTF-8');
  req.send(values);
  req.onreadystatechange = function() {
    if (req.readyState == 4) { // 通信の完了時
      if (req.status == 200) { // 通信の成功時
        console.log(req.statusText);
      }else{
        console.log(req.statusText);
      }
    }else{
      console.log(req.statusText);
    }
  }
  return false;
}

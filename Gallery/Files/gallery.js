function    createDate() {
    let mydate = new Date();
    return mydate.getFullYear().toString().substr(-2) + '-' + ("0" +  (mydate.getMonth() + 1).toString()).slice(-2) + '-' + ("0" + mydate.getDate().toString()).slice(-2) + ' ' + ("0" + mydate.getHours().toString()).slice(-2) + ':' + ("0" + mydate.getMinutes().toString()).slice(-2);
}

function    comment(name, userId, postId, owner, token) {
    //AJAX
    let xtp = new XMLHttpRequest();
    let text = document.getElementById('comment' + postId).value;
    if (text.trim(' ').length == 0)
        return ;
    xtp.onreadystatechange = function () {
        if (xtp.readyState == 4) {
            //document.getElementById('error').innerHTML = xtp.responseText;
        }
    }
    xtp.open('POST', '/comment', true);
    let data = 'user_id=' + userId + '&post_id=' + postId + '&ownerId=' + owner + '&text=' + text + '&token=' + token;
    xtp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xtp.send(data);

    //DOM
    document.getElementById('comment' + postId).value = '';
    let newNode = document.createElement('div');
    newNode.className = 'comment';
    let info = document.createElement('div');
    info.className = 'info';
    let uname = document.createElement('p');
    uname.innerHTML = name;
    uname.className = "commenterName";
    let date = document.createElement('p');
    date.innerHTML = createDate();
    date.className = "commenterDate";
    info.appendChild(uname);
    info.appendChild(date);
    let content = document.createElement('div');
    content.className = 'text';
    content.innerHTML = text;
    newNode.appendChild(info);
    newNode.appendChild(content);
    document.getElementById('post' + postId).appendChild(newNode);
}

function    like(userId, postId, token) {
    let xtp = new XMLHttpRequest();
    xtp.onreadystatechange = function () {
        if (xtp.readyState == 4) {
            //document.getElementById('error').innerHTML = xtp.responseText;
        }
    }
    xtp.open('POST', '/like', true);
    let data = 'user_id=' + userId + '&post_id=' + postId + '&token=' + token;
    xtp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xtp.send(data);
    if (document.getElementById('like' + postId).value == 0) {
        let likes = parseInt(document.getElementById('likes' + postId).innerHTML);
        document.getElementById('likes' + postId).innerHTML = (likes + 1).toString();
        document.getElementById('like' + postId).value = 1;
    }
    else {
        let likes = parseInt(document.getElementById('likes' + postId).innerHTML);
        document.getElementById('likes' + postId).innerHTML = (likes - 1).toString();
        document.getElementById('like' + postId).value = 0;
    }
}
function handleOuterImage(img) {
    //Validating the file
    var file = img;
    var validFileExtensions = /(.png)$/;
    if (file.type !== "file" || (img.files[0] && !validFileExtensions.exec(file.value))) {
        window.location.href = "/cam";
        return ;
    }
    console.log(document.getElementById('vid').tagName);


    //AJAX
    if (img.files[0]) {
            let reader = new FileReader();
        
        if (document.getElementById('vid').tagName === "VIDEO") {
            document.getElementById('vid').id = "out";
            document.getElementById("out").hidden = true;
            document.getElementById("blah").id = "vid";
            document.getElementById("vid").hidden = false;
        }
        let imgtagscreen = document.getElementById("vid");

        reader.onloadend = function(e) {
            let imgtag = new Image();
            imgtag.onload = function() {
                document.getElementById('canvas').getContext('2d').drawImage(imgtag, 0, 0, 500, 500);
            }
            imgtag.src = e.target.result;
            imgtagscreen.src = e.target.result;
        }
        reader.readAsDataURL(img.files[0]);
    }
}

async function init() {
    const stream = await navigator.mediaDevices.getUserMedia({
        audio: false,
        video: {
            width: 500,
            height: 500
        }
    });
    window.stream = stream;
    document.getElementById('vid').srcObject = stream;
}

function    capture() {
    if (!document.getElementById("filter").src)
        return ;
    document.getElementById('canvas').getContext('2d').drawImage(document.getElementById('vid'), 0, 0, 500, 500);

    //AJAX
    let xtp = new XMLHttpRequest();
    xtp.onreadystatechange = function () {
        if (xtp.readyState == 4) {
            //alert(document.getElementById('error').innerHTML = xtp.responseText);
            window.location.href = "/cam";
        }
    }
    xtp.open('POST', '/capture', true);
    let data = 'data=' + encodeURIComponent(document.getElementById('canvas').toDataURL()) + '&filter=' + document.getElementById("filter").src;
    xtp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xtp.send(data);

    
}

function    changeImg(name) {
    //Change filter
    document.getElementById("filter").src = '/Gallery/Filters/' + name + '.png';

    //DOM Manipulation
    document.getElementById("capture").disabled = false;
    document.getElementById("fill21").style.borderColor = "#183152";
    document.getElementById("fill10").style.borderColor = "#183152";
    document.getElementById("fill30").style.borderColor = "#183152";
    document.getElementById("fill"+name).style.borderColor = "green";
    document.getElementById("capture").className = 'butt';
    document.getElementById("filter").hidden = true;
}

document.getElementById("capture").disabled = true;

init();

function    deletePost(postId) {
    let xtp = new XMLHttpRequest();
    xtp.onreadystatechange = function () {
        if (xtp.readyState == 4) {
            //document.getElementById('error').innerHTML = xtp.responseText;
        }
    }
    xtp.open('POST', '/deletePost', true);
    let data = 'post_id=' + postId;
    xtp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xtp.send(data);
    let old = document.getElementById("post" + postId);
    old.parentNode.removeChild(old);
}

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
function Validate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        //getting each input
        var oInput = arrInputs[i];
        //checking the input type
        if (oInput.type == "file") {

            var sFileName = oInput.value;
            if (sFileName.length > 0) {

                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                    return false;
                }
            }
        }
    }
  
    return true;
}
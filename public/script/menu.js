var ajax = new XMLHttpRequest();
ajax.open("GET", "/script/menu.html", false);
ajax.send();
document.body.innerHTML += ajax.responseText;
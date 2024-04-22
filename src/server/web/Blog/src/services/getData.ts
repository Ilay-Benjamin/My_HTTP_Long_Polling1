var running = false;
var name1 = "";
var msg = "";

function post() {
    var serverUrl = 'http://172.20.10.2:8010/app.php?name=&message=' + msg;
    fetch(serverUrl)
        .then(response => response.json())
        .then(res => {
            msg = "";
            if (!res.data) {
                console.log("No data");
                return;
            }
            document.getElementById('output')!.innerHTML = "<h2>Messages</h2>";
            console.table(res.data);
            var data : any = res.data as {messages: [{name: string, message: string, id: number}], counter: number};
            for (var i = 0; i < data.messages.length; i++) {
                var message = data.messages[i];
                document.getElementById('output')!.innerHTML += '<p>(' + message.id + ") " + message.name + ': ' + message.message + '</p>';
            }
    });
}

function get() {
    var serverUrl = 'http://172.20.10.2:8010/app.php?name=' + name1;
    fetch(serverUrl)
        .then(response => response.json())
        .then(res => {
            if (!res.data) {
                console.log("No data");
                return;
            }
            document.getElementById('output')!.innerHTML = "<h2>Messages</h2>";
            console.table(res.data);
            var data : any = res.data as {messages: [{name: string, message: string, id: number}], counter: number};
            for (var i = 0; i < data.messages.length; i++) {
                var message = data.messages[i];
                document.getElementById('output')!.innerHTML += '<p>(' + message.id + ") " + message.name + ': ' + message.message + '</p>';
            }
    });
}

function loop() {
    if (!running) {
        return;
    }
    if (msg != "") {
        post();
        msg = "";
    } else {
        get();
    }
    setTimeout(loop, 5000);
}

document.getElementById('post_btn')!.addEventListener('click', () => {
    msg = (document.getElementById('message_input') as HTMLInputElement).value;
    loop();
});

document.getElementById('get_btn')!.addEventListener('click', () => {
    running = true;
    name1 = (document.getElementById('name_input') as HTMLInputElement).value;
    loop();
});

document.getElementById('stop_btn')!.addEventListener('click', () => {
    running = false;
}   );
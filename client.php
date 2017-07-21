<!DOCTYPE html>
<html>
<head>
    <title>Title of the document</title>
</head>

<body>
<script>
    //http://localhost/websocket/client.php?user_id=2&room_id=22&message=%27hihi%27
    var user_id = <?php echo $_GET['user_id'];?> ;
    var room_id = <?php echo $_GET['room_id'];?> ;
    var message = <?php echo $_GET['message'];?> ;

//var ws = new WebSocket('ws://192.168.1.17:7703');
//var ws = new WebSocket('ws://websocket.com:7703');
    var ws = new WebSocket('ws://websocket.com:7703');
        ws.onopen = function(){
        //login
        var api = {
            "api":"login",
            "parms":{
            "user_id":user_id,
            'room_id':room_id,
        }
    }

//发送消息
//        var api = {
//            "api":"message",
//            "parms":{
//                "user_id":user_id,
//                'room_id':room_id,
//                "message":message
//            }
//        }
    ws.send(JSON.stringify(api));
    };
    ws.onmessage = function(evt){
        console.log(evt.data);
    };
    ws.onclose = function(evt){
        console.log('WebSocketClosed!');
    };
    ws.onerror = function(evt){
        console.log('WebSocketError!');
    };

    function login() {
        var api = {
            "api":"login",
            "parms":{
            "user_id":user_id,
            'room_id':room_id,
            }
        }
        
        //发送消息
        //        var api = {
        //            "api":"message",
        //            "parms":{
        //                "user_id":user_id,
        //                'room_id':room_id,
        //                "message":message
        //            }
        //        }
        ws.send(JSON.stringify(api));
    }
    function setMessage(m) {
        message = m;
    }
    function send() {
        var api = {
            'api':'message',
            'parms':{
                'user_id':user_id,
                'room_id':room_id,
                'message':message
            }
        }
        ws.send(JSON.stringify(api));
    }

</script>
</body>

</html>


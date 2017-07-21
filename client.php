<!DOCTYPE html>
<html>
<head>
    <title>Title of the document</title>
</head>

<body>
<script>
    var user_id = <?php echo $_GET['user_id'];?> ;
    var room_id = <?php echo $_GET['room_id'];?> ;
    var message = <?php echo $_GET['message'];?> ;

//var ws = new WebSocket('ws://192.168.1.17:7703');
//var ws = new WebSocket('ws://118.178.233.217:7703');
    var ws = new WebSocket('ws://121.196.237.158:7703');
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


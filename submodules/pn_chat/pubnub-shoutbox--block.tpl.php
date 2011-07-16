    <link href=http://fonts.googleapis.com/css?family=Nunito|Amaranth|Ubuntu rel=stylesheet type=text/css>
	<link href="<?php echo base_path().drupal_get_path('module', 'pubnub_communicator');?>/pubnub_style.css" rel="stylesheet" type="text/css" />
    <meta http-equiv=Content-Type content=text/html;charset=utf-8>
    <meta name=viewport content=width=320,height=480,user-scalable=0>
    <meta name=apple-mobile-web-app-capable content=yes>
<div id="pubnub_chat">
<?php if($username){?>
<div id=chat-bar>
    <input id=chat-textbox placeholder='Chat Here' />
    <button id=chat-send>chat</button>
</div>
<?php }?>
<div id=chat-display><div></div></div>

<div id=list></div>
</div>

<div pub-key="<?php print $publish_key; ?>" sub-key="<?php print $subscribe_key; ?>" ssl="off" origin="pubsub.pubnub.com" id="pubnub"></div>
<script src="http://cdn.pubnub.com/pubnub-3.1.min.js"></script>
<script>(function(){
    // =======================================================================
    // STREAM FRAMEWORK CODE
    // =======================================================================
    var p = PUBNUB
    , chat_display = p.$('chat-display')
    , chat_send = p.$('chat-send')
    , chat_textbox = p.$('chat-textbox')
    , last_received = 0
    , now = function(){return+new Date}
    , safe_rx = /[<>]/g
    , domain = ('pnub' || '//www.pubnub.com').split('/')[2]
    , channel_ns = (location.href.match(/CHAT-ROOM=([\w\-]+)/)||[''])
                        .slice(-1)[0]||''
    , channel = '' + domain + channel_ns
    , stream_id = (location.href.match(/stream-id=([\w\-]+)/)||[''])
                        .slice(-1)[0];
    // =======================================================================
    // CHAT RECIEVED
    // =======================================================================
    function new_chat(message) {
        var chat_line = p.create('div');

        p.attr( chat_line, 'class', 'chat-item' );
        p.css( chat_line, { backgroundColor : '#d1edf7' } )

        if (!message.link)
            chat_line.innerHTML =
                message.description.replace( safe_rx, '' );
        else
            chat_line.innerHTML = [
                "<a target='x",
                now(),
                "' href='",
                (message.link||'#').replace( safe_rx, '' ),
                "'>",
                message.description.replace( safe_rx, '' ),
                "</a>"
            ].join('');

        chat_display.insertBefore( chat_line, chat_display.firstChild );

        setTimeout( function() {
            p.css( chat_line, { backgroundColor : '#f2f2f2' } )
            p.css( chat_line, { backgroundColor : 'rgba(240,240,240,0.7)' } )
        }, 1000 );
    }

    // =======================================================================
    // LISTEN FOR NEW CHATS
    // =======================================================================
    p.subscribe({
        channel : channel,
        callback : new_chat
    });

    // =======================================================================
    // SEND CHAT
    // =======================================================================
    function send_chat(text) {
        p.publish({
            channel : channel,
            message : { description : '<?php print $username;?>: '+text.replace( safe_rx, '' ) }
        });
    }

    // =======================================================================
    // HISTORY
    // =======================================================================
    p.history({
        limit : 10,
        channel : channel,
        callback : function(messages) {
            p.each( messages, new_chat );

            // Initial Message
            0&& new_chat({
                link : 'http://www.pubnub.com/streams',
                description : 'You are using PubNub Streams.'
            });
        }
    });

    // =======================================================================
    // BIND UI CHAT
    // =======================================================================
    function ui_chat_bind(e) {
        var text = chat_textbox.value;

        if ((e.keyCode || e.charCode || 13) !== 13) return 1;
        if (!text) return 1;

        send_chat(text);
        chat_textbox.value = '';

        return 1;
    }

    p.bind( 'mousedown,touchstart', chat_send, ui_chat_bind );
    p.bind( 'keydown', chat_textbox, ui_chat_bind );

})();</script>
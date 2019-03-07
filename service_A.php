<?php
require_once __DIR__ . '/vendor/autoload.php'; 
require_once 'conn.php';
require_once 'DBcon.php';
use PhpAmqpLib\Message\AMQPMessage;
/*$message = {
    "amount": 1123.4,
    "currency": "EUR",
};*/


function send ($messageBody, $channel, $connection) {
    $exchange = 'router';
    $queue = 'msgs';
    
    $channel->queue_declare($queue, false, true, false, false);

    $channel->exchange_declare($exchange, 'direct', false, true, false);
    $channel->queue_bind($queue, $exchange);
    
    $messageBody->amount = ((float) $messageBody->amount)*100;
    
    $message = new AMQPMessage(json_encode($messageBody), [
        'content_type' => 'application/json', 
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
    ]);
    $channel->basic_publish($message, $exchange);
}
    function receve(){
        include('DBcon.php');
        echo('Current balance is: '.$info.'</br>');
        echo('Balance was last updated at: '.$last);
    }



if ($_POST){
    $message = json_decode($_POST['message']);
    if($message == NULL) {
        header("Status: 400 Bad request");
    } else {
        if (isset($message->amount) && isset($message->currency)){
            $amount = (float) $message->amount;
            $currency = $message->currency;
            if($amount>-100000000 && $amount < 100000000 && $currency == 'EUR' && $amount != ' '){
                send($message, $channel, $connection);
                $channel->close();
                $connection->close();
                header("Status: 200 OK");
                echo "sent";
            }else{
                echo "The given amount is not correct";
            }
        } else {
            header("Status: 400 Bad request");
        }
        
    }
    
} else {
    receve();
}


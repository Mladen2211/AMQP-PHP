<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'conn.php';
require_once 'DBcon.php';
$exchange = 'router';
$queue = 'msgs';

$channel->queue_declare($queue, false, true, false, false);



$channel->exchange_declare($exchange, 'direct', false, true, false);
$channel->queue_bind($queue, $exchange);



function process_message($message){
    $messagebody = json_decode($message->body, true);
    
    $amount = (float)$messagebody['amount'];

    


    try {
        include ('DBcon.php');
        $amount = $amount + $info;
        $sql = "UPDATE services SET 
            balance='$amount', 
            updatedAt='$info'";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "New record created successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;
    $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    
}


$channel->basic_consume($queue, $consumerTag, false, false, false, false, 'process_message');

function shutdown($channel, $connection)
{
    $channel->close();
    $connection->close();
}
register_shutdown_function('shutdown', $channel, $connection);
// Loop as long as the channel has callbacks registered
while (count($channel->callbacks)) {
    $channel->wait();
} 
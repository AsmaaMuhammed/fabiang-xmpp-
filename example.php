<?php

require 'vendor/autoload.php';
error_reporting(-1);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Client;

use Fabiang\Xmpp\Protocol\Roster;
use Fabiang\Xmpp\Protocol\Presence;
use Fabiang\Xmpp\Protocol\Message;

$logger = new Logger('xmpp');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));

$hostname       = '127.0.0.1';
$port           = 5222;
$connectionType = 'tcp';
$address        = "$connectionType://$hostname:$port";

$username = 'php@example.com';
$password = '123';

$options = new Options($address);//('tcp://127.0.0.1:5222');
//$options->setContextOptions(['ssl' => ['peer_name'=> 'example.com', 'allow_self_signed' => true, 'verify_peer' => false,'verify_peer_name' => false]]);
echo '1';

$options->setLogger($logger)
    ->setUsername($username)
    ->setPassword($password);
echo '2';

$client = new Client($options);
echo '3';

$client->connect();
echo 'jjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjConnected';

$client->send(new Roster);
echo '5';

$client->send(new Presence);
echo '6';

// send a message to another user
$message = new Message;
$message->setMessage('test')
    ->setTo('asmaa_user@example.com');
$client->send($message);
echo 'Sended';

// // join a channel
// $channel = new Presence;
// $channel->setTo('channelname@conference.myjabber.com')
//     ->setPassword('channelpassword')
//     ->setNickName('mynick');
// $client->send($channel);

// // send a message to the above channel
// $message = new Message;
// $message->setMessage('test')
//     ->setTo('channelname@conference.myjabber.com')
//     ->setType(Message::TYPE_GROUPCHAT);
// $client->send($message);

$client->disconnect();
echo 'Disconnected';

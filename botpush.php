<?php
require "vendor/autoload.php";
//require "connect.php";
$access_token = 'WYP4r1z6EV0PZ3TrjD6cg90PJ86ri7f5/Wpuj4KQMRvcLnE+RTjgwKoDGwHHwm/F3MLueTPcfSt9JpgZtekQP87g/zaKxic9TaNp9yK3ab3MgBKHYwJ3MmdDg/4BjTmsnptYkM5tuhljAqZY9pq/fQdB04t89/1O/w1cDnyilFU=';

$channelSecret = '82fdafeaf4d24ddf26c1e52026be9586';

$pushID = 'U92e74f8ce3595165ba396dbef155629a';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
//$q = "SELECT * FROM student";
//$result = mysqli_query($con,$q);
//$m = mysqli_fetch_assoc($result);
function queryDB($queryString)
{
    $db = require 'connect.php';
    //$db->query("SET NAMES'UTF8'");
    $result = $db->query($queryString);
    $text = '';
    $arr = [];
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $obj = (object)[];
            foreach ($row as $key => $attribute) {
                $obj->$key = $attribute;
            }
            $arr[] = $obj;
        }
        $text = json_encode($arr);
    }
    $db->close();
    return $text;
}

$data = queryDB("SELECT * FROM student");
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($data);
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();


?>





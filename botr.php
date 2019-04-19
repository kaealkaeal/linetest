<?php
require("../con-db.php");
   $accessToken = "9s7wpqo8THjXYR5A0ToQtANCMKD3jqr2ii8FOA1Wlojj1KnVSNF+c76PZRaGjNQlUETdpltlz77xEEvg/T3pKaWmaDG7SYDoh7wcnlsyRwlWbrKGA2sSpreJxcJE7SrhJaFotOJlXb86S41i/mEiFAdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //รับข้อความจากผู้ใช้
   $message = $arrayJson['events'][0]['message']['text'];
   //รับ id ของผู้ใช้
   $id = $arrayJson['events'][0]['source']['userId'];
   #ตัวอย่าง Message Type "Text + Sticker"
   
  $sqlimg = "SELECT * FROM tmp WHERE Stu_lineid = '$id'";
   $resultimg =mysqli_query($conndb,$sqlimg);
   $getimg = mysqli_fetch_assoc($resultimg);
   if($message == $getimg["encodemes"]){
   $arrayPostData['to'] = $id;
   $arrayPostData['messages'][0]['type'] = "image";
   $arrayPostData['messages'][0]['originalContentUrl'] = $getimg["Img"];
   $arrayPostData['messages'][0]['previewImageUrl'] = $getimg["Img"];
   pushMsg($arrayHeader,$arrayPostData);
}else
 if($message == "hi"){
   $arrayPostData['to'] = $id;
   $arrayPostData['messages'][0]['type'] = "text";
   $arrayPostData['messages'][0]['text'] = "สวัlดี";
   pushMsg($arrayHeader,$arrayPostData);
}


   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close ($ch);
      print_r($result);
   }
   exit;
?>

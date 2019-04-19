<?php
require "con-db.php";
   $accessToken = "fBuzxRAyzplYqZ/LmfI01/U58Y7+dfSXoGSMpaM8dhRHGsf8AP3i0QRvXn4Z/hTx3MLueTPcfSt9JpgZtekQP87g/zaKxic9TaNp9yK3ab2g04YnKz2CRGAuEiQGEtCf187swcPZ9Ee5EECgE2WydVGUYhWQfeY8sLGRXgo3xvw=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
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
   
   if($message == "ลงทะเบียน"){
      $arrayPostData['to'] = $id;
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "โปรดระบุรหัสนักศึกษา";
      pushMsg($arrayHeader,$arrayPostData);
   }else if($message != null){
      $qmessage = "SELECT * FROM student WHERE Student_id = '$message'";
      $result1 = mysqli_query($conndb,$qmessage);
      $getm = mysqli_fetch_assoc($result1);
      if($message == $getm["Student_id"]){
      $sql = "UPDATE student SET Stu_lineid = '".$id."' WHERE Student_id = '".$message."'";
         if ($con->query($sql) === TRUE) {
            //echo "New record created successfully";
           $arrayPostData['to'] = $id;
           $arrayPostData['messages'][0]['type'] = "text";
           $arrayPostData['messages'][0]['text'] = "เพิ่มข้อมูลสำเร็จ";
           pushMsg($arrayHeader,$arrayPostData);
   }
 }
} 
if($message == $id){
   $sqlimg = "SELECT * FROM tmp WHERE Stu_lineid = '$message'";
   $resultimg =mysqli_query($conndb,$sqlimg);
   $getimg = mysqli_fetch_assoc($resultimg);
   $arrayPostData['to'] = $id;
   $arrayPostData['messages'][0]['type'] = "image";
   $arrayPostData['messages'][0]['originalContentUrl'] = $getimg["Img"];
   $arrayPostData['messages'][0]['previewImageUrl'] = $getimg["Img"];
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

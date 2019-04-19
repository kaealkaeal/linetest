<?php
error_reporting(~E_NOTICE);
require __DIR__ . DIRECTORY_SEPARATOR . "phpqrcode" . DIRECTORY_SEPARATOR . "qrlib.php";
date_default_timezone_set('Asia/Bangkok');
$result = $_REQUEST["scanresult"];
$id = $_REQUEST["userid"];
$date=date("H.i.s");
$info = $id.$result;

function encode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
       for ($i = 0; $i < $strLen; $i++) {
            $ordStr = ord(substr($string,$i,1));
               if ($j == $keyLen) { $j = 0; }
                    $ordKey = ord(substr($key,$j,1));
                      $j++;
                    $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
         }
 return $hash;

}
function decode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

/*function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return base64_encode($encrypted_string);
}*/
//$enc = encrypt($info,$date);
$enc = encode($info,$date);
$data=  array("mes"=> $enc);
//echo decode($enc,$date);
require("../con-db.php");
if($id != null){
$sql2 = "SELECT * FROM student WHERE Stu_lineid = '$id'";
$result_id = mysqli_query($conndb,$sql2);					
    $infoqr = mysqli_fetch_assoc($result_id);
    $qr = $date.$infoqr["Student_id"];

$JPG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR; //กำหนด Path Temp

                        $JPG_WEB_DIR = 'img/'; //กำหนด Path รูป Qr Code

                        $filename = "";
                        $errorCorrectionLevel = 'H';
                        //$base64_encode = base64_encode($qrinfo);
                        $matrixPointSize = 20; //ขนาด QR Code
                        $filename = $JPG_TEMP_DIR.$date.'.jpg'; //ไฟล์
                        $filename2 = $date.'.jpg';
                        QRcode::jpg($qr,$filename, $errorCorrectionLevel, $matrixPointSize, 2);
$qrurl = "https://rproxy.cp.su.ac.th:8445/classapp/bot/img/".$filename2;
$sql3 = "SELECT * FROM tmp WHERE Stu_lineid = '$id'";
$result_tmp = mysqli_query($conndb,$sql3);
$infotmp = mysqli_fetch_assoc($result_tmp);
if($infotmp["Stu_lineid"] == null){
$sql = "INSERT INTO tmp (Stu_lineid, Img, encodemes) VALUES ('$id','$qrurl','$enc')";
                        $query = mysqli_query($conndb,$sql);
                        
                        //echo $enc;
                            header( "refresh: 0; url=line://oaMessage/@koy8790g/?$enc");
 exit(0);
}else {
    $sql4 = "UPDATE tmp SET Img = '$qrurl', encodemes = '$enc' WHERE Stu_lineid = '$id'";
    $query = mysqli_query($conndb,$sql4);
   
    //echo $enc;
   header( "refresh: 0; url=line://oaMessage/@koy8790g/?$enc");
 exit(0);
}

}
?>

<?php
$access_token = 'oNByAtnrEnKPkI8dWuth+UWtBMVwTVB4QHkSsE7tRJgkxR0CxjCAS8EIeoBAdx9U3MLueTPcfSt9JpgZtekQP87g/zaKxic9TaNp9yK3ab0q4JqZ0W9pfwGEuWARX+Kwkx3jHA4Z/XnmEqX8T0GOelGUYhWQfeY8sLGRXgo3xvw=';


$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>
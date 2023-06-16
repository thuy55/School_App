<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://partner.hanet.ai/place/getPlaces',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjUwOTY3Nzg1MTE2NDg4NjU2NTciLCJlbWFpbCI6ImluZm9AZWNsby52biIsImNsaWVudF9pZCI6IjBkNDZhODNmMTU4YWI1YTY5MGVkZTdlOWY0NDczMzQ2IiwidHlwZSI6ImF1dGhvcml6YXRpb25fY29kZSIsImlhdCI6MTY2NjMyNjgyMywiZXhwIjoxNjk3ODYyODIzfQ.9aI78bxTPX9jK61EV-bZGLGNx1AYduaeuNDDdKmhAng',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
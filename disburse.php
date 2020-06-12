<?php
$url = 'https://nextar.flip.id/disburse';
$data = array('bank_code' => 'bni', 'account_number' => '1234567890', 'amount' => '10000', 'remark' => 'sample remark');
$username = "HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41";
$password = "";
// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n".
		"Authorization: Basic " . base64_encode("$username:$password"),
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE)

//var_dump($result);


include 'koneksi.php';

$obj = json_decode($result);

$id = $obj->{'id'};
$amount = $obj->{'amount'};
$status = $obj->{'status'};
$timestamp = $obj->{'timestamp'};
$bank_code = $obj->{'bank_code'};
$account_number = $obj->{'account_number'};
$beneficiary_name = $obj->{'beneficiary_name'};
$remark = $obj->{'remark'};
$receipt = $obj->{'receipt'};
$time_served = $obj->{'time_served'};
$fee = $obj->{'fee'};

mysqli_query($koneksi,"insert into T_Disbursement values('$id','$amount','$status','$timestamp','$bank_code','$account_number','$beneficiary_name','$remark','$receipt','$time_served','$fee')");




?>



<?php

include 'koneksi.php';
$data = mysqli_query($koneksi,"select id from T_Disbursement Limit 1");
while($row = mysqli_fetch_array($data)){
	$id = $row['id'];
}

$url = 'https://nextar.flip.id/disburse/$id';
$username = "HyzioY7LP6ZoO7nTYKbG8O4ISkyWnX1JvAEVAhtWKZumooCzqp41";
$password = "";
$options = array(
    'http' => array(
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n".
		"Authorization: Basic " . base64_encode("$username:$password"),
        'method'  => 'GET'//,
        //'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }
//var_dump($result);

$obj = json_decode($result);
$status = $obj->{'status'};
$receipt = $obj->{'receipt'};
$time_served = $obj->{'time_served'};

mysqli_query($koneksi,"update T_Disbursement set status = '$status', receipt = '$receipt', time_served = '$time_served' where id='$id'");

?>

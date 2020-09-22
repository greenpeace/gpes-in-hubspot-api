<?php

function httpGet($email) {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,'https://api.hubapi.com/contacts/v1/contact/email/'. $email . '/profile?hapikey='. HUBSPOTAPIKEY);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$output=curl_exec($ch);
	curl_close($ch);
	$record = json_decode($output, TRUE);
    return $record;
}

?>

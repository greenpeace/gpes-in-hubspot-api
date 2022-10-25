<?php

function httpGet($email) {
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,'https://api.hubapi.com/crm/v3/objects/contacts/'. $email . '?idProperty=email&properties=lifecyclestage&properties=phone&properties=mobilephone&properties=otp_out_hbs&properties=salesforcecampaignids');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'authorization: Bearer ' . HUBSPOT_PRIVATE_APP_KEY,
	));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$output=curl_exec($ch);
	curl_close($ch);
	$record = json_decode($output, TRUE);
    return $record;
}

?>

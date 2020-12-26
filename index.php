<?php

require('includes/config.php');
require('includes/display_errors.php');
require('includes/functions.php');

// Inputs

$email = addslashes( filter_var( $_GET["email"], FILTER_SANITIZE_STRING, FILTER_SANITIZE_EMAIL ) );

$record = httpGet($email);

// Parsing certain arrays

$list_memberships = array();

if (isset($record['list-memberships'])) {
    foreach ( $record['list-memberships'] as $list) {
        array_push( $list_memberships, $list['static-list-id'] );
    }
}

if( isset( $record['properties']['salesforcecampaignids']['value'] ) ){
    $salesforce_campaign_ids = explode(";", $record['properties']['salesforcecampaignids']['value']);
} else {
    $salesforce_campaign_ids = array();
}

// Preparing response

$response = array();

if (isset( $record['is-contact'] )) {
    $response['is_contact'] = $record['is-contact'] ? true : false;
} else {
    $response['is_contact'] = false;
}

if ( $response['is_contact'] === true) {
    $response['lifecycle'] = $record['properties']['lifecyclestage']['value'];
    $response['has_phone'] = isset($record['properties']['phone']['value']) ? true : false;
    $response['has_mobile_phone'] = isset($record['properties']['mobilephone']['value']) ? true : false;
    $response['opt_out'] = (isset($record['properties']['otp_out_hbs']) && $record['properties']['otp_out_hbs']['value'] === "true") ? true : false;
    $response['list_memberships'] = $list_memberships;
    $response['salesforce_campaignids'] = $salesforce_campaign_ids;
}

$response = json_encode( $response );

// Headers & output

header('Content-Type: application/json');
$header_origin = isset($_SERVER['HTTP_ORIGIN']) ? filter_var($_SERVER['HTTP_ORIGIN'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH) : '';

if ( in_array( $header_origin, $cross_origin_domains) ) {
    header('Access-Control-Allow-Origin: ' . $header_origin);
} else {
    header('Access-Control-Allow-Origin: ' . 'https://es.greenpeace.org');
}

echo ( $response );

?>

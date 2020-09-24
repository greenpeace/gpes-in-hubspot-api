<?php

require('includes/config.php');
require('includes/display_errors.php');
require('includes/functions.php');

// Inputs

$email = addslashes( filter_var( $_GET["email"], FILTER_SANITIZE_STRING, FILTER_SANITIZE_EMAIL ) );

$record = httpGet($email);

// Parsing certain arrays

$list_memberships = array();

foreach ( $record['list-memberships'] as $list) {
    array_push( $list_memberships, $list['static-list-id'] );
}

$salesforce_campaign_ids = explode(";", $record['properties']['salesforcecampaignids']['value']);

// Preparing response

$response = array();

$response['is_contact'] = $record['is-contact'] ? true : false;

if ( $response['is_contact'] === true) {
    $response['lifecycle'] = $record['properties']['lifecyclestage']['value'];
    $response['has_phone'] = $record['properties']['phone']['value'] ? true : false;
    $response['opt_out'] = $record['properties']['otp_out_hbs']['value'] === "true" ? true : false;
    $response['list_memberships'] = $list_memberships;
    $response['salesforce_campaignids'] = $salesforce_campaign_ids;
}

$response = json_encode( $response );

// Headers & output

header('Content-Type: application/json');
$header_origin = isset($_SERVER['HTTP_ORIGIN']) ? filter_var($_SERVER['HTTP_ORIGIN'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH) : '';

if ( in_array( $header_origin, $cross_origin_domains) ) {
    header('Access-Control-Allow-Origin: ' . $header_origin);
}

echo ( $response );

?>

<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

mb_internal_encoding("UTF-8");

$app['title'] = '';
$app['description'] = '';
$app['domain'] = "http://".$_SERVER['SERVER_NAME'];
$app['googleSiteVerification'] = '';
$app['yandexVerification'] = '';
$app['yandexMetrika'] = '';
$app['googleAnalytics'] = '';
$app['CallbackkillerID'] = '';
$app['facebookPixel'] = '';
$app['googleMapsApiKey'] = '';

// Enable/disable sending form data services
$settings['sendEmail'] = true;
$settings['isSMTP'] = false;
$settings['sendSMS'] = false;
$settings['writeLocalFile'] = false;
$settings['writeGoogleSheets'] = false;

$settings['sypexGeoApiKey'] = '';
$settings['smsRecipietns'] = '';
$settings['smsRuApiKey'] = '';
$settings['smsMessage'] = " ";

$settings['EmailRecipietns'] = [''];
$settings['EmailReplyTo'] = [''];
$settings['EmailFrom'] = "";
$settings['EmailSubject'] = "Новая заявка с сайта ". $_SERVER['SERVER_NAME'] ."";
$settings['EmailSMTPHosts'] = '';
$settings['EmailSMTPUser'] = '';
$settings['EmailSMTPPassword'] = '';
$settings['EmailSMTPSecure'] = 'tls';
$settings['EmailSMTPPort'] = 587;

$settings['fileForRequests'] = 'requests.csv';

$settings['googleSpreedSheetsAppName'] = '';
$settings['googleSpreedSheetsClientId'] = '';
$settings['googleSpreedSheetsClientEmail'] = '';
$settings['googleSpreedSheetsClientSecrets'] = '';
$settings['googleSpreedSheetsScope'] = 'https://spreadsheets.google.com/feeds';
$settings['googleSpreedSheetsP12'] = '';
$settings['googleSpreedSheetsSpreedSheetID'] = '';
$settings['googleSpreedSheetsWorkSheetID'] = '';



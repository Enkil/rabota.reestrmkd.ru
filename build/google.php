<?php

$CLIENT_APP_NAME = $settings['googleSpreedSheetsAppName'];
$CLIENT_ID       = $settings['googleSpreedSheetsClientId'];
$CLIENT_EMAIL    = $settings['googleSpreedSheetsClientEmail'];
$CLIENT_KEY_PATH = $settings['googleSpreedSheetsP12'];
$CLIENT_KEY_PW   = 'notasecret';

$objClientAuth  = new Google_Client ();
$objClientAuth->setClassConfig('Google_Cache_File', 'directory', 'tmp/Google_Client');
$objClientAuth -> setApplicationName ($CLIENT_APP_NAME);
$objClientAuth -> setClientId ($CLIENT_ID);
$objClientAuth -> setAssertionCredentials (new Google_Auth_AssertionCredentials (
    $CLIENT_EMAIL,
    array('https://spreadsheets.google.com/feeds','https://docs.google.com/feeds'),
    file_get_contents ($CLIENT_KEY_PATH),
    $CLIENT_KEY_PW
));
$objClientAuth->getAuth()->refreshTokenWithAssertion();
$objToken  = json_decode($objClientAuth->getAccessToken());
$accessToken = $objToken->access_token;

/**
 * Initialize the service request factory
 */
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

$serviceRequest = new DefaultServiceRequest($accessToken);
ServiceRequestFactory::setInstance($serviceRequest);

/**
 * Get spreadsheet by title
 */
$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
$spreadsheetFeed = $spreadsheetService->getSpreadsheetFeed();
$spreadsheet = $spreadsheetFeed->getById($settings['googleSpreedSheetsSpreedSheetID']);

/**
 * Get particular worksheet of the selected spreadsheet
 */
$worksheetFeed = $spreadsheet->getWorksheetFeed();
$worksheet = $worksheetFeed->getById($settings['googleSpreedSheetsWorkSheetID']);
$listFeed = $worksheet->getListFeed();
<?php

require_once ('vendor/autoload.php');
require_once ('vendor/google/apiclient/src/Google/autoload.php');
require_once ('settings.php');
require_once ('functions.php');
require_once ('google.php');
require_once ('sypex.php');


if(isset($_POST['formname']))
{
    //FormFields Data
    $data = loadData();
    $utm = loadUtm();

    //CustomData
    $today = date("Y-m-d H:i:s");
    $referer = htmlspecialchars(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

    // Email body
    $body = str_replace(
        //Искомые значения
        array_merge(formFields(),utmData(),customFields()),
        //На что заменяем
        array_merge(formFieldValues(),utmDataValues(),[$_SERVER['SERVER_NAME'],$today,$country,$region,$city,$region_time, $referer]),
        //Источник
        file_get_contents('mail.html')
    );

    // Send data with enabled services
    if ($settings['sendEmail']){
        sendEmail($settings,$body);
    }
    if ($settings['sendSMS']){
        sendSms($settings,$data);
    }
    if ($settings['writeLocalFile']){

    }
    if ($settings['writeGoogleSheets']){
        insertRowInGoogleSpreadSheet($listFeed,$today,$data,$country,$city,$region,$utm,$referer);
    }

}

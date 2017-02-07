<?php

/**
 * @return array
 * Поля формы (только для шаблона, значения указывать вручную в form.php не нужно)
 */
function formFields(){
    return [
        'formname','name','phone'
    ];
}

/**
 * @return array
 * Кастомные поля (только для шаблона, значения указывать вручную в form.php)
 */
function customFields(){
    return [
        'site','today','country','region','city','reg_time','referer',
    ];
}

/**
 * @return array
 * Поля UTM-меток (только для шаблона, значения указывать вручную в form.php не нужно)
 */
function utmData(){
    return [
        'utm_source','utm_medium','utm_campaign','utm_term','utm_content'

    ];
}

function adress($country, $city, $region){
    $string = check($country).','.check($city).','.check($region);
    return $string;
}

function check($var,$message = ' '){
    return ($var) ? $var : $message;
}

function formFieldValues(){
    return array_map(function ($key){
        return (isset($_POST[$key])) ? htmlspecialchars($_POST[$key]) : false;
    },formFields());
}

function utmDataValues(){
    return array_map(function ($key){
        return \UtmCookie\UtmCookie::get($key);
    },utmData());
}

function loadData(){
    return array_combine(formFields(),formFieldValues());
}

function loadUtm(){
    return array_combine(utmData(),utmDataValues());
}

function sendEmail($settings,$body){
    $mail = new PHPMailer();

    if ($settings['isSMTP']){
        $mail->isSMTP();

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->SMTPDebug = 4;
        $mail->Host = $settings['EmailSMTPHosts'];
        $mail->SMTPAuth = true;
        $mail->Username = $settings['EmailSMTPUser'];
        $mail->Password = $settings['EmailSMTPPassword'];
        $mail->SMTPSecure = $settings['EmailSMTPSecure'];
        $mail->Port = $settings['EmailSMTPPort'];
    }

    $mail->CharSet = 'UTF-8';
    $mail->setFrom($settings['EmailFrom'], '');

    array_map(function ($email) use ($mail){
        $mail->addAddress($email);
    },$settings['EmailRecipients']);

    array_map(function ($email) use ($mail){
        $mail->addReplyTo($email);
    },$settings['EmailReplyTo']);

    $mail->isHTML(true);
    $mail->Subject = $settings['EmailSubject'];
    $mail->Body    = $body;

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}

function sendSms($settings,$data){
    return file_get_contents("http://sms.ru/sms/send?api_id=".$settings['smsRuApiKey']."&to=". $settings['smsRecipietns'] ."&text=".urlencode("Заявка от {$data['name']},'.{$data['phone']}."));
}

function insertRowInGoogleSpreadSheet($listFeed,$today,$data,$country,$city,$region,$utm,$referer){
    $refPattern = '-';
    $refCode = stristr($utm['utm_campaign'],$refPattern);
    $row = array(
        'дата'=>$today,
        'статус'=>'Новая с телефоном',
        'телефон'=>$data['phone'],
        'e-mail'=>$data['email'],
        'фио'=>$data['name'],
        'адрес'=>adress($country,$city,$region),
        'промо-код'=>$data['promo'],
        'источник'=>($utm['utm_source']) ? $utm['utm_source'] : 0,
        'рефкод'=> $refCode,
        'cтраница'=>(string)$referer
    );
    $listFeed->insert($row);
}
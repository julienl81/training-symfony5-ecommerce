<?php

namespace App\Classe;

use Mailjet\Client;
use \Mailjet\Resources;

class Mail 
{
    private $api_key = '21436a700e10aba3fdee879a09cd5fb7';
    private $api_key_secret = '73fd2ece447a8127820b0545497e96fd';

    public function send($to_email, $to_name, $subject, $content) {
    $mj= new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);

    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => 'julienlaurent77@outlook.com',
                    'Name' => 'La Boutique Française'
                ],
                'To' => [
                    [
                        'Email' => $to_email,
                        'Name' => $to_name
                    ]
                ],
                'TemplateID' => 4265490,
                'TemplateLanguage' => true,
                'Subject' => $subject,
                'Variables' => [
                    'content' => $content,
                ]
            ]
        ]
    ];

    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success() && dump($response->getData());

    }


}




 ?>
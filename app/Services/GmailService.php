<?php

namespace App\Services;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class GmailService
{
    private $client;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->addScope(Google_Service_Gmail::GMAIL_SEND);
    }

    public function sendMessage($to, $subject, $body)
    {
        $service = new Google_Service_Gmail($this->client);
        $message = new Google_Service_Gmail_Message();

        $rawMessage = "From: me\r\n";
        $rawMessage .= "To: $to\r\n";
        $rawMessage .= "Subject: $subject\r\n";
        $rawMessage .= "\r\n$body";

        $encodedMessage = base64_encode($rawMessage);
        $encodedMessage = rtrim(strtr($encodedMessage, '+/', '-_'), '=');

        $message->setRaw($encodedMessage);

        try {
            $service->users_messages->send('me', $message);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function authenticate($code = null)
    {
        if ($code) {
            $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);
            $this->client->setAccessToken($accessToken);
        }

        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $this->client->getRefreshToken();
            $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
        }

        return $this->client;
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }
}

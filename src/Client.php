<?php

namespace RedjanYm\FCM;

use GuzzleHttp;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    const DEFAULT_API_URL = 'https://fcm.googleapis.com/v1/projects/{PROJECT_ID}/messages:send';
    private string $projectId;
    private string $serviceAccountPath;
    private string $accessToken;
    private GuzzleHttp\Client $guzzleClient;

    public function __construct(string $serviceAccountPath)
    {
        if (file_exists($serviceAccountPath) === false) {
            throw new \InvalidArgumentException('Service account file does not exist!');
        }

        $this->serviceAccountPath = $serviceAccountPath;
        $this->guzzleClient = new \GuzzleHttp\Client();
        $this->applyCredentials();
    }

    public function setServiceAccountPath(string $serviceAccountPath): self
    {
        if (file_exists($serviceAccountPath) === false) {
            throw new \InvalidArgumentException('Service account file does not exist!');
        }

        $this->serviceAccountPath = $serviceAccountPath;
        $this->applyCredentials();
        return $this;
    }

    private function applyCredentials(): self
    {
        $this->projectId = \json_decode(file_get_contents($this->serviceAccountPath), true)['project_id'];
        $this->accessToken = $this->getAccessToken();

        return $this;
    }

    private function getAccessToken(): string
    {
        $client = new \Google\Client();
        $client->setAuthConfig($this->serviceAccountPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->useApplicationDefaultCredentials();
        $token = $client->fetchAccessTokenWithAssertion();

        return $token['access_token'];
    }

    /**
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function send(Notification $message): ResponseInterface
    {
        return $this->guzzleClient->post(
            $this->getApiUrl(),
            [
                'headers' => [
                    'Authorization' => sprintf('Bearer %s', $this->accessToken),
                    'Content-Type' => 'application/json'
                ],
                'body' => \json_encode([
                    'message' => $message,
                ])
            ]
        );
    }

    private function getApiUrl()
    {
        return str_replace('{PROJECT_ID}', $this->projectId, self::DEFAULT_API_URL);
    }
}

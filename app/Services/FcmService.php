<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    protected $credentialsPath;
    protected $projectId;

    public function __construct()
    {
        $this->credentialsPath = storage_path('app/firebase-auth.json');
        $this->projectId = env('FIREBASE_PROJECT_ID');
    }

    /**
     * Send Push Notification to a specific FCM token
     */
    public function sendNotification($token, $title, $body, $data = [])
    {
        if (!$token) return false;

        if (!file_exists($this->credentialsPath)) {
            Log::error('Firebase credentials file not found at ' . $this->credentialsPath . '. Push notification skipped.');
            return false;
        }

        if (!$this->projectId) {
            Log::error('FIREBASE_PROJECT_ID not set in .env. Push notification skipped.');
            return false;
        }

        try {
            $accessToken = $this->getAccessToken();
            
            $payload = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => !empty($data) ? array_map('strval', $data) : null,
                    'android' => [
                        'priority' => 'high',
                        'notification' => [
                            'sound' => 'default',
                            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        ],
                    ],
                    'apns' => [
                        'payload' => [
                            'aps' => [
                                'sound' => 'default',
                            ],
                        ],
                    ],
                ],
            ];

            // Remove null entries
            $payload['message'] = array_filter($payload['message']);

            $response = Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send", $payload);

            if ($response->failed()) {
                Log::error('FCM send failed: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('FCM Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get OAuth2 Access Token for Firebase HTTP v1
     */
    protected function getAccessToken()
    {
        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];
        $credentials = new ServiceAccountCredentials($scopes, $this->credentialsPath);
        $token = $credentials->fetchAuthToken(HttpHandlerFactory::build());
        
        return $token['access_token'];
    }
}

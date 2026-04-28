<?php

namespace App\Services;

class MessagingService {
    
    private $config;
    private $db;
    
    public function __construct() {
        $this->config = require __DIR__ . '/../../config/messaging.php';
        $this->db = new \PDO('sqlite:' . __DIR__ . '/../../database/app.db');
    }
    
    // ============ SMS Methods ============
    public function sendSMS($phone, $message, $purpose = 'general') {
        $driver = $this->config['sms']['driver'];
        
        if ($driver === 'twilio' && $this->config['sms']['twilio']['enabled']) {
            return $this->sendViaTwilio($phone, $message, $purpose);
        } elseif ($driver === 'aws_sns' && $this->config['sms']['aws_sns']['enabled']) {
            return $this->sendViaAWSSNS($phone, $message, $purpose);
        }
        
        return false;
    }
    
    private function sendViaTwilio($phone, $message, $purpose) {
        try {
            $config = $this->config['sms']['twilio'];
            $accountSid = $config['account_sid'];
            $authToken = $config['auth_token'];
            
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json";
            
            $data = [
                'From' => $config['phone_number'],
                'To' => $phone,
                'Body' => $message,
            ];
            
            $response = $this->makeRequest($url, $data, $accountSid, $authToken);
            $this->logCommunication('sms_twilio', $phone, $message, 'sent', $response);
            
            return true;
        } catch (\Exception $e) {
            $this->logCommunication('sms_twilio', $phone, $message, 'failed', $e->getMessage());
            return false;
        }
    }
    
    private function sendViaAWSSNS($phone, $message, $purpose) {
        try {
            // AWS SNS implementation placeholder
            $this->logCommunication('sms_aws', $phone, $message, 'sent', 'AWS SNS');
            return true;
        } catch (\Exception $e) {
            $this->logCommunication('sms_aws', $phone, $message, 'failed', $e->getMessage());
            return false;
        }
    }
    
    // ============ WhatsApp Methods ============
    public function sendWhatsApp($phone, $message, $templateName = null) {
        if (!$this->config['whatsapp']['meta']['enabled']) {
            return false;
        }
        
        try {
            $apiVersion = $this->config['whatsapp']['meta']['api_version'];
            $phoneNumberId = $this->config['whatsapp']['meta']['phone_number_id'];
            $accessToken = $this->config['whatsapp']['meta']['access_token'];
            
            $url = "https://graph.instagram.com/{$apiVersion}/{$phoneNumberId}/messages";
            
            $data = [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => $message,
                ],
            ];
            
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ];
            
            $response = $this->makeRequest($url, $data, null, null, $headers);
            $this->logCommunication('whatsapp_meta', $phone, $message, 'sent', $response);
            
            return true;
        } catch (\Exception $e) {
            $this->logCommunication('whatsapp_meta', $phone, $message, 'failed', $e->getMessage());
            return false;
        }
    }
    
    public function sendWhatsAppTemplate($phone, $templateName, $parameters = []) {
        if (!$this->config['whatsapp']['meta']['enabled']) {
            return false;
        }
        
        try {
            $apiVersion = $this->config['whatsapp']['meta']['api_version'];
            $phoneNumberId = $this->config['whatsapp']['meta']['phone_number_id'];
            $accessToken = $this->config['whatsapp']['meta']['access_token'];
            
            $url = "https://graph.instagram.com/{$apiVersion}/{$phoneNumberId}/messages";
            
            $data = [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => [
                        'code' => 'en_US',
                    ],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => array_map(fn($p) => ['type' => 'text', 'text' => $p], $parameters),
                        ],
                    ],
                ],
            ];
            
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ];
            
            $response = $this->makeRequest($url, $data, null, null, $headers);
            $this->logCommunication('whatsapp_template', $phone, $templateName, 'sent', $response);
            
            return true;
        } catch (\Exception $e) {
            $this->logCommunication('whatsapp_template', $phone, $templateName, 'failed', $e->getMessage());
            return false;
        }
    }
    
    // ============ Telegram Methods ============
    public function sendTelegram($chatId, $message) {
        if (!$this->config['telegram']['enabled']) {
            return false;
        }
        
        try {
            $botToken = $this->config['telegram']['bot_token'];
            $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
            
            $data = [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ];
            
            $response = $this->makeRequest($url, $data);
            $this->logCommunication('telegram', $chatId, $message, 'sent', $response);
            
            return true;
        } catch (\Exception $e) {
            $this->logCommunication('telegram', $chatId, $message, 'failed', $e->getMessage());
            return false;
        }
    }
    
    public function sendTelegramDocument($chatId, $fileUrl, $caption = '') {
        if (!$this->config['telegram']['enabled']) {
            return false;
        }
        
        try {
            $botToken = $this->config['telegram']['bot_token'];
            $url = "https://api.telegram.org/bot{$botToken}/sendDocument";
            
            $data = [
                'chat_id' => $chatId,
                'document' => $fileUrl,
                'caption' => $caption,
            ];
            
            $this->makeRequest($url, $data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    // ============ Helper Methods ============
    private function makeRequest($url, $data, $username = null, $password = null, $customHeaders = []) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        if ($username && $password) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        }
        
        $headers = array_merge([
            'Content-Type: application/json',
        ], $customHeaders);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return $response;
        }
        
        throw new \Exception("API Request failed with code $httpCode");
    }
    
    private function logCommunication($service, $recipient, $message, $status, $response) {
        $stmt = $this->db->prepare("
            INSERT INTO communication_logs (service_type, recipient, message_content, status, response, created_at)
            VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
        ");
        $stmt->execute([$service, $recipient, substr($message, 0, 500), $status, substr($response, 0, 1000)]);
    }
    
    public function getOrderNotificationMessage($order) {
        return "Order #{$order['order_number']} confirmed. Total: ₹{$order['total_amount']}. Estimated delivery: 3-5 days.";
    }
    
    public function getShipmentNotificationMessage($order, $tracking) {
        return "Your order #{$order['order_number']} has shipped! Tracking: {$tracking}";
    }
}

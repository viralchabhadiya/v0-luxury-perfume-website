<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SettingsController extends Controller {
    
    private $db;
    
    public function __construct() {
        $this->db = new \PDO('sqlite:' . __DIR__ . '/../../../../database/app.db');
    }
    
    public function index() {
        return view('admin/settings/index');
    }
    
    public function emailSettings() {
        $emailConfig = require __DIR__ . '/../../../../config/email.php';
        return view('admin/settings/email', ['config' => $emailConfig]);
    }
    
    public function updateEmailSettings() {
        $data = $_POST;
        
        // Update .env file
        $this->updateEnv([
            'MAIL_DRIVER' => $data['mail_driver'] ?? 'smtp',
            'MAIL_HOST' => $data['mail_host'] ?? '',
            'MAIL_PORT' => $data['mail_port'] ?? 587,
            'MAIL_USERNAME' => $data['mail_username'] ?? '',
            'MAIL_PASSWORD' => $data['mail_password'] ?? '',
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'] ?? '',
            'MAIL_FROM_NAME' => $data['mail_from_name'] ?? '',
            'MAIL_ENCRYPTION' => $data['mail_encryption'] ?? 'tls',
            'SENDGRID_API_KEY' => $data['sendgrid_api_key'] ?? '',
            'MAILGUN_API_KEY' => $data['mailgun_api_key'] ?? '',
            'MAILGUN_DOMAIN' => $data['mailgun_domain'] ?? '',
        ]);
        
        return redirect('admin/settings/email')->with('success', 'Email settings updated successfully!');
    }
    
    public function messagingSettings() {
        $messagingConfig = require __DIR__ . '/../../../../config/messaging.php';
        return view('admin/settings/messaging', ['config' => $messagingConfig]);
    }
    
    public function updateMessagingSettings() {
        $data = $_POST;
        
        $this->updateEnv([
            'SMS_DRIVER' => $data['sms_driver'] ?? 'twilio',
            'TWILIO_ACCOUNT_SID' => $data['twilio_account_sid'] ?? '',
            'TWILIO_AUTH_TOKEN' => $data['twilio_auth_token'] ?? '',
            'TWILIO_PHONE_NUMBER' => $data['twilio_phone_number'] ?? '',
            'TWILIO_ENABLED' => $data['twilio_enabled'] ?? false,
            
            'AWS_SNS_KEY' => $data['aws_sns_key'] ?? '',
            'AWS_SNS_SECRET' => $data['aws_sns_secret'] ?? '',
            'AWS_REGION' => $data['aws_region'] ?? 'us-east-1',
            'AWS_SNS_ENABLED' => $data['aws_sns_enabled'] ?? false,
            
            'WHATSAPP_DRIVER' => $data['whatsapp_driver'] ?? 'meta',
            'WHATSAPP_API_VERSION' => $data['whatsapp_api_version'] ?? 'v18.0',
            'WHATSAPP_PHONE_NUMBER_ID' => $data['whatsapp_phone_number_id'] ?? '',
            'WHATSAPP_BUSINESS_ACCOUNT_ID' => $data['whatsapp_business_account_id'] ?? '',
            'WHATSAPP_ACCESS_TOKEN' => $data['whatsapp_access_token'] ?? '',
            'WHATSAPP_ENABLED' => $data['whatsapp_enabled'] ?? false,
            
            'TELEGRAM_BOT_TOKEN' => $data['telegram_bot_token'] ?? '',
            'TELEGRAM_WEBHOOK_URL' => $data['telegram_webhook_url'] ?? '',
            'TELEGRAM_ENABLED' => $data['telegram_enabled'] ?? false,
            
            'FCM_KEY' => $data['fcm_key'] ?? '',
            'FCM_SENDER_ID' => $data['fcm_sender_id'] ?? '',
            'PUSH_NOTIFICATIONS_ENABLED' => $data['push_notifications_enabled'] ?? false,
        ]);
        
        return redirect('admin/settings/messaging')->with('success', 'Messaging settings updated successfully!');
    }
    
    public function aiSettings() {
        $aiConfig = require __DIR__ . '/../../../../config/ai.php';
        return view('admin/settings/ai', ['config' => $aiConfig]);
    }
    
    public function updateAiSettings() {
        $data = $_POST;
        
        $this->updateEnv([
            'AI_PROVIDER' => $data['ai_provider'] ?? 'openai',
            
            'OPENAI_API_KEY' => $data['openai_api_key'] ?? '',
            'OPENAI_MODEL' => $data['openai_model'] ?? 'gpt-4',
            'OPENAI_ENABLED' => $data['openai_enabled'] ?? false,
            
            'GROQ_API_KEY' => $data['groq_api_key'] ?? '',
            'GROQ_MODEL' => $data['groq_model'] ?? 'mixtral-8x7b',
            'GROQ_ENABLED' => $data['groq_enabled'] ?? false,
            
            'HUGGINGFACE_API_KEY' => $data['huggingface_api_key'] ?? '',
            'HUGGINGFACE_MODEL' => $data['huggingface_model'] ?? 'gpt2',
            'HUGGINGFACE_ENABLED' => $data['huggingface_enabled'] ?? false,
            
            'AI_RECOMMENDATIONS' => $data['ai_recommendations'] ?? true,
            'AI_CHATBOT' => $data['ai_chatbot'] ?? true,
            'AI_SEARCH' => $data['ai_search'] ?? true,
            'AI_CONTENT_GENERATION' => $data['ai_content_generation'] ?? true,
            'AI_SENTIMENT_ANALYSIS' => $data['ai_sentiment_analysis'] ?? true,
        ]);
        
        return redirect('admin/settings/ai')->with('success', 'AI settings updated successfully!');
    }
    
    public function communicationLogs() {
        $stmt = $this->db->prepare("
            SELECT * FROM communication_logs 
            ORDER BY created_at DESC 
            LIMIT 100
        ");
        $stmt->execute();
        $logs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return view('admin/settings/logs', ['logs' => $logs]);
    }
    
    public function testEmail() {
        if ($_POST) {
            $email = $_POST['test_email'] ?? '';
            $subject = 'Test Email from Patel Perfumes';
            $message = 'This is a test email to verify your email configuration is working correctly.';
            
            $emailService = new \App\Services\EmailService();
            $result = $emailService->sendNewsletterEmail($email, $subject, $message);
            
            if ($result) {
                return json_encode(['success' => true, 'message' => 'Test email sent successfully!']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to send test email.']);
            }
        }
    }
    
    public function testSMS() {
        if ($_POST) {
            $phone = $_POST['test_phone'] ?? '';
            $message = 'This is a test SMS from Patel Perfumes to verify SMS configuration.';
            
            $messagingService = new \App\Services\MessagingService();
            $result = $messagingService->sendSMS($phone, $message, 'test');
            
            if ($result) {
                return json_encode(['success' => true, 'message' => 'Test SMS sent successfully!']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to send test SMS.']);
            }
        }
    }
    
    public function testWhatsApp() {
        if ($_POST) {
            $phone = $_POST['test_phone'] ?? '';
            $message = 'This is a test WhatsApp message from Patel Perfumes.';
            
            $messagingService = new \App\Services\MessagingService();
            $result = $messagingService->sendWhatsApp($phone, $message);
            
            if ($result) {
                return json_encode(['success' => true, 'message' => 'Test WhatsApp sent successfully!']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to send test WhatsApp.']);
            }
        }
    }
    
    public function testTelegram() {
        if ($_POST) {
            $chatId = $_POST['test_chat_id'] ?? '';
            $message = 'This is a test Telegram message from Patel Perfumes.';
            
            $messagingService = new \App\Services\MessagingService();
            $result = $messagingService->sendTelegram($chatId, $message);
            
            if ($result) {
                return json_encode(['success' => true, 'message' => 'Test Telegram sent successfully!']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to send test Telegram.']);
            }
        }
    }
    
    private function updateEnv($values) {
        $envPath = __DIR__ . '/../../../../.env';
        $env = file_get_contents($envPath);
        
        foreach ($values as $key => $value) {
            if (strpos($env, $key) !== false) {
                $env = preg_replace("/^{$key}=.*/m", "{$key}=" . $this->escapeEnvValue($value), $env);
            } else {
                $env .= "\n{$key}=" . $this->escapeEnvValue($value);
            }
        }
        
        file_put_contents($envPath, $env);
    }
    
    private function escapeEnvValue($value) {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (strpos($value, ' ') !== false) {
            return '"' . $value . '"';
        }
        return $value;
    }
}

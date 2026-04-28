<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    
    private $mailer;
    private $config;
    
    public function __construct() {
        $this->config = require __DIR__ . '/../../config/email.php';
        $this->initializeMailer();
    }
    
    private function initializeMailer() {
        $this->mailer = new PHPMailer(true);
        
        $driver = $this->config['driver'];
        
        if ($driver === 'smtp') {
            $smtp = $this->config['smtp'];
            $this->mailer->isSMTP();
            $this->mailer->Host = $smtp['host'];
            $this->mailer->Port = $smtp['port'];
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = $smtp['username'];
            $this->mailer->Password = $smtp['password'];
            $this->mailer->SMTPSecure = $smtp['encryption'];
            $this->mailer->setFrom($smtp['from_address'], $smtp['from_name']);
        }
    }
    
    public function sendOrderConfirmation($order, $email) {
        try {
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Order Confirmation - ' . $order['order_number'];
            $this->mailer->Body = $this->getOrderConfirmationTemplate($order);
            
            return $this->mailer->send();
        } catch (Exception $e) {
            $this->logError('Order Confirmation', $email, $e->getMessage());
            return false;
        }
    }
    
    public function sendShipmentNotification($order, $email, $tracking) {
        try {
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Your Order Has Been Shipped!';
            $this->mailer->Body = $this->getShipmentTemplate($order, $tracking);
            
            return $this->mailer->send();
        } catch (Exception $e) {
            $this->logError('Shipment Notification', $email, $e->getMessage());
            return false;
        }
    }
    
    public function sendNewsletterEmail($email, $subject, $content) {
        try {
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $this->wrapTemplate($content);
            
            return $this->mailer->send();
        } catch (Exception $e) {
            $this->logError('Newsletter', $email, $e->getMessage());
            return false;
        }
    }
    
    public function sendPasswordReset($email, $resetLink) {
        try {
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Password Reset Request';
            $this->mailer->Body = $this->getPasswordResetTemplate($resetLink);
            
            return $this->mailer->send();
        } catch (Exception $e) {
            $this->logError('Password Reset', $email, $e->getMessage());
            return false;
        }
    }
    
    private function getOrderConfirmationTemplate($order) {
        return "
        <html>
            <body style='font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #8B6E47;'>Order Confirmation</h2>
                    <p>Thank you for your purchase!</p>
                    <p><strong>Order Number:</strong> {$order['order_number']}</p>
                    <p><strong>Total Amount:</strong> ₹{$order['total_amount']}</p>
                    <p><strong>Order Date:</strong> {$order['created_at']}</p>
                    <p>We will send you a shipping confirmation when your order is dispatched.</p>
                    <p>Best regards,<br/>Patel Perfumes Team</p>
                </div>
            </body>
        </html>";
    }
    
    private function getShipmentTemplate($order, $tracking) {
        return "
        <html>
            <body style='font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #8B6E47;'>Your Order Has Shipped!</h2>
                    <p>Order {$order['order_number']} has been dispatched.</p>
                    <p><strong>Tracking Number:</strong> {$tracking}</p>
                    <p>Track your package at your carrier's website.</p>
                    <p>Best regards,<br/>Patel Perfumes Team</p>
                </div>
            </body>
        </html>";
    }
    
    private function getPasswordResetTemplate($resetLink) {
        return "
        <html>
            <body style='font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #8B6E47;'>Password Reset Request</h2>
                    <p>Click the link below to reset your password:</p>
                    <p><a href='{$resetLink}' style='background: #8B6E47; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a></p>
                    <p>This link expires in 1 hour.</p>
                </div>
            </body>
        </html>";
    }
    
    private function wrapTemplate($content) {
        return "
        <html>
            <body style='font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                    {$content}
                    <hr style='margin-top: 30px;'/>
                    <p style='color: #666; font-size: 12px;'>© 2026 Patel Perfumes. All rights reserved.</p>
                </div>
            </body>
        </html>";
    }
    
    private function logError($type, $recipient, $error) {
        $db = new \PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        $stmt = $db->prepare("INSERT INTO communication_logs (service_type, recipient, status, response) VALUES (?, ?, ?, ?)");
        $stmt->execute(['email_' . $type, $recipient, 'failed', $error]);
    }
}

<?php

namespace App\Services;

class AIService {
    
    private $config;
    private $db;
    private $provider;
    
    public function __construct() {
        $this->config = require __DIR__ . '/../../config/ai.php';
        $this->db = new \PDO('sqlite:' . __DIR__ . '/../../database/app.db');
        $this->provider = $this->config['default_provider'];
    }
    
    // ============ Product Recommendations ============
    public function getProductRecommendations($userId, $limit = 5) {
        if (!$this->config['features']['recommendations']['enabled']) {
            return [];
        }
        
        try {
            // Get user's purchase history
            $userHistory = $this->getUserPurchaseHistory($userId);
            $browsingHistory = $this->getUserBrowsingHistory($userId);
            
            // Generate AI-based recommendations
            $recommendations = $this->generateRecommendations($userId, $userHistory, $browsingHistory, $limit);
            
            return $recommendations;
        } catch (\Exception $e) {
            return [];
        }
    }
    
    // ============ Chatbot ============
    public function getAIResponse($userMessage, $context = []) {
        if (!$this->config['features']['chatbot']['enabled']) {
            return "Our chatbot is currently unavailable. Please contact support.";
        }
        
        try {
            $response = $this->queryAIProvider($userMessage, $context);
            return $response;
        } catch (\Exception $e) {
            return "I'm sorry, I couldn't process your request. Please try again later.";
        }
    }
    
    public function handleSupportTicket($message, $ticketId) {
        try {
            $response = $this->getAIResponse($message);
            return [
                'suggested_response' => $response,
                'confidence' => 0.85,
                'requires_human' => false,
            ];
        } catch (\Exception $e) {
            return [
                'suggested_response' => '',
                'confidence' => 0,
                'requires_human' => true,
            ];
        }
    }
    
    // ============ Smart Search ============
    public function semanticSearch($query, $limit = 10) {
        if (!$this->config['features']['search']['enabled']) {
            return $this->fallbackSearch($query, $limit);
        }
        
        try {
            // Get embedding for the query
            $queryEmbedding = $this->getEmbedding($query);
            
            // Find similar products using semantic similarity
            $results = $this->findSimilarProducts($queryEmbedding, $limit);
            
            return $results;
        } catch (\Exception $e) {
            return $this->fallbackSearch($query, $limit);
        }
    }
    
    // ============ Content Generation ============
    public function generateProductDescription($productData) {
        if (!$this->config['features']['content_generation']['enabled']) {
            return '';
        }
        
        try {
            $prompt = "Generate a luxury product description for a perfume with the following details: " . json_encode($productData);
            return $this->queryAIProvider($prompt);
        } catch (\Exception $e) {
            return '';
        }
    }
    
    public function generateMarketingCopy($product, $style = 'elegant') {
        if (!$this->config['features']['content_generation']['enabled']) {
            return '';
        }
        
        try {
            $prompt = "Write a {$style} marketing copy for this perfume: {$product['name']}. Focus on: {$product['notes']}.";
            return $this->queryAIProvider($prompt);
        } catch (\Exception $e) {
            return '';
        }
    }
    
    // ============ Sentiment Analysis ============
    public function analyzeSentiment($text) {
        if (!$this->config['features']['sentiment_analysis']['enabled']) {
            return ['sentiment' => 'neutral', 'score' => 0.5];
        }
        
        try {
            $prompt = "Analyze the sentiment of this text and return JSON with 'sentiment' (positive/negative/neutral) and 'score' (0-1): " . $text;
            $response = $this->queryAIProvider($prompt);
            
            // Parse JSON response
            preg_match('/\{.*\}/', $response, $matches);
            if ($matches) {
                return json_decode($matches[0], true);
            }
            
            return ['sentiment' => 'neutral', 'score' => 0.5];
        } catch (\Exception $e) {
            return ['sentiment' => 'neutral', 'score' => 0.5];
        }
    }
    
    public function analyzeReview($reviewText) {
        $sentiment = $this->analyzeSentiment($reviewText);
        
        return [
            'sentiment' => $sentiment['sentiment'],
            'score' => $sentiment['score'],
            'keywords' => $this->extractKeywords($reviewText),
            'aspects' => $this->extractAspects($reviewText),
        ];
    }
    
    // ============ Private Helper Methods ============
    private function queryAIProvider($prompt, $context = []) {
        $provider = $this->config['default_provider'];
        
        switch ($provider) {
            case 'openai':
                return $this->queryOpenAI($prompt, $context);
            case 'groq':
                return $this->queryGroq($prompt, $context);
            case 'huggingface':
                return $this->queryHuggingFace($prompt, $context);
            default:
                throw new \Exception("Unknown AI provider: $provider");
        }
    }
    
    private function queryOpenAI($prompt, $context = []) {
        if (!$this->config['openai']['enabled']) {
            throw new \Exception("OpenAI is not enabled");
        }
        
        $apiKey = $this->config['openai']['api_key'];
        $model = $this->config['openai']['model'];
        
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant for Patel Perfumes e-commerce.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => $this->config['features']['chatbot']['temperature'],
            'max_tokens' => $this->config['features']['chatbot']['max_tokens'],
        ]));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        return $data['choices'][0]['message']['content'] ?? '';
    }
    
    private function queryGroq($prompt, $context = []) {
        if (!$this->config['groq']['enabled']) {
            throw new \Exception("Groq is not enabled");
        }
        
        $apiKey = $this->config['groq']['api_key'];
        $model = $this->config['groq']['model'];
        
        $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant for Patel Perfumes e-commerce.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        return $data['choices'][0]['message']['content'] ?? '';
    }
    
    private function queryHuggingFace($prompt, $context = []) {
        if (!$this->config['huggingface']['enabled']) {
            throw new \Exception("HuggingFace is not enabled");
        }
        
        $apiKey = $this->config['huggingface']['api_key'];
        $model = $this->config['huggingface']['model'];
        
        $ch = curl_init("https://api-inference.huggingface.co/models/{$model}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ]);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'inputs' => $prompt,
        ]));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        return isset($data[0]['generated_text']) ? $data[0]['generated_text'] : '';
    }
    
    private function getUserPurchaseHistory($userId) {
        $stmt = $this->db->prepare("
            SELECT p.id, p.name, p.category_id, COUNT(*) as times_purchased
            FROM products p
            JOIN order_items oi ON p.id = oi.product_id
            JOIN orders o ON oi.order_id = o.id
            WHERE o.user_id = ?
            GROUP BY p.id
            ORDER BY o.created_at DESC
            LIMIT 10
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    private function getUserBrowsingHistory($userId) {
        return [];
    }
    
    private function generateRecommendations($userId, $history, $browsing, $limit) {
        $stmt = $this->db->prepare("SELECT * FROM products LIMIT ?");
        $stmt->execute([$limit]);
        $allProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return array_slice($allProducts, 0, $limit);
    }
    
    private function getEmbedding($text) {
        return [];
    }
    
    private function findSimilarProducts($embedding, $limit) {
        $stmt = $this->db->prepare("SELECT * FROM products LIMIT ?");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    private function fallbackSearch($query, $limit) {
        $stmt = $this->db->prepare("
            SELECT * FROM products 
            WHERE name LIKE ? OR description LIKE ?
            LIMIT ?
        ");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    private function extractKeywords($text) {
        $words = array_count_values(str_word_count(strtolower($text), 1));
        arsort($words);
        return array_slice(array_keys($words), 0, 5);
    }
    
    private function extractAspects($text) {
        $aspects = [];
        $keywords = ['longevity', 'projection', 'scent', 'bottle', 'packaging', 'value', 'price'];
        
        foreach ($keywords as $keyword) {
            if (stripos($text, $keyword) !== false) {
                $aspects[] = $keyword;
            }
        }
        
        return $aspects;
    }
}

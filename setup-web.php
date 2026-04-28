<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patel Perfumes - Setup Wizard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 100%;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #8B7355 0%, #D4AF37 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .header p {
            font-size: 1.1em;
            opacity: 0.95;
        }
        
        .content {
            padding: 40px;
            max-height: 600px;
            overflow-y: auto;
        }
        
        .step {
            margin-bottom: 30px;
            display: none;
        }
        
        .step.active {
            display: block;
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .step-title {
            font-size: 1.8em;
            color: #8B7355;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .step-number {
            background: #D4AF37;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
        }
        
        .step-content {
            margin-left: 55px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="url"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95em;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="url"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .toggle-section {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .toggle-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 600;
            color: #333;
        }
        
        .toggle-header:hover {
            color: #8B7355;
        }
        
        .toggle-content {
            display: none;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
        }
        
        .toggle-content.active {
            display: block;
        }
        
        .status-message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .status-message.show {
            display: block;
        }
        
        .status-message.success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .status-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .status-message.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 2px solid #bee5eb;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #8B7355 0%, #D4AF37 100%);
            width: 0%;
            transition: width 0.3s;
        }
        
        .controls {
            display: flex;
            gap: 10px;
            justify-content: space-between;
            padding: 30px 40px;
            border-top: 2px solid #e0e0e0;
            background: #f9f9f9;
        }
        
        button {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background: #d0d0d0;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #8B7355 0%, #D4AF37 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.4);
        }
        
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .success-screen {
            text-align: center;
            padding: 40px;
        }
        
        .success-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }
        
        .success-screen h2 {
            color: #8B7355;
            margin-bottom: 15px;
            font-size: 2em;
        }
        
        .success-screen p {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        
        .info-box {
            background: #f0f0f0;
            padding: 15px;
            border-left: 4px solid #8B7355;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .info-box strong {
            color: #8B7355;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #D4AF37;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .section-divider {
            height: 1px;
            background: #e0e0e0;
            margin: 30px 0;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8em;
            }
            
            .content {
                padding: 20px;
            }
            
            .controls {
                flex-direction: column;
                padding: 20px;
            }
            
            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💎 Patel Perfumes Setup Wizard</h1>
            <p>Professional Setup in Just 5 Minutes</p>
        </div>
        
        <div class="progress-bar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
        
        <div class="content">
            <div id="statusMessage" class="status-message"></div>
            
            <!-- Step 1: Database -->
            <div class="step active" data-step="1">
                <div class="step-title">
                    <div class="step-number">1</div>
                    <div>Database Setup</div>
                </div>
                <div class="step-content">
                    <div class="info-box">
                        <strong>✓ SQLite Database</strong><br>
                        We'll create and configure your SQLite database automatically.
                    </div>
                    <p style="color: #666; margin-bottom: 20px;">
                        This step will create all necessary database tables and seed sample data.
                    </p>
                </div>
            </div>
            
            <!-- Step 2: Application Settings -->
            <div class="step" data-step="2">
                <div class="step-title">
                    <div class="step-number">2</div>
                    <div>Application Settings</div>
                </div>
                <div class="step-content">
                    <div class="form-group">
                        <label>Application Name</label>
                        <input type="text" id="appName" placeholder="Patel Perfumes" value="Patel Perfumes">
                    </div>
                    <div class="form-group">
                        <label>Application URL</label>
                        <input type="url" id="appUrl" placeholder="http://localhost:8000" value="http://localhost:8000">
                    </div>
                    <div class="form-group">
                        <label>Admin Email</label>
                        <input type="email" id="adminEmail" placeholder="admin@patelperfumes.com" value="admin@patelperfumes.com">
                    </div>
                </div>
            </div>
            
            <!-- Step 3: Admin Account -->
            <div class="step" data-step="3">
                <div class="step-title">
                    <div class="step-number">3</div>
                    <div>Admin Account</div>
                </div>
                <div class="step-content">
                    <div class="form-group">
                        <label>Admin Username</label>
                        <input type="text" id="adminUsername" placeholder="admin" value="admin">
                    </div>
                    <div class="form-group">
                        <label>Admin Password</label>
                        <input type="password" id="adminPassword" placeholder="Create a strong password" value="admin123">
                    </div>
                    <div class="form-group">
                        <label>Admin Full Name</label>
                        <input type="text" id="adminName" placeholder="Administrator" value="Administrator">
                    </div>
                </div>
            </div>
            
            <!-- Step 4: Email Configuration -->
            <div class="step" data-step="4">
                <div class="step-title">
                    <div class="step-number">4</div>
                    <div>Email Configuration</div>
                </div>
                <div class="step-content">
                    <div class="checkbox-group">
                        <input type="checkbox" id="enableEmail" checked>
                        <label for="enableEmail" style="margin-bottom: 0;">Enable Email Notifications</label>
                    </div>
                    
                    <div id="emailSettings">
                        <div class="form-group">
                            <label>Mail Driver</label>
                            <select id="mailDriver">
                                <option value="log">Log (Testing - No Emails Sent)</option>
                                <option value="smtp">SMTP (Gmail, Custom)</option>
                                <option value="sendgrid">SendGrid API</option>
                            </select>
                        </div>
                        
                        <div id="smtpFields" style="display: none;">
                            <div class="form-group">
                                <label>SMTP Host</label>
                                <input type="text" id="smtpHost" placeholder="smtp.gmail.com" value="smtp.gmail.com">
                            </div>
                            <div class="form-group">
                                <label>SMTP Port</label>
                                <input type="number" id="smtpPort" placeholder="587" value="587">
                            </div>
                            <div class="form-group">
                                <label>SMTP Username</label>
                                <input type="email" id="smtpUsername" placeholder="your-email@gmail.com">
                            </div>
                            <div class="form-group">
                                <label>SMTP Password / App Password</label>
                                <input type="password" id="smtpPassword" placeholder="Your app password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 5: SMS/WhatsApp Configuration -->
            <div class="step" data-step="5">
                <div class="step-title">
                    <div class="step-number">5</div>
                    <div>SMS & WhatsApp Configuration</div>
                </div>
                <div class="step-content">
                    <div class="checkbox-group">
                        <input type="checkbox" id="enableSMS">
                        <label for="enableSMS" style="margin-bottom: 0;">Enable SMS Notifications (Twilio)</label>
                    </div>
                    
                    <div id="smsSettings" style="display: none;">
                        <div class="form-group">
                            <label>Twilio Account SID</label>
                            <input type="text" id="twilioSid" placeholder="Your Twilio SID">
                        </div>
                        <div class="form-group">
                            <label>Twilio Auth Token</label>
                            <input type="text" id="twilioToken" placeholder="Your Twilio Token">
                        </div>
                        <div class="form-group">
                            <label>Twilio Phone Number</label>
                            <input type="text" id="twilioPhone" placeholder="+1234567890">
                        </div>
                    </div>
                    
                    <div class="section-divider"></div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="enableWhatsApp">
                        <label for="enableWhatsApp" style="margin-bottom: 0;">Enable WhatsApp Business API (Meta)</label>
                    </div>
                    
                    <div id="whatsappSettings" style="display: none;">
                        <div class="form-group">
                            <label>WhatsApp Phone Number ID</label>
                            <input type="text" id="whatsappPhoneId" placeholder="Your Phone Number ID">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp Access Token</label>
                            <input type="text" id="whatsappToken" placeholder="Your Access Token">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 6: AI Configuration -->
            <div class="step" data-step="6">
                <div class="step-title">
                    <div class="step-number">6</div>
                    <div>AI Configuration</div>
                </div>
                <div class="step-content">
                    <div class="checkbox-group">
                        <input type="checkbox" id="enableAI">
                        <label for="enableAI" style="margin-bottom: 0;">Enable AI Features</label>
                    </div>
                    
                    <div id="aiSettings" style="display: none;">
                        <div class="form-group">
                            <label>AI Provider</label>
                            <select id="aiProvider">
                                <option value="openai">OpenAI GPT-4</option>
                                <option value="groq">Groq (Fast & Affordable)</option>
                                <option value="huggingface">HuggingFace</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>API Key</label>
                            <input type="password" id="aiApiKey" placeholder="Your API Key">
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="enableChatbot" checked>
                            <label for="enableChatbot" style="margin-bottom: 0;">Enable AI Chatbot</label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" id="enableRecommendations" checked>
                            <label for="enableRecommendations" style="margin-bottom: 0;">Enable Product Recommendations</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Step 7: Confirmation -->
            <div class="step" data-step="7">
                <div class="step-title">
                    <div class="step-number">✓</div>
                    <div>Review & Complete Setup</div>
                </div>
                <div class="step-content">
                    <div class="info-box">
                        <strong>Ready to Setup?</strong><br>
                        Review your settings above and click "Complete Setup" to initialize your Patel Perfumes store.
                    </div>
                    <div id="reviewContent" style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin-top: 20px; max-height: 300px; overflow-y: auto;"></div>
                </div>
            </div>
            
            <!-- Success Screen -->
            <div class="step" data-step="8">
                <div class="success-screen">
                    <div class="success-icon">✓</div>
                    <h2>Setup Complete!</h2>
                    <p>Your Patel Perfumes store is ready to go!</p>
                    
                    <div class="info-box" style="text-align: left; margin: 20px 0;">
                        <strong>Next Steps:</strong><br><br>
                        1. Visit your store: <a href="http://localhost:8000" target="_blank" style="color: #8B7355; text-decoration: none;">http://localhost:8000</a><br><br>
                        2. Access Admin: <a href="http://localhost:8000/admin/login" target="_blank" style="color: #8B7355; text-decoration: none;">http://localhost:8000/admin/login</a><br><br>
                        3. Login with your credentials<br><br>
                        4. Configure additional services in Admin → Settings
                    </div>
                    
                    <button class="btn-primary" onclick="window.location.href='http://localhost:8000';">Visit Your Store</button>
                </div>
            </div>
        </div>
        
        <div class="controls">
            <button class="btn-secondary" id="prevBtn" onclick="previousStep()">← Back</button>
            <button class="btn-primary" id="nextBtn" onclick="nextStep()">Next →</button>
        </div>
    </div>
    
    <script>
        let currentStep = 1;
        const totalSteps = 8;
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateProgressBar();
            setupCheckboxListeners();
            setupDriverListeners();
            showStep(1);
        });
        
        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.step').forEach(el => {
                el.classList.remove('active');
            });
            
            // Show current step
            document.querySelector(`.step[data-step="${step}"]`).classList.add('active');
            
            // Update buttons
            document.getElementById('prevBtn').disabled = step === 1;
            document.getElementById('nextBtn').textContent = step === totalSteps ? 'Finish' : (step === 7 ? 'Complete Setup' : 'Next →');
            
            updateProgressBar();
            
            if (step === 7) {
                generateReview();
            }
        }
        
        function nextStep() {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
                window.scrollTo(0, 0);
            } else if (currentStep === totalSteps - 1) {
                completeSetup();
            } else {
                window.location.href = 'http://localhost:8000';
            }
        }
        
        function previousStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                window.scrollTo(0, 0);
            }
        }
        
        function updateProgressBar() {
            const progress = (currentStep / totalSteps) * 100;
            document.getElementById('progressFill').style.width = progress + '%';
        }
        
        function setupCheckboxListeners() {
            document.getElementById('enableEmail').addEventListener('change', function() {
                document.getElementById('emailSettings').style.display = this.checked ? 'block' : 'none';
            });
            
            document.getElementById('enableSMS').addEventListener('change', function() {
                document.getElementById('smsSettings').style.display = this.checked ? 'block' : 'none';
            });
            
            document.getElementById('enableWhatsApp').addEventListener('change', function() {
                document.getElementById('whatsappSettings').style.display = this.checked ? 'block' : 'none';
            });
            
            document.getElementById('enableAI').addEventListener('change', function() {
                document.getElementById('aiSettings').style.display = this.checked ? 'block' : 'none';
            });
        }
        
        function setupDriverListeners() {
            document.getElementById('mailDriver').addEventListener('change', function() {
                document.getElementById('smtpFields').style.display = this.value === 'smtp' ? 'block' : 'none';
            });
        }
        
        function generateReview() {
            const review = `
                <h3 style="margin-bottom: 15px; color: #8B7355;">Configuration Summary:</h3>
                <p><strong>App Name:</strong> ${document.getElementById('appName').value}</p>
                <p><strong>Admin Email:</strong> ${document.getElementById('adminEmail').value}</p>
                <p><strong>Database:</strong> SQLite</p>
                <p><strong>Email Enabled:</strong> ${document.getElementById('enableEmail').checked ? 'Yes' : 'No'}</p>
                <p><strong>SMS Enabled:</strong> ${document.getElementById('enableSMS').checked ? 'Yes' : 'No'}</p>
                <p><strong>WhatsApp Enabled:</strong> ${document.getElementById('enableWhatsApp').checked ? 'Yes' : 'No'}</p>
                <p><strong>AI Enabled:</strong> ${document.getElementById('enableAI').checked ? 'Yes' : 'No'}</p>
            `;
            document.getElementById('reviewContent').innerHTML = review;
        }
        
        function completeSetup() {
            const setupData = {
                appName: document.getElementById('appName').value,
                appUrl: document.getElementById('appUrl').value,
                adminEmail: document.getElementById('adminEmail').value,
                adminUsername: document.getElementById('adminUsername').value,
                adminPassword: document.getElementById('adminPassword').value,
                adminName: document.getElementById('adminName').value,
                
                enableEmail: document.getElementById('enableEmail').checked,
                mailDriver: document.getElementById('mailDriver').value,
                smtpHost: document.getElementById('smtpHost').value,
                smtpPort: document.getElementById('smtpPort').value,
                smtpUsername: document.getElementById('smtpUsername').value,
                smtpPassword: document.getElementById('smtpPassword').value,
                
                enableSMS: document.getElementById('enableSMS').checked,
                twilioSid: document.getElementById('twilioSid').value,
                twilioToken: document.getElementById('twilioToken').value,
                twilioPhone: document.getElementById('twilioPhone').value,
                
                enableWhatsApp: document.getElementById('enableWhatsApp').checked,
                whatsappPhoneId: document.getElementById('whatsappPhoneId').value,
                whatsappToken: document.getElementById('whatsappToken').value,
                
                enableAI: document.getElementById('enableAI').checked,
                aiProvider: document.getElementById('aiProvider').value,
                aiApiKey: document.getElementById('aiApiKey').value,
                enableChatbot: document.getElementById('enableChatbot').checked,
                enableRecommendations: document.getElementById('enableRecommendations').checked,
            };
            
            const nextBtn = document.getElementById('nextBtn');
            nextBtn.disabled = true;
            nextBtn.innerHTML = '<span class="loading"></span> Setting up...';
            
            fetch('setup-api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(setupData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentStep = totalSteps;
                    showStep(currentStep);
                    showMessage('Setup completed successfully! Your store is ready.', 'success');
                } else {
                    showMessage('Error: ' + data.message, 'error');
                    nextBtn.disabled = false;
                    nextBtn.innerHTML = 'Complete Setup';
                }
            })
            .catch(error => {
                showMessage('Error: ' + error.message, 'error');
                nextBtn.disabled = false;
                nextBtn.innerHTML = 'Complete Setup';
            });
        }
        
        function showMessage(message, type) {
            const el = document.getElementById('statusMessage');
            el.textContent = message;
            el.className = `status-message show ${type}`;
            setTimeout(() => {
                el.classList.remove('show');
            }, 5000);
        }
    </script>
</body>
</html>

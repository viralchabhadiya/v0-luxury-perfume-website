// ============================================
// PATEL PERFUMES - 2026 WIDGETS SYSTEM
// ============================================

class PathelPerfumeWidgets {
    constructor() {
        this.widgets = {};
        this.init();
    }
    
    init() {
        this.initChatWidget();
        this.initRecommendationWidget();
        this.initNewsletterWidget();
        this.initAISearchWidget();
    }
    
    // ============ Chat Widget ============
    initChatWidget() {
        if (document.getElementById('chat-widget')) {
            this.createChatWidget();
        }
    }
    
    createChatWidget() {
        const widget = document.createElement('div');
        widget.id = 'floating-chat-widget';
        widget.innerHTML = `
            <div style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                <!-- Chat Button -->
                <button id="chat-toggle" style="
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    background: #8B6E47;
                    border: none;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    transition: all 0.3s;
                ">
                    💬
                </button>
                
                <!-- Chat Box -->
                <div id="chat-box" style="
                    display: none;
                    position: absolute;
                    bottom: 80px;
                    right: 0;
                    width: 350px;
                    height: 500px;
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
                    flex-direction: column;
                    overflow: hidden;
                ">
                    <!-- Header -->
                    <div style="background: #8B6E47; color: white; padding: 16px; font-weight: bold;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span>Patel Perfumes Support 🧴</span>
                            <button id="chat-close" style="
                                background: none;
                                border: none;
                                color: white;
                                font-size: 20px;
                                cursor: pointer;
                            ">×</button>
                        </div>
                    </div>
                    
                    <!-- Messages -->
                    <div id="chat-messages" style="
                        flex: 1;
                        overflow-y: auto;
                        padding: 16px;
                        display: flex;
                        flex-direction: column;
                        gap: 12px;
                    "></div>
                    
                    <!-- Input -->
                    <div style="padding: 12px; border-top: 1px solid #eee; display: flex; gap: 8px;">
                        <input 
                            id="chat-input" 
                            type="text" 
                            placeholder="Type your message..."
                            style="
                                flex: 1;
                                padding: 8px 12px;
                                border: 1px solid #ddd;
                                border-radius: 4px;
                                font-size: 14px;
                            "
                        >
                        <button 
                            id="chat-send"
                            style="
                                background: #8B6E47;
                                color: white;
                                border: none;
                                padding: 8px 16px;
                                border-radius: 4px;
                                cursor: pointer;
                                font-weight: bold;
                            "
                        >
                            Send
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(widget);
        this.setupChatListeners();
    }
    
    setupChatListeners() {
        const toggle = document.getElementById('chat-toggle');
        const chatBox = document.getElementById('chat-box');
        const closeBtn = document.getElementById('chat-close');
        const sendBtn = document.getElementById('chat-send');
        const input = document.getElementById('chat-input');
        
        toggle.addEventListener('click', () => {
            chatBox.style.display = chatBox.style.display === 'none' ? 'flex' : 'none';
        });
        
        closeBtn.addEventListener('click', () => {
            chatBox.style.display = 'none';
        });
        
        sendBtn.addEventListener('click', () => this.sendChatMessage());
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendChatMessage();
        });
    }
    
    sendChatMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        
        if (!message) return;
        
        const messagesDiv = document.getElementById('chat-messages');
        
        // Add user message
        const userMsg = document.createElement('div');
        userMsg.style.cssText = 'align-self: flex-end; background: #8B6E47; color: white; padding: 8px 12px; border-radius: 8px; max-width: 80%;';
        userMsg.textContent = message;
        messagesDiv.appendChild(userMsg);
        
        input.value = '';
        
        // Simulate AI response
        setTimeout(() => {
            const aiMsg = document.createElement('div');
            aiMsg.style.cssText = 'align-self: flex-start; background: #f0f0f0; color: #333; padding: 8px 12px; border-radius: 8px; max-width: 80%;';
            aiMsg.textContent = 'Thank you for contacting Patel Perfumes! We\'ll respond shortly with the information you need.';
            messagesDiv.appendChild(aiMsg);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }, 500);
        
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
    
    // ============ Product Recommendation Widget ============
    initRecommendationWidget() {
        if (document.getElementById('recommendations-widget')) {
            this.createRecommendationWidget();
        }
    }
    
    createRecommendationWidget() {
        const container = document.getElementById('recommendations-widget');
        container.innerHTML = `
            <div style="background: white; border-radius: 8px; padding: 24px; margin: 32px 0;">
                <h3 style="font-size: 24px; font-weight: bold; margin-bottom: 16px; color: #333;">
                    ✨ Recommended For You
                </h3>
                <div id="recommendations-list" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                    <!-- Recommendations will be loaded here -->
                    <div style="text-align: center; padding: 32px; color: #999;">Loading recommendations...</div>
                </div>
            </div>
        `;
        
        // Fetch recommendations
        this.loadRecommendations();
    }
    
    loadRecommendations() {
        fetch('/api/recommendations')
            .then(r => r.json())
            .then(products => {
                const list = document.getElementById('recommendations-list');
                list.innerHTML = '';
                
                if (products.length === 0) {
                    list.innerHTML = '<p>No recommendations available</p>';
                    return;
                }
                
                products.forEach(product => {
                    const card = document.createElement('div');
                    card.style.cssText = 'background: white; border: 1px solid #eee; border-radius: 8px; overflow: hidden; transition: all 0.3s;';
                    card.onmouseover = () => card.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
                    card.onmouseout = () => card.style.boxShadow = 'none';
                    
                    card.innerHTML = `
                        <div style="aspect-ratio: 1; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                            <img src="${product.image || '/images/placeholder.jpg'}" alt="${product.name}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="padding: 12px;">
                            <p style="font-weight: bold; margin-bottom: 8px; font-size: 14px;">${product.name}</p>
                            <p style="color: #8B6E47; font-size: 18px; font-weight: bold;">₹${product.price}</p>
                            <button onclick="window.location.href='/products/${product.id}'" style="
                                width: 100%;
                                padding: 8px;
                                background: #8B6E47;
                                color: white;
                                border: none;
                                border-radius: 4px;
                                cursor: pointer;
                                margin-top: 8px;
                                font-weight: bold;
                            ">View</button>
                        </div>
                    `;
                    
                    list.appendChild(card);
                });
            })
            .catch(err => {
                console.error('Error loading recommendations:', err);
                const list = document.getElementById('recommendations-list');
                list.innerHTML = '<p>Error loading recommendations</p>';
            });
    }
    
    // ============ Newsletter Widget ============
    initNewsletterWidget() {
        if (document.getElementById('newsletter-widget')) {
            this.createNewsletterWidget();
        }
    }
    
    createNewsletterWidget() {
        const container = document.getElementById('newsletter-widget');
        container.innerHTML = `
            <div style="background: linear-gradient(135deg, #8B6E47 0%, #6B5437 100%); color: white; border-radius: 8px; padding: 32px; text-align: center; margin: 32px 0;">
                <h3 style="font-size: 24px; font-weight: bold; margin-bottom: 8px;">✉️ Join Our Exclusive List</h3>
                <p style="margin-bottom: 24px; opacity: 0.95;">Get exclusive perfume launches and 15% off your first order</p>
                <div style="display: flex; gap: 8px; margin-bottom: 16px;">
                    <input 
                        id="newsletter-email"
                        type="email" 
                        placeholder="Enter your email"
                        style="
                            flex: 1;
                            padding: 12px;
                            border: none;
                            border-radius: 4px;
                            font-size: 14px;
                        "
                    >
                    <button 
                        id="newsletter-subscribe"
                        style="
                            padding: 12px 24px;
                            background: #FFD700;
                            color: #333;
                            border: none;
                            border-radius: 4px;
                            cursor: pointer;
                            font-weight: bold;
                        "
                    >
                        Subscribe
                    </button>
                </div>
                <p id="newsletter-message" style="font-size: 12px; opacity: 0.8;"></p>
            </div>
        `;
        
        document.getElementById('newsletter-subscribe').addEventListener('click', () => {
            this.subscribeNewsletter();
        });
    }
    
    subscribeNewsletter() {
        const email = document.getElementById('newsletter-email').value.trim();
        const message = document.getElementById('newsletter-message');
        
        if (!email) {
            message.textContent = 'Please enter an email address';
            message.style.color = '#ff6b6b';
            return;
        }
        
        fetch('/api/newsletter-subscribe', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                message.textContent = '✓ Thank you! Check your email for your 15% discount code';
                message.style.color = '#90EE90';
                document.getElementById('newsletter-email').value = '';
            } else {
                message.textContent = data.message || 'Subscription failed. Please try again.';
                message.style.color = '#ff6b6b';
            }
        })
        .catch(err => {
            message.textContent = 'Error subscribing. Please try again later.';
            message.style.color = '#ff6b6b';
        });
    }
    
    // ============ AI Search Widget ============
    initAISearchWidget() {
        if (document.getElementById('ai-search-widget')) {
            this.createAISearchWidget();
        }
    }
    
    createAISearchWidget() {
        const container = document.getElementById('ai-search-widget');
        container.innerHTML = `
            <div style="margin: 24px 0;">
                <div style="display: flex; gap: 8px; margin-bottom: 16px;">
                    <input 
                        id="ai-search-input"
                        type="text" 
                        placeholder="🤖 Search with AI: 'fresh floral perfume for summer'..."
                        style="
                            flex: 1;
                            padding: 12px;
                            border: 2px solid #8B6E47;
                            border-radius: 4px;
                            font-size: 14px;
                        "
                    >
                    <button 
                        id="ai-search-btn"
                        style="
                            padding: 12px 24px;
                            background: #8B6E47;
                            color: white;
                            border: none;
                            border-radius: 4px;
                            cursor: pointer;
                            font-weight: bold;
                        "
                    >
                        Search
                    </button>
                </div>
                <div id="ai-search-results" style="display: none; margin-top: 16px;"></div>
            </div>
        `;
        
        document.getElementById('ai-search-btn').addEventListener('click', () => {
            this.performAISearch();
        });
        
        document.getElementById('ai-search-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.performAISearch();
        });
    }
    
    performAISearch() {
        const query = document.getElementById('ai-search-input').value.trim();
        const resultsDiv = document.getElementById('ai-search-results');
        
        if (!query) return;
        
        resultsDiv.style.display = 'block';
        resultsDiv.innerHTML = '<p style="color: #999;">Searching with AI...</p>';
        
        fetch(`/api/ai-search?q=${encodeURIComponent(query)}`)
            .then(r => r.json())
            .then(data => {
                if (data.results && data.results.length > 0) {
                    resultsDiv.innerHTML = `
                        <div style="margin-bottom: 12px; font-size: 12px; color: #666;">
                            ${data.reasoning || 'Here are the best matches for your search:'}
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px;">
                            ${data.results.map(p => `
                                <a href="/products/${p.id}" style="
                                    background: white;
                                    border: 1px solid #eee;
                                    border-radius: 4px;
                                    padding: 12px;
                                    text-decoration: none;
                                    color: #333;
                                    text-align: center;
                                ">
                                    <p style="font-weight: bold; font-size: 14px; margin-bottom: 4px;">${p.name}</p>
                                    <p style="color: #8B6E47; font-weight: bold;">₹${p.price}</p>
                                </a>
                            `).join('')}
                        </div>
                    `;
                } else {
                    resultsDiv.innerHTML = '<p style="color: #999;">No results found. Try a different search.</p>';
                }
            })
            .catch(err => {
                resultsDiv.innerHTML = '<p style="color: #ff6b6b;">Search failed. Please try again.</p>';
            });
    }
}

// Initialize widgets when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new PathelPerfumeWidgets();
    });
} else {
    new PathelPerfumeWidgets();
}

// DOM Elements
const chatDisplay = document.getElementById('chatDisplay');
const userInput = document.getElementById('userInput');
const sendButton = document.getElementById('sendButton');
const imageButton = document.getElementById('imageButton');
const imageInput = document.getElementById('imageInput');

// SVG Icons - Define them if you don't have the actual files
const plantIconSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M12 2v8M4 10h16M12 10v12M8 14h8"/>
</svg>`;

// Initialize chat with welcome message
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        addMessage('Hello! I\'m your Agriculture AI Assistant. How can I help with your farming or gardening questions today?', 'ai');
    }, 500);
});

// Event Listeners
sendButton.addEventListener('click', sendMessage);
userInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

imageButton.addEventListener('click', () => {
    imageInput.click();
});

imageInput.addEventListener('change', handleImageUpload);

// Functions
function sendMessage() {
    const message = userInput.value.trim();
    if (message === '') return;
    
    // Add user message to chat
    addMessage(message, 'user');
    userInput.value = '';
    
    // Show typing indicator
    showTypingIndicator();
    
    // Simulate AI response (would connect to real API in production)
    setTimeout(() => {
        removeTypingIndicator();
        generateResponse(message);
    }, 1000 + Math.random() * 1000); // Random delay to seem more natural
}

function askQuestion(question) {
    userInput.value = question;
    sendMessage();
}

function addMessage(message, sender) {
    const chatRow = document.createElement('div');
    chatRow.className = `chat-row ${sender}`;
    
    // Create avatar
    const avatar = document.createElement('div');
    avatar.className = `avatar ${sender}-avatar`;
    
    if (sender === 'ai') {
        avatar.innerHTML = '<img src="plant-icon.svg" alt="AI">';
    } else {
        avatar.textContent = 'U';
    }
    
    // Create message bubble
    const bubble = document.createElement('div');
    bubble.className = `chat-bubble ${sender}-bubble`;
    bubble.innerHTML = formatMessage(message);
    
    // Add avatar and bubble to row
    if (sender === 'ai') {
        chatRow.appendChild(avatar);
        chatRow.appendChild(bubble);
    } else {
        chatRow.appendChild(bubble);
        chatRow.appendChild(avatar);
    }
    
    chatDisplay.appendChild(chatRow);
    
    // Scroll to bottom
    chatDisplay.scrollTop = chatDisplay.scrollHeight;
}

function formatMessage(message) {
    // Simple formatting for common markdown elements
    let formatted = message
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/\n/g, '<br>');
    
    // Handle bullet lists
    if (message.includes('\n- ')) {
        formatted = formatted.replace(/- (.*?)(<br>|$)/g, '<li>$1</li>');
        formatted = formatted.replace(/<li>(.*?)<\/li>(<li>|$)/g, '<ul><li>$1</li>$2');
        formatted = formatted.replace(/<\/li>$/g, '</li></ul>');
    }
    
    return formatted;
}

function showTypingIndicator() {
    const typingRow = document.createElement('div');
    typingRow.className = 'chat-row ai';
    typingRow.id = 'typingIndicator';
    
    const avatar = document.createElement('div');
    avatar.className = 'avatar ai-avatar';
    avatar.innerHTML = '<img src="plant-icon.svg" alt="AI">';
    
    const indicator = document.createElement('div');
    indicator.className = 'typing-indicator';
    indicator.innerHTML = '<span></span><span></span><span></span>';
    
    typingRow.appendChild(avatar);
    typingRow.appendChild(indicator);
    
    chatDisplay.appendChild(typingRow);
    chatDisplay.scrollTop = chatDisplay.scrollHeight;
}

function removeTypingIndicator() {
    const typingIndicator = document.getElementById('typingIndicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

function handleImageUpload(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    if (!file.type.startsWith('image/')) {
        addMessage('Please upload only image files.', 'ai');
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(event) {
        const img = document.createElement('img');
        img.src = event.target.result;
        img.className = 'uploaded-image';
        
        // Add user message with image
        const chatRow = document.createElement('div');
        chatRow.className = 'chat-row user';
        
        const avatar = document.createElement('div');
        avatar.className = 'avatar user-avatar';
        avatar.textContent = 'U';
        
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble user-bubble';
        bubble.textContent = 'I uploaded an image for analysis:';
        bubble.appendChild(img);
        
        chatRow.appendChild(bubble);
        chatRow.appendChild(avatar);
        
        chatDisplay.appendChild(chatRow);
        chatDisplay.scrollTop = chatDisplay.scrollHeight;
        
        // Process image response
        showTypingIndicator();
        setTimeout(() => {
            removeTypingIndicator();
            addMessage('I\'ve analyzed your image. This appears to be a crop/plant. What specific information would you like to know about it?', 'ai');
        }, 2000);
    };
    
    reader.readAsDataURL(file);
}

function generateResponse(message) {
    // In a real app, this would connect to an AI service
    // For demo purposes, we'll use some canned responses
    
    message = message.toLowerCase();
    
    if (message.includes('sandy soil') || message.includes('sand')) {
        addMessage('For sandy soil, these crops work well:\n- Carrots\n- Potatoes\n- Lettuce\n- Strawberries\n- Watermelon\n- Zucchini\n\nSandy soil drains quickly, so these crops that don\'t need constant moisture will thrive. Consider adding organic matter to improve water retention.', 'ai');
    }
    else if (message.includes('aphid') || message.includes('pest')) {
        addMessage('To control aphids on tomatoes:\n- Spray plants with a strong stream of water to knock aphids off\n- Apply insecticidal soap or neem oil\n- Introduce natural predators like ladybugs\n- Create a garlic or hot pepper spray solution\n- Remove heavily infested leaves\n\nPreventative measures include companion planting with marigolds and maintaining good air circulation.', 'ai');
    }
    else if (message.includes('fertilizer') || message.includes('paddy') || message.includes('rice')) {
        addMessage('For paddy/rice cultivation, a balanced NPK fertilizer with higher nitrogen content works best. Consider:\n- Base application: 14-14-14 NPK before planting\n- Top dressing: Urea (46-0-0) during vegetative growth\n- Second top dressing: 16-20-0 during panicle initiation\n\nOrganic options include compost, animal manure, and green manure crops. Timing is critical - apply main fertilizer 1-2 weeks before planting.', 'ai');
    }
    else if (message.includes('planting guide') || message.includes('season')) {
        addMessage('**Seasonal Planting Guide:**\n\n*Spring (After last frost)*\n- Tomatoes, peppers, cucumbers\n- Beans, corn, squash\n- Melons, pumpkins\n\n*Summer*\n- Heat-tolerant vegetables: okra, sweet potatoes\n- Succession plantings of corn, beans\n\n*Fall*\n- Leafy greens: lettuce, spinach, kale\n- Root vegetables: carrots, beets, radishes\n- Brassicas: broccoli, cauliflower, cabbage\n\n*Winter (Mild climates)*\n- Cover crops\n- Garlic, onions\n- Cold-hardy greens with protection\n\nAlways adjust for your specific growing zone!', 'ai');
    }
    else if (message.includes('organic') || message.includes('natural')) {
        addMessage('**Organic Pest Control Methods:**\n\n*Physical Controls*\n- Handpicking larger pests\n- Row covers and barriers\n- Sticky traps\n- Companion planting\n\n*Biological Controls*\n- Beneficial insects (ladybugs, praying mantis)\n- Nematodes for soil pests\n- Bacillus thuringiensis (Bt) for caterpillars\n\n*Organic Sprays*\n- Neem oil for multiple pests\n- Insecticidal soap for soft-bodied insects\n- Garlic spray for repelling various pests\n- Diatomaceous earth for crawling insects\n\nPrevention through crop rotation and healthy soil is the foundation of organic pest management.', 'ai');
    }
    else {
        addMessage('Thank you for your question about ' + message + '. In agriculture, success depends on understanding your specific growing conditions and crop requirements. Could you provide more details about your location, growing zone, and what specific information you\'re looking for?', 'ai');
    }
}
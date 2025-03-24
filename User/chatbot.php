<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farm Assist Chatbot</title>
  <style>
    /* Global styles */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7f0;
      margin: 0;
      padding: 0;
    }
    
    /* Chatbot icon styles */
    #chat-icon {
      position: fixed;
      bottom: 20px;
      right: 20px;
      cursor: pointer;
      z-index: 1000;
      transition: transform 0.3s ease;
    }
    
    #chat-icon:hover {
      transform: scale(1.1);
    }
    
    #chat-icon-img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
      background-color: #4a7c36;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    /* Chatbox styles */
    #chat-box {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 320px;
      height: 450px;
      background: white;
      border: 1px solid #dbe0d3;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      display: none;
      flex-direction: column;
      overflow: hidden;
    }
    
    #chat-box.active {
      display: flex;
    }
    #chat-box {
    z-index: 1000;
}
    
    #chat-header {
      padding: 15px;
      background: #4a7c36;
      color: white;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    #chat-header-title {
      display: flex;
      align-items: center;
    }
    
    #chat-header-icon {
      width: 28px;
      height: 28px;
      margin-right: 10px;
    }
    
    #close-chat {
      cursor: pointer;
      font-size: 18px;
    }
    
    #chat-messages {
      flex: 1;
      padding: 15px;
      overflow-y: auto;
      background-color: #f9fbf6;
    }
    
    .message {
      margin-bottom: 12px;
      max-width: 85%;
      padding: 10px 12px;
      border-radius: 12px;
      line-height: 1.4;
      font-size: 14px;
    }
    
    .user-message {
      background-color: #e6f2dd;
      color: #2c4d20;
      margin-left: auto;
      border-bottom-right-radius: 4px;
    }
    
    .bot-message {
      background-color: #ffffff;
      color: #333;
      border: 1px solid #e0e5d9;
      border-bottom-left-radius: 4px;
    }
    
    #chat-input {
      padding: 12px;
      border-top: 1px solid #dbe0d3;
      display: flex;
      background-color: white;
    }
    
    #user-input {
      flex: 1;
      padding: 10px;
      border: 1px solid #cad2bb;
      border-radius: 20px;
      outline: none;
      font-size: 14px;
    }
    
    #user-input:focus {
      border-color: #4a7c36;
    }
    
    #send-button {
      margin-left: 8px;
      padding: 8px 16px;
      background: #5d9a48;
      color: white;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.2s;
    }
    
    #send-button:hover {
      background-color: #4a7c36;
    }
    
    /* Welcome message */
    #welcome-container {
      padding: 15px;
      border-bottom: 1px solid #dbe0d3;
      background-color: #f0f4e7;
    }
    
    #welcome-title {
      font-weight: bold;
      color: #4a7c36;
      margin-bottom: 8px;
    }
    
    .quick-option {
      display: inline-block;
      margin: 5px 5px 5px 0;
      padding: 8px 12px;
      background-color: white;
      border: 1px solid #cad2bb;
      border-radius: 16px;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .quick-option:hover {
      background-color: #e6f2dd;
      border-color: #5d9a48;
    }
  </style>
</head>
<body>
  <!-- Chatbot Icon -->
  <div id="chat-icon">
    <div id="chat-icon-img">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
        <line x1="7" y1="13" x2="17" y2="13"/>
        <line x1="12" y1="8" x2="12" y2="18"/>
      </svg>
    </div>
  </div>

  <!-- Chatbox -->
  <div id="chat-box">
    <div id="chat-header">
      <div id="chat-header-title">
        <svg id="chat-header-icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          <line x1="8" y1="9" x2="16" y2="9"/>
          <line x1="12" y1="6" x2="12" y2="12"/>
        </svg>
        Farm Assist
      </div>
      <span id="close-chat">×</span>
    </div>
    
    <div id="welcome-container">
      <div id="welcome-title">How can we help your farm today?</div>
      <div id="quick-options">
        <span class="quick-option">Crop recommendations</span>
        <span class="quick-option">Weather forecast</span>
        <span class="quick-option">Pest control</span>
        <span class="quick-option">Equipment</span>
        <span class="quick-option">Soil testing</span>
      </div>
    </div>
    
    <div id="chat-messages">
      <div class="message bot-message">
        Hello farmer! I'm your Farm Assist chatbot. How can I help with your agricultural needs today?
      </div>
    </div>
    
    <div id="chat-input">
      <input type="text" id="user-input" placeholder="Type your farming question..." />
      <button id="send-button">Send</button>
    </div>
  </div>

  <script>
    // Farm-related responses
    const farmResponses = [
      "Our soil testing kits are available for order on the Equipment page. Would you like me to direct you there?",
      "The best time to plant corn in your region depends on soil temperature. Generally, when soil reaches 50-55°F at a 2-inch depth, it's safe to plant.",
      "For organic pest control, consider neem oil, beneficial insects like ladybugs, or companion planting strategies. Would you like specific information for a particular crop?",
      "Our weather forecast shows favorable conditions for harvesting in the next 3 days. You might want to prepare your equipment.",
      "Based on your soil type, wheat, barley, and canola would be suitable crops for rotation. This helps maintain soil nutrients and break pest cycles.",
      "Our irrigation specialists can help you design a water-efficient system for your farm. Would you like to schedule a consultation?",
      "For livestock nutrition questions, I recommend checking our resources page or connecting with our animal nutritionist.",
      "Sustainable farming practices include crop rotation, cover cropping, and reduced tillage. These methods help maintain soil health and reduce erosion."
    ];

    // Toggle chatbox visibility
    document.getElementById('chat-icon').addEventListener('click', function() {
      const chatBox = document.getElementById('chat-box');
      chatBox.classList.add('active');
    });
    
    // Close chat when X is clicked
    document.getElementById('close-chat').addEventListener('click', function() {
      document.getElementById('chat-box').classList.remove('active');
    });

    // Function to send a message
    function sendMessage() {
      const userInput = document.getElementById('user-input');
      const chatMessages = document.getElementById('chat-messages');
      
      if (userInput.value.trim() !== '') {
        // Add user message to chat
        const userMessageElement = document.createElement('div');
        userMessageElement.className = 'message user-message';
        userMessageElement.textContent = userInput.value;
        chatMessages.appendChild(userMessageElement);
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Generate a random farm-related response
        const randomIndex = Math.floor(Math.random() * farmResponses.length);
        
        // Simulate a bot response with typing indicator
        setTimeout(() => {
          const botMessageElement = document.createElement('div');
          botMessageElement.className = 'message bot-message';
          botMessageElement.textContent = farmResponses[randomIndex];
          chatMessages.appendChild(botMessageElement);
          
          // Scroll to bottom again after bot responds
          chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 1000);
        
        userInput.value = ''; // Clear input field
      }
    }

    // Send button click
    document.getElementById('send-button').addEventListener('click', sendMessage);
    
    // Allow pressing Enter to send a message
    document.getElementById('user-input').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        sendMessage();
      }
    });
    
    // Quick option clicks
    document.querySelectorAll('.quick-option').forEach(option => {
      option.addEventListener('click', function() {
        document.getElementById('user-input').value = this.textContent;
        sendMessage();
      });
    });
  </script>
</body>
</html>
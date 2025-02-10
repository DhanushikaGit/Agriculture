// DOM Elements
const chatDisplay = document.getElementById("chatDisplay");
const userInput = document.getElementById("userInput");
const imageInput = document.getElementById("imageInput");
const imageButton = document.getElementById("imageButton");
const sendButton = document.getElementById("sendButton");

// API Configuration
const GEMINI_API_KEY = "AIzaSyBsxRTFdmHVTfP8-nL7eHCV46xGLLfWOPQ";
const GEMINI_API_URL = "https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent";

// Function to add messages to chat
function addMessage(content, sender, isImage = false) {
    const chatRow = document.createElement("div");
    chatRow.classList.add("chat-row", sender);
    
    let bubbleContent = isImage
        ? `<img src="${content}" alt="Uploaded Image" class="uploaded-image">`
        : content;
    
    chatRow.innerHTML = `
        ${sender === "user" ? `<img src="user-avatar.png" alt="User" class="chat-image">` : ""}
        <div class="chat-bubble ${sender}-bubble">${bubbleContent}</div>
        ${sender === "ai" ? `<img src="ai-avatar.png" alt="AI" class="chat-image">` : ""}
    `;
    
    chatDisplay.appendChild(chatRow);
    chatDisplay.scrollTop = chatDisplay.scrollHeight;
}

// Function to call Gemini API
async function getAIResponse(userMessage) {
    try {
        const response = await fetch(`${GEMINI_API_URL}?key=${GEMINI_API_KEY}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                contents: [{
                    parts: [{
                        text: userMessage
                    }]
                }]
            })
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.error?.message || `HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        
        if (data.candidates && data.candidates.length > 0) {
            const aiMessage = data.candidates[0]?.content?.parts?.[0]?.text;
            if (aiMessage) {
                addMessage(aiMessage, "ai");
            } else {
                throw new Error("No response content found");
            }
        } else {
            throw new Error("Invalid API response structure");
        }
    } catch (error) {
        console.error("Error details:", error);
        addMessage(`⚠️ ${error.message}`, "ai");
    }
}

// Handle send button click
sendButton.addEventListener("click", async () => {
    const message = userInput.value.trim();
    if (message) {
        addMessage(message, "user");
        userInput.value = "";
        userInput.focus();
        await getAIResponse(message);
    }
});

// Handle enter key press
userInput.addEventListener("keypress", (e) => {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        sendButton.click();
    }
});

// Handle image upload button click
imageButton.addEventListener("click", () => {
    imageInput.click();
});

// Handle image selection
imageInput.addEventListener("change", () => {
    const file = imageInput.files[0];
    if (file) {
        if (file.size > 5 * 1024 * 1024) {
            addMessage("⚠️ Please select an image smaller than 5MB", "ai");
            return;
        }
        
        const reader = new FileReader();
        reader.onload = () => {
            addMessage(reader.result, "user", true);
            addMessage("I apologize, but I can't process images at the moment.", "ai");
        };
        reader.readAsDataURL(file);
    }
    imageInput.value = "";
});
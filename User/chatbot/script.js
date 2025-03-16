// DOM Elements
const chatDisplay = document.getElementById("chatDisplay");
const userInput = document.getElementById("userInput");
const imageInput = document.getElementById("imageInput");
const imageButton = document.getElementById("imageButton");
const sendButton = document.getElementById("sendButton");

// API Configuration
const GEMINI_API_KEY = "AIzaSyBsxRTFdmHVTfP8-nL7eHCV46xGLLfWOPQ";
const GEMINI_MODEL = "gemini-1.5-pro";
const GEMINI_API_URL = `https://generativelanguage.googleapis.com/v1/models/${GEMINI_MODEL}:generateContent`;

// Function to add messages to chat
function addMessage(content, sender, isImage = false) {
    const chatRow = document.createElement("div");
    chatRow.classList.add("chat-row", sender);
    
    let bubbleContent = isImage
        ? `<img src="${content}" alt="Uploaded Image" class="uploaded-image">`
        : content;
    
    chatRow.innerHTML = `
        <div class="chat-bubble ${sender}-bubble">${bubbleContent}</div>
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
                        text: `You are an agriculture expert. Provide detailed and accurate information about farming, crops, soil, weather, and related topics. ${userMessage}`
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
        reader.onload = async () => {
            addMessage(reader.result, "user", true);
            const imageData = reader.result.split(",")[1]; // Get base64 data

            // Call a crop disease detection API (placeholder)
            const detectionResult = await detectCropDisease(imageData);
            addMessage(detectionResult, "ai");
        };
        reader.readAsDataURL(file);
    }
    imageInput.value = "";
});

// Placeholder function for crop disease detection
async function detectCropDisease(imageData) {
    // Replace with actual API call
    return "⚠️ Crop disease detection is not available yet.";
}

// Quick question handler
function askQuestion(question) {
    userInput.value = question;
    sendButton.click();
}
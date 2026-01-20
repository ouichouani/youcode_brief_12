<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini AI Chatbot</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;600;700&display=swap');

        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --user-msg-bg: #6366f1;
            --ai-msg-bg: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            overflow: hidden;
        }

        .chat-container {
            width: 90%;
            max-width: 900px;
            height: 85vh;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .chat-header {
            padding: 24px 32px;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .chat-header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
        }

        #chat-box {
            flex: 1;
            padding: 24px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
            scroll-behavior: smooth;
        }

        #chat-box::-webkit-scrollbar {
            width: 6px;
        }

        #chat-box::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .message {
            max-width: 80%;
            padding: 14px 20px;
            border-radius: 18px;
            font-size: 0.95rem;
            line-height: 1.5;
            animation: fadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

        .user-message {
            align-self: flex-end;
            background: var(--user-msg-bg);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .ai-message {
            align-self: flex-start;
            background: var(--ai-msg-bg);
            color: var(--text-main);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 8px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .input-area {
            padding: 24px;
            border-top: 1px solid var(--glass-border);
        }

        .input-container {
            display: flex;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 8px;
            transition: all 0.3s ease;
        }

        .input-container:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        input {
            flex: 1;
            background: transparent;
            border: none;
            color: white;
            padding: 12px 16px;
            outline: none;
            font-size: 1rem;
        }

        input::placeholder {
            color: var(--text-muted);
        }

        button {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        button:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .typing {
            font-style: italic;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-left: 8px;
            display: none;
        }

        /* Glassmorphism background elements */
        .blob {
            position: absolute;
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.4;
        }

        .blob-1 {
            top: -100px;
            right: -100px;
        }

        .blob-2 {
            bottom: -100px;
            left: -100px;
        }
    </style>
</head>

<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="chat-container">
        <div class="chat-header">
            <div class="status-dot"></div>
            <h1>Mini AI Assistant</h1>
        </div>

        <div id="chat-box">
            <div class="message ai-message">
                Hello! I'm your EvolveAi. How can I help you today?
            </div>
        </div>

        <div class="input-area">
            <form id="chat-form">
                <div class="input-container">
                    <input type="text" id="user-input" placeholder="Type your message here..." autocomplete="off">
                    <button type="submit" id="send-btn">
                        <span>Send</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
                <div class="typing">AI is thinking...</div>
            </form>
        </div>
    </div>

    <script src="chatbot.js"></script>
</body>

</html>
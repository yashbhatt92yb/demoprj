import { useState, useEffect, useRef } from 'react';
import axios from 'axios';

export default function ChatComponent({ request, userRole }) {
    const [messages, setMessages] = useState([]);
    const [newMessage, setNewMessage] = useState('');
    const [isTyping, setIsTyping] = useState(false);
    const messagesEndRef = useRef(null);

    useEffect(() => {
        // Load initial messages
        axios.get(route('chat.messages', request.request_id))
            .then(response => {
                setMessages(response.data);
                scrollToBottom();
            });

        // Listen for new messages
        // Assuming channel name convention
        /*
        Echo.join(`presence-request.${request.request_id}`)
            .here((users) => {
                // console.log(users);
            })
            .joining((user) => {
                console.log(user.name + ' joined');
            })
            .leaving((user) => {
                console.log(user.name + ' left');
            })
            .listen('RequestMessageCreated', (e) => {
                setMessages(prev => [...prev, e.message]);
                scrollToBottom();
            })
            .listenForWhisper('typing', (e) => {
                setIsTyping(e.typing);
                setTimeout(() => setIsTyping(false), 2000);
            });
        */

       // Fallback for dev without Reverb running
       const interval = setInterval(() => {
            axios.get(route('chat.messages', request.request_id))
                .then(response => {
                    // Simple poll for now to avoid duplications logic complexity in demo
                    if(response.data.length > messages.length) {
                        setMessages(response.data);
                        scrollToBottom();
                    }
                });
       }, 5000);

       return () => clearInterval(interval);

    }, [request.request_id]);

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    const sendMessage = (e) => {
        e.preventDefault();
        if (!newMessage.trim()) return;

        axios.post(route('chat.send', request.request_id), {
            body: newMessage
        }).then(response => {
            setMessages(prev => [...prev, response.data]);
            setNewMessage('');
            scrollToBottom();
        }).catch(error => {
            console.error(error);
        });
    };

    return (
        <div className="flex flex-col h-[500px] border rounded-lg bg-gray-50">
            <div className="flex-1 overflow-y-auto p-4 space-y-4">
                {messages.map((msg) => (
                    <div key={msg.id} className={`flex ${msg.sender_id === request.customer_id && userRole === 'customer' || msg.sender_id !== request.customer_id && userRole === 'staff' ? 'justify-end' : 'justify-start'}`}>
                        <div className={`max-w-[70%] rounded-lg p-3 ${msg.sender_role === userRole ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900'}`}>
                            <p className="text-sm font-bold mb-1">{msg.sender?.name || msg.sender_role}</p>
                            <p>{msg.body}</p>
                            <span className="text-xs opacity-75">{new Date(msg.created_at).toLocaleTimeString()}</span>
                        </div>
                    </div>
                ))}
                <div ref={messagesEndRef} />
            </div>

            {isTyping && <div className="p-2 text-sm text-gray-500 italic">Someone is typing...</div>}

            <div className="p-4 border-t bg-white">
                <form onSubmit={sendMessage} className="flex gap-2">
                    <input
                        type="text"
                        value={newMessage}
                        onChange={(e) => setNewMessage(e.target.value)}
                        className="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Type a message..."
                        disabled={!request.is_chat_enabled && userRole === 'customer'}
                    />
                    <button
                        type="submit"
                        disabled={(!request.is_chat_enabled && userRole === 'customer') || !newMessage.trim()}
                        className="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50"
                    >
                        Send
                    </button>
                </form>
                {!request.is_chat_enabled && userRole === 'customer' && (
                    <p className="text-red-500 text-xs mt-2">Chat is currently disabled by staff.</p>
                )}
            </div>
        </div>
    );
}

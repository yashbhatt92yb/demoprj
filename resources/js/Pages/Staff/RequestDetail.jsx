import StaffLayout from '@/Layouts/StaffLayout';
import { Head, useForm } from '@inertiajs/react';
import ChatComponent from '@/Components/Chat/ChatComponent';
import PrimaryButton from '@/Components/PrimaryButton';

export default function RequestDetail({ request }) {
    const { data, setData, post, processing } = useForm({
        status: request.current_status,
        enabled: request.is_chat_enabled,
    });

    const updateStatus = (newStatus) => {
        setData('status', newStatus);
        // In a real app, use a dedicated form or call post immediately with data
        // Here we hack it for brevity
        // We need to create a separate form instance or use axios for actions if we want cleaner UI
    };

    // Using separate forms conceptually
    const { post: postStatus, processing: processingStatus } = useForm({ status: '' });
    const { post: postChat, processing: processingChat } = useForm({ enabled: !request.is_chat_enabled });

    const handleStatusChange = (e) => {
        postStatus(route('staff.requests.status', request.request_id), {
            data: { status: e.target.value },
            preserveScroll: true,
        });
    };

    const toggleChat = () => {
        postChat(route('staff.requests.toggle_chat', request.request_id), {
            preserveScroll: true,
        });
    };

    return (
        <StaffLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Manage Request #{request.request_id}</h2>}
        >
            <Head title={`Manage Request #${request.request_id}`} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {/* Controls Column */}
                        <div className="lg:col-span-1 space-y-6">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h3 className="text-lg font-bold mb-4">Actions</h3>

                                <div className="mb-6">
                                    <label className="block text-sm font-medium text-gray-700">Update Status</label>
                                    <select
                                        value={request.current_status}
                                        onChange={handleStatusChange}
                                        disabled={processingStatus}
                                        className="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                    >
                                        <option value="assigned">Assigned</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="needs_info">Needs Info</option>
                                        <option value="reviewing">Reviewing</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>

                                <div className="mb-6">
                                    <label className="block text-sm font-medium text-gray-700">Chat Control</label>
                                    <div className="mt-2 flex items-center justify-between">
                                        <span className={`text-sm ${request.is_chat_enabled ? 'text-green-600' : 'text-red-600'}`}>
                                            {request.is_chat_enabled ? 'Chat Enabled' : 'Chat Disabled'}
                                        </span>
                                        <PrimaryButton onClick={toggleChat} disabled={processingChat}>
                                            {request.is_chat_enabled ? 'Disable Chat' : 'Enable Chat'}
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>

                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h3 className="text-lg font-bold mb-4">Customer Info</h3>
                                <p><strong>Name:</strong> {request.customer?.user?.name}</p>
                                <p><strong>Email:</strong> {request.customer?.eml}</p>
                                <p><strong>Phone:</strong> {request.customer?.mob}</p>
                            </div>
                        </div>

                        {/* Chat Column */}
                        <div className="lg:col-span-2">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h3 className="text-lg font-bold mb-4">Conversation</h3>
                                <ChatComponent request={request} userRole="staff" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </StaffLayout>
    );
}

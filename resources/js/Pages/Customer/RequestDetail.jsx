import CustomerLayout from '@/Layouts/CustomerLayout';
import { Head } from '@inertiajs/react';
import ChatComponent from '@/Components/Chat/ChatComponent';

export default function RequestDetail({ request }) {
    return (
        <CustomerLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Request #{request.request_id}</h2>}
        >
            <Head title={`Request #${request.request_id}`} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {/* Info Column */}
                        <div className="lg:col-span-1 space-y-6">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h3 className="text-lg font-bold mb-4">Details</h3>
                                <div className="space-y-3">
                                    <div>
                                        <p className="text-sm text-gray-500">Service</p>
                                        <p className="font-semibold">{request.service.service_nm}</p>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-500">Status</p>
                                        <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${request.current_status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}`}>
                                            {request.current_status}
                                        </span>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-500">Assigned To</p>
                                        <p className="font-semibold">{request.assigned_staff ? request.assigned_staff.frst_nm : 'Pending Assignment'}</p>
                                    </div>
                                    <div>
                                        <p className="text-sm text-gray-500">Price</p>
                                        <p className="font-semibold">₹{request.service.base_price}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Chat Column */}
                        <div className="lg:col-span-2">
                            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                                <h3 className="text-lg font-bold mb-4">Messages</h3>
                                <ChatComponent request={request} userRole="customer" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </CustomerLayout>
    );
}

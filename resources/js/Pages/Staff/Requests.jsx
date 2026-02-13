import StaffLayout from '@/Layouts/StaffLayout';
import { Head, Link } from '@inertiajs/react';

export default function Requests({ requests }) {
    return (
        <StaffLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">My Requests</h2>}
        >
            <Head title="Assigned Requests" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {requests.data.map((req) => (
                                    <tr key={req.request_id}>
                                        <td className="px-6 py-4 whitespace-nowrap">#{req.request_id}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{req.customer?.user?.name || 'Unknown'}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{req.service.service_nm}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <span className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {req.current_status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <Link href={route('staff.requests.show', req.request_id)} className="text-indigo-600 hover:text-indigo-900">Manage</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </StaffLayout>
    );
}

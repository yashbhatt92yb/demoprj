import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import { useState } from 'react';

export default function ServiceRequests({ requests, availableStaff }) {
    const { post, processing } = useForm({});
    const [selectedStaff, setSelectedStaff] = useState({});

    const handleAssign = (requestId) => {
        if (!selectedStaff[requestId]) return;

        post(route('admin.service_requests.assign', requestId), {
            data: { staff_uin: selectedStaff[requestId] },
            preserveScroll: true,
        });
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">All Service Requests</h2>}
        >
            <Head title="Service Requests" />

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
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Staff</th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {requests.data.map((req) => (
                                    <tr key={req.request_id}>
                                        <td className="px-6 py-4 whitespace-nowrap">#{req.request_id}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{req.customer?.user?.name}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">{req.service.service_nm}</td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <span className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {req.current_status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            {req.assigned_staff ? (
                                                <span className="text-green-600">{req.assigned_staff.frst_nm} {req.assigned_staff.lst_nm}</span>
                                            ) : (
                                                <select
                                                    className="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    onChange={(e) => setSelectedStaff({ ...selectedStaff, [req.request_id]: e.target.value })}
                                                    defaultValue=""
                                                >
                                                    <option value="" disabled>Select Staff</option>
                                                    {availableStaff.map(staff => (
                                                        <option key={staff.cab_staff_prfl_uin} value={staff.cab_staff_prfl_uin}>
                                                            {staff.frst_nm} {staff.lst_nm}
                                                        </option>
                                                    ))}
                                                </select>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            {!req.assigned_staff && (
                                                <PrimaryButton
                                                    onClick={() => handleAssign(req.request_id)}
                                                    disabled={processing || !selectedStaff[req.request_id]}
                                                    className="bg-indigo-600 hover:bg-indigo-700"
                                                >
                                                    Assign
                                                </PrimaryButton>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

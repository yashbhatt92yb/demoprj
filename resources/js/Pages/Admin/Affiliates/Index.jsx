import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ affiliates }) {
    return (
        <AdminLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">Affiliates</h2>
                    <Link href={route('admin.affiliates.create')} className="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add Affiliate</Link>
                </div>
            }
        >
            <Head title="Affiliates" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {affiliates.data.map((affiliate) => (
                                        <tr key={affiliate.cab_aff_uin}>
                                            <td className="px-6 py-4 whitespace-nowrap">{affiliate.user?.name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{affiliate.user?.email}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${affiliate.user?.is_vf ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                                    {affiliate.user?.is_vf ? 'Yes' : 'No'}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <Link href={route('admin.affiliates.show', affiliate.cab_aff_uin)} className="text-indigo-600 hover:text-indigo-900 mr-4">View</Link>
                                                <Link href={route('admin.affiliates.edit', affiliate.cab_aff_uin)} className="text-green-600 hover:text-green-900">Edit</Link>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

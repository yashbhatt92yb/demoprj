import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ staff }) {
    return (
        <AdminLayout
            header={
                <div className="flex justify-between items-center">
                    <h2 className="text-xl font-semibold leading-tight text-gray-800">Staff</h2>
                    <Link href={route('admin.staff.create')} className="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Add Staff</Link>
                </div>
            }
        >
            <Head title="Staff" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {staff.data.map((member) => (
                                        <tr key={member.cab_staff_prfl_uin}>
                                            <td className="px-6 py-4 whitespace-nowrap">{member.user?.name}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{member.user?.email}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{member.dept}</td>
                                            <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <Link href={route('admin.staff.show', member.cab_staff_prfl_uin)} className="text-indigo-600 hover:text-indigo-900 mr-4">View</Link>
                                                <Link href={route('admin.staff.edit', member.cab_staff_prfl_uin)} className="text-green-600 hover:text-green-900">Edit</Link>
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

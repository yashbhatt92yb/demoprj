import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ staff }) {
    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Staff Details: {staff.user?.name}</h2>}
        >
            <Head title={`Staff - ${staff.user?.name}`} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 className="text-lg font-bold mb-4">Profile Information</h3>
                        <div className="grid grid-cols-2 gap-4">
                            <p><strong>First Name:</strong> {staff.frst_nm}</p>
                            <p><strong>Last Name:</strong> {staff.lst_nm}</p>
                            <p><strong>Login Email:</strong> {staff.user?.email}</p>
                            <p><strong>Corporate Email:</strong> {staff.corp_eml}</p>
                            <p><strong>Mobile:</strong> {staff.mob}</p>
                            <p><strong>Department:</strong> {staff.dept}</p>
                            <p><strong>Designation:</strong> {staff.desig}</p>
                        </div>
                        <div className="mt-6">
                            <Link href={route('admin.staff.edit', staff.cab_staff_prfl_uin)} className="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Edit Profile</Link>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

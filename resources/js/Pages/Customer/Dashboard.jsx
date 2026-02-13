import CustomerLayout from '@/Layouts/CustomerLayout';
import { Head, Link } from '@inertiajs/react';

export default function Dashboard({ pendingRequests }) {
    return (
        <CustomerLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Customer Dashboard</h2>}
        >
            <Head title="Customer Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <h3 className="text-lg font-bold mb-4">Welcome back!</h3>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div className="bg-blue-50 p-4 rounded-lg">
                                    <h4 className="font-semibold">Pending Requests</h4>
                                    <p className="text-2xl">{pendingRequests}</p>
                                </div>
                                <div className="bg-green-50 p-4 rounded-lg flex items-center justify-center">
                                    <Link href={route('customer.requests.create')} className="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        New Service Request
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </CustomerLayout>
    );
}

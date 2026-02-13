import StaffLayout from '@/Layouts/StaffLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ assignedCount, pendingTodos }) {
    return (
        <StaffLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Staff Dashboard</h2>}
        >
            <Head title="Staff Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6 text-gray-900">
                                <h3 className="text-lg font-bold">Assigned Requests</h3>
                                <p className="text-3xl">{assignedCount}</p>
                            </div>
                        </div>
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                            <div className="p-6 text-gray-900">
                                <h3 className="text-lg font-bold">Pending Tasks</h3>
                                <p className="text-3xl">{pendingTodos}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </StaffLayout>
    );
}

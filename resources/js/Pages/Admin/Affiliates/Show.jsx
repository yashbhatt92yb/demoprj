import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';

export default function Show({ affiliate }) {
    const { transform, post: postForm, processing: formProcessing } = useForm({
        is_vf: false,
    });

    const toggleVerification = () => {
        const nextStatus = affiliate.user?.is_vf ? false : true;

        transform((data) => ({
            ...data,
            is_vf: nextStatus,
        }));

        postForm(route('admin.affiliates.verify', affiliate.cab_aff_uin));
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Affiliate Details: {affiliate.user?.name}</h2>}
        >
            <Head title={`Affiliate - ${affiliate.user?.name}`} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="text-lg font-bold">Profile Information</h3>
                            <div>
                                <span className={`px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full mr-4 ${affiliate.user?.is_vf ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                    {affiliate.user?.is_vf ? 'Verified' : 'Not Verified'}
                                </span>
                                <PrimaryButton onClick={toggleVerification} disabled={formProcessing} className={affiliate.user?.is_vf ? 'bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900' : 'bg-green-600 hover:bg-green-700 focus:bg-green-700 active:bg-green-900'}>
                                    {affiliate.user?.is_vf ? 'Revoke Verification' : 'Verify Affiliate'}
                                </PrimaryButton>
                            </div>
                        </div>

                        <div className="grid grid-cols-2 gap-4 mt-4">
                            <p><strong>First Name:</strong> {affiliate.fa_nm}</p>
                            <p><strong>Last Name:</strong> {affiliate.la_nm}</p>
                            <p><strong>Login Email:</strong> {affiliate.user?.email}</p>
                            <p><strong>Contact Email:</strong> {affiliate.eml}</p>
                            <p><strong>Mobile:</strong> {affiliate.mob}</p>
                            <p><strong>Aadhaar:</strong> {affiliate.adhr_num}</p>
                            <p><strong>PAN:</strong> {affiliate.pn_num}</p>
                        </div>
                        <div className="mt-6">
                            <Link href={route('admin.affiliates.edit', affiliate.cab_aff_uin)} className="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit Profile</Link>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

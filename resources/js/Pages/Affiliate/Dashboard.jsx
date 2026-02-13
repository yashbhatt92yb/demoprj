import AffiliateLayout from '@/Layouts/AffiliateLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ customerCount, earnings, referrals }) {
    return (
        <AffiliateLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Affiliate Dashboard</h2>}
        >
            <Head title="Affiliate Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-lg font-bold">Total Referrals</h3>
                            <p className="text-3xl">{customerCount}</p>
                        </div>
                        <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 className="text-lg font-bold">Total Earnings</h3>
                            <p className="text-3xl">₹{earnings}</p>
                        </div>
                    </div>

                    <div className="mt-8 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-lg font-bold mb-4">Recent Referrals</h3>
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                    {referrals.map((referral) => (
                                        <tr key={referral.cab_custmr_prfl_uin}>
                                            <td className="px-6 py-4 whitespace-nowrap">{referral.fa_nm} {referral.la_nm}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">{referral.eml}</td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${referral.stau === 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`}>
                                                    {referral.stau === 1 ? 'Active' : 'Inactive'}
                                                </span>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AffiliateLayout>
    );
}

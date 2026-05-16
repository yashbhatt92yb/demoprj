import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

export default function Edit({ affiliate }) {
    const { data, setData, put, processing, errors } = useForm({
        fa_nm: affiliate.fa_nm || '',
        la_nm: affiliate.la_nm || '',
        adhr_num: affiliate.adhr_num || '',
        pn_num: affiliate.pn_num || '',
        mob: affiliate.mob || '',
        eml: affiliate.eml || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('admin.affiliates.update', affiliate.cab_aff_uin));
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Edit Affiliate: {affiliate.user?.name}</h2>}
        >
            <Head title="Edit Affiliate" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <form onSubmit={submit} className="space-y-4 max-w-xl">
                            <div>
                                <InputLabel htmlFor="fa_nm" value="First Name" />
                                <TextInput
                                    id="fa_nm"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.fa_nm}
                                    onChange={(e) => setData('fa_nm', e.target.value)}
                                    required
                                />
                                <InputError message={errors.fa_nm} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="la_nm" value="Last Name" />
                                <TextInput
                                    id="la_nm"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.la_nm}
                                    onChange={(e) => setData('la_nm', e.target.value)}
                                />
                                <InputError message={errors.la_nm} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="eml" value="Contact Email" />
                                <TextInput
                                    id="eml"
                                    type="email"
                                    className="mt-1 block w-full"
                                    value={data.eml}
                                    onChange={(e) => setData('eml', e.target.value)}
                                />
                                <InputError message={errors.eml} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="mob" value="Mobile" />
                                <TextInput
                                    id="mob"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.mob}
                                    onChange={(e) => setData('mob', e.target.value)}
                                />
                                <InputError message={errors.mob} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="adhr_num" value="Aadhaar Number" />
                                <TextInput
                                    id="adhr_num"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.adhr_num}
                                    onChange={(e) => setData('adhr_num', e.target.value)}
                                />
                                <InputError message={errors.adhr_num} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="pn_num" value="PAN Number" />
                                <TextInput
                                    id="pn_num"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.pn_num}
                                    onChange={(e) => setData('pn_num', e.target.value)}
                                />
                                <InputError message={errors.pn_num} className="mt-2" />
                            </div>

                            <PrimaryButton disabled={processing}>Save Changes</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

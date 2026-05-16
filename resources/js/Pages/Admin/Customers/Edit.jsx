import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

export default function Edit({ customer }) {
    const { data, setData, put, processing, errors } = useForm({
        mob: customer.mob || '',
        eml: customer.eml || '',
        adhr_num: customer.adhr_num || '',
        pn_num: customer.pn_num || '',
        city: customer.city || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('admin.customers.update', customer.cab_custmr_prfl_uin));
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Edit Customer: {customer.user?.name}</h2>}
        >
            <Head title="Edit Customer" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <form onSubmit={submit} className="space-y-4 max-w-xl">
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
                                <InputLabel htmlFor="eml" value="Email" />
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

                            <div>
                                <InputLabel htmlFor="city" value="City" />
                                <TextInput
                                    id="city"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.city}
                                    onChange={(e) => setData('city', e.target.value)}
                                />
                                <InputError message={errors.city} className="mt-2" />
                            </div>

                            <PrimaryButton disabled={processing}>Save Changes</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

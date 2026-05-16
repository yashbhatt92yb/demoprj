import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        fa_nm: '',
        la_nm: '',
        adhr_num: '',
        pn_num: '',
        mob: '',
        eml: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('admin.affiliates.store'));
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Create Affiliate</h2>}
        >
            <Head title="Create Affiliate" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <form onSubmit={submit} className="space-y-4 max-w-xl">
                            <div>
                                <InputLabel htmlFor="name" value="System Username" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    required
                                />
                                <InputError message={errors.name} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="email" value="Login Email" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    className="mt-1 block w-full"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                />
                                <InputError message={errors.email} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="password" value="Password" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    className="mt-1 block w-full"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                />
                                <InputError message={errors.password} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="password_confirmation" value="Confirm Password" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    className="mt-1 block w-full"
                                    value={data.password_confirmation}
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    required
                                />
                                <InputError message={errors.password_confirmation} className="mt-2" />
                            </div>

                            <hr className="my-4" />

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

                            <PrimaryButton disabled={processing}>Create Affiliate</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

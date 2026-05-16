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
        frst_nm: '',
        lst_nm: '',
        corp_eml: '',
        mob: '',
        desig: '',
        dept: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('admin.staff.store'));
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Create Staff</h2>}
        >
            <Head title="Create Staff" />

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
                                <InputLabel htmlFor="frst_nm" value="First Name" />
                                <TextInput
                                    id="frst_nm"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.frst_nm}
                                    onChange={(e) => setData('frst_nm', e.target.value)}
                                    required
                                />
                                <InputError message={errors.frst_nm} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="lst_nm" value="Last Name" />
                                <TextInput
                                    id="lst_nm"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.lst_nm}
                                    onChange={(e) => setData('lst_nm', e.target.value)}
                                />
                                <InputError message={errors.lst_nm} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="corp_eml" value="Corporate Email" />
                                <TextInput
                                    id="corp_eml"
                                    type="email"
                                    className="mt-1 block w-full"
                                    value={data.corp_eml}
                                    onChange={(e) => setData('corp_eml', e.target.value)}
                                />
                                <InputError message={errors.corp_eml} className="mt-2" />
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
                                <InputLabel htmlFor="dept" value="Department" />
                                <TextInput
                                    id="dept"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.dept}
                                    onChange={(e) => setData('dept', e.target.value)}
                                />
                                <InputError message={errors.dept} className="mt-2" />
                            </div>

                            <PrimaryButton disabled={processing}>Create Staff</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

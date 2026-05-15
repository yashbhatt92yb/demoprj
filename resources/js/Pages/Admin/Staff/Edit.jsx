import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

export default function Edit({ staff }) {
    const { data, setData, put, processing, errors } = useForm({
        frst_nm: staff.frst_nm || '',
        lst_nm: staff.lst_nm || '',
        corp_eml: staff.corp_eml || '',
        mob: staff.mob || '',
        desig: staff.desig || '',
        dept: staff.dept || '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('admin.staff.update', staff.cab_staff_prfl_uin));
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Edit Staff: {staff.user?.name}</h2>}
        >
            <Head title="Edit Staff" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <form onSubmit={submit} className="space-y-4 max-w-xl">
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
                                <InputLabel htmlFor="desig" value="Designation" />
                                <TextInput
                                    id="desig"
                                    type="text"
                                    className="mt-1 block w-full"
                                    value={data.desig}
                                    onChange={(e) => setData('desig', e.target.value)}
                                />
                                <InputError message={errors.desig} className="mt-2" />
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

                            <PrimaryButton disabled={processing}>Save Changes</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

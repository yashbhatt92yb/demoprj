import CustomerLayout from '@/Layouts/CustomerLayout';
import { Head, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import { Transition } from '@headlessui/react';

export default function Create({ services }) {
    const { data, setData, post, processing, errors, recentlySuccessful } = useForm({
        service_id: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('customer.requests.store'));
    };

    return (
        <CustomerLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">New Service Request</h2>}
        >
            <Head title="New Service Request" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <form onSubmit={submit} className="mt-6 space-y-6">
                                <div>
                                    <InputLabel htmlFor="service_id" value="Select Service" />
                                    <select
                                        id="service_id"
                                        name="service_id"
                                        className="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                        value={data.service_id}
                                        onChange={(e) => setData('service_id', e.target.value)}
                                        required
                                    >
                                        <option value="">Select a service</option>
                                        {services.map((service) => (
                                            <option key={service.service_id} value={service.service_id}>
                                                {service.service_nm} - ₹{service.base_price}
                                            </option>
                                        ))}
                                    </select>
                                    <InputError className="mt-2" message={errors.service_id} />
                                </div>

                                <div className="flex items-center gap-4">
                                    <PrimaryButton disabled={processing}>Submit Request</PrimaryButton>

                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <p className="text-sm text-gray-600">Created.</p>
                                    </Transition>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </CustomerLayout>
    );
}

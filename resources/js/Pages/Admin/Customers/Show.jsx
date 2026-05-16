import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';

export default function Show({ customer, documentTypes }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        doc_typ_uin: '',
        document: null,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('admin.customers.upload_document', customer.cab_custmr_prfl_uin), {
            onSuccess: () => reset(),
        });
    };

    return (
        <AdminLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Customer Details: {customer.user?.name}</h2>}
        >
            <Head title={`Customer - ${customer.user?.name}`} />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 className="text-lg font-bold mb-4">Profile Information</h3>
                        <p><strong>Email:</strong> {customer.eml}</p>
                        <p><strong>Mobile:</strong> {customer.mob}</p>
                        <p><strong>Aadhaar:</strong> {customer.adhr_num}</p>
                        <p><strong>PAN:</strong> {customer.pn_num}</p>
                        <div className="mt-4">
                            <Link href={route('admin.customers.edit', customer.cab_custmr_prfl_uin)} className="text-indigo-600 hover:text-indigo-900">Edit Profile</Link>
                        </div>
                    </div>

                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 className="text-lg font-bold mb-4">Documents</h3>
                        {customer.documents && customer.documents.length > 0 ? (
                            <ul className="list-disc pl-5 mb-4">
                                {customer.documents.map((doc) => (
                                    <li key={doc.cab_custmr_doc_uin}>
                                        <a href={`/storage/${doc.doc_path}`} target="_blank" rel="noreferrer" className="text-blue-600 hover:underline">
                                            {doc.document_type?.doc_typ_nm || 'Document'}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        ) : (
                            <p className="mb-4">No documents uploaded.</p>
                        )}

                        <h4 className="text-md font-semibold mb-2">Upload New Document</h4>
                        <form onSubmit={submit} className="space-y-4 max-w-md">
                            <div>
                                <InputLabel htmlFor="doc_typ_uin" value="Document Type" />
                                <select
                                    id="doc_typ_uin"
                                    className="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    value={data.doc_typ_uin}
                                    onChange={(e) => setData('doc_typ_uin', e.target.value)}
                                >
                                    <option value="">Select Type</option>
                                    {documentTypes.map((type) => (
                                        <option key={type.doc_typ_uin} value={type.doc_typ_uin}>{type.doc_typ_nm}</option>
                                    ))}
                                </select>
                                <InputError message={errors.doc_typ_uin} className="mt-2" />
                            </div>

                            <div>
                                <InputLabel htmlFor="document" value="File" />
                                <input
                                    id="document"
                                    type="file"
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData('document', e.target.files[0])}
                                />
                                <InputError message={errors.document} className="mt-2" />
                            </div>

                            <PrimaryButton disabled={processing}>Upload</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}

<x-app-layout>
    <x-slot name="header">
        My Leads
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <Link modal href="{{ route('leads.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mb-4" >Add New Lead</Link>
                    <x-splade-table :for="$leads" as="$lead">
                        <x-splade-cell lead_status_id>
                            {{ $lead->lead_status->status ?? ''}}
                        </x-splade-cell>
                        <x-splade-cell action>
                            <Link modal href="{{ route('leads.edit', $lead->id) }}" class="text-blue-400 hover:text-blue-800">Edit</Link>
                            <Link
                                confirm="Delete Lead?"
                                confirm-button="Yes"
                                cancel-button="No"
                                href="{{ route('leads.destroy', $lead->id) }}"
                                class="text-red-500 hover:text-red-700"
                                method="DELETE">
                                Delete
                            </Link>
                        </x-splade-cell>
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

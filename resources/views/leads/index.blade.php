<x-app-layout>
    <x-slot name="header">
        My Leads
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white mb-5 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-form :action="route('leads.check')" method="POST">
                        @csrf
                        <x-splade-input name="phone" label="Phone Number" />
                        <button hidden="hidden" type="submit">Submit</button>
                    </x-splade-form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$leads" as="$lead">
                        <x-splade-cell lead_status_id>
                            {{ $lead->lead_status->status ?? ''}}
                        </x-splade-cell>
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

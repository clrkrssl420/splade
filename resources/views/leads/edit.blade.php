<x-app-layout>
    <x-slot name="header">
        Edit Leads
    </x-slot>
    <x-splade-modal>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mb-5 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h3 class="text-xl font-medium text-gray-900 mb-4">Edit Lead</h3>
                        <h2 class="text-3xl font-medium text-gray-900 mb-4">{{ $lead->phone }}</h2>
                        <x-splade-form :action="route('leads.update', [$lead->id] )" method="PUT" class="space-y-4" :default="$lead">
                            <x-splade-input type="hidden" name="phone" label="Phone Number"/>
                            <x-splade-textarea name="description" label="Description" autoresize/>
                            <x-splade-input type="hidden" name="user_id" />
                            <x-splade-input type="hidden" name="lead_status_id" />
                            <x-splade-select name="lead_status_id" label="Status" :options="$lead_statuses" />
                            <x-splade-submit>Update Lead</x-splade-submit>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-app-layout>
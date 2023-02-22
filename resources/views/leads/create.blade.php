<x-app-layout>
    <x-slot name="header">
        Create Leads
    </x-slot>
    <x-splade-modal>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mb-5 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h2 class="text-xl font-medium text-gray-900 mb-4">Add New Lead</h2>
                        <x-splade-form :action="route('agent.leads.store')" method="POST" class="space-y-4" :default="['user_id' => Auth::user()->id, 'lead_status_id' => '1']">
                            <x-splade-input name="phone" label="Phone Number" placeholder="Enter 11 digits company phone number" required/>
                            <x-splade-textarea name="description" label="Description" autosize required/>
                            <x-splade-input type="hidden" name="user_id" />
                            <x-splade-input type="hidden" name="lead_status_id" />
                            <x-splade-submit>Create Lead</x-splade-submit>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-app-layout>
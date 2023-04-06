<x-admin-layout>
    <x-slot name="header">
        Create Team
    </x-slot>
    <x-splade-modal>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mb-5 shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h2 class="text-xl font-medium text-gray-900 mb-4">Add New Team</h2>
                        <x-splade-form :action="route('admin.teams.store')" method="POST" class="space-y-4">
                            <x-splade-input name="team_name" label="Team Name" placeholder="Team Name" required/>
                            <x-splade-select choices name="team_leader_id" label="Team Leader" :options="$team_leaders" />
                            <x-splade-select multiple choices name="users" label="Members" :options="$users" />
                            <x-splade-submit>Add New Team</x-splade-submit>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-admin-layout>
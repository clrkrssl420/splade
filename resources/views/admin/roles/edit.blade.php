<x-admin-layout>
    <x-slot name="header">
        Edit Role
    </x-slot>
    <x-splade-modal>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mb-5 shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h3 class="text-xl font-medium text-gray-900 mb-4">Edit Role</h3>
                        <x-splade-form :default="$role" :action="route( 'admin.roles.update', [$role->id] )" method="PUT" class="space-y-4">
                            <x-splade-input name="title" label="Title"/>
                            <x-splade-select multiple relation choices name="permissions" label="Permissions" :options="$permissions"/>
                            <x-splade-submit>Update Role</x-splade-submit>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-admin-layout>
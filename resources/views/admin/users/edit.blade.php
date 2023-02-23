<x-app-layout>
    <x-slot name="header">
        Edit User
    </x-slot>
    <x-splade-modal>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mb-5 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h3 class="text-xl font-medium text-gray-900 mb-4">Edit User</h3>
                        <x-splade-form :action="route('admin.users.update', [$user->id])" method="PUT" class="space-y-4" :default="$user">
                            <x-splade-input name="name" label="Name"/>
                            <x-splade-input name="email" label="Email"/>
                            <x-splade-input name="password" label="Password" type="password"/>
                            <x-splade-checkboxes name="roles" label="Role" :options="$roles" />
                            <x-splade-submit>Update User</x-splade-submit>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-app-layout>
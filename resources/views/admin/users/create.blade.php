<x-admin-layout>
    <x-slot name="header">
        Create User
    </x-slot>
    <x-splade-modal>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mb-5 shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h2 class="text-xl font-medium text-gray-900 mb-4">Add New User</h2>
                        <x-splade-form :action="route('admin.users.store')" method="POST" class="space-y-4">
                            <x-splade-input name="name" label="Name" placeholder="Name" required/>
                            <x-splade-input name="email" label="Email" placeholder="Email" type="email" required/>
                            <x-splade-input name="password" label="Password" placeholder="Password" type="password" required />
                            <x-splade-select multiple choices name="roles" label="Role" :options="$roles" />
                            <x-splade-submit>Add User</x-splade-submit>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-admin-layout>
<x-app-layout>
    <x-slot name="header">
        Edit Permission
    </x-slot>
    <x-splade-modal>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white mb-5 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <h3 class="text-xl font-medium text-gray-900 mb-4">Edit Lead</h3>
                        <x-splade-form :action="route( 'admin.permissions.update', [$permission->id] )" method="PUT" class="space-y-4" :default="$permission">
                            <x-splade-input name="title" label="Title"/>
                            <x-splade-submit>Update Lead</x-splade-submit>
                        </x-splade-form>
                    </div>
                </div>
            </div>
        </div>
    </x-splade-modal>
</x-app-layout>
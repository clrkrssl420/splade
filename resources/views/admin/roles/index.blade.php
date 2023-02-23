<x-admin-layout>
    <x-slot name="header">
        Roles
    </x-slot>

    @can('role_create')
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Link modal href="{{ route('admin.roles.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" >Add New Role</Link> 
            </div>
        </div>
    @endcan

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$roles" as="$role" striped>
                        <x-splade-cell permissions>
                            <div class="flex flex-row flex-wrap gap-1">
                                @foreach($role->permissions as $permission)
                                    <span class="basis-1 text-transform: capitalize bg-indigo-500 px-2 py-1 rounded text-white">{{ $permission->title }}</span>
                                @endforeach
                            </div>
                        </x-splade-cell>
                        <x-splade-cell action>
                            <Link modal href="{{ route('admin.roles.edit', $role->id) }}" class="text-blue-400 mr-1 hover:text-blue-800">Edit</Link>
                            <Link
                                confirm="Delete Lead?"
                                confirm-button="Yes"
                                cancel-button="No"
                                href="{{ route('admin.roles.destroy', $role->id) }}"
                                class="text-red-500 ml-1 hover:text-red-700"
                                method="DELETE">
                                Delete
                            </Link>
                        </x-splade-cell>
                    </x-splade-table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

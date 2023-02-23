<x-admin-layout>
    <x-slot name="header">
        Users
    </x-slot>

    @can('user_create')
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Link modal href="{{ route('admin.users.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" >Add New User</Link> 
            </div>
        </div>
    @endcan

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$users" as="$user" striped>
                        <x-splade-cell role>
                            @foreach($user->roles as $roles)
                                <h3 class="text-transform: capitalize mr-2 inline-block bg-indigo-500 px-2 py-1 rounded text-white">{{ $roles->title }}</h3>
                            @endforeach
                        </x-splade-cell>
                        <x-splade-cell action>
                            <Link modal href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-400 mr-1 hover:text-blue-800">Edit</Link>
                            <Link
                                confirm="Delete User?"
                                confirm-button="Yes"
                                cancel-button="No"
                                href="{{ route('admin.users.destroy', $user->id) }}"
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
<x-admin-layout>
    <x-slot name="header">
        Teams
    </x-slot>

    @can('user_create')
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Link modal href="{{ route('admin.teams.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded" >Add New Team</Link> 
            </div>
        </div>
    @endcan

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-table :for="$teams" as="$team" striped>
                        <x-splade-cell team_leader_id>
                                {{ $team->team_leader->name ?? ''}}
                        </x-splade-cell>
                        <x-splade-cell users>
                            <div class="flex flex-row flex-wrap gap-1">
                                @foreach($team->users as $key => $user)
                                    <span class="basis-1 text-transform: capitalize bg-indigo-500 px-2 py-1 rounded text-white">{{ $user->name }}</span>
                                @endforeach
                            </div>
                        </x-splade-cell>
                        <x-splade-cell action>
                            <Link modal href="{{ route('admin.teams.edit', $team->id) }}" class="text-blue-400 mr-1 hover:text-blue-800">Edit</Link>
                            <Link
                                confirm="Delete Team?"
                                confirm-button="Yes"
                                cancel-button="No"
                                href="{{ route('admin.teams.destroy', $team->id) }}"
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
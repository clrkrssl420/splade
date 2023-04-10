<x-app-layout>
    <x-slot name="header">
        Leads
    </x-slot>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-slate-900">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-slate-900">
                    <x-splade-table :for="$leads" as="$lead" striped class="dark:bg-slate-900">
                        <x-splade-cell phone>
                            <?php 
                                $from = $lead->phone; 
                                $formatedphone = sprintf("%s-%s-%s", substr($from, 0, 3), substr($from, 3, 3), substr($from, 6)); ?>
                                <a href="tel:{{ $lead->phone }}" class="text-blue-400 hover:text-blue-800">{{ $formatedphone }}</a>
                        </x-splade-cell>
                        <x-splade-cell lead_status_id>
                            {{ $lead->lead_status->status ?? ''}}
                        </x-splade-cell>
                        <x-splade-cell user_id>
                            {{ $lead->user->name ?? ''}}
                        </x-splade-cell>
                        <x-splade-cell action>
                            <Link modal href="{{ route('agent.leads.edit', $lead->id) }}" class="text-blue-400 mr-1 hover:text-blue-800">Edit</Link>
                            <Link
                                confirm="Delete Lead?"
                                confirm-button="Yes"
                                cancel-button="No"
                                href="{{ route('agent.leads.destroy', $lead->id) }}"
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
</x-app-layout>

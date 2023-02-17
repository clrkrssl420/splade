<x-app-layout>
    <x-slot name="header">
        My Leads
    </x-slot>

    <x-splade-modal>
        <x-splade-form :action="route('chirps.store')" method="POST">
            @csrf
            <x-splade-input name="phone" label="Phone Number" />
            <x-splade-input name="description" label="Description" />
            <x-splade-input name="user_id" label="User" />
            <x-splade-input name="lead_status_id" label="Status" />

            <x-splade-errors :messages="$errors->get('message')" class="mt-2" />
            <x-splade-submit class="mt-4">{{ __('Chirp') }}</x-splade-submit>
        </x-splade-form>
    </x-splade-modal>
</x-app-layout>
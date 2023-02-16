<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Chirps') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <x-splade-form :default="$chirp" :action="route('chirps.update', $chirp)" method="PUT">
            @csrf
            <x-splade-textarea 
                name="message" 
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                autosize />
            <x-splade-errors :messages="$errors->get('message')" class="mt-2" />
            <x-splade-submit class="mt-4">{{ __('Chirp') }}</x-splade-submit>
            <x-splade-button><Link href="{{ route('chirps.index') }}">{{ __('Cancel') }}</Link></x-splade-button>
        </x-splade-form>
    </div>

</x-app-layout>

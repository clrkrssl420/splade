<x-app-layout>
    <x-slot name="header">
        My Leads
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white mb-5 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200"> 
                    @php
                        $phone = session('phone');
                    @endphp
                    <h2 class="text-3xl font-medium text-gray-900 mb-4">{{ $phone }}</h2>
                    <form action="{{ route('leads.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="phone" value="{{ $phone }}">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" id="description" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required></textarea>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="lead_status_id" value="1">
                        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add New Lead</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card-body">
        <x-splade-form method="POST" :action="route("leads.store")" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h1>{{ $phone }}</h1>
                <input type="hidden" class="form-control" placeholder="Company Phone" value="{{ $phone }}" name="phone" id="phone" />
                
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.lead.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description') }}</textarea>
                
            </div>
            <div class="form-group">

                <input class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" value="{{ Auth::user()->id }}" type="hidden" />

            </div>
            <div class="form-group">
                <input class="form-control {{ $errors->has('lead_status') ? 'is-invalid' : '' }}" name="lead_status_id" id="lead_status_id" value="1" type="hidden" />
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">save</button>
            </div>
        </x-splade-form>
    </div> --}}
</x-app-layout>
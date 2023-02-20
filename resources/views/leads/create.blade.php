<x-app-layout>
    <x-slot name="header">
        My Leads
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white mb-5 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-splade-form :default="$lead" :action="route('leads.store')" method="POST">
                        @csrf
                        <h1>{{ $p }}</h1>
                        <x-splade-input name="phone" label="Phone Number" value="phone" />
                        <x-splade-textarea 
                            name="description" 
                            label="Description"
                            autosize />
                        <x-splade-input name="user_id" label="User" />
                        <x-splade-input name="lead_status_id" label="Status" />
            
                        <x-splade-errors :messages="$errors->get('message')" class="mt-2" />
                        <x-splade-submit class="mt-4">{{ __('Chirp') }}</x-splade-submit>
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
{{-- 
    <div class="card-body">
        <form method="POST" action="{{ route("leads.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <h1>{{ $p }}</h1>
                <?php /* <label class="required" for="phone">{{ trans('cruds.lead.fields.phone') }}</label> */ ?>
                <input type="hidden" type="text" class="form-control" placeholder="Company Phone" value="{{ $phone }}" name="phone" id="phone">
                <?php /* <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required> */ ?>
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lead.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.lead.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lead.fields.description_helper') }}</span>
            </div>
            <div class="form-group">

                <input class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" value="{{ Auth::user()->id }}" type="hidden">

                <?php /*<label for="user_id">{{ trans('cruds.lead.fields.user') }}</label>

                <?php /*<select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select> -*/ ?>

                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lead.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <input class="form-control {{ $errors->has('lead_status') ? 'is-invalid' : '' }}" name="lead_status_id" id="lead_status_id" value="1" type="hidden">
                <?php /* <label for="lead_status_id">{{ trans('cruds.lead.fields.lead_status') }}</label>

                <select class="form-control select2 {{ $errors->has('lead_status') ? 'is-invalid' : '' }}" name="lead_status_id" id="lead_status_id">
                    @foreach($lead_statuses as $id => $entry)
                        <option value="{{ $id }}" {{ old('lead_status_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select> */ ?>
                @if($errors->has('lead_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lead_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.lead.fields.lead_status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div> --}}
</x-app-layout>
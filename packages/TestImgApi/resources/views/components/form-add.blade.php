<front-useradd url-add-user="{{ route('tia.create_user')}}" get-token="{{ route('tia.get_token') }}"
               :words='{"adduser": "{{ __('Add new user') }}", "send": "{{ __('Send') }}", "reset": "{{ __('Reset') }}"}'>
    <template v-slot:form-fields>
        @csrf
        @foreach($fields as $field => $v)
            @switch($v['type'])
                @case('select')
                    <div class="mb-3">
                        <label for="form_{{ $field }}"
                               class="form-label">{{ __('field.' . ($v['name'] ?? $field)) }}</label>
                        <select class="form-select" id="form_{{ $field }}"
                                name="{{ $field }}">
                            @foreach($v['data'] as $fValue => $fName)
                                <option value="{{ $fValue }}">{{ $fName }}</option>
                            @endforeach
                        </select>
                    </div>
                    @break
                @case('password')
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label for="form_{{ $field }}"
                                   class="form-label">{{ __('field.' . ($v['name'] ?? $field)) }}</label>
                            <input type="{{ $v['type'] }}" class="form-control" id="form_{{ $field }}"
                                   name="{{ $field }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="form_{{ $field }}_confirmation"
                                   class="form-label">{{ __('field.' . ($v['name'] ?? $field) . '_confirmation') }}</label>
                            <input type="{{ $v['type'] }}" class="form-control"
                                   id="form_{{ $field }}_confirmation"
                                   name="{{ $field }}_confirmation">
                        </div>
                    </div>
                    @break

                @default
                    <div class="mb-3">
                        <label for="form_{{ $field }}"
                               class="form-label">{{ __('field.' . ($v['name'] ?? $field)) }}</label>
                        <input type="{{ $v['type'] }}" class="form-control" id="form_{{ $field }}"
                               name="{{ $field }}">
                    </div>
            @endswitch
        @endforeach
    </template>
</front-useradd>

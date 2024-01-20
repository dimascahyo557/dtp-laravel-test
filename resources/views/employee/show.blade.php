@extends('template')

@section('title', __('views/employee/show.title'))

@section('control-buttons')
    <a href="{{ route('employee.index') }}" class="btn btn-secondary float-end">
        @lang('views/employee/show.button-back')
    </a>
@endsection

@section('content')
    <div id="app" class="card card-body">
        <div class="row mb-3">
            <div class="col">
                <label for="input-name" class="form-label">
                    @lang('views/employee/show.input.name')
                </label>
                <input
                    class="form-control"
                    type="text"
                    id="input-name"
                    value="{{ $employee->name }}"
                    disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="input-address" class="form-label">
                    @lang('views/employee/show.input.address')
                </label>
                <textarea
                    class="form-control"
                    id="input-address"
                    rows="2"
                    disabled>{{ $employee->address }}</textarea>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="input-id-card-number" class="form-label">
                    @lang('views/employee/show.input.id-card-number')
                </label>
                <input
                    class="form-control"
                    type="text"
                    id="input-id-card-number"
                    value="{{ $employee->id_card_number }}"
                    disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="card card-body">
                    <div class="hstack justify-content-between">
                        <h5>@lang('views/employee/show.input.education')</h5>
                    </div>
                    
                    @foreach ($employee->educations as $education)
                        <div class="row mb-3">
                            <div class="col">
                                <label for="input-school-name" class="form-label">
                                    @lang('views/employee/show.input.school-name')
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="input-school-name"
                                    value="{{ $education->school_name }}"
                                    disabled>
                            </div>
                            <div class="col">
                                <label for="input-major" class="form-label">
                                    @lang('views/employee/show.input.major')
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="input-major"
                                    value="{{ $education->major }}"
                                    disabled>
                            </div>
                            <div class="col">
                                <label for="input-entry-year" class="form-label">
                                    @lang('views/employee/show.input.entry-year')
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="input-entry-year"
                                    value="{{ $education->entry_year }}"
                                    disabled>
                            </div>
                            <div class="col">
                                <label for="input-graduation-year" class="form-label">
                                    @lang('views/employee/show.input.graduation-year')
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="input-graduation-year"
                                    value="{{ $education->graduation_year }}"
                                    disabled>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="card card-body">
                    <div class="hstack justify-content-between">
                        <h5>@lang('views/employee/show.input.work-experience')</h5>
                    </div>
                    
                    @foreach ($employee->workExperiences as $workExperience)
                        <div class="row mb-3">
                            <div class="col">
                                <label for="input-company-name" class="form-label">
                                    @lang('views/employee/show.input.company-name')
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="input-company-name"
                                    value="{{ $workExperience->company_name }}"
                                    disabled>
                            </div>
                            <div class="col">
                                <label for="input-position" class="form-label">
                                    @lang('views/employee/show.input.position')
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="input-position"
                                    value="{{ $workExperience->position }}"
                                    disabled>
                            </div>
                            <div class="col">
                                <label for="input-year" class="form-label">
                                    @lang('views/employee/show.input.year')
                                </label>
                                <input
                                    class="form-control"
                                    type="number"
                                    id="input-year"
                                    value="{{ $workExperience->year }}"
                                    disabled>
                            </div>
                            <div class="col">
                                <label for="input-description" class="form-label">
                                    @lang('views/employee/show.input.description')
                                </label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="input-description"
                                    value="{{ $workExperience->description }}"
                                    disabled>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-auto" style="width: 170px">
                <label for="input-photo" class="form-label">
                    @lang('views/employee/show.input.photo')
                </label>
                <img
                    src="{{ asset('storage/' . $employee->photo) }}"
                    alt=""
                    class="img-thumbnail d-block">
            </div>
        </div>
    </div>
@endsection
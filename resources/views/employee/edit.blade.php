@extends('template')

@section('title', __('views/employee/edit.title'))

@section('control-buttons')
    <a href="{{ route('employee.index') }}" class="btn btn-secondary float-end">
        @lang('views/employee/edit.button-back')
    </a>
@endsection

@section('content')
    <div id="app" class="card card-body">
        {{-- Flash message --}}
        <x-infos.save-data-info/>
        
        <form action="{{ route('employee.update', $employee->id) }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="input-name" class="form-label">
                        @lang('views/employee/edit.input.name')
                        <small class="text-danger">*</small>
                    </label>
                    <input class="form-control" type="text" name="name" id="input-name" value="{{ $employee->name }}" required>
                    <x-errors.error-input :errors="$errors->get('name')"/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="input-address" class="form-label">
                        @lang('views/employee/edit.input.address')
                    </label>
                    <textarea class="form-control" name="address" id="input-address" rows="2">{{ $employee->address }}</textarea>
                    <x-errors.error-input :errors="$errors->get('address')"/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="input-id-card-number" class="form-label">
                        @lang('views/employee/edit.input.id-card-number')
                        <small class="text-danger">*</small>
                    </label>
                    <input class="form-control" type="number" name="id_card_number" id="input-id-card-number" value="{{ $employee->id_card_number }}" required>
                    <x-errors.error-input :errors="$errors->get('id_card_number')"/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="card card-body">
                        <div class="hstack justify-content-between">
                            <h5>@lang('views/employee/edit.input.education')</h5>
                            <button @@click="addEducationField" type="button" class="btn btn-success fw-bold">+</button>
                        </div>
                        
                        <div v-for="(education, i) in educations" class="row mb-3">
                            <input type="hidden" :name="'educations[' + i + '][id]'" v-model="education.id">
                            <div class="col">
                                <label for="input-school-name" class="form-label">
                                    @lang('views/employee/edit.input.school-name')
                                    <small class="text-danger">*</small>
                                </label>
                                <input
                                    v-model="education.school_name"
                                    class="form-control"
                                    type="text"
                                    :name="'educations[' + i + '][school_name]'"
                                    id="input-school-name"
                                    required>
                            </div>
                            <div class="col">
                                <label for="input-major" class="form-label">
                                    @lang('views/employee/edit.input.major')
                                    <small class="text-danger">*</small>
                                </label>
                                <input
                                    v-model="education.major"
                                    class="form-control"
                                    type="text"
                                    :name="'educations[' + i + '][major]'"
                                    id="input-major"
                                    required>
                            </div>
                            <div class="col">
                                <label for="input-entry-year" class="form-label">
                                    @lang('views/employee/edit.input.entry-year')
                                    <small class="text-danger">*</small>
                                </label>
                                <input
                                    v-model="education.entry_year"
                                    class="form-control"
                                    type="text"
                                    :name="'educations[' + i + '][entry_year]'"
                                    id="input-entry-year"
                                    required>
                            </div>
                            <div class="col">
                                <label for="input-graduation-year" class="form-label">
                                    @lang('views/employee/edit.input.graduation-year')
                                    <small class="text-danger">*</small>
                                </label>
                                <input
                                    v-model="education.graduation_year"
                                    class="form-control"
                                    type="text"
                                    :name="'educations[' + i + '][graduation_year]'"
                                    id="input-graduation-year"
                                    required>
                            </div>
                            <div class="col-auto align-self-end">
                                <button @@click="removeEducationField(i)" type="button" class="btn btn-danger">-</button>
                            </div>
                        </div>
                        <x-errors.error-input :errors="$errors->get('educations.*')"/>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="card card-body">
                        <div class="hstack justify-content-between">
                            <h5>@lang('views/employee/edit.input.work-experience')</h5>
                            <button @@click="addWorkExperienceField" type="button" class="btn btn-success fw-bold">+</button>
                        </div>
                        
                        <div v-for="(workExperience, i) in workExperiences" class="row mb-3">
                            <input type="hidden" :name="'work_experience[' + i + '][id]'" v-model="workExperience.id">
                            <div class="col">
                                <label for="input-company-name" class="form-label">
                                    @lang('views/employee/edit.input.company-name')
                                    <small class="text-danger">*</small>
                                </label>
                                <input
                                    v-model="workExperience.company_name"
                                    class="form-control"
                                    type="text"
                                    :name="'work_experiences[' + i + '][company_name]'"
                                    id="input-company-name"
                                    required>
                            </div>
                            <div class="col">
                                <label for="input-position" class="form-label">
                                    @lang('views/employee/edit.input.position')
                                    <small class="text-danger">*</small>
                                </label>
                                <input
                                    v-model="workExperience.position"
                                    class="form-control"
                                    type="text"
                                    :name="'work_experiences[' + i + '][position]'"
                                    id="input-position"
                                    required>
                            </div>
                            <div class="col">
                                <label for="input-year" class="form-label">
                                    @lang('views/employee/edit.input.year')
                                    <small class="text-danger">*</small>
                                </label>
                                <input
                                    v-model="workExperience.year"
                                    class="form-control"
                                    type="number"
                                    :name="'work_experiences[' + i + '][year]'"
                                    id="input-year"
                                    required>
                            </div>
                            <div class="col">
                                <label for="input-description" class="form-label">
                                    @lang('views/employee/edit.input.description')
                                </label>
                                <input
                                    v-model="workExperience.description"
                                    class="form-control"
                                    type="text"
                                    :name="'work_experiences[' + i + '][description]'"
                                    id="input-description">
                            </div>
                            <div class="col-auto align-self-end">
                                <button @@click="removeWorkExperienceField(i)" type="button" class="btn btn-danger">-</button>
                            </div>
                        </div>
                        <x-errors.error-input :errors="$errors->get('work_experiences.*')"/>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-auto" style="width: 170px">
                    <img
                        v-if="previewPhotoUrl != null"
                        :src="previewPhotoUrl"
                        alt=""
                        class="img-thumbnail d-block">
                    <div
                        v-else
                        class="border rounded w-100 d-flex justify-content-center align-items-center text-muted"
                        style="height: 200px">
                        @lang('views/employee/edit.no-image')
                    </div>
                </div>
                <div class="col">
                    <label for="input-photo" class="form-label">
                        @lang('views/employee/edit.input.photo')
                    </label>
                    <input
                        @@change="onPhotoChange"
                        class="form-control"
                        type="file"
                        name="photo"
                        id="input-photo">
                    <x-errors.error-input :errors="$errors->get('photo')"/>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <i class="text-muted">
                        * @lang('views/employee/edit.required')
                    </i>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-warning">
                        @lang('views/employee/edit.button-update')
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        const { createApp, ref } = Vue

        createApp({
            setup() {
                const educations = ref(@json($employee->educations))
                const workExperiences = ref(@json($employee->workExperiences))
                const previewPhotoUrl = ref(@json(asset('storage/' . $employee->photo)))

                const addEducationField = () => {
                    educations.value.push({
                        id: null,
                        school_name: null,
                        major: null,
                        entry_year: null,
                        graduation_year: null,
                    });
                }
                
                const addWorkExperienceField = () => {
                    workExperiences.value.push({
                        id: null,
                        company_name: null,
                        position: null,
                        year: null,
                        description: null,
                    });
                }

                const removeEducationField = (idx) => {
                    educations.value.splice(idx, 1)
                }

                const removeWorkExperienceField = (idx) => {
                    workExperiences.value.splice(idx, 1)
                }

                const onPhotoChange = (e) => {
                    const file = e.target.files[0];
                    previewPhotoUrl.value = URL.createObjectURL(file);
                }

                return {
                    educations,
                    workExperiences,
                    previewPhotoUrl,
                    addEducationField,
                    addWorkExperienceField,
                    removeEducationField,
                    removeWorkExperienceField,
                    onPhotoChange,
                }
            }
        }).mount('#app')
    </script>
@endpush
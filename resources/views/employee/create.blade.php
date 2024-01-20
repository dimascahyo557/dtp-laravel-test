@extends('template')

@section('title', __('views/employee/create.title'))

@section('control-buttons')
    <a href="{{ route('employee.index') }}" class="btn btn-secondary float-end">
        @lang('views/employee/create.button-back')
    </a>
@endsection

@section('content')
    <div id="app" class="card card-body">
        {{-- Flash message --}}
        <x-infos.save-data-info/>

        <form action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="input-name" class="form-label">
                        @lang('views/employee/create.input.name')
                        <small class="text-danger">*</small>
                    </label>
                    <input class="form-control" type="text" name="name" id="input-name" value="{{ old('name') }}" required>
                    <x-errors.error-input :errors="$errors->get('name')"/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="input-address" class="form-label">
                        @lang('views/employee/create.input.address')
                    </label>
                    <textarea class="form-control" name="address" id="input-address" rows="2">{{ old('address') }}</textarea>
                    <x-errors.error-input :errors="$errors->get('address')"/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="input-id-card-number" class="form-label">
                        @lang('views/employee/create.input.id-card-number')
                        <small class="text-danger">*</small>
                    </label>
                    <input class="form-control" type="number" name="id_card_number" id="input-id-card-number" value="{{ old('id_card_number') }}" required>
                    <x-errors.error-input :errors="$errors->get('id_card_number')"/>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="card card-body">
                        <div class="hstack justify-content-between">
                            <h5>@lang('views/employee/create.input.education')</h5>
                            <button @@click="addEducationField" type="button" class="btn btn-success fw-bold">+</button>
                        </div>
                        
                        <div v-for="(education, i) in educations" class="row mb-3">
                            <div class="col">
                                <label for="input-school-name" class="form-label">
                                    @lang('views/employee/create.input.school-name')
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
                                    @lang('views/employee/create.input.major')
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
                                    @lang('views/employee/create.input.entry-year')
                                    <small class="text-danger">*</small>
                                </label>
                                <select
                                    v-model="education.entry_year"
                                    class="form-select"
                                    :name="'educations[' + i + '][entry_year]'"
                                    id="input-entry-year"
                                    required>
                                    @for ($i = 0; $i < 100; $i++)
                                        <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col">
                                <label for="input-graduation-year" class="form-label">
                                    @lang('views/employee/create.input.graduation-year')
                                    <small class="text-danger">*</small>
                                </label>
                                <select
                                    v-model="education.graduation_year"
                                    class="form-select"
                                    :name="'educations[' + i + '][graduation_year]'"
                                    id="input-graduation-year"
                                    required>
                                    @for ($i = 0; $i < 100; $i++)
                                        <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                                    @endfor
                                </select>
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
                            <h5>@lang('views/employee/create.input.work-experience')</h5>
                            <button @@click="addWorkExperienceField" type="button" class="btn btn-success fw-bold">+</button>
                        </div>
                        
                        <div v-for="(workExperience, i) in workExperiences" class="row mb-3">
                            <div class="col">
                                <label for="input-company-name" class="form-label">
                                    @lang('views/employee/create.input.company-name')
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
                                    @lang('views/employee/create.input.position')
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
                                    @lang('views/employee/create.input.year')
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
                                    @lang('views/employee/create.input.description')
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
                        @lang('views/employee/create.no-image')
                    </div>
                </div>
                <div class="col">
                    <label for="input-photo" class="form-label">
                        @lang('views/employee/create.input.photo')
                        <small class="text-danger">*</small>
                    </label>
                    <input
                        @@change="onPhotoChange"
                        class="form-control"
                        type="file"
                        name="photo"
                        id="input-photo"
                        required>
                    <x-errors.error-input :errors="$errors->get('photo')"/>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <i class="text-muted">
                        * @lang('views/employee/create.required')
                    </i>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        @lang('views/employee/create.button-create')
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
                const educations = ref([])
                const workExperiences = ref([])
                const previewPhotoUrl = ref(null)

                const addEducationField = () => {
                    educations.value.push({
                        school_name: null,
                        major: null,
                        entry_year: null,
                        graduation_year: null,
                    });
                }

                const addWorkExperienceField = () => {
                    workExperiences.value.push({
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

                addEducationField()
                addWorkExperienceField()

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
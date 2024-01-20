@extends('template')

@section('title', __('views/employee/index.title'))

@section('control-buttons')
    <a href="{{ route('employee.create') }}" class="btn btn-primary float-end">
        @lang('views/employee/index.button-add')
    </a>
@endsection

@section('content')
    <div class="card card-body">
        {{-- Flash message --}}
        <x-infos.save-data-info/>

        <div class="row">
            <div class="col overflow-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('views/employee/index.table-col-id')</th>
                            <th>@lang('views/employee/index.table-col-name')</th>
                            <th>@lang('views/employee/index.table-col-id-card-number')</th>
                            <th>@lang('views/employee/index.table-col-address')</th>
                            <th>@lang('views/employee/index.table-col-photo')</th>
                            <th>@lang('views/employee/index.table-col-action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->id_card_number }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>
                                    <img
                                        src="{{ asset('storage/' . $employee->photo) }}"
                                        alt="user photo"
                                        width="120">
                                </td>
                                <td>
                                    <form action="{{ route('employee.destroy', $employee->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <div class="btn-group">
                                            <a href="{{ route('employee.show', $employee->id) }}" class="btn btn-info">
                                                @lang('views/employee/index.button-detail')
                                            </a>
                                            <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-warning">
                                                @lang('views/employee/index.button-edit')
                                            </a>
                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                                onclick="return confirm('@lang('views/employee/index.promp-delete')')">
                                                @lang('views/employee/index.button-delete')
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{ $employees->links() }}
            </div>
        </div>
    </div>
@endsection
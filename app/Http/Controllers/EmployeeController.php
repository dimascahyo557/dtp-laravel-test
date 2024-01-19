<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();

            $this->employeeService->create(
                $request->input('name'),
                $request->input('id_card_number'),
                $request->file('photo'),
                $request->input('address'),
                $request->input('educations'),
                $request->input('work_experiences'),
            );

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("QueryException: " . $e->getMessage());

            return redirect()
                ->back()
                ->with('failed', __('message.store-failed'));
        }

        return redirect()
            ->action([self::class, 'index'])
            ->with('success', __('message.store-success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            DB::beginTransaction();

            $this->employeeService->update(
                $employee,
                $request->input('name'),
                $request->input('id_card_number'),
                $request->file('photo'),
                $request->input('address'),
                $request->input('educations'),
                $request->input('work_experiences'),
            );

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("QueryException: " . $e->getMessage());

            return redirect()
                ->back()
                ->with('failed', __('message.update-failed'));
        }

        return redirect()
            ->action([self::class, 'index'])
            ->with('success', __('message.update-success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            DB::beginTransaction();

            $this->employeeService->delete($employee);

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error("QueryException: " . $e->getMessage());

            return redirect()
                ->back()
                ->with('failed', __('message.destroy-failed'));
        }

        return redirect()
            ->action([self::class, 'index'])
            ->with('success', __('message.destroy-success'));
    }
}

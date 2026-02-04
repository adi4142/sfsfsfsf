<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payroll;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payrolls = Payroll::all();
        return view('payroll.index', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payroll.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:calculated,paid,approved',
        ]);

        Payroll::create([
            'period_month' => $request->period_month,
            'period_year' => $request->period_year,
            'status' => $request->status,
        ]);

        return redirect()->route('payroll.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payroll = Payroll::with(['details.employee'])->findOrFail($id);
        return view('payroll.show', compact('payroll'));
    }

    public function showDetail($detail_id)
    {
        $detail = \App\PayrollDetail::with(['employee', 'components'])->findOrFail($detail_id);
        return view('payroll.detail', compact('detail'));
    }

    public function generate($id)
    {
        $payroll = Payroll::findOrFail($id);
        $employees = \App\Employee::all();

        foreach ($employees as $employee) {
            $exists = \App\PayrollDetail::where('payroll_id', $id)->where('nip', $employee->nip)->first();
            if (!$exists) {
                \App\PayrollDetail::create([
                    'payroll_id' => $id,
                    'nip' => $employee->nip,
                    'basic_salary' => 0, // Should come from master data if available
                    'total_allowance' => 0,
                    'total_deduction' => 0,
                    'total_salary' => 0,
                ]);
            }
        }

        return redirect()->route('payroll.show', $id)->with('success', 'Data gaji karyawan berhasil digenerate.');
    }

    public function addComponent(Request $request, $detail_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction',
            'amount' => 'required|numeric|min:0',
        ]);

        $detail = \App\PayrollDetail::findOrFail($detail_id);
        
        \App\PayrollComponent::create([
            'payroll_detail_id' => $detail_id,
            'name' => $request->name,
            'type' => $request->type,
            'amount' => $request->amount,
        ]);

        // Update totals in detail
        if ($request->type == 'allowance') {
            $detail->total_allowance += $request->amount;
        } else {
            $detail->total_deduction += $request->amount;
        }
        
        $detail->total_salary = ($detail->basic_salary + $detail->total_allowance) - $detail->total_deduction;
        $detail->save();

        return back()->with('success', 'Komponen gaji berhasil ditambahkan.');
    }

    public function updateBasicSalary(Request $request, $detail_id)
    {
        $request->validate(['basic_salary' => 'required|numeric|min:0']);
        
        $detail = \App\PayrollDetail::findOrFail($detail_id);
        $detail->basic_salary = $request->basic_salary;
        $detail->total_salary = ($detail->basic_salary + $detail->total_allowance) - $detail->total_deduction;
        $detail->save();

        return back()->with('success', 'Gaji pokok berhasil diperbarui.');
    }

    public function deleteComponent($detail_id, $component_id)
    {
        $component = \App\PayrollComponent::where('payroll_detail_id', $detail_id)
                                    ->where('payroll_component_id', $component_id)
                                    ->firstOrFail();
        
        $detail = \App\PayrollDetail::findOrFail($detail_id);
        
        // Decrease totals before deleting
        if ($component->type == 'allowance') {
            $detail->total_allowance -= $component->amount;
        } else {
            $detail->total_deduction -= $component->amount;
        }
        
        $component->delete();

        // Recalculate total salary
        $detail->total_salary = ($detail->basic_salary + $detail->total_allowance) - $detail->total_deduction;
        $detail->save();

        return back()->with('success', 'Komponen gaji berhasil dihapus.');
    }

    public function editComponent($detail_id, $component_id)
    {
        $detail = \App\PayrollDetail::with('employee')->findOrFail($detail_id);
        $component = \App\PayrollComponent::where('payroll_detail_id', $detail_id)
                                    ->where('payroll_component_id', $component_id)
                                    ->firstOrFail();
        
        return view('payroll.edit_component', compact('detail', 'component'));
    }

    public function updateComponent(Request $request, $detail_id, $component_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:allowance,deduction',
            'amount' => 'required|numeric|min:0',
        ]);

        $detail = \App\PayrollDetail::findOrFail($detail_id);
        $component = \App\PayrollComponent::where('payroll_detail_id', $detail_id)
                                    ->where('payroll_component_id', $component_id)
                                    ->firstOrFail();

        // Revert old amounts from detail totals
        if ($component->type == 'allowance') {
            $detail->total_allowance -= $component->amount;
        } else {
            $detail->total_deduction -= $component->amount;
        }

        // Update component
        $component->update([
            'name' => $request->name,
            'type' => $request->type,
            'amount' => $request->amount,
        ]);

        // Add new amounts to detail totals
        if ($request->type == 'allowance') {
            $detail->total_allowance += $request->amount;
        } else {
            $detail->total_deduction += $request->amount;
        }

        // Recalculate total salary
        $detail->total_salary = ($detail->basic_salary + $detail->total_allowance) - $detail->total_deduction;
        $detail->save();

        return redirect()->route('payroll.detail', $detail_id)->with('success', 'Komponen gaji berhasil diperbarui.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editpayroll = Payroll::findOrFail($id);
        return view('payroll.edit', compact('editpayroll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'period_month' => 'required|integer|min:1|max:12',
            'period_year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:calculated,paid,approved',
        ]);

        $update = Payroll::findOrFail($id);
        $update->update([
            'period_month' => $request->period_month,
            'period_year' => $request->period_year,
            'status' => $request->status,
        ]);

        return redirect()->route('payroll.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Payroll::where('payroll_id', $id)->delete();
        return redirect()->route('payroll.index');
    }
}

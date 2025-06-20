<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $classes = Company::where('name', 'like', '%' . request('name') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.class.index', compact('classes'));
    }

    //show
    public function show($id)
    {
        $company = Company::find(1);
        return view('pages.class.show', compact('company'));
    }

    //edit
    public function edit($id)
    {
        $company = Company::find($id);
        return view('pages.class.edit', compact('company'));
    }

    //create
    public function create()
    {
        return view('pages.class.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_km' => 'required',
            'attendance_type' => 'required',
        ]);

        Company::create($request->all());

        return redirect()->route('companies.index')->with('success', 'Class created successfully');
    }

    //update
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_km' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
            'attendance_type' => 'required',
        ]);

        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_km' => $request->radius_km,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'attendance_type' => $request->attendance_type,
        ]);

        return redirect()->route('companies.show', 1)->with('success', 'Company updated successfully');
    }

    //destroy
    public function destroy($id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->delete();
            return redirect()->route('companies.index')->with('success', 'Company deleted successfully');
        }

        return redirect()->route('companies.index')->with('error', 'Company not found');
    }
}

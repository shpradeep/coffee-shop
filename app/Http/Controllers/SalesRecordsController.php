<?php

namespace App\Http\Controllers;

use App\Models\SalesRecords;
use Illuminate\Http\Request;

class SalesRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SalesRecords::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quantity'    => 'required',
            'unit_cost'   => 'required',
            'record_sale' => 'required'
        ]);

        SalesRecords::create($request->all());
        $response['status'] = 'Success';
        $response['message'] = 'Sales Record created successfully !';
        return response(json_encode($response));
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesRecords $salesRecords)
    {
        return $salesRecords;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesRecords $salesRecords)
    {
        $request->validate([
            'quantity'    => 'required',
            'unit_cost'   => 'required',
            'record_sale' => 'required'
        ]);

        $salesRecords->update($request->all());
        return response(content:'', status:200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesRecords $salesRecords)
    {
        $salesRecords->delete();
        return response(content:'', status:204);
    }
}

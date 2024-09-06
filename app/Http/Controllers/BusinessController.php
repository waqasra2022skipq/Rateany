<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Requests\BusinessCreateRequest;

class BusinessController extends Controller
{

    public function show($id)
    {
        try {
            $business = Business::where('id', $id)
                ->with(['user', 'category'])->get();

            return $this->apiSuccess('success', $business, 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function index()
    {
        try {
            $businesses = Business::with(['user', 'category'])->get();
            return $this->apiSuccess('success', $businesses, 200);
        } catch (\Throwable $th) {
            return $this->apiError('error', $th->getMessage(), 500);
        }
    }

    public function createBusiness(BusinessCreateRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $business = Business::create($validatedData);

            return $this->apiSuccess("New Business Created", $business, 201);
        } catch (\Throwable $th) {
            return $this->apiError('error', $th->getMessage(), 500);
        }
    }

    public function updateBusiness(BusinessCreateRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $business = Business::find($id);
            $business->update($validatedData);

            return $this->apiSuccess("New Business Created", $business, 201);
        } catch (\Throwable $th) {
            return $this->apiError('error', $th->getMessage(), 500);
        }
    }
}

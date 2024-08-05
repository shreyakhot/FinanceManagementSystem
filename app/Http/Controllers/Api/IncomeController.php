<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;
use App\Services\Log\LogService;

class IncomeController extends Controller
{
    private $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }
    /**
     * @OA\Post(
     *     path="/api/getIncome",
     *     summary="get income",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function index()
    {
        $this->logService->info('insede index function');
        $income = Income::where('type','income')->get();
        $this->logService->info('fetch all income successfully');
        $expense = Income::where('type','expense')->get();
        $this->logService->info('fetch all expense successfully');
        return response()->json(['income' => $income,'expense' => $expense], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/storeIncome",
     *     summary="store income",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function store(Request $request)
    {
        $this->logService->info('inside store function');

        $this->logService->info('validate request');

        $request->validate([
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'type' => 'required|string',
            'recurrence_type' => 'nullable|string', // e.g., daily, weekly, monthly
            'recurrence_end_date' => 'nullable|date',
        ]);
        $this->logService->info('request validates');
        $income = Income::create([
            'user_id' => 1,
            'amount' => $request->amount,
            'category' => $request->category,
            'type' => $request->type,
            'recurrence_type' => $request->recurrence_type,
            'recurrence_end_date' => $request->recurrence_end_date,
        ]);
        $this->logService->info('data stored');

        return response()->json(['income' => $income], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/findIncome/{id}",
     *     summary="find income",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function findIncome($id)
    {
        $this->logService->info('get income or expense by id');
        $income = Income::where('id', $id)->get();
        $this->logService->info('fetched data successfully');
        return response()->json(['income' => $income], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/updateIncome/{id}",
     *     summary="update income",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function update(Request $request, $id)
    {
        $this->logService->info('update record');

        $income = Income::findOrFail($id);
        $income->update($request->all());
        $this->logService->info('record updated successfully');

        return response()->json(['income' => $income]);
    }
    /**
     * @OA\Post(
     *     path="/api/deleteIncome/{id}",
     *     summary="delete income",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function destroy($id)
    {
        $this->logService->info('delete income or expense');
        Income::destroy($id);
        $this->logService->info('record deleted successfully');
        return response()->json(['message' => 'Income deleted successfully']);
    }
}

<?php

// app/Http/Controllers/InvestmentController.php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Services\Log\LogService;

class InvestmentController extends Controller
{
    private $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }
    /**
     * @OA\Post(
     *     path="/api/getInvestment",
     *     summary="get investment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function index()
    {
        $this->logService->info('inside index');
        $Investment = Investment::get();
        $this->logService->info('investments fetched successfully');
        return response()->json(['investment' => $Investment], 201);
    }
    /**
     * @OA\Post(
     *     path="/api/storeInvestment",
     *     summary="save investment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function store(Request $request)
    {
        $this->logService->info('inside store');
        $request->validate([
            'type' => 'required|string',
            'symbol' => 'required|string',
            'amount' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        $this->logService->info('request validate');

        $investment =Investment::create([
            'user_id'=>1,
            'type' => $request->type,
            'symbol' => $request->symbol,
            'amount' => $request->amount,
            'price' => $request->price,
        ]);
        $this->logService->info('data stored successfully');

        return response()->json($investment, 201);
    }
    /**
     * @OA\Post(
     *     path="/api/findInvestment/{id}",
     *     summary="find investment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function findInvestment($id)
    {
        $this->logService->info('get investment by id');
        $Investment = Investment::where('id', $id)->get();
        $this->logService->info('data fetched successfully');
        return response()->json(['investment' => $Investment], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/updateInvestment/{id}",
     *     summary="update investment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/

    public function update(Request $request, $id)
    {
        $this->logService->info('inside update');

        $request->validate([
            'type' => 'required|string',
            'symbol' => 'required|string',
            'amount' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        $this->logService->info('find investment');
        $investment = Investment::findOrFail($id);
        $investment->update([
            'type' => $request->type,
            'symbol' => $request->symbol,
            'amount' => $request->amount,
            'price' => $request->price,
        ]);
        $this->logService->info('investment updated successfully');

        return response()->json($investment);
    }
    /**
     * @OA\Post(
     *     path="/api/deleteInvestment/{id}",
     *     summary="delete investment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function destroy($id)
    {
        $this->logService->info('delete investment');

        $investment = Investment::findOrFail($id);
        $investment->delete();
        $this->logService->info('data deleted successfully');

        return response()->json(null, 204);
    }
    /**
     * @OA\Post(
     *     path="/api/fetchPrice",
     *     summary=fetch live price",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function fetchPrice()
    {
        $this->logService->info('inside fetch live price');
        $this->logService->info('call third party api');

        $json = file_get_contents('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=demo');
        $this->logService->info('fetched record successfully');

        return $data = json_decode($json, true);
    }
}

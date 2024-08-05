<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Services\Log\LogService;

class PortfolioController extends Controller
{
    private $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }
    /**
     * @OA\Post(
     *     path="/api/getportfolio",
     *     summary="get portfolio",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function index()
    {
        $this->logService->info('inside index');
        $portfolios = Portfolio::get();
        $this->logService->info('portfolio data fetched successfully');

        return response()->json($portfolios);
    }
    /**
     * @OA\Post(
     *     path="/api/storeportfolio",
     *     summary="save portfolio",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function store(Request $request)
    {
        $this->logService->info('inside store');

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->logService->info('data validate');

        $portfolio = Portfolio::create([
            'user_id'=>1,
            'name' => $request->name,
        ]);
        $this->logService->info('data stored');

        return response()->json($portfolio, 201);
    }
    /**
     * @OA\Post(
     *     path="/api/findportfolio/{id}",
     *     summary="find portfolio",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function show($id)
    {
        $this->logService->info('get portfolio by id');

        $portfolio = Portfolio::with('portfolios')->findOrFail($id);
        $this->logService->info('data fetched successfully');

        return response()->json($portfolio);
    }
    /**
     * @OA\Post(
     *     path="/api/updateportfolio/{id}",
     *     summary="update portfolio",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function update(Request $request, $id)
    {
        $this->logService->info('inside update');

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $this->logService->info('validated request');

        $portfolio = Portfolio::findOrFail($id);
        $portfolio->update([
            'name' => $request->name,
        ]);
        $this->logService->info('data updated successfully');

        return response()->json($portfolio);
    }
    /**
     * @OA\Post(
     *     path="/api/deleteportfolio/{id}",
     *     summary="delete portfolio",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA
     **/
    public function destroy($id)
    {
        $this->logService->info('delete portfolio');

        $portfolio = Portfolio::findOrFail($id);
        $portfolio->delete();
        $this->logService->info('data deleted successfully');

        return response()->json(null, 204);
    }
}

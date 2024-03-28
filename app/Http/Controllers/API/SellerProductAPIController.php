<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Repositories\Interfaces\SellerProductRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


class SellerProductAPIController extends Controller
{
    /**
     * @var SellerProductRepositoryInterface
     */
    protected SellerProductRepositoryInterface $productRepository;

    /**
     * @param SellerProductRepositoryInterface $productRepository
     */
    public function __construct(SellerProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return \Illuminate\Foundation\Application|Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     * @throws \Exception
     */
    public function index(): \Illuminate\Foundation\Application|Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $products = $this->productRepository->getAll();

            return Response(['status' => '200', 'products' => $products], 200);
        }catch (\Exception $e){
            Log::error('Caught Exception: '. $e);
            throw $e;
        }
    }

    /**
     * Store a newly created resources in storage
     * @param CreateProductRequest $request
     * @return \Illuminate\Foundation\Application|Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     * @throws \Exception
     */
    public function store(CreateProductRequest $request): \Illuminate\Foundation\Application|Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $result = $this->productRepository->store($request->all());

        return Response($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     * @param CreateProductRequest $request
     * @param string $productId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function update(CreateProductRequest $request, string $productId): \Illuminate\Foundation\Application|Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory//: \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|Response
    {
        $result = $this->productRepository->update($productId, $request->all());

        return Response($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $productId
     * @return Response
     */
    public function destroy(string $productId): Response
    {
        $result = $this->productRepository->delete($productId);

        return Response($result, $result['status']);
    }
}

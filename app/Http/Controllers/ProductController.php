<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     * @throws \Exception
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view('userend.index');
        }catch(\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @throws \Exception
     */
    public function show(Product $products, string $productID): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $product = $this->productRepository->show($productID);
            return view('userend.product-page', compact('product'));
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . json_encode($e->getTrace(), JSON_PRETTY_PRINT));
            throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $productAd, string $productId)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateProductRequest $request, string $productId)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $productId)
    {

    }

    /**
     * List products according to category
     * @param string $categoryId
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function categoryProductList(string $categoryId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $data = $this->productRepository->categoryProductList($categoryId);

            return view('userend.product-list', $data);
        } catch (\Exception $e) {
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . $e);
            throw $e;
        }
    }
}

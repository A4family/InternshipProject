<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\SellerProductRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;



class SellerProductController extends Controller
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
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\Foundation\Application|Application|Factory|View
     * @throws \Exception
     */
    public function index(): \Illuminate\Contracts\Foundation\Application|Factory|View|Application
    {
        try {
            $products = $this->productRepository->getAll();
            return view('userend.my-products', compact('products'));
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Excepion Details: '. $e);
            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param Category $category
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws \Exception
     */
    public function create(Category $category): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $parentCategory = $category->whereNull('parent_id')->paginate(10);
            return view('userend.create-product', compact('parentCategory'));
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception details: ' . json_encode($e->getTrace(), JSON_PRETTY_PRINT));
            throw $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param CreateProductRequest $request
     * @return RedirectResponse
     */
    public function store(CreateProductRequest $request): RedirectResponse
    {
        $result = $this->productRepository->store($request->all());

        if ($result['status'] === 200) {
            return redirect()->back()->with('message', $result['message']);
        }

        return redirect()->back()->with('message', $result['message']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param Product $productAd
     * @param string $productId
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     * @throws \Exception
     */
    public function edit(Product $product, string $productId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $productDetails = $product->with('tags')->find($productId);
            $subSubCategory = $productDetails->category;
            $subCategory = $productDetails->parentCategory;
            $parentCategory = $productDetails->grandParentCategory;
            return view('userend.edit-product', compact('productDetails', 'subSubCategory', 'subCategory', 'parentCategory'));
        }catch (\Exception $e){
            Log::error('Caught Exception: ' . $e->getMessage());
            Log::error('Exception Details: ' . $e);
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     * @param CreateProductRequest $request
     * @param string $productId
     * @return RedirectResponse
     */
    public function update(CreateProductRequest $request, string $productId): RedirectResponse
    {
        $result = $this->productRepository->update($productId, $request->all());

        if ($result['status'] === 200) {
            return redirect(route('my-product-ads'))->with('message', $result['message']);
        } else {
            return redirect(route('my-products-ads'))->with('message', $result['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $productId
     * @return RedirectResponse
     */
    public function destroy(string $productId): RedirectResponse
    {
        $result = $this->productRepository->delete($productId);

        if ($result['status'] === 200) {
            return redirect()->back()->with('message', $result['message']);
        } else {
            return redirect()->back()->withErrors(['message' => $result['message']]);
        }
    }
}

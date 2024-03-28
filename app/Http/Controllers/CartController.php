<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CartItemsRequest;
use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Http\Request;
use function Termwind\renderUsing;

class CartController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    protected CartRepositoryInterface $cartRepository;

    /**
     * @param CartRepositoryInterface $cartRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Display a listing of the resource.
     * @param string $userId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(string $userId): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cartItems = $this->cartRepository->showCartItems($userId);
        $totalAmount = $cartItems->sum('amount');
        return view('userend.cart-items', compact('cartItems', 'totalAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param CartItemsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CartItemsRequest $request): \Illuminate\Http\RedirectResponse
    {
        if ($this->cartRepository->store($request->all())){
            return redirect()->back()->with('message', 'Product Added to Cart.');
        }
        return redirect()->back()->with('message', 'Product failed to add!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param CartItemsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CartItemsRequest $request)
    {
        if ($this->cartRepository->updateQuantity($request->all())){
            return redirect()->back()->with('message', 'Quantity Updated.');
        }

        return redirect()->back()->with('message', 'Quantity Update Failed.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'cart_id' => 'required'
        ]);
        if ($this->cartRepository->removeFromCart($validated['cart_id'])){
            return redirect()->back()->with('message', 'Removed from cart.');
        }
        return redirect()->back()->with('message', 'Could not remove.');
    }
}

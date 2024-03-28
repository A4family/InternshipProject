<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function showCartItems(string $userId);
    public function store(array $data);
    public function updateQuantity(array $data);
    public function removeFromCart(string $cartId);
}

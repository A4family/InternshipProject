<?php

namespace App\Repositories\Interfaces;

interface CheckoutRepositoryInterface
{
    public function getCheckoutProducts(string $productId);
}

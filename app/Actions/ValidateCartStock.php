<?php

namespace App\Actions;

use App\Contract\CartServiceInterface;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\Product;

class ValidateCartStock
{
    use AsAction;


public function __construct(
    public CartServiceInterface $cart
)
{

}

public function handle()
{
    $insufficient = [];

    foreach($this->cart->all()->items as $item) {
                    /**  @var ProductData $product  */

        $product = $item->product();

        if (!$product || $product->stock < $item->quantity) {
            $insufficient[] = [
                'sku'=> $product->sku ?? $item->sku,
                'name'=> $product->name ?? "Unknown",
                'requested'=>$item->quantity,
                'available'=>$product?->stock ?? 0,
            ];
        }
    }

    if ($insufficient) {
        throw ValidationException::withMessages([
            'cart' => 'Some Product is insufficient stock',
            'details' => $insufficient
            ]);
        }
    }
}
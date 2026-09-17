<?php

namespace App\Http\Controllers;

use App\Services\Cart\CartService;
use App\Services\Cart\CartViewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Lunar\Models\CartLine;
use Lunar\Models\ProductVariant;
use InvalidArgumentException;


class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CartViewService $cartViewService,
    ) {}

    /**
     * Mostrar la página completa del carrito.
     */
    public function index(): View
    {
        return view('cart.index', [
            'cart' => $this->cartViewService->get(),
        ]);
    }

    /**
     * Obtener el carrito actual en formato JSON.
     *
     * Lo utiliza Alpine.js para actualizar
     * el contador y el mini carrito.
     */
    public function data(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'cart' => $this->cartViewService->get(),
        ]);
    }

    /**
     * Agregar una variante al carrito.
     */
    /**
     * Agregar una variante al carrito.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([

            'variant_id' => [
                'required',
                'integer',
                'exists:lunar_product_variants,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'meta' => [
                'nullable',
                'array',
            ],

        ]);


        try {

            $variant = ProductVariant::query()
                ->findOrFail(
                    $validated['variant_id']
                );


            $this->cartService->addProduct(

                variant: $variant,

                quantity: $validated['quantity'],

                meta: $validated['meta'] ?? [],

            );


            return response()->json([

                'success' => true,

                'message' =>
                'Producto agregado al carrito.',

                'cart' =>
                $this->cartViewService->get(),

            ]);
        } catch (InvalidArgumentException $e) {

            return response()->json([

                'success' => false,

                'message' => $e->getMessage(),

            ], 422);
        }
    }

    /**
     * Actualizar la cantidad de una línea.
     */
    public function update(
        Request $request,
        CartLine $line
    ): JsonResponse {
        $validated = $request->validate([
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $this->ensureLineBelongsToCurrentCart($line);

        $this->cartService->updateQuantity(
            lineId: $line->id,
            quantity: $validated['quantity'],
        );

        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada.',
            'cart' => $this->cartViewService->get(),
        ]);
    }

    /**
     * Eliminar una línea del carrito.
     */
    public function destroy(
        CartLine $line
    ): JsonResponse {
        $this->ensureLineBelongsToCurrentCart($line);

        $this->cartService->remove($line->id);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito.',
            'cart' => $this->cartViewService->get(),
        ]);
    }

    /**
     * Vaciar completamente el carrito.
     */
    public function clear(): JsonResponse
    {
        $this->cartService->clear();

        return response()->json([
            'success' => true,
            'message' => 'Carrito vaciado.',
            'cart' => $this->cartViewService->get(),
        ]);
    }

    /**
     * Verifica que la línea pertenezca
     * al carrito actual.
     *
     * Evita que alguien modifique
     * una línea perteneciente a otro carrito.
     */
    protected function ensureLineBelongsToCurrentCart(
        CartLine $line
    ): void {
        $cart = $this->cartService->current();

        abort_unless(
            $cart &&
                $line->cart_id === $cart->id,
            404
        );
    }
}

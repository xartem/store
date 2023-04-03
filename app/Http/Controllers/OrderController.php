<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use Domain\Order\Actions\NewOrderAction;
use Domain\Order\DTOs\NewOrderDTO;
use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Domain\Order\Processes\AssignCustomer;
use Domain\Order\Processes\AssignProducts;
use Domain\Order\Processes\ChangeStateToPending;
use Domain\Order\Processes\CheckProductQuantity;
use Domain\Order\Processes\ClearCart;
use Domain\Order\Processes\DecreaseProductsQuantities;
use Domain\Order\Processes\OrderProcess;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $items = cart()->items();

        if ($items->isEmpty()) {
            throw new DomainException('Cart is empty');
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
        ]);
    }

    public function handle(OrderFormRequest $request, NewOrderAction $newOrderAction): RedirectResponse
    {
        $orderDto = NewOrderDTO::fromRequest($request);

        $order = $newOrderAction($orderDto);

        (new OrderProcess($order))
            ->processes([
                new CheckProductQuantity(),
                new AssignCustomer($orderDto),
                new AssignProducts(),
                new ChangeStateToPending(),
                new DecreaseProductsQuantities(),
                new ClearCart(),
            ])
            ->run();

        return redirect()->route('home');
    }
}

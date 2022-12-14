<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Models\Order;
use App\Models\StatusList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class OrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|string
     */
    public function index(): View|Factory|string|Application
    {
        $this->canSee('orders');

        $orders = Order::query()
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->paginate(7);

        $statuses = StatusList::all();

        // ajax pagination
        if(request()->ajax()){
            return view('admin.order.ajax.pagination',
                compact('orders', 'statuses')
            )->render();
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.order.index', [
            'orders' => $orders,
            'statuses' => $statuses,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Get the breadcrumbs array
     *
     * @return array[]
     */
    protected function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();

        $breadcrumbs[] = ["Замовлення"];

        return $breadcrumbs;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id): View|Factory|Response|Application
    {
        $this->canEdit('orders');

        $order = Order::query()->find($id);

        if(!$order){
           abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('orders',false));

        return view('admin.order.edit',[
            'statuses'      => StatusList::all(),
            'order'         => $order,
            'items'         => $order->items,
            'breadcrumbs'   => $this->breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(OrderRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEdit('orders');

        $order = Order::query()->find($id);

        if(!$order){
            abort(404);
        }

        $delivering_status = StatusList::getOneBySeoName('delivering');

        // if product is in delivering status - decrease product counts of sizes
        if($delivering_status && $request->get('status') == $delivering_status->id){

            $order->updateProductsProperties();

            $order->user->updateOrdersStatistic($order->total_cost);

            // check conditions and giving a promocode for user
            $order->user->checkAndGiveManyOrdersPromocode();
        }

        $request->merge([
            'address'         => $request->get('address') ?? null,
            'post_department' => $request->get('post_department') ?? null,
        ]);

        $order->update($request->all());

        return redirect('/admin/orders')->with(['success-message' => 'Замовлення успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id): Redirector|RedirectResponse|Application
    {
        $this->canDelete('orders');

        $order = Order::query()->find($id);

        if(!$order){
            abort(404);
        }

        $order->delete();

        return redirect("/admin/orders")->with(['success-message' => 'Замовлення успішно видалено.']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Spatie\Permission\Models\Role;

class UserController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|string
     */
    public function index(): View|Factory|string|Application
    {
        $this->canEverything();

        $users = User::query()->orderBy('id','asc')->paginate(2);

        // ajax pagination
        if(request()->ajax()){
            return view('admin.user.ajax.pagination', compact('users'))->render();
        }

        $this->setBreadcrumbs($this->getBreadcrumbs());

        return view('admin.user.index', [
            'users' => $users,
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

        $breadcrumbs[] = ["Користувачі"];

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
        $this->canEverything();

        $user = User::query()->find($id);

        if(!$user){
            abort(404);
        }

        $this->setBreadcrumbs($this->getCreateOrEditPageBreadcrumbs('users',false));

        return view('admin.user.edit',[
            'selected_user' => $user,
            'roles' => Role::all(),
            'arRoles' => $arRoles ?? null,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UserRequest $request, int $id): Redirector|RedirectResponse|Application
    {
        $this->canEverything();

        $user = User::query()->find($id);

        if(!$user){
            abort(404);
        }

        $request->setActiveField();

        $user->syncRoles($request->get('roles'));

        $request->merge([
            'is_admin' => $user->hasAnyAdminRole() === true
        ]);

        $user->update($request->all());

        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно змінено.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($id): Redirector|RedirectResponse|Application
    {
        $this->canEverything();

        $user = User::query()->find($id);

        if(!$user){
            abort(404);
        }

        $user->delete();

        return redirect('/admin/users')->with(['success-message' => 'Користувача успішно видалено.']);
    }
}

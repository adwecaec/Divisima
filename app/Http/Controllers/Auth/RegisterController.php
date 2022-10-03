<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\Cart;
use App\Models\Promocode;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
    }

    /**
     * Registration page
     *
     * @return Application|Factory|View
     */
    public function showRegistrationForm(): View|Factory|Application
    {
        return view('pages.auth.register');
    }

    /**
     * Registration request
     *
     * @param RegistrationRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function toRegister(RegistrationRequest $request): Redirector|RedirectResponse|Application
    {
        //   Создаем юзера
        $user = User::query()->create($request->all());

        //   Создание корзины
        $user->createCart();

        // выдаем промокод
        $this->setPromocode($user);

        Auth::loginUsingId($user->id);

        return redirect('/shop/women');
    }

    /**
     * Выдача промокода юзеру
     *
     * @param Model $user
     * @return void
     */
    private function setPromocode(Model $user): void
    {
        $promocode = Promocode::where('promocode', 'special-for-reg-user')->first();

        $user->promocodes()->attach($promocode->id, [
            'user_id' => $user->id,
            'user_promocode_id' => $promocode->id
        ]);
    }
}

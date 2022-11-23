<?php

namespace Controller;

use Model\Product;
use Model\User;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class Api
{
    public function index(): void
    {
        $posts = Product::all()->toArray();
        (new View())->toJSON($posts);
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function signup(Request $request)
    {
        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'login' => ['required', 'unique:users,login'],
            'password' => ['required']
        ], [
            'required' => 'Поле :field пусто',
            'unique' => 'Поле :field должно быть уникально'
        ]);

        if ($validator->fails()) {
            (new View())->toJSON(['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
        }

        if (User::create($request->all())) {
            (new View())->toJSON(['message' => "Пользователь создан"]);
        }
    }

    public function login(Request $request)
    {
        if(app()->auth->attempt($request->all())){
            app()->auth->generateToken();
        }
    }
}

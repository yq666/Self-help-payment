<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\PasswordRequest;
use App\Http\Requests\Api\PaymentPasswordRequest;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Dingo\Api\Http\Request;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $user = User::create([
            'student_id' => $request->student_id,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'nickname' => $request->student_id,
            'avatar' => 'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
        ]);

        return $this->response->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($user),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }

    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }

    public function reset(Request $request)
    {
        $user = \Auth::user();

        $validatedData = $request->validate([
            'password' => 'required|min:6|string',
            'new_password' => 'required|min:6|string',
        ]);

        if(! \Hash::check($validatedData['password'], $user->password)){
            $data = [
                'message' => '用户密码错误',
                'status_code' => '403',
            ];
            return $this->response->array($data)->setStatusCode(403);
        }

        $user->password = bcrypt($validatedData['new_password']);
        $user->update();

        return $this->response->noContent();
    }

    public function resetDorm(Request $request)
    {
        $validatedData = $request->validate([
            'dorm_id' => 'required|integer',
        ],[
            'dorm_id.required' => '请完善宿舍 id',
            'dorm_id.integer' => '宿舍 id 应为整型',
        ]);

        $user = \Auth::user();
        $user->dormitory_id = $validatedData['dorm_id'];
        $user->update();

        return $this->response->noContent();
    }

    public function resetNickname(Request $request)
    {
        $validatedData = $request->validate([
            'nickname' => 'required',
        ],[
            'nickname.required' => '请完善昵称',
        ]);

        $user = \Auth::user();
        $user->nickname = $validatedData['nickname'];
        $user->update();

        return $this->response->noContent();
    }

    public function paymentPassword(PaymentPasswordRequest $request)
    {

        if(\Auth::user()->payment_password == md5($request->payment_password)){
            return $this->response->noContent();
        }else{
            $data = [
                'message' => '支付密码错误',
                'status_code' => '403',
            ];

            return $this->response->array($data)->setStatusCode(403);
        }
    }

    public function resetPaymentPassword(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required',
            'payment_password' => 'required',
        ]);
        $user = \Auth::user();


        if(! \Hash::check($validateData['password'], $user->password)){
            $data = [
                'message' => '用户密码错误',
                'status_code' => '403',
            ];
            return $this->response->array($data)->setStatusCode(403);
        }
        $user->payment_password = md5($validateData['payment_password']);
        $user->save();

        return $this->response->noContent();
    }
}

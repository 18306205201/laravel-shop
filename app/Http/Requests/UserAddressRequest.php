<?php

namespace App\Http\Requests;

class UserAddressRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'province'      => ['required'],
            'city'          => ['required'],
            'district'      => ['required'],
            'address'       => ['required'],
            'contact_name'  => ['required'],
            'contact_phone' => ['required'],
            'zip'           => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'province'      => '省',
            'city'          => '市',
            'district'      => '区县',
            'address'       => '详细地址',
            'contact_name'  => '姓名',
            'contact_phone' => '联系电话',
            'zip'           => '邮编',
        ];
    }
}

<?php

namespace TestImgApi\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Illuminate\View\View;
use TestImgApi\Models\Position;
use TestImgApi\TestImgApiServiceProvider;

class FormAdd extends Component
{
    public function render(): View
    {
        $fields = [
            'name' => ['type' => 'text'],
            'email' => ['type' => 'email'],
            'phone' => ['type' => 'text'],
            'position_id' => ['type' => 'select', 'data' => $this->getPositionsList()],
//            'password' => ['type' => 'password'],
//            'firstname' => ['type' => 'text'],
//            'lastname' => ['type' => 'text'],
//            'address' => ['type' => 'text'],
            'photo' => ['type' => 'file'],
        ];

        return view(TestImgApiServiceProvider::PREFIX_PACKAGE . '::components.form-add', [
            'fields' => $fields,
        ]);
    }

    protected function getPositionsList(): array
    {
        return Cache::remember(__CLASS__ . __METHOD__, 120, function () {
           return Position::get()->pluck('title', 'id')->toArray();
        });
    }
}

<?php

namespace TestImgApi\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use TestImgApi\Contracts\UsersDataInterface;
use TestImgApi\TestImgApiServiceProvider;

class TableShow extends Component
{
    public function render(): View
    {
        return view(TestImgApiServiceProvider::PREFIX_PACKAGE . '::components.table-show', [
            'items' => resolve(UsersDataInterface::class)->getByPaginate(request()->input('page', 1), config('tia.defaultFrontPerPage')),
        ]);
    }
}

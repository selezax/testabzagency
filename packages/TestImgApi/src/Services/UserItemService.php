<?php

namespace TestImgApi\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use TestImgApi\Contracts\ImageInterface;
use TestImgApi\Contracts\UserItemInterface;
use TestImgApi\Models\UserInfo;
use TestImgApi\Models\Users;

/**
 * @props int id
 * @props string name
 * @props string email
 * @props string created_at
 * @props string firstname
 * @props string lastname
 * @props int position_id
 * @props string position
 * @props string address
 * @props string photo
 * @props string phone
 */
class UserItemService implements UserItemInterface
{
    protected  $item;

    public function __construct($item = null)
    {
        $this->item = $item;
    }

    public function findUserByItem(int $id)
    {
        $this->item = Users::findOrFail($id);
        return $this;
    }

    public function registerUser(array $data)
    {
        $this->chkUniqData($data);

        DB::transaction(function () use ($data) {

            $photo = Arr::get($data, 'photo') instanceof UploadedFile ? $this->uploadImage($data['photo']) : null;

            $this->item = Users::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make(($data['password']) ?? $data['name']),
            ]);

            $info = new UserInfo([
                'firstname' => Arr::get($data, 'firstname', null),
                'lastname' => Arr::get($data, 'lastname', null),
                'position_id' => Arr::get($data, 'position_id', null),
                'address' => Arr::get($data, 'address', null),
                'phone' => Arr::get($data, 'phone', null),
                'photo' => $photo,
            ]);

            $this->item->info()->save($info);
        });

        return true;
    }

    public function getItem(): mixed
    {
        return $this->item;
    }

    public function __get(string $name)
    {
        if (!isset($this->item)) {
            return 'undefined';
        }

        return match ($name) {
            'id', 'name', 'email', 'created_at' => $this->item?->$name ?? '',
            'created_at_format' => $this->item?->created_at->format('d.m.Y') ?? '',
            'firstname', 'lastname', 'position_id', 'address', 'photo', 'phone' => $this->item->info?->$name ?? '',
            'position' => $this->item->info?->position?->title ?? '',
            default => 'undefined',
        };
    }

    protected function uploadImage($file){
        $image = resolve(ImageInterface::class);
        return $image->uploadImage($file)
            ->cropImage()
            ->optimizeImage()
            ->optimized;
    }

    protected function chkUniqData($data){
        if (
            Users::query()
                ->where('email', $data['email'])
                ->orWhereHas('info', function ($query) use ($data) {
                    $query->where('phone', $data['phone']);
                })
                ->exists()
        ) {
            throw new RuntimeException('User with this phone or email already exist', 409);
        }
        return true;
    }
}

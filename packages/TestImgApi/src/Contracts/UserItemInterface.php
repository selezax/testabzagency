<?php

namespace TestImgApi\Contracts;

interface UserItemInterface
{
    public function getItem(): mixed;
    public function registerUser(array $data);
    public function findUserByItem(int $id);
}

<?php

namespace App\Repositories\Contracts;

interface NewsRepositoryInterface
{
    public function fetchNews($from);
}
<?php
namespace App\Storage;

use Illuminate\Support\Facades\DB;

class DatabaseStorage implements StorageInterface
{
    public function store(array $data)
    {
        DB::table('items')->insert($data);
    }
}

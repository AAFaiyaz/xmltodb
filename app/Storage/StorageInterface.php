<?php

namespace App\Storage;

interface StorageInterface
{
    public function store(array $data);
}
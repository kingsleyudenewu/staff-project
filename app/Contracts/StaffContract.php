<?php


namespace App\Contracts;


interface StaffContract
{
    public function all();
    public function create(array $request);
    public function update($request, $id);
    public function find($id);
    public function search($request);
}

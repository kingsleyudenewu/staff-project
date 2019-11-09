<?php


namespace App\Repositories;


use App\Contracts\StaffContract;
use App\Staff;

class StaffRepository implements StaffContract
{
    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function all(){
        return $this->staff->paginate();
    }
    public function create(array $request){
        return $this->staff->create($request);
    }
    public function update($request, $id){
        return $this->find($id)->update($request);
    }
    public function search($request){
        return $this->staff->where(function ($q) use ($request){
           $q->where('name', 'LIKE', '%'.$request->search.'%')
               ->orWhere('email', 'LIKE', '%'.$request->search.'%')
               ->orWhere('phone', 'LIKE', '%'.$request->search.'%');
        })
            ->first();
    }

    public function find($id)
    {
        return $this->staff->findOrFail($id);
    }
}

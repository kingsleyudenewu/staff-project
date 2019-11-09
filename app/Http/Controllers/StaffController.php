<?php

namespace App\Http\Controllers;

use App\Contracts\StaffContract;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController extends BaseController
{
    protected $staff;
    public function __construct(StaffContract $staff)
    {
        $this->staff = $staff;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = $this->staff->all();
        return $this->sendResponse($staffs, 'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:staffs,name',
            'phone' => 'required',
            'email' => 'required',
        ]);
        if($validate->fails())
        {
            return $this->sendError('Operation failed',$validate->errors(), 422);
        }

        $data = $this->staff->create($request);
        if ($data) return $this->sendResponse($data, 'success');
        return $this->sendError('Staff Not Found');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        $data = $this->staff->find($staff->id);
        if ($data) return $this->sendResponse($data, 'success');
        return $this->sendError('Staff Not Found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:staffs,name,'.$staff->id,
            'phone' => 'required',
            'email' => 'required',
        ]);
        if($validate->fails())
        {
            return $this->sendError('Operation failed',$validate->errors(), 422);
        }

        $data = $this->staff->update($request, $staff->id);
        if ($data) return $this->sendResponse($data, 'success');
        return $this->sendError('Staff Not Found');
    }

    public function search(Request $request)
    {
        if (is_null($request->search) || empty($request->search))return $this->sendError('Staff Not Found');
        $data = $this->staff->search($request->search);
        if ($data) return $this->sendResponse($data, 'success');
        return $this->sendError('Staff Not Found');
    }
}

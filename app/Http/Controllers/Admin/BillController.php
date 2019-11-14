<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BillRepository;

class BillController extends Controller
{
    /**
     *  账单仓库
     */
    protected $bill;

    /**
     *  实例化仓库 
     */
    public function __construct(BillRepository $bill)
    {
        $this->bill = $bill;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereData = [
            'userAccount' => !empty($request->get('userAccount'))?trim($request->get('userAccount')):'',
            'borrow_start' => !empty($request->get('borrow_start'))?trim($request->get('borrow_start')):'',
            'borrow_end' => !empty($request->get('borrow_end'))?trim($request->get('borrow_end')):'',
            'status' => !empty($request->get('status'))?trim($request->get('status')):'',
        ];
        $pathinfo = $this->bill->CommonPathInfo();
        $bills = $this->bill->bills($whereData);
        //dump($whereData);
        return view('admin.bill.index',compact('pathinfo','bills','whereData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

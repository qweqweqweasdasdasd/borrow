<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PandectRepository;

class PandectController extends Controller
{
    /**
     *  账单仓库
     */
    protected $pandect;

    /**
     *  实例化仓库 
     */
    public function __construct(PandectRepository $pandect)
    {
        $this->pandect = $pandect;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $whereData = $this->requestInit($request->all());

        $pathinfo = $this->pandect->CommonPathInfo();
        $pandects = $this->pandect->pandects($whereData);

        //dump($pandects);
        return view('admin.pandect.index',compact('pathinfo','pandects','whereData'));
    }

    public function requestInit($d)
    {   
       if(!empty($d['apply_time'])){
            list($apply_start,$apply_end) = explode('~', $d['apply_time']);
            $whereData['apply_start'] = $apply_start;
            $whereData['apply_end'] = $apply_end;
            $whereData['apply_time'] = $d['apply_time'];
        }else{
            $whereData['apply_time'] = '';
        }

        if(!empty($d['repayment_time'])){
            list($repayment_start_t,$repayment_end_t) = explode('~', $d['repayment_time']);
            $whereData['repayment_start_t'] = $repayment_start_t;
            $whereData['repayment_end_t'] = $repayment_end_t;
            $whereData['repayment_time'] = $d['repayment_time'];
        }else{
            $whereData['repayment_time'] = '';
        }
        
        $whereData['userAccount'] = !empty($d['userAccount']) ? trim($d['userAccount']) : '';
        $whereData['borrow_start'] = !empty($d['borrow_start']) ? trim($d['borrow_start']) : '';
        $whereData['borrow_end'] = !empty($d['borrow_end']) ? trim($d['borrow_end']) : '';
        $whereData['repayment_start'] = !empty($d['repayment_start']) ? trim($d['repayment_start']) : '';
        $whereData['repayment_end'] = !empty($d['repayment_end']) ? trim($d['repayment_end']) : '';

        return $whereData;
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
        dd($request->all());
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

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;

class MemberController extends Controller
{
    /**
     *  角色仓库
     */
    protected $member;

    /**
     * 初始化仓库
     */
    public function __construct(MemberRepository $member)
    {
        $this->member = $member;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $whereData = [
            'userAccount' => !empty($request->get('userAccount'))?$request->get('userAccount'):'',
            'userName' => !empty($request->get('userName'))?$request->get('userName'):'',
            'telephone' => !empty($request->get('telephone'))?$request->get('telephone'):'',
        ];
        $pathinfo = $this->member->CommonPathInfo();
        $members = $this->member->members($whereData);
        
        foreach ($members as $k => $v) {
            $v->telephone = substr_replace($v->telephone,'****',3,4);
        }
        //dump($members);
        return view('admin.member.index',compact('pathinfo','members','whereData'));
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

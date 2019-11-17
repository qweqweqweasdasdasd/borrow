@extends('admin/common/layout')

@section('content')
    <body>
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="#">{{$pathinfo['module']}}</a>
                <a href="#">{{$pathinfo['contr']}}</a>
                <a>
                    <cite>{{$pathinfo['method']}}</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form class="layui-form layui-col-space5" id="table">
                            	<div class="layui-input-inline layui-show-xs-block">
                                    <select name="status">
                                        <option value="">账单状态</option>
                                        <option value="1" @if($whereData['status'] == 1) selected @endif>待申请</option>
                                        <option value="2" @if($whereData['status'] == 2) selected @endif>借款成功</option>
                                        <option value="3" @if($whereData['status'] == 3) selected @endif>借款失败</option>
                                        <option value="4" @if($whereData['status'] == 4) selected @endif>待还款</option>
                                        <option value="5" @if($whereData['status'] == 5) selected @endif>还款成功</option>
                                        <option value="6" @if($whereData['status'] == 6) selected @endif>还款失败</option>
                                    </select>
                                </div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="userAccount" placeholder="会员账号" autocomplete="off" class="layui-input" value="{{$whereData['userAccount']}}">
                                </div>  

                                
							    <div class="layui-input-inline" style="width: 120px;">
							      <input type="text" name="borrow_start" placeholder="借款总额" autocomplete="off" class="layui-input" value="{{$whereData['borrow_start']}}">
							    </div>
							    -
							    <div class="layui-input-inline" style="width: 120px;">
							      <input type="text" name="borrow_end" placeholder="借款总额" autocomplete="off" class="layui-input" value="{{$whereData['borrow_end']}}">
							    </div>
							  
					
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="search">
                                       查询</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="layui-card-body">
                            <table class="layui-table layui-form">
                                <thead>

                                    <tr>  
                                        <th>ID</th>
                                        <th>会员账号</th>
                                        <th>真实姓名</th>
                                        <th>VIP名</th>
                                        <th>申请时间</th>
                                        <th>还贷时间</th>
                                        <th>借款金额</th>
                                       	<th>状态</th>
                                        <th>备注</th>
                                        <th>操作</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach($bills as $v) 
                                    <tr>
                                        <td>{{$v->b_id}}</td>
                                        <td>{{$v->userAccount}}</td>
                                        <td>{{$v->userName}}</td>
                                        <td>{{$v->vipName}}</td>
                                        <td>{{$v->apply_time}}</td>
                                        <td>{{$v->repayment_time}}</td>
                                        <td>{{$v->borrow_money}}</td>
                                        <td>{!! bill_show_status($v->status) !!}</td>
                                        <td>{{$v->desc}}</td>
                                        <td class="td-manage">
                                            @if($v->status == 1)
                                            <a title="申请借款" class="layui-btn layui-btn-xs" onclick="member_del(this,'{{$v->b_id}}')" href="javascript:;">申请借款</a>
                                            @endif
                                            <a title="备注" class="layui-btn layui-btn-normal layui-btn-xs" onclick="xadmin.open('编辑','/admin/bill/{{$v->b_id}}/edit',600,800,true)" href="javascript:;">备注</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <!-- 分页 -->          	
								{{ $bills->appends($whereData)->links() }}
                                <!-- 分页 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('my-js')
<script>
    layui.use(['laydate', 'form'],
        function() {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#test10'
                ,type: 'datetime'
                ,range: '~'
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#test11'
                ,type: 'datetime'
                ,range: '~'
            });
    });

    /*laravel使用blade ajax 分页*/
    

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认需要申请吗？',function(index) {
            //发异步删除数据
            var money = $(obj).parents('tr').find('td:eq(6)').html();
            
            $.ajax({
                url:'/admin/bill/'+id,
                data:{money:money},
                dataType:'json',
                type:'get',
                headers:{
                  'X-CSRF-TOKEN':"{csrf_token()}"
                },  
                success:function(res){
                    if(res.code == '1'){
                        layer.msg(res.msg,{icon:6})
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }
                    if(res.code == '0'){
                        layer.msg(res.msg,{icon:5})
                    }
                }
            })
        });
    }

</script>
@endsection
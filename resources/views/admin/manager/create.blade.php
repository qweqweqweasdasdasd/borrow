@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
              <div class="layui-form-item">
                  <label for="mg_name" class="layui-form-label">
                      <span class="x-red">*</span>管理员名
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="mg_name" name="mg_name" required="" 
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
               <div class="layui-form-item">
                  <label for="password" class="layui-form-label">
                      <span class="x-red">*</span>密码
                  </label>
                  <div class="layui-input-block">
                      <input type="password" id="password" name="password" required=""
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="password_confirmation" class="layui-form-label">
                      <span class="x-red">*</span>确认密码
                  </label>
                  <div class="layui-input-block">
                      <input type="password" id="password_confirmation" name="password_confirmation" required=""
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
      				   <label class="layui-form-label">
      				   		<span class="x-red">*</span>管理员状态
      				   </label>
      				   <div class="layui-input-block">
      				      <input type="radio" name="mg_status" value="1" title="启用" checked>
      				      <input type="radio" name="mg_status" value="2" title="停用" >
      				   </div>
      			  </div>
              <div class="layui-form-item">
                <label class="layui-form-label">
                  <span class="x-red">*</span>选择角色
                </label>
                <div class="layui-input-block">
                  @foreach($allocationRoleData as $k => $v)
                  <input type="checkbox" name="role_ids[]" title="{{$v->role_name}}" lay-skin="primary" value="{{$v->role_id}}" @if($v->role_status == 2) disabled @endif>
                  @endforeach
                </div>
              </div>
              <div class="layui-form-item">
                  <label for="L_email" class="layui-form-label">
                      <span class="x-red">*</span>邮箱
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="email" name="email" required="" 
                      autocomplete="off" class="layui-input">
                  </div>
         
              </div>
              <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label">
                  </label>
                  <button  class="layui-btn" lay-filter="add" lay-submit="">
                      保存
                  </button>
              </div>
          </form>
        </div>
    </div>
   
</body>
@endsection

@section('my-js')
 <script>
    layui.use(['form', 'layer'],
        function() {
            $ = layui.jquery;
            var form = layui.form,
            layer = layui.layer;

    //监听提交
    form.on('submit(add)',function(data) {
            //发异步，把数据提交给php

            $.ajax({
            	url:'/admin/manager',
            	data:data.field,
            	dataType:'json',
            	type:'post',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
            	success:function(res){
            		if(res.code == '1'){
            			layer.alert("添加成功",{icon:6},function(){
            				//关闭当前frame
			                xadmin.close();
			                // 可以对父窗口进行刷新 
			                xadmin.father_reload();
            			})
            		}
                if(res.code == '422'){
                    layer.msg(res.msg,{icon:5})
                }
                if(res.code == '1003'){
                    layer.msg(res.msg,{icon:5})
                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection

@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
            	<input type="hidden" name="mg_id" value="{{$manager->mg_id}}">
              <div class="layui-form-item">
                  <label for="mg_name" class="layui-form-label">
                      <span class="x-red">*</span>管理员名
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="mg_name" name="mg_name"  
                      autocomplete="off" class="layui-input" value="{{$manager->mg_name}}">
                  </div>
              </div>
              <div class="layui-form-item">
      				   <label class="layui-form-label">
      				   		<span class="x-red">*</span>管理员状态
      				   </label>
      				   <div class="layui-input-block">
      				      <input type="radio" name="mg_status" value="1" title="启用" @if($manager->mg_status == 1) checked @endif>
      				      <input type="radio" name="mg_status" value="2" title="停用" @if($manager->mg_status == 2) checked @endif>
      				   </div>
      			  </div>
               <div class="layui-form-item">
                <label class="layui-form-label">
                  <span class="x-red">*</span>选择角色
                </label>
                <div class="layui-input-block">
                  @foreach($allocationRoleData as $k => $v)
                  <input type="checkbox" name="role_ids[]" title="{{$v->role_name}}" lay-skin="primary" value="{{$v->role_id}}" @if($v->role_status == 2) disabled @endif @if(in_array($v->role_id,$in_manager_roles_id)) checked @endif>
                  @endforeach
                </div>
              </div>
              <div class="layui-form-item">
                  <label for="L_email" class="layui-form-label">
                      <span class="x-red">*</span>邮箱
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="email" name="email" required="" 
                      autocomplete="off" class="layui-input" value="{{$manager->email}}">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="L_repass" class="layui-form-label">
                  </label>
                  <button  class="layui-btn" lay-filter="update" lay-submit="">
                      更新
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
    form.on('submit(update)',function(data) {
            //发异步，把数据提交给php
            var id = $('input[type="hidden"]').val();
            $.ajax({
            	url:'/admin/manager/'+id,
            	data:data.field,
            	dataType:'json',
            	type:'PATCH',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
            	success:function(res){
            		if(res.code == '1'){
            			layer.alert("更新成功",{icon:6},function(){
            				//关闭当前frame
			                xadmin.close();
			                // 可以对父窗口进行刷新 
			                xadmin.father_reload();
            			})
            		}
	                if(res.code == '422'){
	                    layer.msg(res.msg,{icon:5})
	                }
	                if(res.code == '1005'){
	                    layer.msg(res.msg,{icon:5})
	                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection

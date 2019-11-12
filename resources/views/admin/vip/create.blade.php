@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
              <div class="layui-form-item">
                  <label for="vipName" class="layui-form-label">
                      <span class="x-red">*</span>VIP名称
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="vipName" name="vipName" required="" 
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                  <label for="borrow_balance" class="layui-form-label">
                      <span class="x-red">*</span>借款余额
                  </label>
                  <div class="layui-input-block">
                      <input type="text" id="borrow_balance" name="borrow_balance" required="" 
                      autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
      				   <label class="layui-form-label">
      				   		<span class="x-red">*</span>vip状态
      				   </label>
      				   <div class="layui-input-block">
      				      <input type="radio" name="vip_status" value="1" title="开启" checked>
      				      <input type="radio" name="vip_status" value="2" title="停用" >
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
            	url:'/admin/vip',
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
                if(res.code == '7000'){
                    layer.msg(res.msg,{icon:5})
                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection

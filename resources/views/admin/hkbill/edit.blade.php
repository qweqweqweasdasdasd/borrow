@extends('admin.common.layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
            	<input type="hidden" name="b_id" value="{{$bill->b_id}}">
              <div class="layui-form-item layui-form-text">
		          <label class="layui-form-label">备注信息</label>
		          <div class="layui-input-block">
		            <textarea name="desc" placeholder="请输入内容" class="layui-textarea">{{$bill->desc}}</textarea>
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
            var id = $('input[name="b_id"]').val();

            $.ajax({
            	url:'/admin/bill/'+id,
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
	                if(res.code == '9000'){
	                    layer.msg(res.msg,{icon:5})
	                }
            	}
            })
            
            return false;
        });

    });
</script>
@endsection

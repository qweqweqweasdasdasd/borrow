@extends('admin/common/layout')

@section('content')
<body>
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form">
              <div class="layui-form-item layui-form-text">
      			    <label class="layui-form-label">
      			    	<span class="x-red">*</span>令牌
      			    </label>
      			    <div class="layui-input-block">
      			      <textarea name="token" placeholder="请输入令牌" class="layui-textarea">@if(is_object($token)){{$token->token}}@endif
      			      </textarea>
      			    </div>
      			  </div>
              <div class="layui-form-item">
                <label class="layui-form-label">令牌状态</label>
                <div class="layui-input-block">
                  <input type="radio" name="status" title="" id="status">
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
  layui.use(['form', 'layer','jquery'],function() {
        $ = layui.jquery;
        var form = layui.form,
        layer = layui.layer;

        /**
         *  定时器
         */
         _ajax();
         setInterval(function(){
            _ajax();
         },60000)

         function _ajax(){
          $.ajax({
              url:'/api/borrow/heartbeat',
              data:'',
              dataType:'json',
              type:'post',
              headers:{
                'X-CSRF-TOKEN':"{{csrf_token()}}"
              },
              success:function(res){
                  if(res.code == '1'){
                    console.log(res);
                    if(res.data.status == true){
                      $('#status').attr('title','会话有效');
                      $('#status').attr('checked',true);
                      form.render();
                    }
                    if(res.status == false){
                      $('#status').attr('title','会话失效');
                      $('#status').attr('checked',false);
                      form.render();
                    }
                  }
                  if(res.code == '422'){
                      layer.msg(res.msg,{icon:5})
                  }
                  if(res.code == '6000'){
                      layer.msg(res.msg,{icon:5})
                  }
              }
            })
         }
        //监听提交
        form.on('submit(update)',function(data) {

            //发异步，把数据提交给php
            $.ajax({
            	url:'/admin/platform/token',
            	data:data.field,
            	dataType:'json',
            	type:'post',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
            	success:function(res){
            		  if(res.code == '1'){
              			layer.alert("更新成功",{icon:6},function(){
              				location.reload()
              			})
            		  }
	                if(res.code == '422'){
	                    layer.msg(res.msg,{icon:5})
	                }
	                if(res.code == '6000'){
	                    layer.msg(res.msg,{icon:5})
	                }
            	}
            })

            return false;
        });

    });

  
</script>
@endsection
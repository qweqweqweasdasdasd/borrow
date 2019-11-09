@extends('admin.common.layout')

@section('my-css')
<link rel="stylesheet" href="{{asset('/admin/css/login.css')}}">
@endsection

@section('content')
<body class="login-bg">
    <div class="login layui-anim layui-anim-up">
        <div class="message">x-admin2.0-管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" >
            <input name="mg_name" placeholder="用户名"  type="text"  class="layui-input" >
            <hr class="hr15">
            <input name="password"  placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15"> 
            <input name="谷歌验证"  placeholder="谷歌验证"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

</body>
@endsection

@section('my-js')
<script>
    $(function  () {
        layui.use('form', function(){
          var form = layui.form;
          //监听提交
          form.on('submit(login)', function(data){
            //	ajax
            $.ajax({
            	url:'/admin/doLogin',
            	data:data.field,
            	dataType:'json',
            	type:'post',
            	headers:{
            		'X-CSRF-TOKEN':"{{csrf_token()}}"
            	},
            	success:function(res){
            		if(res.code == '1'){
                        location.href = res.data.url;
                    }
                    if(res.code == '1000'){
                        layer.msg(res.msg,{icon:5})
                    }
                    if(res.code == '1001'){
                        layer.msg(res.msg,{icon:5})
                    }
            	}
            })
            
            return false;
          });
        });
    })
</script>
@endsection

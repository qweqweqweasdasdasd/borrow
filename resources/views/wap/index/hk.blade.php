@extends('wap.common.layout')
@section('content')

	<body>

		@include('wap/common/header')

		@include('wap/common/nav')

		<div class="content">
			<div class="box3">
				<div class="title">
					<h5>我要还款</h5>
				</div>
				<div class="txt-box">
					<p>
					</p>
					<p>
						<span style="font-family: 微软雅黑, Arial, Helvetica, sans-serif; font-size: 15px; text-indent: 30px; white-space: normal;color:#000000">{{$webset->web_name}} 系统将自动检测是否到还款时间,一旦到还款时间客服会自动从会员余额内扣除相应的借款金额,</span>
					</p>
					<p>
					</p>
					
				</div>
			</div>
		</div>

		<!-- /主体 -->

		<!-- 底部 -->

		@include('wap/common/foot',['data'=>$webset])
	</body>
@endsection
@section('my-js')

@endsection

@extends('wap.common.layout')
@section('content')

	<body>

		@include('wap/common/header')

		@include('wap/common/nav')

		<div class="content">
			<div class="box3">
				<div class="title">
					<h5>借还款记录</h5>
				</div>
				<div class="txt-box">
					<p>
					</p>
					<p>
						<span style="font-family: 微软雅黑, Arial, Helvetica, sans-serif; font-size: 15px; text-indent: 30px; white-space: normal;color:#000000">
							在 {{$webset->web_name}} 借呗每一笔借还款记录将永久记录，每一笔借还款记录永久累计，电子等级和真人等级越高，可借款总额度就越高。
						</span>
					</p>
					<p>
					</p>
					<div class="box-ge">

						<table border="1" class="box3-table" width="100%" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<th>
										会员帐号
									</th>

									<th>
										vip等级
									</th>
									<th>
										姓名
									</th>
									<th class="jhk1">
										金额
									</th>

									<th class="jhk2">
										日期
									</th>
									<th class="jhk2">
										状态
									</th>
								</tr>
							</tbody>
							<tbody id="deals">
								@foreach($bills as $v)
								<tr>
									<td width="">{{$v->userAccount}}</td>
									<td width="">{{$v->vipName}}</td>
									<td width="">{{$v->userName}}</td>
									<td width="">
									
										<span class="" style="color:green;">{{$v->borrow_money}}</span>

									</td>
									<td>{{$v->updated_at}}</td>
									<td>
										@if($v->status == 2)
											<span class="" style="color:green;">借款成功</span>
										
										@elseif($v->status == 1)
											<span class="" style="color:green;">客服处理中</span>

										@elseif($v->status == 3)
											<span class="" style="color:red;">借款失败</span>	
										
										@elseif($v->status == 4)
											<span class="" style="color:red;">待还款</span>

										@elseif($v->status == 5)
											<span class="" style="color:green;">还款成功</span>

										@elseif($v->status == 6)
											<span class="" style="color:red;">还款失败</span>
										@endif
										
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>


		@include('wap/common/foot',['data'=>$webset])
	</body>
@endsection
@section('my-js')

@endsection

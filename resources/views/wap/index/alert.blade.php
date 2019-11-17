<!DOCTYPE HTML>
<html>
<head>
 <link rel="stylesheet" rev="stylesheet" href="/wap/css/css.css" type="text/css" />
</head>
<body style="min-width: 600px;">
 <div id="light" class="white_content" style="width:500px;">
      <div class="">用户信息</div>
       
      <div class="white-div">
        <table class="white-table" width="100%" border="0" cellspacing="0" cellpadding="0" >              
             <tr class='tr-top' >
               <td width='11%'>会员账号</td>
               <td width='11%'>vip等级</td>
               <td width='11%'>可借款金额</td>
               <td width='11%'>已经借款金额</td>
               <td width='11%'>总借款金额</td>
               <td width='11%'>总还款金额</td>
               <td width='11%'>借款次数</td>

             </tr>
             	
             <tr>

             	<td >{{$member->userAccount}}</td>
             	<td >{{$member->vip->vipName}}</td>
             	<td >{{$member->vip->borrow_balance}}</td>
             	<td >{{$member->balanced}}</td>
             	<td >{{$member->pandect->borrow_total}}</td>
             	<td >{{$member->pandect->repayment_total}}</td>
             	<td >{{$member->pandect->total_count}}</td>
          

             </tr>        
          </table>
        <br/>
        <div class="">账单列表</div>
        <table class="white-table" width="100%" border="0" cellspacing="0" cellpadding="0" >              
           <tr  class='tr-top'>
             <td>会员账号</td>
             <td>借款金额</td>
             <td>申请日期</td>
             <td>还款日期</td> 
            <!--  <td>原因</td> -->
             <td>状态</td>
           </tr>
           @foreach($bills as $v)
           <tr>
                <td >{{$v->userAccount}}</td>
                <td >{{$v->borrow_money}}</td>
                <td >{{date('Y-m-d',strtotime($v->apply_time))}}</td>
                <td >{{date('Y-m-d',strtotime($v->repayment_time))}}</td>
                <!-- <td >{{$v->desc}}</td> -->
                <td >{!! bill_show_status($v->status) !!}</td>
           </tr>           
           @endforeach
        </table>
        <div  class="paging">
          <div class="paging_l">
                      </div>
        
        </div>
        
        
        
      </div>
  </div>
<style type="text/css">
  .white-table tr td{
    height:26px;
    line-height:26px;
  }
</style>  
</body>
</html>
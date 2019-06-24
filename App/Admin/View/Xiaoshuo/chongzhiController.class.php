<!--_meta 作为公共模版分离出去-->
<include file='Index/meta'/>
<!--/meta 作为公共模版分离出去-->

<title>小说管理</title>  
<style>

td {

      white-space:nowrap;
      overflow:hidden;
      text-overflow: ellipsis;

}
table{
	table-layout: fixed;
}

</style>
</head>  
<body>
<!--_header 作为公共模版分离出去-->
<include file='Index/header'/>  
<!--/_header 作为公共模版分离出去-->
 
<!--_menu 作为公共模版分离出去-->
<include file='Index/leftmenu' />  
<!--/_menu 作为公共模版分离出去--> 

<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 频道管理 <span class="c-gray en">&gt;</span> 男频列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav> 
	
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <i ></i> </a></a></span> <span >共有数据：<strong><{$shu}></strong> 条</span> </div>
			
			
			<div class="mt-0">  
				<table class="table table-border table-bordered table-bg table-hover table-sort" width="100%">
					<thead>
						<tr class="text-c"> 
							
							<th width="10">ID</th>
							<th width="50">小说名</th>
							<th width="30">最后一章</th>
							<th width="150">内容</th>
							<th width="30">更新时间</th>
							<!-- <if condition="$_SESSION.guanli eq null">
							<th width="100">推广</th>
							</if> -->
							<th width="30">大小</th>
							<th width="30">价格</th>

							
							
							
							
							
							
							<th width="30">销售数量</th>
							<th width="20">操作</th>
							
							 
						</tr> 
						<foreach name="arr" item="v">
						<tr class="text-c"> 
							<!-- <td width="100"><{$v.sortid}></td> -->
							
							<td width="20"><{$v.chapterid}></td>
							<td width="100">
								
								<{$v.articlename}>
							</td>
							<td width="50"><{$v.chaptername}></td>
							<td width="50"><{$v.attachment}></td>
							    
							</td>
							
							<td width="100"><{$v.lastupdate}></td>
							
							
							<td width="50"><{$v.size}>KB</td>
							<td width="30"><{$v.saleprice}>
							 	
							</td>
							
							
							
							
							
							
							
							
							
								<td width="100"><{$v.salenum}>
								
							</td>
							<td width="30"><a title="修改" onClick="picture_add('修改小说','<{:U('zjedit')}>?id=<{$v.chapterid}>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>&nbsp;&nbsp;
							 <a  href="<{:U('zjdel')}>?id=<{$v.chapterid}>&fid=<{$v.articleid}>" title="删除" class="ml-5"><i class="Hui-iconfont">&#xe6e2;</i></a>
							</td>
						</if>
						</tr> 
					</foreach>
					</thead> 
					<tfoot>
						
					</tfoot>
				</table>
				<{$btn}>
			</div>
		</article>
	</div> 
</section>

<!--_footer 作为公共模版分离出去-->
<include file='Index/footer'/>
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="__PUBLIC__/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="__PUBLIC__/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/lib/laypage/1.2/laypage.js"></script> 
<script type="text/javascript"> 
 	function MsgBox(id) //声明标识符
{
alert("http://www.youdingb.com/xiangmu/xiaoshuoyipin/index.php/Home/index/book.html"+id); //弹出对话框
}
 function picture_add(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
// onclick="MsgBox('?id=<{$_GET.id}>&zid=<{$v.chapterid}>&uid=<{$_SESSION.user_id}>')"
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
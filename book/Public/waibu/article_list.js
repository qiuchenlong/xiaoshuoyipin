/**
 * DataTables
 */
var datatable = null,
	init_times = 0,
	loading = null,
	idList = [];

$(function($) {

	//填充下拉菜单
	$.get(contextPath + "/category/getCategoryAll", {}, function(data) {
		var html = '<option value="">---请选择---</option>';
		for(var i = 0; i < data.length; i++) {
			html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
		}
		$('#categoryId').html(html);
	});
	
	simpleSelect2('sourceId', 1, [], '搜索来源');
 
	var guidStatusMap = new HashMap();


	datatable = $('.table-sort').DataTable({
		fixedHeader: true,
		order: [
			[5, 'desc']
		],
		ajax: { 
			url: contextPath + "/article/getPageList",
			type: 'post',
			data: function(d) {  
				d.search = $('#search').val();
				d.timeMin = $("#timeMin").val();
				d.timeMax = $("#timeMax").val();
				d.categoryId = $('#categoryId').val();
				d.sourceId = $('#sourceId').val();
			}
		},
		columns: [{
			data: "id"
		}, {
			data: "title"
		}, {
			data: "categoryName",
			defaultContent: ""
		}, {
			data: "source",
			defaultContent: ""
		}, {
			data: "headline",
			defaultContent: ""
		}, {
			data: "pubTime",
			defaultContent: ""
		}, {
			data: "createName",
			defaultContent: "spider",
			orderable:false
		}, {
			data: "stick",
			defaultContent: ""
		}, {
			data: "status",
			defaultContent: ""
		}, {
			data: null
		}],
		columnDefs: [{
			targets: [0],
			orderable: false,
			render: function(data, type, row, meta) {
				return '<input id="input-' + data + '" type="checkbox" name="single"><label for="input-' + data + '"></label>';
			}
		}, {
			targets: [3],
			render: function(data, type, row, meta) {
				var type = ['', '微信', 'app', '网站', '合作媒体', 'UGC'];
				return data.name + '(' + type[data.type] + ')';
			}
		}, {
			targets: [4],
			render: function(data, type, row, meta) {
				return data == 1 ? '是' : '';
			}
		}, {
			targets: [5],
			render: function(data, type, row, meta) {
				return data ? new Date(data).pattern("yyyy-MM-dd HH:mm:ss") : '';
			}
		}, {
			targets: [7],
			render: function(data, type, row, meta) {
				return data ? '是' : '否';
			}
		}, {
			targets: [8],
			render: function(data, type, row, meta) {
				return '<select class="select" guid="' + row.id + '"><option value="0">待审核</option><option value="1">正常</option><option value="2">已下架</option></select>';
			}
		}, {
			targets: [9],
			orderable: false,
			responsivePriority: 1,
			render: function(data, type, row, meta) {
				var btns = new Array('newTabEdit', 'del');
				return getDTOperateBtn(btns, row.id, 'article-add.jsp', row.status, '/article/del/');
			}
		}
		],
		drawCallback: function(settings) { 
			var _$this = this;
			drawCallbackDefault(settings, _$this);
			$('.table select').select2({
				minimumResultsForSearch: "-1"
			});
			if(guidStatusMap.size() > 0) {
				$('.table .select').each(function() { 
					$(this).select2({
						minimumResultsForSearch: "-1"
					});
					$(this).select2('val', guidStatusMap.get($(this).attr('guid')));
				}).change(function() {
					$.post(contextPath + "/article/update", {
						id: $(this).attr('guid'),
						status: $(this).val()
					}, function(result) {
						if(result.status == 200) { 
							showSuccessMessage("操作成功!", reloadTable);
						} else {
							showFailMessage("操作失败!")
						} 
					})
				});
			}
		}
	}).on('xhr.dt', function(e, settings, json, xhr) {
		for(var i = 0, ien = json.data.length; i < ien; i++) {
			var data = json.data[i];
			guidStatusMap.put(data.id, data.status + "");
		}
	}).on('preXhr.dt', function(e, settings, data) {
        if(init_times > 0){
        	loading = layer.msg('加载中', {
        		icon: 16,
        		shade: 0.3
    		});
        }
        init_times++;
    }).on('draw.dt', function() {
    	layer.close(loading);
    });
});

/**
 * 刷新DT
 */
function reloadTable() {
	datatable.ajax.reload(null, false);
}

/**
 * 获取datatables选中行的ID
 */
function getDTSelect() { 
	var lines = datatable.rows('.selected').data();
	for(var i = 0; i < lines.length; i++) {
		idList.push(lines[i].id);
	}

	return idList;
}
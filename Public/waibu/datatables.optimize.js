/**
 * datatables优化
 */
$.extend($.fn.dataTable.defaults, {
	dom: 't<"dataTables_info"il>p',
	language: {
		"url": "../assets/lib/datatables/datatables_language.json"
	},
	processing: true, //当datatable获取数据时候是否显示正在处理提示信息。
	serverSide: true, //服务器处理分页
	responsive: {
		details: false
	},
	initComplete: function(settings) {
		var _$this = this;

		/**
		 *  
		 * 重写搜索事件
		 */
		$('#doSearch').bind('click', function(e) {
			_$this.api().ajax.reload();
		});
		$('#search').bind('keyup', function(e) {
			if(e.keyCode == 13 || (e.keyCode == 8 && (this.value.length == 0))) {
				_$this.api().ajax.reload();
			}
		}); 
	},
	drawCallback: drawCallbackDefault  
});

/**
 * DT绘制完成默认回调函数
 * 单独写出来是方便二次定制
 * 
 * 默认回调函数功能：
 * 1.DT第一列checkbox初始化成icheck
 * 2.iCheck全选、取消多选、多选与单选双向关联
 * 3.选中的tr加上selected class
 * 
 * @param {Object} settings  
 */
function drawCallbackDefault(settings, _$this) {
	console.log("drawCallbackDefault");
	_$this = (isExitsVariable('_$this') && _$this) ? _$this : this;
	selector = _$this.selector;
	$(selector + ' input').iCheck({
		checkboxClass: 'icheckbox_minimal',
		increaseArea: '20%'
	});

	/**
	 * DT thead iCheck 点击事件
	 */
	$(selector + ' input[name=all]').on('ifChecked ifUnchecked', function(e) {
		$(this).closest('table').find('input[name=single]').each(function() {
			if(e.type == 'ifChecked') {
				$(this).iCheck('check');
				$(this).closest('tr').addClass('selected');
			} else {
				$(this).iCheck('uncheck');
				$(this).closest('tr').removeClass('selected');
			}
		});
	});

	/**
	 * DT tbody iCheck点击事件
	 */
	$(selector + ' input[name=single]').on('ifChecked ifUnchecked', function(e) {
		if(e.type == 'ifChecked') {
			$(this).iCheck('check');
			$(this).closest('tr').addClass('selected');
			//全选单选框的状态处理
			var selected = _$this.api().rows('.selected').data().length; //被选中的行数
			var recordsDisplay = _$this.api().page.info().recordsDisplay; //搜索条件过滤后的总行数
			var iDisplayStart = _$this.api().page.info().start; // 起始行数
			if(selected === _$this.api().page.len() || selected === recordsDisplay || selected === (recordsDisplay - iDisplayStart)) {
				$(selector + ' input[name=all]').iCheck('check');
			}
		} else {
			$(this).iCheck('uncheck');
			$(this).closest('tr').removeClass('selected');
			$(selector + ' input[name=all]').attr('checked', false); 
			$(selector + ' input[name=all]').iCheck('update');
		}
	});

	/**
	 * 展示详情点击触发（有a.details-control时才会触发）
	 */
	$(selector + ' tbody').on('click', 'a.details-control', function() {
		var tr = $(this).closest('tr');
		var row =  _$this.api().row(tr);
		if(row.child.isShown()) {
			row.child.hide();
			tr.removeClass('shown');
		} else {
			var width = $(selector + ' tr > th:first-child').width() - 1;
			var subTable = format(row.data(), width);
			row.child(subTable).show();
			tr.addClass('shown');
			tr.next().children(":first").css({
				'padding': 0,'border':'none'
			});
			tr.next().hover(function(){
				$(this).find('td').css('background-color','white');
			});
		}
	});

	/**
	 * 是否存在指定变量
	 * @param {Object} variableName 变量名
	 */
	function isExitsVariable(variableName) {
		try {
			if(typeof(variableName) == "undefined") {
				return false;
			} else {
				return true;
			}
		} catch(e) {}
		return false;
	}
}

/**
 * 拼装Datatables操作列的按钮
 * @param {Object} btns 操作按钮数组
 * @param {Object} id 实体ID
 * @param {Object} jsp jsp地址
 * @param {Object} otherParam 其它的参数
 * @param {Object} url ajax地址
 */
function getDTOperateBtn(btns, id, jsp, otherParam, url) {
	var html = '';
	if(contains(btns, 'newTabEdit')) {
		html += '&nbsp;<a data-title="编辑" href="javascript:;" data-href="' + jsp + '?id=' + id + '" onclick="Hui_admin_tab(this)" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>&nbsp;';
	}
	if(contains(btns, 'edit')) {
		html += '&nbsp;<a title="编辑" href="javascript:;" onclick="edit(\'编辑\',\'' + jsp + '\',' + id + ',\'700\',\'480\')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>&nbsp;';
	}
	if(contains(btns, 'closure')) {
		html += '&nbsp;<a title="封禁" href="javascript:;" onclick="closure(' + id + ')" style="text-decoration:none"><i class="Hui-iconfont">&#xe60e;</i></a>&nbsp;';
	}
	if(contains(btns, 'reply')) {
		html += '&nbsp;<a title="回复" href="javascript:;" onclick="edit(\'回复\',\'' + jsp + '\',' + id + ',\'700\',\'480\')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6c5;</i></a>&nbsp;';
	}
	if(contains(btns, 'download')) {
		html += '&nbsp;<a title="下载" href="javascript:;" onclick="downloadFile(' + id + ',\'' + otherParam + '\')" style="text-decoration:none"><i class="Hui-iconfont">&#xe641;</i></a>&nbsp;';
	}
	if(contains(btns, 'del')) {
		html += '&nbsp;<a title="删除" href="javascript:;" onclick="del([' + id + '],\'' + url + '\')" style="text-decoration:none"><i class="Hui-iconfont">&#xe609;</i></a>&nbsp;';
	}
	return html;
}

/**
 * DT子表显示行详情
 * @param {Object} data
 * @param {Object} translate
 */
function DTShowRowDetail(data, translate, width){
	var subTable = '<table>';
	$.each(translate, function(key, element) {
		value = eval('data.' + key);
		value = value ? value : '';
		if(isExitsFunction(element.value)){
			value = element.value(value);
		}
		subTable += '<tr><td width="' + width + 'px">' + element.cn_ZH + '</td><td>' + value + '</td></tr>';
	});
	subTable += '</table>';
	return subTable;
}

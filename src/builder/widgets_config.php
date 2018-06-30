<?php 
// +----------------------------------------------------------------------
// | 大鲸PHP框架 [ WhalePHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 上海才硕信息科技有限公司
// +----------------------------------------------------------------------
// | 官方网站: http://whalephp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

//组件配置文件
return [
	//不同构建器需要加载的文件
	//=============================================================
	'builder_common'	=> [
		'table'	=> [
			'css'	=> [],
			'js'	=> [],
		],
		'form'	=> [
			'css'	=> [],
			'js'	=> [],
		],
		'tree'	=> [
			'css'	=> [
				'__STATIC__/common/builder/tree/tree.css',
			],
			'js'	=> [],
		],
	],
	//其他单纯的插件
	//=============================================================
	'echarts'	=> [
		'js'	=> [
			'__VENDOR__/plugins/echarts/echarts.min.js',
			//'__VENDOR__/plugins/echarts/theme/infographic-my.js',	//walden
			'__VENDOR__/plugins/echarts/theme/infographic-my.js',
			'__VENDOR__/plugins/echarts/echarts.helper.js',
		],
	],
	'art-template'	=> [
		'js'	=> [
			//'__VENDOR__/plugins/artTemplate/template.js'
		],
	],
	// 复制到剪切板
	'clipboard'	=> [
		'js'	=> [
			'__VENDOR__/plugins/clipboard/clipboard.min.js',
		],
	],
	// 复制到剪切板
	'qrcode'	=> [
		'js'	=> [
			'__VENDOR__/plugins/qrcode/qrcode.min.js',
		],
	],
	//滚动条1
	'slimscroll'	=> [
		'js'	=> [
			'__VENDOR__/plugins/slimscroll/jquery.slimscroll.min.js',
		],
	],
	//滚动条2
	'mCustomScrollbar'	=> [
		'css'	=> [
			'__VENDOR__/plugins/mCustomScrollbar/jquery.mCustomScrollbar.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js',
		],
	],
	
	// 
	'duallistbox'	=> [
		'js'	=> [
			'__VENDOR__/plugins/duallistbox/jquery.bootstrap-duallistbox.min.js',
		],
	],
	
	//图片预览
	'magnific'	=> [
		'css'	=> [
			'__VENDOR__/plugins/magnific/magnific-popup.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/magnific/jquery.magnific-popup.js',
		],
	],
	//各组件需要加载的css及js文件，及其他相关配置
	//=============================================================
	'x-editable'=> [	// 快速编辑
		'css'	=> [
			//X-editable CSS
			'__VENDOR__/plugins/xeditable/css/bootstrap-editable.css',
			'__VENDOR__/plugins/xeditable/inputs/address/address.css',
			'__VENDOR__/plugins/xeditable/inputs/typeaheadjs/lib/typeahead.js-bootstrap.css'
		],
		'js'	=> [
			//Xedit Dependency
			'__VENDOR__/plugins/moment/moment.min.js',
			//Xedit JS
			'__VENDOR__/plugins/xeditable/js/bootstrap-editable.min.js',
			'__VENDOR__/plugins/xeditable/inputs/address/address.js',
			'__VENDOR__/plugins/xeditable/inputs/typeaheadjs/lib/typeahead.js',
			'__VENDOR__/plugins/xeditable/inputs/typeaheadjs/typeaheadjs.js'
		],
	],
	'select2'	=> [
		'css'	=> [
			//'__VENDOR__/plugins/select2/css/core.css',
			'__VENDOR__/plugins/select2/3.4.4/select2.css'
		],
		'js'	=> [
			'__VENDOR__/plugins/select2/3.4.4/select2.js',
		],
	],
	'echart'	=> [
		'css'	=> [],
		'js'	=> [],
	],
	'datetimepicker'	=> [	// 时间日期选择
		'css'	=> [
			'__VENDOR__/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js',
			'__VENDOR__/plugins/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js',
		],
	],
	'magnific'	=> [	// 模态框插件
		'css'	=> [
			'__VENDOR__/plugins/magnific/magnific-popup.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/magnific/jquery.magnific-popup.js',
		],
	],
	'webuiPopover'	=> [
		'css'	=> [
			'__VENDOR__/plugins/webui/jquery.webui-popover.min.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/webui/jquery.webui-popover.min.js',
		],
	],
	'diy_colums'	=> [
		'css'	=> [],
		'js'	=> [
			'__VENDOR__/plugins/dragsort/jquery.dragsort-0.5.2.js',
		],
	],
	'dragsort'	=> [
		'css'	=> [],
		'js'	=> [
			'__VENDOR__/plugins/dragsort/jquery.dragsort-0.5.2.js',
		],
	],
	'json-viewer'	=> [	// json格式化显示
		'css'	=> [
			'__VENDOR__/plugins/json-viewer/css/jquery.json-viewer.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/json-viewer/js/jquery.json-viewer.js',
		],
	],
	'dropzone'	=> [	// 拖拽控件
		'css'	=> [
			'__VENDOR__/plugins/dropzone/css/dropzone.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/dropzone/dropzone.min.js',
		],
	],
	'tagsinput'	=> [	// tags标签
		'js'	=> [
			'__VENDOR__/plugins/tagsinput/tagsinput.min.js',
		],
	],
	'images'	=> [
		'css'	=> [],
		'js'	=> [
			'__VENDOR__/plugins/jquery.form.js',
		],
	],
	'jQueryForm'	=> [
		'css'	=> [],
		'js'	=> [
			'__VENDOR__/plugins/jquery.form.js',
		],
	],
	'cropper'	=> [
		'css'	=> [
			'__VENDOR__/plugins/cropper/cropper.min.css?t=11',
			'__VENDOR__/plugins/cropper/sitelogo.css',
		],
		'jq'	=> [				// 这还存在问题，与其他插件还是存在冲突！！！！
			'version'	=> '1.10.2',
			'alias'		=> '$jq1_10_2',
		],
		'js'	=> [
			'__VENDOR__/plugins/cropper/bootstrap-modal.pack-2.1.0.js',
			'__VENDOR__/plugins/cropper/cropper.js',
			'__VENDOR__/plugins/cropper/sitelogo.js',
			'__VENDOR__/plugins/cropper/html2canvas.min.js',
		],
	],
	//--------------------------------------------------------------------------------
	'ueditor'	=> [
		'css'	=> [],
		'js'	=> [],
	],
	'kindeditor'	=> [
		'css'	=> [
			'__VENDOR__/editors/kindeditor/4.1.7/themes/default/default.css',
		],
		'js'	=> [
			'/public/static/vendor/editors/kindeditor/4.1.7/kindeditor-min.js',
			'__VENDOR__/editors/kindeditor/4.1.7/lang/zh_CN.js',
		],
	],
	'editormd'	=> [
		'css'	=> [
			'__VENDOR__/plugins/editormd/css/editormd.css',
			//'__VENDOR__/plugins/editormd/css/editormd.preview.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/editormd/lib/marked.min.js',
			'__VENDOR__/plugins/editormd/lib/prettify.min.js',
			'__VENDOR__/plugins/editormd/lib/raphael.min.js',
			'__VENDOR__/plugins/editormd/lib/underscore.min.js',
			'__VENDOR__/plugins/editormd/lib/sequence-diagram.min.js',
			'__VENDOR__/plugins/editormd/lib/flowchart.min.js',
			'__VENDOR__/plugins/editormd/lib/jquery.flowchart.min.js',
			'__VENDOR__/plugins/editormd/editormd.min.js',
		],
	],
	'summernote'	=> [
		'css'	=> [
			'__VENDOR__/editors/summernote/summernote-bs3.css',
			'__VENDOR__/editors/summernote/summernote.css',
		],
		'js'	=> [
			'__VENDOR__/editors/summernote/summernote.js',
		],
	],
	//--------------------------------------------------------------------------------
	// 表单验证
	'validate'	=> [
		'css'	=> [],
		'js'	=> [
			'__VENDOR__/plugins/jquery-validation-1.14.0/dist/jquery.validate.min.js',
			'__VENDOR__/plugins/jquery-validation-1.14.0/dist/localization/messages_zh.min.js',
		],
	],
	// jquery WEUI
	'weui'	=> [
		'css'	=> [
			'__VENDOR__/frame/weui/lib/weui.min.css',
			'__VENDOR__/frame/weui/css/jquery-weui.css',
			STATIC_PREFIX . '/home/css/weui-expand.css?t=1',
		],
		'js'	=> [
			'__VENDOR__/frame/weui/lib/fastclick.js',
			'__VENDOR__/frame/weui/js/jquery-weui.js'
		],
	],
	// 绘画板
	'jq-signature'	=> [
		'css'	=> [],
		'js'	=> [
			'__VENDOR__/plugins/jq-signature/jq-signature.js',
			'__VENDOR__/plugins/md5.js',
		],
	],
	
	// 表内增删改
	'jQueryTabullet'	=> [
		'css'	=> [
			'__VENDOR__/plugins/jQueryTabullet/css/style.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/jQueryTabullet/js/Tabullet.js',
		],
	],	
	
	// 表内增删改
	'bigcolorpicker'	=> [
		'css'	=> [
			'__VENDOR__/plugins/bigcolorpicker/css/jquery.bigcolorpicker.css',
		],
		'js'	=> [
			'__VENDOR__/plugins/bigcolorpicker/jquery.bigcolorpicker.js',
		],
	],
	//--------------------------------------------------------------------------------
	// vue.js
	'vue'	=> [
		'css'	=> [],
		'js'	=> [
			'https://cdn.bootcss.com/vue/2.4.2/vue.min.js',
			'https://cdn.bootcss.com/vue-validator/3.0.0-alpha.2/vue-validator.js'
		],
	],
	
	
	
	

];




















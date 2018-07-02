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

namespace whalephp\tbuilder\traits;
/**
 * 界面设置相关方法
 * @author: qw_xingzhe <qwei2013@gmail.com>
 */
trait ViewSetting 
{
	public $tbObj;						// 构建器对象
	public $twObj = null;				// 组件对象
	public $widgetsValues = [];			// 组件赋值
	protected $request_param = [];		// 请求参数
	
	public $_view_vars = [				// 界面控制相关变量
		
		// 常量数组
		'constant_arr'			=> [
			/****
			'entrance'		=> ENTRANCE,
			'base_domain'	=> BASE_DOMAIN,
			'second_domain'	=> SECOND_DOMAIN
			*/
			'entrance'		=> '',
			'base_domain'	=> '',
			'second_domain'	=> ''
		],
	
		//微信配置
		//============================================
		'jsSignConf'			=> [
			'appId'			=> '',
			'timestamp'		=> '',
			'nonceStr'		=> '',
			'signature'		=> '',
			'shareData'		=> [
				'title'	=> '',
				'desc'	=> '',
				'link'	=> '',
				'imgUrl'=> '',
			],
		],
		
		//菜单相关配置
		//============================================
		'pageRightTopMenu'		=> [],
		'pageRightDropdownMenu'	=> [],
		'prefix_main_title'		=> '',
		'main_title'			=> '',
	    'main_title_append'		=> ' - 云测库测评',
	    'keywords'				=> 'exam,考试系统,在线考试系统,在线考试,资格证模考,模考试卷/题库,企业考试系统,微信考试系统,知识竞赛系统,手机考试系统,网上考试系统,校园招聘考试,防作弊考试系统,电子作业系统云平台',
	    'description'			=> '云测库是一款线上考试测评及人才管理工具。具有海量题库，支持测评邀约、题库导入、选题组卷、自动判分，双向阅卷、排名榜单，多重报表统计分析等功能。帮助团队在招聘测试、企业内部培训、绩效考核等各类场景提供线上答题考试，数据收集统计等工作，大幅度提升工作效率。',
	    
		//扩展
		//============================================
		'extend'				=> [		// 扩展文件
			'extend_js'			=> '',	// 拼接后js
			'extend_css'		=> '',	// 拼接后css
			'append_js'			=> [],	// 待拼接的js路径数组
			'append_css'		=> [],	// 待拼接的css路径数组
			
			'extend_js_content'	=> '',	// 拼接后js内容
			'extend_css_content'=> '',	// 拼接后css内容（加载在页面顶部）
		],
		
		'widgets_in_use'		=> [],		// 使用中的组件，用于动态加载依赖的文件库
		'widgets_sub_in_use'	=> [],		// 组件的不同呈现形式
		
		//组件类
		//============================================
		'list_button_line_num'	=> 9999,	// listButton每行显示数量
		'top_btns'				=> [],		// 顶部按钮
		'top_right_btns'		=> [],		// 顶部右侧按钮
		'top_tab_btns'			=> [],		//
		'list_item_btns'		=> [],		// 列表按钮
		'left_menu_top_btns'	=> [],		// 左侧菜单顶部按钮
		 
		//
		'widgets_field'			=> [],		// 组件-字段对于数组
		 
		//tab分组信息存储
		'current_tab_num'		=> 0,		// 当前显示的tab数
		'tab_group'				=> [],		// tab分组
		'tab_group_show_num'	=> 0,		// 显示tab分组数量
		 
		'form_action'			=> '',		// 表单提交的地址
		 
		'columns'				=> [],		// 展示列

		//Form 构建器配置数组
		//============================================
		
		
		//框架类
		//============================================
		'topbar_type' 			=> 1,		// topbar类型，1:面包屑导航，2顶部菜单导航，0不显示
		'topbar_menus'			=> [],		// topbar导航链接配置数组
		'topbar_buttons'		=> [],		// topbar导航上的按钮数组
		
		//'builder'				=> '',		// 构建器类型
		'layout_view'			=> 'layout',// 构建器所使用的布局
		
		//组件的显隐
		//============================================
		'is_show_navbar'		=> 1,		// 是否显示顶部菜单（隐藏时样式待调整）
		'is_show_footer'		=> 1,		// 是否显示底部
		'is_show_form_button'	=> 1,		// 是否显示表单的按钮
		'is_show_topbar'		=> 1,		// 是否显示topbar
		'is_show_sidebar'		=> 1,		// 是否显示sidebar（左侧菜单）
		'is_show_tray'			=> 0,		// 
		'is_show_tray_menu'		=> 0,		// 是否显示tray_menu
		'is_show_tray_right'	=> 0,		// 
		'is_show_sidemenu'		=> 0,		// 
		'is_show_table_ids'		=> 0,		// 是否显示table列表id选择checkbox
		'is_show_form_desc'		=> 0,		// 是否显示form组件描述区域
		'header_back_link'		=> '',		// topbar返回按钮地址
		
		//自由布局组件
		//============================================
		'custom_view'	=> '../vendor/whalephp/tbuilder/src/builder/custom/empty.html',
		'custom_widget'	=> [
			/*	
			//添加后效果数据格式
			[	// row 1
				['col'=>3,'widgets'=>[]],	// 列1
				['col'=>9,'widgets'=>[]],	// 列2
			],
			[	// row 2
				['col'=>4,'widgets'=>[]],	// 列1
				['col'=>4,'widgets'=>[]],	// 列2
				['col'=>4,'widgets'=>[]],	// 列3
			],
			*/
		],
		'custom_widget_row_num'	=> 0,			// 自由布局行数
		
		'append_content_html'	=> '',			// 附加内容主题内容
		
		
		
		//左侧菜单扩展
		//============================================
		'left_menu_expand'	=> [
			
		],
		
		// 主题布局组件相关配置
		//============================================
		// 动态布局
		'_home_layout'		=> '',
		
		// 页面显示内容
		'show_val'	=> [
			'logo_text'		=> '管理控制台',
		],
		'single_panel'	=> [
			'panel_title'	=> '',
			'class'			=> 'panel-primary',
		],
		
		'upload_img'	=> '/static/common/img/upload_img.png',
		
		//主题
		//============================================
		'page_theme'	=> [
		
			'form_label_col'		=> 3,			// 表单label显示的列数
		
			'body_class'			=> '',
			
			'body_attr'				=> '',
		
			//
			'content_class'			=> '',
		
			//是否允许收起展开按钮
			'use_toggle_sidemenu'	=> 1,			// 1|0
			
			//navbar皮肤
			'navbar_skin' 			=> 'bg-skin01',//'bg-dark', 	// bg-primary|bg-info|bg-warning|bg-danger|bg-alert|bg-system|bg-success|bg-dark
			
			//sidebar皮肤
			'sidebar_skin'			=> 'sidebar-skin01',//'',//'',			// sidebar-dark|sidebar-light|sidebar-light light
			
			'sidebar_class'			=> 'nano nano-primary affix',
			
			//侧边栏呈现方式
			/*
			 * 	'sb-top'
				'.sb-l-o' - Sets Left Sidebar to "open"
				'.sb-l-m' - Sets Left Sidebar to "minified"
				'.sb-l-c' - Sets Left Sidebar to "closed"
				
				'.sb-r-o' - Sets Right Sidebar to "open"
				'.sb-r-c' - Sets Right Sidebar to "closed"
				---------------------------------------------------------------+
				Example: <body class="example-page sb-l-o sb-r-c">
				Results: Sidebar left Open, Sidebar right Closed
			 */
			'sidebar_position'			=> 'sb-l-o sb-r-c',		//sb-l-c（隐藏侧边：待调试有问题）|sb-top sb-top-sm（顶部）|sb-l-o sb-r-c（左侧）
			
			//面包屑导航
			'topbar_breadcrumb_class'	=> 'affix',
	
			//
			'topbar_nav_class'			=> 'affix ph10',
	
		],
		
		'page_show_config'	=> [
			'sidebar_position'			=> 'left',	// left | top | right
		],
		
		//tray_menu设置
		//============================================
		'tray_menu'	=> [			// tray 菜单
			'headHtml'		=> '',
			'headTitle'		=> '',
			'headList'		=> [],
			'menuList'		=> [],
		],
		'tray_right'	=> [		// tray 右侧内容区
			'is_empty'		=> 1,
			'empty_msg'		=> '暂无数据',
			'timelineList'	=> [],	// 时间线
			'help'			=> [
				'title'	=> '帮助中心',
				'link'	=> '',
				'item'	=> [],		// 各项帮助说明内容
			],
			'html'		=> '',		// 自定义html内容
		],
		'crumbsArr'		=> [],		// 面包屑导航
		'assign_data'	=> [],		// 需要最终赋值到页面的数据
		
	];
	
	public function _initialize(){
		$this->request_param = self::$init_param;	//$_GET;
	}
	
	
	/**
	 * 附加内容主题内容
	 * 2018-6-8 下午1:55:54
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function appendContentHtml($html)
	{
		$this->_view_vars['append_content_html'] = $html;
		return $this;
	}
	
	/**
	 * 隐藏左侧菜单
	 * 2018-1-17 下午12:28:02
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function hideLeftMenu()
	{
		$this->_view_vars['is_show_sidebar'] = 0;
		$this->_view_vars['page_theme']['body_class'] = 'hide-sidebar';
		return $this;	
	}
	
	/**
	 * 设置topbar返回按钮链接
	 * 2018-1-17 下午4:18:32
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setHeaderBackLink( $href )
	{
		$this->_view_vars['header_back_link'] = $href;
		return $this;
	}
	
	/**
	 * 配置页面主题
	 * @date: 2017-8-13 下午8:23:28
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setPageTheme($themeConfig)
	{
		$this->_view_vars['page_theme'] = array_replace($this->_view_vars['page_theme'], $themeConfig);
		return $this;
	}

	/**
	 * 设置form表单action地址
	 * @param unknown $url
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setFormAction($url)
	{
		$this->_view_vars['form_action'] = $url;
		return $this;
	}
	
	/**
	 * 设置form表单class值
	 * 2017-12-20 下午1:15:37
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setFormClass($form_class)
	{
		$this->_view_vars['form_class'] = $form_class;
		return $this;
	}
	
	//----------------------------------------------------------------------
	/**
	 * 设置TrayMenu
	 * @date: 2017-8-21 上午9:57:58
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setTrayMenu($trayConfig)
	{
		return $this->setTray($trayConfig,'tray_menu');
	}
		
	/**
	 * 设置TrayRight
	 * @date: 2017-9-6 下午11:02:16
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setTrayRight($trayConfig)
	{
		return $this->setTray($trayConfig,'tray_right');
	}
	
	/**
	 * 
	 * @date: 2017-9-7 上午12:33:30
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setTray($trayConfig,$key='tray_menu')
	{
		if(!$trayConfig)return $this;
		
		$trayConfig = array_replace($this->_view_vars[$key], $trayConfig);
		$this->_view_vars['is_show_tray']	= 1;
		
		switch ($key){
			case 'tray_menu':
				$this->_view_vars['is_show_tray_menu']	= 1;
				break;
			case 'tray_right':
				$this->_view_vars['is_show_tray_right']	= 1;
				// 时间线
				if( !empty($trayConfig['timelineList']) ){
					$default_data = ['bg_class'=>'dark','icon_class'=>'fa fa-tags','title'=>'','datetime'=>'','desc'=>''];
					foreach ($trayConfig['timelineList'] as $i=>$one){
						$trayConfig['timelineList'][$i] = array_replace($default_data, $one);
					}
				}
				// 不为空
				if( !empty($trayConfig['timelineList']) || !empty($trayConfig['html'])  || !empty($trayConfig['help']['item']) ){
					$trayConfig['is_empty'] = 0;
				}
				break;
		}
		
		//
		$this->_view_vars[$key] = $trayConfig;
		
		
		//vde($this->_view_vars);
		return $this->setPageTheme([
			'content_class'				=> 'table-layout',
			'topbar_breadcrumb_class'	=> '',
			'topbar_nav_class'			=> '',
			'body_attr'					=> 'data-spy="scroll" data-target="#nav-spy" data-offset="100"'
		]);
	}
	
	//----------------------------------------------------------------------
	/**
	 * 设置单个Panel面板config
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setSinglePanelConfig($config=[])
	{
		$this->_view_vars['single_panel'] = array_replace($this->_view_vars['single_panel'],$config);
		return $this;
	}
		
	/**
	 * 设置单个Panel面板标题
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setSinglePanelTitle($title='')
	{
		$this->_view_vars['single_panel']['panel_title'] = $title;
		return $this;
	}
	/**
	 * 设置单个Panel面板class
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setSinglePanelClass($class='')
	{
		$this->_view_vars['single_panel']['class'] = $class;
		return $this;
	}
	//----------------------------------------------------------------------
	
	
	
	/**
	 * 添加扩展css内容
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addCssContent($content){
		$this->_view_vars['extend']['extend_css_content'] .= $content;
		return $this;
	}
	
	/**
	 * 添加扩展js内容
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addJsContent($content){
		$this->_view_vars['extend']['extend_js_content'] .= $content;
		return $this;
	}
	
	/**
	 * 隐藏页面底部区域
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function hideFooter(){
		$this->_view_vars['is_show_footer'] 	= 0;
		return $this;
	}
	
	/**
	 * 隐藏form表单按钮
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function hideFormButton(){
		$this->_view_vars['is_show_form_button'] = 0;
		return $this;
	}
	
	
	/**
	 * 批量添加扩展文件
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addExtendFiles($files,$type='')
	{
		if( empty($files) )return $this;
		if( empty($type) ){
			if( is_array($files) ){
				foreach ($files as $key_type=>$file_arr){
					$type = $key_type;
					foreach ($file_arr as $file){
						switch ($type){
							case 'js':
								$this->_view_vars['extend']['append_js'][] = $file;
								break;
							case 'css':
								$this->_view_vars['extend']['append_css'][] = $file;
								break;
						}
					}
				}
			}else if( endwith($files,'.js') ){
				$this->_view_vars['extend']['append_js'][] = $files;
			}else if( endwith($files,'.css') ){
				$this->_view_vars['extend']['append_css'][] = $files;
			}
		}else{
			if( is_string($files) )$files = [$files];
			foreach ($files as $key_type=>$file){
				if( empty($type) ){
					$type = $key_type;
				}
				switch ($type){
					case 'js':
						$this->_view_vars['extend']['append_js'][] = $file;
						break;
					case 'css':
						$this->_view_vars['extend']['append_css'][] = $file;
						break;
				}
			}
		}
		
		return $this;
	}
	/**
	 * 添加js路径
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addJs($file){
		$this->_view_vars['extend']['append_js'][] = $file;
		return $this;
	}
	
	/**
	 * 添加css路径
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addCss($file){
		$this->_view_vars['extend']['append_css'][] = $file;
		return $this;
	}
	
	/**
	 * 设置侧边栏位置
	 * @date: 2017-8-13 下午11:53:16
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setSidebarPosition($position='')
	{
		if( $position ){	// 设置
			$this->_view_vars['page_show_config']['sidebar_position']==$position;
		}else{				// 相关属性赋值
			$sidebar_position = $this->_view_vars['page_show_config']['sidebar_position'];
			switch ($sidebar_position) {
				case 'top':
					$this->_view_vars['page_theme']['sidebar_position'] = 'sb-top sb-top-sm';
					$this->_view_vars['page_theme']['sidebar_class'] 	= 'affix';
					//$this->_view_vars['page_theme']['topbar_nav_class'] = '';
				break;
			}
		}
		return $this;
	}
	
	
	/**
	 * 
	 * 2018-6-29 下午8:52:16
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function beforeFetch()
	{
		
		$config = config();
		
		//vde( $this->_view_vars['tab_group'][0] );
		//vde($this->_view_vars['extend']);
		
		//组件及构建器相关文件
		$this->assignExtendFile();
		
		// 设置侧边栏位置
		$this->setSidebarPosition();		
		//vd($this->_view_vars['custom_widget'][0]);vd($this->_view_vars['custom_widget'][0][0]['widgets']);vde($this->_view_vars['custom_widget']);
				
		$this->_view_vars['page_theme']['form_value_col'] = 12 - $this->_view_vars['page_theme']['form_label_col'];
		$this->_view_vars['form_action'] = (empty($this->_view_vars['form_action']))?'':$this->_view_vars['form_action'];
		
		//vd($this->_view_vars['page_theme']);
		// 执行不同构建器赋值方法
		//$this->assignVars();
		$this->assignAllVars();
		
		$view_replace_str = config('template.tpl_replace_string');
		foreach ($view_replace_str as $key=>$val){
			$this->_view_vars['extend']['extend_css'] = str_replace($key, $val, $this->_view_vars['extend']['extend_css']);
			$this->_view_vars['extend']['extend_js']  = str_replace($key, $val, $this->_view_vars['extend']['extend_js']);
		}
		
		/*
		// 微信环境下
		switch ( SECOND_DOMAIN ){
			case 'weixin':
				// 微信环境下，加载微信相关数据
				$this->loadWeChatResource();
				break;
		}
		*/
		
		// 赋值到页面上
		$this->assign('_view_vars',$this->_view_vars);
		$this->assign('config',$config);
		//$admin_current_view_base_layout = $config['admin_current_view_base_layout'];
		$this->assign([
// 				'_admin_base_layout' => $config[ $admin_current_view_base_layout ],
// 				'_admin_view_public' => $config['admin_view_public'],
				'userinfo'			 => session('user_auth'),
				// 2017.12.25	新版布局变量（依据当前应用所处环境动态设置）
				'_home_layout'		 => $this->_view_vars['_home_layout'],
		]);
		//$this->assign( $this->_view_vars['assign_data'] );
		
		
		//$template = $template.'?t=2';
		//vd($template);vd($config['admin_view_public']);vde( $config[ $admin_current_view_base_layout ] );
	}
	
	/*
	public function fetch($template = '', $vars = [], $replace = [], $config = [])
	{
		
		$config = config();
		
		$this->beforeFetch();
		
		
		
		// #NOT# 此处有个问题，不缓存效率底，缓存无法使用自定义布局（后面再解决）
		$config['tpl_cache'] = false;
		
		if( $this->twObj==null ){
			$this->twObj = TWidget($this);
		}
		
		$this->assign('contObj',$this);
		//vd( $this->contObj );
		
		
		// 此处调整，如果是ajax请求，则只加载内容，否则将模版置于布局中加载
		
		
		$template = str_replace('\\', '/', $template);
		$template = str_replace('//', '/', $template);
		
		//vde($template);
		return parent::fetch($template, $vars, $replace, $config);
	}
	*/
	
	
	
	
	/**
	 * 增加一批topbar_menu
	 *
	 * @date 2017-5-29 上午10:22:09
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addTopBarMenus($topbar_menu_configs){
		foreach ($topbar_menu_configs as $topbar_menu_config){
			$this->addTopBarMenu($topbar_menu_config);
		}
		return $this;
	}
	/**
	 * 增加一个topbar_menu
	 *
	 * @date 2017-5-26 下午2:14:02
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addTopBarMenu($topbar_menu_config=[]){
		$this->_view_vars['topbar_type'] = 2;
		
		$topbar_menu_config_default = [
			'icon_class'	=> '',
			'title'			=> '',
			'href'			=> '',
			'is_active'		=> false,
			'class'			=> '',
			'active_rule'	=> '',	// 高亮使用的规则	CONTROLLER_NAME	ACTION_NAME
			'active_key'	=> '',	// 高亮使用的key（URL参数）
			'active_val'	=> '',	// 高亮规则所匹配的值
		];
		$topbar_menu_config = array_replace($topbar_menu_config_default, $topbar_menu_config);
		
		//------------------------------------------------------
		$active_rule = $topbar_menu_config['active_rule'];
		$active_key  = $topbar_menu_config['active_key'];
		$active_val  = strtolower($topbar_menu_config['active_val']);
		
		$href_split = explode('.html', $topbar_menu_config['href']);
		$href_split = strtolower(trim($href_split[0],'/'));
		$href_split = explode('/', $href_split);
		
		if( $active_key && $active_val==I($active_key,'') ){
			$topbar_menu_config['is_active'] = true;
		}else if( $active_rule ){
			switch ( strtoupper($active_rule) ){
				case 'CN':
				case 'CONTROLLER_NAME':
					if( empty($active_val) && in_array(strtolower(CONTROLLER_NAME), $href_split)){
						$topbar_menu_config['is_active'] = true;
					}else if( strtolower(CONTROLLER_NAME)==$active_val ){
						$topbar_menu_config['is_active'] = true;
					}
					break;
				case 'AN':
				case 'ACTION_NAME':
					if( empty($active_val) && in_array(strtolower(ACTION_NAME), $href_split)){
						$topbar_menu_config['is_active'] = true;
					}else if( strtolower(ACTION_NAME)==$active_val ){
						$topbar_menu_config['is_active'] = true;
					}
					break;
			}
		}
		//------------------------------------------------------
		
		
		
		if( $topbar_menu_config['is_active'] ){
			$topbar_menu_config['class'] 	.= ' active';
			$topbar_menu_config['href'] 	=  'javascript:;';
		}
		
		if( !empty($topbar_menu_config['title']) ){
			$this->_view_vars['topbar_menus'][] = $topbar_menu_config;
		}
		return $this;
	}
	/**
	 * 增加一个topbar_button
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addTopBarButton($btn_config=[])
	{
		$this->createBtn('topbar_buttons',$btn_config);
		return $this;
	}
	/**
	 * 增加多个topbar_button
	 * @date: 2017-10-6 上午8:39:48
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addTopBarButtons($btn_configs)
	{
		foreach ($btn_configs as $btn_config){
			$this->createBtn('topbar_buttons',$btn_config);
		}
		return $this;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	// +----------------------------------------------------------------------
	// | 按钮操作公共方法区相关
	// +----------------------------------------------------------------------
	/**
	 * 添加一组按钮
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addButtons($btn_keys, $btn_group_key)
	{
		$btn_keys = explode(',', $btn_keys);			//用逗号拆分出多个按钮的配置
		foreach ($btn_keys as $key){
			$default = ['',''];
			$single_btn_config = explode('|', $key);	//配置组中按照|号分割成不同的参数。目前为type.|href_param
			$single_btn_config = array_replace($default, $single_btn_config);
			
			list($type, $href_param) = $single_btn_config;
			$type_arr = explode('.', $type);
			$btn_config = [
				'type'		=> $type_arr[0],
				'href_param'=> $href_param
			];
			if( isset($type_arr[1]) && !empty($type_arr[1]) ){
				$btn_config['href_base'] = $type_arr[1];
			}
			 
			$this->createBtn($btn_group_key,$btn_config);
		}
		return $this;
	}
	
	
	
	/**
	 * 格式化按钮配置，生成并加入按钮组中
	 * @param unknown $btn_group_key
	 * @param unknown $btn_config
	 */
	public function createBtn( $btn_group_key, $btn_config )
	{
		$this->_view_vars[$btn_group_key][] = $this->getBtnConfig($btn_config,$btn_group_key);
		return $this;
	}
	
	/**
	 * 生成页面可用按钮格式
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	protected function getBtnConfig( $btn_config,$btn_group_key='' )
	{
		$default_config = array(
				'title'				=> '',		// 按钮文字名称
				'item_class'		=> '',		// 按钮节点附加class
				'append_item_class'	=> '',		// 在原按钮的样式上追加的class样式
				'icon_class'		=> '',		// 按钮图标class
				'href'				=> '',		// 按钮链接（当指定此值时，其他链接参数无效）
				'href_base'			=> '',		// 链接基础地址
				'href_param'		=> '',		// 链接参数，默认取主键值	$this->pk_name
				'href_param_key'	=> [],		// 参与生成链接的key
				'attr'				=> [],		// 按钮附加属性
				'popup'				=> false,	// 弹出框展示内容
				'target'			=> '_self',	// 链接打开方式
				'show_map'			=> [],		// 是否显示按钮配置条件
		);
		
		//系统预定义按钮配置
		$sysBtns = [
			'add'	=> [
				'title'			=> '新增',
				'icon_class'	=> 'fa fa-plus',
				'item_class'	=> 'btn-primary',
				'href_base'		=> 'add',
			],
			'sort'	=> [
				'title'			=> '排序',
				'icon_class'	=> 'fa fa-sort-amount-asc',
				'href_base'		=> 'sort',
			],
			'edit'	=> [
				'title'			=> '编辑',
				'icon_class'	=> 'fa fa-pencil-square-o',
				'item_class'	=> 'btn-info',
				'href_base'		=> 'edit',
			],
			//----------------------------------------------------------------
			'del'	=> [
				'title'			=> '删除',
				'icon_class'	=> 'fa fa-trash-o',
				'item_class'	=> 'btn-danger ajax-post confirm',
				'href_base'		=> 'del',
				'attr'			=> []
			],
			'recycle'	=> [
				'title'			=> '移入回收站',
				'icon_class'	=> 'fa fa-trash-o',
				'item_class'	=> 'btn-danger ajax-post confirm',
				'href_base'		=> 'recycle',
			],
			'download'	=> [
				'title'			=> '导出',
				'icon_class'	=> 'fa fa-download',
				'item_class'	=> 'btn-primary',
				'href_base'		=> 'download',
			],
			'download_all'	=> [
				'title'			=> '导出全部',
				'icon_class'	=> 'fa fa-download',
				'item_class'	=> 'btn-primary',
				'href_base'		=> 'download_all',
			],
			
			'enable'	=> [
				'title'			=> '启用',
				'item_class'	=> 'btn-success ajax-post',
				'icon_class'	=> 'fa fa-check',
				'href_base'		=> 'enable',
			],
			'disable'	=> [
				'title'			=> '禁用',
				'item_class'	=> 'btn-warning ajax-post',
				'icon_class'	=> 'fa fa-ban',
				'href_base'		=> 'disable',
			],
			//----------------------------------------------------------------
			'custom'=> [
				'title'			=> '',
				'icon_class'	=> '',
			],
		];
		
		
		 
	
		//默认为自定义按钮
		$btn_config['type'] = get_arr_val($btn_config, 'type', 'custom');
	
		if( isset( $sysBtns[ $btn_config['type'] ]) ){
			$default_config = array_replace($default_config, $sysBtns[ $btn_config['type'] ]);
		}
		$btn_config 	= array_replace($default_config, $btn_config);
		$current_param 	= [];	// 当前页面参数
		/*
		$request_param = request()->request();
		vde( $request_param );
		*/
		switch ( $btn_group_key ) {
			case 'top_btns':		//Table页顶部操作按钮
				//加上相关属性
				switch ( $btn_config['type'] ){
					case 'del':
					case 'recycle':
					case 'download':
					case 'download_all':
					case 'enable':
					case 'disable':
						if( in_array($btn_config['type'], ['download','download_all']) ){	// 导出操作，默认需要带上当前的条件
							
						}
						$btn_config['attr']['target-form'] = 'ids';
						break;
				}
				break;
			case 'list_item_btns':	//Table列表页相关操作按钮
				if( $btn_config['href_param']=='' ){
					$btn_config['href_param'] = $this->pk_name;	//id
				}
				// 将按钮默认的post提交改成get
				$btn_config['item_class'] = str_replace('ajax-post', 'ajax-get', $btn_config['item_class']);
				break;
		}
		
		//弹出框展示
		if( $btn_config['popup'] ){
			$btn_config['item_class'] .= ' popup';
			$this->recordWidget('magnific');
		}
		$btn_config['item_class'] .= ' '.$btn_config['append_item_class'];
		
		//当未指定具体的链接地址时，使用相关配置参数生成
		if( empty($btn_config['href']) ){
			//生成按钮链接
			if( is_string($btn_config['href_param']) ){
				$btn_config['href_param'] = explode('+', $btn_config['href_param']);	//通过+号可以添加多个字段到数组中
			}
	
			//将参数置入url参数变量中
			$param = [];
			foreach ($btn_config['href_param'] as $i=>$one){
				if( is_string($one) && $one ){
					/*
					$val = ($btn_group_key=='top_btns')?get_arr_val($this->request_param, $one, ''):'__'.$one.'__';
					$btn_config['href_param_key'][] = $one;
					$param[$one] = $val;
					*/
					$one_param = explode('.', $one);	//通过.给字段设置别名（请求参数字段名.列表数据字段），如果没有.则参数字段和数据字段使用同一个字段名
					$key_field = $one_param[0];
					$val_field = get_arr_val($one_param, 1, $key_field);
	
					$val = ($btn_group_key=='top_btns')?get_arr_val($this->request_param, $val_field, ''):'__'.$val_field.'__';
					$btn_config['href_param_key'][] = $val_field;
					$param[$key_field] 				= $val;
				}else{
					//...
				}
			}
			
			//href_base
			//	为数组时，第一个为基础url，第二个为固定参数数组。
			//	为字符串时，仅为基础url
			if( is_array($btn_config['href_base']) ){
				$param = array_replace($btn_config['href_base'][1], $param);
				$btn_config['href'] = url($btn_config['href_base'][0],$param);
			}else{
				$btn_config['href'] = url($btn_config['href_base'],$param);
			}
		}
		 
		 
		//属性完整内容显示字符串
		$attr_str = 'target="'.$btn_config['target'].'"';
		foreach ($btn_config['attr'] as $key=>$val){
			$attr_str .= ' '.$key.'="'.$val.'" ';
		}
		$btn_config['attr_str'] = $attr_str;
		
		return $btn_config;
	}


	/**
	 * 模板变量赋值
	 * @access protected
	 * @param mixed $name  要显示的模板变量
	 * @param mixed $value 变量的值
	 * @return void
	 */
	public function assign($name, $value = ''){
		//parent::assign($name, $value);
		/*
		// 待定尚需验证
		if( is_array($name) ){
			$this->_view_vars['assign_data'] = array_replace($this->_view_vars['assign_data'], $name);
		}else{
			$this->_view_vars['assign_data'][$name] = $value;
		}
		*/
		return $this;
	}
	
	
	/**
	 * 设置需要登录的页面记录地址（有此值登录成功后会跳转到当前页面）
	 * 2018-4-16 上午9:23:45
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setBackKey($key)
	{
		cookie('login_from_type','just_jump');
		//$login_from_aim = cookie('login_from_aim');
		cookie('login_http_referer');
		
		return $this;
	}


	// +----------------------------------------------------------------------
	// | 文件扩展
	// +----------------------------------------------------------------------
	/**
	 * 增加组件调用记录
	 */
	public function recordWidget($widget_type,$widget_sub_type='',$field='')
	{
		// 不存在的加入使用中队列
		if( !in_array($widget_type, $this->_view_vars['widgets_in_use']) ){
			$this->_view_vars['widgets_in_use'][] = $widget_type;
		}
		// 加入子组件队列
		if( !in_array($widget_sub_type, $this->_view_vars['widgets_sub_in_use']) ){
			$this->_view_vars['widgets_sub_in_use'][] = $widget_sub_type;
		}
		if( !isset($this->_view_vars['widgets_field'][$widget_type]) ){
			$this->_view_vars['widgets_field'][$widget_type] = array();
		}
		// 组件涉及到的字段
		if( $field ){
			$this->_view_vars['widgets_field'][$widget_type][] = $field;
		}
		return $this;	
	}
	public function recordWidgets($widgets){
		foreach ($widgets as $widget){
			$default_widget = [[],'',''];
			$widget = array_replace($default_widget, $widget);
			$this->recordWidget($widget[0],$widget[1],$widget[2]);
		}
		return $this;
	}
	
	/**
	 * 组件及构建器相关文件
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	protected function assignExtendFile(){
		//扩展组件依赖类库
		//$extend = $this->_view_vars['extend'];
	
		// 加载当前页面用到的组件依赖文件
		if( $this->_view_vars['widgets_in_use'] ){
                    
                        //vde( WHALE_BUILDER_PATH . 'widgets_config.php' );
                    
			//加载组件配置文件
			$widgets_config = require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'builder' . DIRECTORY_SEPARATOR . 'widgets_config.php';
			
			//所有启用的组件
			$widgets = $this->_view_vars['widgets_in_use'];
			
			//循环加载拼接
			foreach ( $widgets as $widget ){
	
				$widget_arr = explode('.', $widget);
				if( count($widget_arr)==2 ){
					$widget = $widget_arr[0];
				}
	
				if( isset($widgets_config[$widget]) ){
					$wconfig = $widgets_config[$widget];
					if( isset($widget_arr[1]) && isset($wconfig[ $widget_arr[1] ]) ){
						$wconfig = $wconfig[ $widget_arr[1] ];
					}
					$this->appendExtendFile($wconfig);
				}
			}
		}
		//vde($this->_view_vars['extend']);
		// 加载指定js及css文件
		if( !empty($this->_view_vars['extend']['append_js']) ){
			foreach ($this->_view_vars['extend']['append_js'] as $file_path){
				$this->appendOneExtendFile($file_path, 'js');
			}
		}
		if( !empty($this->_view_vars['extend']['append_css']) ){
			foreach ($this->_view_vars['extend']['append_css'] as $file_path){
				$this->appendOneExtendFile($file_path, 'css');
			}
		}
		//vde($extend);
		//组件及构建器相关文件
		//$this->assign(['widgets_in_use'=>$this->widgets_in_use]);
	}
	
	/**
	 * 加入一组扩展文件
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	protected function appendExtendFile($wconfig){
		if( empty($wconfig) )return;
		foreach ($wconfig as $type=>$file_arr){
			if($type=='jq'){
				$this->_view_vars['extend']['extend_js'] .= '<script src="__VENDOR__/jquery/jquery-'.$file_arr['version'].'.min.js"></script>';
				$this->_view_vars['extend']['extend_js'] .= '<script type="text/javascript">var '.$file_arr['alias'].' = $.noConflict();</script>';
			}else{
				if( empty($file_arr) )continue;
				foreach ($file_arr as $file_path){
					$this->appendOneExtendFile($file_path, $type);
				}
			}
		}
		// 如果使用了其他版本的jquery库，则在加载完该版本的相关插件后对基础jquery进行恢复
		if( isset($wconfig['jq']) ){
			$this->_view_vars['extend']['extend_js'] .= '<script type="text/javascript">window.jQuery = jQuery = $ = $311;</script>';
		}
	}
	
	/**
	 * 加入单个扩展文件
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	protected function appendOneExtendFile($file_path,$type){
		// 判断是否已存在
			
		// 追加
		switch ($type){
			case 'js':
				$this->_view_vars['extend']['extend_js'] .= '<script src="'.$file_path.'"></script>';
				break;
			case 'css':
				$this->_view_vars['extend']['extend_css'] .= '<link href="'.$file_path.'" rel="stylesheet" />';
				break;
		}
	}
	
	
	
	
	
	/**
	 *
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setWidgetsValues($info,$is_uses_get=true){
	
		if($is_uses_get ){
			//vd($this->request_param);vde($info);
			if( $info ){
				$info = array_replace($this->request_param, $info);
			}else{
				$info = $this->request_param;
			}
		}
		$this->widgetsValues = $info;
	
		return $this;
	}
	
	
	
	
	/**
	 * 
	 * 2018-2-26 上午10:14:07
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setShareImgById($pic_id)
	{
		if( $pic_id ){
			$this->_view_vars['jsSignConf']['shareData']['imgUrl'] = get_cover($pic_id,true);
		}
		return $this;
	}
	
	/**
	 * 
	 * 2018-2-26 上午10:17:08
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setShareInfo($optionArr)
	{
		foreach ($optionArr as $key=>$val){
			if($key=='pic_id'){
				$this->setShareImgById($val);
			}else{
				$this->_view_vars[$key] = $val;
			}
		}
	}
	
	
	
	
	
	/**
	 * 批量设置数据列（格式化数据列）
	 * @param array $columns
	 * 			[[field,name,config]]
	 * 			参数1		字段信息
	 * 						field展示类型，如果可以直接编辑则以.号分割，其后加入编辑类型
	 * 			参数2		字段名称
	 * 			参数3		展示配置
	 * 						type		展示类型
	 * 							field	// field . xedit type
	 * 							url
	 * 							btn		// type . url | 参数
	 * 
	 * 						// type为field，对显示内容进行二次处理的函数
	 * 						func		对字段处理的函数名称，参数为当前值
	 * 						func_param	当存在对字段处理的函数时，此值为为该函数的第二个参数
	 * 
	 * 						config_name	配置参数名。当func为c_name时且func_param未传值，此值可替代func_param。
	 * 									当type为field且可编辑时，此为编辑选择数据源。
	 * 
	 * 						// 附加数据select2
	 * 						data		下拉的数据
	 * 						key_relevance	使用的字段，使用 | 分割值与显示用字段，'id|name'
	 * 
	 * 						table_field 获取指定表的指定字段的值，使用 | 分割表与表字段(影响速度，不建议使用)
	 * 						
	 * 						icon_prefix_class_field		前置图标字段名称
	 * 						icon_prefix_class			前置图标class值
	 * 
	 * 						// type为btn有效
	 * 						btn_config	按钮相关配置
	 * 
	 * 						// type为url有效
	 * 						url			展示类型为url时,当type为url时生效
	 * 						url_param	展示类型为url时参数配置,当type为url时生效
	 * 
	 * 						// 样式相关
	 *						style
	 * 
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	function formatColumns($columns)
	{
		$temp = [];
		foreach ($columns as $i=>$one){
				
			//更多配置
			$one[2] = (isset($one[2]))?$one[2]:[];
			$defaultConfig = [
				//展示类型
				'type'				=> 'field',		//展示类型
				//field
				// field . xedit type
				//url
				//btn
				// type . url | 参数
				//type为field，对显示内容进行二次处理的函数
				'func'				=> '',			// 对字段处理的函数名称，参数为当前值
				'func_param'		=> '',			// 当存在对字段处理的函数时，此值为为该函数的第二个参数
		
				'table_field'		=> '',			// 获取指定表的指定字段的值，使用 | 分割表与表字段(影响速度，不建议使用)
		
				'config_name'		=> null,		// 使用配置中的数据值
		
				//附加数据select2
				'listdata'			=> [],			// 下拉的数据
				'key_relevance'		=> 'id|name',	// 使用的字段
				//'data_empty'		=> '',			// 此值一旦设置，则在未成功匹配到数据的时候，用此值替换
		
				//type为btn有效
				'btn_config'		=> [],			// 按钮相关配置
		
				//type为url有效
				'url'				=> '',			// 基础url,当type为url时生效
				'url_param'			=> '',			// 基础url参数配置,当type为url时生效
		
				//样式相关
				'style'				=> '',
					
				//字段排序
				'order'				=> false,		// 是否开启，默认关闭
				'order_url'			=> '',
				'order_icon'		=> 'fa fa-sort text-muted',
		
				// 字段前后附加内容
				'prepend_content'	=> '',			// 向前追加
				'append_content'	=> '',			// 向后追加
				'bottom_html'		=> '',			// 换行追加
			];
				
			// 列表数据最终由get_tval格式化
			$config  = array_replace($defaultConfig,$one[2]);
	
	
			$tempOne = [
				'field'		=> $one[0],
				'name'		=> $one[1],
				'config'	=> $config,
			];
	
			//$temp[] = $tempOne;
			// 字段解析、插件加载
			//------------------------------------------------------------------
			$config = $tempOne['config'];
			// 			get_tval();
			switch ( $config['type'] ){		//基础类型
				case 'btn':		//按钮
					$btn_keys			= $tempOne['field'];
					if( empty($btn_keys) )continue;
					$this->addButtons($btn_keys, 'list_item_btns');
					$tempOne['btns']	= $this->_view_vars['list_item_btns'];
					break;
				case 'field':	//普通字段
					$fieldInfo = explode('.', $tempOne['field']);
					$tempOne['field'] 	= $fieldInfo[0];
		
					// 快速编辑
					//---------------------------------------------------
					$tempOne['xedit']	= get_arr_val($fieldInfo, 1, '');
					if( $tempOne['xedit']!='' ){
						if( in_array($tempOne['xedit'], ['tags','select2']) ){
							$this->recordWidget('select2');
						}
						$this->recordWidget('x-editable',$tempOne['xedit']);
					}
					break;
				case 'img':	//图片
					$this->recordWidget('magnific');
					break;
			}

			// 开启了字段排序
			if( $tempOne['config']['order'] ){
				$param 			= request()->param();
				$_order_by 		= 'desc';
				if( is_string($tempOne['config']['order']) ){
					$_order_field 	= $tempOne['config']['order'];
				}else{
					$_order_field 	= $tempOne['field'];
				}
				$order_url 		= request()->baseUrl();
				if( isset($param['_order_field']) && $param['_order_field']==$_order_field ){
					switch ($param['_order_by']){	// 当前排序类型
						case 'desc':
							$_order_by = 'asc';
							$tempOne['config']['order_icon'] = 'fa fa-caret-down';
							break;
						case 'asc':
							$_order_by = '';
							$tempOne['config']['order_icon'] = 'fa fa-caret-up';
							break;
					}
				}				
				$tempOne['config']['order_url'] = $order_url . '?_order_by='.$_order_by.'&_order_field='.$_order_field;
			}
			
			$temp[] = $tempOne;
			//------------------------------------------------------------------
		}
		
		$this->_view_vars['columns'] = $temp;
		
		return $temp;
	}
	
}


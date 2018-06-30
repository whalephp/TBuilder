<?php
namespace whalephp\tbuilder;


use think\Exception;
use whalephp\tbuilder\builder\form\Builder;

/**
 * 模版构建器
 * @package app\common\builder
 */
class TBuilder	// extends CommonBase
{
	use traits\ViewSetting;
	
	
    static private $template;							//当前构建器使用的布局文件
    
    protected $template_view_path;						//模版地址
    
    static protected $columns;							//展示的数据列
    protected $topFilters;								//顶部筛选器
    protected $pk_name 				= 'id';				//主键字段名称
    protected $builder_type			= '';
    protected $request;
    
    
    /*
    //页面元素变量
    protected $_view_vars = [
    	//
	    'top_btns'			=> [],		//顶部按钮
	    'top_tab_btns'		=> [],
	    'list_item_btns'	=> [],		//列表按钮
    	
	    //
	    'widgets_field'		=> [],		//组件-字段对于数组
	    
	    //tab分组信息存储
	    'current_tab_num'	=> 0,
	    'tab_group'			=> [],		// tab分组
	    
	    'form_action'		=> '',
	    
	    'columns'			=> [],		// 展示列
    ];
    */
    
	/**
	 * 初始化Builder组件
	 * 2017-12-6 上午9:57:55
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function initBuilder()
	{
		if( $this->request->param('modal_show')==1 ){
			$this->hideFormButton();
		}
		return $this;
	}
    
    /**
     * 创建各种builder的入口
     * @param string $type 构建器名称，'Form', 'Table', 'View' 或其他自定义构建器
     * @param string $action 动作
     * @return mixed
     * @throws Exception
     */
    public static function createBuilder($type = '', &$obj = null)
    {
    	if ($type == '') {
    		throw new Exception('未指定构建器名称', 8001);
    	} else {
    		$type = strtolower($type);
    	}
    
//     	new \whalephp\tbuilder\builder\table\Builder();
//     	exit();
    	
    	// 构造器类路径
    	$class = '\\whalephp\\tbuilder\\builder\\'. $type .'\\Builder';
    	if (!class_exists($class)) {
    		throw new Exception($type . '构建器不存在', 8002);
    	}
    
    	$newObj = new $class;
    	if( $obj ){
    		$newObj->contObj 	= $obj;
    		//$newObj->_view_vars = $obj->_view_vars;	// 2017.12.15
    	}
    	
    	//加入组件类型中（ builder_common.tree 二层数组类配置 ）
    	$newObj->recordWidget( 'builder_common.' . $type );
    	$newObj->request_param = request()->param();
    	//vde( $newObj->request_param );
    	
    	$newObj->builder_type = $type;
    	
    	define('DS', DIRECTORY_SEPARATOR);
//     	defined('APP_PATH') or define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . DS);
//     	defined('ROOT_PATH') or define('ROOT_PATH', dirname(realpath(APP_PATH)) . DS);
//     	vd(APP_PATH);vd(ROOT_PATH);

    	
    	
    	defined('TBUILDER_PATH') or define('TBUILDER_PATH', dirname(__FILE__) . DS);
    	
    	//vd( TBUILDER_PATH );
    	
    	$newObj->template_view_path =  TBUILDER_PATH . '\\builder\\'. $type .'\\views';
    	
    	// $newObj->template_view_path = APP_PATH . '\\common\\builder\\'. $type .'\\views';
    	
    	//$newObj->template_view_path = '';
    	//vde($newObj->template_view_path);
    	
    	$newObj->request = request();
    	$newObj->initBuilder();
    	
//     	vde($newObj->_view_vars);
    	//设置builder布局模板
    	return $newObj;
    }
    
    /**
     * 设置指定布局模板
     * @param unknown $layout_view
     */
    public function layoutView( $layout_view ){
    	$this->_view_vars['layout_view'] = $layout_view;
    	return $this;
    }

    
    // +----------------------------------------------------------------------
    // | 按钮相关
    // +----------------------------------------------------------------------
    /**
     * 设置listButton每行显示数量
     * @date: 2017-10-8 上午10:36:32
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function setListButtonLineNum($num)
    {
    	$this->_view_vars['list_button_line_num'] = $num;
    	return $this;
    }
    
    /**
     * 顶部按钮生成
     * @date: 2017-4-24 下午8:42:41
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function addTopButtons( $btn_keys )
    {
    	return $this->addButtons($btn_keys, 'top_btns');
    }
    /**
     * 添加列表按钮
     * 
     * @date 2017-5-22 下午9:58:10
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function addListButton( $btn_config )
    {
    	$this->createBtn('list_item_btns',$btn_config);
    	return $this;
    }
    /**
     * 创建顶部菜单
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function addTopButton($btn_config)
    {
    	$this->createBtn('top_btns',$btn_config);
    	return $this;
    }
    
    /**
     * 创建顶部右侧菜单
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function addTopRightButton($btn_config)
    {
    	$this->createBtn('top_right_btns',$btn_config);
    	return $this;
    }
    
    /**
     * 创建顶部tab上的按钮
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function addTopTabButton($btn_config)
    {
    	$this->createBtn('top_tab_btns',$btn_config);
    	return $this;
    }
    
    // +----------------------------------------------------------------------
    // | 顶部tab相关
    // +----------------------------------------------------------------------
    /**
     * 批量添加一批tab
     * @param array $groups	组合信息数组
     * 					[title,val]	可多组
     * 						title	tab组标题
     * 						val		tab标识
     * 
     * @param array $config			组别配置信息
     * 					url			url地址
     * 					key			url参数字段，配合每组中的val生成完整的url
     * 					current_val	当前选中的值，默认为空，为空则选第一个
     * 					field		组别数组中使用的字段，默认为：title|val，可重新指定
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function addTabGroups($groups,$config)
    {
    	$current_empty_val = time() . rand(10000, 99999);
    	$default_config = [
    		'url'			=> '',
    		'key'			=> '',
    		'current_val'	=> $current_empty_val,
    		'field'			=> 'title|val',
    	];
    	$config = array_replace($default_config, $config);
    	list($title_field,$val_field) =	explode('|', $config['field']); 
    	
    	foreach ($groups as $num=>$group){
    		$is_active 	= false;
    		$val 		= $group[$val_field];
    		if( ($config['current_val']==$current_empty_val && $num==0) || (string)$config['current_val']===(string)$val ){
    			$is_active = true;
    		}
    		$url = url($config['url'],[$config['key']=>$val]);
    		$this->addTabGroup($group[$title_field],$is_active,$url);
    	}
    	return $this;
    }
    
    /**
     * 添加一个tab
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function addTabGroup($group_title,$is_active=null,$url=null)
    {
    	$this->_view_vars['current_tab_num'] = count( $this->_view_vars['tab_group'] );
    
    	$li_class = '';
    	if( $url ){
    		$tab_href = $url;
    		$tab_type = 'url';
    	}else{
    		$tab_href = '#tab_' . $this->_view_vars['current_tab_num'];
    		$tab_type = 'tab';
    	}
    
    	if( $is_active===true || ($is_active===null && $this->_view_vars['current_tab_num']==0) ){
    		$li_class = 'active';
    	}
    	
    	$this->_view_vars['tab_group'][ $this->_view_vars['current_tab_num'] ] = array(
    			'tab_num'		=> $this->_view_vars['current_tab_num'],
    			'group_title'	=> $group_title,
    			'li_class'		=> $li_class,
    			'tab_href'		=> $tab_href,
    			'tab_type'		=> $tab_type,
    			'group_wigets'	=> [],
    			'append_html'	=> '',		// tab底部附加html内容
    	);
    	
    	if( !empty($group_title) ){
    		$this->_view_vars['tab_group_show_num']++;
    	}
    	
    
    	$this->_view_vars['tab_group'][ $this->_view_vars['current_tab_num'] ]['group_wigets'] = [];
    
    	//dump($this->_view_vars);
    	
    	return $this;
    }
    
    /**
     * 检查当前tab信息，无则进行初始化
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    protected function checkInitCurrentTab(){
    	if( !isset($this->_view_vars['tab_group'][ $this->_view_vars['current_tab_num'] ]) || empty($this->_view_vars['tab_group'][ $this->_view_vars['current_tab_num'] ])){
    		$this->_view_vars['tab_group'][ $this->_view_vars['current_tab_num'] ] = array(
    				'tab_num' 		=> $this->_view_vars['current_tab_num'],
    				'group_title' 	=> '',
    				'li_class' 		=> 'active',
    				'tab_href' 		=> '#tab_'.$this->_view_vars['current_tab_num'],
    				'tab_type' 		=> 'tab',
    				'group_wigets'	=> [],
    				'append_html'	=> '',		// tab底部附加html内容
    		);
    	}
    }
    
    /**
     * tab信息格式化
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    protected function assignTabGroup(){
    	$widgetsValues 	= $this->widgetsValues;
    	$tabGroup		= $this->_view_vars['tab_group'];
//     			vd($widgetsValues);
    	// 		vde($tabGroup);
    	
    	//将组件挂在到tab分组中
    	if( !empty($widgetsValues) ){
    		//vde($tabGroup);
    		foreach ($tabGroup as $key=>$group){
    			foreach ($group['group_wigets'] as $i=>$one){
    				if( !isset($one['field']) )continue;
    				$field = $one['field'];
    				$field = str_replace('[]', '', $field);
    				if( isset($widgetsValues[$field]) ){
//     					$tabGroup[$key]['group_wigets'][$i]['value'] = $widgetsValues[$field];
    					$tabGroup[$key]['group_wigets'][$i]['value'] = $widgetsValues[$field];//get_arr_val($widgetsValues,$field);//$widgetsValues[$field];
    				}
    			}
    		}
    	}
    	$this->_view_vars['tab_group'] 	= $tabGroup;
    }
    
 
    
    /**
     * 设置列表数据
     * @date: 2017-4-23 下午11:24:33
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function setRowList($list)
    {
    	
    	//vde($this->param);
    	
    	$this->assign(['list'=>$list]);
    	return $this;
    }
    
    
    
    
    
    
    
    // +----------------------------------------------------------------------
    // | 赋值、生成页面
    // +----------------------------------------------------------------------
    
    public function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
    	// 包含布局地址
    	self::$template = APP_PATH . '\\common\\builder\\'. $this->builder_type .'\\'.$this->_view_vars['layout_view'].'.html';
    	if( $template=='' ){
    		$template = self::$template;
    	}
    	//vde($this->widgets_in_use);
    	
    	// 对所有变量进行格式化赋值转换
    	$this->assignAllVars();
    	//$this->assign('template_view_path',self::$template_view_path);
    	
    	return parent::fetch($template, $vars, $replace, $config);
    }
    
    /**
     * 对所有变量进行格式化赋值转换
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function assignAllVars()
    {
    	
    	//Tab信息格式化
    	$this->assignTabGroup();
    	
    	//各构建器独特的变量赋值
    	$this->assignVars();
    	
    	//vde($this->_view_vars['columns']);
    	//vde($this->_view_vars);
    	//$this->assign('_vars',$this->_view_vars);
    }
    
    /**
     * 各构建器独特的变量赋值
     *
     * @date 2017-5-22 下午3:40:02
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    protected function assignVars(){}
    

    /**
     * 设置请求参数
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    public function setRequestParam($request_param){
    	$this->request_param = $request_param;
    	return $this;
    }
    
    
    //=======================================================================//
    //						   			公共方法区								 //
    //=======================================================================//
	/**
	 * 解码数组参数
	 * 		1、将索引数组转换为关联数组
	 * 		2、加载相关配置需要的引用文件及附加属性
	 * 		3、填充默认配置信息
	 * @date: 2017-8-14 上午11:56:29
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function decodeWidgetParameterArr($parameterArr)
	{
		$data_info			= (isset($parameterArr))?$parameterArr:[[],''];
		$default_widget_2 	= [
			//列表选择类数据
			'listdata'		=> [],
			'key_relevance'	=> 'id|name',
			
			// 当指定名称组件值为真时，当前组件显示，否则处于隐藏状态
			'open_by'		=> '',
			
			// 提示
			'icon'			=> '',
			'tip'			=> '',
			
			// 值处理
			'func'			=> '',
			'func_param'	=> [],
			'config_name'	=> '',
			
			// 数据验证配置
			'validate'		=> [],
			
			// 图片/文件
			'limit_num'		=> 1,		// 可上传图片/文件最大数量
			'enabled_edit'	=> 1,		// 图片/文件是否可编辑（删除或替换，默认允许）
			'ext'			=> '',		// 指定文件格式，不传不限制
			// 图片
			'pic_wh'		=> '',		// 指定图片宽高
			'pic_ratio'		=> '',		// 指定图片宽高比
			
			// 样式相关
			'box_class'		=> '',
			'full_show'		=> false,
		];
		
		// 列表选择类数据
		//-----------------------------------------------------------------------
		if( isset($data_info[0]) ){		//索引数组配置【1：数据，2：key及value字段名称】
			$widget_config = [
				'listdata'		=> get_arr_val($data_info, 0, []),
				'key_relevance'	=> 'id|name',
			];
			if( isset($data_info[1]) && $data_info[1]!='' ){
				$widget_config['key_relevance'] = $data_info[1];
			}
		}else{							//关联数组配置
			$widget_config = $data_info;
		}
		
		$widget_config = array_replace($default_widget_2, $widget_config);
		$widget_config['key_relevance'] = explode('|', $widget_config['key_relevance']);
		
		// 附加插件
		//-----------------------------------------------------------------------
		if( !empty($widget_config['validate']) ){
			$this->recordWidget('validate');
		}
				
		return $widget_config;
	}
	
    
    /**
     * 解码单个组件参数
     * @date: 2017-8-14 下午12:40:47
     * @author: qw_xingzhe <qwei2013@gmail.com>
     */
    protected function decodeWidgetParameter($widget)
    {
    	/*
    	 * 配置值数组:
    	* 		参数1：字段名|字段类型|附加样式及属性
    	* 			字段名
    	*
    	* 			字段类型
    	* 				val
    	* 				textarea
    	* 				input
    	* 					text
    	* 					number
    	* 					password
    	* 					color
    	* 					date|dateday
    	* 					datetime
    	* 					dateyear
    	* 					datemonth
    	* 				radio
    	* 				images
    	* 				cropper
    	* 				checkbox
    	* 				hidden
    	* 				select
    	* 				switch
    	* 				tree_checkbox
    	* 				kindeditor
    	* 				tags
    	* 				multirecord
    	*
    	* 			附加样式及属性
    	* 				.class1,.class2,#id1,attr:attr_val,attr2:attr_val2
    	*
    	* 			例：name|text|.class1,.class2,#id1,attr:attr_val,attr2:attr_val2
    	*
    	*
    	*
    	* 		参数2：字段名称|字段描述
    	* 		参数3：可选数据数组
    	* 			索引数组传值：
    	* 				参数1：列表数据数组
    	* 				参数2：列表数组中使用的键值名称
    	* 			关联数组传值：
    	* 				【函数处理区】	input
    	* 					func				对字段处理的函数名称，参数为当前值
    	* 					func_param			当存在对字段处理的函数时，此值为为该函数的第二个参数
    	* 					config_name			配置参数名。当func为c_name时且func_param未传值，此值可替代func_param。
    	* 											          当type为field且可编辑时，此为编辑选择数据源。
    	*
    	* 				【当组件为选项时，对应索引数组传值的参数1和参数2】	select
    	* 					listInsert			向列表数据数组前追加的内容
    	* 					listdata			列表数据数组
    	* 					key_relevance		列表数组中使用的键值名称
    	* 				【更多复杂（扩展）配置】	input
    	* 					icon				组件展示存在图标的
    	* 					tip					组件的tip提示内容
    	* 				【数据验证】
    	*					validate			字段验证配置
    	* 				【图片上传】
    	* 					limit_num				可上传图片数量（默认1个）
    	* 				【图片裁切】
    	* 					pic_wh				指定图片宽高
    	* 					pic_ratio			指定图片宽高比
    	* 				【样式】
    	* 					style				组件上追加的样式
    	* 					item_class			组件上追加的class
    	* 					box_class			附加在循环体最外围的盒子样式
    	*
    	* 		参数4：值
    	*/
    	if( !isset($widget[0]) ){
    		// 返回解析的扩展组件
    		return $this->decodeExpandWidgetParameter($widget);
    	}
    	
    	$default = array('','',[[],'']);
    	$widget  = array_replace($default,$widget);
    		
    	//--------------------------------------------------------------------------
    	// 参数1：字段名|字段类型|附加样式及属性
    	$field_info		= explode('|', $widget[0]);
    	$field 			= $field_info[0];	//字段key
    	
    	// 参数3
    	$widget_config 	= $this->decodeWidgetParameterArr($widget[2]);
    	
    	// 参数4	数据值
    	$value			= get_arr_val($widget, 3, '');
    	if( $value==='' )$value = I($field,'');
    	//--------------------------------------------------------------------------
    	
    		
    	//参数组合
    	$type 			= (isset($field_info[1]))?$field_info[1]:'text';	//字段类型
    	$field_append	= get_arr_val($field_info, 2,'');
    	
    	//附加类，id及属性（附加在具体组件上的：input\textarea\select）
    	$item_class_str = $item_attr_str = '';
    	$item_id		= 'id_' . uniqid();
    	if( $field_append!='' ){
    		// .class1,.class2,#id1,attr:attr_val,attr2:attr_val2
    		// 例：name|text|.class1,.class2,#id1,attr:attr_val,attr2:attr_val2
    		$field_append_arr = explode(',', $field_append);
    		foreach ($field_append_arr as $one_append_str){
    			$frist_char = substr($one_append_str,0,1);
    			switch ($frist_char) {
    				case '.':	// 类
    					$item_class_str .= ' '.str_replace('.', '', $one_append_str);
    					break;
    				case '#':	// id
    					$item_id = str_replace('#', '', $one_append_str);
    					break;
    				default:	// 属性
    					$attr_arr = explode(':', $one_append_str);
    					$item_attr_str .= ' '.$attr_arr[0].'="'.$attr_arr[1].'" ';
    					break;
    			}
    		}
    	}
    	
    	// 字段类型
    	switch ($type){
    		
    		case 'hidden':
    			$widget_config['box_class'] .= ' hide';
    			break;
    		case 'email':
    			$type = 'input.email';
    			break;
    		case 'text':
    			$type = 'input.text';
    			break;
    		case 'number':
    			$type = 'input.number';
    			break;
    		case 'password':
    			$type = 'input.password';
    			break;
    		case 'color':
    			$item_class_str .= ' bigcolorpicker';
    			$this->recordWidget('bigcolorpicker');
    			break;
    		case 'price_group':
    			$this->recordWidget('vue');
    			$html = <<<str
		<div class="pull-right mr10 mt50">
			<span class="mr20">合计: <span class="total-price"> - </span>元</span>
			<button type="submit" class="btn btn-primary">去支付</button>
		</div>
str;
    			$this->appendTabHtml($html);
    			break;
    		//时间日期选择器
    		case 'date':
    		case 'dateday':
    			$type = 'input.text';
    			$item_class_str .= ' datetimepicker dateday';
    			$this->recordWidget('datetimepicker');
    			break;
    		case 'listbox':
    			if( !is_array($value) )$value = explode(',', $value);
    			$this->recordWidget('duallistbox');
    			break;
    		case 'datetime':
    			$type = 'input.text';
    			$item_class_str .= ' datetimepicker datetime';
    			$this->recordWidget('datetimepicker');
    			break;
    		case 'datemonth':
    			$type = 'input.text';
    			$item_class_str .= ' datetimepicker datemonth';
    			$this->recordWidget('datetimepicker');
    			break;
    		case 'dateyear':
    			$type = 'input.text';
    			$item_class_str .= ' datetimepicker dateyear';
    			$this->recordWidget('datetimepicker');
    			break;
    		case 'tags':
    			$type = 'input.text';
    			$item_class_str .= ' tagsinput';
    			$this->recordWidget('tagsinput');
    			break;
    	}
    		
    	$type			= explode('.', $type);
    	$widget_type	= $type[0];
    	$type_sub		= (isset($type[1]))?$type[1]:'text';
    		
    	//加入组件类型中
    	$this->recordWidget($widget_type,$type_sub,$field);
    		
    	// 参数2：字段名称|字段描述
    	$name_info 		= explode('|', $widget[1]);
    	$name_info[1] 	= (isset($name_info[1]))?$name_info[1]:'';
    	//----------------------------------------------------------------
    	
    	$placeholder 	= ($name_info[0])?'请输入'.$name_info[0]:'';
				
		if( isset($widget_config['listdata']) && isset($widget_config['listInsert']) ){		// 向list数组前追加元素
			if( is_array($widget_config['listInsert']) ){
				array_unshift($widget_config['listdata'],$widget_config['listInsert']);
			}else{
				//vd($widget_config);
				//$key_relevance = explode('|', $widget_config['key_relevance']);
				$key_relevance = $widget_config['key_relevance'];
				array_unshift($widget_config['listdata'],[$key_relevance[0]=>'',$key_relevance[1]=>$widget_config['listInsert']] );
			}
		}
		
		// 添加验证属性
		$widget_config['is_necessary'] = 0;
		foreach ($widget_config['validate'] as $key=>$validate){
			if( is_string($key) ){
				$item_attr_str .= ' '.$key.'="'.$validate.'" ';
			}else{
				$item_attr_str .= ' '.$validate.' ';
			}
			if( $key=='required' ){	// 必填
				$widget_config['is_necessary'] = 1;
			}
			$this->setFormClass('form-validate');
		}
		
		// 填充附加属性
		$attrWidgetConfig = ['open_by'];
		foreach ($attrWidgetConfig as $attr_name){
			$attr_value = $widget_config[ $attr_name ];
			if( !empty($attr_value) ){
				//vd($attr_name);vd($attr_value);vde($widget_config);
				$item_attr_str .= ' '.$attr_name.'="'.$attr_value.'" ';
			}
		}
		
		
    	$one_widget = array(
    			// 整体组件组织类型
    			'widget_type' 	=> 'widget',
    			
    			// 字段名称
    			'field'			=> $field,
    				
    			// 组件类型
    			'type'			=> $widget_type,		// 组内组件类型
    			'type_sub'		=> $type_sub,			// 子类型，当主类型为input时，子类型有多种选择
    				
    			// 属性及显示
    			'name'			=> $name_info[0],		// 显示名称
    			'desc'			=> $name_info[1],		// 备注说明
    			'name_desc'		=> ($name_info[1])?$name_info[1]:$name_info[0],
    			'placeholder'	=> $placeholder,
    			'hide_label'	=> 0,
    			
    			'id_str'		=> $item_id,
    			'item_class'	=> $item_class_str,
    			'item_attr_str'	=> $item_attr_str,
    				
    			// 字段值
    			'value'			=> $value,
    	);
    	
    	$one_widget 	= array_replace($one_widget, $widget_config);
    	if( $one_widget['type']=='multirecord' && isset($one_widget['multicnf']) && !empty($one_widget['multicnf']) ){
    		$one_widget['sub_widgets'] = [];
    		foreach ($one_widget['multicnf'] as $one_sub_widget){
    			$one_widget['sub_widgets'][] = $this->decodeWidgetParameter($one_sub_widget);
    		}
    		//vd($type);vde( $one_widget );
    	}
    	
    	return $one_widget;
    }
    
    
    /**
     * 解析扩展组件
     * 2018-1-1 下午8:32:27
     * qw_xingzhe <qwei2013@gmail.com>
     */
    public function decodeExpandWidgetParameter($widget)
    {
    	$one_widget = array(
    			// 整体组件组织类型
    			'widget_type' 	=> 'html',
    			'icon_class'	=> '',
    			'title'			=> '',
    			'content'		=> '',
    	);
    	$one_widget = array_replace($one_widget, $widget);
    	return $one_widget;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

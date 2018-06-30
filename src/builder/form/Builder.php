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

namespace whalephp\tbuilder\builder\form;

use whalephp\tbuilder\TBuilder;
//use think\Cache;

/**
 * 
 * @date: 2017-4-25 上午12:12:09
 * @author: qw_xingzhe <qwei2013@gmail.com>
 */
class Builder extends TBuilder
{
	// form表单元素
	protected $formWidgets;
	
	/**
	 * 批量添加表单组件
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addWidgets( $widgets_arr, $is_assign_val=false )
	{
		foreach ( $widgets_arr as $key=>$widget ){
			$this->addWidget($widget);
		}
		if($is_assign_val)$this->assignTabGroup();
		
		return $this;
	}
	
	/**
	 * 添加单个表单组件
	 * @date: 2017-9-1 上午11:31:57
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addWidget($widget)
	{
		// 解析参数配置
		$one_widget = $this->decodeWidgetParameter($widget);
			
		// 检查及初始化当前的TAB
		$this->checkInitCurrentTab();
			
		// 加入组件队列
		$this->_view_vars['tab_group'][ $this->_view_vars['current_tab_num'] ]['group_wigets'][] = $one_widget;
		
		return $this;
	}

	/**
	 * 附加tab内底部自定义html内容
	 * 2018-6-7 下午6:42:17
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function appendTabHtml($append_html)
	{
		// 检查及初始化当前的TAB
		$this->checkInitCurrentTab();
	
		$this->_view_vars['tab_group'][ $this->_view_vars['current_tab_num'] ]['append_html'] = $append_html;
		return $this;
	}
	/**
	 * 设置form组件描述区域不显示
	 * 2017-12-7 下午8:57:15
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function hideWidgetsDesc()
	{
		$this->_view_vars['is_show_form_desc'] = 0;
		return $this;
	}
	
	
	/**
	 * 变量集中赋值到模版中
	 * @date: 2017-4-25 上午12:12:52
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function assignVars()
	{
		//$this->_view_vars['form_action'] = (empty($this->_view_vars['form_action']))?'':$this->_view_vars['form_action'];
	}
	
	
	
	
}
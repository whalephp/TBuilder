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

namespace whalephp\tbuilder\builder\table;

use whalephp\tbuilder\TBuilder;

/**
 * 
 * @date: 2017-4-23 下午10:58:14
 * @author: qw_xingzhe <qwei2013@gmail.com>
 */
class Builder extends TBuilder
{
	
	/**
	 * 
	 * 2017-12-6 下午4:28:57
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function hideIdsCheckbox()
	{
		$this->_view_vars['is_show_table_ids'] = 0;
		return $this;
	}
	public function showIdsCheckbox()
	{
	    $this->_view_vars['is_show_table_ids'] = 1;
	    return $this;
	}
	
	/**
	 * 自定义table显示列
	 * 
	 * @date 2017-5-28 下午5:48:00
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function diyColumns($all_columns,$select_columns,$is_use_custom=true)
	{
		$columns = [];
		
		//获取当前用户当前基础url地址下自定义的列
		$diy_columns = [];

		
		if( !empty($diy_columns) ){
			$select_columns = $diy_columns;
		}
		foreach ( $select_columns as $key ){
			$columns[] = $all_columns[$key];
		}
		
		//添加一个右侧列设置按钮
		if( $is_use_custom ){
			$this->addTopRightButton([	  //添加顶部按钮
					'type'		=> 'custom',
					'href'		=> 'javascript:;',
					'btn_class'	=> 'btn-primary',
					'item_class'=> 'custom_table_row',
					'icon_class'=> 'glyphicon glyphicon-list-alt',
				]);
		}
		$this->recordWidget('magnific');
		$this->recordWidget('diy_colums');
		foreach ( $select_columns as $key ){
			$has_set[$key] = $all_columns[$key];
		}
		
		$this->assign('all_columns',$all_columns);
		$this->assign('has_set',$has_set);
		$this->assign('select_columns',$select_columns);

		return $this->setColumns($columns);
	}
	
	
	
	
	/**
	 * 批量设置数据列
	 * @param array $columns
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setColumns($columns)
	{
		$this->formatColumns($columns);
		return $this;
	}
	
	
	//=======================================================================//
	//						   		筛选条件生成									 //
	//=======================================================================//
	/**
	 * 批量添加筛选条件
	 * @param unknown $filters_arr
	 * 					参数1：	字段信息
	 * 								字段|展示类型
	 * 					参数2：	描述
	 * 					更多配置：
	 * 							
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addFilters($filters_arr)
	{
		foreach ($filters_arr as $widget){
			// 解析参数配置
			$one_widget = $this->decodeWidgetParameter($widget);
			$this->topFilters[] = $one_widget;
		}
		//vde($this->topFilters);
		return $this;
	}
		
	/**
	 * 添加下拉选择筛选
	 */
	public function addSelectFilters(){
		
		return $this;
	}
	
	/**
	 * 添加日期筛选
	 */
	public function addDateSearch(){
		
		return $this;
	}
	
	/** 
	 * 添加时间段筛选
	 */
	public function addTimeQuantumSearch(){
		
		return $this;
	}
	
	
	/**
	 * 变量集中赋值到模版中
	 * @date: 2017-4-24 下午9:44:38
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function assignVars()
	{
		//vde( $this->_view_vars );
// 		$this->assign('topFilters',$this->topFilters);
// 		$this->assign('_view_vars',$this->_view_vars);

		$this->_view_vars['assign_data']['topFilters'] = $this->topFilters;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
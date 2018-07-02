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

namespace whalephp\tbuilder\builder\custom;

use whalephp\tbuilder\TBuilder;

/**
 * 
 * @date: 2017-4-23 下午10:58:14
 * @author: qw_xingzhe <qwei2013@gmail.com>
 */
class Builder extends TBuilder
{
	
	public function _initialize(){
		parent::_initialize();
		$this->assign(['custom_view'=>'../vendor/whalephp/tbuilder/src/builder/widgets/empty.html']);
	}
	
	/**
	 * 设置自定义view模板地址
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setCustomView($custom_view=''){
		if( $custom_view!='' && strpos($custom_view, '.')===FALSE && strpos($custom_view, '/')===FALSE ){
			$custom_view = strtolower(CONTROLLER_NAME) .'/'. $custom_view;
		}
		//$this->assign(['custom_view'=>$custom_view]);
		$this->_view_vars['custom_view'] = $custom_view;
		return $this;
	}
	
	
	
	/**
	 * 添加一行
	 * @date: 2017-9-5 上午12:14:52
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function row()
	{
		$this->_view_vars['custom_widget'][] = [];
		$this->_view_vars['custom_widget_row_num']++;
		return $this;
	}
	
	/**
	 * 添加一列
	 * @date: 2017-9-5 上午12:15:04
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function col( $col_num=12 )
	{
		if( $this->_view_vars['custom_widget_row_num']==0 ){
			$this->row();
		}
		$custom_widget_row_index = $this->_view_vars['custom_widget_row_num']-1;
		$this->_view_vars['custom_widget'][$custom_widget_row_index][] = [
			'col'		=> $col_num,
			'widgets'	=> []
		];
		return $this;
	}
	
	/**
	 * 添加html内容
	 * @date: 2017-9-7 下午7:42:58
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addHtml($html)
	{
		return $this->addToColWidgets([
			'type'	=> 'html',
			'html'	=> $html,
		]);
	}
	
	/**
	 * Echarts组合
	 * @date: 2017-8-24 下午4:06:53
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function groupEcharts($data,$widthPanle=true)
	{
		$data['type'] = 'echart';
		$this->recordWidget('echarts');
		return $this->addToColWidgets($data);
	}
	
	/**
	 * 获取当前行的当前列，并追加组件到当前列
	 * @date: 2017-9-5 上午12:37:25
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addToColWidgets($widget)
	{
		if( $this->_view_vars['custom_widget_row_num']==0 ){
			$this->col();
		}
		$row_index 		= $this->_view_vars['custom_widget_row_num'] - 1;
		$row_col_index	= count( $this->_view_vars['custom_widget'][$row_index] )-1;
		if( $row_col_index<0 ){
			$this->col();
			$row_col_index = 0;
		}
		$this->_view_vars['custom_widget'][$row_index][$row_col_index]['widgets'][] = $widget;
		
		return $this;
	}
	
	/**
	 * 添加一组Tile
	 * @date: 2017-9-5 上午12:16:33
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addTiles($tiles)
	{
		foreach ($tiles as $tile){
			$this->addTile($tile);
		}
		return $this;
	}
	
	/**
	 * 添加单个Tile
	 * @date: 2017-9-5 上午12:16:55
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function addTile($tile)
	{
		$default_config = [
			'bg_class'		=> 'light',
			'icon_class'	=> '',
			'value'			=> '',
			'unit'			=> '',
			'text'			=> '',
			'footer_icon'	=> '',
			'footer_text'	=> '',
			'sub_type'		=> '',
			'h1_class'		=> 'fs30 mt5 mbn',
			'use_footer'	=> 0,
		];
		
		
		$default_config 		= array_replace($default_config, $tile);
		$default_config['type'] = 'tile';
		
		
		// 是否开启底部
		if( $default_config['footer_icon']!='' || $default_config['footer_text']!='' ){
			$default_config['use_footer'] = 1;
			$default_config['sub_type']	= 'adv';
		}
		
		// 
		if( $default_config['use_footer']==1 && $default_config['sub_type']=='adv' && !empty($default_config['icon_class'])){
			$default_config['h1_class']	= 'fs35 mbn';
		}
		
		// 默认配色
		if( $default_config['bg_class']=='light' ){
			$default_config['text_class'] = 'text-system';
		}else{
			$default_config['text_class'] = '';
			$default_config['text_class'] = 'text-white';
		}
		
		
		$tile = array_replace($default_config, $tile);
		return $this->addToColWidgets($tile);
	}
	
	
	
	
	
	
	
	
}
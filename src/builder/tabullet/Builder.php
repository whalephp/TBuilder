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

namespace whalephp\tbuilder\builder\tabullet;

use whalephp\tbuilder\TBuilder;

/**
 * 
 * 2018-1-2 下午11:26:38
 * qw_xingzhe <qwei2013@gmail.com>
 */
class Builder extends TBuilder
{
	public function initBuilder()
	{
		parent::initBuilder();
		$this->recordWidgets([['jQueryTabullet']]);
		return $this;
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
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
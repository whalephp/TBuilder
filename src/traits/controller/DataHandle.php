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

namespace common\traits\controller;

use think\Config;
use think\exception\HttpResponseException;
use think\Response;
use think\Url;
use think\View as ViewTemplate;

/**
 * 数据处理相关
 * @author: qw_xingzhe <qwei2013@gmail.com>
 */
trait DataHandle 
{
	public $list_limit = null;
	
	// +----------------------------------------------------------------------
	// | 菜单导航相关
	// +----------------------------------------------------------------------
	/**
	 * 面包屑导航（未带入上级数组信息，待完善）
	 * @date: 2017-4-23 下午1:09:37
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	final public function getCrumbs( $menu=array() ){
		
		$current_url 	= strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
		$MenuModel 		= db('admin_menu');
		$crumbsArr 		= $inIDArr = array();
		
		$_cache_name = 'crumbs_'.$current_url.'_'.MODULE_NAME.'_'.ENTRANCE;
		
		$data = cache($_cache_name);
		if( !$data ){
			//\think\Debug::remark('begin_a');
			
			//从当前层级开始向上追溯
			$map = 	['url'=>['like','%'.$current_url],'module'=>MODULE_NAME,'childapp'=>ENTRANCE];
			$info = $MenuModel->where( $map )->order('sort asc,pid desc')->find();	//
			
			if( !$info ){
				unset($map['module']);
				$info = $MenuModel->where( $map )->order('sort asc,pid desc')->find();	//
			}
			//\think\Debug::remark('end_a');
// 			echo "<br/>" . $MenuModel->getLastSql() ."<br/>";
// 			vde($info);
			
			
			if( !$info ){
				$this->assign(['crumbsArr'=>[]]);
				return $menu;
			}
			
			//$info 				= $info->toArray();
			// 		vd($info);
			$info['is_last'] 	= 1;
			$crumbsArr[] 		= $info;
			$inIDArr[]	 		= strtolower($info['id']);
			
			// 递归获取上级目录
			function getPrevMenu($pid,&$crumbsArr,&$inIDArr){
				if($pid==0)return;
				$MenuModel 			= model('Menu');
				$info 				= $MenuModel->where( ['id'=>$pid] )->find();
				$info['is_last'] 	= 0;
				$inIDArr[] 	 		= strtolower($info['id']);
					
				array_unshift($crumbsArr,$info);
				getPrevMenu($info['pid'],$crumbsArr,$inIDArr);
			}
			getPrevMenu($info['pid'],$crumbsArr,$inIDArr);
			
			
			//\think\Debug::remark('end_a');
			//echo \think\Debug::getRangeTime('begin_a','end_a').'s';exit();
			
			
			$main_title = $info['title'];
			$data = [
				'crumbsArr' => $crumbsArr,
				'main_title'=> $main_title,
				'inIDArr'	=> $inIDArr	
			];
			cache($_cache_name,$data);
		}else{
			$crumbsArr 	= $data['crumbsArr'];
			$main_title = $data['main_title'];
			$inIDArr 	= $data['inIDArr'];
		}
		$this->_view_vars['main_title'] = $main_title;
		$this->assign(['crumbsArr'=>$crumbsArr]);	//
		return $inIDArr;
	}
	
	/**
	 * 获取控制器菜单数组,二级菜单元素位于一级菜单的'_child'元素中
	 * @author 朱亚杰  <xcoolcc@gmail.com>
	 */
	final public function getMenus($inIDArr,$controller=CONTROLLER_NAME){
	
		//$_cache_name = strtolower('menu_'.implode('-', $inIDArr).''.$controller);
		//$data = cache($_cache_name);
		
		//vd($inIDArr);
		//session('ADMIN_MENU_LIST.'.$controller,'');
		$ADMIN_MENU_LIST 	= session('ADMIN_MENU_LIST_'.ENTRANCE);
		$menus  			= get_arr_val($ADMIN_MENU_LIST, MODULE_NAME . $controller, []);//session('ADMIN_MENU_LIST.'.$controller);
		$MenuModel 			= db('admin_menu');
		$main_lower_url 	= strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);
		
		//vd(MODULE_NAME);vde($main_lower_url);
		
		$all_menu_ids		= [];
		if( !IS_ROOT )
			$all_menu_ids	= $this->userInfo['menu_auth']['all_menu_ids'];
		
		// 		$menus = null;
		if( empty($menus) ){
			// 获取主菜单
			// $where['pid']   =   0;
			// $where['hide']  =   0;
	
			$where = [
				'pid'	=> 0,
				//'hide'	=> 0,
				//'module'=> MODULE_NAME
				'childapp'=>ENTRANCE
			];
			/*
			if(!C('DEVELOP_MODE')){ // 是否开发者模式
				$where['is_dev']    =   0;
			}
			*/
			
			if( !IS_ROOT )
				$where['id'] = ['in',$all_menu_ids];
			/*
			model('Member')->updateUserAuth();
			vde( $this->userInfo );
			*/
			$menus['main']  =   $MenuModel->where($where)->order('sort asc')->field('id,title,icon_class,module,url,is_list_sub_menu,is_can_retractable,hide')->cache(true)->select();
			$menus['child'] =   array(); //设置子节点
	
			//echo CONTROLLER_NAME.'/'.ACTION_NAME;exit;
	
				
			foreach ($menus['main'] as $key => $item) {
				/*
				// 判断主菜单权限
				if ( !IS_ROOT && !$this->checkRule(strtolower(MODULE_NAME.'/'.$item['url']),AuthRuleModel::RULE_MAIN,null) ) {
				unset($menus['main'][$key]);
				continue;//继续循环
				}
				*/
				$menus['main'][$key]['class'] = '';
				//$menus['main'][$key]['append_class'] = '';
				if( in_array($item['id'], $inIDArr) ){
					$menus['main'][$key]['class']='active';
					$menus['main_active'] = $menus['main'][$key];
					$menus['main_active']['active_url'] = strtolower( $menus['main_active']['module'].'/'.$menus['main_active']['url'] );
				}
				/*
				if( $item['is_can_retractable']==1 ){
					$menus['main'][$key]['append_class'] .= 'open_sub_forever';
				}
				*/
			}
			
			// 查找当前子菜单
			$child_map = [
				'pid'		=> ['neq',0],
				'url'		=> ['like','%'.$main_lower_url],
				'module'	=> MODULE_NAME,
				'childapp'	=> ENTRANCE,
			];
			if( !IS_ROOT )
				$child_map['id'] = ['in',$all_menu_ids];
			/*
			model('Member')->updateUserAuth();
			vde( $this->userInfo );
			*/
			
			//$pid = $MenuModel->where("pid !=0 AND url like '%{$controller}/".ACTION_NAME."%'")->value('pid');
			$pid = $MenuModel->where($child_map)->cache(true)->value('pid');
			if( !$pid ){
				unset( $child_map['module'] );
				$pid = $MenuModel->where($child_map)->cache(true)->value('pid');
			}
			//vd($child_map);vd($menus);vde($pid);
			
			if( $pid ){
				// 查找当前主菜单
				$nav =  $MenuModel->find($pid);
				if($nav['pid']){
					$nav    =   $MenuModel->cache(true)->find($nav['pid']);
				}
				//vd($nav);vd($pid);
// 				vde($menus['main']);
				foreach ($menus['main'] as $key => $item) {
					// 获取当前主菜单的子菜单项
					//$menus['main'][$key]['class']='';
					//if($item['id'] == $nav['id']){
					if($menus['main'][$key]['class']=='active'){
						//$menus['main'][$key]['class']='active';
						//生成child树
						//$groups = $MenuModel->where(array('group'=>array('neq',''),'pid' =>$item['id']))->distinct(true)->column("group");
						$groupMap = array('pid' =>$item['id']);
						if( !IS_ROOT )
							$groupMap['id'] = ['in',$all_menu_ids];
						$groups = $MenuModel->where($groupMap)->order('sort asc')->cache(true)->select();
	
						//dump($groups);exit;
						//获取二级分类的合法url
						$where          =   array();
						$where['pid']   =   $item['id'];
						$where['hide']  =   0;
						/*
							if(!C('DEVELOP_MODE')){ // 是否开发者模式
						$where['is_dev']    =   0;
						}
						*/
						$second_urls = $MenuModel->where($where)->cache(true)->value('id,url');
	
						// 按照分组生成子菜单树
						foreach ($groups as $g=>$group_item) {
							$map = array('pid'=>$group_item['id']);
							$map['hide']    =   0;
							if( !IS_ROOT )
								$map['id'] = ['in',$all_menu_ids];
							/*
								if(!C('DEVELOP_MODE')){ // 是否开发者模式
							$map['is_dev']  =   0;
							}
							*/
// 							vde($map);
							$add_class = '';
							$child_temp = $MenuModel->where($map)
													->field('id,pid,title,url,tip,module,icon_class,is_list_sub_menu,is_can_retractable,hide')
													->order('sort asc')
													->cache(true)
													->select();
							$child = [];
							foreach ($child_temp as $key=>$c) {
								$c['class']		 = '';
								//$c['append_class'] = '';
								$child[$c['id']] = $c;
							}
							$group_item['append_class'] = '';
							if( $group_item['is_can_retractable']==0 ){
								$group_item['append_class'] = 'open_sub_forever';
							}
							$group_item['class'] 		= $add_class;
							$group_item['child'] 		= $child;
							$group_item['child_num'] 	= count($child);
							$group_item['is_have_sub_menu']= ($group_item['child_num']>0 && $group_item['is_list_sub_menu']==1)?1:0;
							$menus['child'][ $group_item['id'] ]  = $group_item;
						}
					}
				}
			}
				
			$menus = $this->sortModuleMenus($menus);
			//vde($menus);
				
			$ADMIN_MENU_LIST[ MODULE_NAME . $controller ] = $menus;
				
			session('ADMIN_MENU_LIST',$ADMIN_MENU_LIST);
		}
	
	
	
		//菜单高亮处理
		$count_in 	 = count($inIDArr);
		$left_first  = get_arr_val($inIDArr, $count_in-2,'');
		$left_second = get_arr_val($inIDArr, $count_in-3,'');
		if( isset($menus['child'][ $left_first ]) ){
			$menus['child'][ $left_first ]['class'] = 'menu-open';
			if( isset($menus['child'][ $left_first ]['child'][ $left_second ]) ){
				$menus['child'][ $left_first ]['child'][ $left_second ]['class'] = 'active';
			}else{
				$menus['child'][ $left_first ]['class'] = 'active';
			}
		}
	
		return $menus;
	}
	
	
	// +----------------------------------------------------------------------
	// | 数据处理相关
	// +----------------------------------------------------------------------
	/**
	 * 对模块菜单进行重新排序
	 * @date 2017-5-11 下午4:29:29
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	private function sortModuleMenus( $menus ){
		$module_list = db('admin_module')->where(['status'=>1,'is_install'=>1])->field('module_key')->order('sort asc,id asc')->cache(true)->select();
		$module_list = getIdIndexArr($module_list,'module_key');
		$main_menus  = $menus['main'];
		foreach ($main_menus as $i=>$menu){
			$module = $menu['module'];
			if( isset($module_list[$module]) ){
				if( !isset($module_list[$module]['menus']) ){
					$module_list[$module]['menus'] = [];
				}
				$module_list[$module]['menus'][] = $menu;
			}
		}
		$main_menus = [];
		foreach ($module_list as $module=>$module_menus){
			if( !isset($module_menus['menus']) )continue;
			foreach ($module_menus['menus'] as $one){
				$main_menus[] = $one;
			}
		}
	
		$menus['main'] = $main_menus;
		return $menus;
	}
	
	/**
	 * 设置列表每页数量
	 * @date: 2017-10-5 下午10:59:05
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	public function setListLimit($num){
		$this->list_limit = $num;
		return $this;
	}
	
	
	/**
	 * 获取页显示数量
	 * 2018-4-4 下午4:05:59
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function getPageListRow()
	{
		$action  = strtolower(MODULE_NAME.'-'.CONTROLLER_NAME.'-'.ACTION_NAME);
		if( cookie($action) ){
			return cookie($action);
		}
		return null;
	}
	
	
	
	/**
	 * 通用分页列表数据集获取方法
	 *
	 *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
	 *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
	 *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
	 *
	 * @param sting|Model  $model   模型名或模型实例
	 * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
	 * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
	 *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
	 *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
	 *
	 * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
	 * @return array|false
	 * 返回数据集
	 */
	protected function lists ($model,$where=array(),$order='',$field=true,$with=[]){
		
		$options    =   array();
		$REQUEST    =   (array)I('request.');
		if(is_string($model)){
			$model  =   model($model);
		}
		
		$OPT        =   new \ReflectionProperty($model,'options');
		$OPT->setAccessible(true);
		
		$pk         =   $model->getPk();
		if($order===null){
			//order置空
		}else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
			$options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
		}elseif( $order==='' && empty($options['order']) && !empty($pk) ){
			$options['order'] = $pk.' desc';
		}elseif($order){
			$options['order'] = $order;
		}
		unset($REQUEST['_order'],$REQUEST['_field']);
	
		if(empty($where)){
			//$where  =   array('status'=>array('egt',0));
			$where  =   array();
		}
		
		$options['where']   =   $where;
		$options      =   array_merge( (array)$OPT->getValue($model), $options );
		//vd($with);vde($where);
		$total        =   $model->with($with)->where($where)->count();
// 		vde($total);
		//vde($this->list_limit);
		
		$userSetPageNum = $this->getPageListRow();
// 		vde($userSetPageNum);
		if( $this->list_limit==-1 ){
			$listRows = 99999999;
		}elseif( $this->list_limit ){
			$listRows = (int)$this->list_limit;
		}elseif( isset($REQUEST['r']) ){
			$listRows = (int)$REQUEST['r'];
		}elseif($userSetPageNum){
			$listRows = $userSetPageNum;
		}else{
			$listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
		}
		
		/*
		 $page = new \Think\Page($total, $listRows, $REQUEST);
		if($total>$listRows){
		$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		}
		$p =$page->show();
		$this->assign('_page', $p? $p: '');
		$this->assign('_total',$total);
		$options['limit'] = $page->firstRow.','.$page->listRows;
		$model->setProperty('options',$options);
	
		return $model->field($field)->select();
		*/
		
// 		$list = $model->where($where)->order($order)->field($field)->paginate($listRows);
		$page_config = config('paginate');
		$page_config['list_rows'] = $listRows;
		
		
		// 追加GET中的数据到分页URL中
		$page_config['query'] = $this->request->param();
		
		$list = $model->where($where)->with($with)->order($order)->field($field)->paginate($listRows,false,$page_config);
		//vd($where);echo $model->getLastSql();vde($list);
		
		
		if( $this->list_limit==-1 ){
			$page = '';
		}else{
			
			$selectPage = ['10'=>'','20'=>'','50'=>'','100'=>'','300'=>'','500'=>'','1000'=>''];
			$selectPage[$userSetPageNum] = 'selected';
			$page = '<div class="bottom">'.
						'<div class="dataTables_info" id="datatable3_info" role="status" aria-live="polite">当前：'.$list->getCurrentPage().'/'.$list->lastPage().'，共'.$list->total().'条记录</div>'.
						'<div class="dataTables_paginate paging_simple_numbers" id="datatable3_paginate">'.
							$list->render().
						'</div>'.
						'<div class="setting_paginate">
						<label class="field select w80">
                        	<select class="page_show_num">
                            	<option value="10" '.$selectPage['10'].'>10条</option>
                                <option value="20" '.$selectPage['20'].'>20条</option>
                                <option value="50" '.$selectPage['50'].'>50条</option>
								<option value="100" '.$selectPage['100'].'>100条</option>
								<option value="300" '.$selectPage['300'].'>300条</option>
								<option value="500" '.$selectPage['500'].'>500条</option>'.
								//<option value="1000" '.$selectPage['1000'].'>1000条</option>
                            '</select>
                            <i class="arrow"></i>
                        	</label>
						</div>'.
					'</div>';
		}
		$this->assign(['page'=>$page]);
		
		
		
		$list = getArrayList($list);
		if( method_exists($this->model_vars['base_model'],'formatList') ){
			$list = $this->model_vars['base_model']->formatList($list);
		}
		//vd( method_exists($model,'formatList') );vd($model);vde($list);
	
	
		return $list;
	
	}
	
	/**
	 * 记录当前列表页的cookie
	 * @date: 2017-4-29 下午9:40:00
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	protected function rememberUri()
	{
		cookie('__forward__',$_SERVER['REQUEST_URI']);
	}
	/**
	 * 设置页面跳转到上级记录页面
	 * @date: 2017-4-29 下午9:40:11
	 * @author: qw_xingzhe <qwei2013@gmail.com>
	 */
	protected function actionToUri()
	{
		self::$is_jump_to_remember_uri = true;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
	 *
	 * @param string $model 模型名称,供M函数使用的参数
	 * @param array  $data  修改的数据
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	final protected function editRow ( $model ,$data, $where , $msg ){
		$id    = array_unique((array)I('id',0));
		$id    = is_array($id) ? implode(',',$id) : $id;
		$where = array_merge( array('id' => array('in', $id )) ,(array)$where );
		$msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );
	
		if( M($model)->where($where)->update($data)!==false ) {
			// vde($model);
			$this->success($msg['success'],$msg['url'],$msg['ajax']);
		}else{
			$this->error($msg['error'],$msg['url'],$msg['ajax']);
		}
	}
	
	/**
	 * 设置一条或者多条数据的状态
	 */
	public function setStatus($Model=CONTROLLER_NAME,$idName='id'){
	
		$ids    =   I('request.ids');
		$status =   I('request.status');
		if(empty($ids)){
			$this->error('请选择要操作的数据');
		}
	
		$map[ $idName ] = array('in',$ids);
		switch ($status){
			case -1 :
				$this->delete($Model, $map, array('success'=>'删除成功','error'=>'删除失败'));
				break;
			case 0  :
				$this->forbid($Model, $map, array('success'=>'禁用成功','error'=>'禁用失败'));
				break;
			case 1  :
				$this->resume($Model, $map, array('success'=>'启用成功','error'=>'启用失败'));
				break;
			default :
				$this->error('参数错误');
				break;
		}
	}
	
	
	/**
	 * 禁用条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的 where()方法的参数
	 * @param array  $msg   执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function forbid ( $model , $where = array() , $msg = array( 'success'=>'状态禁用成功！', 'error'=>'状态禁用失败！')){
		$data    =  array('status' => 0);
		$this->editRow( $model , $data, $where, $msg);
	}
	
	/**
	 * 恢复条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 *
	 * @author 朱亚杰  <zhuyajie@topthink.net>
	 */
	protected function resume (  $model , $where = array() , $msg = array( 'success'=>'状态恢复成功！', 'error'=>'状态恢复失败！')){
		$data    =  array('status' => 1);
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	/**
	 * 还原条目
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 * @author huajie  <banhuajie@163.com>
	 */
	protected function restore (  $model , $where = array() , $msg = array( 'success'=>'状态还原成功！', 'error'=>'状态还原失败！')){
		$data    = array('status' => 1);
		$where   = array_merge(array('status' => -1),$where);
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	/**
	 * 条目假删除
	 * @param string $model 模型名称,供D函数使用的参数
	 * @param array  $where 查询时的where()方法的参数
	 * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
	 *                     url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
	 */
	protected function delete ( $model , $where = array() , $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！')) {
		$data['status']         =   -1;
		$data['update_time']    =   NOW_TIME;
		$this->editRow(   $model , $data, $where, $msg);
	}
	
	
	
	
	
	
	
	
	//-----------------------------------------------------------------------------------------------------------
	//检测编辑查看的信息查询参数是否传入
	public function check_key($requestVal,$msg='信息有误'){
		if( !$requestVal ){
			$this->error($msg);
		}
	}
	
	/**
	 * 增改通用
	 */
	public function doEdit( $Model ,$messageArr=array('新增','修改'),$jump=true){
		//vde(self::$is_jump_to_remember_uri);
		$msg 		= '成功';
		$error_msg 	= null;
		$data 		= $_POST;
		$Pk			= $Model->getPk();
	
		if( $data ){
			if( isset($data[$Pk]) && $data[$Pk] ){
				$ret = $Model->allowField(true)->save($data,[$Pk=>$data[$Pk]]);
				if( $ret ) $ret = $data[$Pk];
			}else{
				$ret = $Model->allowField(true)->save($data);
				if( $ret ) $ret = $Model->getLastInsID();
			}
			if( !$ret ){
				$error_msg = $Model->getError();
			}
		}else{
			$ret = 0;
			$error_msg = $Model->getError();
		}
		
		
		
		//----------------------------------------------------
		if( is_array($messageArr) && isset($messageArr[0]) ){	// 新增或修改
			$msg = ( isset($data[$Pk]) && $data[$Pk]>0 )?$messageArr[1]:$messageArr[0];
		}else{
			$msg = $messageArr;
		}
		/*
		//----------------------------------------------------
		if( $error_msg ){	// 保存失败了（临时方案）
			$msg = [$msg.'成功',$error_msg];
		}
		*/
		
		$msg = $this->getRetMsg($ret,$msg,$error_msg);
		return $this->doRet( $ret, $msg, $jump );
	}
	
	/**
	 * 
	 * 2018-1-31 下午1:57:03
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function getRetMsg($ret,$messageArr,$error_msg='')
	{
		$retKey	 		= ($ret)?'success':'error';
// 		if( isset($messageArr[$retKey]) && empty($error_msg) ){
// 			return $messageArr;
// 		}
		$retStatusMsg 	= ($ret)?'成功':'失败';
		if( !empty($error_msg) ){
			$msg = $error_msg;
		}elseif( is_string($messageArr) ){
			$msg = $messageArr.$retStatusMsg;
		}else if( isset($messageArr[$retKey]) ){
			return $messageArr;
		}else{
			$msg = $retStatusMsg;
		}
		
		return [$retKey=>$msg];
	}
	
	
	/**
	 * 删除通用
	 */
	public function doDel( $Model , $map='', $message='删除',$jump=true){
		if( !is_array($map) ){
			$Pk = $Model->getPk();
			$map = (empty($map))?I( $Pk ):$map;
			$map = array($Pk=>$map);
		}elseif ( isset($map[0]) ){
			$Pk = $Model->getPk();
			$map = array($Pk=>['in',$map]);
		}
		$ret = $Model->where( $map )->delete();
		//vde($ret);
		//echo $Model->getLastsql();echo "<hr/>";exit;
		return $this->doRet( $ret, $message, $jump );
	}
	/**
	 * 跳转通用
	 */
	public function doRet( $ret, $message='操作', $jump=true ){
		
		if( isset($this->append_update_ret) && $this->append_update_ret ){
			$ret = $ret || $this->append_update_ret;
		}
		
		if( $jump ){
			if( $jump===true && self::$is_jump_to_remember_uri===true ){
				$jump = cookie('__forward__');
				//vde( $jump );
			}elseif ( is_array(self::$is_jump_to_remember_uri) ){
				$jumpArr = self::$is_jump_to_remember_uri;
				$jump = url( $jumpArr[0], [$jumpArr[1]=>$ret] );
			}else if( $jump===true ){
				$jump = '';
			}
			
			
			//-----------------------------------------------------
// 			if( !is_array($message) ){
// 				$message .= ($ret)?'成功':'失败';
// 			}else if( isset($message[0]) && $message[1] ){
// 				$message = ($ret)?$message[0]:$message[1];
// 			}
			$message = $this->getRetMsg($ret,$message);
			
			//-----------------------------------------------------
				
			//vd(self::$is_jump_to_remember_uri);vd( cookie('__forward__') );vde($jump);
			
			
			if( $ret ){
				$this->executeSuccessCallbackFunc($ret);
				$this->success( $message['success'], $jump );
			}else{
				$this->error( $message['error'] );
			}
		}else{
			return $ret;
		}
		exit();
	}
	
	/**
	 * 
	 * 2018-3-4 下午5:27:55
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function executeSuccessCallbackFunc($ret)
	{
		if( $this->successCallbackFunc ){	// 数据操作成功后回调处理
			
			if( !empty($this->successCallbackParam) ){
				$this->successCallbackParam['ret'] = $ret;
				$ret = $this->successCallbackParam;
			}
			
			if( is_object($this->successCallbackFunc) ){	// 匿名函数
				$this->successCallbackFunc( $ret );
			}else{
				$successCallbackFunc = explode('|', $this->successCallbackFunc);
				if( count($successCallbackFunc)>1 ){		// 调用模型内方法
					model( $successCallbackFunc[0] )->{$successCallbackFunc[1]}( $ret );
				}else{										// 回调函数
					$this->successCallbackFunc( $ret );
				}
			}
			
			// 验证后用下面方法替换
			//$this->executeCallback($this->dataProcessingFunction,$ret);
		}
	}
	
	/**
	 * 执行回调方法
	 * 
	 * 2018-6-1 上午11:39:38
	 * qw_xingzhe <qwei2013@gmail.com>
	 */
	public function executeCallback($success_callback_func,&$data)
	{
		if (is_null($success_callback_func))return;
				
		if (is_object($success_callback_func)){	// 匿名函数
			$this->successCallbackFunc( $data );
		} elseif (is_string($success_callback_func)){
			
			$success_callback_func = explode('|', $success_callback_func);
			
			if (count($success_callback_func)>1){		// 调用模型内方法
				//vde($success_callback_func);
				model( $success_callback_func[0] )->{$success_callback_func[1]}( $data );
			} elseif (method_exists($this,$success_callback_func[0])){
				$this->{$success_callback_func[0]}( $data );
			} else {										// 回调函数
				$success_callback_func[0]( $data );
			}
		}
	}
	
	public function jumpReturn($result, array $header = []){
		$code 	= $result['code'];
		$url 	= $result['url'];
		$msg 	= $result['msg'];
	
		if (is_numeric($msg)) {
			$code = $msg;
			$msg  = '';
		}
		if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
			$url = $_SERVER["HTTP_REFERER"];
		} elseif ('' !== $url) {
			$url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Url::build($url);
		}
	
		$result['msg'] = $msg;
		$result['url'] = $url;
	
		if($code==0 || $url==null)unset($result['url']);
	
		$type = $this->getResponseType();
		if ('html' == strtolower($type)) {
			$result = ViewTemplate::instance(Config::get('template'), Config::get('view_replace_str'))->fetch(Config::get('dispatch_success_tmpl'), $result);
		}
		$response = Response::create($result, $type)->header($header);
		throw new HttpResponseException($response);
		exit();
	}
}


<?php
class IndexAction extends AdminInitAction {
	public function index() {
		/*$dtime = statime ( "Y-m-d" ); // 今天时间戳
		$ztime = statime ( "Y-m-d", "-1 day" ); // 昨天时间戳
		$xtime = statime ( "Y-m-d", "-6 day" ); // 一个星期的时间戳
		$timeq30 = statime ( "Y-m-d", "-29 day" ); // 一个月的时间戳
		$timed1 = strtotime ( date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'n' ), 1, date ( 'Y' ) ) ) ); // 当前月份第一天时间戳
		$st = isset ( $st ) ? $st : $dtime; // 如果没有开始时间，那么默认为当天时间
		$et = isset ( $et ) ? $et : $dtime; // 如果没有结束时间，那么默认为当天时间
		
		if ($stt)
			$st = strtotime ( $stt );
		if ($ett)
			$et = strtotime ( $ett );
		if ($st > $et) {
			$st = strtotime ( $ett );
			$et = strtotime ( $stt );
		}
		
		if ($st && $st > $dtime)
			$st = $dtime;
		if ($et && $et > $dtime)
			$et = $dtime;
		
		$visitday = M ( 'visitsummary' )->where ( array (
				'dateline' => $dtime 
		) )->find ();
		if (! $visitday) {
			$str = '';
			
			for($i = 0; $i < 24; $i ++) {
				$str .= '|';
			}
			$part = $str;
			
			M ( 'visitsummary' )->add ( array (
					'pv' => 0,
					'ip' => 0,
					'alone' => 0,
					'part' => $str,
					'dateline' => $dtime 
			) );
		}
		
		
		$tmst = date ( "Y-m-d", $st );
		$tmet = date ( "Y-m-d", $et );
		
		$weekarray = array (
				'星期日',
				'星期一',
				'星期二',
				'星期三',
				'星期四',
				'星期五',
				'星期六' 
		);
		$result = M ( 'visitsummary' )->select ();
		$l = 0;
		foreach ( $result as $key => $value ) {
			
			if ($value ['dateline'] == $dtime) {
				$visit_summary = $data ['visit_summary'] = $value;
			}
			$pvaccum = $data ['pvaccum'] = $pvaccum + $value ['pv'];
			$ipaccum = $data ['ipaccum'] = $ipaccum + $value ['ip'];
			$alaccum = $data ['alaccum'] = $alaccum + $value ['alone'];
			$summarylist [] = $value;
			$l ++; // 一共这么多天
		}
		if (! $visit_summary) {
			$visit_summary = $data ['visit_summary'] = array (
					'dateline' => $dtime,
					'pv' => 0,
					'alone' => 0,
					'ip' => 0 
			);
		}
		$pvaver = $data ['pvaver'] = round ( $pvaccum / $l ); // 平均每天对应的pv
		$ipaver = $data ['ipaver'] = round ( $ipaccum / $l );
		$alaver = $data ['alaver'] = round ( $alaccum / $l );
		foreach ( $summarylist as $key => $val ) {
			$p = 0; // 查找历史最高 还有时间
			$i = 0;
			$a = 0;
			foreach ( $summarylist as $key => $val2 ) {
				if ($val ['pv'] < $val2 ['pv'])
					$p = 1;
				if ($val ['ip'] < $val2 ['ip'])
					$i = 1;
				if ($val ['alone'] < $val2 ['alone'])
					$a = 1;
			}
			if ($p == 0)
				$maxpv = $data ['maxpv'] = $val ['pv'] . '<span>(' . date ( "Y-m-d", $val ['dateline'] ) . ')</span>';
			if ($i == 0)
				$maxip = $data ['maxip'] = $val ['ip'] . '<span>(' . date ( "Y-m-d", $val ['dateline'] ) . ')</span>';
			if ($a == 0)
				$maxal = $data ['maxal'] = $val ['alone'] . '<span>(' . date ( "Y-m-d", $val ['dateline'] ) . ')</span>';
		}
		
		$data ['per_visit'] = $per_visit = sprintf ( "%.2f", ($visit_summary ['pv'] / $visit_summary ['alone']) ); // 今日人均浏览次数
		
		$visit_summaryz = $data ['visit_summaryz'] = M ( 'visitsummary' )->where ( array (
				'dateline' => $ztime 
		) )->find ();
		
		if (! $visit_summaryz) {
			$visit_summaryz ['pv'] = $data ['visit_summaryz'] ['pv'] = 0;
			$visit_summaryz ['alone'] = $data ['visit_summaryz'] ['alone'] = 0;
			$visit_summaryz ['ip'] = $data ['visit_summaryz'] ['ip'] = 0;
		}
		$data ['per_visitz'] = $per_visitz = sprintf ( "%.2f", ($visit_summaryz ['pv'] / $visit_summaryz ['alone']) ); // 昨天人均浏览次数
		
		$data ['dtime'] = $dtime;*/
		
		// 留言数目
		$data ['pmcount'] = M ( 'message' )->where ( array (
				'isnew' => 1,
				'isxunpan' => 0 
		) )->count ();
		$data ['ordercount'] = M ( 'order' )->where ( array (
				'isnew' => 1 
		) )->count ();
		$data ['xuncount'] = M ( 'message' )->where ( array (
				'isnew' => 1,
				'isxunpan' => 1 
		) )->count ();
		$data ['membercount'] = M ( 'user' )->count ();
	/*	$where['lang']=$this->lang;
		$sort=M('sort')->where(array('lang'=>$this->lang,'module'=>'Article'))->select();
		$newsort=array();
		if(!empty($sort)){
			foreach($sort as $k=>$v){
				$newsort[$v['id']]=$v;
			}
				
		}*/
		$count = M ( 'Article' )->where ($where)->count (); // 查询满足要求的总记录数
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		/*$list = M ( 'Article' )->where ($where)->order ( 'id desc' )->limit ( '7' )->select ();
		
		if(!empty($list)){
			foreach($list as $key=>$value){
				$list[$key]['sortname']=$newsort[$value['sort']]['name'];
			}
				
		}
		
		$sortlist = M ( 'sort' )->where ( array (
				'lang' => $this->lang,
				'module'=>'Article'
		) )->order ( 'sort_order ASC,idpath ASC' )->select ();
		
		
		
		
		
		
		$sort=M('sort')->where(array('lang'=>$this->lang,'module'=>'Product'))->select();
		$pnewsort=array();
		if(!empty($sort)){
			foreach($sort as $k=>$v){
				$pnewsort[$v['id']]=$v;
			}
		
		}
		$plist = M ( 'Product' )->where (array('lang'=>$this->lang))->order ( 'id desc' )->limit ( '7')->select ();
		
		if(!empty($plist)){
			foreach($plist as $key=>$value){
				$plist[$key]['sortname']=$pnewsort[$value['sort']]['name'];
				$plist[$key]['img']=site_url().'/'.$value['pic'];
			}
		
		}
		*/
		
		$this->assign('plist',$plist);
		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( $data );
		$this->display ( './Public/Admin/Index/index.html' );
	}
	public function login() {
		$this->display ( './Public/Admin/Index/login.html' );
	}
	public function logout() {
		$cookie_name = C ( 'COOKIE_NAME' );
		$this->user_model->generateAuthCookie ( $this->_USESSION ['username'], $this->_USESSION ['uid'] );
		
		setcookie ( $cookie_name, '', - 86400, '/' );
		session ( 'user', null );
		session ( 'islogin', null );
		session ( 'sorturl', null );
		redirect ( site_url().'/jhyx.php');
	}
}
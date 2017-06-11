<?php
class AlexaAction extends AdminInitAction {
	public function summary() {
		$dtime = statime ( "Y-m-d" ); // 今天时间戳
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
		
		/* 初始变量 */
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
		
		$data ['dtime'] = $dtime;
		$this->assign ( $data );
		$this->display ( './Public/Admin/Alexa/summary.html' );
	}
	public function eng() {
		$st = intval ( $_GET ['st'] );
		$et = intval ( $_GET ['et'] );
		$stt = $_POST ['stt'];
		$ett = $_POST ['ett'];
		
		$data ['dtime'] = $dtime = statime ( "Y-m-d" );
		$data ['ztime'] = $ztime = statime ( "Y-m-d", "-1 day" );
		$data ['xtime'] = $xtime = statime ( "Y-m-d", "-6 day" );
		$data ['timeq30'] = $timeq30 = statime ( "Y-m-d", "-29 day" );
		$data ['timed1'] = $timed1 = strtotime ( date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'n' ), 1, date ( 'Y' ) ) ) );
		$st = ! empty ( $st ) ? $st : $dtime;
		$et = ! empty ( $et ) ? $et : $dtime;
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
			/* 初始变量 */
		$tmst = date ( "Y-m-d", $st );
		$tmet = date ( "Y-m-d", $et );
		
		$labtype = isset ( $_GET ['tab'] ) ? ($_GET ['tab'] == '' ? 1 : $_GET ['tab']) : 1;
		
		$field = $field ? $field : 'pv';
		$zvist [$field] = '<b style="color:#f00;">↓</b>';
		$list = M ( 'visitdetail' )->where ( array (
				'dateline' => array (
						array (
								'egt',
								$st 
						),
						array (
								'elt',
								$et 
						) 
				),
				'type' => 1 
		) )->order ( 'pv desc' )->select ();
		
		foreach ( $list as $key => $value ) {
			
			switch ($labtype) {
				case 1 :
					if ($visit [$value ['name']]) {
						$list [$key] ['pv'] = $visit [$value ['name']] ['pv'] + $value ['pv'];
						$list [$key] ['ip'] = $visit [$value ['name']] ['ip'] + $value ['ip'];
						$list [$key] ['alone'] = $visit [$value ['name']] ['alone'] + $value ['alone'];
					}
					$list [$key] ['per'] = sprintf ( "%.2f", ($value ['pv'] / $value ['alone']) );
					$visit [$list [$key] ['name']] = $list [$key];
					break;
				case 2 :
					$shp = explode ( '|', $list [$key] ['remark'] );
					for($i = 0; $i < count ( $shp ); $i ++) {
						if ($shp [$i] != '') {
							$kp = explode ( '-', $shp [$i] );
							$stype = 's' . $kp [0];
							$enginelist [$stype] ['pv'] = $enginelist [$stype] ['pv'] + $kp [1];
						}
					}
					break;
			}
		}
		switch ($labtype) {
			case 1 :
				$field = $field ? $field : 'pv';
				foreach ( $visit as $key => $val ) {
					$order [$key] = $val [$field];
				}
				array_multisort ( $order, SORT_DESC, SORT_NUMERIC, $visit );
				break;
			case 2 :
				array_multisort ( $enginelist, SORT_DESC );
				foreach ( $enginelist as $key => $val ) {
					$yqnum .= $key . '-' . $val ['pv'] . '|';
				}
				$visit = $enginelist;
				break;
		}
		$i = 0;
		foreach ( $visit as $key => $val ) {
			$i ++;
			$visit [$key] ['order'] = $i;
		} /* 排序 */
		import ( 'ORG.Util.Page' ); // 导入分页类
		/* 分页 */
		$list_num = 20;
		$total_count = count ( $visit );
		$Page = new Page ( $total_count, $list_num ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		
		$from_record = $Page->firstRow;
		
		$i = 0;
		foreach ( $visit as $key => $val ) {
			$i ++;
			$maxl = $from_record + $list_num;
			if ($i > $from_record and $i <= $maxl) {
				$newvisit [$key] = $val;
			}
		}
		$visit = $newvisit;
		
		$data ['st'] = $st;
		$data ['et'] = $et;
		$data ['yqnum'] = $yqnum;
		$this->assign ( $data );
		$this->assign ( 'dtab', empty ( $_GET ['dtab'] ) ? 'j' : $_GET ['dtab'] );
		$this->assign ( 'tab', $labtype );
		$this->assign ( 'visit', $visit );
		$this->assign ( 'page', $show ); // 赋值分页输出
		
		$this->display ( './Public/Admin/Alexa/eng.html' );
	}
	public function access() {
		$st = intval ( $_GET ['st'] );
		$et = intval ( $_GET ['et'] );
		$stt = $_POST ['stt'];
		$ett = $_POST ['ett'];
		
		$data ['dtime'] = $dtime = statime ( "Y-m-d" );
		$data ['ztime'] = $ztime = statime ( "Y-m-d", "-1 day" );
		$data ['xtime'] = $xtime = statime ( "Y-m-d", "-6 day" );
		$data ['timeq30'] = $timeq30 = statime ( "Y-m-d", "-29 day" );
		$data ['timed1'] = $timed1 = strtotime ( date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'n' ), 1, date ( 'Y' ) ) ) );
		$st = ! empty ( $st ) ? $st : $dtime;
		$et = ! empty ( $et ) ? $et : $dtime;
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
			/* 初始变量 */
		$tmst = date ( "Y-m-d", $st );
		$tmet = date ( "Y-m-d", $et );
		
		$labtype = isset ( $_GET ['tab'] ) ? ($_GET ['tab'] == '' ? 1 : $_GET ['tab']) : 1;
		
		$field = $field ? $field : 'pv';
		$zvist [$field] = '<b style="color:#f00;">↓</b>';
		$list = M ( 'visitdetail' )->where ( array (
				'dateline' => array (
						array (
								'egt',
								$st 
						),
						array (
								'elt',
								$et 
						) 
				),
				'type' => 2,
				'name' => Array (
						'neq',
						'' 
				) 
		) )->order ( 'pv desc' )->select ();
		
		foreach ( $list as $key => $value ) {
			
			switch ($labtype) {
				case 1 :
					if ($visit [$value ['name']]) {
						$list [$key] ['pv'] = $visit [$value ['name']] ['pv'] + $value ['pv'];
						$list [$key] ['ip'] = $visit [$value ['name']] ['ip'] + $value ['ip'];
						$list [$key] ['alone'] = $visit [$value ['name']] ['alone'] + $value ['alone'];
					}
					$list [$key] ['per'] = sprintf ( "%.2f", ($value ['pv'] / $value ['alone']) );
					$visit [$list [$key] ['name']] = $list [$key];
					break;
				case 2 :
					preg_match_all ( '/(http:\/\/.*?)\/.*?/i ', $value ['name'], $d );
					$do = explode ( 'http://', $d [1] [0] );
					$do [1] = strtolower ( $do [1] );
					$domain [$do [1]] ['pv'] = $domain [$do [1]] ['pv'] + $value ['pv'];
					break;
			}
		}
		switch ($labtype) {
			case 1 :
				$field = $field ? $field : 'pv';
				foreach ( $visit as $key => $val ) {
					$order [$key] = $val [$field];
				}
				array_multisort ( $order, SORT_DESC, SORT_NUMERIC, $visit );
				break;
			case 2 :
				array_multisort ( $domain, SORT_DESC );
				foreach ( $domain as $key => $val ) {
					$yqnum .= $key . '$' . $val ['pv'] . '|';
				}
				$visit = $domain;
				break;
		}
		$i = 0;
		foreach ( $visit as $key => $val ) {
			$i ++;
			$visit [$key] ['order'] = $i;
		} /* 排序 */
		import ( 'ORG.Util.Page' ); // 导入分页类
		/* 分页 */
		$list_num = 20;
		$total_count = count ( $visit );
		$Page = new Page ( $total_count, $list_num ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		$from_record = $Page->firstRow;
		$i = 0;
		foreach ( $visit as $key => $val ) {
			$i ++;
			$maxl = $from_record + $list_num;
			if ($i > $from_record and $i <= $maxl) {
				$newvisit [$key] = $val;
			}
		}
		$visit = $newvisit;
		
		$data ['st'] = $st;
		$data ['et'] = $et;
		$data ['yqnum'] = $yqnum;
		$this->assign ( $data );
		$this->assign ( 'dtab', empty ( $_GET ['dtab'] ) ? 'j' : $_GET ['dtab'] );
		$this->assign ( 'tab', $labtype );
		$this->assign ( 'visit', $visit );
		$this->assign ( 'page', $show ); // 赋值分页输出
		
		$this->display ( './Public/Admin/Alexa/access.html' );
	}
	public function referer() {
		$st = intval ( $_GET ['st'] );
		$et = intval ( $_GET ['et'] );
		$stt = $_POST ['stt'];
		$ett = $_POST ['ett'];
		
		$data ['dtime'] = $dtime = statime ( "Y-m-d" );
		$data ['ztime'] = $ztime = statime ( "Y-m-d", "-1 day" );
		$data ['xtime'] = $xtime = statime ( "Y-m-d", "-6 day" );
		$data ['timeq30'] = $timeq30 = statime ( "Y-m-d", "-29 day" );
		$data ['timed1'] = $timed1 = strtotime ( date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'n' ), 1, date ( 'Y' ) ) ) );
		$st = ! empty ( $st ) ? $st : $dtime;
		$et = ! empty ( $et ) ? $et : $dtime;
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
			/* 初始变量 */
		$tmst = date ( "Y-m-d", $st );
		$tmet = date ( "Y-m-d", $et );
		
		$labtype = isset ( $_GET ['tab'] ) ? ($_GET ['tab'] == '' ? 1 : $_GET ['tab']) : 1;
		
		$field = $field ? $field : 'pv';
		$zvist [$field] = '<b style="color:#f00;">↓</b>';
		$list = M ( 'visitdetail' )->where ( array (
				'dateline' => array (
						array (
								'egt',
								$st 
						),
						array (
								'elt',
								$et 
						) 
				),
				'type' => 3 
		) )->order ( 'pv desc' )->select ();
		
		foreach ( $list as $key => $value ) {
			
			switch ($labtype) {
				case 1 :
					if ($visit [$value ['name']]) {
						$list [$key] ['pv'] = $visit [$value ['name']] ['pv'] + $value ['pv'];
						$list [$key] ['ip'] = $visit [$value ['name']] ['ip'] + $value ['ip'];
						$list [$key] ['alone'] = $visit [$value ['name']] ['alone'] + $value ['alone'];
					}
					$list [$key] ['per'] = sprintf ( "%.2f", ($value ['pv'] / $value ['alone']) );
					$visit [$list [$key] ['name']] = $list [$key];
					break;
				case 2 :
					preg_match_all ( '/(http:\/\/.*?)\/.*?/i ', $value ['name'], $d );
					$do = explode ( 'http://', $d [1] [0] );
					if ($do [1] == '')
						$do [1] = '直接输入网址';
					$domain [$do [1]] ['pv'] = $domain [$do [1]] ['pv'] + $value ['pv'];
					break;
			}
		}
		switch ($labtype) {
			case 1 :
				$visit = arraysort2 ( $visit, $field, SORT_DESC );
				break;
			case 2 :
				array_multisort ( $domain, SORT_DESC );
				foreach ( $domain as $key => $val ) {
					$yqnum .= $key . '$' . $val ['pv'] . '|';
				}
				$visit = $domain;
				break;
		}
		$i = 0;
		foreach ( $visit as $key => $val ) {
			$i ++;
			$visit [$key] ['order'] = $i;
		} /* 排序 */
		import ( 'ORG.Util.Page' ); // 导入分页类
		/* 分页 */
		$list_num = 20;
		$total_count = count ( $visit );
		$Page = new Page ( $total_count, $list_num ); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show (); // 分页显示输出
		
		$from_record = $Page->firstRow;
		
		$i = 0;
		foreach ( $visit as $key => $val ) {
			$i ++;
			$maxl = $from_record + $list_num;
			if ($i > $from_record and $i <= $maxl) {
				$val ['order'] = $i;
				$newvisit [$key] = $val;
			}
		}
		$visit = $newvisit;
		
		$data ['st'] = $st;
		$data ['et'] = $et;
		$data ['yqnum'] = $yqnum;
		$this->assign ( $data );
		$this->assign ( 'dtab', empty ( $_GET ['dtab'] ) ? 'j' : $_GET ['dtab'] );
		$this->assign ( 'tab', $labtype );
		$this->assign ( 'visit', $visit );
		$this->assign ( 'page', $show ); // 赋值分页输出
		
		$this->display ( './Public/Admin/Alexa/referer.html' );
	}
	public function engdata() {
		$yqnum = $_GET ['yqnum'];
		$yqnum = explode ( '|', $yqnum );
		$char_str = "<graph decimalPrecision='0' showPercentageValues='1' showNames='1' showValues='0' showPercentageInLabel='0' pieYScale='45' pieBorderAlpha='100' baseFontSize='12' pieRadius='100' animation='0' shadowXShift='4' shadowYShift='4' shadowAlpha='40' pieFillAlpha='95' pieBorderColor='FFFFFF' BGCOLOR='F8F8F8'>";
		$t = 0;
		for($i = 0; $i < count ( $yqnum ); $i ++) {
			if ($yqnum [$i] != '') {
				$p = explode ( '-', $yqnum [$i] );
				
				$p0 = enginetype ( $p [0] );
				$t = $t + $p [1];
				$metdata [$i] ['value'] = $p [1];
				$metdata [$i] ['name'] = $p0;
			}
		}
		$h = 0;
		foreach ( $metdata as $key => $val ) {
			$b = sprintf ( "%.2f", $val [value] / $t ) * 100;
			if (count ( $yqnum ) > 4 && $b < 4) {
				$h = $h + $val ['value'];
			} else {
				$char_str .= "<set value='{$val[value]}' name='{$val[name]}'/>";
			}
		}
		if ($h)
			$char_str .= "<set value='{$h}' name='其他'/>";
		$char_str .= "</graph>";
		
		$char_str = iconv ( "UTF-8", "GB2312//IGNORE", $char_str );
		echo $char_str;
	}
	public function summaydata() {
		$st = intval ( $_GET ['st'] );
		$et = intval ( $_GET ['et'] );
		
		$list = M ( 'visitsummary' )->where ( array (
				'dateline' => array (
						array (
								'egt',
								$st 
						),
						array (
								'elt',
								$et 
						) 
				) 
		) )->select ();
		
		foreach ( $list as $key => $value ) {
			$suy = explode ( '|', $value ['part'] );
			for($i = 0; $i < 24; $i ++) {
				$ky = explode ( '-', $suy [$i] );
				$summary_pv [$i] = $ky [0] == '' ? 0 : $ky [0];
				$summary_ip [$i] = $ky [1] == '' ? 0 : $ky [1];
				$summary_al [$i] = $ky [2] == '' ? 0 : $ky [2];
			}
			$summary [] = $value;
		}
		
		$ml = date ( 'G' ) - 23;
		if ($ml < 0) {
			$p = 24 + $ml;
			$ztime = statime ( "Y-m-d", "-1 day" );
			$ztdat = M ( 'visitsummary' )->where ( array (
					'dateline' => $ztime 
			) )->find ();
			$suy = $ztdat ? explode ( '|', $ztdat ['part'] ) : '';
			for($i = 0; $i < 24; $i ++) {
				if ($i >= $p) {
					$ky = explode ( '-', $suy [$i] );
					if (! $ky || $ky [0] == '') {
						$ky [0] = 0;
						$ky [1] = 0;
						$ky [2] = 0;
					}
					$summary_pv [$i] = $ky [0];
					$summary_ip [$i] = $ky [1];
					$summary_al [$i] = $ky [2];
				}
			}
		}
		$char_str = "<graph BGCOLOR='F8F8F8' yAxisMinValue='0' decimalPrecision='0' showValues='0' showAlternateHGridColor='1' AlternateHGridColor='ff5904' divLineColor='ff5904' divLineAlpha='20' alternateHGridAlpha='5' anchorRadius='4' anchorBgColor='ffffff' baseFontSize='12' canvasBorderColor='cccccc' canvasBorderThickness='1'
		shadowAlpha='30' numVDivLines ='22' showAlternateVGridColor='1' alternateVGridAlpha='5' outCnvbaseFontSize='10' formatNumberScale='0'
		>";
		$dtm = date ( 'Y-m-d' );
		$char_str .= '<categories>';
		for($i = 0; $i < 24; $i ++) {
			if ($p == 24)
				$p = 0;
			$lp = $p % 2 == 0 ? 1 : 0;
			$dtms = $dtm;
			if ($p > date ( 'G' ))
				$dtms = date ( "Y-m-d", statime ( "Y-m-d", "-1 day" ) );
			$char_str .= $sys ? "<category name='{$p}' showName='{$lp}' hoverText='{$dtms} {$p}'/>" : "<category name='{$p}:00' showName='{$lp}' hoverText='{$dtms} {$p}:00'/>";
			$p ++;
		}
		$char_str .= '</categories>';
		/* PV */
		$char_str .= "<dataset seriesName='pv' color='0033ca' anchorBorderColor='0033ca' anchorBgColor='ffffff' anchorSides='10' anchorRadius='4'>";
		for($i = 0; $i < 24; $i ++) {
			if ($p == 24)
				$p = 0;
			$lp = $p % 2 == 0 ? 1 : 0;
			if (! $summary_pv [$p])
				$summary_pv [$p] = 0;
			$char_str .= "<set value='{$summary_pv[$p]}' />";
			$p ++;
		}
		$char_str .= '</dataset>';
		/* IP */
		$char_str .= "<dataset seriesName='ip' color='fd0100' anchorBorderColor='fd0100' anchorBgColor='ffffff' anchorSides='10' anchorRadius='4'>";
		for($i = 0; $i < 24; $i ++) {
			if ($p == 24)
				$p = 0;
			$lp = $p % 2 == 0 ? 1 : 0;
			if (! $summary_ip [$p])
				$summary_ip [$p] = 0;
			$char_str .= "<set value='{$summary_ip[$p]}' />";
			$p ++;
		}
		$char_str .= '</dataset>';
		/* 独立访客 */
		$char_str .= "<dataset seriesName='独立访客' color='2AD62A' anchorBorderColor='2AD62A' anchorBgColor='ffffff' anchorSides='10' anchorRadius='4'>";
		for($i = 0; $i < 24; $i ++) {
			if ($p == 24)
				$p = 0;
			$lp = $p % 2 == 0 ? 1 : 0;
			if (! $summary_al [$p])
				$summary_al [$p] = 0;
			$char_str .= "<set value='{$summary_al[$p]}' />";
			$p ++;
		}
		$char_str .= '</dataset>';
		$char_str .= '</graph>';
		
		$char_str = iconv ( "UTF-8", "GB2312//IGNORE", $char_str );
		echo $char_str;
	}
	public function accessdata() {
		$st = intval ( $_GET ['st'] );
		$et = intval ( $_GET ['et'] );
		$yqnums = $_GET ['yqnums'];
		$yqnum = $_GET ['yqnum'];
		if ($yqnums) {
			$list = M ( 'visitdetail' )->where ( array (
					'dateline' => array (
							array (
									'egt',
									$st 
							),
							array (
									'elt',
									$et 
							) 
					),
					'type' => 3 
			) )->order ( 'pv desc' )->select ();
			$domain = array ();
			
			foreach ( $list as $key => $value ) {
				
				preg_match_all ( '/(http:\/\/.*?)\/.*?/i ', $value ['name'], $d );
				$do = explode ( 'http://', $d [1] [0] );
				$domain [$do [1]] ['pv'] = $domain [$do [1]] ['pv'] + $value ['pv'];
			}
			array_multisort ( $domain, SORT_DESC );
			foreach ( $domain as $key => $val ) {
				$yqnum .= $key . '$' . $val ['pv'] . '|';
			}
		}
		$yqnum = explode ( '|', urldecode ( $yqnum ) );
		$char_str = "<graph decimalPrecision='0' showPercentageValues='1' showNames='1' showValues='0' showPercentageInLabel='0' pieYScale='45' pieBorderAlpha='100' baseFontSize='12' pieRadius='100' animation='0' shadowXShift='4' shadowYShift='4' shadowAlpha='40' pieFillAlpha='95' pieBorderColor='FFFFFF' BGCOLOR='F8F8F8'>";
		$t = 0;
		for($i = 0; $i < count ( $yqnum ); $i ++) {
			if ($yqnum [$i] != '') {
				$p = explode ( '$', $yqnum [$i] );
				$t = $t + $p [1];
				$metdata [$i] ['value'] = $p [1];
				$metdata [$i] ['name'] = $p [0];
			}
		}
		$h = 0;
		foreach ( $metdata as $key => $val ) {
			$b = sprintf ( "%.2f", $val [value] / $t ) * 100;
			if (count ( $yqnum ) > 4 && $b < 4) {
				$h = $h + $val ['value'];
			} else {
				$char_str .= "<set value='{$val[value]}' name='{$val[name]}'/>";
			}
		}
		if ($h)
			$char_str .= "<set value='{$h}' name='其他'/>";
		$char_str .= "</graph>";
		$char_str = iconv ( "UTF-8", "GB2312//IGNORE", $char_str );
		echo $char_str;
	}
}
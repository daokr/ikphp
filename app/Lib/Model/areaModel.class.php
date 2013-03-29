<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class areaModel extends Model {
	
	public function name_exists($name, $id = 0) {
		$where = "username='" . $name . "' AND userid<>'" . $id . "'";
		$result = $this->where ( $where )->count ( 'userid' );
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	// 获取单个区域
	public function getOneArea($areaid){
		$where = array('areaid'=>$areaid);
		$result = $this->where ( $where )->find ();
		return $result;	
	}
	// 获取区域下的区域
	public function getReferArea($areaid) {
		$where = "referid='" . $areaid . "'";
		$result = $this->where ( $where )->select ();
		return $result;
	}
	// 通过连贯性找到三级区域
	public function getArea($areaid) {
		$strAreaThree = $this->where (array('areaid'=>$areaid))->find();
		
		if ($strAreaThree) {
			
			if ($strAreaThree ['referid'] > 0) {
				$strAreaTwo = $this->where ( array('areaid'=>$strAreaThree ['referid']))->find();
				if ($strAreaTwo ['referid'] > 0) {
					$strAreaOne = $this->where ( array('areaid'=>$strAreaTwo ['referid']))->find();
					$strArea = array (
							'one' => array (
									'areaid' => $strAreaOne ['areaid'],
									'areaname' => $strAreaOne ['areaname'] 
							),
							'two' => array (
									'areaid' => $strAreaTwo ['areaid'],
									'areaname' => $strAreaTwo ['areaname'] 
							),
							'three' => array (
									'areaid' => $strAreaThree ['areaid'],
									'areaname' => $strAreaThree ['areaname'] 
							) 
					);
				} else {
					$strArea = array (
							'two' => array (
									'areaid' => $strAreaTwo ['areaid'],
									'areaname' => $strAreaTwo ['areaname'] 
							),
							'three' => array (
									'areaid' => $strAreaThree ['areaid'],
									'areaname' => $strAreaThree ['areaname'] 
							) 
					);
				}
			} else {
				$strArea = array (
						'three' => array (
								'areaid' => $strAreaThree ['areaid'],
								'areaname' => $strAreaThree ['areaname'] 
						) 
				);
			}
		
		} else {
			$strArea = array (
					'three' => array (
							'areaid' => '0',
							'areaname' => '火星' 
					) 
			);
		}
		return $strArea;
	
	}
}
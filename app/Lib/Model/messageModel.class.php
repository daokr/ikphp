<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class messageModel extends Model {
	
	// 发送消息
	public function sendMessage($userid, $touserid, $title, $content) {
		if ($touserid && $content) {
			$data = array (
					'userid' => $userid,
					'touserid' => $touserid,
					'title' => $title,
					'content' => $content,
					'addtime' => time () 
			);
			if (! false == $this->create ( $data )) {
				$messageid = $this->add ();
			}
		
		}
		return $messageid>0 ? $messageid : 0;
	}
}
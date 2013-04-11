<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class noticeAction extends Action {
	
    //网站提醒
    public function isupdate(){
    	//$ref = $_SERVER['HTTP_REFERER'];
    	//$ip = get_client_ip();
    	$v = $this->_get('v');
    	if($v<IKPHP_VERSION){
    		$html = '<tr><td width="100" style="color:red">发现有新版本：</td><td style="color:red">IKPHP 1.5.1 版本 <a href="http://www.ikphp.com" target="_blank">[下载升级包]</a></td></tr>';
    		$this->ajaxReturn($html,'JSONP');
    	}else{
    		$this->ajaxReturn('<tr><td width="100">还没有新版本：</td><td>请再等等吧^_^！</td></tr>','JSONP');
    	}
    }
	
}
<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class tagAction extends frontendAction {
	public function _initialize() {
		parent::_initialize ();
		$this->tag_mod = D ( 'tag' );
	}
	public function add_ajax() {
		$objname = $this->_post ( 'objname' );
		$idname = $this->_post ( 'idname' );
		$objid = $this->_post ( 'objid' );
		$tags = $this->_post ( 'tags', 'trim' );
		$tagid = $this->tag_mod->addTag ( $objname, $idname, $objid, $tags );	
	}
}
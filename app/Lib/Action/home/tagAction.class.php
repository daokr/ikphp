<?php
// 本类由系统自动生成，仅供测试用途
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
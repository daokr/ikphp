<?php
class appsAction extends backendAction {

    public function _before_index() {
        $this->sort = 'ordid';
        $this->order = 'ASC';
        $big_menu = array(
            'title' => L('nav_add'),
            'iframe' => U('nav/add'),
            'id' => 'add',
            'width' => '500',
            'height' => '200'
        );
        $this->assign('big_menu', $big_menu);
    }

}
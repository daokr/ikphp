<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
* @Email:160780470@qq.com
*/
class cacheAction extends backendAction
{
    public function _initialize() {
        parent::_initialize();
    }

    public function index() {
    	$list = array(
    			array('id'=>'1','name'=>'数据库字段缓存','desc'=>'修改过数据库结构之后更新'),
    			array('id'=>'2','name'=>'模板编译缓存','desc'=>'修改过模板文件后更新'),
    			array('id'=>'3','name'=>'站点数据缓存','desc'=>'网站迁移、恢复、修改配置文件后网站数据异常时更新'),
    			array('id'=>'4','name'=>'网站编译缓存','desc'=>'网站迁移、恢复、修改网站配置后更新'),
    			array('id'=>'5','name'=>'网站日志文件','desc'=>'清理项目日志文件释放服务器空间'),
    			array('id'=>'6','name'=>'JS缓存文件','desc'=>'修改过JS文件需要更新才会生效'),
    			);
    	$this->assign('list', $list);
    	$this->title ( '缓存管理' );
    	$this->display();
    }

    public function delete() {
        $id = $this->_get('id','trim');
        $obj_dir = new Dir;
        switch ($id) {
            case '1':
                is_dir(DATA_PATH . '_fields/') && $obj_dir->del(DATA_PATH . '_fields/');
                break;
            case '2':
                is_dir(CACHE_PATH) && $obj_dir->delDir(CACHE_PATH);
                break;
            case '3':
                is_dir(DATA_PATH) && $obj_dir->del(DATA_PATH);
                is_dir(TEMP_PATH) && $obj_dir->delDir(TEMP_PATH);
                break;
            case '4':
                @unlink(RUNTIME_FILE);
                break;
            case '5':
                is_dir(LOG_PATH) && $obj_dir->delDir(LOG_PATH);
                break;
            case '6':
                is_dir(IKPHP_DATA_PATH . '/static/') && $obj_dir->del(IKPHP_DATA_PATH . '/static/');
                break;
        }
        $this->success('成功清除缓存！');
    }

    public function qclear() {
        $obj_dir = new Dir;
        is_dir(DATA_PATH . '_fields/') && $obj_dir->del(DATA_PATH . '_fields/');
        is_dir(CACHE_PATH) && $obj_dir->delDir(CACHE_PATH);
        is_dir(DATA_PATH) && $obj_dir->del(DATA_PATH);
        is_dir(TEMP_PATH) && $obj_dir->delDir(TEMP_PATH);
        is_dir(LOG_PATH) && $obj_dir->delDir(LOG_PATH);
        is_dir(IK_DATA_PATH . '/static/') && $obj_dir->del(IK_DATA_PATH . '/static/');
        @unlink(RUNTIME_FILE);
        $arrJson = array('r'=>0, 'html'=> '成功清除缓存！');
        echo json_encode($arrJson);
    }
}
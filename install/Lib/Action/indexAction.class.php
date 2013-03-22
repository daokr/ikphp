<?php
/*
 * IKPHP爱客网 安装程序 @copyright (c) 2012-3000 IKPHP All Rights Reserved @author 小麦
 * @Email:160780470@qq.com
 */
class indexAction extends Action {
	
	public function _initialize() {
		L ( include LANG_PATH . 'common.php' );
	}
	
	public function index() {
		$flag = true;
		// 检测文件夹权限
		$check_file = array (
				'./data',
				'./data/static',
				'./data/upload',
				'./data/config/db.php',
				'./data/config/url.php',
				'./data/config/home/config.php',
				'./install/Runtime',
				'./install/Runtime/Data',
		);
		$error = array ();
		foreach ( $check_file as $file ) {
			$path_file = $file;
			if (! file_exists ( $path_file )) {
				$error [] = $file . L ( 'not_exists' );
				$flag = false;
				continue;
			}
			if (! is_writable ( $path_file )) {
				$error [] = $file . L ( 'not_writable' );
				$flag = false;
			}
		}
		if (! $flag) {
			$this->assign ( 'error', $error );
			$this->display ();
		} else {
			$this->display ();
		}
	}
	
	public function next() {
		if (IS_POST) {
			foreach ( $_POST as $key => $val ) {
				$this->assign ( $key, $val );
			}
			extract ( $_POST );
			if (! $dbname || ! $dbuser || ! $dbhost || ! $dbport || ! $dbprefix) {
				$this->assign ( 'error_msg', L ( 'please_input_config_info' ) );
				$this->display ();
				exit ();
			}
			if (! $this->_is_email ( $admin_email )) {
				$this->assign ( 'error_msg', L ( 'admin_email_format_incorrect' ) );
				$this->display ();
				exit ();
			}
			// 试着连接数据库
			$conn = @mysql_connect ( $dbhost . ':' . $dbport, $dbuser, $dbpwd );
			if (! $conn) {
				$this->assign ( 'error_msg', L ( 'connect_mysql_error' ) );
				$this->display ();
				exit ();
			}
			
			$selected_db = @mysql_select_db ( $dbname );
			
			if ($selected_db) {
				// 如果数据库存在 并且里面安装过 提示是否覆盖
				$query = @mysql_query ( "SHOW TABLES LIKE '{$dbprefix}%'" );
				$was_install = false;
				while ( $row = mysql_fetch_assoc ( $query ) ) {
					$was_install = true;
					break;
				}
				if ($was_install && ! isset ( $force_install )) {
					$this->assign ( 'database_name_tip', L ( 'db_isset' ) );
					$this->display ();
					exit ();
				} else {
					$this->_set_temp ( $_POST );
					$this->redirect ( 'install' );
				}
			} else {
				if (mysql_get_server_info ( $conn ) > '4.1') {
					$charset = C ( 'DEFAULT_CHARSET' );
					$sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET " . str_replace ( '-', '', $charset );
				} else {
					$sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}`";
				}
				if (! mysql_query ( $sql, $conn )) {
					$this->assign ( 'error_msg', L ( 'create_db_error' ) );
					$this->display ();
					exit ();
				}
				$this->_set_temp ( $_POST );
				$this->redirect ( 'install' );
			}
		} else {
			$this->assign ( 'database_name_tip', L ( 'database_name_tip' ) );
			
			$this->assign ( 'dbname', 'ikphp' );
			$this->assign ( 'dbuser', 'root' );
			$this->assign ( 'dbpwd', '' );
			$this->assign ( 'dbhost', 'localhost' );
			$this->assign ( 'dbport', '3306' );
			$this->assign ( 'dbprefix', 'ik_' );
			
			$this->assign ( 'site_title', '爱客网' );
			$this->assign ( 'site_subtitle', '又一个爱客开源社区' );
			$this->assign ( 'site_url', $this->getHttpUrl ());
			
			$this->assign ( 'admin_email', 'admin@admin.com' );
			$this->assign ( 'admin_password', '000000' );
			$this->assign ( 'admin_username', 'admin' );
			$this->display ();
		}
	}
	public function install() {
		$charset = C ( 'DEFAULT_CHARSET' );
		header ( 'Content-type:text/html;charset=' . $charset );
		$temp_info = F ( 'temp_data' );
		$conn = mysql_connect ( $temp_info ['dbhost'] . ':' . $temp_info ['dbport'], $temp_info ['dbuser'], $temp_info ['dbpwd'] );
		$version = mysql_get_server_info ();
	    $charset = str_replace('-', '', $charset);
        if ($version > '4.1') {
            if ($charset != 'latin1') {
                mysql_query("SET character_set_connection={$charset}, character_set_results={$charset}, character_set_client=binary", $conn);
            }if ($version > '5.0.1') {
                mysql_query("SET sql_mode=''", $conn);
            }
        }
		$selected_db = mysql_select_db ( $temp_info ['dbname'], $conn );
		// 开始创建数据表
		$sqls = $this->_get_sql ( APP_PATH . 'Sql_data/create_table.sql' );
		foreach ( $sqls as $sql ) {
			// 替换前缀
			$sql = str_replace ( '`ik_', '`' . $temp_info ['dbprefix'], $sql );
			// 获得表名
			$run = mysql_query ( $sql, $conn );
			if (substr ( $sql, 0, 12 ) == 'CREATE TABLE') {
				$table_name = $temp_info ['dbprefix'] . preg_replace ( "/CREATE TABLE `" . $temp_info ['dbprefix'] . "([a-z0-9_]+)` .*/is", "\\1", $sql );
			}
		}
		//添加管理员帐号
		$admin_password = md5($temp_info['admin_password']);
		$sql = "INSERT INTO `" . $temp_info['dbprefix'] . "admin` (`username`, `password`, `email`, `role_id`) VALUES " .
				"('" . $temp_info['admin_username'] . "', '" . $admin_password . "', '" . $temp_info['admin_email'] . "', 1);";		
		$userid = mysql_query( $sql, $conn );

		
		//更改网站信息
		$run = mysql_query ( "UPDATE `" . $temp_info['dbprefix'] . "setting` set `data`='".$temp_info ['site_title']."' where `name`='site_title'", $conn );
		$run = mysql_query ( "UPDATE `" . $temp_info['dbprefix'] . "setting` set `data`='".$temp_info ['site_subtitle']."' where `name`='site_subtitle'" , $conn );
		$run = mysql_query ( "UPDATE `" . $temp_info['dbprefix'] . "setting` set `data`='".$temp_info ['site_url']."' where `name`='site_url'" , $conn );

		//修改配置文件
		$config_file = './data/config/db.php';
		$config_data['DB_SQL'] = $temp_info['sql'];
		$config_data['DB_HOST'] = $temp_info['dbhost'];
		$config_data['DB_NAME'] = $temp_info['dbname'];
		$config_data['DB_USER'] = $temp_info['dbuser'];
		$config_data['DB_PWD'] = $temp_info['dbpwd'];
		$config_data['DB_PORT'] = $temp_info['dbport'];
		$config_data['DB_PREFIX'] = $temp_info['dbprefix'];
		file_put_contents($config_file, "<?php\r\nreturn " . var_export($config_data, true) . ";");
		//安装完毕
		$this->redirect ( 'result');
	}
	public function result() {
        touch('./data/install.lock');
        $temp_info = F ( 'temp_data' );
        $this->assign ( 'email', $temp_info['admin_email'] );
        $this->assign ( 'home_url', $temp_info['site_url'] );
        $this->assign ( 'admin_url', $temp_info['site_url'].'index.php?g=admin' );
        $this->assign ( 'password', $temp_info['admin_password'] );
        $this->display();
	}
	private function _is_email($email) {
		$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,5}\$/i";
		if (strpos ( $email, '@' ) !== false && strpos ( $email, '.' ) !== false) {
			if (preg_match ( $chars, $email )) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	private function _set_temp($temp_data) {
		F ( 'temp_data', $temp_data );
	}
	private function _get_sql($sql_file) {
		$contents = file_get_contents ( $sql_file );
		$contents = str_replace ( "\r\n", "\n", $contents );
		$contents = trim ( str_replace ( "\r", "\n", $contents ) );
		$return_items = $items = array ();
		$items = explode ( ";\n", $contents );
		
		foreach ( $items as $item ) {
			$return_item = '';
			$item = trim ( $item );
			$lines = explode ( "\n", $item );
			foreach ( $lines as $line ) {
				if (isset ( $line [1] ) && $line [0] . $line [1] == '--') {
					continue;
				}
				$return_item .= $line;
			}
			if ($return_item) {
				$return_items [] = $return_item; // .";";
			}
		}
		return $return_items;
	}
	//获取带http的网站域名 BY wanglijun
	private function getHttpUrl(){
		$arrUri = explode('install.php',$_SERVER['REQUEST_URI']);
		$site_url = 'http://'.$_SERVER['HTTP_HOST'].$arrUri[0];
		return $site_url;
	}

}
<?
class DB {
	private static $connected = false;
	
	public static function connect() {
		if(self::$connected) return;
		$con = mysql_connect(DB_SERVER.':'.DB_PORT, DB_USERNAME, DB_PASSWORD);
		if(!$con) {
			die('Could not connect: ' . mysql_error());
		}else{
			self::$connected = true;
		}
		mysql_set_charset('utf8',$con);
		mysql_select_db(DB_NAME, $con);
	}
	
	public static function query($sql) {
		if(!self::$connected) self::connect();
		return mysql_query($sql);
	}
	
	public static function getData($sql) {
		if(!self::$connected) self::connect();
		$data = array();
		$result = mysql_query($sql);
		if($result === false) return $data;
		while($row = mysql_fetch_assoc($result)) {
			array_push($data, $row);
		}
		return $data;
	}

	public static function getRowData($sql) {
		if(!self::$connected) self::connect();
		$data = array();
		$result = mysql_query($sql);
		if($result === false) return $data;
		while($row = mysql_fetch_row($result)) {
			array_push($data, $row);
		}
		return $data;
	}
	
	public static function getFirstRow($sql) {
		$data = self::getData($sql);
		if(isset($data[0])){
			return $data[0];
		}else{
			return false;
		}
	}

	public static function getFirstGrid($sql) {
		$data =  self::getRowData($sql);
		if(isset($data[0][0])){
			return $data[0][0];
		}else{
			return '';
		}
	}

	
}

?>
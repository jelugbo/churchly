<?php
//require_once 'session/SessionManagerException.php';
require_once(realpath(__DIR__ . '/../../api/vendor/autoload.php'));
require_once(realpath(__DIR__ . '/../../api/classes/conf/config.php'));
/**
 * Db Session (Singleton)
 *
 * @author Sascha Hoercher <hoercher@it-togo.com>
 * @copyright Sascha Hoercher
 * @version 10.12.2005
 * @package framework.session
 */
class SessionManager {

	/**
	 * The instance of Session
	 *
	 * @var mixed $instance
	 */
	static private $instance = false;

	/**
	 * Constructor
	 */
	private function __construct() {
		//require_once 'dao/Session.php';
		if (
		!session_set_save_handler(
			array($this, 'open'),
			array($this, 'close'),
			array($this, 'read'),
			array($this, 'write'),
			array($this, 'destroy'),
			array($this, 'gc')
		)
		) {
			throw new Exception('Cannot register new session handler!');
		}

		session_start();
	}

	/**
	 * Destructor
	 */
	public function __destruct() {
		session_write_close();
	}

	/**
	 * Get a singleton instance
	 *
	 * @return object instance of session
	 */
	static function instance() {
		if(!SessionManager::$instance)
			SessionManager::$instance = new SessionManager();
		return SessionManager::$instance;
	}

	/**
	 * open
	 *
	 * @param string $path
	 * @param string $name
	 * @return boolean true on success
	 */
	public function open($path, $name) {
		return true;
	}

	/**
	 * close
	 *
	 * @return boolean true on success
	 */
	public function close() {
		return true;
	}

	/**
	 * read
	 *
	 * @param  string $id
	 * @return string session data
	 */
	public function read($id) {
		// Open the database connection
		$db = new SessionsQuery();
		$array = $db->findOneById($id);
		$session = 'false';
// If the array is empty
		if (!empty($array))
		{
			$data= $array->toArray();
			$session = $data['Data'];
		}
		return $session;
	}

	/**
	 * write
	 *
	 * @param  string $id
	 * @param  string $data
	 * @return boolean
	 */
	public function write($id, $data) {
		$access = time();
		SessionsQuery::create()->filterById($id)->findOneOrCreate()
		->setData($data)->setAccess($access)->setId($id)->save();
		return true;
	}

	/**
	 * destroy
	 *
	 * @param  string $id
	 * @return boolean
	 */
	public function destroy($id) {
		$session = SessionsQuery::create()->findOneById($id);
		$session->delete();
		return true;
	}

	/**
	 * gc Garbage Collector
	 *
	 * @param  int $maxLifeTime in seconds
	 * @return boolean
	 */
	public function gc($maxLifeTime) {
		$old = time() - $maxLifeTime;
		$session = SessionsQuery::create()->where('Sessions.Access < ?', $old)->find();
		$session->delete();
		return true;
	}
	

	/***************************
	 * FUNCTION: SESSION WRITE *
	 ***************************/
	function  session_write($sess_id, $data)
	{
		$access = time();
		$conn = Propel::getConnection();
		$stmt = $conn->prepare("REPLACE INTO sessions VALUES (:sess_id, :access, :data)");
		$stmt->execute(array(":sess_id"=> $sess_id, ":access" => $access, ":data" => $data));

//	$db = SessionsQuery::create()->filterById($sess_id)
//		->filterByData($data)->filterByAccess($access)->findOneOrCreate($conn)
//		->setData($data)->setAccess($access)->setId($sess_id)->save();
		return true;
	}
	


	
}
?>
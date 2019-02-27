<?php
/**
 * User: hailongtrinh
 * Date: 10/04/2017
 * Last update : 17/09/2017
 * Time: 16:00 CH
 * Log:
 * --- 05-04-17  Add stringcutter function----
 * --- 10-04-17  Add number2word function----
 * --- 17-04-17  Update sendmail function (multi to address)----
 * --- 20-04-17  Add numofweekday function----
 * --- 23-04-17  Update getsystemuser function----
 * --- 01-06-17  Update selectlist function,id is key of array
 * --- 12-06-17  Update pass dev
 * --- 15-06-17  Add getbackday function
 * --- 22-07-17  Update Insert function with viewper and editper by owner,fix error search field
 * --- 23-07-17  Add getlistdataman function
 * --- 14-07-18  Add selectbox funtion
 * --- 17-09-17  Upgrade Update function with viewper,editper,owner
 */


/*********************************Variable List************************/

date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date('Y-m-d H:i:s');
$todays = date('d-m-Y H:i:s');
$datetoday = date('Y-m-d');
$datetodays = date('d-m-Y');
$wdtoday = getWeekday($datetoday);
$daynow = date('d');
$monthnow = date('m');
$yearnow = date('Y');
$timenow = date('H:i:s');
$curhost = $_SERVER['SERVER_NAME'];
$curlink = $_SERVER['PHP_SELF'];


/*********************************TIT Function************************/
class titAuth extends PDO
{
	public function __construct($dbhost, $dbuser, $dbpass, $dbname, $port = 3306)
	{
		try {
			parent::__construct("mysql:host=" . $dbhost . ";port=" . $port . ";dbname=$dbname", $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
		} catch (PDOException $e) {
			return false;
			//die("<h3>Database không tồn tại hoặc lỗi connection!</h3><br/>" . $e);
		}
	}
}

class demoAuth extends PDO
{
	public function __construct($dbname)
	{
	}
}

class appAuth extends PDO
{
	public function __construct($dbname)
	{
	}
}

class apiAuth extends PDO
{
	public function __construct($dbname)
	{
	}
}

class devAuth extends PDO
{
	public function __construct($dbname)
	{
	}
}

function getsystemuser($db, $table, $field, $user)
{
	$sql = 'SELECT * FROM ' . $table . ' inner join user on ' . $field . ' = user.Name where user.Id = "' . $user.'"';
	try {
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$userinfo = $stmt->fetch();
		$id = ucfirst($table) . '_id';
		$userinfo['uid'] = $userinfo[$id];
		return $userinfo;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
}

function stringcutter($string, $num)
{
	$string = substr($string, 0, $num);
	$string = substr($string, 0, strrpos($string, " "));
	return $string;
}

function genhash()
{
	$hash = md5(uniqid(mt_rand(), true));
	return $hash;
}

function getdataman($db, $dataid)
{
	$sql = "SELECT * from dataman where id = :id";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':id', $dataid, PDO::PARAM_STR);
	$stmt->execute();
	$datavlue = $stmt->fetch();
	return $datavlue['Value'];
}//end dataman

function sendmail($from, $to, $subject, $body, $files = array())
{
	include_once 'sendmail/PHPMailerAutoload.php';
	$mailuser = (empty($from['username'])) ? "info.demo.faceworks@gmail.com" : $from['username'];
	$mailpass = (empty($from['password'])) ? "demofaceworks123" : $from['password'];
	$sendname = (empty($from['sendname'])) ? "TIT-Faceworks" : $from['sendname'];
	$bcc = (empty($from['bcc'])) ? "" : $from['bcc'];
	$cc = (empty($from['cc'])) ? "" : $from['cc'];
	$host = (empty($from['host'])) ? "ssl://smtp.gmail.com" : $from['host'];
	$secure = (empty($from['secure'])) ? "ssl" : $from['secure'];
	$port = (empty($from['port'])) ? "465" : $from['port'];
	$from = $mailuser;
	$mail = new PHPMailer;

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $host;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = $mailuser;                 // SMTP username
	$mail->Password = $mailpass;                           // SMTP password
	$mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = $port;                                // TCP port to connect to
	if ($secure == "tls"):
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
	endif;
	$mail->setFrom($mailuser, $sendname);
	if(isset($from['replyto']))
	$mail->AddReplyTo($from['replyto'], $from['replyto']);
	if (is_array($to)) {
		foreach ($to as $k => $v) {
			$maillist = explode(';', $v);
			foreach ($maillist as $kv => $vv) {
				$mail->addAddress($vv);     // Add a recipient
			}
		}

	} else {
		$maillist = explode(';', $to);
		foreach ($maillist as $k => $v) {
			$mail->addAddress($v);     // Add a recipient
		}
	}

	if (!empty($bcc)) {
		if (is_array($bcc)) {
			foreach ($bcc as $k => $v) {
				$maillist = explode(';', $v);
				foreach ($maillist as $kv => $vv) {
					$mail->AddBCC($vv);     // Add a recipient
				}
			}

		} else {
			$maillist = explode(';', $bcc);
			foreach ($maillist as $k => $v) {
				$mail->AddBCC($v);     // Add a recipient
			}
		}
	}





	if (!empty($cc)) {
		if (is_array($cc)) {
		foreach ($cc as $k => $v) {
					$maillist = explode(';', $v);
				foreach ($maillist as $kv => $vv) {
			$mail->AddCC($vv);     // Add a recipient
		}

		}

	} else {
		$maillist = explode(';', $cc);
				foreach ($maillist as $k => $v) {
			$mail->AddCC($v);     // Add a recipient
					//$mail->addCustomHeader("BCC:".$v);
		}
	}
	}

	foreach ($files as $value) {
		$mail->addAttachment($value);         // Add attachments
	}

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->CharSet = 'UTF-8';
	$mail->Subject = $subject;
	$mail->Body = $body;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	if (!$mail->send()) {
		return $mail->ErrorInfo;
	} else {
		return true;
	}

}//end sendmail

function titmail($from, $to, $subject,$body, $files = array(),$time=''){
	//require_once "tit.php";
	$conn = new devAuth("jmex5n");
	if(empty($time)) $time = date('Y-m-d');
	$mailuser = (empty($from['username'])) ? "" : $from['username'];
	$mailpass = (empty($from['password'])) ? "" : $from['password'];
	$sendname = (empty($from['sendname'])) ? "" : $from['sendname'];
	$cc = (empty($from['cc'])) ? "" : $from['cc'];
	$bcc = (empty($from['bcc'])) ? "" : $from['bcc'];
	$host = (empty($from['host'])) ? "" : $from['host'];
	$secure = (empty($from['secure'])) ? "" : $from['secure'];
	$port = (empty($from['port'])) ? "" : $from['port'];
	//$cc = implode(',', $from['cc']);
	//$bcc = implode(',', $from['bcc']);
	$data =[
		"T32ms5x_3pBqIl" => $host,
		"T32ms5x_mnEVFy" => $mailuser,
		"T32ms5x_JZDHBm" => $mailpass,
		"T32ms5x_lHoaWP" => $port,
		"T32ms5x_5caUSv" => $secure,
		"T32ms5x_UYHS5k" => $to,
		"T32ms5x_qHFsVA" => $cc,
		"T32ms5x_FbHLxr" => $bcc,
        "T32ms5x_AG7IZ2" => $sendname,
		"T32ms5x_HyvqJ2" => $subject,
		"T32ms5x_37nUpN" => 3,
		"T32ms5x_ABjklv" => $body,
        "T32ms5x_7JkUiK" => date('Y-m-d H:i:s'),
        "T32ms5x_l8GhXb" => $time
	];
	insertdb($conn,'t32ms5x', $data);
	$id = lastinsertid($conn);
	foreach ($files as  $value) {
		$data1 =[
			"T9ehaji_vK0cVX" => $id,
			"T9ehaji_YhNtpM" => $value
		];
		insertdb($conn,'t9ehaji' , $data1);
	}
}

/***************************************Database Function***************************/

function query($db, $sql)
{
	try {
		$smile = $db->prepare($sql);
		$result = $smile->execute();
		return ($result) ? true : false;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
}


function select_list($db, $sql)
{
	try {
		$smile = $db->prepare($sql);
		$smile->execute();
		$result = $smile->fetchAll();
		/*$returnarr = array();
		foreach ($result as $row) {
			//TODO
		}*/

		return $result;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
}

function select_info($db, $sql)
{
	try {
		$smile = $db->prepare($sql);
		$smile->execute();
		$result = $smile->fetch();
		return $result;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}

}


function getlist($db, $tbname)
{
	$sql = 'select * from ' . $tbname;
	$smile = $db->prepare($sql);
	$smile->execute();
	$result = $smile->fetchAll();
	return $result;
}


function getlist_where($db, $tbname, $rules)
{
	$sql = 'select * from ' . $tbname . ' where ';
	foreach ($rules as $key => $val) {
		$sql .= $key . " = '" . $val . "' AND";
	}
	$sql .= " 0=0";
	$smile = $db->prepare($sql);
	$smile->execute();
	$result = $smile->fetchAll();
	return $result;
}


function lastinsertid($db)
{
	return $db->lastInsertId();
}

function get_total($db, $tbname)
{
	$sql = 'select * from ' . $tbname;
	$smile = $db->prepare($sql);
	$smile->execute();
	$result = $smile->rowCount();
	return $result;
}

function get_total_where($db, $tbname, $rules)
{
	$sql = 'select * from ' . $tbname . ' where ';
	foreach ($rules as $key => $val) {
		$sql .= $key . " = '" . $val . "' AND ";
	}
	$sql .= " 0=0";
	$smile = $db->prepare($sql);
	$smile->execute();
	$result = $smile->rowCount();
	return $result;
}

function get_info($db, $tbname, $rules, $option = '')
{
	$sql = 'select * from ' . $tbname . ' where ';
	foreach ($rules as $key => $val) {
		$sql .= $key . " = '" . $val . "' AND ";
	}
	$sql .= " 0=0 ";
	$sql .= $option;
	$smile = $db->prepare($sql);
	$smile->execute();
	$result = $smile->fetch();
	return $result;
}

function getlistdataman($db, $field)
{
	try {
		$sql = 'select * from dataman where Data_field ="' . $field . '"';
		$smile = $db->prepare($sql);
		$smile->execute();
		$result = $smile->fetchAll();
		return $result;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
}

/*
 *
 * Insert function with viewper and editper by owner
 * Fix error search field
 * Update : 17-07-21
 *
 */
function insertdb($db, $dbname, $data)
{
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$today = date('Y-m-d H:i:s');
	$datetoday = date('Y-m-d');
	$timenow = date('H:i:s');
	$sql = 'insert into ' . $dbname . '(';
	foreach ($data as $key => $val) {
		if ($key != 'owner' AND $key != 'viewper' AND $key != 'editper' AND $key != 'search'):
			$sql .= $key . ",";
		endif;
	}//end foreach;

	$sql .= $dbname . "_owner," . $dbname . "_eld," . $dbname . "_elo," . $dbname . "_crd," . $dbname . "_cro,Viewper,Editper," . $dbname . "_search) ";

	$sql .= "VALUES(";
	foreach ($data as $key => $val) {
		if ($key != 'owner' AND $key != 'viewper' AND $key != 'editper' AND $key != 'search'):
			$sql .= ":" . $key . ",";
		endif;
	}//end foreach;


	$viewper = '';
	$editper = '';
	if (!isset($data['owner'])) {
		$owner = '1';
	} else {
		$owner = $data['owner'];
	}
	if (!isset($data['viewper'])) {
		$viewper = 'and' . $owner . 'and';
	} else {
		foreach ($data['viewper'] as $key => $val) {
			$viewper .= 'and' . $val . 'and';
		}
	}
	if (!isset($data['editper'])) {
		$editper = 'and' . $owner . 'and';
	} else {
		foreach ($data['editper'] as $key => $val) {
			$editper .= 'and' . $val . 'and';
		}
	}

	$search = '';
	if (isset($data['search']))
		$search .= '_' . $data['search'];

	foreach ($data as $key => $val) {
		if ($key != 'owner' AND $key != 'viewper' AND $key != 'editper' AND $key != 'search'):
			$search .= "_" . $val;
		endif;
	}//end foreach;

	$sql .= '"' . $owner . '","' . $today . '",1,"' . $today . '",1,"' . $viewper . '","' . $editper . '",:search)';
	try {
		$smile = $db->prepare($sql);

		foreach ($data as $key => $val) {
			if ($key != 'owner' AND $key != 'viewper' AND $key != 'editper' AND $key != 'search'):
				$smile->bindValue(':' . $key, $val);
			endif;
		}//end foreach;
		$smile->bindValue(':search', $search);
		logrecord($db, $owner, 1, $dbname, $data, $id = 0);
		$result = $smile->execute();
		$newid = $db->lastInsertId();
		return ($result) ? $newid : false;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
} //end insert function;

function normalinsert($db, $dbname, $data)
{
	$sql = 'insert into ' . $dbname . '(';
	foreach ($data as $key => $val) {
		$sql .= $key . ",";
	}//end foreach;
	$sql = rtrim($sql, ',');
	$sql .= ')';
	$sql .= "VALUES(";
	foreach ($data as $key => $val) {
		$sql .= ":" . $key . ",";
	}//end foreach;
	$sql = rtrim($sql, ',');
	$sql .= ')';

	try {
		$smile = $db->prepare($sql);
		foreach ($data as $key => $val) {
			$smile->bindValue(':' . $key, $val);
		}//end foreach;
		$result = $smile->execute();
		$newid = $db->lastInsertId();
		return ($result) ? $newid : false;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
}

function updatedb($db, $tbname, $data)
{
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$today = date('Y-m-d H:i:s');
	$sql = 'UPDATE ' . $tbname . ' SET ';
	foreach ($data['data'] as $key => $val) {
		if ($key != 'owner' AND $key != 'viewper' AND $key != 'editper' AND $key != 'elo'):
			$sql .= $key . ' = :' . $key . ',';
		endif;
	}
	if (isset($data['data']['owner']))
		$sql .= $tbname . '_owner = :' . $tbname . '_owner,';
	if (isset($data['data']['viewper']))
		$sql .= 'Viewper = :' . $tbname . '_viewper,';

	if (isset($data['data']['editper']))
		$sql .= 'Editper = :' . $tbname . '_editper,';

	if (isset($data['data']['elo']))
		$sql .= $tbname . '_elo = :' . $tbname . '_elo,';

	$sql .= $tbname . '_eld = :' . $tbname . '_eld';
	//$sql = rtrim($sql, ",");
	$sql .= ' WHERE 0 = 0';
	foreach ($data['where'] as $key => $val) {
		$sql .= ' AND ' . $key . ' = :' . $key.$tbname;
	}

	$viewper = '';
	$editper = '';
	if (isset($data['data']['owner'])) $owner = $data['data']['owner'];
	if (isset($data['data']['viewper'])) {
		foreach ($data['data']['viewper'] as $key => $val) {
			$viewper .= 'and' . $val . 'and';
		}
	}
	if (isset($data['data']['editper'])) {
		foreach ($data['data']['editper'] as $key => $val) {
			$editper .= 'and' . $val . 'and';
		}
	}
	try {
		$smile = $db->prepare($sql);
		foreach ($data['data'] as $key => $val) {
			if ($key != 'owner' AND $key != 'viewper' AND $key != 'editper' AND $key != 'elo'):
				$smile->bindValue(':' . $key, $val);
			endif;
		}//end foreach;
		foreach ($data['where'] as $key => $val) {
			$smile->bindValue(':' . $key.$tbname, $val);
		}
		if (isset($data['data']['owner']))
			$smile->bindValue(':' . $tbname . '_owner', $owner);
		if (isset($data['data']['viewper']))
			$smile->bindValue(':' . $tbname . '_viewper', $viewper);
		if (isset($data['data']['editper']))
			$smile->bindValue(':' . $tbname . '_editper', $editper);
		if (isset($data['data']['elo']))
			$smile->bindValue(':' . $tbname . '_elo', $data['data']['elo']);
		$smile->bindValue(':' . $tbname . '_eld', $today);
		$result = $smile->execute();
		return ($result) ? true : false;
		//return $sql;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
	//return $sql;
}

function deletedb($db, $tbname, $data)
{
	$sql = 'DELETE from ' . $tbname . ' WHERE ';
	$sql .= ' 0 = 0';
	foreach ($data as $key => $val) {
		$sql .= ' AND ' . $key . ' = "' . $val . '"';
	}
	try {
		$smile = $db->prepare($sql);
		$result = $smile->execute();
		return ($result) ? true : false;
	} catch (Exception $e) {
		die("<h3>Opps,Something went wrong,Contact technical support :</h3>" . $sql . "<h5>Error Log :</h5><i>" . $e . "</i>");
	}
}

function logrecord($db, $user, $action, $tbname, $data, $id = 0)
{
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$today = date('Y-m-d H:i:s');
	if (empty($user)) $user = 0;
	$user = get_info($db, 'user', ['Id' => $user])['Name'];
	$actionname = '';
	$tbname = strtolower($tbname);
	$lognew = $logold = '';
	$idlink = $id;
	if ($action == 1) $actionname = 'Insert';
	if ($action == 2) $actionname = 'Update';
	if ($action == 3) $actionname = 'Delete';
	if ($action == 2 || $action == 3) {
		if ($action == 2) $where = $data['where'];
		if ($action == 3) $where = $data;
		if (!empty($where)):
			$idcol = ucfirst($tbname) . '_id';
			$op = ' ORDER by ' . $idcol . ' DESC limit 0,1';
			$olddata = get_info($db, $tbname, $data, $op);
			$idlink = $olddata[$idcol] + 1;
			foreach ($olddata as $key => $val) {
				if ($key != '')
					$columnname = select_info($db, 'select * from nameform where Nameform_code ="' . $key . '"')['Nameform_vi'];
				$logold .= '&' . $columnname . ':' . $val;
			}
		endif;
	}

	if ($action == 1 || $action == 2) {
		if ($action == 1) $data = $data;
		if ($action == 2) $data = $data['data'];
		foreach ($data as $key => $val) {
			$columnname = select_info($db, 'select * from nameform where Nameform_code ="' . $key . '"')['Nameform_vi'];
			$lognew .= '&' . $columnname . ':' . $val;
		}
		if (!empty($data) AND $action == 1) {
			$idcol = ucfirst($tbname) . '_id';
			$op = ' ORDER by ' . $idcol . ' DESC limit 0,1';
			unset($data['owner']);
			unset($data['viewper']);
			unset($data['editper']);
			unset($data['search']);
			$olddata = get_info($db, $tbname, $data, $op);
			$idlink = $olddata[$idcol] + 1;
		}

	}

	$logmodule = select_info($db, 'select * from modulename where Modulename_links = "' . $tbname . '"')['Modulename_desvi'];
	$loglink = '/' . $tbname . '/edit/' . $idlink;
	$insertdata = array(
		"Log_time" => $today,
		"Log_user" => $user,
		"Log_action" => $actionname,
		"Log_old" => $logold,
		"Log_new" => $lognew,
		"Log_module" => $logmodule,
		"Log_links" => $loglink,
	);
	normalinsert($db, "log", $insertdata);
}

/***************************************Dates Function***************************/

/*
 * getWeekday($datetoday);
 * return weekday name (monday...)
 * */
function getWeekday($date)
{
	return date('l', strtotime($date));
}

/*
 * getNumWeekday($datetoday);
 * return num of weekday name (Sun : 0 - Sat : 6)
 * */
function getNumWeekday($date)
{
	return date('w', strtotime($date));
}

/*
 * getnextday(1,$datetoday);
 * */
function getnextday($num, $date)
{
	return date("Y-m-d", strtotime("+" . $num . " day", strtotime($date)));
}

/*
 * getbackday(1,$datetoday);
 * return back day,para is number of day want to back
 * */
function getbackday($num, $date)
{
	return date("Y-m-d", strtotime("-" . $num . " day", strtotime($date)));
}


/*
 * getdayofnextmonth(1,$datetoday);
 * */
function getdayofnextmonth($num, $date)
{
	return date("Y-m-d", strtotime("+" . $num . " month", strtotime($date)));
}

/*
 * getnextdate("week",1,$datetoday);
 * */
function getnextdate($type, $num, $date)
{
	return date("Y-m-d", strtotime("+" . $num . " " . $type, strtotime($date)));
}

/*
 * countworkday(2017, 2, array(0, 6));
 * */

function countworkday($year, $month, $ignore)
{
	$count = 0;
	$counter = mktime(0, 0, 0, $month, 1, $year);
	while (date("n", $counter) == $month) {
		if (in_array(date("w", $counter), $ignore) == false) {
			$count++;
		}
		$counter = strtotime("+1 day", $counter);
	}
	return $count;
}

/*
 * firstofmonth($datetoday)
 * */
function firstofmonth($date)
{
	return date('Y-m-01', strtotime($date));
}

/*
 * lastofmonth($datetoday)
 * */
function lastofmonth($date)
{
	return date('Y-m-t', strtotime($date));
}

function getweekdayinrange($start, $end, $wd)
{
	$start_date = strtotime($start);
	$last_date = strtotime($end);
	while ($start_date <= $last_date) {

		if (date('N', $start_date) == $wd) {
			return date('Y-m-d', $start_date) . PHP_EOL;
		}
		$start_date = strtotime('+1 day', $start_date);
	}
}

function getdaybyweekday($start, $end, $wd)
{
	$start_date = strtotime($start);
	$last_date = strtotime($end);
	$result = array();
	while ($start_date <= $last_date) {

		if (date('N', $start_date) == $wd) {
			$date = date('Y-m-d', $start_date) . PHP_EOL;
			array_push($result, $date);
		}
		$start_date = strtotime('+1 day', $start_date);
	}

	return $result;
}

function caldate($date1, $date2, $op)
{
	if ($op == "+")
		$diff = abs(strtotime($date2) + strtotime($date1));
    elseif ($op == "-")
		$diff = abs(strtotime($date2) - strtotime($date1));

	$years = floor($diff / (365 * 60 * 60 * 24));
	$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
	$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
	$hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
	$minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
	$seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

	$result = array(
		"years" => $years,
		"months" => $months,
		"days" => $days,
		"hours" => $hours,
		"minutes" => $minutes,
		"seconds" => $seconds
	);
	return $result;
}

function calday($date1, $date2)
{
	return (strtotime($date2) - strtotime($date1)) / (24 * 3600);
}

function titdate($date)
{
	$checkdate = explode(' ', $date);
	if (count($checkdate) > 1)
		$result = date('d/m/Y H:i:s');
	else
		$result = date('d/m/Y');

}

function titdatei($date)
{
	$checkdate = explode(' ', $date);
	if (count($checkdate) > 1)
		$result = date('Y-m-d H:i:s');
	else
		$result = date('Y-m-d');

}

/**********************************Other functions**************************/

function number2word($number)
{

	$hyphen = ' ';
	$conjunction = ' ';
	$separator = ', ';
	$negative = ' âm ';
	$decimal = ' chấm ';
	$dictionary = array(
		0 => 'không',
		1 => 'một',
		2 => 'hai',
		3 => 'ba',
		4 => 'bốn',
		5 => 'năm',
		6 => 'sáu',
		7 => 'bẩy',
		8 => 'tám',
		9 => 'chín',
		10 => 'mười',
		11 => 'mười một',
		12 => 'mười hai',
		13 => 'mười ba',
		14 => 'mười bốn',
		15 => 'mười lăm',
		16 => 'mười sáu',
		17 => 'mười bẩy',
		18 => 'mười tám',
		19 => 'mười chín',
		20 => 'hai mươi',
		30 => 'ba mươi',
		40 => 'bốn mươi',
		50 => 'năm mươi',
		60 => 'sáu mươi',
		70 => 'bẩy mươi',
		80 => 'tám mươi',
		90 => 'chín mươi',
		100 => 'trăm',
		1000 => 'nghìn',
		1000000 => 'triệu',
		1000000000 => 'tỷ',
		1000000000000 => 'nghìn tỷ',
		1000000000000000 => 'triệu tỷ',
		1000000000000000000 => 'tỷ tỷ'
	);

	if (!is_numeric($number)) {
		return false;
	}

	if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
		// overflow
		trigger_error(
			'convert number to words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
			E_USER_WARNING
		);
		return false;
	}

	if ($number < 0) {
		return $negative . number2word(abs($number));
	}

	$string = $fraction = null;

	if (strpos($number, '.') !== false) {
		list($number, $fraction) = explode('.', $number);
	}

	switch (true) {
		case $number < 21:
			$string = $dictionary[$number];
			break;
		case $number < 100:
			$tens = ((int)($number / 10)) * 10;
			$units = $number % 10;
			$string = $dictionary[$tens];
			if ($units) {
				$string .= $hyphen . $dictionary[$units];
			}
			break;
		case $number < 1000:
			$hundreds = $number / 100;
			$remainder = $number % 100;
			$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
			if ($remainder) {
				$string .= $conjunction . number2word($remainder);
			}
			break;
		default:
			$baseUnit = pow(1000, floor(log($number, 1000)));
			$numBaseUnits = (int)($number / $baseUnit);
			$remainder = $number % $baseUnit;
			$string = number2word($numBaseUnits) . ' ' . $dictionary[$baseUnit];
			if ($remainder) {
				$string .= $remainder < 100 ? $conjunction : $separator;
				$string .= number2word($remainder);
			}
			break;
	}

	if (null !== $fraction && is_numeric($fraction)) {
		$string .= $decimal;
		$words = array();
		foreach (str_split((string)$fraction) as $number) {
			$words[] = $dictionary[$number];
		}
		$string .= implode(' ', $words);
	}

	return $string;
}


function formatnumber($number, $precision = 2, $separator = ',')
{
	$numberParts = explode($separator, $number);
	$response = $numberParts[0];
	if (count($numberParts) > 1) {
		$response .= $separator;
		$response .= substr($numberParts[1], 0, $precision);
	}
	return $response;
}

function formatnumber1($num)
{
	return floor($num * 100) / 100;
}


function vn_to_str($str)
{

	$unicode = array(

		'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

		'd' => 'đ',

		'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

		'i' => 'í|ì|ỉ|ĩ|ị',

		'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

		'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

		'y' => 'ý|ỳ|ỷ|ỹ|ỵ',

		'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

		'D' => 'Đ',

		'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

		'I' => 'Í|Ì|Ỉ|Ĩ|Ị',

		'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

		'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

		'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',

	);

	foreach ($unicode as $nonUnicode => $uni) {

		$str = preg_replace("/($uni)/i", $nonUnicode, $str);

	}
//$str = str_replace(' ','_',$str);

	return $str;

}


function exportexcel($titlearr, $data)
{

	require('PHPExcel.php');
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");


	foreach ($titlearr as $col => $val) {
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($col, $val);
	}


	$i = 2;
	foreach ($data as $item) {
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue($item['col'] . $i, $item['val']);
		$i++;
	}

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="barcode.xlsx"');
	header('Cache-Control: max-age=0');

	return $objWriter->save('php://output');

}

function arrayDiff($aArray1, $aArray2)
{
	$aReturn = array();

	foreach ($aArray1 as $mKey => $mValue) {
		if (array_key_exists($mKey, $aArray2)) {
			if (is_array($mValue)) {
				$aRecursiveDiff = arrayDiff($mValue, $aArray2[$mKey]);
				if (count($aRecursiveDiff)) {
					$aReturn[$mKey] = $aRecursiveDiff;
				}
			} else {
				if ($mValue != $aArray2[$mKey]) {
					$aReturn[$mKey] = $mValue;
				}
			}
		} else {
			$aReturn[$mKey] = $mValue;
		}
	}
	return $aReturn;
}

function selectbox($conn, $code, $mt, $l)
{
	$field = select_info($conn, 'Select * FROM nameform WHERE Nameform_code="' . $code . '"');

	if ($field['Nameform_formtype'] == 'parent') {
		$data = select_list($conn, 'SELECT * FROM ' . $field['Nameform_pmodule']);
		?>
        <div class="col-lg-<?= $l; ?>"><label><?= $field['Nameform_vi']; ?></label>
            <div class="form-group input-group-sm">
                <select name="<?php echo $field['Nameform_code'];
				if ($mt == 'yes') {
					echo '[]';
				} ?>" id="id_<?= $field['Nameform_code']; ?>"
                        class="form-control chosen-select" <?php if ($mt == 'yes') {
					echo 'multiple="multiple"';
				} ?>>
                    <option value="">---</option>
					<?php foreach ($data as $value) { ?>
                        <option value="<?= $value[$field['Nameform_pfieldid']] ?>"><?= $value[$field['Nameform_pfieldshow']] ?></option>
					<?php } ?>
                </select>
            </div>
        </div>
	<?php } ?>
	<?php
	if ($field['Nameform_formtype'] == 'chose') {
		$data = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $field['Nameform_code'] . '"');
		?>
        <div class="col-lg-<?= $l; ?>"><label><?= $field['Nameform_vi']; ?></label>
            <div class="form-group input-group-sm">
                <select name="<?php echo $field['Nameform_code'];
				if ($mt == 'yes') {
					echo '[]';
				} ?>" id="id_<?= $field['Nameform_code']; ?>"
                        class="form-control chosen-select" <?php if ($mt == 'yes') {
					echo 'multiple="multiple"';
				} ?>>
                    <option value="">---</option>
					<?php foreach ($data as $value) { ?>
                        <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
					<?php } ?>
                </select>
            </div>
        </div>
	<?php }
}


function selectbox3($conn, $code, $option, $l, $mt = '', $id = '')
{
	$field = select_info($conn, 'Select * FROM nameform WHERE Nameform_code="' . $code . '"');

	if ($field['Nameform_formtype'] == 'parent') {
		$data = select_list($conn, 'SELECT * FROM ' . $field['Nameform_pmodule']);
		if (empty($id)) $id = $field['Nameform_code'];
		?>
        <label><?= $field['Nameform_vi']; ?></label>

        <select name="<?php echo $id ?>" id="<?= $id ?>"
                class="form-control" <?php echo $option ?>>
            <option value="">---</option>
			<?php foreach ($data as $value) { ?>
                <option value="<?= $value[$field['Nameform_pfieldid']] ?>"><?= $value[$field['Nameform_pfieldshow']] ?></option>
			<?php } ?>
        </select>

	<?php } ?>
	<?php
	if ($field['Nameform_formtype'] == 'chose') {
		$data = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $field['Nameform_code'] . '"');
		?>
        <label><?= $field['Nameform_vi']; ?></label>
        <select name="<?php echo $id;
		if ($mt == 'yes') {
			echo '[]';
		} ?>" id="<?= $id ?>"
                class="form-control" <?php if ($mt == 'yes') {
			echo 'multiple="multiple"';
		} ?>>
            <option value="0">---</option>
			<?php foreach ($data as $value) { ?>
                <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
			<?php } ?>
        </select>

	<?php }
}

function selectbox2($conn, $code, $option = '', $l, $id = '', $mt = '', $show = '')
{
	$field = select_info($conn, 'Select * FROM nameform WHERE Nameform_code="' . $code . '"');
	if (empty($id)) $idc = $field['Nameform_code'];
	else $idc = $id;
	if ($field['Nameform_formtype'] == 'parent') {
		$data = select_list($conn, 'SELECT * FROM ' . $field['Nameform_pmodule']);
		?>
        <div class="col-lg-<?= $l; ?>"><label><?php if (!empty($show)) {
					echo $show;
				} else {
					echo $field['Nameform_vi'];
				} ?></label>
            <div class="form-group input-group-sm">
                <select name="<?php echo $idc;
				if ($mt == 'yes') {
					echo '[]';
				} ?>" id="<?= $idc ?>"
                        class="form-control chosen-select" <?php if ($mt == 'yes') {
					echo 'multiple="multiple"';
				} ?> <?php echo $option ?>>
                    <option value="">---</option>
					<?php foreach ($data as $value) { ?>
                        <option value="<?= $value[$field['Nameform_pfieldid']] ?>"><?= $value[$field['Nameform_pfieldshow']] ?></option>
					<?php } ?>
                </select>
            </div>
        </div>
	<?php } ?>
	<?php
	if ($field['Nameform_formtype'] == 'chose') {
		$data = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $field['Nameform_code'] . '"');
		?>
        <div class="col-lg-<?= $l; ?>"><label><?php if (!empty($show)) {
					echo $show;
				} else {
					echo $field['Nameform_vi'];
				} ?></label>
            <div class="form-group input-group-sm">
                <select name="<?= $idc ?>" id="<?= $idc ?>"
                        class="form-control chosen-select">
                    <option value="0">---</option>
					<?php foreach ($data as $value) { ?>
                        <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
					<?php } ?>
                </select>
            </div>
        </div>
	<?php }
}

function selectbox5($conn, $code, $option, $l, $label = '',$id='')
{
	$field = select_info($conn, 'Select * FROM nameform WHERE Nameform_code="' . $code . '"');

	if ($field['Nameform_formtype'] == 'parent') {
		$data = select_list($conn, 'SELECT * FROM ' . $field['Nameform_pmodule']);
		if (empty($label)) $label = $field['Nameform_vi'];
		?>
        <div class="col-sm-<?= $l ?>" style="height:85px">
            <div class="form-group input-group-sm">
                <label><?= $label ?></label>
                <select name="<?php echo $field['Nameform_code'].$id; ?>" id="<?= $field['Nameform_code'].$id; ?>"
                        class="form-control chosen-select" <?php echo $option ?>>
                    <option value="">---</option>
					<?php foreach ($data as $value) { ?>
                        <option value="<?= $value[$field['Nameform_pfieldid']] ?>"><?= $value[$field['Nameform_pfieldshow']] ?></option>
					<?php } ?>
                </select>

            </div>
        </div>
	<?php } ?>
	<?php
	if ($field['Nameform_formtype'] == 'chose') {
		$data = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $field['Nameform_code'] . '"');
		?>
        <div class="col-sm-<?= $l ?>">
            <div class="form-group input-group-sm" style="height:85px">
                <label><?= $field['Nameform_vi']; ?></label>
                <select name="<?= $field['Nameform_code']; ?>"
                        id="<?= $field['Nameform_code']; ?>"
                        class="form-control chosen-select" <?php echo $option ?> >
                    <option value="0">---</option>
					<?php foreach ($data as $value) { ?>
                        <option value="<?= $value['Id'] ?>"><?= $value['Value'] ?></option>
					<?php } ?>
                </select>
            </div>
        </div>

	<?php }
}


//Hansontable
function drawtablejs2($conn, $module, $title, $idtabel, $column)
{
	?>
	<?php


	$sql = "Select * from nameform where Nameform_module = '" . $module . "'";
	$nameform = select_list($conn, $sql);

	$nameformarry = array();
	foreach ($nameform as $value) {
		$nameformarry[$value['Nameform_code']]['code'] = $value['Nameform_code'];
		$nameformarry[$value['Nameform_code']]['vi'] = $value['Nameform_vi'];
		$nameformarry[$value['Nameform_code']]['type'] = $value['Nameform_formtype'];
		$nameformarry[$value['Nameform_code']]['pmodule'] = $value['Nameform_pmodule'];
		$nameformarry[$value['Nameform_code']]['pmoduleshow'] = $value['Nameform_pfieldshow'];


	}

	?>


    <script src="/handsontable/dist/handsontable.full.js"></script>
    <link rel="stylesheet" media="screen" href="/handsontable/dist/handsontable.full.css">
    <link rel="stylesheet" media="screen" href="/handsontable/plugins/bootstrap/handsontable.bootstrap.css">
    <script src="/js/makealert.js" type="text/javascript"></script>
    <script src="/handsontable/lib/handsontable-chosen-editor.js"></script>
    <script>
        var $$ = function (id) {
            return document.getElementById(id);
        }
        var container = $$('<?php echo $idtabel; ?>show');
        var <?php echo $idtabel; ?>=
        new Handsontable(container, {
            minSpareRows: 1,
            rowHeaders: true,
            stretchH: "all",
            colHeaders: [<?php foreach ($column as $value) { ?>"<?php echo $nameformarry[$value]['vi']; ?>",<?php } ?>],
            contextMenu: true,
            columns: [
				<?php foreach ($column as $value) { ?>
				<?php if ($nameformarry[$value]['type'] == 'text' or $nameformarry[$value]['type'] == 'textarea') { ?>
                {type: 'text'},
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'date') { ?>
                {type: 'date'},
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'money') { ?>
                {type: 'numeric', format: '0,0'},
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'chose') { ?>
				<?php
				$data = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $nameformarry[$value]['code'] . '"');
				?>
                {
                    type: 'autocomplete',
                    source: [
						<?php foreach ($data as $value1) { ?>
                        "<?php echo $value1['Value']; ?>",
						<?php } ?>
                    ],
                    strict: true,
                    allowInvalid: false
                },
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'parent') { ?>
				<?php
				$data = select_list($conn, 'SELECT * FROM ' . $nameformarry[$value]['pmodule']);
				?>
                {
                    type: 'autocomplete',
                    source: [
						<?php foreach ($data as $value1) { ?>
                        "<?php echo $value1[$nameformarry[$value]['pmoduleshow']]; ?>",
						<?php } ?>
                    ],
                    strict: true,
                    allowInvalid: true
                },
				<?php } ?>
				<?php } ?>

            ]
        });
    </script>
	<?php
}

//Để insert cho hansontable
function insertjson($conn, $module, $column, $defaultv)
{

	if (isset($_POST[$module])) {

		$sql = "Select * from nameform where Nameform_module = '" . $module . "'";
		$nameform = select_list($conn, $sql);

		$nameformarry = array();
		foreach ($nameform as $value) {
			$nameformarry[$value['Nameform_code']]['code'] = $value['Nameform_code'];
			$nameformarry[$value['Nameform_code']]['vi'] = $value['Nameform_vi'];
			$nameformarry[$value['Nameform_code']]['type'] = $value['Nameform_formtype'];
			$nameformarry[$value['Nameform_code']]['pmodule'] = $value['Nameform_pmodule'];
			$nameformarry[$value['Nameform_code']]['pmoduleshow'] = $value['Nameform_pfieldshow'];
			if ($value['Nameform_formtype'] == 'chose') {
				$datachose = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $value['Nameform_code'] . '"');
				foreach ($datachose as $value1) {
					$arraydata[$value['Nameform_code']][$value1['Value']] = $value1['Id'];
				}

			}

			if ($value['Nameform_formtype'] == 'parent') {
				$datachose = select_list($conn, 'SELECT * FROM ' . $value['Nameform_pmodule'] . '');
				foreach ($datachose as $value1) {
					$arraydata[$value['Nameform_code']][$value1[$value['Nameform_pfieldshow']]] = $value1[$value['Nameform_pfieldid']];
				}

			}

		}

		$totaldata = json_decode($_POST[$module], true);


		foreach ($totaldata as $value) {
			$value = array_filter($value);
			if (!empty($value)) {
				$datainsert = array();
				$count = 0;
				foreach ($column as $value1) {
					if ($nameformarry[$value1]['type'] == 'chose' or $nameformarry[$value1]['type'] == 'parent') {
						$datainsert[$value1] = $arraydata[$value1][$value[$count]];
					}
					if ($nameformarry[$value1]['type'] == 'text' or $nameformarry[$value1]['type'] == 'textarea') {
						$datainsert[$value1] = $value[$count];
					}
					if ($nameformarry[$value1]['type'] == 'money') {
						$datainsert[$value1] = str_replace(",", "", $value[$count]);
					}
					if ($nameformarry[$value1]['type'] == 'date') {
						$datainsert[$value1] = str_replace("/", "-", $value[$count]);
						if ($datainsert[$value1] != null) {
							$datainsert[$value1] = date('Y-m-d', strtotime($datainsert[$value1]));
						} else {
							$datainsert[$value1] = null;
						}

					}
					foreach ($defaultv as $val3) {
						$datainsert[$val3['code']] = $val3['value'];


					}


					$count++;
				}
				$m = strtolower($module);
				insertdb($conn, $m, $datainsert);
			}
		}


	}


}


//Để insert cho hansontable
function insertjsonan($conn, $module, $column, $defaultv)
{

	if (isset($_POST[$module])) {

		$sql = "Select * from nameform where Nameform_module = '" . $module . "'";
		$nameform = select_list($conn, $sql);

		$nameformarry = array();
		foreach ($nameform as $value) {
			$nameformarry[$value['Nameform_code']]['code'] = $value['Nameform_code'];
			$nameformarry[$value['Nameform_code']]['vi'] = $value['Nameform_vi'];
			$nameformarry[$value['Nameform_code']]['type'] = $value['Nameform_formtype'];
			$nameformarry[$value['Nameform_code']]['pmodule'] = $value['Nameform_pmodule'];
			$nameformarry[$value['Nameform_code']]['pmoduleshow'] = $value['Nameform_pfieldshow'];
			if ($value['Nameform_formtype'] == 'chose') {
				$datachose = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $value['Nameform_code'] . '"');
				foreach ($datachose as $value1) {
					$arraydata[$value['Nameform_code']][$value1['Value']] = $value1['Id'];
				}

			}

			if ($value['Nameform_formtype'] == 'parent') {
				$datachose = select_list($conn, 'SELECT * FROM ' . $value['Nameform_pmodule'] . '');
				foreach ($datachose as $value1) {
					$arraydata[$value['Nameform_code']][$value1[$value['Nameform_pfieldshow']]] = $value1[$value['Nameform_pfieldid']];
				}

			}

		}

		$totaldata = json_decode($_POST[$module], true);


		foreach ($totaldata as $value) {
			$value = array_filter($value);
			if (!empty($value)) {
				$datainsert = array();
				$count = 0;
				foreach ($column as $value1) {
					if ($nameformarry[$value1]['type'] == 'chose' or $nameformarry[$value1]['type'] == 'parent') {
						if (isset($arraydata[$value1][$value[$count]])) {
							$datainsert[$value1] = $arraydata[$value1][$value[$count]];
						} else {

							if ($nameformarry[$value1]['type'] == 'chose') {
								$sql = 'INSET INTO dataman (Data_field,Value,Default) VALUES ("' . $value1 . '","' . $value[$count] . '",2)';
								query($conn, $sql);
								$datainsert[$value1] = lastinsertid($conn);

							}
							if ($nameformarry[$value1]['type'] == 'parent') {
								$data9 = array($nameformarry[$value1]['pmoduleshow'] => $value[$count]);
								insertdb($conn, $nameformarry[$value1]['pmodule'], $data9);
								$datainsert[$value1] = lastinsertid($conn);

							}

						}


					}
					if ($nameformarry[$value1]['type'] == 'text' or $nameformarry[$value1]['type'] == 'textarea') {
						$datainsert[$value1] = $value[$count];
					}
					if ($nameformarry[$value1]['type'] == 'money') {
						$datainsert[$value1] = str_replace(",", "", $value[$count]);
					}
					if ($nameformarry[$value1]['type'] == 'date') {
						$datainsert[$value1] = str_replace("/", "-", $value[$count]);
						if ($datainsert[$value1] != null) {
							$datainsert[$value1] = date('Y-m-d', strtotime($datainsert[$value1]));
						} else {
							$datainsert[$value1] = null;
						}

					}
					foreach ($defaultv as $val3) {
						$datainsert[$val3['code']] = $val3['value'];


					}


					$count++;
				}
				$m = strtolower($module);
				insertdb($conn, $m, $datainsert);
			}
		}


	}


}

//Vẽ bảng datatable
function ntable($conn, $data, $title, $col, $datas, $id, $idb, $rep)
{
	?>


    <div class="box box-primary" style="border-radius: 0px">
        <div class="box-header with-border" style="padding: 5px">
            <i class="fa fa-list"></i>
            <h3 class="box-title"><strong><?php echo $title; ?></strong></h3>
        </div><!-- /.box-header -->

        <div class="box-body" style="padding: 0px">

            <div class="row">
                <div class="col-lg-12">

                    <div class="tab-pane fade active in" id="cvdalam">
                        <script type="text/javascript" src="datatables/jquery.dataTables.min.js"></script>
                        <script type="text/javascript" src="datatables/dataTables.bootstrap.min.js"></script>
                        <script type="text/javascript" src="datatables/dataTables.buttons.min.js"></script>
                        <script type="text/javascript" src="datatables/buttons.bootstrap.min.js"></script>
                        <script type="text/javascript" src="datatables/jszip.min.js"></script>
                        <script type="text/javascript" src="datatables/pdfmake.min.js"></script>
                        <script type="text/javascript" src="datatables/vfs_fonts.js"></script>
                        <script type="text/javascript" src="datatables/buttons.print.min.js"></script>
                        <script type="text/javascript" src="datatables/buttons.html5.min.js"></script>

                        <link rel="stylesheet" type="text/css" href="datatables/dataTables.bootstrap.min.css">
                        <link rel="stylesheet" type="text/css" href="datatables/buttons.bootstrap.min.css">
                        <table id="<?php echo $idb; ?>"
                               class="table table-bordered table-striped table-hover text-center">
                            <thead>
                            <tr>
								<?php foreach ($col as $value) { ?>
                                    <th><?php echo $value['show']; ?></th>
								<?php } ?>
                            </tr>
                            </thead>
                            <tbody>
							<?php foreach ($data as $value) { ?>
                                <tr>

									<?php foreach ($datas as $value1) { ?>

										<?php if ($value1['type'] == 'text') { ?>
                                            <td><?php echo $value[$value1['show']]; ?></td> <?php } ?>
										<?php if ($value1['type'] == 'action') { ?>
                                            <td>
												<?php

												$gt = str_replace("@" . $id . "@", $value[$id], $value1['show']);
												if ($rep != null) {
													foreach ($rep as $va1) {
														$gt = str_replace("@" . $va1 . "@", $value[$va1], $gt);

													}
												}

												echo $gt; ?></td> <?php } ?>
									<?php } ?>

                                </tr>
							<?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <script>
                        $(function () {
                            $('#<?php echo $idb; ?>').DataTable({
                                dom: 'Bfrtip',
                                buttons: ['copy', 'csv', 'pdf', 'print', {
                                    extend: 'excel',
                                    text: 'Export To Excel'
                                }],
                                "language": {
                                    "info": "",
                                    "paginate": {
                                        "first": "Trang đầu",
                                        "last": "Trang cuối",
                                        "next": "Trang tiếp",
                                        "previous": "Trang trước"
                                    },
                                }

                            });
                        });
                    </script>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
	<?php
}

//Thực thi câu lệnh sql dựa trên $_GET
function updatebget($conn, $sql, $var)
{
	foreach ($var as $val) {
		$sql = str_replace("@" . $val . "@", $_GET[$val], $sql);

	}
	query($conn, $sql);
}

///Thực thi câu lệnh sql dựa trên $_GET $_POST
function updatebgetpost($conn, $sql, $varg, $varp)
{
	foreach ($varg as $val) {
		$sql = str_replace("@" . $val . "@", $_GET[$val], $sql);

	}
	foreach ($varp as $val) {
		$sql = str_replace("@" . $val . "@", $_POST[$val], $sql);

	}
	query($conn, $sql);
}

///Thực thi nhiều câu lệnh sql dựa trên $_GET $_POST
function updatebgetpostml($conn, $sqlarr, $varg, $varp)
{
	foreach ($sqlarr as $sql) {
		foreach ($varg as $val) {
			$sql = str_replace("@" . $val . "@", $_GET[$val], $sql);

		}
		foreach ($varp as $val) {
			$sql = str_replace("@" . $val . "@", $_POST[$val], $sql);

		}
		query($conn, $sql);


	}
}

///Selectbox với thêm mới
function selectpwa($conn, $code, $title, $option = '', $l = 12, $id = '')
{

	$field = select_info($conn, 'Select * FROM nameform WHERE Nameform_code="' . $code . '"');
	$dcode = 'dataaddnewe' . $code;
	if ($field['Nameform_formtype'] == 'parent') {

		if (isset($_GET[$dcode])) {
			$data = json_decode($_GET[$dcode], true);

			insertdb($conn, $field['Nameform_pmodule'], $data);

			$b = lastinsertid($conn);
			$a = select_info($conn, 'SELECT * FROM ' . $field['Nameform_pmodule'] . ' WHERE ' . $field['Nameform_pfieldid'] . ' = ' . $b);
			echo $dcode . json_encode($a) . $dcode;
			exit;
		}

		$data = select_list($conn, 'SELECT * FROM ' . $field['Nameform_pmodule']);

		if (empty($id)) $idc = $field['Nameform_code'];
		else $idc = $id;
		?>

        <div class="col-sm-<?= $l ?>" style="height:85px">
            <div class="form-group input-group-sm">

                <label><?= $field['Nameform_vi']; ?><a data-toggle="modal" data-target="#<?php echo $code . 'add'; ?>">
                        <i class="fa  fa-plus"></i></i>
                    </a></label>
                <select <?php echo $option; ?> name="<?= $idc ?>"
                                               id="<?= $idc ?>"
                                               class="form-control chosen-select" <?php echo $option ?>>
                    <option value="">---</option>
					<?php foreach ($data as $value) { ?>
                        <option value="<?= $value[$field['Nameform_pfieldid']] ?>"><?= $value[$field['Nameform_pfieldshow']] ?></option>
					<?php } ?>
                </select>
            </div>
        </div>

        <div class="modal fade" id="<?php echo $code . 'add'; ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo $title; ?></h4>
                    </div>
                    <div class="modal-body">


						<?php $fieldp = select_list($conn, 'Select * FROM nameform WHERE  Nameform_module="' . $field['Nameform_pmodulename'] . '"'); ?>
						<?php foreach ($fieldp as $va1) { ?>


							<?php if ($va1['Nameform_formtype'] == 'text' or $va1['Nameform_formtype'] == 'money') { ?>
                                <div class="form-group">
                                    <label for="recipient-name"
                                           class="control-label"><?php echo $va1['Nameform_vi']; ?></label>
                                    <input type="text" class="form-control"
                                           id="<?php echo $code . $va1['Nameform_code']; ?>">
                                </div>
							<?php } ?>
							<?php if ($va1['Nameform_formtype'] == 'date') { ?>
                                <div class="form-group">
                                    <label for="recipient-name"
                                           class="control-label"><?php echo $va1['Nameform_vi']; ?></label>
                                    <input type="date" class="form-control"
                                           id="<?php echo $code . $va1['Nameform_code']; ?>">
                                </div>
							<?php } ?>
							<?php if ($va1['Nameform_formtype'] == 'textarea') { ?>
                                <div class="form-group">
                                    <label for="recipient-name"
                                           class="control-label"><?php echo $va1['Nameform_vi']; ?></label>
                                    <textarea class="form-control"
                                              id="<?php echo $code . $va1['Nameform_code']; ?>">   </textarea>
                                </div>
							<?php } ?>
							<?php if ($va1['Nameform_formtype'] == 'chose' or $va1['Nameform_formtype'] == 'parent') { ?>
                                <div class="form-group">
									<?php selectbox3($conn, $va1['Nameform_code'], null, '3', '', $code . $va1['Nameform_code']); ?>
                                </div>
							<?php } ?>


						<?php } ?>


                    </div>
                    <div class="modal-footer">
                        <button type="button" id="<?= $code ?>btnsubmit" onclick="<?php echo $code . 'addf'; ?>()" class="btn btn-primary">Thêm
                        </button>
                        <script>


                            function <?php echo $code . 'addf'; ?>() {
                                $('#<?php echo $code . 'add'; ?>').modal('hide');


                                var formData = {
								<?php foreach ($fieldp as $va1){ if ($va1['Nameform_formtype'] == 'text' or $va1['Nameform_formtype'] == 'textarea'
							or $va1['Nameform_formtype'] == 'date'
							or $va1['Nameform_formtype'] == 'chose'
							or $va1['Nameform_formtype'] == 'parent'
							or $va1['Nameform_formtype'] == 'money'

								) {?>
								<?php echo $va1['Nameform_code']; ?>:
                                document.getElementById("<?php echo $code . $va1['Nameform_code']; ?>").value,
								<?php }} ?>
                            }
                                ;
                                var data1 = JSON.stringify(formData);


                                $.ajax({
                                    type: 'get',
                                    url: '#',
                                    data: '<?php echo $dcode;  ?>=' + data1,
                                    /*                    async: false,
                                     cache: false,
                                     contentType: false,
                                     processData: false,*/
                                    success: function (data) {

                                        var obj2 = data.split("<?php echo $dcode;  ?>");

                                        var obj = JSON.parse(obj2[1]);
                                        $('#<?= $idc ?>').append($('<option>', {
                                            value: obj["<?php echo $field['Nameform_pfieldid']; ?>"],
                                            text: obj["<?php echo $field['Nameform_pfieldshow']; ?>"]
                                        }));
                                        $('#<?= $idc ?>').val(obj["<?php echo $field['Nameform_pfieldid']; ?>"]).trigger('chosen:updated');
										<?php foreach ($fieldp as $va1){ if ($va1['Nameform_formtype'] == 'text' or $va1['Nameform_formtype'] == 'textarea'
									or $va1['Nameform_formtype'] == 'date'
									or $va1['Nameform_formtype'] == 'chose'
									or $va1['Nameform_formtype'] == 'parent'

										) {?>
                                        document.getElementById("<?php echo $code . $va1['Nameform_code']; ?>").value = null;
										<?php }} ?>
                                    }
                                }); //End Ajax


                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>


	<?php } ?>


<?php }

//Lấy danh sách file
function getlistfile($code, $module, $Id, $f)
{

	$links = dirname(dirname(dirname(dirname(dirname(dirname(dirname($f))))))) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $code . DIRECTORY_SEPARATOR . 'uploads';
	$foldername = $module . $Id;
	$links_dir = realpath($links) .
		DIRECTORY_SEPARATOR .
		$foldername;


	$files = array();
	if (!is_dir($links_dir)) {
		//	mkdir($links_dir, 0777);
	} else {

		if (is_dir($links_dir)) {
			$handle = opendir($links_dir);
			if ($handle) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$files[] = $entry;
					}
				}
				closedir($handle);
			}
		}
	}
	$data = null;
	$i = 0;
	foreach ($files as $va) {
		$data[$i] = '/com/download/' . $Id . '/' . $module . '/' . strtolower($module) . '/?file=' . $va;
		$i++;
	}
	return $data;

}

//Lấy danh sách file ngoài module
function getlistfileoutside($code, $module, $Id, $f,$link = '',$debug=0)
{
    if(empty($link))
	$links = dirname(dirname(dirname($f))) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $code . DIRECTORY_SEPARATOR . 'uploads';
    else
      $links = $link;
	$foldername = ucfirst($module) . $Id;
	$links_dir = realpath($links) .
		DIRECTORY_SEPARATOR .
		$foldername;


	$files = array();
	if (!is_dir($links_dir)) {
		// mkdir($links_dir, 0777);
	} else {

		if (is_dir($links_dir)) {
			$handle = opendir($links_dir);
			if ($handle) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$files[] = $entry;
					}
				}
				closedir($handle);
			}
		}
	}

    if($debug == 1) return $links_dir;
	else return $files;
}

//Form upload file
function uploadfile($code, $module, $Id, $name, $f)
{


	$links = dirname(dirname(dirname(dirname(dirname(dirname(dirname($f))))))) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $code . DIRECTORY_SEPARATOR . 'uploads';
	$foldername = ucfirst($module) . $Id;
	$links_dir = realpath($links) .
		DIRECTORY_SEPARATOR .
		$foldername;

	$files = array();
	if (!is_dir($links_dir)) {
		mkdir($links_dir, 0777,true);
	}
	$count = 0;

	if (isset($_FILES[$name]['name'])) {
		foreach ($_FILES[$name]['name'] as $file) {
			if (


				strpos($file, 'html') === false and strpos($file, 'java') === false and
				strpos($file, 'rpm') === false and strpos($file, 'exe') === false and strpos($file, 'php') === false
				and $_FILES[$name]['size'][$count] < 10000000


			) {
				$a = rename($_FILES[$name]['tmp_name'][$count], $links_dir . DIRECTORY_SEPARATOR . $file);
				$count++;
			}

		}

	}
	return $links_dir;

}

//Insert data theo module trả về mảng insert lookup giá trị option
function makedatal($conn, $module, $datain)
{
	$dataout = array();
	$field = select_list($conn, 'SELECT * FROM nameform WHERE Nameform_module = "' . $module . '"');

	foreach ($field as $value) {
		if (isset($datain[$value['Nameform_code']])) {
			if ($value['Nameform_formtype'] == 'chose') {
				$lookup = select_info($conn, 'SELECT * FROM dataman WHERE  data_field = "' . $value['Nameform_code'] . '" AND Value = "' . $datain[$value['Nameform_code']] . '"');
				$dataout[$value['Nameform_code']] = $lookup['Id'];
			}

			if ($value['Nameform_formtype'] == 'parent') {
				$lookup = select_info($conn, 'SELECT * FROM ' . $value['Nameform_pmodule'] . ' WHERE  ' . $value['Nameform_pfieldshow'] . ' = "' . $datain[$value['Nameform_code']] . '"');
				$dataout[$value['Nameform_code']] = $lookup[$value['Nameform_pfieldid']];
			}

			if ($value['Nameform_formtype'] != 'chose' and $value['Nameform_formtype'] != 'parent') {
				$dataout[$value['Nameform_code']] = $datain[$value['Nameform_code']];

			}
			if ($value['Nameform_formtype'] == 'money') {
				$dataout[$value['Nameform_code']] = str_replace(",", "", $datain[$value['Nameform_code']]);

			}


		}

	}
	return $dataout;
}

//Tạo array dữ liệu đầu ra từ array dữ liệu đầu vào
function makedatanl($conn, $module, $datain)
{
	$dataout = array();
	$field = select_list($conn, 'SELECT * FROM nameform WHERE Nameform_module = "' . $module . '"');

	foreach ($field as $value) {
		if (isset($datain[$value['Nameform_code']])) {
			$dataout[$value['Nameform_code']] = $datain[$value['Nameform_code']];
			if ($value['Nameform_formtype'] == 'money') {
				$dataout[$value['Nameform_code']] = str_replace(",", "", $datain[$value['Nameform_code']]);

			}
		}

	}
	return $dataout;


}


function getrowall($conn, $code, $value, $like)
{

	if ($like == 'yes') {
		$wh = $code . ' LIKE "%' . $value . '%"';
	} else {
		$wh = $code . '="' . $value . '%"';
	}
	$module = explode("_", $code)[0];
	$modulel = strtolower($module);
	$field = select_list($conn, 'SELECT * FROM nameform where Nameform_module ="' . $module . '"');
	$mj = null;
	$mjw = null;
	$j = null;
	foreach ($field as $va) {
		if ($va['Nameform_formtype'] == 'parent') {
			$mj = $mj . ',' . $va['Nameform_pmodule'];
			$mjw = $mjw . ' AND ' . $modulel . '.' . $va['Nameform_code'] . '=' . $va['Nameform_pmodule'] . '.' . $va['Nameform_pfieldid'];
		}


	}
	if ($mj != null) {
		$mj = substr($mj, 1);
		$mjw = substr($mjw, 5);
		$j = ' LEFT JOIN (' . $mj . ') ON (' . $mjw . ') ';

	}

	$sql = 'SELECT * FROM ' . $modulel . $j . ' WHERE ' . $wh;
	$data = select_list($conn, $sql);
	return $data;
}


function drawform($conn, $module, $option, $l = 3, $notshow, $fastadd = '',$fid = '')
{

	$field = select_list($conn, 'Select * from nameform where Nameform_module = "' . $module . '" order by Nameform_showpri');
	foreach ($field as $value) {
		if (!isset($notshow[$value['Nameform_code']])) {
			?>


			<?php
			if ($value['Nameform_formtype'] == 'text' or $value['Nameform_formtype'] == 'date' or $value['Nameform_formtype'] == 'time') {
				?>
                <div class="col-sm-<?= $l ?>" style="height:85px">
                    <div class="form-group">
                        <label for="<?php echo $value['Nameform_code']; ?>"><?php echo $value['Nameform_vi']; ?><?php if ($value['Nameform_requiremode'] == 1) {
								echo ' *';
							} ?></label>
                        <input <?php if (isset($option[$value['Nameform_code']])) {
							echo $option[$value['Nameform_code']];
						} ?><?php if ($value['Nameform_requiremode'] == 1) {
							echo 'required';
						} ?> type="<?php echo $value['Nameform_formtype']; ?>"
                             name="<?php echo $value['Nameform_code'].$fid; ?>"
                             class="form-control" id="<?php echo $value['Nameform_code'].$fid; ?>">
                    </div>
                </div>
				<?php
			}
			?>
			<?php
			if ($value['Nameform_formtype'] == 'textarea') {
				?>
                <div class="col-sm-<?= $l * 2 ?>" style="height:85px">
                    <div class="form-group">
                        <label for="<?php echo $value['Nameform_code']; ?>"><?php echo $value['Nameform_vi']; ?><?php if ($value['Nameform_requiremode'] == 1) {
								echo ' *';
							} ?></label>
                        <textarea <?php if (isset($option[$value['Nameform_code']])) {
							echo $option[$value['Nameform_code']];
						} ?> <?php if ($value['Nameform_requiremode'] == 1) {
							echo 'required';
						} ?> name="<?php echo $value['Nameform_code'].$fid; ?>" class="form-control"
                             id="<?php echo $value['Nameform_code'].$fid; ?>"></textarea>
                    </div>
                </div>
				<?php
			}
			?>
			<?php
			if ($value['Nameform_formtype'] == 'money') {
				?>
                <div class="col-sm-<?= $l ?>" style="height:85px">
                    <div class="form-group">
                        <label for="<?php echo $value['Nameform_code']; ?>"><?php echo $value['Nameform_vi']; ?><?php if ($value['Nameform_requiremode'] == 1) {
								echo ' *';
							} ?></label>
                        <input <?php if (isset($option[$value['Nameform_code']])) {
							echo $option[$value['Nameform_code']];
						} ?> <?php if (strpos($value['Nameform_addon'], 'Money') !== False) { ?> onkeyup="<?php echo $value['Nameform_code']; ?>Function()"    <?php }
						if ($value['Nameform_requiremode'] == 1) {
							echo 'required';
						} ?> type="text" name="<?php echo $value['Nameform_code'].$fid; ?>" class="form-control"
                             id="<?php echo $value['Nameform_code'].$fid; ?>">
                    </div>
                </div>
				<?php if (strpos($value['Nameform_addon'], 'Money') !== False) { ?>
                    <script>
                        function <?php echo $value['Nameform_code']; ?>Function() {
                            var b = document.getElementById("<?php echo $value['Nameform_code']; ?>").value;
                            var c = null;
                            if (b != null && b != '')
                                c = b.replace(/,/g, "");
                            else
                                c = null;
                            console.log(c);
                            var a = c.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            document.getElementById("<?php echo $value['Nameform_code']; ?>").value = a;
                        }
                    </script>

					<?php
				}
			}
			?>

			<?php
			if ($value['Nameform_formtype'] == 'chose' or $value['Nameform_formtype'] == 'parent') {


				if (!isset($option[$value['Nameform_code']])) {
					$option[$value['Nameform_code']] = null;
				}
				if (isset($fastadd[$value['Nameform_code']])) {
					selectpwa($conn, $value['Nameform_code'], 'Thêm mới', $option[$value['Nameform_code']], $l,$value['Nameform_code'].$fid);
				} else {
					selectbox5($conn, $value['Nameform_code'], $option[$value['Nameform_code']], $l,$fid);
				}


			}
			?>


			<?php

		}
	}

}


function drawform2($conn, $module, $option, $l = 3, $notshow, $fastadd = '')
{

	$field = select_list($conn, 'Select * from nameform where Nameform_module = "' . $module . '" order by Nameform_showpri');
	$i = 0;
	foreach ($field as $value) {
		if (!isset($notshow[$value['Nameform_code']])) {
			?>


			<?php
			if ($value['Nameform_formtype'] == 'text' or $value['Nameform_formtype'] == 'date' or $value['Nameform_formtype'] == 'time') {
				?>
                <div class="col-sm-<?= $l ?>">
                    <div class="form-group">
                        <label for="<?php echo $value['Nameform_code']; ?>"><?php echo $value['Nameform_vi']; ?><?php if ($value['Nameform_requiremode'] == 1) {
								echo ' *';
							} ?></label>
                        <input <?php if (isset($option[$value['Nameform_code']])) {
							echo $option[$value['Nameform_code']];
						} ?><?php if ($value['Nameform_requiremode'] == 1) {
							echo 'required';
						} ?> type="<?php echo $value['Nameform_formtype']; ?>"
                             name="<?php echo $value['Nameform_code']; ?>"
                             class="form-control" id="<?php echo $value['Nameform_code']; ?>">
                    </div>
                </div>
				<?php
			}
			?>
			<?php
			if ($value['Nameform_formtype'] == 'textarea') {
				?>
                <div class="col-sm-<?= $l * 2 ?>">
                    <div class="form-group">
                        <label for="<?php echo $value['Nameform_code']; ?>"><?php echo $value['Nameform_vi']; ?><?php if ($value['Nameform_requiremode'] == 1) {
								echo ' *';
							} ?></label>
                        <textarea <?php if (isset($option[$value['Nameform_code']])) {
							echo $option[$value['Nameform_code']];
						} ?> <?php if ($value['Nameform_requiremode'] == 1) {
							echo 'required';
						} ?> name="<?php echo $value['Nameform_code']; ?>" class="form-control"
                             id="<?php echo $value['Nameform_code']; ?>"></textarea>
                    </div>
                </div>
				<?php
			}
			?>
			<?php
			if ($value['Nameform_formtype'] == 'money') {
				?>
                <div class="col-sm-<?= $l ?>">
                    <div class="form-group">
                        <label for="<?php echo $value['Nameform_code']; ?>"><?php echo $value['Nameform_vi']; ?><?php if ($value['Nameform_requiremode'] == 1) {
								echo ' *';
							} ?></label>
                        <input <?php if (isset($option[$value['Nameform_code']])) {
							echo $option[$value['Nameform_code']];
						} ?> <?php if (strpos($value['Nameform_addon'], 'Money') !== False) { ?> onchange="<?php echo $value['Nameform_code']; ?>Function()"    <?php }
						if ($value['Nameform_requiremode'] == 1) {
							echo 'required';
						} ?> type="text" name="<?php echo $value['Nameform_code']; ?>" class="form-control"
                             id="<?php echo $value['Nameform_code']; ?>">
                    </div>
                </div>
				<?php if (strpos($value['Nameform_addon'], 'Money') !== False) { ?>
                    <script>
                        function <?php echo $value['Nameform_code']; ?>Function() {

                            var a = document.getElementById("<?php echo $value['Nameform_code']; ?>").value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            document.getElementById("<?php echo $value['Nameform_code']; ?>").value = a;
                        }
                    </script>

					<?php
				}
			}
			?>

			<?php
			if ($value['Nameform_formtype'] == 'chose' or $value['Nameform_formtype'] == 'parent') {


				if (!isset($option[$value['Nameform_code']])) {
					$option[$value['Nameform_code']] = null;
				}
				if (isset($fastadd[$value['Nameform_code']])) {
					selectpwa($conn, $value['Nameform_code'], 'Thêm mới', $option[$value['Nameform_code']], $l);
				} else {
					selectbox5($conn, $value['Nameform_code'], $option[$value['Nameform_code']], $l);
				}


			}
			?>


			<?php

		}
	}

}

// chức năng tự động tạo json từ các trường dữ liệu được định nghĩa trong field
function mkjfin($nf, $field, $action)
{
	?>
    <script>
        function <?php echo $nf; ?>() {
            var formData<?php echo $nf; ?> = {
			<?php foreach ($field as $value) { ?>            <?php echo $value; ?>:
            document.getElementById("<?php echo $value; ?>").value,

			<?php }
			?>
        }
            var data<?php echo $nf; ?> = JSON.stringify(formData<?php echo $nf; ?>);
			<?php echo $action; ?>

        }
    </script>
<?php }

/*
 *
 * Function vẽ ra hàm tính toán
 * $for= 'Tb3v25u_TrwOIt=Tb3v25u_m5bHv7*Tb3v25u_guvq4i';
 * $name = 'tinhtoan';
 *
 */

function calfj($name, $for)
{
	$field = explode('+', str_replace(array('=', '-', '*', '/', ' '), '+', $for));


	?>
    <script>

        function addcomma(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function rmcomma(x) {
            if (x != null && x != '')
                return x.replace(/,/g, "");
            else
                return null;
        }
        function <?php echo $name ?>() {
			<?php foreach ($field as $value) {  ?>
            var <?php echo $value ?> =
            rmcomma(document.getElementById('<?php echo $value ?>').value);
			<?php } ?>
			<?php echo $for;?>;
			<?php foreach ($field as $value) { ?>
            document.getElementById('<?php echo $value ?>').value = addcomma(<?php echo $value ?>);
			<?php } ?>

        }
    </script>

<?php }


function drawformandlist_old($conn, $cdata, $iddata, $idsua, $idbtadd, $fname, $onadd, $ondel = '')
{
	?>


    <script src="/js/makealert.js" type="text/javascript"></script>
    <div class="form-group">

		<?php foreach ($cdata as $value) {
			//$value['id'] = $value['id'].$fname;
			if ($value['type'] == 'hidden') { ?>
                <input <?= $value['option']; ?> type="<?= $value['type']; ?>" class="form-control"
                                                name="<?= $value['name']; ?>"
                                                id="<?= $value['id']; ?>" value="">


			<?php }
			if ($value['type'] != 'chose' and $value['type'] != 'textarea' and $value['type'] != 'hidden' and $value['type'] != 'select') { ?>
                <div class="col-lg-<?= $value['wid']; ?>">
                    <label><?= $value['show']; ?></label>


                    <input <?= $value['option']; ?> type="<?= $value['type']; ?>" class="form-control"
                                                    name="<?= $value['name']; ?>"
                                                    id="<?= $value['id']; ?>" value="">

                </div>
			<?php }
			if ($value['type'] == 'chose') {
				if (isset($value['quickadd'])) {
					selectpwa($conn, $value['code'], 'Thêm nhanh ' . $value['show'], $value['option'], $value['wid'], $value['id']);
					//selectbox2($conn, $value['code'], $value['option'], );
				} else {
					selectbox2($conn, $value['code'], $value['option'], $value['wid'], $value['id']);
				}

			}
			if ($value['type'] == 'select') {
				?>
                <div class="col-lg-<?= $value['wid']; ?>">
                    <label><?= $value['show']; ?></label>

                    <select name="<?= $value['name']; ?>" id="<?= $value['id']; ?>"
                            class="form-control chosen-select" <?= $value['option']; ?>>
						<?php
						foreach ($value['optionvalue'] as $key => $val):
							?>
                            <option value="<?= $key ?>" <?= ($key == $value['defaultvalue']) ? 'selected' : '' ?>><?= $val ?></option>
							<?php
						endforeach;
						?>
                    </select>

                </div>
				<?php
			}


			if ($value['type'] == 'textarea') { ?>
                <div class="col-lg-<?= $value['wid']; ?>">
                    <label><?= $value['show']; ?></label>


                    <textarea <?= $value['option']; ?> name="<?= $value['name']; ?>"
                                                       class="form-control inputcontent1 normal"
                                                       id="<?= $value['id']; ?>"
                                                       style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 54px;"></textarea>
                </div>
			<?php }
		}//end foreach
		?>
    </div>
    <form id="dataupload" class="form-horizontal">
        <input type="hidden" id="<?= $iddata; ?>" name="<?= $iddata; ?>" value="[]" style="wi">
        <input type="hidden" id="<?= $idsua; ?>" name="<?= $idsua; ?>" value="a" style="wi">

        <div class="form-group">

            <div class="col-sm-1">
                <label class="control-label col-sm-12">&nbsp;</label>
                <button type="button" id="<?= $idbtadd; ?>" onclick="them<?= $fname; ?>()"
                        class="btn btn-sm btn-danger">Thêm
                </button>
            </div>
        </div>
        <!--vẽ bảng-->
        <div id="table<?= $fname; ?>"></div>
    </form>
    <script>
        function addcomma(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function rmcomma(x) {
            if (x != null && x != '')
                return x.replace(/,/g, "");
            else
                return null;
        }

        function <?= 'vebang' . $fname;?>() {
            //lam trong bang
            $("#table<?= $fname;?>").empty();
            //ve bang
            var $table = $('<table class="table table-bordered"></table>');
            var <?= $iddata; ?> =
            $.parseJSON($('#<?= $iddata; ?>').val());
            var $line = $("<tr></tr>");
			<?php foreach ($cdata as $value) {
			//$value['id'] = $value['id'].$fname;
			?>
            $line.append($('<th class="text-center"><?= $value['show']; ?></th>'));
			<?php } ?>
            $line.append($('<th style="width: 50px;">Sửa</th>'));
            $line.append($('<th style="width: 50px;">Xóa</th>'));
            $table.append($line);

            for (var i = <?= $iddata; ?>.
            length - 1;
            i >= 0;
            i--
        )
            {
                var emp = <?= $iddata; ?>[i];
                if (i == <?= $iddata; ?>.
                length - 1
            )
                {
                    var $line = $("<tr id='newline'></tr>");
                }
            else
                {
                    var $line = $("<tr></tr>");
                }

				<?php foreach ($cdata as $value) {
				//$value['id'] = $value['id'].$fname;
				if($value['type'] == 'number'){
				?>
                $line.append($("<td></td>").html(addcomma(emp.<?= $value['id']; ?>)));
				<?php
				}else{

				?>
                $line.append($("<td></td>").html(emp.<?= $value['id']; if ($value['type'] == 'chose' OR $value['type'] == 'select') {
					echo 'text';
				}?>));
				<?php
				}
				} ?>
                $line.append($('<td class="text-center"></td>').html(
                    '<a class="glyphicon glyphicon-edit" ' +
                    'onclick="<?= $fname;?>edit(' + i + ')"></a>'));
                $line.append($('<td class="text-center"></td>').html(
                    '<a class="fa fa-remove" ' +
                    'onclick="<?php if(empty($ondel)): ?><?= $fname;?>delete(' + i + ')<?php else: ?><?= $ondel() ?><?php endif; ?>"></a>'));
                $table.append($line);
            }
            $table.appendTo($("#table<?= $fname;?>"));

        }

        function
		<?= $fname;?>delete(i)
        {
            var <?= $iddata; ?> =
            $.parseJSON($('#<?= $iddata; ?>').val());
			<?= $iddata; ?>.
            splice(i, 1);
            $('#<?= $iddata; ?>').val(JSON.stringify(<?= $iddata; ?>));
            vebang<?= $fname;?>();

        }
        function <?= $fname;?>edit(i) {
            var <?= $iddata; ?> =
            $.parseJSON($('#<?= $iddata; ?>').val());
            var line_edit = <?= $iddata; ?>[i];
            $('#<?= $idbtadd; ?>').html('Sửa');
            $('#<?= $idbtadd; ?>').removeClass('btn-danger');
            $('#<?= $idbtadd; ?>').addClass('btn-warning');
            $('#<?= $idsua; ?>').val(i);
			<?php foreach ($cdata as $value) {
			?>
            var <?= $value['id']; ?> =
            line_edit['<?= $value['id']; ?>'];
            console.log(<?= $value['id']; ?>);
			<?php if ($value['type'] == 'chose' OR $value['type'] == 'select') {
			?>
            $('#<?= $value['id']; ?>').val(<?= $value['id']; ?>).trigger('chosen:updated');
			<?php } else { ?>
            $('#<?= $value['id']; ?>').val(<?= $value['id']; ?>);
			<?php } } ?>
        }

        function <?= 'them' . $fname;?>() {
            var id = $('#<?= $idsua; ?>').val();
            if (id != 'a') {
				<?= $iddata; ?> = $.parseJSON($('#<?= $iddata; ?>').val());
				<?= $iddata; ?>.
                splice(id, 1);
                //Convert mang sang json va tra vao input
                $('#<?= $iddata; ?>').val(JSON.stringify(<?= $iddata; ?>));
                // ve bang
                vebang<?= $fname;?>();
                $('#<?= $idsua; ?>').val('a');
            }


			<?php foreach ($cdata as $value) {
			if ($value['type'] != 'chose' AND $value['type'] != 'select') {?>
            var <?= $value['id']; ?> =
            $('#<?= $value['id']; ?>').val();
            console.log(<?= $value['id']; ?>);
			<?php if ($value['require'] == 'yes') { ?>
            if (<?= $value['id']; ?> == ''
        )
            {
                makeAlertright('Chưa nhập <?= $value['show']; ?>', 5000);
                return;
            }
			<?php }
			} //end if
			if ($value['type'] == 'chose' OR $value['type'] == 'select') { ?>
            var <?= $value['id']; ?> =
            $('#<?= $value['id']; ?>').val();
            var <?= $value['id']; ?>text = $('#<?= $value['id']; ?> option:selected').text();

			<?php if ($value['require'] == 'yes') { ?>
            if (<?= $value['id']; ?> == 0
        )
            {
                makeAlertright('Chưa chọn <?= $value['show']; ?>', 5000);
                return;
            }
			<?php } //end if
			} //end if
			} ?>
			<?= $iddata; ?> = $.parseJSON($('#<?= $iddata; ?>').val());

            var echitiet = {
				<?php foreach ($cdata as $value) { ?>
				<?= $value['id']; ?>,
				<?php if ($value['type'] == 'chose' OR $value['type'] == 'select') {?><?= $value['id']; ?>text, <?php } ?>
				<?php } ?>
                }

			<?= $iddata; ?>.
            push(echitiet);

            //Convert mang sang json va tra vao input
            $('#<?= $iddata; ?>').val(JSON.stringify(<?= $iddata; ?>));
            vebang<?= $fname;?>();
			<?php foreach ($cdata as $value) { if ($value['reset'] == 'yes') {
			if ($value['type'] == 'chose' OR $value['type'] == 'select') {?>

            $('#<?= $value['id']; ?>').val("0").trigger('chosen:updated');
			<?php } else { ?>
            $('#<?= $value['id']; ?>').val("");
			<?php  }} }?>
            $('#<?= $idbtadd; ?>').html('Thêm');
            $('#<?= $idbtadd; ?>').addClass('btn-danger');
            $('#<?= $idbtadd; ?>').removeClass('btn-warning');

            //$('#newline').css("background-color", "red");
            $("#newline").animate({
                backgroundColor: 'yellow',
            });
            $("#newline").animate({
                backgroundColor: 'white',
            });
            //ve bang
			<?= $onadd; ?>
        }
    </script>

	<?php
}

function getjsondata($field, $sql, $conn)
{

	foreach ($field as $value) {
		if (isset($_GET[$value])) {

			$sql = str_replace('@' . $value . '@', $_GET[$value], $sql);

		}

	}
	$data = select_list($conn, $sql);
	echo '@data@' . json_encode($data) . '@data@';
	exit;
}


///////////////////////////Function Drawfromandlist///////////
/* Example
$cdata = array(
array(
'name'=>'tencongviecchitiet',
'id'=>'tencongviecchitiet',
'show'=>'Công việc chi tiết',
'type'=>'text',
'wid'=>3,
'option'=>'onchange="themfname()"',
'reset' => 'yes',
'require' => 'no',
),
array(
'type'=>'chose',
'show'=>'Loại',
'code'=>'Ti8lxup_3oFmw4',
'id'=>'Ti8lxup_3oFmw4',
'wid'=>2,
'option'=>'',
'mt'=>3,
'reset' => 'no',
'require' => 'no',
),

);
$onadd = 'abc()';
drawformandlist($conn, $cdata, 'iddata','idsua','idbtadd','fname',$onadd);
 ?>
*/
function drawformandlist($conn, $cdata, $iddata, $idsua, $idbtadd, $fname, $onadd = '', $ondel = '', $onedit = '', $ondelfst = '')
{
	?>


    <script src="/js/makealert.js" type="text/javascript"></script>
    <div class="form-group">

		<?php foreach ($cdata as $value) {
			//$value['id'] = $value['id'].$fname;
		if ($value['type'] == 'hidden' || $value['type'] == 'hiddenx') { ?>
        <input <?= $value['option']; ?> type="hidden" class="form-control"
                                        name="<?= $value['name']; ?>"
                                        id="<?= $value['id']; ?>" value="">


		<?php }
		if ($value['type'] != 'chose' and $value['type'] != 'textarea' and $value['type'] != 'hidden' and $value['type'] != 'hiddenx' and $value['type'] != 'select' and $value['type'] != 'numberx') { ?>
            <div class="col-lg-<?= $value['wid']; ?>">
                <label><?= $value['show']; ?></label>


                <input <?= $value['option']; ?> type="<?= $value['type']; ?>" class="form-control"
                                                name="<?= $value['name']; ?>"
                                                id="<?= $value['id']; ?>" value="">

            </div>
		<?php }
		if ($value['type'] == 'numberx') {
		?>
            <div class="col-lg-<?= $value['wid']; ?>">
                <label><?= $value['show']; ?></label>
                <input <?= $value['option']; ?> type="text" class="form-control"
                                                name="<?= $value['name']; ?>"
                                                id="<?= $value['id']; ?>" value="">
            </div>
            <script>
                $("#<?= $value['id']; ?>").keyup(function () {
                    $('#<?= $value['id']; ?>').val(addcomma(rmcomma($('#<?= $value['id']; ?>').val())));
                });
            </script>
		<?php
		}


		if ($value['type'] == 'chose') {
			if (isset($value['quickadd'])) {
				selectpwa($conn, $value['code'], 'Thêm nhanh ' . $value['show'], $value['option'], $value['wid'], $value['id']);
				//selectbox2($conn, $value['code'], $value['option'], );
			} else {
				selectbox2($conn, $value['code'], $value['option'], $value['wid'], $value['id'], $value['mt'], $value['show']);
				//selectbox($conn, $value['code'],$value['mt'],$value['wid']);
			}

		}
		if ($value['type'] == 'select') {
		?>
            <div class="col-lg-<?= $value['wid']; ?>">
                <label><?= $value['show']; ?></label>
                <select name="<?= $value['name']; ?><?= ($value['mt'] == 'yes') ? '[]' : '' ?>"
                        id="<?= $value['id']; ?>"
                        class="form-control chosen-select" <?= ($value['mt'] == 'yes') ? 'multiple' : '' ?> <?= $value['option']; ?>>
					<?php
					foreach ($value['optionvalue'] as $key => $val):
						if (!is_array($val)):
							?>
                            <option value="<?= $key ?>" <?= ($key == $value['defaultvalue']) ? 'selected' : '' ?>><?= $val ?></option>
							<?php
						else:

							?>
                             <optgroup label="<?= $key ?>">
	                             <?php
	                             foreach ($val as $grkey => $grval):
                                 ?>
                                 <option value="<?= $grkey ?>" <?= ($grkey == $value['defaultvalue']) ? 'selected' : '' ?>><?= $grval ?></option>
	                             <?php
	                             endforeach;
	                             ?>
                            </optgroup>
							<?php
						endif;
					endforeach;
					?>
                </select>
                <style>
                    .group-result {
    cursor: pointer !important;
}
                </style>
                <script>
                    // Add select/deselect all toggle to optgroups in chosen
$(document).on('click', '.group-result', function() {
    // Get unselected items in this group
    var unselected = $(this).nextUntil('.group-result').not('.result-selected');
    if(unselected.length) {
        // Select all items in this group
        unselected.trigger('mouseup');
    } else {
        $(this).nextUntil('.group-result').each(function() {
            // Deselect all items in this group
            $('a.search-choice-close[data-option-array-index="' + $(this).data('option-array-index') + '"]').trigger('click');
        });
    }
});
                </script>
            </div>
		<?php
		}


		if ($value['type'] == 'textarea') { ?>
            <div class="col-lg-<?= $value['wid']; ?>">
                <label><?= $value['show']; ?></label>


                <textarea <?= $value['option']; ?> name="<?= $value['name']; ?>"
                                                   class="form-control inputcontent1 normal"
                                                   id="<?= $value['id']; ?>"
                                                   style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 54px;"></textarea>
            </div>
		<?php }
		}//end foreach
		?>
    </div>
    <!--  <form id="dataupload" class="form-horizontal">-->
    <input type="hidden" id="<?= $iddata; ?>" name="<?= $iddata; ?>" value="[]" style="wi">
    <input type="hidden" id="<?= $idsua; ?>" name="<?= $idsua; ?>" value="a" style="wi">

    <div class="form-group">

        <div class="col-sm-1">
            <label class="control-label col-sm-12">&nbsp;</label>
            <button type="button" id="<?= $idbtadd; ?>" onclick="them<?= $fname; ?>()"
                    class="btn btn-sm btn-danger">Thêm
            </button>
        </div>
    </div>
    <!--vẽ bảng-->
    <div id="table<?= $fname; ?>"></div>
    <!-- </form>-->
    <script>
        function addcomma(x) {
            if (x != null && x != '')
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            else
                return null;
        }
        function rmcomma(x) {
            if (x != null && x != '')
                return x.replace(/,/g, "");
            else
                return null;
        }

        function <?= 'vebang' . $fname;?>() {
            //lam trong bang
            $("#table<?= $fname;?>").empty();
            //ve bang
            var $table = $('<table class="table table-bordered"></table>');
            var <?= $iddata; ?> =
            $.parseJSON($('#<?= $iddata; ?>').val());
            var $line = $("<tr></tr>");
			<?php foreach ($cdata as $value) {
			//$value['id'] = $value['id'].$fname;
			if($value['type'] != 'hiddenx'){
			?>
            $line.append($('<th class="text-center"><?= $value['show']; ?></th>'));
			<?php }
			} ?>
            $line.append($('<th style="width: 50px;">Sửa</th>'));
            $line.append($('<th style="width: 50px;">Xóa</th>'));
            $table.append($line);

            for (var i = <?= $iddata; ?>.
            length - 1;
            i >= 0;
            i--
        )
            {
                var emp = <?= $iddata; ?>[i];
                if (i == <?= $iddata; ?>.
                length - 1
            )
                {
                    var $line = $("<tr id='newline'></tr>");
                }
            else
                {
                    var $line = $("<tr></tr>");
                }

				<?php foreach ($cdata as $value) {
				//$value['id'] = $value['id'].$fname;
				if($value['type'] != 'hiddenx'){
				if($value['type'] == 'number' || $value['type'] == 'numberx'){
				?>
                $line.append($("<td></td>").html(addcomma(emp.<?= $value['id']; ?>)));
				<?php
				}else{
				if ($value['type'] == 'chose' OR $value['type'] == 'select'):
				if ($value['mt'] == 'yes') {
				?>
                var $row = $("<td></td>");
                $.each(emp.<?= $value['id'] ?>text, function (key, value) {
                    $row.append('' +
                        '<span class="label label-success">' + value + '</span>&nbsp;'
                    );
                });
                $line.append($row);
				<?php
				}else{
				?>
                $line.append($("<td></td>").html(emp.<?= $value['id'] ?>text));
				<?php
				}
				else: ?>
                $line.append($("<td></td>").html(emp.<?= $value['id'] ?>));
				<?php endif; ?>

				<?php
				}  //end check number
				} //end check hiddenx
				} //end foreach ?>
                $line.append($('<td class="text-center"></td>').html(
                    '<a class="glyphicon glyphicon-edit" ' +
                    'onclick="<?= $fname;?>edit(' + i + ')"></a>'));
                $line.append($('<td class="text-center"></td>').html(
                    '<a class="fa fa-remove" ' +
                    'onclick="<?= $fname;?>delete(' + i + ')"></a>'));
                $table.append($line);
            }
            $table.appendTo($("#table<?= $fname;?>"));

        }

        function
		<?= $fname;?>delete(i)
        {
			<?= $ondelfst ?>
            var <?= $iddata; ?> =
            $.parseJSON($('#<?= $iddata; ?>').val());
			<?= $iddata; ?>.
            splice(i, 1);
            $('#<?= $iddata; ?>').val(JSON.stringify(<?= $iddata; ?>));
            vebang<?= $fname;?>();
			<?= $ondel ?>

        }
        function <?= $fname;?>edit(i) {
            var <?= $iddata; ?> =
            $.parseJSON($('#<?= $iddata; ?>').val());
            var line_edit = <?= $iddata; ?>[i];
            $('#<?= $idbtadd; ?>').html('Sửa');
            $('#<?= $idbtadd; ?>').removeClass('btn-danger');
            $('#<?= $idbtadd; ?>').addClass('btn-warning');
            $('#<?= $idsua; ?>').val(i);
			<?php foreach ($cdata as $value) {
			?>
            var <?= $value['id']; ?> =
            line_edit['<?= $value['id']; ?>'];
            console.log(<?= $value['id']; ?>);
			<?php if ($value['type'] == 'chose' OR $value['type'] == 'select') {
			?>
            $('#<?= $value['id']; ?>').val(<?= $value['id']; ?>).trigger('chosen:updated');
			<?php } else { ?>
            $('#<?= $value['id']; ?>').val(<?= $value['id']; ?>);
			<?php } } ?>
			<?= $onedit ?>
        }

        function <?= 'them' . $fname;?>() {
            var id = $('#<?= $idsua; ?>').val();
            if (id != 'a') {
				<?= $iddata; ?> = $.parseJSON($('#<?= $iddata; ?>').val());
				<?= $iddata; ?>.
                splice(id, 1);
                //Convert mang sang json va tra vao input
                $('#<?= $iddata; ?>').val(JSON.stringify(<?= $iddata; ?>));
                // ve bang
                vebang<?= $fname;?>();
                $('#<?= $idsua; ?>').val('a');
            }


			<?php foreach ($cdata as $value) {
			if ($value['type'] != 'chose' AND $value['type'] != 'select' AND $value['type'] != 'numberx') {?>
            var <?= $value['id']; ?> =
            $('#<?= $value['id']; ?>').val();
            //console.log(<?= $value['id']; ?>);
			<?php if ($value['require'] == 'yes') { ?>
            if (<?= $value['id']; ?> == '' || <?= $value['id']; ?> == null
        )
            {
                makeAlertright('Chưa nhập <?= $value['show']; ?>', 5000);
                return;
            }
			<?php }
			} //end if
			if ($value['type'] == 'numberx') {?>
            var <?= $value['id']; ?> =
            rmcomma($('#<?= $value['id']; ?>').val());
            console.log(<?= $value['id']; ?>);
			<?php if ($value['require'] == 'yes') { ?>
            if (<?= $value['id']; ?> == '' || <?= $value['id']; ?> == null
        )
            {
                makeAlertright('Chưa nhập <?= $value['show']; ?>', 5000);
                return;
            }
			<?php }
			} //end if


			if ($value['type'] == 'chose' OR $value['type'] == 'select') { ?>
            var <?= $value['id']; ?> =
            $('#<?= $value['id']; ?>').val();
			<?php
			if($value['mt'] == 'yes'):
			?>
            var optlist = [];
            $("#<?= $value['id']; ?> option:selected").each(function () {
                var $this = $(this);
                if ($this.length) {
                    var selText = $this.text();
                    //console.log(selText);
                    optlist.push(selText);
                }
            });
            var <?= $value['id']; ?>text = optlist;
            //console.log(optlist);
			<?php else: ?>
            var <?= $value['id']; ?>text = $('#<?= $value['id']; ?> option:selected').text();
			<?php endif; ?>
			<?php if ($value['require'] == 'yes') { ?>
            if (<?= $value['id']; ?> == 0
        )
            {
                makeAlertright('Chưa chọn <?= $value['show']; ?>', 5000);
                return;
            }
			<?php } //end if
			} //end if
			} ?>
			<?= $iddata; ?> = $.parseJSON($('#<?= $iddata; ?>').val());

            var echitiet = {
				<?php foreach ($cdata as $value) { ?>
				<?= $value['id']; ?>,
				<?php if ($value['type'] == 'chose' OR $value['type'] == 'select') {?>
				<?= $value['id']; ?>text,
				<?php } ?>
				<?php } ?>
                }

			<?= $iddata; ?>.
            push(echitiet);

            //Convert mang sang json va tra vao input
            $('#<?= $iddata; ?>').val(JSON.stringify(<?= $iddata; ?>));
            vebang<?= $fname;?>();
			<?php foreach ($cdata as $value) { if ($value['reset'] == 'yes') {
			if ($value['type'] == 'chose' OR $value['type'] == 'select') {?>

            $('#<?= $value['id']; ?>').val("0").trigger('chosen:updated');
			<?php } else { ?>
            $('#<?= $value['id']; ?>').val("");
			<?php  }} }?>
            $('#<?= $idbtadd; ?>').html('Thêm');
            $('#<?= $idbtadd; ?>').addClass('btn-danger');
            $('#<?= $idbtadd; ?>').removeClass('btn-warning');

            //$('#newline').css("background-color", "red");
            $("#newline").animate({
                backgroundColor: 'yellow',
            });
            $("#newline").animate({
                backgroundColor: 'white',
            });
            //ve bang
			<?= $onadd; ?>
        }
    </script>

	<?php
}


function rmcomma($str)
{
	return str_replace(',', '', $str);
}


function drawtablejs($conn, $module, $title, $idtabel, $column, $option = array())
{

	/*$sql = "Select * from nameform where Nameform_module = '" . $module . "'";
	$nameform = select_list($conn, $sql);*/

	$nameformarry = array();
	/*foreach ($nameform as $value) {
		$nameformarry[$value['Nameform_code']]['code'] = $value['Nameform_code'];
		$nameformarry[$value['Nameform_code']]['vi'] = $value['Nameform_vi'];
		$nameformarry[$value['Nameform_code']]['type'] = $value['Nameform_formtype'];
		$nameformarry[$value['Nameform_code']]['pmodule'] = $value['Nameform_pmodule'];
		$nameformarry[$value['Nameform_code']]['pmoduleshow'] = $value['Nameform_pfieldshow'];
		$nameformarry[$value['Nameform_code']]['pfieldid'] = $value['Nameform_pfieldid'];
	}*/

	foreach ($column as $item) {
		$sql = "Select * from nameform where Nameform_code = '" . $item . "'";
		$value = select_info($conn, $sql);
		$nameformarry[$value['Nameform_code']]['code'] = $value['Nameform_code'];
		$nameformarry[$value['Nameform_code']]['vi'] = $value['Nameform_vi'];
		$nameformarry[$value['Nameform_code']]['type'] = $value['Nameform_formtype'];
		$nameformarry[$value['Nameform_code']]['pmodule'] = $value['Nameform_pmodule'];
		$nameformarry[$value['Nameform_code']]['pmoduleshow'] = $value['Nameform_pfieldshow'];
		$nameformarry[$value['Nameform_code']]['pfieldid'] = $value['Nameform_pfieldid'];
	}

	/*foreach ($customcol as $item) {
		$sql = "Select * from nameform where Nameform_code = '" . $item . "'";
		$value = select_info($conn, $sql);
		$nameformarry[$value['Nameform_code']]['code'] = $value['Nameform_code'];
		$nameformarry[$value['Nameform_code']]['vi'] = $value['Nameform_vi'];
		$nameformarry[$value['Nameform_code']]['type'] = $value['Nameform_formtype'];
		$nameformarry[$value['Nameform_code']]['pmodule'] = $value['Nameform_pmodule'];
		$nameformarry[$value['Nameform_code']]['pmoduleshow'] = $value['Nameform_pfieldshow'];
		$nameformarry[$value['Nameform_code']]['pfieldid'] = $value['Nameform_pfieldid'];
	}*/


	?>


    <script src="/handsontable/dist/handsontable.full.js"></script>
    <link rel="stylesheet" media="screen" href="/handsontable/dist/handsontable.full.css">
    <link rel="stylesheet" media="screen" href="/handsontable/plugins/bootstrap/handsontable.bootstrap.css">
    <script src="/js/makealert.js" type="text/javascript"></script>
    <script src="/handsontable/lib/handsontable-chosen-editor.js"></script>
    <script>
        var $$ = function (id) {
            return document.getElementById(id);
        }
        var container = $$('<?php echo $idtabel; ?>show');
        var <?php echo $idtabel; ?>=
        new Handsontable(container, {
            minSpareRows: 1,
            rowHeaders: true,
            stretchH: "all",
            colHeaders: [<?php foreach ($column as $key => $value) {
				if(empty($nameformarry[$value]['vi'])):
				?>
                "<?= $key ?>",
				<?php
				else:
				?>
                "<?php echo $nameformarry[$value]['vi']; ?>", <?php endif; } ?>
            ],
            contextMenu: true,
            columns: [
				<?php foreach ($column as $key => $value) { ?>
				<?php
				if(empty($nameformarry[$value]['type'])):
				?>
                {type: '<?= $column[$key]['type'] ?>',<?= $column[$key]['option'] ?> },
				<?php else:
				if ($nameformarry[$value]['type'] == 'text' or $nameformarry[$value]['type'] == 'textarea') { ?>
                {type: 'text'},
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'date') { ?>
                {type: 'date'},
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'money') { ?>
                {type: 'numeric', format: '0,0'},
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'chose') { ?>
				<?php
				$data = select_list($conn, 'SELECT * FROM dataman where Data_field = "' . $nameformarry[$value]['code'] . '"');
				?>
                {
                    type: 'autocomplete',
                    source: [
						<?php foreach ($data as $value1) { ?>
                        "<?php echo preg_replace('/\s+/', ' ', trim($value1['Value'])); ?>",
						<?php } ?>
                    ],
                    strict: true,
                    allowInvalid: false
                },
				<?php } ?>
				<?php if ($nameformarry[$value]['type'] == 'parent') {
				$data = select_list($conn, 'SELECT * FROM ' . $nameformarry[$value]['pmodule']);
				?>
                {
                    type: 'autocomplete',
					<?php if($option[$nameformarry[$value]['code']]['chosen'] == 'yes'): ?>
                    editor: "chosen",
                    chosenOptions: {
                        multiple: true,
                        data: [
							<?php foreach ($data as $value1) { ?>
                            {
                                id: "<?php echo $value1[$nameformarry[$value]['pmoduleshow']]; ?>",
                                label: "<?php echo $value1[$nameformarry[$value]['pmoduleshow']]; ?>"
                            },
							<?php } ?>
                        ]
                    },
					<?php else:
					?>
                    source: [
						<?php foreach ($data as $value1) { ?>
                        "<?php echo preg_replace('/\s+/', ' ', trim($value1[$nameformarry[$value]['pmoduleshow']])) ?>",
						<?php } ?>
                    ],
					<?php endif; ?>
                    strict: true,
                    allowInvalid: true
                },
				<?php } ?>


				<?php
				endif;
				} ?>

            ]
        });
    </script>
	<?php
}

function sendcurl($url, $data, $type = 'post')
{
	// Get cURL resource
	$curl = curl_init();
// Set some options - we are passing in a useragent too here
	if ($type == 'post') {
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => 'Hải Long Trịnh',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $data
		));
	} else {
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_USERAGENT => 'Hải Long Trịnh'
		));
	}
// Send the request & save response to $resp
	$resp = curl_exec($curl);
	if (!$resp) {
		die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
	}
// Close request to clear up some resources
	curl_close($curl);
	return $resp;
}

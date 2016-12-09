<?php

/**
 * 邮件类
 * 
 * @author moxiaobai
 * @since  2013-03-12
 */

/**
 * @example
 * $mail = new Mail_Send();
 * $ret = $mail->send('262756784@qq.com', '测试邮件', 'Hello,这是测试邮件', '莫小白');
 * var_dump($ret);
 */

require("class.phpmailer.php");

class Mail_Send {
	
	private $_mail;
	
	const IS_AUTH = TRUE;
	const CHARSET = 'UTF-8';
	
	const SERVER_HOST = 'smtp.exmail.qq.com';
	const SERVER_PORT = 25;

	//邮件配置
	private $_project = array(
		//@todo 邮件自行配置
		'tech'    => array('fromEmail'=>'', 'password'=>'', 'fromName'=>'研发中心'),
	);
	
	/**
	 * 初始化邮件类
	 * 
	 * @param string $project 项目
	 */
	public function __construct($project) {
		if(!$project) {
			throw new Exception("Missing Project Config");
		}

		$info = isset($this->_project[$project]) ? $this->_project[$project] : null;
		if(is_null($info)) {
			throw new Exception("Missing Project Config");
		}

		$this->_mail = new PHPMailer;
		//$this->_mail->SMTPDebug  = 2;
		$this->_mail->SMTPAuth   = true;                  
		$this->_mail->Host       = Mail_Send::SERVER_HOST; 
		$this->_mail->Port       = Mail_Send::SERVER_PORT;                    
		$this->_mail->Username   = $info['fromEmail'];
		$this->_mail->Password   = $info['password'];
		$this->_mail->CharSet    = Mail_Send::CHARSET;
		$this->_mail->IsSMTP();

		$this->_fromEmail = $info['fromEmail'];
		$this->_fromName  = $info['fromName'];
		$this->_mail->SetFrom($this->_fromEmail, $this->_fromName);
	}
	
	/**
	 * 发送邮件
	 * 
	 * @param string $email 收件人邮箱
	 * @param string $title 邮件标题
	 * @param string $body  邮件内容
	 * @param string $name  收件人名称
	 * @param string $isQueue 是否写入队列
	 * @return boolean
	 */
	public function send($email, $title, $body, $name='', $isQueue=false) {
		if(!$email) {
			return false;
		} 
		
		if($isQueue) {
			$this->queue();
		}
		
		$this->_mail->AddAddress($email, $name);
		$this->_mail->Subject = $title;
		$this->_mail->IsHTML(true);
		$this->_mail->Body = $body;
		
		$ret = $this->_mail->Send();
		return $ret;
	}
	
	/**
	 * 邮件队列
	 */
	private function queue() {
		return true;
	}
}
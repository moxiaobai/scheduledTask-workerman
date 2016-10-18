<?
/**
 * LICENSE: The MIT License
 * Copyright (c) 2010 Chris Nizzardini (http://www.cnizz.com) 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * largely a wrapper class for php imap functions but since the classes on phpclasses.org are so shitty here we go....
 * @see http://www.php.net/manual/en/book.imap.php
 * @uses imap_mailboxmsginfo
 * @uses imap_headers
 * @uses imap_list
 * @uses imap_headerinfo
 */

class Mail_Imap {
    /**
     * @var resource $_connect
     */
    private $_connect;
    /**
     * @var object $_mailInfo
     */
    private $_mailInfo;
    /**
     * @var int $_totalCount
     */
    private $_totalCount;
    /**
     * @var array $_totalCount
     */
    private $_contentType;

    
    /**
     * __construct of the class
     */
    public function __construct() {
        $this->_contentType = array(
            'ez' => 'application/andrew-inset','hqx' => 'application/mac-binhex40',
            'cpt' => 'application/mac-compactpro','doc' => 'application/msword',
            'bin' => 'application/octet-stream','dms' => 'application/octet-stream',
            'lha' => 'application/octet-stream','lzh' => 'application/octet-stream',
            'exe' => 'application/octet-stream','class' => 'application/octet-stream',
            'so' => 'application/octet-stream','dll' => 'application/octet-stream',
            'oda' => 'application/oda','pdf' => 'application/pdf',
            'ai' => 'application/postscript','eps' => 'application/postscript',
            'ps' => 'application/postscript','smi' => 'application/smil',
            'smil' => 'application/smil','mif' => 'application/vnd.mif',
            'xls' => 'application/vnd.ms-excel','ppt' => 'application/vnd.ms-powerpoint',
            'wbxml' => 'application/vnd.wap.wbxml','wmlc' => 'application/vnd.wap.wmlc',
            'wmlsc' => 'application/vnd.wap.wmlscriptc','bcpio' => 'application/x-bcpio',
            'vcd' => 'application/x-cdlink','pgn' => 'application/x-chess-pgn',
            'cpio' => 'application/x-cpio','csh' => 'application/x-csh',
            'dcr' => 'application/x-director','dir' => 'application/x-director',
            'dxr' => 'application/x-director','dvi' => 'application/x-dvi',
            'spl' => 'application/x-futuresplash','gtar' => 'application/x-gtar',
            'hdf' => 'application/x-hdf','js' => 'application/x-javascript',
            'skp' => 'application/x-koan','skd' => 'application/x-koan',
            'skt' => 'application/x-koan','skm' => 'application/x-koan',
            'latex' => 'application/x-latex','nc' => 'application/x-netcdf',
            'cdf' => 'application/x-netcdf','sh' => 'application/x-sh',
            'shar' => 'application/x-shar','swf' => 'application/x-shockwave-flash',
            'sit' => 'application/x-stuffit','sv4cpio' => 'application/x-sv4cpio',
            'sv4crc' => 'application/x-sv4crc','tar' => 'application/x-tar',
            'tcl' => 'application/x-tcl','tex' => 'application/x-tex',
            'texinfo' => 'application/x-texinfo','texi' => 'application/x-texinfo',
            't' => 'application/x-troff','tr' => 'application/x-troff',
            'roff' => 'application/x-troff','man' => 'application/x-troff-man',
            'me' => 'application/x-troff-me','ms' => 'application/x-troff-ms',
            'ustar' => 'application/x-ustar','src' => 'application/x-wais-source',
            'xhtml' => 'application/xhtml+xml','xht' => 'application/xhtml+xml',
            'zip' => 'application/zip','au' => 'audio/basic','snd' => 'audio/basic',
            'mid' => 'audio/midi','midi' => 'audio/midi','kar' => 'audio/midi',
            'mpga' => 'audio/mpeg','mp2' => 'audio/mpeg','mp3' => 'audio/mpeg',
            'aif' => 'audio/x-aiff','aiff' => 'audio/x-aiff','aifc' => 'audio/x-aiff',
            'm3u' => 'audio/x-mpegurl','ram' => 'audio/x-pn-realaudio','rm' => 'audio/x-pn-realaudio',
            'rpm' => 'audio/x-pn-realaudio-plugin','ra' => 'audio/x-realaudio',
            'wav' => 'audio/x-wav','pdb' => 'chemical/x-pdb','xyz' => 'chemical/x-xyz',
            'bmp' => 'image/bmp','gif' => 'image/gif','ief' => 'image/ief',
            'jpeg' => 'image/jpeg','jpg' => 'image/jpeg','jpe' => 'image/jpeg',
            'png' => 'image/png','tiff' => 'image/tiff','tif' => 'image/tiff',
            'djvu' => 'image/vnd.djvu','djv' => 'image/vnd.djvu','wbmp' => 'image/vnd.wap.wbmp',
            'ras' => 'image/x-cmu-raster','pnm' => 'image/x-portable-anymap',
            'pbm' => 'image/x-portable-bitmap','pgm' => 'image/x-portable-graymap',
            'ppm' => 'image/x-portable-pixmap','rgb' => 'image/x-rgb','xbm' => 'image/x-xbitmap',
            'xpm' => 'image/x-xpixmap','xwd' => 'image/x-xwindowdump','igs' => 'model/iges',
            'iges' => 'model/iges','msh' => 'model/mesh','mesh' => 'model/mesh',
            'silo' => 'model/mesh','wrl' => 'model/vrml','vrml' => 'model/vrml',
            'css' => 'text/css','html' => 'text/html','htm' => 'text/html',
            'asc' => 'text/plain','txt' => 'text/plain','rtx' => 'text/richtext',
            'rtf' => 'text/rtf','sgml' => 'text/sgml','sgm' => 'text/sgml',
            'tsv' => 'text/tab-separated-values','wml' => 'text/vnd.wap.wml',
            'wmls' => 'text/vnd.wap.wmlscript','etx' => 'text/x-setext',
            'xsl' => 'text/xml','xml' => 'text/xml','mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg','mpe' => 'video/mpeg','qt' => 'video/quicktime',
            'mov' => 'video/quicktime','mxu' => 'video/vnd.mpegurl','avi' => 'video/x-msvideo',
            'movie' => 'video/x-sgi-movie','ice' => 'x-conference/x-cooltalk',
            'rar' => 'application/x-rar-compressed','zip' => 'application/x-zip-compressed',
            '*'=> 'application/octet-stream','docx' => 'application/msword'
        );
    }
    
    /**
     * Open an IMAP stream to a mailbox
     * 
     * @param string $host
     * @param string $port
     * @param string $user
     * @param string $pass
     * @param string $folder
     * @param string $ssl
     * @param string $pop
     * @return resource|bool
     */
    public function mailConnect($host,$port,$user,$pass,$folder="INBOX") {

        $this->_connect = imap_open("{"."$host:$port/novalidate-cert/notls"."}$folder",$user,$pass);
        if( ! $this->_connect) {
            exit('cannot connect: ' . imap_last_error());
            return false;    
        } 
        return $this->_connect;
    }
    
    /**
     * Get information about the current mailbox
     *
     * @return object|bool
     */
    public function mailInfo(){
        $this->_mailInfo = imap_mailboxmsginfo($this->_connect);
        if(!$this->_mailInfo) {
            echo "get mailInfo failed: " . imap_last_error();
            return false;
        }
        return $this->_mailInfo;
    }
    
    /**
     * Read an overview of the information in the headers of the given message
     *
     * @param string $msgRange
     * @return array
     */
    public function mailList($msgRange='')
    {
        if ($msgRange) {
            $range=$msgRange;
        } else {
            $this->mailTotalCount();
            $range = "1:".$this->_totalCount;
        }
        $overview  = imap_fetch_overview($this->_connect,$range);
        foreach ($overview  as $val) {
            $mailList[$val->msgno]=(array)$val;
        }
        return $mailList;
    }
    
    /**
     * get the total count of the current mailbox
     *
     * @return int
     */
    public function mailTotalCount(){
        $check = imap_check($this->_connect);
		$this->_totalCount = $check->Nmsgs;
		return $this->_totalCount;
    }
    
    /**
     * Read the header of the message
     *
     * @param string $msgCount
     * @return array
     */
    public function mailHeader($msgCount) {
		$mailHeader = array();
		$header     = imap_header($this->_connect,$msgCount);
		$sender     = $header->from[0];
		$replyTo    = $header->reply_to[0];
        $subject = $this->decode_mime($header->subject);
        $mailHeader = array(
			'from'        => strtolower($sender->mailbox).'@'.$sender->host,
			'fromName'    => isset( $sender->personal ) ? $sender->personal : FALSE,
			'toOther'     => strtolower($replyTo->mailbox).'@'.$replyTo->host,
			'toOtherName' => isset( $replyTo->personal ) ? $replyTo->personal : FALSE,
			'subject'     => $subject,
			'to'          => strtolower($header->toaddress),
			'date'        => $header->date,
			'id'          => $header->Msgno,
			'seen'        => $header->Unseen,
			'mailbox'     => strtolower($sender->mailbox),
        );

        return $mailHeader;
    }
    
  /**
     * decode the subject of chinese 
     * 
     * @param string $subject
     * @return sting
     */
    public function subjectDecode($subject) {
        $beginStr = substr($subject, 0, 5);
        if($beginStr == '=?ISO') {
            $separator = '=?ISO-2022-JP';
            $toEncoding = 'ISO-2022-JP';
        } else  {
            $separator = '=?GB2312';
            $toEncoding = 'GB2312';
        }
        $encode = strstr($subject, $separator);
        if ($encode) {
            $explodeArr = explode($separator, $subject);
            $length = count($explodeArr);
            $subjectArr = array();
            for($i = 0; $i < $length / 2; $i++) {
                $subjectArr[$i][] = $explodeArr[$i * 2];
                if (@$explodeArr[$i * 2 + 1]) {
                    $subjectArr[$i][] = $explodeArr[$i * 2 + 1];
                }
            }
            foreach ($subjectArr as $arr) {
                $subSubject = implode($separator, $arr);
                if (count($arr) == 1) {
                    $subSubject = $separator . $subSubject;
                }
                $begin = strpos($subSubject, "=?");
                $end = strpos($subSubject, "?=");
                $beginStr = '';
                $endStr = '';
                if ($end > 0) {
                    if ($begin > 0) {
                        $beginStr = substr($subSubject, 0, $begin);
                    }
                    if ((strlen($subSubject) - $end) > 2) {
                        $endStr = substr($subSubject, $end + 2, strlen($subSubject) - $end - 2);
                    }
                    $str = substr($subSubject, 0, $end - strlen($subSubject));
                    $pos = strrpos($str, "?");
                    $str = substr($str, $pos + 1, strlen($str) - $pos);
                    $subSubject = $beginStr . imap_base64($str) . $endStr;
                    $subSubjectArr[] = iconv ( $toEncoding, 'utf-8', $subSubject );
//                    mb_convert_encoding($subSubject, 'utf-8' ,'gb2312,ISO-2022-JP');
                }
            }
            $subject = implode('', $subSubjectArr);
        }
        return $subject;
    }

    public function decode_mime($string) {
	    $pos = strpos($string,'=?');
	    if (!is_int($pos)) {
	       return $string;
	    }
	    $preceding = substr($string, 0, $pos); // save any preceding text
	    $search = substr($string, $pos+2); /* the mime header spec says this is the longest a single encoded Word can be */
	    $d1 = strpos($search, '?');
	    if (!is_int($d1)) {
	      return $string;
	    }
	    $charset = substr($string, $pos+2, $d1); //取出字符集的定义部分
	    $search = substr($search, $d1+1); //字符集定义以后的部分＝>$search;
	    $d2 = strpos($search, '?');
	    if (!is_int($d2)) {
	        return $string;
	    }
	    $encoding = substr($search, 0, $d2); ////两个?　之间的部分编码方式　：ｑ　或　ｂ　
	    $search = substr($search, $d2+1);
	    $end = strpos($search, '?='); //$d2+1 与 $end 之间是编码了　的内容：=> $endcoded_text;
	    if (!is_int($end)) {
	      return $string;
	    }
	    $encoded_text = substr($search, 0, $end);
	    $rest = substr($string, (strlen($preceding . $charset . $encoding . $encoded_text)+6)); //+6 是前面去掉的　=????=　六个字符
	    switch ($encoding) {
	    case 'Q':
	    case 'q':
	//$encoded_text = str_replace('_', '％20', $encoded_text);
	//$encoded_text = str_replace('=', '％', $encoded_text);
	//$decoded = urldecode($encoded_text);
	     $decoded=quoted_printable_decode($encoded_text);
	     if (strtolower($charset) == 'windows-1251') {
	     $decoded = convert_cyr_string($decoded, 'w', 'k');
	     }
	    break;
	    case 'B':
	    case 'b':
	    $decoded = base64_decode($encoded_text);
	    if (strtolower($charset) == 'windows-1251') {
	     $decoded = convert_cyr_string($decoded, 'w', 'k');
	    }
	    break;
	    default:
	    $decoded = '=?' . $charset . '?' . $encoding . '?' . $encoded_text . '?=';
	    break;
	    }
	    return $preceding . $decoded . $this->decode_mime($rest);
	    //return $preceding . $decoded . $this->decode_mime($rest);  
	}
    
    /**
     * Mark a message for deletion from current mailbox
     *
     * @param string $msgCount
     */
    public function mailDelete($msgCount) {
        imap_delete($this->_connect,$msgCount);
    }
    
    /**
     * get attach of the message
     *
     * @param string $msgCount
     * @param string $path
     * @return array
     */
    public function getAttach($msgCount,$path) {
        $struckture = imap_fetchstructure($this->_connect,$msgCount);
        $attach = array();
        if($struckture->parts) {
            foreach($struckture->parts as $key => $value) {
                $encoding=$struckture->parts[$key]->encoding;
                if($struckture->parts[$key]->ifdparameters) {
                    $name=$struckture->parts[$key]->dparameters[0]->value;
                    $message = imap_fetchbody($this->_connect,$msgCount,$key+1);
                    if ($encoding == 0) {
                        $message = imap_8bit($message);    
                    } else if ($encoding == 1){
                        $message = imap_8bit ($message);
                    } else if ($encoding == 2) {
                        $message = imap_binary ($message);
                    } else if ($encoding == 3) {
                        $message = imap_base64 ($message);
                    } else if ($encoding == 4) {
                        $message = quoted_printable_decode($message);
                    }
                    $this->downAttach($path,$name,$message);;
                    $attach[] = $name;
                }
                if($struckture->parts[$key]->parts) {
                    foreach($struckture->parts[$key]->parts as $keyb => $valueb) {
                        $encoding=$struckture->parts[$key]->parts[$keyb]->encoding;
                        if($struckture->parts[$key]->parts[$keyb]->ifdparameters){
                            $name=$struckture->parts[$key]->parts[$keyb]->dparameters[0]->value;
                            $partnro = ($key+1).".".($keyb+1);
                            $message = imap_fetchbody($this->_connect,$msgCount,$partnro);
                            if ($encoding == 0) {
                                $message = imap_8bit($message);
                            } else if ($encoding == 1) {
                                $message = imap_8bit ($message);
                            } else if ($encoding == 2) {
                                $message = imap_binary ($message);
                            } else if ($encoding == 3) {
                                $message = imap_base64 ($message);
                            } else if ($encoding == 4) {
                                $message = quoted_printable_decode($message);
                            }
                            $this->downAttach($path,$name,$message);
                            $attach[] = $name;
                        }
                    }
                }                
            }
        }
        
        return $attach;
    }
    
    /**
     * download the attach of the mail to localhost
     *
     * @param string $filePath
     * @param string $message
     * @param string $name
     */
    public function downAttach($filePath,$name,$message) {
        if(is_dir($filePath)) {
            $fileOpen = fopen($filePath.$name,"w");
        } else {
            mkdir($filePath);
        }
        fwrite($fileOpen,$message);
        fclose($fileOpen);
    }
    
    /**
     * click the attach link to download the attach
     *
     * @param string $id
     */
    public function getAttachData($id,$filePath,$fileName) {
        $nameArr = explode('.',$fileName);
        $length = count($nameArr);
        $contentType = $this->_contentType[$nameArr[$length-1]];
        if(!$contentType) {
            $contentType = $this->_contentType['*'];
        }
          $filePath = chop($filePath);
         if($filePath != ''){
            if(substr($filePath,strlen($filePath)-1,strlen($filePath)) != '/') {
                $filePath .= '/';
            }
               $filePath .= $fileName;
        } else {
            $filePath = $fileName;
          }
          if(!file_exists($filePath)){
            echo 'the file is not exsit';
            return false;
          }
        $fileSize = filesize($filePath);
          header("Content-type: ".$contentType);
          header("Accept-Range : byte ");
          header("Accept-Length: $fileSize");
          header("Content-Disposition: attachment; filename=".$fileName);
          $fileOpen= fopen($filePath,"r");
          $bufferSize = 1024;
          $curPos = 0;
          while(!feof($fileOpen)&&$fileSize-$curPos>$bufferSize) {
                $buffer = fread($fileOpen,$bufferSize);
                echo $buffer;
            $curPos += $bufferSize;
        }
          $buffer = fread($fileOpen,$fileSize-$curPos);
         echo $buffer;
          fclose($fileOpen);
          return true;
    }
    
    /**
     * get the body of the message
     *
     * @param string $msgCount
     * @return string
     */
    public function getBody($msgCount) {
        $body = $this->getPart($msgCount, "TEXT/HTML");
        if ($body == '') {
            $body = $this->getPart($msgCount, "TEXT/PLAIN");
        }
        if ($body == '') {
            return '';
        }
        return $body;
    }
    
    /**
     * Read the structure of a particular message and fetch a particular
     * section of the body of the message
     *
     * @param string $msgCount
     * @param string $mimeType
     * @param object $structure
     * @param string $partNumber
     * @return string|bool
     */
    private function getPart($msgCount, $mimeType, $structure = false, $partNumber = false) {
        if(!$structure) {
            $structure = imap_fetchstructure($this->_connect, $msgCount);
        }
        if($structure) {
            if($mimeType == $this->getMimeType($structure)) {
                if(!$partNumber) {
                    $partNumber = "1";
                }
                $fromEncoding = $structure->parameters[0]->value;
                $text = imap_fetchbody($this->_connect, $msgCount, $partNumber);
                if($structure->encoding == 3) {
                    $text =  imap_base64($text);
                } else if($structure->encoding == 4) {
                    $text =  imap_qprint($text);
                }
                $text = mb_convert_encoding($text,'utf-8',$fromEncoding);
                return $text;
            }
            if($structure->type == 1) {
                while(list($index, $subStructure) = each($structure->parts)) {
                    $prefix = ($partNumber) ? $partNumber . '.' : '';
                    $data = $this->getPart($msgCount, $mimeType, $subStructure, $prefix . ($index + 1));
                    if($data){
                        return $data;
                    }
                }
            }
        }
        return false;
    }
    
    /**
     * get the subtype and type of the message structure
     *
     * @param object $structure
     */
    private function getMimeType($structure) {
        $mimeType = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
        if($structure->subtype) {
            return $mimeType[(int) $structure->type] . '/' . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }
    
    /**
     * put the message from unread to read
     *
     * @param string $msgCount
     * @return bool
     */
    public function mailRead($msgCount) {
        $status = imap_setflag_full($this->_connect, $msgCount , "//Seen");
        return $status;
    }
    
    /**
     * Close an IMAP stream
     */
    public function closeMail() {
        imap_close($this->_connect,CL_EXPUNGE);
    }
}
?>
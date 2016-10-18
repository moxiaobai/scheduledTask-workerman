<?php
/**
 * Helper_Filter
 *
 * @category Helper
 * @package  Helper_Filter
 * @version  1.0 
 */
class Helper_Filter{

	/**
	 * cutString 裁剪字符串
	 * 
	 * @param string $str 字符串
	 * @param interger $len 截取长度
	 * @param string   $end 截取后末尾显示
	 * @return string
	 */

	static function cutString($str, $len, $end = '...') {
	    $i=$j=0;
	    $strlen = mb_strlen($str, 'UTF-8');

	    for($i=0; $i < $strlen; $i++) {
	        if(strlen(mb_substr($str, $i, 1, 'UTF-8')) > 1) {
	            $j+=2;
	        } else {
	            $j++;
	        }

	        if($j >= $len) break;
	    }

	    $returnStr  = mb_substr($str, 0, ++$i, 'UTF-8');
	    $returnStr .= $j < $len ? '' : $end;

	    return $returnStr;
	}

	/**
	 * Format 转义字符，过滤XSS，HTML等
	 * 
	 * @param mixed $data 字符串或者数组格式
	 * @param boolean $escape 过滤HTML
	 * @param boolean $xss 过滤XSS攻击
	 * @return mixed
	 */
	static function format($data, $escape=FALSE, $xss=FALSE) {
		if ( ! get_magic_quotes_gpc() ) {
			$data = is_array($data) ? array_map('self::format', $data) : $data;
		}

		if ( $escape === TRUE) {
			$data = self::escape($data);
		}

		if ( $xss === TRUE) {
			$data = self::xss($data);
		}
		return $data;
	}

	/**
	 * Escape 一些预定义的字符转换为 HTML 实体
	 * 
	 * @param mixed $data 字符串或者数组格式
	 * @return mixed
	 */
	static function escape($data, $quotestyle=ENT_COMPAT) {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]);

	    		$data[self::escape($key)] = self::escape($value);
	  		}
		} else {
	  		$data = htmlspecialchars($data, $quotestyle, 'UTF-8');
		}

		return $data;
	}

	/**
	 * Xss 过滤Xss攻击字符串
	 * 
	 * @param string $string 输入字符串
	 * @return string
	 */
	static function xss($string, $allowed_tags = array('a', 'em', 'strong', 'cite', 'blockquote', 'code', 'ul', 'ol', 'li', 'dl', 'dt', 'dd')) {
		// Only operate on valid UTF-8 strings. This is necessary to prevent cross
		// site scripting issues on Internet Explorer 6.

		if (!(preg_match('/^./us', $string) == 1)) {
			return '';
		}
		// Store the text format.
		self::_xssSplit($allowed_tags, TRUE);
		// Remove NULL characters (ignored by some browsers).
		$string = str_replace(chr(0), '', $string);
		// Remove Netscape 4 JS entities.
		$string = preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%', '', $string);

		// Defuse all HTML entities.
		$string = str_replace('&', '&amp;', $string);
		// Change back only well-formed entities in our whitelist:
		// Decimal numeric entities.
		$string = preg_replace('/&amp;#([0-9]+;)/', '&#\1', $string);
		// Hexadecimal numeric entities.
		$string = preg_replace('/&amp;#[Xx]0*((?:[0-9A-Fa-f]{2})+;)/', '&#x\1', $string);
		// Named entities.
		$string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]*;)/', '&\1', $string);

		return preg_replace_callback('%
		(
		<(?=[^a-zA-Z!/])  # a lone <
		|                 # or
		<!--.*?-->        # a comment
		|                 # or
		<[^>]*(>|$)       # a string that starts with a <, up until the > or the end of the string
		|                 # or
		>                 # just a >
		)%x', 'self::_xssSplit', $string);
	}

	/**
	 * 防止XSS攻击
	 *
	 * @param string $val 输入字符串
	 */
	static function removeXSS($val) {
	   $val     = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);  
	   $search  = 'abcdefghijklmnopqrstuvwxyz';
	   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   $search .= '1234567890!@#$%^&*()';
	   $search .= '~`";:?+/={}[]-_|\'\\';
	   for ($i = 0; $i < strlen($search); $i++) {
		  $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
		  $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
	   } 
	   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	   $ra  = array_merge($ra1, $ra2); 
	   $found = true;
	   while ($found == true) {
		  $val_before = $val;
		  for ($i = 0; $i < sizeof($ra); $i++) {
			 $pattern = '/';
			 for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
				   $pattern .= '(';
				   $pattern .= '(&#[xX]0{0,8}([9ab]);)';
				   $pattern .= '|';
				   $pattern .= '|(&#0{0,8}([9|10|13]);)';
				   $pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			 }
			 $pattern .= '/i';
			 $replacement = substr($ra[$i], 0, 2).'<!--XSS-->'.substr($ra[$i], 2);
			 $val = preg_replace($pattern, $replacement, $val);
			 if ($val_before == $val) {
				$found = false;
			 }
		  }
	   }  
	   return $val;
	}

	static function _xssSplit($m, $store = FALSE) {
		static $allowed_html;

		if ($store) {
			$allowed_html = array_flip($m);
			return;
		}

		$string = $m[1];

		if (substr($string, 0, 1) != '<') {
			// We matched a lone ">" character.
			return '&gt;';
		} elseif (strlen($string) == 1) {
			// We matched a lone "<" character.
			return '&lt;';
		}

		if (!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9]+)([^>]*)>?|(<!--.*?-->)$%', $string, $matches)) {
			// Seriously malformed.
			return '';
		}

		$slash = trim($matches[1]);
		$elem = &$matches[2];
		$attrlist = &$matches[3];
		$comment = &$matches[4];

		if ($comment) {
			$elem = '!--';
		}

		if (!isset($allowed_html[strtolower($elem)])) {
			// Disallowed HTML element.
			return '';
		}

		if ($comment) {
			return $comment;
		}

		if ($slash != '') {
			return "</$elem>";
		}

		// Is there a closing XHTML slash at the end of the attributes?
		$attrlist = preg_replace('%(\s?)/\s*$%', '\1', $attrlist, -1, $count);
		$xhtml_slash = $count ? ' /' : '';

		// Clean up attributes.
		$attr2 = implode(' ', self::_xssAttributes($attrlist));
		$attr2 = preg_replace('/[<>]/', '', $attr2);
		$attr2 = strlen($attr2) ? ' ' . $attr2 : '';

		return "<$elem$attr2$xhtml_slash>";
	}

	/**
	 * Processes a string of HTML attributes.
	 *
	 * @return
	 *   Cleaned up version of the HTML attributes.
	 */
	static function _xssAttributes($attr) {
		$attrarr = array();
		$mode = 0;
		$attrname = '';

		while (strlen($attr) != 0) {
			// Was the last operation successful?
			$working = 0;

			switch ($mode) {
			  	case 0:
			    	// Attribute name, href for instance.
					if (preg_match('/^([-a-zA-Z]+)/', $attr, $match)) {
						$attrname = strtolower($match[1]);
						$skip = ($attrname == 'style' || substr($attrname, 0, 2) == 'on');
						$working = $mode = 1;
						$attr = preg_replace('/^[-a-zA-Z]+/', '', $attr);
					}
			    	break;

				case 1:
					// Equals sign or valueless ("selected").
					if (preg_match('/^\s*=\s*/', $attr)) {
						$working = 1; $mode = 2;
						$attr = preg_replace('/^\s*=\s*/', '', $attr);
						break;
					}

					if (preg_match('/^\s+/', $attr)) {
						$working = 1; $mode = 0;
						if (!$skip) {
							$attrarr[] = $attrname;
						}
						$attr = preg_replace('/^\s+/', '', $attr);
					}
					break;

				case 2:
					// Attribute value, a URL after href= for instance.
					if (preg_match('/^"([^"]*)"(\s+|$)/', $attr, $match)) {
						$thisval = self::_xssBadProtocol($match[1]);

						if (!$skip) {
							$attrarr[] = "$attrname=\"$thisval\"";
						}
						$working = 1;
						$mode = 0;
						$attr = preg_replace('/^"[^"]*"(\s+|$)/', '', $attr);
						break;
					}

					if (preg_match("/^'([^']*)'(\s+|$)/", $attr, $match)) {
						$thisval = self::_xssBadProtocol($match[1]);

						if (!$skip) {
							$attrarr[] = "$attrname='$thisval'";
						}
						$working = 1; $mode = 0;
						$attr = preg_replace("/^'[^']*'(\s+|$)/", '', $attr);
						break;
					}

					if (preg_match("%^([^\s\"']+)(\s+|$)%", $attr, $match)) {
						$thisval = self::_xssBadProtocol($match[1]);

						if (!$skip) {
						$attrarr[] = "$attrname=\"$thisval\"";
						}
						$working = 1; $mode = 0;
						$attr = preg_replace("%^[^\s\"']+(\s+|$)%", '', $attr);
					}
			    	break;
			}

			if ($working == 0) {
			  // Not well formed; remove and try again.
			  	$attr = preg_replace('/
			    ^
			    (
			    "[^"]*("|$)     # - a string that starts with a double quote, up until the next double quote or the end of the string
			    |               # or
			    \'[^\']*(\'|$)| # - a string that starts with a quote, up until the next quote or the end of the string
			    |               # or
			    \S              # - a non-whitespace character
			    )*              # any number of the above three
			    \s*             # any number of whitespaces
			    /x', '', $attr);
			  	$mode = 0;
			}
		}

		// The attribute list ends with a valueless attribute like "selected".
		if ($mode == 1 && !$skip) {
			$attrarr[] = $attrname;
		}
		return $attrarr;
	}


	static function _xssBadProtocol($string, $decode = TRUE) {
		// Get the plain text representation of the attribute value (i.e. its meaning).
		// @todo Remove the $decode parameter in Drupal 8, and always assume an HTML
		//   string that needs decoding.
		if ($decode) {
			$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		}
		return htmlspecialchars(slef::stripProtocols($string), ENT_QUOTES, 'UTF-8');
	}

	static function stripProtocols($uri) {
  		static $allowed_protocols;

  		if (!isset($allowed_protocols)) {
    		$allowed_protocols = array_flip(variable_get('filter_allowed_protocols', array('ftp', 'http', 'https', 'irc', 'mailto', 'news', 'nntp', 'rtsp', 'sftp', 'ssh', 'tel', 'telnet', 'webcal')));
  		}

  		// Iteratively remove any invalid protocol found.
  		do {
		    $before = $uri;
		    $colonpos = strpos($uri, ':');
			if ($colonpos > 0) {
				// We found a colon, possibly a protocol. Verify.
				$protocol = substr($uri, 0, $colonpos);
				// If a colon is preceded by a slash, question mark or hash, it cannot
				// possibly be part of the URL scheme. This must be a relative URL, which
				// inherits the (safe) protocol of the base document.
				if (preg_match('![/?#]!', $protocol)) {
					break;
				}
				// Check if this is a disallowed protocol. Per RFC2616, section 3.2.3
				// (URI Comparison) scheme comparison must be case-insensitive.
				if (!isset($allowed_protocols[strtolower($protocol)])) {
					$uri = substr($uri, $colonpos + 1);
				}
			}
  		} while ($before != $uri);

  		return $uri;
	}
}
?>

<?php

/**
 * 分页类
 *
 * 超强分页类，四种分页模式，默认采用类似baidu,google的分页风格。
 * 2.0增加功能：支持自定义风格，自定义样式，同时支持PHP4和PHP5。
 *
 * @author: feifengxlq (最后修改: 2006-11-4)
 * @version: 2.0
 * @since:2006-5-31
 * @example:
 *  模式四种分页模式：
 *  require_once '../libs/classes/page.class.php';
 *  $page = new page(array('total'=>1000, 'perpage'=>20));
 *  echo 'mode:1<br>'.$page->show();
 *  echo '<hr>mode:2<br>'.$page->show(2);
 *  echo '<hr>mode:3<br>'.$page->show(3);
 *  echo '<hr>mode:4<br>'.$page->show(4);
 *  echo '<hr>mode:9<br>'.$page->show(9);  //论坛模式
 *  开启AJAX：
 *  $ajaxpage=new page(array('total'=>1000, 'perpage'=>20, 'ajax'=>'ajax_page' ,'page_name'=>'test'));
 *  echo 'mode:1<br>'.$ajaxpage->show();
 *  采用继承自定义分页显示模式：
 *  demo:http://www.phpobject.net/blog
 */

class Page {

    public $page_name         = "page";  // page标签，用来控制url页。比如说xxx.php?PB_page=2中的PB_page
    public $next_page         = '下一页';        // 下一页
    public $pre_page          = '上一页';         // 上一页
    public $first_page        = '第一页';   // 首页
    public $last_page         = '最后一页';     // 尾页
    public $pre_bar           = '上一页';         // 上一分页条
    public $next_bar          = '下一页';        // 下一分页条
    public $format_left       = '';
    public $format_right      = '';
    public $is_ajax           = false;       //是否支持AJAX分页模式
    public $current_class     = 'current'; //当前页class
    private $pagebarnum       = 7;      //控制记录条的个数。
    private $totalpage        = 0;        //总页数
    private $ajax_action_name = ''; //AJAX动作名
    private $nowindex         = 1;         //当前页
    private $url              = '';              //url地址头
    private $offset           = 0;
	private $isreplace        = false; //使用采用替换url的方式
    
    private $page_size        = 0;
    
    /**
     * 构造函数
     * 
     * @param array $array
     * @example $array['total'], $array['perpage'], $array['nowindex'], $array['url'], $array['ajax']...
     */
    public function __construct($array,$autouri=false) {
        if (is_array($array)) {
            if (!array_key_exists('total', $array)) {
                $this->error(__FUNCTION__, 'need a param of total');
            }
            $total = intval($array['total']);
            $perpage = (array_key_exists('perpage', $array)) ? intval($array['perpage']) : 10;
            $nowindex = (array_key_exists('nowindex', $array)) ? intval($array['nowindex']) : '';
            $url = (array_key_exists('url', $array)) ? $array['url'] : '';

			$this->isreplace = (array_key_exists('isreplace', $array)) ? $array['isreplace'] : false;
        } else {
            $total = $array;
            $perpage = 10;
            $nowindex = '';
            $url = '';
        }
        if ((!is_int($total))||($total<0)) {
            $this->error(__FUNCTION__, $total.' is not a positive integer!');
        }
        if ((!is_int($perpage))||($perpage<=0)) {
            $this->error(__FUNCTION__, $perpage.' is not a positive integer!');
        }
        if (!empty($array['page_name'])) {
            $this->set('page_name', $array['page_name']); // 设置 pagename
        }
        $this->_set_nowindex($nowindex); // 设置当前页
        $this->_set_url($url); // 设置链接地址
        $this->total = $total; // 设置总记录数
        $this->totalpage = ceil($total / $perpage);
        //$this->offset = ($this->nowindex - 1) * $this->perpage;
        $this->offset = ($this->nowindex - 1) * $perpage;
        
        $this->page_size = $perpage;

        $this->params = '';
        if($autouri===true){
            if ( strpos($_SERVER['REQUEST_URI'], '?') ) {
                $this->params = explode('?', $_SERVER['REQUEST_URI']);
                $this->params = '?' . end($this->params);
            }
        }

        if (!empty($array['ajax'])) {
            $this->open_ajax($array['ajax']); // 打开AJAX模式
        }
    }

    /**
     * 设定类中指定变量名的值
     * 如果改变量不属于这个类，将throw一个exception
     *
     * @param string $var
     * @param string $value
     */
    public function set($var, $value) {
        if (in_array($var, get_object_vars($this))) {
            $this->$var = $value;
        } else {
            $this->error(__FUNCTION__, $var." does not belong to PB_Page!");
        }
    }

    /**
     * 打开倒AJAX模式
     *
     * @param string $action 默认ajax触发的动作
     */
    public function open_ajax($action) {
        $this->is_ajax = true;
        $this->ajax_action_name = $action;
    }
    
    /**
     * 获取显示"下一页"的代码
     *
     * @param string $style
     * @return string
     */
    public function next_page($style = '') {
        if ($this->nowindex < $this->totalpage) {
            return $this->_get_text($this->_get_link($this->_get_url($this->nowindex+1), $this->next_page, $style));
        }
        return $this->_get_text('<a class="'.$style.'">'.$this->next_page.'</a>');
    }
 
    /**
     * 获取显示“上一页”的代码
     *
     * @param string $style
     * @return string
     */
    public function pre_page($style = '') {
        if ($this->nowindex > 1) {
            return $this->_get_text($this->_get_link($this->_get_url($this->nowindex-1), $this->pre_page, $style));
        }
        return $this->_get_text('<a class="'.$style.'">'.$this->pre_page.'</a>');
    }
 
    /**
     * 获取显示“首页”的代码
     *
     * @return string
     */
    public function first_page($style = '') {
        if ($this->nowindex == 1) {
            return $this->_get_text('<a class="'.$style.'">'.$this->first_page.'</a>');
        }
        return $this->_get_text($this->_get_link($this->_get_url(1), $this->first_page, $style));
    }
 
    /**
     * 获取显示“尾页”的代码
     *
     * @return string
     */
    public function last_page($style = '') {
        if ($this->nowindex == $this->totalpage) {
            return $this->_get_text('<a class="'.$style.'">'.$this->last_page.'</a>');
        }
        return $this->_get_text($this->_get_link($this->_get_url($this->totalpage), $this->last_page, $style));
    }
 

    /**
     * nowbar 
     * @access public
     * 
     * @param string $classname 增加Class
     * @param string $ext       是否需要省略号链接首页和尾页
     * @return string
     */
    public function nowbar($classname = '', $ext = '') {
        $plus = ceil($this->pagebarnum / 2);

        if ($this->pagebarnum - $plus + $this->nowindex > $this->totalpage) {
            $plus = $this->pagebarnum - $this->totalpage + $this->nowindex;
        }
        $begin  = $this->nowindex - $plus + 1;
        $begin  = $begin >= 1 ? $begin : 1;
        $return = '';

        if ( $ext && $this->totalpage > $this->pagebarnum && $begin != 1 ) {
            $return .= $this->_get_text($this->_get_link($this->_get_url(1), 1, $classname)) . "<a>{$ext}</a>";
        }

        for($i = $begin; $i < $begin + $this->pagebarnum; $i++) {
            if ($i <= $this->totalpage) {
                if ($i != $this->nowindex) {
                    $return .= $this->_get_text($this->_get_link($this->_get_url($i), $i, $classname));
                } else {
                    $return .= $this->_get_text("<a class=\"{$this->current_class}\">{$i}</a>");
                }
            } else {
                break;
            }
        }

        if ( $ext && $this->totalpage > $this->pagebarnum && $begin + $this->pagebarnum != $this->totalpage ) {
            $return .= "<a>{$ext}</a>" . $this->_get_text($this->_get_link($this->_get_url($this->totalpage), $this->totalpage, $classname)) ;
        }
        unset($begin);
        return $return;
    }
    /**
     * 获取显示跳转按钮的代码
     *
     * @return string
     */
    public function select_page() {
        $return = '<select name="PB_Page_Select" onchange="window.location.href=\''.$this->url.'\'+this.options[this.selectedIndex].value">';
        for ($i = 1; $i <= $this->totalpage; $i++) {
            if ($i == $this->nowindex) {
                $return .= '<option value="'.$i.'" selected>'.$i.'</option>';
            } else {
                $return .= '<option value="'.$i.'">'.$i.'</option>';
            }
        }
        unset($i);
        $return .= '</select>';
        return $return;
    }
 
    /**
     * 获取mysql 语句中limit需要的值
     *
     * @return string
     */
    public function offset() {
        return $this->offset;
    }
 
    /**
     * 控制分页显示风格（你可以增加相应的风格）
     *
     * @param int $mode
     * @return string
     */
    public function show($mode = 1) {
        if($this->totalpage<=0){
            $this->totalpage = 1;
        }
        switch ($mode) {
            case '1': {
                $this->next_page = '>>';
                $this->pre_page  = '<<';
                return $this->pre_page().$this->nowbar().$this->next_page();
                break;
            }
            case '2': {
                $this->next_page  = 'Next';
                $this->pre_page   = 'Prev';
                $this->first_page = 'Frist';
                $this->last_page  = 'Last';
                return $this->first_page()."&nbsp;".$this->pre_page()."&nbsp;".'[Page'.$this->nowindex.']'."&nbsp;".$this->next_page()."&nbsp;".$this->last_page()."&nbsp;".'GOTO'.$this->select_page();
                break;
            }
            case '3': {
                $this->next_page  = 'Next';
                $this->pre_page   = 'Prev';
                $this->first_page = 'Frist';
                $this->last_page  = 'Last';
                return $this->first_page()."&nbsp;".$this->pre_page()."&nbsp;".$this->next_page()."&nbsp;".$this->last_page()."&nbsp;&nbsp;&nbsp;total：".$this->totalpage."&nbsp;page&nbsp;&nbsp;record：".$this->total.'&nbsp;&nbsp;GOTO'.$this->select_page();
                break;
            }
            case '4': {
                $this->next_page = '下一页';
                $this->pre_page = '上一页';
                return '<a href="javascript:;">' . $this->nowindex . '/' . $this->totalpage . '</a>' . $this->pre_page().$this->nowbar().$this->next_page();
                break;
            }
            case '5': {
                $this->next_page = '下一页';
                $this->pre_page = '上一页';
                return '<a href="javascript:;">' . $this->nowindex . '/' . $this->totalpage . '</a>' . $this->pre_page().$this->next_page();
                break;
            }
			case '6': { //运营后台
                $this->next_page  = '下页';
                $this->pre_page   = '上页';
                $this->first_page = '首页';
                $this->last_page  = '尾页';
                return '<a href="javascript:;">' . $this->nowindex . '/' . $this->totalpage . '</a>' . $this->first_page().$this->pre_page().$this->nowbar().$this->next_page().$this->last_page();
                break;
            }

            case '7': { //
                $this->next_page  = '&gt;';
                $this->pre_page   = '&lt;';
                $this->first_page = '首页';
                $this->last_page  = '尾页';
                return '<a href="javascript:;">' . $this->nowindex . '/' . $this->totalpage . '</a>' . $this->first_page().$this->pre_page().$this->nowbar().$this->next_page().$this->last_page();
                break;
            }

            case '10': { //全站论坛模式
                $this->format_left  = '<li>';
                $this->format_right = '</li>';
                $this->next_page  = '下页';
                $this->pre_page   = '上页';
                $this->pagebarnum = 11;
                return $this->pre_page('prev') . $this->nowbar('', '…')
                    .'<li><label><input type="text" class="input-page" title="输入页码，按回车快速跳转" value="'.$this->nowindex.'" onkeydown="if(event.keyCode==13) {window.location=\''.$this->_get_url('\'+this.value+\'').$this->params.'\';}" /> / ' . $this->totalpage . '页</label></li>'
                    . $this->next_page('next');
                break;
            }

            case '11': { //前台模式
                $this->format_left  = '<li>';
                $this->format_right = '</li>';
                $this->next_page    = '&gt;';
                $this->pre_page     = '&lt;';
                $this->first_page   = '首页';
                $this->pagebarnum   = 6;
                return "<ul>". $this->first_page('prev') . $this->pre_page() . $this->nowbar() . $this->next_page()."</ul>";
                break;
            }
            case '12': { //手机端
                $this->next_page    = '';
                $this->pre_page     = '';
                $html = '';
                if($this->totalpage > 1) {
                    $html  =  $this->pre_page('previous-page') . $this->next_page('next-page');
                }

                return $html;
                break;
            }
        }
    }

    /**
     * 设置url头地址
     * 
     * @param: string $url
     * @return boolean
     */
    private function _set_url($url = '') {
        if (!empty($url)) {
            //手动设置
            $this->url = $url."";
        }
    }
 
    /**
     * 设置当前页面
     * 
     * @param int $nowindex 当前页码
     */
    private function _set_nowindex($nowindex) {
        if (empty($nowindex)) {
            // 系统获取
            if (isset($_GET[$this->page_name])) {
                $this->nowindex = intval($_GET[$this->page_name]);
            }
        } else {
            //手动设置
            $this->nowindex = intval($nowindex);
        }
    }
  
    /**
     * 为指定的页面返回地址值
     *
     * @param int $pageno
     * @return string $url
     */
    private function _get_url($pageno = 1) {
		$url = $this->url . $pageno . $this->params;
		if($this->isreplace){
			$url = str_replace('#page#', $pageno, $this->url). $this->params;
		}
        /**
         * 使用modifyUrl()处理后返回
         *
         * @edit by: Voice - 2013-06-01
         */
        return $this->modifyUrl($url, 'page', $pageno);
        return $this->url . $pageno . $this->params;
    }
 
    /**
     * 获取分页显示文字
     * 比如说默认情况下_get_text('<a href="">1</a>')将返回[<a href="">1</a>]
     *
     * @param string $str
     * @return string $url
     */
    private function _get_text($str) {
        return $this->format_left.$str.$this->format_right;
    }
 
    /**
     * 获取链接地址
     * 
     * @param string $url URL
     * @param string $text 文本
     * @param string $style 样式
     * @return string
     */
    private function _get_link($url, $text, $style = '') {
        $style = empty($style) ? '' : 'class="'.$style.'"';
        if ($this->is_ajax) {
            // 如果是使用AJAX模式
            return '<a '.$style.' href="javascript:'.$this->ajax_action_name.'(\''.$url.'\')">'.$text.'</a>';
        } else {
            return '<a '.$style.' href="'.$url.'">'.$text.'</a>';
        }
    }

    /**
     * 出错处理方式
     * @param string $function 出错的函数
     * @param string $errormsg 错误信息
     */
    private function error($function, $errormsg) {
        die('Error in file <b>'.__FILE__.'</b> ,Function <b>'.$function.'()</b> :'.$errormsg);
    }

    /**
     * 增加URL参数的处理,避免参数重复存在
     *
     * @author VoIce
     * @since 2013-06-01
     * @param string $url URL字段
     * @param string $param 被更改的参数
     * @param string $value 参数的新值
     * @return string 处理过的URL
     */
    private function modifyUrl($string, $param, $value) {
        $arrParam = explode('?', $string);
        //如没有存在?段则返回
        if(count($arrParam) < 2) {
            return $string;
        }
        //将非参数段移出
        $url = array_shift($arrParam);

        $strParam = count($arrParam) > 1 ? implode('&', $arrParam) : current($arrParam);
        $arrParam = explode('&', $strParam);

        foreach($arrParam as $v) {
            list($key, $val) = explode('=', $v);
            if(empty($val)) continue;
            $newParam[$key] = "{$key}={$val}";
            //判断是否是更改的参数
            if($key == $param) {
                $newParam[$key] = "{$key}={$value}";
            }
        }

        //生成新的URL
        if(isset($newParam) && count($newParam) > 0) {
            $string = $url.'?'.implode('&', $newParam);
        } 
        return $string;
    }

}
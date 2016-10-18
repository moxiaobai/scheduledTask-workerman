<?php
/**
 * Helper_Form  
 *
 */
class Helper_Form {
    
    /**
     * option
     * 
     * @access public
     * @static
     * @param array $array          数据源.
     * @param mixed $selected_key   被选中key.
     * @param mixed $default_option 默认选项.
     * @return string.
     */
    public static function option($array, $selected_key=NULL, $default_option=NULL) {
        $html = '';
        if ( $default_option ) 
            $html .= '<option value="">' . $default_option . '</option>';
        
        foreach ($array AS $key => $val) {
            $selected = ($selected_key === $key) ? " selected" : '';
            $html    .= "<option value=\"{$key}\"{$selected}>{$val}</option>";
        }
        return $html;
    }


    /**
     * select
     *
     * @access public
     * @static
     * @param mixed $id             select名称和id.
     * @param mixed $array          数据源.
     * @param mixed $selected_key   被选中key.
     * @param mixed $default_option 默认选项.
     * @param mixed $callback       select回调函数.
     * @return string.
     */
    public static function select($id, $array, $selected_key=NULL, $default_option=NULL,  $callback=NULL) {
    	$callback_html = '';
    	if( ! is_null($callback) )
            $callback_html .= ' onchange="return ' . $callback . ';"';
    
        $html  = '<select id="' . $id . '" name="' . $id . '" ' . $callback_html . '>';
        $html .= self::option($array, $selected_key, $default_option);
        $html .= '</select>';
        return $html;
    }


    /**
     * radio
     *
     * @access public
     * @static
     * @param mixed  $name        单选框名称.
     * @param mixed  $array       数据源.
     * @param mixed  $checked_key 被选中key.
     * @param string $class       默认Label Class
     * @return string.
     */
    public static function radio($name, $array, $checked_key=NULL, $class="radio") {
    	$html = '';
        foreach ($array as $key => $val) {
            $checked = ($checked_key === $key) ? ' checked' : '';
            $html .= "
                <label class=\"{$class}\">
                    <input type=\"radio\" name=\"{$name}\" value=\"{$key}\"{$checked}>{$val}
                </label>"; 
        }
        return $html;
    }


    /**
     * checkbox
     *
     * @access public
     * @static
     * @param mixed  $name        复选框名称.
     * @param mixed  $array       数据源.
     * @param array  $checked_key 被选中key数组.
     * @param string $class       默认Label Class
     * @return string.
     */
    public static function checkbox($name, $array, $checked_key=array(), $class="checkbox") {
        $html = '';
        foreach ($array as $key => $val) {
            $checked = in_array($key, $checked_key ) ? ' checked' : '';
            $html .= "
                <label class=\"{$class}\">
                    <input type=\"checkbox\" name=\"{$name}\" value=\"{$key}\"{$checked}>{$val}
                </label>"; 
        }
        return $html;
    }
}
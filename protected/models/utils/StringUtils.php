<?php

/**
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class StringUtils {

    public static function stripTags($str, $allowable_tags = NULL) {
        return strip_tags($str, $allowable_tags);
    }

    public static function cutOnWord($string, $length = 40, $correct_html = true) {
        $sourceString = $string;
        $string.=' ';
        $string = mb_substr($string, 0, $length + 1, 'UTF-8');
        $pos = mb_strrpos($string, ' ', 'UTF-8');
        $string = mb_substr($string, 0, $pos, 'UTF-8');
        if ($sourceString != $string) {
            $string.=' ...';
        }
        if($correct_html){
            $string = StringUtils::correctHtml($string);
        };
        return $string;
    }
    
    public static function getLanguageName($lang){
        $langs = array(
            'ru' => 'Russian', 'en' => 'English', 'es' => 'Spanish'
        );
        return Yii::t('site', $langs[$lang]);
    }

    public static function prepareHtml($string) {
        return StringUtils::correctHtml($string);
    }

    public static function cutOnWordConf($string, $length = 40) {
        return StringUtils::cutOnWord($string, $length);
    }

    public static function firstUChar($string) {
        return mb_strtoupper(mb_substr($string, 0, 1, 'UTF-8'), 'UTF-8');
    }
    
    public static function firstUCharString($string) {
        return mb_strtoupper(mb_substr($string, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($string, 1, mb_strlen($string), 'UTF-8');
    }

    public static function commaSeparatedStrings($arr) {
        $list = '';
        $prefix = '';
        foreach ($arr as $elem) {
            $list .= $prefix . '"' . $elem . '"';
            $prefix = ', ';
        }
        return $list;
    }

    public static function hideEmail($string) {
        $js = 1;
        $link = 1;
        if ($js) {
            $output = "<script type='text/javascript'><!--
			document.write('";
        }
        $encode = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $encode .= '&#' . ord($char) . ';';
            if ($js) {
                if (in_array($char, array('.', '@'))) {
                    //  break strings after ats and dots
                    $encode .= "'+'";
                }
            }
        }
        if ($link && !$js) {
            //  ascii in this next line is "mailto:"
            $output .= "<a href=\"&#109;&#97;&#105;&#108;&#116;&#111;&#58;$encode\">$encode<\/a>";
        } elseif ($link && $js) {
            $output .= "<a href=\"&#109;&#97;&#105;&#108;&#116;&#111;&#58;'+'$encode'+'\">'+'$encode'+'<\/a>";
        } else {
            $output .= $encode;
        }

        if ($js) {
            $output .= "');
			//-->
			</script>";
        }
        return $output;
    }

    public static function asArray($str) {
        if (is_array($str)) {
            return $str;
        }
        $res = array();
        $arr = split(',', $str);
        foreach ($arr as $s) {
            $res[] = trim($s);
        }
        return $res;
    }

    
    public static function map_assoc($array) {
        $result = array();
        foreach ($array as $value) {
            $result[$value] = $value;
        }
        return $result;
    }

    /**
     *  Scan input and make sure that all HTML tags are properly closed and nested.
     */
    public static function correctHtml($text) {
        //  prepare tag lists.
        static $no_nesting, $single_use;
        if (!isset($no_nesting)) {
            //  tags which cannot be nested but are typically left unclosed.
            $no_nesting = StringUtils::map_assoc(array('li', 'p'));

            //  single use tags in HTML4
            $single_use = StringUtils::map_assoc(array('base', 'meta', 'link', 'hr', 'br', 'param', 'img', 'area', 'input', 'col', 'frame'));
        }

        //  properly entify angles.
        $text = preg_replace('@<(?=[^a-zA-Z!/]|$)@', '&lt;', $text);

        //  split tags from text.
        $split = preg_split('/<(!--.*?--|[^>]+?)>/s', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        //  note: PHP ensures the array consists of alternating delimiters and literals
        //  and begins and ends with a literal (inserting $null as required).

        $tag = false; // odd/even counter. Tag or no tag.
        $stack = array();
        $output = '';
        foreach ($split as $value) {
            //  process HTML tags.
            if ($tag) {
                //  passthrough comments.
                if (substr($value, 0, 3) == '!--') {
                    $output .= '<' . $value . '>';
                } else {
                    list($tagname) = preg_split('/\s/', strtolower($value), 2);
                    //  closing tag
                    if ($tagname{0} == '/') {
                        $tagname = substr($tagname, 1);
                        //  discard XHTML closing tags for single use tags.
                        if (!isset($single_use[$tagname])) {
                            //  see if we possibly have a matching opening tag on the stack.
                            if (in_array($tagname, $stack)) {
                                //  close other tags lingering first.
                                do {
                                    $output .= '</' . $stack[0] . '>';
                                } while (array_shift($stack) != $tagname);
                            }
                            //  otherwise, discard it.
                        }
                    }
                    //  opening tag
                    else {
                        //  see if we have an identical 'no nesting' tag already open and close it if found.
                        if (count($stack) && ($stack[0] == $tagname) && isset($no_nesting[$stack[0]])) {
                            $output .= '</' . array_shift($stack) . '>';
                        }
                        //  push non-single-use tags onto the stack
                        if (!isset($single_use[$tagname])) {
                            array_unshift($stack, $tagname);
                        }
                        //  add trailing slash to single-use tags as per X(HT)ML.
                        else {
                            $value = rtrim($value, ' /') . ' /';
                        }
                        $output .= '<' . $value . '>';
                    }
                }
            } else {
                //  passthrough all text.
                $output .= $value;
            }
            $tag = !$tag;
        }
        //  close remaining tags.
        while (count($stack) > 0) {
            $output .= '</' . array_shift($stack) . '>';
        }
        return $output;
    }
    
    public static function spaceToNpsp($text) {
        $text = preg_replace('/\s+/', '&nbsp;', $text);
        return $text;
    }

}

?>

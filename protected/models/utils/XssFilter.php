<?php
/**
 *  This script contains some code borrowed from the sources of Drupal.
 *  
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */

class XssFilter {

    public static $STRICTED_ALLOWED_TAGS = array('span', 'sup', 'sub');
    public static $ALLOWED_TAGS = array('embed','object','audio', 'video', 'source', 'iframe', 'a', 'em', 'strong', 'cite', 'code', 'ul', 'ol', 'li', 'dl', 'dt', 'dd', 'p', 'br', 'span', 'small', 'b', 'u', 'style', 'img', 'h3', 'h4', 'h5', 'h6', 'address', 'pre', 'font', 'div', 'hr', 'table', 'tr', 'th', 'td', 'blockquote');

    public function drupal_validate_utf8($text) {
        if (strlen($text) == 0) {
            return TRUE;
        }
        return (preg_match('/^./us', $text) == 1);
    }

    public function filter_xss($string, $allowed_tags = array('a', 'em', 'strong', 'cite', 'code', 'ul', 'ol', 'li', 'dl', 'dt', 'dd')) {
        // Only operate on valid UTF-8 strings. This is necessary to prevent cross
        // site scripting issues on Internet Explorer 6.
        if (!$this->drupal_validate_utf8($string)) {
            return '';
        }
        // Store the input format
        $this->_filter_xss_split($allowed_tags, TRUE);
        // Remove NUL characters (ignored by some browsers)
        $string = str_replace(chr(0), '', $string);
        // Remove Netscape 4 JS entities
        $string = preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%', '', $string);

        // Defuse all HTML entities
        $string = str_replace('&', '&amp;', $string);
        // Change back only well-formed entities in our whitelist
        // Named entities
        $string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]*;)/', '&\1', $string);
        // Decimal numeric entities
        $string = preg_replace('/&amp;#([0-9]+;)/', '&#\1', $string);
        // Hexadecimal numeric entities
        $string = preg_replace('/&amp;#[Xx]0*((?:[0-9A-Fa-f]{2})+;)/', '&#x\1', $string);


        $func = create_function('$m,$s=FALSE', '$filter = new XssFilter(); return $filter->_filter_xss_split($m,$s); ');

        return preg_replace_callback('%
    (
    <(?=[^a-zA-Z!/])  # a lone <
    |                 # or
    <[^>]*.(>|$)      # a string that starts with a <, up until the > or the end of the string
    |                 # or
    >                 # just a >
    )%x', $func, $string);
    }

    /**
     * Processes an HTML tag.
     *
     * @param @m
     *   An array with various meaning depending on the value of $store.
     *   If $store is TRUE then the array contains the allowed tags.
     *   If $store is FALSE then the array has one element, the HTML tag to process.
     * @param $store
     *   Whether to store $m.
     * @return
     *   If the element isn't allowed, an empty string. Otherwise, the cleaned up
     *   version of the HTML element.
     */
    public function _filter_xss_split($m, $store = FALSE) {
        static $allowed_html;

        if ($store) {
            $allowed_html = array_flip($m);
            return;
        }

        $string = $m[1];

        if (substr($string, 0, 1) != '<') {
            // We matched a lone ">" character
            return '&gt;';
        } else if (strlen($string) == 1) {
            // We matched a lone "<" character
            return '&lt;';
        }

        if (!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9]+)([^>]*)>?$%', $string, $matches)) {
            // Seriously malformed
            return '';
        }

        $slash = trim($matches[1]);
        $elem = &$matches[2];
        $attrlist = &$matches[3];

        if (!isset($allowed_html[strtolower($elem)])) {
            // Disallowed HTML element
            return '';
        }

        if ($slash != '') {
            return "</$elem>";
        }

        // Is there a closing XHTML slash at the end of the attributes?
        // In PHP 5.1.0+ we could count the changes, currently we need a separate match
        $xhtml_slash = preg_match('%\s?/\s*$%', $attrlist) ? ' /' : '';
        $attrlist = preg_replace('%(\s?)/\s*$%', '\1', $attrlist);

        // Clean up attributes
        $attr2 = implode(' ', $this->_filter_xss_attributes($attrlist));
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
    public function _filter_xss_attributes($attr) {
        $attrarr = array();
        $mode = 0;
        $attrname = '';

        while (strlen($attr) != 0) {
            // Was the last operation successful?
            $working = 0;

            switch ($mode) {
                case 0:
                    // Attribute name, href for instance
                    if (preg_match('/^([-a-zA-Z]+)/', $attr, $match)) {
                        $attrname = strtolower($match[1]);
                        //!!!!olga $skip = ($attrname == 'style' || substr($attrname, 0, 2) == 'on');
                        $skip = substr($attrname, 0, 2) == 'on';
                        $working = $mode = 1;
                        $attr = preg_replace('/^[-a-zA-Z]+/', '', $attr);
                    }

                    break;

                case 1:
                    // Equals sign or valueless ("selected")
                    if (preg_match('/^\s*=\s*/', $attr)) {
                        $working = 1;
                        $mode = 2;
                        $attr = preg_replace('/^\s*=\s*/', '', $attr);
                        break;
                    }

                    if (preg_match('/^\s+/', $attr)) {
                        $working = 1;
                        $mode = 0;
                        if (!$skip) {
                            $attrarr[] = $attrname;
                        }
                        $attr = preg_replace('/^\s+/', '', $attr);
                    }

                    break;

                case 2:
                    // Attribute value, a URL after href= for instance
                    if (preg_match('/^"([^"]*)"(\s+|$)/', $attr, $match)) {
                        $thisval = $this->filter_xss_bad_protocol($match[1]);

                        if (!$skip) {
                            $attrarr[] = "$attrname=\"$thisval\"";
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace('/^"[^"]*"(\s+|$)/', '', $attr);
                        break;
                    }

                    if (preg_match("/^'([^']*)'(\s+|$)/", $attr, $match)) {
                        $thisval = $this->filter_xss_bad_protocol($match[1]);

                        if (!$skip) {
                            $attrarr[] = "$attrname='$thisval'";
                            ;
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("/^'[^']*'(\s+|$)/", '', $attr);
                        break;
                    }

                    if (preg_match("%^([^\s\"']+)(\s+|$)%", $attr, $match)) {
                        $thisval = $this->filter_xss_bad_protocol($match[1]);

                        if (!$skip) {
                            $attrarr[] = "$attrname=\"$thisval\"";
                        }
                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("%^[^\s\"']+(\s+|$)%", '', $attr);
                    }
                    break;

                    if ($attrname == 'style') {
                        $attr = str_replace('\"', '"', $attr);
                        $attrarr[] = "$attrname=$attr";
                        $working = 1;
                        $mode = 0;
                    }
                    break;
            }

            if ($working == 0) {
                // not well formed, remove and try again
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

        // the attribute list ends with a valueless attribute like "selected"
        if ($mode == 1) {
            $attrarr[] = $attrname;
        }
        return $attrarr;
    }

    /**
     * Processes an HTML attribute value and ensures it does not contain an URL
     * with a disallowed protocol (e.g. javascript:)
     *
     * @param $string
     *   The string with the attribute value.
     * @param $decode
     *   Whether to decode entities in the $string. Set to FALSE if the $string
     *   is in plain text, TRUE otherwise. Defaults to TRUE.
     * @return
     *   Cleaned up and HTML-escaped version of $string.
     */
    public function filter_xss_bad_protocol($string, $decode = TRUE) {
        static $allowed_protocols;
        if (!isset($allowed_protocols)) {
            $allowed_protocols = array_flip(array('http', 'https', 'ftp', 'news', 'nntp', 'telnet', 'mailto', 'irc', 'ssh', 'sftp', 'webcal'));
        }

        $disallowed_protocols = array_flip(array('javascript', 'data'));


        // Get the plain text representation of the attribute value (i.e. its meaning).
        if ($decode) {
            $string = $this->decode_entities($string);
        }

        // Iteratively remove any invalid protocol found.

        do {
            $before = $string;
            $colonpos = strpos($string, ':');
            if ($colonpos > 0) {
                // We found a colon, possibly a protocol. Verify.
                $protocol = substr($string, 0, $colonpos);
                // If a colon is preceded by a slash, question mark or hash, it cannot
                // possibly be part of the URL scheme. This must be a relative URL,
                // which inherits the (safe) protocol of the base document.
                if (preg_match('![/?#]!', $protocol)) {
                    break;
                }
                // Per RFC2616, section 3.2.3 (URI Comparison) scheme comparison must be case-insensitive
                // Check if this is a disallowed protocol.
                //!!!!olga if (!isset($allowed_protocols[strtolower($protocol)])) {
                if (isset($disallowed_protocols[strtolower($protocol)])) {
                    $string = substr($string, $colonpos + 1);
                }
            }
        } while ($before != $string);
        return $this->check_plain($string);
    }

    /**
     * Decode all HTML entities (including numerical ones) to regular UTF-8 bytes.
     * Double-escaped entities will only be decoded once ("&amp;lt;" becomes "&lt;", not "<").
     *
     * @param $text
     *   The text to decode entities in.
     * @param $exclude
     *   An array of characters which should not be decoded. For example,
     *   array('<', '&', '"'). This affects both named and numerical entities.
     */
    public function decode_entities($text, $exclude = array()) {
        static $table;
        // We store named entities in a table for quick processing.
        if (!isset($table)) {
            // Get all named HTML entities.
            $table = array_flip(get_html_translation_table(HTML_ENTITIES));
            // PHP gives us ISO-8859-1 data, we need UTF-8.
            $table = array_map('utf8_encode', $table);
            // Add apostrophe (XML)
            $table['&apos;'] = "'";
        }
        $newtable = array_diff($table, $exclude);

        //$func=create_function('', '$filter = new XssFilter(); return $filter->_decode_entities("$1", "$2", "$0", $newtable, $exclude); ');
        // Use a regexp to select all entities in one pass, to avoid decoding double-escaped entities twice.
        return preg_replace('/&(#x?)?([A-Za-z0-9]+);/e', 'XssFilter::_decode_entities("$1", "$2", "$0", $newtable, $exclude)', $text);
    }

    /**
     * Helper function for decode_entities
     */
    public static function _decode_entities($prefix, $codepoint, $original, &$table, &$exclude) {
        // Named entity
        if (!$prefix) {
            if (isset($table[$original])) {
                return $table[$original];
            } else {
                return $original;
            }
        }
        // Hexadecimal numerical entity
        if ($prefix == '#x') {
            $codepoint = base_convert($codepoint, 16, 10);
        }
        // Decimal numerical entity (strip leading zeros to avoid PHP octal notation)
        else {
            $codepoint = preg_replace('/^0+/', '', $codepoint);
        }
        // Encode codepoint as UTF-8 bytes
        if ($codepoint < 0x80) {
            $str = chr($codepoint);
        } else if ($codepoint < 0x800) {
            $str = chr(0xC0 | ($codepoint >> 6))
                    . chr(0x80 | ($codepoint & 0x3F));
        } else if ($codepoint < 0x10000) {
            $str = chr(0xE0 | ( $codepoint >> 12))
                    . chr(0x80 | (($codepoint >> 6) & 0x3F))
                    . chr(0x80 | ( $codepoint & 0x3F));
        } else if ($codepoint < 0x200000) {
            $str = chr(0xF0 | ( $codepoint >> 18))
                    . chr(0x80 | (($codepoint >> 12) & 0x3F))
                    . chr(0x80 | (($codepoint >> 6) & 0x3F))
                    . chr(0x80 | ( $codepoint & 0x3F));
        }
        // Check for excluded characters
        if (in_array($str, $exclude)) {
            return $original;
        } else {
            return $str;
        }
    }

    /**
     * Encode special characters in a plain-text string for display as HTML.
     *
     * Uses drupal_validate_utf8 to prevent cross site scripting attacks on
     * Internet Explorer 6.
     */
    public function check_plain($text) {
        return $this->drupal_validate_utf8($text) ? htmlspecialchars($text, ENT_QUOTES) : '';
    }

}

?>

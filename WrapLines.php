<?php 

/** 
 * Wordwrap the selected text to the given right margin. Keeps the existing 
 * right indent and comment prefix. Removes all extra whitespace, so it is 
 * only suitable for plain text, not code samples and such. 
 */ 
class WrapLines 
{ 
    private $text; 
    private $right_margin, $left_margin; 
    private $comment_start = '', $comment_mid = '', $comment_end = ''; 

    public function run($right_margin) 
    { 
        $this->text = file_get_contents('php://stdin'); 
        $this->right_margin = $right_margin; 

        $this->find_left_margin(); 
        $this->find_comment_prefix(); 
        $this->clean_text(); 

        echo utf8_decode($this->rewrap_lines()); 
    } 

    private function find_left_margin() 
    { 
        $text = ltrim($this->text, " \t"); 
        $this->left_margin = strlen($this->text) - strlen($text); 
        $this->text = rtrim($text); 
    } 

    private function find_comment_prefix() 
    { 
        if (preg_match('!^(/\*+|\*+ |//+ )!', $this->text, $matches)) { 
            $this->comment_start = $matches[1]; 
            if (strstr($this->comment_start, '/*')) { 
                $this->comment_mid = ' * '; 
                $this->comment_end = ' */'; 
            } else { 
                $this->comment_mid = $this->comment_start; 
            } 
        } 
    } 

    private function clean_text() 
    { 
        $comments = array(); 
        if ($this->comment_start != '') $comments[] = $this->comment_start; 
        if ($this->comment_mid != '')   $comments[] = $this->comment_mid; 
        if ($this->comment_end != '')   $comments[] = $this->comment_end; 
        $this->text = trim(preg_replace('/[\r\n ]+/', ' ', str_replace($comments, ' ', $this->text))); 
    } 

    private function rewrap_lines() 
    { 
        $wrap_len = $this->right_margin - $this->left_margin - strlen($this->comment_mid); 
        $padding  = str_pad('', $this->left_margin); 
        return $padding . $this->comment_start 
             . (strstr($this->comment_start, '/*') ? "\n$padding" . $this->comment_mid : '') 
             . wordwrap($this->text, $wrap_len, "\n$padding".$this->comment_mid) 
             . (strstr($this->comment_start, '/*') ? "\n$padding" . $this->comment_end : ''); 
    } 
} 

$argv = $_SERVER['argv']; 
$wl = new WrapLines; 
$wl->run($argv[1]); 

?>
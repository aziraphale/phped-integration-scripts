<?php 

/** 
 * Align the rightmost equal signs in the selected text. Useful for formatting 
 * assignment lists and/or array assignments. 
 */ 
class AlignEquals 
{ 
    private $text; 

    public function run() 
    { 
        // Needed because file doesn't work with php://stdin 
        $this->text = explode("\n", rtrim(file_get_contents('php://stdin'))); 

        $this->align($this->find_maxpos()); 

        echo utf8_decode(implode("\n", $this->text)); 
    } 

    private function align($pos) 
    { 
        for ($i = 0; $i < count($this->text); $i++) { 
            $line = $this->text[$i]; 
            $curpos = strrpos($line, '='); 
            $this->text[$i] = str_pad(substr($line, 0, $curpos-1), $pos) . '=' . substr($line, $curpos+1); 
        } 
    } 

    private function find_maxpos() 
    { 
        $pos = 0; 
        foreach ($this->text as $line) { 
            $curpos = strrpos($line, '='); 
            if ($curpos > $pos) $pos = $curpos; 
        } 

        return $pos; 
    } 
} 

$ae = new AlignEquals; 
$ae->run(); 

?>
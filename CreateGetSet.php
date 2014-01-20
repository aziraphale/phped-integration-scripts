<?php
/**
* (C) 2010 Niklas Lampén
* Modified for personal style preferences by Andrew Gillard, Jan 2014
*/
class CreateGetSet
{
    private $Text;

    public function __construct()
    {
        // Read file contents
        $this->Text = file_get_contents('php://stdin');
    }

    private function UpdateConstructor($MemberVariable)
    {
        /**
        * Find full __construct() from source. If it's present, add
        * "$this->MemberVariable = null;" to end of it.
        */
//        if (preg_match('/function\s+__construct\s*\(.*\)\s*\{((?:\{.*\}|.*)*)\}/sUmi', $this->Text, $aMatches)) {
//            // Check if member variable is allready inited in constructor
//            if (!preg_match('/\$this\s*->\s*' . $MemberVariable . '\s*=\s*/i', $aMatches[1])) {
//                $this->Text = preg_replace('/^(\t*| *)(function\s+__construct\s*\(.*\)\s*\{((?:\{.*\}|.*)*))\}/sUmi',
//                    "$2$1    \$this->" . $MemberVariable . " = null;\n$1}", $this->Text);
//            }
//        }
    }

    const K_PHPDOC = 1;
    const K_INDENT = 2;
    const K_VISIBILITY = 3;
    const K_VARNAME = 4;

    public function AddGettersSetters()
    {
        /**
        * Match "{definition} ${VariableName};"
        */
        preg_match_all("/(\/\*\*\s+.+?\*\/)?\s*?(\t*| *)(var|private|public|protected)\s+\\$([a-z0-9]+);/ims", $this->Text, $aMatches);

        foreach ($aMatches[self::K_VARNAME] as $i => $MemberVariable) {
            $phpDoc = $aMatches[self::K_PHPDOC][$i];
            $indent = $aMatches[self::K_INDENT][$i];
            $visibility = $aMatches[self::K_VISIBILITY][$i];
            $MemberVariableUC = ucfirst($MemberVariable);
            $replacementText = '';
            $varType = 'mixed';

            if ($phpDoc) {
                if (preg_match('/^\s*\*\s*@var\s+(.+?)\s*$/im', $phpDoc, $m)) {
                    $varType = $m[1];
                }

                $replacementText .= "$phpDoc";
            } else {
                // Comment this line out if you don't want to get PhpDocumentor comments
                $replacementText .= "/**\n$indent * Description of variable $MemberVariable\n$indent * \n$indent * @var $varType\n$indent */";
            }

            $replacementText .= "\n$indent$visibility \$$MemberVariable;";

            // If function Get{VariableName} is not found, create it
            if (!preg_match("/function\s+get" . $MemberVariableUC . "\s*\(/i", $this->Text)) {
                // Comment this line out if you don't want to get PhpDocumentor comments
                $replacementText .= "\n$indent\n$indent/**\n$indent * Get value of $MemberVariable\n$indent * \n$indent * @return $varType\n$indent */";

                $replacementText .= "\n{$indent}public function get$MemberVariableUC() {\n$indent    return \$this->$MemberVariable;\n$indent}";
            }

            // If function Set{VariableName} is not found, create it
            if (!preg_match("/function\s+set" . $MemberVariableUC . "\s*\(/i", $this->Text)) {
                // Comment this line out if you don't want to get PhpDocumentor comments
                $replacementText .= "\n$indent\n$indent/**\n$indent * Set value of $MemberVariable\n$indent * \n$indent * @param $varType \$$MemberVariable\n$indent */";

                $replacementText .= "\n{$indent}public function set$MemberVariableUC(\$$MemberVariable) {\n$indent    \$this->$MemberVariable = \$$MemberVariable;\n$indent}";
            }

//            $this->Text = preg_replace("/" . $visibility . '\s+\\$' . $MemberVariable . ";/", $replacementText, $this->Text);
            $this->Text = preg_replace("/" . preg_quote($aMatches[0][$i], '/') . "/", $replacementText, $this->Text);

            $this->UpdateConstructor($MemberVariable);
        }
    }

    public function GetContent() {
        return $this->Text;
    }
}

$GetSet = new CreateGetSet();
$GetSet->AddGettersSetters();
echo $GetSet->GetContent();
?>
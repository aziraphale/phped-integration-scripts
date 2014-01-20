<?php
/**
* (C) 2010 Niklas Lampén
*/
class CreateGetSet
{
   private $Text;

   public function __construct()
   {
      // Read file contents
      $this->Text = file_get_contents('php://stdin');
   }

   public function GetContent()
   {
      /**
      * Match "{definition} ${VariableName};"
      */
      preg_match_all("/(\t*| *)(var|private|public|protected)\s+\\$([a-z0-9]+);/i", $this->Text, $aMatches);

      foreach ($aMatches[3] as $i => $MemberVariable)
      {
         /**
         * If function Get{VariableName} is not found, create it
         */
         if (preg_match("/function Get" . $MemberVariable. "\(/i", $this->Text) == 0)
         {
            $this->Text =  preg_replace(
               "/" . $aMatches[2][$i] . ' \\$' . $MemberVariable . ";/",
               $aMatches[2][$i] . " \$$MemberVariable;\n" . $aMatches[1][$i] . 'public function Get' . $MemberVariable . '() { return $this->' . $MemberVariable . "; }",
               $this->Text);
         }

         /**
         * If function Set{VariableName} is not found, create it
         */
         if (preg_match("/function Set" . $MemberVariable. "\(/i", $this->Text) == 0)
         {
            $this->Text =  preg_replace(
               "/" . $aMatches[2][$i] . ' \\$' . $MemberVariable . ";/",
               $aMatches[2][$i] . " \$$MemberVariable;\n" . $aMatches[1][$i] . 'public function Set' . $MemberVariable . '($' . $MemberVariable . ') { $this->' . $MemberVariable . ' = $' . $MemberVariable . "; }",
               $this->Text);
         }
      }


      return trim($this->Text);
   }
}

$GetSet = new CreateGetSet();
echo $GetSet->GetContent();
?>
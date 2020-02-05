<?php
	
class SimpleSubstitution {

    public function Encrypt($s){

    static $pair = array("a"=>"p", "b"=>"h", "c"=>"q", "d"=>"g", "e"=>"i",
    "f"=>"u","g"=>"m", "h"=>"e","i"=>"a", "j"=>"y", "k"=>"l", "l"=>"n", 
    "m"=>"o","n"=>"f", "o"=>"d", "p"=>"x", "q"=>"j", "r"=>"k", "s"=>"r", "t"=>"c",
    "u"=>"v", "v"=>"s", "w"=>"t", "x"=>"z", "y"=>"w", "z"=>"b"," "=> " ", 
    ","=> ",", "."=> ".", "!"=> "!","A"=>"P", "B"=>"H", "C"=>"Q", "D"=>"G", 
    "E"=>"I","F"=>"U","G"=>"M", "H"=>"E","I"=>"A", "J"=>"Y", "K"=>"L", "L"=>"N", 
    "M"=>"O","N"=>"F", "O"=>"D", "P"=>"X", "Q"=>"J", "R"=>"K", "S"=>"R",
    "T"=>"C","U"=>"V", "V"=>"S", "W"=>"T", "X"=>"Z", "Y"=>"W", "Z"=>"B");

        $encrypt = $s;
        $output = " ";		

        for($i=0; $i<strlen($encrypt); $i++){

            $temp = $encrypt[$i];
            $corresponding = $pair[$temp];

            $output = $corresponding . $output;
        }
        // returns the encrypted string 
        return $output;			 
    }

    public function Decrypt($s){

        static $pair = array("a"=>"p", "b"=>"h", "c"=>"q", "d"=>"g", "e"=>"i",
        "f"=>"u","g"=>"m", "h"=>"e","i"=>"a", "j"=>"y", "k"=>"l", "l"=>"n", 
        "m"=>"o","n"=>"f", "o"=>"d", "p"=>"x", "q"=>"j", "r"=>"k", "s"=>"r", "t"=>"c",
        "u"=>"v", "v"=>"s", "w"=>"t", "x"=>"z", "y"=>"w", "z"=>"b"," "=> " ", 
        ","=> ",", "."=> ".", "!"=> "!","A"=>"P", "B"=>"H", "C"=>"Q", "D"=>"G", 
        "E"=>"I","F"=>"U","G"=>"M", "H"=>"E","I"=>"A", "J"=>"Y", "K"=>"L", "L"=>"N", 
        "M"=>"O","N"=>"F", "O"=>"D", "P"=>"X", "Q"=>"J", "R"=>"K", "S"=>"R",
        "T"=>"C","U"=>"V", "V"=>"S", "W"=>"T", "X"=>"Z", "Y"=>"W", "Z"=>"B");

        $decrypt = $s;
        $output = " "; 			

        for($i=0; $i<strlen($decrypt); $i++){
            $temp = $decrypt[$i];

            for($j=0; $j<sizeof(array_keys($pair,$temp)); $j++){
                $output = array_keys($pair,$temp)[$j] . $output;
            }
        }
        // returns the decrypted string
        return $output;			
    }
}
	
	
	

	

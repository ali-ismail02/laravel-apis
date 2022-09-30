<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class apis_controller extends Controller
{

    // function to sort a string in the following format aAbB12
    function sortString($str){

        if(!preg_match("/^[a-zA-Z0-9]+$/",$str)){
            return response()->json([
                "status" => 0,
                "message" => "Wrong format, zabet 5atak/5atek!!!"
            ]);
        }

        $array = str_split($str);
        $lower = [];
        $upper = [];
        $nums = [];

        // splitting string into 3 arrays; uppercase, lowercase and nbs arrays
        for ($i = 0; $i < strlen($str); $i++) {
            if($array[$i] >= 'a' && $array[$i]<= 'z'){
                $lower[] = ord($array[$i])-97;
            }else if($array[$i] >= 'A' && $array[$i] <= 'Z'){
                $upper[] = ord($array[$i])+32-97;
            }else{
                $nums[] = $array[$i];
            }
        }

        sort($lower);
        sort($upper);
        sort($nums);

        // filling the main array with sorted characters
        for($i=0,$x=0;$i<25;$i++){
            for($j=0;$j<count($lower);$j++){
                if($lower[$j] == $i){
                    $array[$x] = chr($lower[$j]+97);
                    $x++;
                }
            }
            for($j=0;$j<count($upper);$j++){
                if($upper[$j] == $i){
                    $array[$x] = chr($upper[$j]+97-32);
                    $x++;
                }
            }
        }

        // adding the sorted numbers to the end of the array
        for($x,$i=0;$x < count($array);$x++,$i++){
            $array[$x] = $nums[$i];
        }

        $str = implode($array);

        return response()->json([
            "status" => 1,
            "message" => $str
        ]);
    }


    // function to split a number into its full values????
    function splitValues($nb){

        if(!preg_match("/^\d+$/",$nb)){
            return response()->json([
                "status" => 0,
                "message" => "bade bs 2r2am. face palm"
            ]);
        }

        $flag = 0;
        $array = [];

        if($nb == 0){
            return response()->json([
                "status" => 1,
                "message" => [0]
            ]);
        }

        if($nb < 0){
            $nb = -$nb;
            $flag=1;
        }
        
        while($nb >= 1){
            $value = $nb % 10;
            $nb = $nb/10;
            $array[] = $value;
        }

        $array = array_reverse($array);

        // adding 0s to the arrays' elements according to the index of the element
        for($i = count($array)-1,$j=0; $i>=0;$i--,$j++){
            if($flag){
                $array[$j] = -($array[$j] * pow(10,$i));
            }else $array[$j] = $array[$j] * pow(10,$i);
        }

        return response()->json([
            "status" => 1,
            "message" => $array
        ]);
    }


    // functions to replace numbers in a string with their binary equivelent
    function replaceWithBinary($string) {

        if(!preg_match("/^[a-zA-Z0-9\s]+$/",$string)){
            return response()->json([
                "status" => 0,
                "message" => "Wrong format, zabet 5atak/5atek!!!"
            ]);
        }

        // this function turns a string of integers into a string of 0s and 1s (binary format of the numbers)
        function parseBinary($number) {
    
            $number = (int)$number;
            $binary = [];
    
            if($number == 0) return "0";

            while($number > 0){
                $binary[] = $number % 2;
                $number = (int)($number / 2);
            }

            $binary = array_reverse($binary);
            
            return implode($binary);
        }

        preg_match_all('!\d+!', $string, $numbers);
        $binarys = [];

        for($i = 0; $i < count($numbers[0]) ; $i++){
            $binarys[] = parseBinary($numbers[0][$i]);
        }

        return response()->json([
            "status" => 1,
            "message" => str_replace($numbers[0], $binarys, $string)
        ]);
    }


    // function that calculates total of a prefix and operands in an array
    function prefixCalc($string){

        if(!preg_match('/^[\+\-\*%\/]{1}\s{1}\d+\s{1}\d+( \d+)*$/', $string)){
            return response()->json([
                "status" => 0,
                "message" => "Wrong format, zabet 5atak/5atek!!!"
            ]);
        }

        $array = explode(" ", $string);
        $total = (int)$array[1];

        for($i = 2 ; $i < count($array) ; $i++){
            if($array[0] == "+"){
                $total += (int)$array[$i];
            }else if($array[0] == "-"){
                $total -= (int)$array[$i];
            }else if($array[0] == "*"){
                $total *= (int)$array[$i];
            }else if($array[0] == "/"){
                $total = $total / (int)$array[$i];
            }else if($array[0] == "%"){
                $total = $total % (int)$array[$i];
            }
        }

        return response()->json([
            "status" => 1,
            "message" => $total
        ]);
    }
}

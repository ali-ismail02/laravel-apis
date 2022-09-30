<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class apis_controller extends Controller
{
    function sortString(){
        $str = "6jnM31Q";

        $array = str_split($str);
        $lower = [];
        $upper = [];
        $nums = [];

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

        for($x,$i=0;$x < count($array);$x++,$i++){
            $array[$x] = $nums[$i];
        }

        $str = implode($array);

        return response()->json([
            "status" => 1,
            "message" => $str
        ]);
    }
    function splitValues(){
        $nb = 100;
        $flag = 0;
        $array = [];

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

    function replaceWithBinary($string) {

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
}

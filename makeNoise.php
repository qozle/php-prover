<?php 
    //  Get random wiki page
    //  Get array of all <p> tags
    //  Pick a random <p> tag
    //  TODO: Strip content of "[n]"
    //  Explode said <p> tag into sentence items.
    //  Pick a random item from the array.  
    //  Push random item to $paragraph
    //  Repeat all this a few times.
    //  Print $paragraph
    ini_set('display_errors', '0');
    $paragraph = [];
    $debug = false;
    //  Function that picks a random <p> from the whole page
    function pickRandomPTag($arrayOfPTags, $debug = false){
        // Pick random <p>
        global $debug;
        static $randomPTag;
        $randIndex = rand(0, count($arrayOfPTags)-1);
        $randomPTag = $arrayOfPTags[$randIndex];
        if ($debug == true){
            echo "we chose:" . $randIndex . "<br>";
            echo $randomPTag;
        }
        $stringIsBad = ($randomPTag == "" || $randomPTag == " " || $randomPTag == "  " || $randomPTag == "\r\n" || $randomPTag == "\n\r" || $randomPTag == "\r" || $randomPTag == " \n" || str_contains($randomPTag, ":") || ord($randomPTag == 0) || $randomPTag == "\n " || $randomPTag == " \r" || $randomPTag == "\n" || $randomPTag == 10 || $randomPTag == "<br>");

        if ($stringIsBad == true && count($arrayOfPTags) > 1){
            if ($debug == true){
                echo "<p>Random P is no good, picking another...</p>";                
            }
            unset($arrayOfPTags[$randIndex]);
            $arayOfPTags = array_values($arrayOfPTags);
            pickRandomPTag($arrayOfPTags);
        } else if ($stringIsBad == true && count($arrayOfPTags) == 1){
            if ($debug == true){
                echo "<p>Only one choice and it's no good, returning null</p>";                
            }
            return null;
        } 
        return $randomPTag;
        

    }

    //  Function that picks a random sentence from the <p> selected
    function pickRandomSentence($arrayOfSentences){
        $randomSentence = $arrayOfSentences[rand(0, count($arrayOfSentences)-1)];
        $randomSentence = rtrim($randomSentence, " \n\r\t\v\0[0..9]");
        if (!str_ends_with($randomSentence, ".")){
            $randomSentence = $randomSentence . ".";
        }

        return $randomSentence;
    }

    
    function getNonsense($iterations = 0, $debug = false) {
        static $timesRun = 0;
        global $paragraph;
        $newTextArray = [];
        //  Pull a random wiki page
        $ch = curl_init("https://en.wikipedia.org/wiki/Special:Random");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $data = curl_exec($ch);
        curl_close($ch);

        //  Create an array of all the <p> elements
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($data);
        libxml_clear_errors();
        $textArray = $doc->getElementsByTagName('p');
        if ($debug == true){
            echo "<h2>all P elements:</h2>";                
        }
        foreach($textArray as $text){
            if ($debug == true){
                echo "<p>-" . $text->nodeValue . "</p>";                
            }
            array_push($newTextArray, $text->nodeValue);
        }

        //  Pick a random element
        $randomPTag = pickRandomPTag($newTextArray);
        if ($debug == true){
            echo "<h2>Random p-tag:</h2><p>". $randomPTag . "</p>";                
        }


        //  Seperate the sentences into array items
        
        if ($randomPTag != null) {

            $sentencesArray = explode('. ', $randomPTag);
            if ($debug == true){
                echo "<h2>After explode:</h2>";
                foreach($sentencesArray as $sentence){
                            echo "<p>-" . $sentence . "</p>";
                }
            }     

            //  Pick a random one
            $randomSentence = pickRandomSentence($sentencesArray); 
            if ($debug == true){
                echo "<h1>random sentence:</h2><br>";
                echo "<p>".$randomSentence."</p>";                
            }
            
            //  Clean it up, remove "[]"s
            preg_replace('/\[.+\]/', '', $randomSentence);
            //  Push it to a global array
            array_push($paragraph, $randomSentence); 
        }
        
        //  Increase the count of how many times the function has been run
        $timesRun++;

        //  If it hasn't run it as many times as asked, run it again!
        if ($timesRun < $iterations){
            global $debug;
            getNonsense($iterations, $debug);
        }
    }
    echo "<p>";
    getNonsense(10, $debug);
    foreach ($paragraph as $sentence){
        echo $sentence . "  ";
    }
    echo "</p>";
?>
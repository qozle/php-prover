<!DOCTYPE html>
<html>
<head>
<!-- <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script> -->
</head>
<body>
    <?php 
        ini_set('display_errors', '0');
        $ch = curl_init("https://en.wikipedia.org/wiki/Special:Random");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $data = curl_exec($ch);
        curl_close($ch);

        // echo $data;

        $doc = new DOMDocument();
        $doc->loadHTML($data);
        $textArray = $doc->getElementsByTagName('p');
        $h1Array = $doc->getElementsByTagName('h1');
        echo $h1Array->length . "<br><br>";
        foreach ($h1Array as $h1Elem){
            echo $h1Elem->nodeValue . "<br>";
        }
        echo '<br><br>';
        foreach ($textArray as $text){
            echo $text->nodeValue . "<br>";
        }


        // echo $data;

        // echo "<h1 id='test'>wow what a cool test</h1>";

        // echo '<script type="text/Javascript">
        //         let jTest = $("#test")
        //         console.log(jTest.text());
        //     </script>';
    
    ?>
</body>
</html>
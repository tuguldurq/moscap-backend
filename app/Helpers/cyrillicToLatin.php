<?php

if(!function_exists('cyrillicToLatinText')){
    function cyrillicToLatinText($text = null){
        $formattedText = null;
        if($text != null){
            $cyr = [
                'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','ө','п', 'р','с','т','у', 'ү','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я', 
                'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','Ө','П', 'Р','С','Т','У', 'Ү','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
            ];
            $lat = [
                    'a','b','v','g','d','ye','yo','j','z','i','i','k','l','m','n','o','o','p', 'r','s','t','u','u','f','kh','ts','ch','sh','sh','i','y','i','e','yu','ya', 
                    'A','B','V','G','D','Ye','Yo','J','Z','I','I','K','L','M','N','O','O','P', 'R','S','T','U','U','F','Kh','Ts','Ch','Sh','Sh','I','Y','I','E','Yu','Ya'
            ];

            $formattedText = str_replace($cyr, $lat, $text);

        }

        return $formattedText;
    }
}
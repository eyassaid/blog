<?php

class Message{
    public static function success($msg){
        echo "<div class='alert alert-success justify-content-center m-2 p-3 '>".strtoupper($msg)."</div>";
    }
    public static function error($msg){
        echo "<div class='alert alert-danger justify-content-center m-2 p-3 '>".strtoupper($msg)."</div>";
        
    }

}


?>



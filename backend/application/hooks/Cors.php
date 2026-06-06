<?php
class Cors{
    public function handle(){
        // header("X-Test-Hook: working");
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            exit(0);  
        }

    }
}

?>
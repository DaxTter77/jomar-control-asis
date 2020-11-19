<?php
    class Check{
        function isAjax() {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest')){
                return true;
            }
            return false;
        }
    }
?>
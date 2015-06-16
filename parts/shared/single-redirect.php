
<?php
    if(isset($ID)) {
        $redirect_url = home_url() . "?post=" . $ID . "&" . $_SERVER['QUERY_STRING'];
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=" . $redirect_url . "\">";
    }
?>

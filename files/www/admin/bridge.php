<?php
$page_title = "Create a WiFi bridge";
include('header.php');
?>
    <div class="center">
    	<h1><i class="icon-bridge"></i> Create a WiFi bridge</h1>
	</div>
    <script>                                                                                                                                    var $r;
        function checkForPw() {
                var myselect = document.getElementById("bridge");
                var rid=myselect.id;
                console.log(rid);
                if(myselect.value.slice(-1) != 'off') {
                        document.getElementById("bridgepw").style.visibility = "visible";
                } else {
                        document.getElementById("bridgepw").style.visibility = "hidden";
                }
                
        }
    </script>

    <?php
        $d = fopen("config/vpnstatus", "r");
        $e=fgets($d);
        if (preg_match('/up/', $e) == 1) {
            echo "<br>";
            echo "<div class='warning'>";
            echo "It seems there's a VPN running. Please stop it before creating a bridge, then start it again once the bridge is up and you're online";
            echo "</div>"; 
            echo "<form method='get' id='stopvpn' action='cgi-bin/config.cgi'>";
            echo "<input name='stopvpn' type='hidden' value='stopvpn'>";
            echo "<input type='submit' value='Stop VPN' class='button'>";
            echo "</form>";
            fclose($d);
        } else {
            echo "<form enctype='multipart/form-data' action='bridgeset.php' method='post'>";
            echo "</center>";
            echo "<select class='networks' name='bridge' onchange='checkForPw()' id='bridge'>";
            echo "<option class='networks' id='nothing'>Choose a network...</option>"; 
            $f = fopen("data/networks", "r");
            while(!feof($f)) { 
                $g=fgets($f);
                $parts = explode(',', $g);
                if ($parts[1]) {
                    $data=$parts[0].','.$parts[1].','.$parts[2].','.$parts[3];
                    echo "<option id=$data name=$data value=$data>".base64_decode($parts[1])."</option>"; 
                    if ($parts[3] == 'wpa') {
                        echo "<input name='n$data' for=$data min='8' max='63' id='pw$data' type='text' placeholder='password' style='visibility:hidden' >";
                    }
                }
            }
            fclose($f);
            echo "</select>";
            echo "<div id='bridgepw' style='visibility:hidden'>";
            echo "<br>";
            echo "<input name='password'min='8' max='63' type='text' value='' placeholder='enter wifi passphrase' >";
            echo "</div>";
            echo "<input type='checkbox' name='save' id='save' class='css-checkbox'>";
            echo "<label for='save' class='css-label'>Save this network</label>";
            echo "<input type='checkbox' name='defaultroute' id='defaultroute' class='css-checkbox'>";
            echo "<label for='defaultroute' class='css-label'>Make this my default connection</label>";
            echo "<center>";
            echo "<input type='submit' value='NEXT' class='btnnext'>";
            echo "</form>";
            echo "<br>";
            echo "<hr>";
            $fn = "config/savedbridge";
            if (file_exists($fn)) {
                $f = fopen($fn, "r");
                $g = fgets($f);
                $parts = explode(',', $g);
				$ssid = base64_decode($parts[1]);
		        $ap = $parts[0].','.$ssid;
                $default=$parts[6];
                fclose($f);
                echo "<br>";
                echo "<h3>Use a saved network</h3>"; 
                echo "<form method='get' id='savedbridge' action='cgi-bin/config.cgi'>";
                echo "<input name='savedbridge' type='hidden' value='savedbridge'>";
				echo '<button class=button" value="'.$ap.'" type="submit">'.$ssid.'</button>';
                echo "</form>";
                echo "<br>";
                if ( $default == "1" ) {
                    echo "<h3><em>".$ssid."</em> is your default connection</h3>";
                    echo "<form method='get' id='removebridge' action='cgi-bin/config.cgi'>";
                    echo "<input name='removebridge' type='hidden' value='removebridge'>";
                    echo "<input type='submit' value='Unset as default' class='button'>";
                    echo "</form>";

                }
                echo "</center>";
           }
        }
    ?>
<?php include('footer.php'); ?>

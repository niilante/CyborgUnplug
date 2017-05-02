<?php
// PHP File Tree code by Cory LaViska, adapts code from here:
//   http://abeautifulsite.net/notebook.php?article=21
$page_title = "Share files over Wifi";
include('/www/admin/header.php');
include("/www/share/php_file_tree.php");
?>
	<script src="/share/php_file_tree.js" type="text/javascript"></script>
	<div class="center">
		<h1><i class="icon-file-share"></i> Share files over WiFi</h1>
	</div>
<?php
	$g = "usb/empty";
	if (file_exists($g)) {
		echo "<br>";
		echo "<div class='warning warning3'>";
		echo "Insert USB stick to start sharing";
		echo "</div>"; 
		echo "<div class='warning'>";
		echo "Note that during USB stick sharing mode there is no access to the main and configuration menus until the USB stick is ejected and the owner/administrator logs in again";
		echo "</div>"; 
		echo "<form method='get' id='sharerefresh' action='cgi-bin/config.cgi'>";
		echo "<div class='center'>";
        echo "<input name='sharerefresh' type='submit' value='Refresh' class='button'>";
        echo "</div>";
		echo "</form>";
	} else {
		echo "<div class='warning warning3'>";
		echo "Devices connected to this network can now download the following files:";
		echo "</div>"; 
		echo "<div id='container_files'>";
		echo "<form method='get' id='start' action='cgi-bin/config.cgi'>";
		echo "<br>";
		echo php_file_tree("/www/share/usb", "[link]");
		echo "</div>"; 
		echo "<hr>";
		echo "<center>";
        echo "<input name='umount' type='submit' value='Eject USB stick' class='button'>";
        echo "</center>";
		echo "</form>";
	}
include('/www/admin/footer.php'); ?>

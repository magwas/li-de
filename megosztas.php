<?php
// megosztás gombok
$title = 'Test oldal';
$myURL = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
?>
<html>
<head>
  <script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'hu'}
  </script>
</head>
<body>
myURL=<?php echo $myURL; ?><br />

<table class="megosztasBar"><tbody><tr>
<td valign="top">
  <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</td>
<td valign="top"><div class="g-plusone" data-annotation="inline" data-width="300"></div></td>
<td><iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode($myURL); ?>&amp;width=200&amp;layout=standard&amp;action=recommend&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=366904500111535" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:80px;" allowTransparency="true"></iframe></td>
</tr></tbody></table>
</body>
</html>



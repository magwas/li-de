<?php
// a felhasznalo a hibajelzes linkre kattintott
// JUMI program
$hibaInfo = urldecode($_GET['info']);
if (isset($_GET['task'])) {
   $title = $_POST['title';
   $description = $_POST['description'];
   $start = $_POST['start'];
   $priority = $_POST['priority'];
   $state = $_POST['state'];
   
   // tárolás adatbázisba
   $db = JFactory::getDBO();
   $db->setQuery('INSERT INTO #__ampm_task 
   (title,description,start,priority,state)
   VALUES
   ("'.str_replace('"','\"',$title).'",
    "'.str_replace('"','\"',$description).'",
    "'.$start.'",
    "'.$priority.'",
    "'.$state.'")
   ');
   $db->query();
   
   // levél küldés
   $errordesc = '';
   foreach($_POST as $fn=>$fv)
      $errordesc .= $fn.'='.$fv."\n\n";
   mail('tibor.fogler@gmail.com','li-de hibajelzes',$errordesc);
   echo '
   <br>
   <br>
   <h2>Köszönöm a hibajelzést.</h2>
   <a href="'.JURI::base().'index.php">Vissza a kezdő lapra</a>
   <br>
   ';
} else {
  $user = JFactory::getUser();
  echo '
  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  </head>
  <body>
  <h1>li-de program HIBAJELZÉS</h1>
  <form action="'.JURI::base().'index.php?option=com_jumi&file=????" method="post">
    <p>Amennyiben hibát észlelt a li-de program müködése soráb; kérjük jelezze azt a program fejlesztői fel!
    Ezzel sokat segít a program fejlesztésében, tökéletesítésében. Kérjük minnél pontosabban írja le a hiba 
    jelenséget, hasznos ha a böngésző program tipusát és a képernyő felbontást is megadja.</p>
    <p>Hiba rövid leírása:<br /><input type="text" name="title" size="60" /></p>
    <p>Részletesebb hiba leírás:<br />
    <textarea name="description" rows="15" cols="80">
    
    
Hibajelzo neve: '.$user->name.'
Hibajelzo e-mail cime:'.$user->email.'    
Kerem, hogy az alabbi infokat hagyja benne a hibajelzesben!
'.$hibaInfo.'
    </textarea>
    </p>
    <p>Hiba minősítése:
      <select name="state">
        <option value="1">Javaslat továbbfejlesztésre</option>
        <option value="1">Apró hiba</option>
        <option value="2">Zavaró hiba</option>
        <option value="3>Súlyos hiba</option>
        <option value="9">Azonnal javítandó, így használhatatlan a program</option>
      </select>
    </p>
    <input type="hidden" name="start" value="'.date().'" />
    <input type="hidden" name="state" value="1" />
    
    <p style="text-align:center">
      <button type="submit" name="task" value="send">Elküld</button>
      <button type="button" onclick="location='."'index.php'".'">Mégsem</button>
    </p>
  </form>
  </body>
  </html>
  ';
}

?>
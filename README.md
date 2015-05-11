Joomla! CMS [![Analytics](https://ga-beacon.appspot.com/UA-544070-3/joomla-cms/readme)](https://github.com/igrigorik/ga-beacon)
====================
Likvid demokrácia 

(http://li-de.tk)
 
likviddemokracia
Ez egy web -es közösségi döntéshozatali rendszer

Likvid demokrácia

Ez a demokratikus döntéshozatali modell igyekszik egyesíteni magában a képviseleti demokráciával elérhetõ szakértelmet és a közvetlen demokrácia elõnyeit.

Ebben a modellben, minden szavazó polgár minden kérdésnél maga döntheti el, hogy  akar-e közvetlen szavazati jogával élni vagy azt átruházza másra. Ez az átruházás történhet egy-egy adott témakörre vonatkozóan, különbözõ téma körökben eltérõ személyekre, csoportokra ruházhatja át a szavazati jogát, de történhet általános érvénnyel is. A szavazati jog átruházások bármikor visszavonhatóak, megváltoztathatóak, és a szavazó polgár bármikor dönthet úgy, hogy egy adott kérdésben közvetlenül szavaz akkor is ha erre a tárgykörre korábban átruházta szavazati jogát, vagy általános érvénnyel átruházta szavazati jogát.


Borda rendszerû szavazás. Ez azt jelenti, hogy a lehetséges választási alternatívák között a szavazó nem csak olyan módon dönthet, hogy egyet kiválaszt és az összes többit elveti (mint ahogy ez most történik az “X” elhelyezésével), hanem rangsorol, megmondja melyik lehetõség tûnik neki a legjobbnak, melyik a második jó, melyik a közepes, melyik amit rossznak tart, mit tart elfogadhatatlannak.

A szabályok vázlatos összefoglalása:

Minden eldöntendõ kérdést szavazásra bocsátunk
 Minden választó polgárnak, minden kérdésben joga van szavazati jogával közvetlenül élni, az adott kérdésben szavazni, még akkor is ha az adott témakörben korábban szavazati jogát átruházta valakire, vagy az adott idõszakra általánosan átruházta a szavazati jogát (lásd lentebb).
 A választó polgár dönthet úgy, hogy egy-egy adott témakörben nem kíván szavazati jogával közvetlenül élni, hanem ezt a jogot átruházza valaki másra (másik szavazó polgárra ). Ez esetben a szavazás kiértékelésénél úgy tekintjük, hogy a szavazó polgár (aki az adott kérdésben közvetlen szavazatot nem adott le) ugyanúgy szavazott mint az akire átruházta a szavazatát.
 A választó polgár dönthet úgy, hogy egy adott idõszakban semmilyen témakõrben nem kíván szavazati jogával közvetlenül élni, hanem ezt a jogot minden témakörre vonatkozóan , általánosan átruházza valaki másra (másik szavazó polgárra). Ez esetben a szavazás kiértékelésénél úgy tekintjük, hogy a szavazó polgár (aki az adott kérdésben közvetlen szavazatot nem adott le) ugyanúgy szavazott mint az akire átruházta a szavazatát
Szavazatot csak olyan személyre lehet átruházni aki erre a feladatra (a képviseletre) vállalkozott.
Aki mások képviseletére vállalkozik (azaz hozzá járul, hogy mások rá átruházzák szavazati jogukat) az saját szavazati jogát nem ruházhatja át másra.
A likvid demokrácia modell teljes egészében tartalmazza a képviseleti demokráciát és a közvetlen demokráciát is! Ha egy választó polgár úgy akarja, minden kérdésben közvetlenül szavaz, a számára megvalósul a teljes bázis demokrácia. Ha egy másik választó polgár úgy akarja akkor 4 évre, általános kérvénnyel átruházza szavazati jogát valakire, ezzel az õ számára a képviseleti demokrácia valósult meg. 

A likvid demokrácia modell elsõsorban a nyílt szavazásokat támogatja. Hiszen ahhoz, hogy a szavazásra jogosultak felelõs döntéseket tudjanak hozni abban a kérdésben, hogy kire ruházzák át szavazatukat (kiket bíznak meg a képviseletükkel), illetve mikor vonják vissza ezt a megbízást, mikor módosítják azt - ismerniük kell, hogy a képviselõjük az egyes kérdésekben hogyan szavaz.

Ugyanakkor a létezõ realitásokat figyelembe véve indokolt lehet titkos szavazásokat is rendezni, elsõsorban személyi jellegû kérdésekben, amikor a szavazás eredményeképpen a megbízottak hatalmat kapnak, amivel esetleg visszaélve bosszút állhatnának azokon akik ellenük szavaztak. Ezért ez a program lehetõséget ad "titkos", és "szigorúan titkos" szavazások lebonyolítására is. "Titkos" szavazásnál a "csak saját nevükben szavazók" szavazata titkos, a "mások nevében is szavazó képviselõk" szavazata nyilvános. "Szigorúan titkos" szavazásban mindenki szavazata titkos, viszont az ilyen szavazásban a képviseleti megbízásokat nem vesszük figyelembe, mindenki csak a saját nevében szavaz.

 

 Lásd még:

WIKIPEDIA http://hu.wikipedia.org/wiki/R%C3%A9szv%C3%A9teli_demokr%C3%A1cia

Kalóz párt http://kalozpart.org/likvid-demokracia/

http://www.sogowave.com/2013/05/likvid-demokracia-szilard-koztarsasag.html

MUNKÁSOK ÚJSÁGA http://muon.hu/on-line-tartalom/440-likvid-demokracia

 
Technikai információk:
Joomla 3 alapokon fejlesztett PHP/ MYSQ(vagy pastgradeSQL)  program



PHP (Magic Quotes GPC off)[1]  	ajánlott:5.4 +	        min:5.3.10 +	   (http://www.php.net)

MySQL (InnoDB support required)	ajánlott:5.1 +         min:5.1 +	      (http://www.mysql.com)

SQL Server	                     ajánlott:10.50.1600.1+	min:10.50.1600.1+	  (http://www.microsoft.com/sql)

PostgreSQL	                     ajánlott:8.3.18 +      min:8.3.18 +	   (http://www.postgresql.org/)

Supported Web Servers:

Apache[2]
(with mod_mysql, mod_xml, and mod_zlib)	ajánlott:2.x +	min:2.x +	http://www.apache.org

Nginx	ajánlott:1.1	min:1.0	http://wiki.nginx.org/

Microsoft IIS[5]	ajánlott:7	min:7	http://www.iis.net
 

 
 
Projekt vezetõ:  Fogler Tibor (Utopszkij)   tibor.fogler@gmail.com
 

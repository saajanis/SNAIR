<?php





require_once 'dbconfig.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if(!$db_server) die("Unable to connect to MySQL: " .mysql_error());
mysql_select_db($db_database)
 or die ("Unable to select database" .mysql_error());
print "Connection Succeeded";








function safeClean($n)
{

    $punctuation = array("+",",",".","-","\'","\"","&","!","?",":",";","#","~","=","/","$","£","^","(",")","_","<",">","@", "\\", "%", "http" , "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "amp", "Other", "Ska", "Blouses", "Die", "Pain", "Adults", "Dies", "Mixed", "Now");

    $n = trim($n);

    if(get_magic_quotes_gpc())
    {
        $n = stripslashes($n);
    } 

    $n = mysql_escape_string($n);
    $n = htmlentities($n);
    
    $n = str_replace($punctuation, '', $n);


    return $n;
}










/////////////

try{

$consumerKey = '7zcuiPjSVRO8ppIchJLYdg';
$consumerSecret = 'afefUnffMn1dN6G1hqrIcMtGIdclHRAbbAEtBlCFQik';
$oauthToken = '63680306-8LTReuJgZZOp4CpeA3hKhiLsZ34W4i6jK60wn41SE';
$oauthSecret = 'NBg8AZzrXokwlMvPDlFhd27ZKz6pvVwgJt3LjyU1c';
 
 
 
include "OAuth.php";
include "twitteroauth.php";
 
$connection = new TwitterOAuth($consumerKey, $consumerSecret, $oauthToken, $oauthSecret);





$profile_input = $_POST['profile_input'];

if($profile_input == null){
echo "<br><br><br><br><b>Please enter a valid profile name!</b>";
exit();
}

////



$remove = array("/(\bable\b)/" , "/(\babout\b)/" , "/(\babove\b)/" , "/(\bacross\b)/" , "/(\bact\b)/" , "/(\baction\b)/" , "/(\bactually\b)/" , "/(\badd\b)/" , "/(\baddition\b)/" , "/(\badjective\b)/" , "/(\bafraid\b)/" , "/(\bAfrica\b)/" , "/(\bafter\b)/" , "/(\bagain\b)/" , "/(\bagainst\b)/" , "/(\bage\b)/" , "/(\bago\b)/" , "/(\bagreed\b)/" , "/(\bahead\b)/" , "/(\bair\b)/" , "/(\ball\b)/" , "/(\ballow\b)/" , "/(\balmost\b)/" , "/(\balone\b)/" , "/(\balong\b)/" , "/(\balready\b)/" , "/(\balso\b)/" , "/(\balthough\b)/" , "/(\balways\b)/" , "/(\bam\b)/" , "/(\bAmerica\b)/" , "/(\bamong\b)/" , "/(\bamount\b)/" , "/(\ban\b)/" , "/(\band\b)/" , "/(\bangle\b)/" , "/(\banimal\b)/" , "/(\banother\b)/" , "/(\banswer\b)/" , "/(\bany\b)/" , "/(\banything\b)/" , "/(\bappear\b)/" , "/(\bare\b)/" , "/(\barea\b)/" , "/(\barms\b)/" , "/(\barmy\b)/" , "/(\baround\b)/" , "/(\barrived\b)/" , "/(\bart\b)/" , "/(\bas\b)/" , "/(\bask\b)/" , "/(\bat\b)/" , "/(\baway\b)/" , "/(\bbaby\b)/" , "/(\bback\b)/" , "/(\bbad\b)/" , "/(\bball\b)/" , "/(\bbank\b)/" , "/(\bbase\b)/" , "/(\bbe\b)/" , "/(\bbear\b)/" , "/(\bbeat\b)/" , "/(\bbeautiful\b)/" , "/(\bbecame\b)/" , "/(\bbecause\b)/" , "/(\bbecome\b)/" , "/(\bbed\b)/" , "/(\bbeen\b)/" , "/(\bbefore\b)/" , "/(\bbegan\b)/" , "/(\bbegin\b)/" , "/(\bbehind\b)/" , "/(\bbeing\b)/" , "/(\bbelieve\b)/" , "/(\bbell\b)/" , "/(\bbelong\b)/" , "/(\bbelow\b)/" , "/(\bbeside\b)/" , "/(\bbest\b)/" , "/(\bbetter\b)/" , "/(\bbetween\b)/" , "/(\bbig\b)/" , "/(\bbill\b)/" , "/(\bbirds\b)/" , "/(\bbit\b)/" , "/(\bblack\b)/" , "/(\bblock\b)/" , "/(\bblood\b)/" , "/(\bblow\b)/" , "/(\bblue\b)/" , "/(\bboard\b)/" , "/(\bboat\b)/" , "/(\bbody\b)/" , "/(\bbones\b)/" , "/(\bbook\b)/" , "/(\bborn\b)/" , "/(\bboth\b)/" , "/(\bbottom\b)/" , "/(\bbox\b)/" , "/(\bboy\b)/" , "/(\bbranches\b)/" , "/(\bbreak\b)/" , "/(\bbright\b)/" , "/(\bbring\b)/" , "/(\bBritish\b)/" , "/(\bbroken\b)/" , "/(\bbrother\b)/" , "/(\bbrought\b)/" , "/(\bbrown\b)/" , "/(\bbuild\b)/" , "/(\bbuilding\b)/" , "/(\bbuilt\b)/" , "/(\bburning\b)/" , "/(\bbusiness\b)/" , "/(\bbut\b)/" , "/(\bbuy\b)/" , "/(\bby\b)/" , "/(\bcall\b)/" , "/(\bcame\b)/" , "/(\bcan\b)/" , "/(\bcannot\b)/" , "/(\bcan't\b)/" , "/(\bcapital\b)/" , "/(\bcaptain\b)/" , "/(\bcar\b)/" , "/(\bcare\b)/" , "/(\bcarefully\b)/" , "/(\bcarry\b)/" , "/(\bcase\b)/" , "/(\bcat\b)/" , "/(\bcatch\b)/" , "/(\bcattle\b)/" , "/(\bcaught\b)/" , "/(\bcause\b)/" , "/(\bcells\b)/" , "/(\bcenter\b)/" , "/(\bcents\b)/" , "/(\bcentury\b)/" , "/(\bcertain\b)/" , "/(\bchance\b)/" , "/(\bchange\b)/" , "/(\bchart\b)/" , "/(\bcheck\b)/" , "/(\bchief\b)/" , "/(\bchild\b)/" , "/(\bchildren\b)/" , "/(\bchoose\b)/" , "/(\bchurch\b)/" , "/(\bcircle\b)/" , "/(\bcity\b)/" , "/(\bclass\b)/" , "/(\bclean\b)/" , "/(\bclear\b)/" , "/(\bclimbed\b)/" , "/(\bclose\b)/" , "/(\bclothes\b)/" , "/(\bcloud\b)/" , "/(\bcoast\b)/" , "/(\bcold\b)/" , "/(\bcolor\b)/" , "/(\bcolumn\b)/" , "/(\bcome\b)/" , "/(\bcommon\b)/" , "/(\bcompany\b)/" , "/(\bcompare\b)/" , "/(\bcomplete\b)/" , "/(\bcompound\b)/" , "/(\bconditions\b)/" , "/(\bconsider\b)/" , "/(\bconsonant\b)/" , "/(\bcontain\b)/" , "/(\bcontinued\b)/" , "/(\bcontrol\b)/" , "/(\bcook\b)/" , "/(\bcool\b)/" , "/(\bcopy\b)/" , "/(\bcorn\b)/" , "/(\bcorner\b)/" , "/(\bcorrect\b)/" , "/(\bcost\b)/" , "/(\bcotton\b)/" , "/(\bcould\b)/" , "/(\bcouldn't\b)/" , "/(\bcount\b)/" , "/(\bcountry\b)/" , "/(\bcourse\b)/" , "/(\bcovered\b)/" , "/(\bcows\b)/" , "/(\bcreate\b)/" , "/(\bcried\b)/" , "/(\bcrops\b)/" , "/(\bcross\b)/" , "/(\bcrowd\b)/" , "/(\bcurrent\b)/" , "/(\bcut\b)/" , "/(\bdance\b)/" , "/(\bdark\b)/" , "/(\bday\b)/" , "/(\bdead\b)/" , "/(\bdeal\b)/" , "/(\bdeath\b)/" , "/(\bdecided\b)/" , "/(\bdecimal\b)/" , "/(\bdeep\b)/" , "/(\bdescribe\b)/" , "/(\bdesert\b)/" , "/(\bdesign\b)/" , "/(\bdetails\b)/" , "/(\bdetermine\b)/" , "/(\bdeveloped\b)/" , "/(\bdictionary\b)/" , "/(\bdid\b)/" , "/(\bdidn't\b)/" , "/(\bdied\b)/" , "/(\bdifference\b)/" , "/(\bdifferent\b)/" , "/(\bdifficult\b)/" , "/(\bdirect\b)/" , "/(\bdirection\b)/" , "/(\bdiscovered\b)/" , "/(\bdistance\b)/" , "/(\bdivided\b)/" , "/(\bdivision\b)/" , "/(\bdo\b)/" , "/(\bdoctor\b)/" , "/(\bdoes\b)/" , "/(\bdoesn't\b)/" , "/(\bdog\b)/" , "/(\bdollars\b)/" , "/(\bdone\b)/" , "/(\bdon't\b)/" , "/(\bdoor\b)/" , "/(\bdown\b)/" , "/(\bdraw\b)/" , "/(\bdrawing\b)/" , "/(\bdress\b)/" , "/(\bdrive\b)/" , "/(\bdrop\b)/" , "/(\bdry\b)/" , "/(\bduring\b)/" , "/(\beach\b)/" , "/(\bearly\b)/" , "/(\bears\b)/" , "/(\bearth\b)/" , "/(\beast\b)/" , "/(\beasy\b)/" , "/(\beat\b)/" , "/(\bedge\b)/" , "/(\beffect\b)/" , "/(\beggs\b)/" , "/(\beight\b)/" , "/(\beither\b)/" , "/(\belectric\b)/" , "/(\belements\b)/" , "/(\belse\b)/" , "/(\bend\b)/" , "/(\benergy\b)/" , "/(\bengine\b)/" , "/(\bEngland\b)/" , "/(\bEnglish\b)/" , "/(\benjoy\b)/" , "/(\benough\b)/" , "/(\bentered\b)/" , "/(\bentire\b)/" , "/(\bequal\b)/" , "/(\bequation\b)/" , "/(\bespecially\b)/" , "/(\bEurope\b)/" , "/(\beven\b)/" , "/(\bevening\b)/" , "/(\bever\b)/" , "/(\bevery\b)/" , "/(\beveryone\b)/" , "/(\beverything\b)/" , "/(\bexactly\b)/" , "/(\bexample\b)/" , "/(\bexcept\b)/" , "/(\bexciting\b)/" , "/(\bexercise\b)/" , "/(\bexpect\b)/" , "/(\bexperience\b)/" , "/(\bexperiment\b)/" , "/(\bexplain\b)/" , "/(\bexpress\b)/" , "/(\beye\b)/" , "/(\bface\b)/" , "/(\bfact\b)/" , "/(\bfactories\b)/" , "/(\bfactors\b)/" , "/(\bfall\b)/" , "/(\bfamily\b)/" , "/(\bfamous\b)/" , "/(\bfar\b)/" , "/(\bfarm\b)/" , "/(\bfarmers\b)/" , "/(\bfast\b)/" , "/(\bfather\b)/" , "/(\bfear\b)/" , "/(\bfeel\b)/" , "/(\bfeeling\b)/" , "/(\bfeet\b)/" , "/(\bfell\b)/" , "/(\bfelt\b)/" , "/(\bfew\b)/" , "/(\bfield\b)/" , "/(\bfig\b)/" , "/(\bfight\b)/" , "/(\bfigure\b)/" , "/(\bfilled\b)/" , "/(\bfinally\b)/" , "/(\bfind\b)/" , "/(\bfine\b)/" , "/(\bfingers\b)/" , "/(\bfinished\b)/" , "/(\bfire\b)/" , "/(\bfirst\b)/" , "/(\bfish\b)/" , "/(\bfit\b)/" , "/(\bfive\b)/" , "/(\bflat\b)/" , "/(\bfloor\b)/" , "/(\bflow\b)/" , "/(\bflowers\b)/" , "/(\bfly\b)/" , "/(\bfollow\b)/" , "/(\bfood\b)/" , "/(\bfoot\b)/" , "/(\bfor\b)/" , "/(\bforce\b)/" , "/(\bforest\b)/" , "/(\bform\b)/" , "/(\bforward\b)/" , "/(\bfound\b)/" , "/(\bfour\b)/" , "/(\bfraction\b)/" , "/(\bFrance\b)/" , "/(\bfree\b)/" , "/(\bFrench\b)/" , "/(\bfresh\b)/" , "/(\bfriends\b)/" , "/(\bfrom\b)/" , "/(\bfront\b)/" , "/(\bfruit\b)/" , "/(\bfull\b)/" , "/(\bfun\b)/" , "/(\bgame\b)/" , "/(\bgarden\b)/" , "/(\bgas\b)/" , "/(\bgave\b)/" , "/(\bgeneral\b)/" , "/(\bget\b)/" , "/(\bgirl\b)/" , "/(\bgive\b)/" , "/(\bglass\b)/" , "/(\bgo\b)/" , "/(\bGod\b)/" , "/(\bgold\b)/" , "/(\bgone\b)/" , "/(\bgood\b)/" , "/(\bgot\b)/" , "/(\bgovernment\b)/" , "/(\bgrass\b)/" , "/(\bgreat\b)/" , "/(\bGreek\b)/" , "/(\bgreen\b)/" , "/(\bgrew\b)/" , "/(\bground\b)/" , "/(\bgroup\b)/" , "/(\bgrow\b)/" , "/(\bguess\b)/" , "/(\bgun\b)/" , "/(\bhad\b)/" , "/(\bhair\b)/" , "/(\bhalt\b)/" , "/(\bhand\b)/" , "/(\bhappened\b)/" , "/(\bhappy\b)/" , "/(\bhard\b)/" , "/(\bhas\b)/" , "/(\bhat\b)/" , "/(\bhave\b)/" , "/(\bhe\b)/" , "/(\bhead\b)/" , "/(\bhear\b)/" , "/(\bheard\b)/" , "/(\bheart\b)/" , "/(\bheat\b)/" , "/(\bheavy\b)/" , "/(\bheld\b)/" , "/(\bhelp\b)/" , "/(\bher\b)/" , "/(\bhere\b)/" , "/(\bhigh\b)/" , "/(\bhill\b)/" , "/(\bhim\b)/" , "/(\bhimself\b)/" , "/(\bhis\b)/" , "/(\bhistory\b)/" , "/(\bhit\b)/" , "/(\bhold\b)/" , "/(\bhole\b)/" , "/(\bhome\b)/" , "/(\bhope\b)/" , "/(\bhorse\b)/" , "/(\bhot\b)/" , "/(\bhours\b)/" , "/(\bhouse\b)/" , "/(\bhow\b)/" , "/(\bhowever\b)/" , "/(\bhuge\b)/" , "/(\bhuman\b)/" , "/(\bhundred\b)/" , "/(\bhunting\b)/" , "/(\bI\b)/" , "/(\bice\b)/" , "/(\bidea\b)/" , "/(\bif\b)/" , "/(\bI'll\b)/" , "/(\bimportant\b)/" , "/(\bin\b)/" , "/(\binches\b)/" , "/(\binclude\b)/" , "/(\bincrease\b)/" , "/(\bIndian\b)/" , "/(\bindicate\b)/" , "/(\bindustry\b)/" , "/(\binformation\b)/" , "/(\binsects\b)/" , "/(\binside\b)/" , "/(\binstead\b)/" , "/(\binstruments\b)/" , "/(\binterest\b)/" , "/(\binterest\b)/" , "/(\binto\b)/" , "/(\biron\b)/" , "/(\bis\b)/" , "/(\bisland\b)/" , "/(\bisn't\b)/" , "/(\bit\b)/" , "/(\bits\b)/" , "/(\bit's\b)/" , "/(\bitself
\b)/" , "/(\bJapanese\b)/" , "/(\bjob\b)/" , "/(\bjoined\b)/" , "/(\bjumped\b)/" , "/(\bjustkeep\b)/" , "/(\bkept\b)/" , "/(\bkey\b)/" , "/(\bkilled\b)/" , "/(\bkind\b)/" , "/(\bking\b)/" , "/(\bknew\b)/" , "/(\bknow\b)/" , "/(\bknownlady\b)/" , "/(\blake\b)/" , "/(\bland\b)/" , "/(\blanguage\b)/" , "/(\blarge\b)/" , "/(\blast\b)/" , "/(\blater\b)/" , "/(\blaughed\b)/" , "/(\blaw\b)/" , "/(\blay\b)/" , "/(\blead\b)/" , "/(\blearn\b)/" , "/(\bleast\b)/" , "/(\bleave\b)/" , "/(\bled\b)/" , "/(\bleft\b)/" , "/(\blegs\b)/" , "/(\blength\b)/" , "/(\bless\b)/" , "/(\blet\b)/" , "/(\blet's\b)/" , "/(\bletter\b)/" , "/(\blevel\b)/" , "/(\blie\b)/" , "/(\blife\b)/" , "/(\blifted\b)/" , "/(\blight\b)/" , "/(\blike\b)/" , "/(\bline\b)/" , "/(\blist\b)/" , "/(\blisten\b)/" , "/(\blittle\b)/" , "/(\blive\b)/" , "/(\blocated\b)/" , "/(\blong\b)/" , "/(\blook\b)/" , "/(\blost\b)/" , "/(\blot\b)/" , "/(\bloud\b)/" , "/(\blove\b)/" , "/(\blowmachine\b)/" , "/(\bmade\b)/" , "/(\bmain\b)/" , "/(\bmajor\b)/" , "/(\bmake\b)/" , "/(\bman\b)/" , "/(\bmany\b)/" , "/(\bmap\b)/" , "/(\bmarch\b)/" , "/(\bmark\b)/" , "/(\bmatch\b)/" , "/(\bmaterial\b)/" , "/(\bmatter\b)/" , "/(\bmay\b)/" , "/(\bmaybe\b)/" , "/(\bme\b)/" , "/(\bmean\b)/" , "/(\bmeasure\b)/" , "/(\bmeat\b)/" , "/(\bmeet\b)/" , "/(\bmelody\b)/" , "/(\bmembers\b)/" , "/(\bmen\b)/" , "/(\bmetal\b)/" , "/(\bmethod\b)/" , "/(\bmiddle\b)/" , "/(\bmight\b)/" , "/(\bmile\b)/" , "/(\bmilk\b)/" , "/(\bmillion\b)/" , "/(\bmind\b)/" , "/(\bmine\b)/" , "/(\bminutes\b)/" , "/(\bmiss\b)/" , "/(\bmodern\b)/" , "/(\bmolecules\b)/" , "/(\bmoment\b)/" , "/(\bmoney\b)/" , "/(\bmonths\b)/" , "/(\bmoon\b)/" , "/(\bmore\b)/" , "/(\bmorning\b)/" , "/(\bmost\b)/" , "/(\bmother\b)/" , "/(\bmountain\b)/" , "/(\bmouth\b)/" , "/(\bmove\b)/" , "/(\bmovement\b)/" , "/(\bmuch\b)/" , "/(\bmusic\b)/" , "/(\bmust\b)/" , "/(\bmyname\b)/" , "/(\bnation\b)/" , "/(\bnatural\b)/" , "/(\bnear\b)/" , "/(\bnecessary\b)/" , "/(\bneed\b)/" , "/(\bnever\b)/" , "/(\bnew\b)/" , "/(\bnext\b)/" , "/(\bnight\b)/" , "/(\bno\b)/" , "/(\bnor\b)/" , "/(\bnorth\b)/" , "/(\bnorthern\b)/" , "/(\bnose\b)/" , "/(\bnot\b)/" , "/(\bnote\b)/" , "/(\bnothing\b)/" , "/(\bnotice\b)/" , "/(\bnoun\b)/" , "/(\bnow\b)/" , "/(\bnumber\b)/" , "/(\bnumeralobject\b)/" , "/(\bobserve\b)/" , "/(\bocean\b)/" , "/(\bof\b)/" , "/(\boff\b)/" , "/(\boffice\b)/" , "/(\boften\b)/" , "/(\boh\b)/" , "/(\boil\b)/" , "/(\bold\b)/" , "/(\bon\b)/" , "/(\bonce\b)/" , "/(\bone\b)/" , "/(\bonly\b)/" , "/(\bopen\b)/" , "/(\bopposite\b)/" , "/(\bor\b)/" , "/(\border\b)/" , "/(\bother\b)/" , "/(\bour\b)/" , "/(\bout\b)/" , "/(\boutside\b)/" , "/(\bover\b)/" , "/(\bown\b)/" , "/(\boxygen\b)/" , "/(\bpage\b)/" , "/(\bpaint\b)/" , "/(\bpair\b)/" , "/(\bpaper\b)/" , "/(\bparagraph\b)/" , "/(\bpark\b)/" , "/(\bpart\b)/" , "/(\bparticular\b)/" , "/(\bparty\b)/" , "/(\bpassed\b)/" , "/(\bpast\b)/" , "/(\bpattern\b)/" , "/(\bpay\b)/" , "/(\bpeople\b)/" , "/(\bper\b)/" , "/(\bperhaps\b)/" , "/(\bperiod\b)/" , "/(\bperson\b)/" , "/(\bphrase\b)/" , "/(\bpicked\b)/" , "/(\bpicture\b)/" , "/(\bpiece\b)/" , "/(\bplace\b)/" , "/(\bplains\b)/" , "/(\bplan\b)/" , "/(\bplane\b)/" , "/(\bplant\b)/" , "/(\bplants\b)/" , "/(\bplay\b)/" , "/(\bplease\b)/" , "/(\bplural\b)/" , "/(\bpoem\b)/" , "/(\bpoint\b)/" , "/(\bpole\b)/" , "/(\bpoor\b)/" , "/(\bposition\b)/" , "/(\bpossible\b)/" , "/(\bpounds\b)/" , "/(\bpower\b)/" , "/(\bpractice\b)/" , "/(\bprepared\b)/" , "/(\bpresidents\b)/" , "/(\bpretty\b)/" , "/(\bprinted\b)/" , "/(\bprobably\b)/" , "/(\bproblem\b)/" , "/(\bprocess\b)/" , "/(\bproduce\b)/" , "/(\bproducts\b)/" , "/(\bproperty\b)/" , "/(\bprovide\b)/" , "/(\bpulled\b)/" , "/(\bpushed\b)/" , "/(\bputquestions\b)/" , "/(\bquickly\b)/" , "/(\bquiet\b)/" , "/(\bquite\b)/" , "/(\brace\b)/" , "/(\bradio\b)/" , "/(\brain\b)/" , "/(\braised\b)/" , "/(\bran\b)/" , "/(\brather\b)/" , "/(\breached\b)/" , "/(\bread\b)/" , "/(\bready\b)/" , "/(\breally\b)/" , "/(\breason\b)/" , "/(\breceived\b)/" , "/(\brecord\b)/" , "/(\bred\b)/" , "/(\bregion\b)/" , "/(\bremain\b)/" , "/(\bremember\b)/" , "/(\brepeated\b)/" , "/(\breport\b)/" , "/(\brepresent\b)/" , "/(\bresent\b)/" , "/(\brest\b)/" , "/(\bresult\b)/" , "/(\breturn\b)/" , "/(\brhythm\b)/" , "/(\brich\b)/" , "/(\bride\b)/" , "/(\bright\b)/" , "/(\bring\b)/" , "/(\brise\b)/" , "/(\briver\b)/" , "/(\broad\b)/" , "/(\brock\b)/" , "/(\brolled\b)/" , "/(\broom\b)/" , "/(\broot\b)/" , "/(\brope\b)/" , "/(\brose\b)/" , "/(\bround\b)/" , "/(\brow\b)/" , "/(\brule\b)/" , "/(\brun\b)/" , "/(\bsafe\b)/" , "/(\bsaid\b)/" , "/(\bsail\b)/" , "/(\bsame\b)/" , "/(\bsand\b)/" , "/(\bsat\b)/" , "/(\bsave\b)/" , "/(\bsaw\b)/" , "/(\bsay\b)/" , "/(\bscale\b)/" , "/(\bschool\b)/" , "/(\bscience\b)/" , "/(\bscientists\b)/" , "/(\bscore\b)/" , "/(\bsea\b)/" , "/(\bseat\b)/" , "/(\bsecond\b)/" , "/(\bsection\b)/" , "/(\bsee\b)/" , "/(\bseeds\b)/" , "/(\bseem\b)/" , "/(\bseen\b)/" , "/(\bsell\b)/" , "/(\bsend\b)/" , "/(\bsense\b)/" , "/(\bsent\b)/" , "/(\bsentence\b)/" , "/(\bseparate\b)/" , "/(\bserve\b)/" , "/(\bset\b)/" , "/(\bsettled\b)/" , "/(\bseven\b)/" , "/(\bseveral\b)/" , "/(\bshall\b)/" , "/(\bshape\b)/" , "/(\bsharp\b)/" , "/(\bshe\b)/" , "/(\bship\b)/" , "/(\bshoes\b)/" , "/(\bshop\b)/" , "/(\bshort\b)/" , "/(\bshould\b)/" , "/(\bshoulder\b)/" , "/(\bshouted\b)/" , "/(\bshow\b)/" , "/(\bshown\b)/" , "/(\bside\b)/" , "/(\bsight\b)/" , "/(\bsign\b)/", "/(\bjust\b)/" , "/(\bsignal\b)/" , "/(\bsilent\b)/" , "/(\bsimilar\b)/" , "/(\bsimple\b)/" , "/(\bsince\b)/" , "/(\bsing\b)/" , "/(\bsir\b)/" , "/(\bsister\b)/" , "/(\bsit\b)/" , "/(\bsix\b)/" , "/(\bsize\b)/" , "/(\bskin\b)/" , "/(\bsky\b)/" , "/(\bsleep\b)/" , "/(\bsleep\b)/" , "/(\bslowly\b)/" , "/(\bsmall\b)/" , "/(\bsmell\b)/" , "/(\bsmiled\b)/" , "/(\bsnow\b)/" , "/(\bso\b)/" , "/(\bsoft\b)/" , "/(\bsoil\b)/" , "/(\bsoldiers\b)/" , "/(\bsolution\b)/" , "/(\bsome\b)/" , "/(\bsomeone\b)/" , "/(\bsomething\b)/" , "/(\bsometimes\b)/" , "/(\bson\b)/" , "/(\bsong\b)/" , "/(\bsoon\b)/" , "/(\bsound\b)/" , "/(\bsouth\b)/" , "/(\bsouthern\b)/" , "/(\bspace\b)/" , "/(\bspeak\b)/" , "/(\bspecial\b)/" , "/(\bspeed\b)/" , "/(\bspell\b)/" , "/(\bspot\b)/" , "/(\bspread\b)/" , "/(\bspring\b)/" , "/(\bsquare\b)/" , "/(\bstand\b)/" , "/(\bstars\b)/" , "/(\bstart\b)/" , "/(\bstate\b)/" , "/(\bstatement\b)/" , "/(\bstay\b)/" , "/(\bsteel\b)/" , "/(\bstep\b)/" , "/(\bstick\b)/" , "/(\bstill\b)/" , "/(\bstone\b)/" , "/(\bstood\b)/" , "/(\bstop\b)/" , "/(\bstore\b)/" , "/(\bstory\b)/" , "/(\bstraight\b)/" , "/(\bstrange\b)/" , "/(\bstream\b)/" , "/(\bstreet\b)/" , "/(\bstretched\b)/" , "/(\bstring\b)/" , "/(\bstrong\b)/" , "/(\bstudents\b)/" , "/(\bstudy\b)/" , "/(\bsubject\b)/" , "/(\bsubstances\b)/" , "/(\bsuch\b)/" , "/(\bsuddenly\b)/" , "/(\bsuffix\b)/" , "/(\bsugar\b)/" , "/(\bsuggested\b)/" , "/(\bsum\b)/" , "/(\bsummer\b)/" , "/(\bsun\b)/" , "/(\bsupply\b)/" , "/(\bsuppose\b)/" , "/(\bsure\b)/" , "/(\bsurface\b)/" , "/(\bsurprise\b)/" , "/(\bswim\b)/" , "/(\bsyllables\b)/" , "/(\bsymbols\b)/" , "/(\bsystem\b)/" , "/(\btable\b)/" , "/(\btail\b)/" , "/(\btake\b)/" , "/(\btalk\b)/" , "/(\btall\b)/" , "/(\bteacher\b)/" , "/(\bteam\b)/" , "/(\btell\b)/" , "/(\btemperature\b)/" , "/(\bten\b)/" , "/(\bterms\b)/" , "/(\btest\b)/" , "/(\bthan\b)/" , "/(\bthat\b)/" , "/(\bthe\b)/" , "/(\btheir\b)/" , "/(\bthem\b)/" , "/(\bthemselves\b)/" , "/(\bthen\b)/" , "/(\bthere\b)/" , "/(\bthese\b)/" , "/(\bthey\b)/" , "/(\bthick\b)/" , "/(\bthin\b)/" , "/(\bthing\b)/" , "/(\bthink\b)/" , "/(\bthird\b)/" , "/(\bthis\b)/" , "/(\bthose\b)/" , "/(\bthough\b)/" , "/(\bthought\b)/" , "/(\bthousands\b)/" , "/(\bthree\b)/" , "/(\bthrough\b)/" , "/(\bthus\b)/" , "/(\btied\b)/" , "/(\btime\b)/" , "/(\btiny\b)/" , "/(\bto\b)/" , "/(\btoday\b)/" , "/(\btogether\b)/" , "/(\btold\b)/" , "/(\btone\b)/" , "/(\btoo\b)/" , "/(\btook\b)/" , "/(\btools\b)/" , "/(\btop\b)/" , "/(\btotal\b)/" , "/(\btouch\b)/" , "/(\btoward\b)/" , "/(\btown\b)/" , "/(\btrack\b)/" , "/(\btrade\b)/" , "/(\btrain\b)/" , "/(\btrain\b)/" , "/(\btravel\b)/" , "/(\btree\b)/" , "/(\btriangle\b)/" , "/(\btrip\b)/" , "/(\btrouble\b)/" , "/(\btruck\b)/" , "/(\btrue\b)/" , "/(\btry\b)/" , "/(\btube\b)/" , "/(\bturn\b)/" , "/(\btwo\b)/" , "/(\btypeuncle\b)/" , "/(\bunder\b)/" , "/(\bunderline\b)/" , "/(\bunderstand\b)/" , "/(\bunit\b)/" , "/(\buntil\b)/" , "/(\bup\b)/" , "/(\bupon\b)/" , "/(\bus\b)/" , "/(\buse\b)/" , "/(\busually\b)/" , "/(\bvalley\b)/" , "/(\bvalue\b)/" , "/(\bvarious\b)/" , "/(\bverb\b)/" , "/(\bvery\b)/" , "/(\bview\b)/" , "/(\bvillage\b)/" , "/(\bvisit\b)/" , "/(\bvoice\b)/" , "/(\bvowel\b)/" , "/(\bwait\b)/" , "/(\bwalk\b)/" , "/(\bwall\b)/" , "/(\bwant\b)/" , "/(\bwar\b)/" , "/(\bwarm\b)/" , "/(\bwas\b)/" , "/(\bwash\b)/" , "/(\bWashington\b)/" , "/(\bwasn't\b)/" , "/(\bwatch\b)/" , "/(\bwater\b)/" , "/(\bwaves\b)/" , "/(\bway\b)/" , "/(\bwe\b)/" , "/(\bwear\b)/" , "/(\bweather\b)/" , "/(\bweek\b)/" , "/(\bweight\b)/" , "/(\bwell\b)/" , "/(\bwe'll\b)/" , "/(\bwent\b)/" , "/(\bwere\b)/" , "/(\bwest\b)/" , "/(\bwestern\b)/" , "/(\bwhat\b)/" , "/(\bwheels\b)/" , "/(\bwhen\b)/" , "/(\bwhere\b)/" , "/(\bwhether\b)/" , "/(\bwhich\b)/" , "/(\bwhile\b)/" , "/(\bwhite\b)/" , "/(\bwho\b)/" , "/(\bwhole\b)/" , "/(\bwhose\b)/" , "/(\bwhy\b)/" , "/(\bwide\b)/" , "/(\bwife\b)/" , "/(\bwild\b)/" , "/(\bwill\b)/" , "/(\bwin\b)/" , "/(\bwind\b)/" , "/(\bwindow\b)/" , "/(\bwings\b)/" , "/(\bwinter\b)/" , "/(\bwire\b)/" , "/(\bwish\b)/" , "/(\bwith\b)/" , "/(\bwithin\b)/" , "/(\bwithout\b)/" , "/(\bwoman\b)/" , "/(\bwomen\b)/" , "/(\bwonder\b)/" , "/(\bwon't\b)/" , "/(\bwood\b)/" , "/(\bword\b)/" , "/(\bwork\b)/" , "/(\bworkers\b)/" , "/(\bworld\b)/" , "/(\bwould\b)/" , "/(\bwouldn't\b)/" , "/(\bwrite\b)/" , "/(\bwritten\b)/" , "/(\bwrong\b)/" , "/(\bwroteyard\b)/" , "/(\byear\b)/" , "/(\byellow\b)/" , "/(\byes\b)/" , "/(\byet\b)/" , "/(\byou\b)/" , "/(\byoung\b)/" , "/(\byour\b)/" , "/(\byou're\b)/" , "/(\byourself\b)/" , "/(\bmost\b)/" , "/(\buseful\b)/" , "/(\bthanks\b)/" , "/(\bim\b)/", "/(\bwatching\b)/", "/(\bsummer\b)/" , "/(\ba\b)/" , "/(\bb\b)/" , "/(\bc\b)/" , "/(\bd\b)/" , "/(\be\b)/" , "/(\bf\b)/" , "/(\bg\b)/" , "/(\bh\b)/" , "/(\bi\b)/" , "/(\bj\b)/" , "/(\bk\b)/" , "/(\bl\b)/" , "/(\bm\b)/" , "/(\bn\b)/" , "/(\bo\b)/" , "/(\bp\b)/" , "/(\bq\b)/" , "/(\br\b)/" , "/(\bs\b)/" , "/(\bt\b)/" , "/(\bu\b)/" , "/(\bv\b)/" , "/(\bw\b)/" , "/(\bx\b)/" , "/(\by\b)/" , "/(\bz\b)/");

$count=0;

$params = array("screen_name"=>"$profile_input","count"=>"10000","include_rts"=>"1","trim_user"=>"1");

$xml = $connection->get("statuses/user_timeline", $params);


// print_r($xml);

foreach($xml as $node){

$status = safeClean($node->text);



        $status_broken = strtok($status, " ,\n\t-/");




        while ($status_broken !== false) 

        {
          
           $status_broken = preg_replace($remove , "", strtolower($status_broken));
          
          
          if($status_broken != null) {
          
          try{
          
           $xml_ebay = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsByKeywords&SERVICE-VERSION=1.11.0&SECURITY-APPNAME=MIETb62d5-4894-49be-b294-8d5738a90bf&RESPONSE-DATA-FORMAT=XML&REST-PAYLOAD&LevelLimit=5&keywords=$status_broken&paginationInput.entriesPerPage=5" ;      
 
           $open = fopen($xml_ebay, 'r');
           $content = stream_get_contents($open);
           
           
           
           fclose($open);
           $xml_ebay1 = new SimpleXMLElement($content);
        }//try end
        
        catch (Exception $e){
        
        goto end;
        
        }//catch end
        
        
           foreach($xml_ebay1->searchResult->item as $result){
            
           $category = safeClean($result->primaryCategory->categoryName);
           
           
           $category_broken = strtok($category, " ,\n\t-/");




        while ($category_broken !== false) 

        {
        
         
         
         $query = "INSERT INTO category_list (category, full_category) VALUES ('$category_broken' , '$category' )";
            $sql_result = mysql_query($query);
            if(!$sql_result) die ("Database access failed(Insert Query): " .mysql_error());
 
 
 
         
           $category_broken = strtok(" ,\n\t-/"); 
         }//while end 2nd strtok  
           
           }//foreach_ebay end
 
         }//if end
           
        
          end :
            $status_broken = strtok(" ,\n\t-/");
          }//while end 1st strtok



}



/////////////






$query = "SELECT category, full_category, Count(*) AS Count FROM `category_list` GROUP BY full_category ORDER BY Count DESC";
$sql_result = mysql_query($query);
if(!$sql_result) die ("//Database access failed: " .mysql_error());

$row = mysql_fetch_row($sql_result);

$category = $row[0];

$full_category = $row[1];


if($category != null){
echo "<br><br><br><b>Interest list--></b><br><br>Based on statuses, the user is interested in $full_category";

$counter = 2;



if($category != null){

while($counter < 10){

$row = mysql_fetch_row($sql_result);

if ($row[0] == null){
break;
}

if(($row[0] != null) && ($row[0] != $category)){

$category = $row[0];

$full_category = $row[1];




echo "<br><br><br><br>Based on statuses, the next probable interest is $full_category";

}

}
}
}


//delete

$query = "Delete FROM category_list";
$sql_result = mysql_query($query);
if(!$sql_result) die ("Database access failed: " .mysql_error());


mysql_close($db_server);



}//main try end

catch (Exception $e){

echo "<br><b>Sorry, cannot retrieve data, please try again!</b>";

}//catch end

?>
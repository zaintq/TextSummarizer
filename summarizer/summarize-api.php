<?php
// header('Content-Type: application/json');
header("Content-Type: text/plain; charset=UTF-8");
function success($arr){
	$arr["error"] = false;
	echo json_encode($arr);
}
function error($msg, $type="unspecified"){
	echo json_encode(array("error" => true, "message" => $msg, "type" => $type));
}
function wordCount($content){
	$words = array_count_values(str_word_count($content, 1));
	$cleaned_words = array();
	foreach($words as $word => $count){
		if (!in_array(strtolower($word), stopwords("en")) && strlen($word) > 2){
			$cleaned_words[$word] = $count;
		}
	}
	arsort($cleaned_words);
	return array_slice($cleaned_words, 0, 10);
}

$textcyr="Тествам с кирилица";
$textlat="I want to live!";

$heb = ['א','ב','ג','ד','ה','ו','ז','ח','ט','י','ך','כ','ל','ם','מ','ן',
		'נ','ס','ע','ף','פ','ץ','צ','ק','ר','ש','ת',' ','׳'];

$heblit = ['ALEF','BAIS','GIMEL','DALET','HAY','VAV','ZAYIN','KHESS','TESS','YUD','KHAF2','KAF','LAMED','MEM2','MEM','NUN2',
		'NUN','SAMEKH','AYIN','FAY2','PAY','TSADI2','TSADI','KUF','RAISH','SHIN','TAF','BLANK','GERESH'];

$cyr = [
    'а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п',
    'р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',
    'А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П',
    'Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'
];

$lat = [
    'a','b','v','g','d','e','io','zh','z','i','y','k','l','m','n','o','p',
    'r','s','t','u','f','h','ts','ch','sh','sht','a','i','y','e','yu','ya',
    'A','B','V','G','D','E','Io','Zh','Z','I','Y','K','L','M','N','O','P',
    'R','S','T','U','F','H','Ts','Ch','Sh','Sht','A','I','Y','e','Yu','Ya'
];


// $he_text = "שלום! שמי מאשה. אני בן שמונה עשרה. אני גר ברוסיה. אני מהעיר ליפטסק. ליפטסק ממוקם ארבעה מאה קילומטרים דרומית למוסקבה. אבל על פי הסטנדרטים הרוסים, זה לא מרחק גדול מאוד. עזבתי את בית הספר כשהייתי בת 16 שנים, אם כי רוב התלמידים רוסים משתחררים מבית הספר בגיל שבע עשר. הסיבה לכך היא כי יום ההולדת שלי נופלת על החלק הראשון של שנת הלימודים. זה בדצמבר. אבל אני תמיד אהבתי להיות הצעיר ביותר בכיתה שלי. אני לא יודע למה. בתיכון, התחלתי ללמוד אנגלית. נכון להיום, אני לומד אנגלית במשך יותר מעשר שנים. עכשיו סיימתי השנה השנייה ללימודיה. אגב, הלכתי לאוניברסיטה וורונז, ליפטסק במקום. האוניברסיטה שלי נקראת סטייט Voronezh ואני ללמוד כלכלה. לפעמים זה מעניין, לפעמים משעמם, אבל להיות כך או כך, אני לא יודע מה העבודה היטב שילם אחרים, אני מעדיף לעבוד ככלכלן. בנוסף, יש לי קבוצה טובה מאוד. Voronezh ליפטסק הרבה יותר גדול. יש לדוגמה, ליפטסק אוכלוסייה של כ -500 000 אנשים, וורונז - יותר מ -1 מיליון בני אדם. ליפטסק ממוקם מאה קילומטרים Voronezh. Voronezh נקרא לעתים קרובות בעיר התלמידים. ישנם בתי ספר רבים וצעירים מעיירות שכנות קרובות באות לכאן כדי לרכוש השכלה. מה שזה לא יהיה אני, כמובן, יותר כמו ליפטסק, כי זה ארץ מולדתי. הוא נראה יותר נוח ומוכר לי כאן. זה הבית שלי. ובכל וורונז ', שכרתי דירה עם עוד שלושה חברים. הוא אישי מדי, אני רגיל לזה. בנוסף, יש לעיתים קרובות הרבה כיף.";
// $ru_text = "Здравствуйте! Меня зовут Маша. Мне восемнадцать лет. Я живу в России. Я из города Липецк. Липецк находится в четырехстах километрах к югу от Москвы. Но по Российским меркам это не очень большое расстояние. Я окончила школу, когда мне было 16 лет, хотя в России большинство учеников выпускаются из школы в семнадцать. Это потому, что мой день рождения приходится на первую часть учебного года. Он в декабре. Но мне всегда нравилось быть младшей ученицей в классе. Не знаю почему. В школе я начала учить английский. На сегодняшний день я изучаю английский уже более десяти лет. Сейчас я закончила второй курс университета. Кстати я поступила в университет в Воронеже, а не в Липецке. Мой университет называется Воронежский Государственный Университет, и здесь я изучаю экономику. Иногда это интересно, иногда скучно, но как бы то ни было, я не знаю, какую другую хорошо оплачиваемую работу я бы предпочла работе экономистом. Кроме того, у меня очень хорошая группа. Воронеж намного крупнее Липецка. К примеру, в Липецке население составляет около 500 000 человек, а в Воронеже – более 1 000 000 человек. Липецк находится в ста километрах от Воронежа. Воронеж часто называют городом студентов. Там находится множество учебных заведений и молодежь из соседних городов часто приезжает сюда, чтобы получить образование. Как бы то ни было я, конечно, больше люблю Липецк, ведь это моя Родина. Он кажется мне более уютным и здесь мне все знакомо. Здесь мой дом. А в Воронеже я снимаю квартиру с тремя своими друзьями. Она тоже ничего, я привыкла к ней. Кроме того, там часто бывает очень весело.";
// $en_text = "Hello! My name is Masha. I am eighteen years old. I live in Russia. I'm from the city of Lipetsk. Lipetsk is located four hundred miles south of Moscow. But according to the Russian standards, this is not a very great distance. I left school when I was 16 years old, although in the majority of Russian students are released from school at seventeen. This is because my birthday falls on the first part of the school year. It is in December. But I always liked to be the youngest in my class. I do not know why. In high school, I started to learn English. To date, I have been studying English for over ten years. Now I have finished the second year of university. By the way, I went to university in Voronezh, Lipetsk instead. My university is called the Voronezh State University and I study economics. Sometimes it's interesting, sometimes boring, but be that as it may, I do not know what other well-paid job, I would prefer to work as an economist. In addition, I have a very good group. Voronezh Lipetsk much larger. For example, in Lipetsk has a population of about 500 000 people, and in Voronezh - more than 1 million people. Lipetsk is located a hundred kilometers from Voronezh. Voronezh is often called the city of students. There are many schools and young people from neighboring towns often come here to get an education. Whatever it was I, of course, more like Lipetsk, because it is my native land. He seems more comfortable and familiar to me here. This is my home. And in Voronezh, I rented an apartment with three friends. It is too personal, I'm used to it. In addition, there is often a lot of fun.";

// $textcyr = str_replace($cyr, $lat, $ru_text);
// $textlat = str_replace($lat, $cyr, $textcyr);

// echo("$textcyr \n\n");
// echo("$textlat \n\n");

// die();

// $_POST   = array("type" => "text", "value" => $he_text, "lang" => "he");

error_reporting(error_reporting() & (-1 ^ E_DEPRECATED));

require_once 'summarizer.php';
require_once 'html_functions.php';
require_once 'simple_html_dom.php';
include ("en_stopwords.php");

$summarizer = new Summarizer();

if(isset($_POST["type"]) && isset($_POST["value"])){

	if (isset($_POST["lang"])) {
		$lang = $_POST["lang"];
	}else{
		$lang = "en";
	}

	if($_POST["type"] == "url"){
		$url =  $_POST["value"];
		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			$html    = file_get_html($url);
			$content = "";
			foreach($html->find('p') as $e){
				$clear = strip_tags($e->plaintext);
				$clear = html_entity_decode($clear);
				$clear = urldecode($clear);
				// $clear = preg_replace('/[^A-Za-z0-9.,/']/', ' ', $clear);
				// $clear = preg_replace('/ +/', ' ', $clear);
				$clear = trim($clear);
				$test = explode(" ", $clear);
				if (sizeof($test) > 5)
					$content .= $clear ."\n";
			}
			
			if($lang == "ru"){
				$content = str_replace($cyr, $lat, $content);
			}else if($lang == "he"){
				$content = str_replace($heb, $heblit, $content);
			}

			$words   = wordCount($content);
			$content = implode("\n", array_unique(explode("\n", $content)));
		} else {
		    error("$url is not a valid URL", "url");
		}
	}else if($_POST["type"] == "text"){

		$content = $_POST["value"];
		// echo "**original:** $content \n\n";
		if($lang == "ru"){
			$content = str_replace($cyr, $lat, $content);
			// echo "**converted:** $content \n\n";
		}else if($lang == "he"){
			$content = str_replace($heb, $heblit, $content);
		}
		
		$words   = wordCount($content);
	}

	// echo "**echoing:** $content \n\n";

	if (isset($content) && isset($words)){
		$content = normalizeHtml($content);
		$rez = $summarizer->summary($content);
		$summary = implode(' ',$rez);
	
		if(!empty($summary)){
			if($lang == "ru"){
				$summary = str_replace($lat, $cyr, $summary);
				foreach ($words as $word => $count) { 
					$new_word = str_replace($lat, $cyr, $word);
					$words[$new_word] = $words[$word];
					unset($words[$word]);
				}
				// echo "**summary:** $summary \n\n";
			}else if($lang == "he"){
				$summary = str_replace($heblit, $heb, $summary);
				foreach ($words as $word => $count) { 
					$new_word = str_replace($heblit, $heb, $word);
					$words[$new_word] = $words[$word];
					unset($words[$word]);
				}
			}

			success(array("message" => "Summary successful!", "summary" => preg_split("/[\n.]+/", $summary), "words" => $words));
		}
		else
			error("Unable to summarize content.", "Summarizing");
	}
}else{
	error("No Params");
}

?>
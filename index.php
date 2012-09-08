<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="author" content="Lukas Oppermann - veare.net" />
	<meta name="keywords" content="keywords" />
	<meta name="description" content="description" />
	<meta name="robots" content="index,follow" />
	<meta name="language" content="de" />
	<link rel="stylesheet" type="text/css" href="./libs/css/screen.css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600italic' rel='stylesheet' type='text/css'>
	<title>Moving Systems</title>
</head>
<body>
	<div class="header">
		<div class="header-content">
			<div class="logo">
				<img src="./layout/moving-systems-logo.png">
			</div>
			<div class="slider">
				<div class="slide" id="quote_one">
					<img src="./images/banner_two.png">
					<div class="slide-quote">
						<blockquote>„Ein Körper ist ein Aufflammen.“</blockquote>
						<div class="author">~ J.-L.Nancy</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="menu">
		<ul>
			<li class="logo-small"><a href="#top"><img src="./layout/moving-systems-logo-small.png" /></a></li>
			<li class="menu-link"><a href="#moving-systems">Was ist <span class="highlight">moving systems</span></a></li>
			<li class="menu-link"><a href="#about">Über uns</a></li>
			<li class="menu-link"><a href="#angebote">Angebote</a></li>
			<li class="menu-link"><a href="#empfehlungen">Empfehlungen</a></li>
			<li class="menu-link"><a href="#downloads">Downloads</a></li>
			<li class="menu-link"><a href="/blog/">Blog</a></li>
			<li class="menu-link"><a href="#kontakt">Kontakt</a></li>
		</ul>
	</div>
	<div class="container">
		<div class="news">
			<h3>Neues von uns</h3>
			<ul id="tweets">
			<?php
				// twitter user name
				$twitterid = "movingsystems";
				// link fn
				function change_link($string, $urls)
				{
					if( isset($urls) && is_array($urls) )
					{
						foreach($urls as $url)
						{
							$string = str_replace($url['url'], "<a rel=\"nofollow\" target=\"_blank\" href='".$url['expanded_url']."'>".$url['expanded_url']."</a>", $string);
					  	}
					}
					$string = preg_replace('!http://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', '<a href="\\0" target="_blank">\\0</a>', $string);
					return $string;
				}
				
				function tweet_time($t)
				{
					// clean
					$time_date = substr($t, 5, -6);
					// get tome
					$time = substr($time_date, -8);
					// get date
					$date = substr($time_date,0, 11);
					$date_arr = explode(' ',$date);
					// get month
					$m = array('jan' => '01', 'feb' => '02', 'mar' => '03', 'apr' => '04', 'may' => '05', 'jun' => '06', 'jul' => '07', 'aug' => '08', 'sep' => '09', 'oct' => '10', 'nov' => '11', 'dec' => '12');
					// build new date time string
					$time_date = $date_arr[2].'-'.$m[strtolower($date_arr[1])].'-'.$date_arr[0].' '.$time;
					//
					return $time_date;
				}
	
				function getLatestTweet($t_json, $twitterid)
				{
					$curl = curl_init();
					curl_setopt( $curl, CURLOPT_URL, $t_json );
					curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
					$result = curl_exec( $curl );
					curl_close( $curl );
					$tweets = json_decode($result, TRUE);
					//
					foreach($tweets as $tweettag)
					{
						$time_date = tweet_time($tweettag['created_at']);
						$tweettime = (human_to_unix($time_date))+3600; // time difference - UK + 1 hours (3600s)
						$timeago = (time()-$tweettime);
						$thehours = floor($timeago/3600);
						$theminutes = floor($timeago/60);
						$thedays = floor($timeago/86400);
						if($theminutes < 60)
						{
							if($theminutes < 1)
							{
					 			$timemessage =  "Less than 1 minute ago";
							}
							elseif($theminutes == 1) 
							{
					 			$timemessage = $theminutes." minute ago.";
					 		}
							else
							{
					 			$timemessage = $theminutes." minutes ago.";
					 		}
		
						} 
						elseif($theminutes > 60 && $thedays < 1)
						{
					 		if($thehours == 1)
							{
					 			$timemessage = $thehours." hour ago.";
					 		} 
							else 
							{
					 			$timemessage = $thehours." hours ago.";
					 		}
						} 
						else
						{
					 		if($thedays == 1)
							{
					 			$timemessage = $thedays." day ago.";
					 		}
							else
							{
								$timemessage = $thedays." days ago.";
						}
					}
					echo "<li class='tweet'>".
					// time
					//"<span class='tweet-time'>".$timemessage."</span>".
					"<a target='_blank' rel='nofollow' class='tweet-link' href='https://twitter.com/#!/".$twitterid.'/status/'.$tweettag['id_str']."'>".
					// tweets
					change_link($tweettag["text"], $tweettag['entities']['urls'])."</a><br />\n"
					."</li>\n";
					}
				}
				
				$count = 6;
				// $tweets_json = "http://search.twitter.com/search.json?q=from:".$twitterid."&rpp=".$count."&with_twitter_user_id=true&include_entities=true";
				$tweets_json = "https://twitter.com/statuses/user_timeline/movingsystems.json";
				getLatestTweet($tweets_json, $twitterid);
	
				function human_to_unix($datestr = '')
				{
					if ($datestr == '')
					{
						return FALSE;
					}

					$datestr = trim($datestr);
					$datestr = preg_replace("/\040+/", ' ', $datestr);

					if ( ! preg_match('/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}\s[0-9]{1,2}:[0-9]{1,2}(?::[0-9]{1,2})?(?:\s[AP]M)?$/i', $datestr))
					{
						return FALSE;
					}

					$split = explode(' ', $datestr);

					$ex = explode("-", $split['0']);

					$year  = (strlen($ex['0']) == 2) ? '20'.$ex['0'] : $ex['0'];
					$month = (strlen($ex['1']) == 1) ? '0'.$ex['1']  : $ex['1'];
					$day   = (strlen($ex['2']) == 1) ? '0'.$ex['2']  : $ex['2'];

					$ex = explode(":", $split['1']);

					$hour = (strlen($ex['0']) == 1) ? '0'.$ex['0'] : $ex['0'];
					$min  = (strlen($ex['1']) == 1) ? '0'.$ex['1'] : $ex['1'];

					if (isset($ex['2']) && preg_match('/[0-9]{1,2}/', $ex['2']))
					{
						$sec  = (strlen($ex['2']) == 1) ? '0'.$ex['2'] : $ex['2'];
					}
					else
					{
						// Unless specified, seconds get set to zero.
						$sec = '00';
					}

					if (isset($split['2']))
					{
						$ampm = strtolower($split['2']);

						if (substr($ampm, 0, 1) == 'p' AND $hour < 12)
							$hour = $hour + 12;

						if (substr($ampm, 0, 1) == 'a' AND $hour == 12)
							$hour =  '00';

						if (strlen($hour) == 1)
							$hour = '0'.$hour;
					}

					return mktime($hour, $min, $sec, $month, $day, $year);
				}
			?>
			</ul>
			<a class="follow" target="_blank" href="https://twitter.com/movingsystems">folgen Sie ins auf Twitter</a>
		</div>
		<div class="content">
			<section>
				<h2 class="main-headline"><a name="moving-systems">Was ist moving systems</a></h2>
				<div class="column">
				<p>moving systems beschreibt die Verbindung aus systemischem Denken und Handeln mit den Gegebenheiten der körperlichen Präsenz. Körper bewegen Systeme. Veränderung in diesen Systemen braucht kluge Köpfe, Körper und Systemstruktur.</p>
				</div><div class="column">
					<p>Wir begreifen Körper in Organisationen systemisch: körperliche Präsenz folgt den Gesetzen des Systems und ist von Umfeld und Deutung abhängig.</p>
					<p>Das unbekannte Dritte: die Verbindung von Person und System.</p>
				</div>
			</section>
			<section>
				<h2 class="main-headline"><a name="about">Über uns</a></h2>
				<p class="excerpt">Wir stehen für eine synergetische Arbeit vor dem  Hintergrund der Systemtheorie und der prozessorientierten und praxisorientierten Körperanalyse.</p>
				<div class="column">
					<h3>Marion Schenk</h3>
					<p>Diplom Psych., Diplom Kffr.</p>
					<p>Ausbildung in systemischer- und prozessorientierter Organisationsberatung</p>
					<p>Seit 1999 Mitinhaberin der Beratungssozietät Oppermann Schenk</p>
					<p>seit 2001 Geschäftsführerin und Trainerin im Institut Systemische Beratung Berlin ISBB</p>
				</div><div class="column">
					<h3>Alexander Veit</h3>
					<p>freier Regisseur und Dozent für nonverbale Kommunikation</p>
					<p>Ausbildung zum Pantomimen in London im Mime Centre London (Adam Darius), Studium Kunst an der Akademie der Bildenden Künste, München</p>
					<p>Pantomime Soloprogramme</p>
					<p>Seminare zu Theater und nonverbaler Kommunikation seit 1990</p>
					<p>Oper- und Theaterinszenierungen in Freising/München 2000 bis 2011</p>
					</p>
				</div>
			</section>
			<section>		
				<h2 class="main-headline"><a name="angebote">Angebote</a></h2>
				<h3>Führung</h3>
				<div class="column">
					<p>Neben Führungstechniken, Motivation, Analyse der eigenen Wirkung und der systemischen Einbettung von Führungshandeln in der Organisation stehen Fragen von Status, Macht, Körper und körperliche Präsenz im Mittelpunkt.</p>
					<p>Die Verbindung von Persona und Wirkung, mit Handeln und Entscheiden im Führungskontext.</p>
				</div><div class="column">
					<p>Sagen Sie uns, wie Sie Führung und Macht als Phänomen der Organisation und die Entstehung in systemischer Sicht begreifen. Ist Macht durch Gesten eine Macht der Körperlichkeit?</p>
				</div>
			</section>
			<section>
				<h3>Wirkung, Status und Auftritt</h3>
				<div class="column">
					<p>Um über reines Präsenztraining hinauszugehen, arbeiten wir an und mit den Begriffen des Status, sowohl verbal, nonverbal als auch systemgebunden.
				Es werden Fragen von Status und der im inliegenden gewünschten Bedeutung im System beobachtet. Ebenso stellen wir die Frage von  Status und Körper als Ordnungsprinzip.</p>
				</div><div class="column">
					<p>Wie kann die eigene Wirkung optimiert werden? Dabei berücksichtigen wir immer den Kontext und die Umgebung in der diese stattfinden soll.</p>
					<p>Sagen Sie uns, in welchem System Sie arbeiten. Sagen Sie uns wie Sie Wirkung erzielen wollen. Ermitteln Sie: welches Charisma passt zu Ihrer Führungskraft.</p>
				</div>
			</section>
			<section>
				<h3>Veränderungsprozesse und Kultur</h3>
				<div class="column">
					<p>Wenn Systeme und Organisationen sich verändern und entwickeln kommen auch die Menschen in Bewegung. Bewegung wird körperlich als auch kulturell und atmosphärisch sichtbar.</p>
				</div><div class="column">
					<p>Welche Form von Bewegung unterstützt Prozesse? Wie wirken Statik und Bewegung in Organisationen. Woran macht sich Kultur und Kulturveränderung fest?</p>
					<p>Sagen Sie uns, welchen Stellenwert Körperlichkeit in Ihrem System einnimmt. Sagen Sie uns, wie Sie Ihre Produkte begehrenswert und attraktiv machen.</p>
				</div>
			</section>
			<section>
				<h3>Diversitiy</h3>
				<div class="column">
					<p>Welchen Unterschied machen Unterschiede?  Wie können systemisches Wissen und das Wissen um die Unterschiede in körperlicher Präsenz, Gestik, Mimik und Sprache genutzt werden um Diversität zu fördern? Wir wollen Stärken stärken und Unterschiede positiv nutzen. Dabei geht es sowohl um den Auftritt von Frauen in Machtumgebungen als auch kulturelle Unterschiede in Präsenz, Sprache und Gestik.</p>
				</div><div class="column">
					<p>Sagen Sie uns welche Gruppen in ihrer Organisation unterrepräsentiert sind. Welcher Personenkreis soll gefördert werden, mit welchem Nutzen für Mensch und Organisation?</p>
				</div>
			</section>
			<section>
				<h2 class="main-headline"><a name="empfehlungen">Empfehlungen</a></h2>
			</section>
			<section>
				<h2 class="main-headline"><a name="downloads">Downloads</a></h2>
			</section>
			<section>
				<h2 class="main-headline"><a name="kontakt">Kontakt</a></h2>
			</section>
		</div>
	</div>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script src="./libs/js/base-0.0.1.js"></script>
</html>
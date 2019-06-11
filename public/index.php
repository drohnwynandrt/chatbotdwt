<?php


require '../vendor/autoload.php';


use \LINE\LINEBot\SignatureValidator as SignatureValidator;


// initiate app
$configs =  [
	'settings' => ['displayErrorDetails' => true],
];
$app = new Slim\App($configs);

/* ROUTES */
$app->get('/', function ($request, $response) {
	return $response->withStatus(200, 'Okido');
});

$app->post('/', function ($request, $response)
{
	// get request body and line signature header
	$body 	   = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];

	// log body and signature
	file_put_contents('php://stderr', 'Body: '.$body);

	// is LINE_SIGNATURE exists in request header?
	if (empty($signature)){
		return $response->withStatus(400, 'Signature not set');
	}

	// is this request comes from LINE?
	if($_ENV['PASS_SIGNATURE'] == false && ! SignatureValidator::validateSignature($body, $_ENV['CHANNEL_SECRET'], $signature)){
		return $response->withStatus(400, 'Invalid signature');
	}
	// init bot
	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);
	$data = json_decode($body, true);
	foreach ($data['events'] as $event)
	{
		$userMessage = $event['message']['text'];
		$senderUserId = $event['source']['userId'];
		if(strtolower($userMessage) == 'hallo')
		{
			$message = "Hallo Gorilla";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}


	   if(strtolower($userMessage) == 'afspraak')
		{
			$message = "Kun je vanmiddag om 15:00 ?";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}



     if(strtolower($userMessage) == 'sticker')
		{
	
            $mysticker = new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder("11538", "51626501");
			$result = $bot->replyMessage($event['replyToken'], $mysticker);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}

		if(strtolower($userMessage) == 'ik hou van jou')
		{
	
            $mysticker = new \LINE\LINEBot\MessageBuilder\StickerMessageBuilder("11538", "51626495");
			$result = $bot->replyMessage($event['replyToken'], $mysticker);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}

		
		if(strtolower($userMessage) == 'wie ben jij?')
		{
	
            $myimage = new \LINE\LINEBot\MessageBuilder\ImageMessageBuilder( "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBMYkESnxGma0tuuNwLzjjy5yVuDiXJ9JILoo1bvUY_ZDcxy9q8w" , "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRBMYkESnxGma0tuuNwLzjjy5yVuDiXJ9JILoo1bvUY_ZDcxy9q8w");
			$result = $bot->replyMessage($event['replyToken'], $myimage);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}


		if(stripos($userMessage, "hallo chatbot") !== false)
		{
			$message1 = "Hoe ken jij mijn naam stalker?";
			$message2= "Vertel het me!";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message1, $message2);
			$result = $bot->pushMessage($senderUserId, $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}
		if(stripos($userMessage, "open") !== false)

		{
			$message = "Wij zijn geopend op Maandag-Vrijdag van 9.00 tot 17.00. Op zaterdag zijn wij open van 10.00 tot 15.00. Zondag zijn wij gesloten.";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$result = $bot->pushMessage($senderUserId, $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
		}

		if(stripos($userMessage, "multi") !== false)

		{
			$message = $senderUserId;
			$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$receiversIds=[$senderUserId, 'U45ee1ee091ea49700b5f2491a6c09fcc'];
			$result = $bot->multicast($receiversIds, $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		}

	if(strtolower($userMessage) == 'smile')
	{
		$message = "I'm happy! \xF0\x9F\x98\x81" ;
		$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
		$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
		return $result->getHTTPStatus() . ' ' . $result->getRawBody();
	
	}

	if(strtolower($userMessage) == 'schedule')
	{
		$datajson = file_get_contents('chatbotdwt.json');
		$datajsonn='{
			"type": template,
			"altText": this is a carousel template,
			"template": {
			  "type": carousel,
			  "actions": [],
			  "columns": [
				{
				  "thumbnailImageUrl": https://www.bostonmagazine.com/wp-content/uploads/sites/2/2018/10/massage-boston-1.jpg,
				  "title": Massage,
				  "text": Do you want to schedule a massage?,
				  "actions": [
					{
					  "type": datetimepicker,
					  "label": Schedule,
					  "data": Date,
					  "mode": datetime,
					  "initial": 2019-06-06T15:32,
					  "max": 2019-12-31T15:32,
					  "min": 2018-06-06T15:32
					}
				  ]
				}
			  ]
			}
		  }';
		$myanswer= json_decode($datajsonn);
		$message = $myanswer;
		$CarouselTemplateBuilder = new LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder($message);
		$result = $bot->replyMessage($event['replyToken'], $CarouselTemplateBuilder);
		return $result->getHTTPStatus() . ' ' . $result->getRawBody();
	
	}
	if(strtolower($userMessage) == 'obj')
	{	$json = '{"foo-bar":123}';
		$obj=json_decode($json);
		$message = $obj->{'foo-bar'};
		$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
		$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
		return $result->getHTTPStatus() . ' ' . $result->getRawBody();
	
	}

	
}
});

// $app->get('/push/{to}/{message}', function ($request, $response, $args)
// {
// 	$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
// 	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);

// 	$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($args['message']);
// 	$result = $bot->pushMessage($args['to'], $textMessageBuilder);

// 	return $result->getHTTPStatus() . ' ' . $result->getRawBody();
// });

/* JUST RUN IT */
$app->run();
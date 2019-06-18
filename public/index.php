<?php


require '../vendor/autoload.php';

use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\Uri\AltUriBuilder;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\Constant\Flex\ComponentButtonStyle;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpaceSize;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpacerComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use LINE\LINEBot\TemplateActionBuilder;

use \LINE\LINEBot\SignatureValidator as SignatureValidator;
/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FlexSampleRestaurant
{

    /**
     * Create sample restaurant flex message
     *
     * @return \LINE\LINEBot\MessageBuilder\FlexMessageBuilder
     */


    public static function get()
    {
        return FlexMessageBuilder::builder()
            ->setAltText('Restaurant')
            ->setContents(
                BubbleContainerBuilder::builder()
//                    ->setHero(self::createHeroBlock())
                    ->setBody(self::createBodyBlock())
                    ->setFooter(self::createFooterBlock())
            );
    }
    // private static function createHeroBlock()
    // {
    //     $mainimage = 'https://www.amrathhotelempereur.nl/heading/restaurant_4.jpg';
    //     return ImageComponentBuilder::builder()
    //         ->setUrl($mainimage)
    //         ->setSize(ComponentImageSize::FULL)
    //         ->setAspectRatio(ComponentImageAspectRatio::R20TO13)
    //         ->setAspectMode(ComponentImageAspectMode::COVER)
    //         ->setAction(
    //             new UriTemplateActionBuilder(
    //                 null,
    //                 'https://example.com',
    //                 new AltUriBuilder('https://example.com#desktop')
    //             )
    //         );
    // }
    private static function createBodyBlock()
    {
        $title = TextComponentBuilder::builder()
            ->setText('Brown Cafe')
            ->setWeight(ComponentFontWeight::BOLD)
            ->setSize(ComponentFontSize::XL);
        $goldStar = IconComponentBuilder::builder()
            ->setUrl('https://example.com/gold_star.png')
            ->setSize(ComponentIconSize::SM);
        $grayStar = IconComponentBuilder::builder()
            ->setUrl('https://example.com/gray_star.png')
            ->setSize(ComponentIconSize::SM);
        $point = TextComponentBuilder::builder()
            ->setText('4.0')
            ->setSize(ComponentFontSize::SM)
            ->setColor('#999999')
            ->setMargin(ComponentMargin::MD)
            ->setFlex(0);
        $review = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setMargin(ComponentMargin::MD)
            ->setContents([$goldStar, $goldStar, $goldStar, $goldStar, $grayStar, $point]);
        $place = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('Place')
                    ->setColor('#aaaaaa')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText('Miraina Tower, 4-1-6 Shinjuku, Tokyo')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(5)
            ]);
        $time = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::BASELINE)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([
                TextComponentBuilder::builder()
                    ->setText('Time')
                    ->setColor('#aaaaaa')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(1),
                TextComponentBuilder::builder()
                    ->setText('10:00 - 23:00')
                    ->setWrap(true)
                    ->setColor('#666666')
                    ->setSize(ComponentFontSize::SM)
                    ->setFlex(5)
            ]);
        $info = BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setMargin(ComponentMargin::LG)
            ->setSpacing(ComponentSpacing::SM)
            ->setContents([$place, $time]);
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setContents([$title, $review, $info]);
    }
    private static function createFooterBlock()
    {
        $callButton = ButtonComponentBuilder::builder()
            ->setStyle(ComponentButtonStyle::LINK)
            ->setHeight(ComponentButtonHeight::SM)
            ->setAction(
                new UriTemplateActionBuilder(
                    'CALL',
                    'https://example.com',
                    new AltUriBuilder('https://example.com#desktop')
                )
            );
        $websiteButton = ButtonComponentBuilder::builder()
            ->setStyle(ComponentButtonStyle::LINK)
            ->setHeight(ComponentButtonHeight::SM)
            ->setAction(
                new UriTemplateActionBuilder(
                    'WEBSITE',
                    'https://example.com',
                    new AltUriBuilder('https://example.com#desktop')
                )
            );
        $spacer = new SpacerComponentBuilder(ComponentSpaceSize::SM);
        return BoxComponentBuilder::builder()
            ->setLayout(ComponentLayout::VERTICAL)
            ->setSpacing(ComponentSpacing::SM)
            ->setFlex(0)
            ->setContents([$callButton, $websiteButton, $spacer]);
    }
}

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

        if(stripos($userMessage, "locatie") !== false)
		{
			$message = "Je kunt ons vinden aan de Stationsweg 1A in Groningen."
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
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
        
        if((stripos($userMessage, "tarief")) !== false && (stripos($userMessage, "haar")) !== false)

		{
			$message = "Haar: 20 Euro ";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$result = $bot->pushMessage($senderUserId, $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
        }

        else if((stripos($userMessage, "tarief")) !== false && (stripos($userMessage, "facemask")) !== false)

		{
			$message = "Facemask: 30 Euro ";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$result = $bot->pushMessage($senderUserId, $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
        }
        else if((stripos($userMessage, "tarief")) !== false && (stripos($userMessage, "massage")) !== false)

		{
			$message = "Massage: 15 Euro ";
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
			$result = $bot->pushMessage($senderUserId, $textMessageBuilder);
			return $result->getHTTPStatus() . ' ' . $result->getRawBody();
		
        }
        else if (stripos($userMessage, "tarief") !== false)

		{
			$message = "Haar: 20 Euro\nFacemask: 30 Euro\nMassage: 15 Euro";
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

	if(strtolower($userMessage) == 'ext')

	{	$externalreply=file_get_contents('chatbotdwt.json');
		$message = $externalreply;
		$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
		$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
		return $result->getHTTPStatus() . ' ' . $result->getRawBody();
	
	}	

	if(strtolower($userMessage) == 'arrdata')

	{	
		$data = '{
			"name": "Drohn",
			"race": "Human"
		}';

		$message = json_decode($data)->name;
		$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
		$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
		return $result->getHTTPStatus() . ' ' . $result->getRawBody();
	}	

	if(strtolower($userMessage) == 'ok2')

	{
        class otherrest extends FlexSampleRestaurant{
            
        }
		$data = otherrest::get();
		file_put_contents('php://stderr', 'reply data: ' . print_r($data, true));
		  $result = $bot->replyMessage($event['replyToken'], $data);
		  //return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
		  return $result->getHTTPStatus() . ' ' . $result->getRawBody();
	  
    }
    
    if(strtolower($userMessage) == 'test')
    {
        $message = "TEST OK";
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
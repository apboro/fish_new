<?
class Parserlink
{
    protected $baseUrl = 'https://example.com';
    protected $url = 'https://example.com/need/';
    protected $postData = array();
    protected $response = array();
    protected $parseData = array();

    public static function create()
    {
        return new static();
    }

    public function setBaseUrl($baseUrl) 
    {
        $this->baseUrl = $baseUrl;
        
        return $this;
    }

    public function getBaseUrl() 
    {
        return $this->baseUrl;
    }

    public function setUrl($url) 
    {
        $this->url = $url;
        
        return $this;
    }

    public function getUrl() 
    {
        return $this->url;
    }

    public function setPostData($postData = array()) 
    {
        $this->postData = $postData;
        
        return $this;
    }

    public function getPostData() 
    {
        return $this->postData;
    }

    public function setResponse($response) 
    {
        $this->response = $response;
        
        return $this;
    }

    public function getResponse() 
    {
        return $this->response;
}
 
    public function parse() 
    {
        preg_match('#<a href="(/do.*.xls)"#', $this->response['data'], $dataDetail);

        $this->parseData = array(
            'LINK' => $dataDetail[1],
            'FULL_LINK' => $this->baseUrl . $dataDetail[1]
        );

        return $this;
    }

    public function getLink() 
    {
        return $this->parseData['LINK'];
    }

    public function getFullLink() 
    {
        return $this->parseData['FULL_LINK'];
    }
    
    public function send() 
    {
        $errors = array ();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_REFERER, $this->baseUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->postData));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $response['data'] = curl_exec($ch);

        $ci = curl_getinfo($ch);
        if($ci['http_code'] != 200 && $ci['http_code'] != 404) {
            $errors = array (1, $this->url, $ci['http_code']);
        }
        $response['code'] = $ci['http_code'];
        $response['errors'] = $errors;
        curl_close($ch);

        return $this->setResponse($response);
    }

    public function sendNext() 
    {
        $errors = array();
        $timestamp = time();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->getRandomUserAgent());
        curl_setopt($ch, CURLOPT_URL, "http://moscanella.ru/Opt.aspx");
        curl_setopt($ch, CURLOPT_REFERER, $this->baseUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      	   curl_setopt ($ch, CURLOPT_COOKIE, ".ASPXANONYMOUS=m513gaLZ1wEkAAAAODk1ZGFkNzUtY2NmYi00MDI0LTkzY2YtM2YxYTZkZGI1Y2Q4rWgms_PYEIGXgA_fvWjckOV49YhiEKP8aC9xOnk5g-A1; ASP.NET_SessionId=4a1tubidp0j1gs00h5o4mj0j; NOPCOMMERCE.AUTH=D9C8656D0F1BDA68E9A459C77F54522592AEB70866DF7CD8B879295BA3CBD9024A8253BCE95B6E2CF71F60D3CDADB6AD0C897C9FEFA1FB0D78209F7A6174307BDE2B83314CF6D6D19861F1FBDB9E3DD19F72643DAD1BD78D49063975299FB5E49A23B13E1BC744384F02C35B933D35B2EB53FEC0F638092311162C5278943FF6237213A86D20CF35AC94A20727BC556454D91274D67FFED400838539F78B4389; Nop.CustomerSessionGUIDCookie=50605cef-065b-404a-9155-f1443a9b22ce");

        $response['data'] = curl_exec($ch);

        $ci = curl_getinfo($ch);
        if($ci['http_code'] != 200 && $ci['http_code'] != 404) {
            $errors = array (1, $this->url, $ci['http_code']);
        }
        $response['code'] = $ci['http_code'];
        $response['errors'] = $errors;
        curl_close($ch);

        return $this->setResponse($response);
    }

    public function getRandomUserAgent()
    {
        $userAgents = array (
            'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.1',
            'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A',
            'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)',
            'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
            'Mozilla/5.0 (Windows; U; Win 9x 4.90; SG; rv:1.9.2.4) Gecko/20101104 Netscape/9.1.0285',
            'Lynx/2.8.8dev.3 libwww-FM/2.14 SSL-MM/1.4.1',
            'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko',
        );
        $random = mt_rand(0, count($userAgents)-1);

        return $userAgents[$random];
    } 
}

$data = array(
    '__EVENTTARGET' => '',
    '__EVENTARGUMENT' => '',
    '__VIEWSTATE' => '/wEPDwUKMTc5MDQ5OTc2OA9kFgJmD2QWBmYPZBYEAgMPFgIeB2NvbnRlbnQFtwLQoNGL0LHQvtC70L7QstC90YvQtSDQsdC70L7Qs9C4LCDQvdC+0LLQvtGB0YLQuCDRgNGL0LHQvtC70L7QstC90L7Qs9C+INGA0YvQvdC60LAuINCg0YvQsdC+0LvQvtCy0L3Ri9C1INGC0L7QstCw0YDRiyDQvtC/0YLQvtC8OiBBbnJlJ3MsIEJhbmF4LCBCcmlzY29sYSwgRGFpd2EsIERVTywgR0FELCBHYXJ5IFlhbWFtb3RvLCBJTUEsIElzc2VpLCBNZWdhYmFzcywgTUVJSE8gVmVyc3VzLCBPU1AsIE93bmVyL0PigJl1bHRpdmEsIFBhbmFjZWEsIFBvbnRvb24yMSwgUkFJRCBKYXBhbiwgU3QuQ3JvaXgsIFRydW1wLCBWYWxrZUlOLCBaaXBCYWl0c2QCBA8WAh8ABb8B0JrQvtC80L/QsNC90LjRjyDQnNC+0YHQutCw0L3QtdC70LvQsC4g0J7RhNC40YbQuNCw0LvRjNC90YvQuSDRgdCw0LnRgi4g0KDRi9Cx0L7Qu9C+0LLQvdGL0LUg0YLQvtCy0LDRgNGLINCyINCg0L7RgdGB0LjQuC4g0KDRi9Cx0L7Qu9C+0LLQvdGL0LUg0YLQvtCy0LDRgNGLINCg0L7RgdGB0LjRjiDQu9GD0YfRiNC40Lkg0YHQsNC50YJkAgIPZBYCAgYPZBYGAgEPZBYCAgMPFgIeB1Zpc2libGVoFgJmDw9kFgIeCW9ua2V5ZG93bgW7AWlmKGV2ZW50LndoaWNoIHx8IGV2ZW50LmtleUNvZGUpe2lmICgoZXZlbnQud2hpY2ggPT0gMTMpIHx8IChldmVudC5rZXlDb2RlID09IDEzKSkge2RvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdjdGwwMF9jcGgxX3RvcFRvcGljX2J0blBhc3N3b3JkJykuY2xpY2soKTtyZXR1cm4gZmFsc2U7fX0gZWxzZSB7cmV0dXJuIHRydWV9OyBkAgMPZBYCZg9kFgRmD2QWAgIDDxYCHwFoFgJmDw9kFgIfAgXBAWlmKGV2ZW50LndoaWNoIHx8IGV2ZW50LmtleUNvZGUpe2lmICgoZXZlbnQud2hpY2ggPT0gMTMpIHx8IChldmVudC5rZXlDb2RlID09IDEzKSkge2RvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdjdGwwMF9jcGgxX2N0bDAwX3RtcFRvcGljX2J0blBhc3N3b3JkJykuY2xpY2soKTtyZXR1cm4gZmFsc2U7fX0gZWxzZSB7cmV0dXJuIHRydWV9OyBkAgMPZBYEAgEPDxYCHwFoZGQCBw9kFgICBQ8QZBAVAQbQntC/0YIVAQExFCsDAWdkZAIFD2QWAgIDDxYCHwFoFgJmDw9kFgIfAgW+AWlmKGV2ZW50LndoaWNoIHx8IGV2ZW50LmtleUNvZGUpe2lmICgoZXZlbnQud2hpY2ggPT0gMTMpIHx8IChldmVudC5rZXlDb2RlID09IDEzKSkge2RvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdjdGwwMF9jcGgxX2JvdHRvbVRvcGljX2J0blBhc3N3b3JkJykuY2xpY2soKTtyZXR1cm4gZmFsc2U7fX0gZWxzZSB7cmV0dXJuIHRydWV9OyBkAgQPDxYCHwFnZGRkxhcNXrhLOqQbsx9WZP37AIwpyN0NI5E9LovsZKq/lYc=',
    '__EVENTVALIDATION' => '/wEdAAtD8DQ+CxYShWjyP34bdCxMVsoOvXMGY6IjBwYH+89Sa1V6RkAfufrqJa6LpqnGFgsLBjwbIv2CjsxZb2fNvuw/InYfcer2RJPFf5JlvaLiJikI/UL/bL1Nlyf/LFKHLf167Skf5QJp2akAVimIIGewHf922/E78EQUo1nec4cDr59y+zr0mYvbuGUVL4ehkpIB4jSGrVgOUYeTwacmdnSd8bgnehEWn9l71FO5v9y9yUbHxvuFoM80xVsvMvjzJowrJaH8D73buYtWXkm6EfIK',
    '__VIEWSTATEGENERATOR' => '08EDEF53',
    'ctl00_ctl00_sm1_HiddenField' => '',
    'ctl00$ctl00$sm1' => '',
    'ctl00$ctl00$txtSearchQueryString' => '',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$UserName' => 'magazin@yourfish.ru',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$Password' => 'spartak1',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$RememberMe' => 'on',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$LoginButton' => 'Войти в систему',
'ctl00$txtSearchQueryString' => '',
'ctl00$cph1$ctl00$btnLogin' => 'Войти в систему',
'ctl00$cph1$ctl00$ContactUs$txtName' => '',
'ctl00$cph1$ctl00$ContactUs$txtEmail' => 'magazin@yourfish.ru',
'ctl00$cph1$ctl00$ContactUs$ddlSubjects' => 1,
'ctl00$cph1$ctl00$ContactUs$txtEnquiry '=> '',
'ctl00$cph1$ctl00$ContactUs$captchaCtrl$txtCode'=> ''
);



?>

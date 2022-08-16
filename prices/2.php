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
        curl_setopt ($ch, CURLOPT_COOKIE, ".ASPXANONYMOUS=sfKMG7011wEkAAAAOTVkMzI5MTYtMzAwMi00NzEyLWFjNGMtNzU3MzQ2NWNmOTg3NP-BaMSLhZUL2hGyT8fNwLgt7Sya3yLPX1Ja5Zdk_zE1; ASP.NET_SessionId=nneg2lldat3nv5asjiqgvbsk; nop.onlineusertracking=c83bfe2e-6e89-4656-b23e-2860611dfe3d; _ga=GA1.2.1193677762.1612906438; _gid=GA1.2.365803047.1612906438; _fbp=fb.1.1612906438022.402439886; top100_id=t1.-1.47095145.1612906438139; NOPCOMMERCE.AUTH=7A07E35CF1CE40201C244F118C5D864C0DD3D8695C673D5807CD19BFBF62F9D2E945B1FADC40FF3C873C88935F9CC5A8028624003171925F9BD6341F5F24814F9F6BC0044BC6ABD6A30910DCDF00E2111E7973AC16CE9AE0134897CE21571C3E7C3443DC286E3E2FC2B05CE9B96C5790380BBBB84E69DDC714ADEC7C61A9DD6E0B2C8C5F1BEDCDEFAB9CD13D775612BD7A1831C36D0D05349945694A5CB89D2F; Nop.CustomerSessionGUIDCookie=50605cef-065b-404a-9155-f1443a9b22ce; _gat_gtag_UA_104522754_2=1; last_visit=".$timestamp."::".$timestamp);
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
    '__VIEWSTATE' => '/wEPDwULLTE0MjQxODU3NzUPZBYCZg9kFgJmD2QWBmYPZBYEAgMPFgIeB2NvbnRlbnQFtwLQoNGL0LHQvtC70L7QstC90YvQtSDQsdC70L7Qs9C4LCDQvdC+0LLQvtGB0YLQuCDRgNGL0LHQvtC70L7QstC90L7Qs9C+INGA0YvQvdC60LAuINCg0YvQsdC+0LvQvtCy0L3Ri9C1INGC0L7QstCw0YDRiyDQvtC/0YLQvtC8OiBBbnJlJ3MsIEJhbmF4LCBCcmlzY29sYSwgRGFpd2EsIERVTywgR0FELCBHYXJ5IFlhbWFtb3RvLCBJTUEsIElzc2VpLCBNZWdhYmFzcywgTUVJSE8gVmVyc3VzLCBPU1AsIE93bmVyL0PigJl1bHRpdmEsIFBhbmFjZWEsIFBvbnRvb24yMSwgUkFJRCBKYXBhbiwgU3QuQ3JvaXgsIFRydW1wLCBWYWxrZUlOLCBaaXBCYWl0c2QCBA8WAh8ABb8B0JrQvtC80L/QsNC90LjRjyDQnNC+0YHQutCw0L3QtdC70LvQsC4g0J7RhNC40YbQuNCw0LvRjNC90YvQuSDRgdCw0LnRgi4g0KDRi9Cx0L7Qu9C+0LLQvdGL0LUg0YLQvtCy0LDRgNGLINCyINCg0L7RgdGB0LjQuC4g0KDRi9Cx0L7Qu9C+0LLQvdGL0LUg0YLQvtCy0LDRgNGLINCg0L7RgdGB0LjRjiDQu9GD0YfRiNC40Lkg0YHQsNC50YJkAgIPZBYCAgYPZBYIAgMPZBYCAgMPZBYEZg9kFgICAQ88KwAKAQAPFgQeDUNyZWF0ZVVzZXJVcmwFD34vcmVnaXN0ZXIuYXNweB4SRGVzdGluYXRpb25QYWdlVXJsBQ5+L2RlZmF1bHQuYXNweGQWAmYPZBYGAhUPEA8WAh4HQ2hlY2tlZGdkZGRkAhkPDxYCHgtOYXZpZ2F0ZVVybAUXfi9wYXNzd29yZHJlY292ZXJ5LmFzcHhkZAIbDw8WAh4HVmlzaWJsZWhkZAIBDw8WAh8FaGRkAgUPZBYCZg9kFgJmD2QWBAIBDxYCHwVnFgxmDxYCHgRUZXh0BQEwZAIBDxYCHwYFBTAg0YAuZAICDxYCHwYFATBkAgMPFgIfBgUFMCDRgC5kAgQPFgIfBgUBMGQCBQ8WAh8GBQUwINGALmQCAw8WAh8FaGQCBw8PFgIfBWhkZAILDw8WAh8FaGRkAgQPDxYCHwVnZGQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgEFNWN0bDAwJGN0bDAwJGNwaDEkY3BoTWlkZGxlJGN0bDAwJExvZ2luRm9ybSRSZW1lbWJlck1lxaYakd5HH9XNWucZNP0JF/Sk2IOLb5V/H8hboKg9Xq8=',
    '__EVENTVALIDATION' => '/wEdAAhG2XuvB/nwM0nVdef8hZ3H+Klpeiuc6q5n1RVrsJxzXB1cmhT0V7wqLy/CY1+6NkhUyQcxo2SQ6iUhLxSoCh+iLxQVIifeTNCRiHJcbnkv5PIVR59KVLdl6hYp6CEhpTA5+vANWv/WkJWojNCRYTgb5UVETnGvtwDfMliQ7PRzincAD9s7gjksTEu0VtkiMXUw7dHjU6JqUIvLmp3lfjyv',
    '__VIEWSTATEGENERATOR' => 'C2EE9ABB',
    'ctl00_ctl00_sm1_HiddenField' => '',
    'ctl00$ctl00$sm1' => '',
    'ctl00$ctl00$txtSearchQueryString' => '',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$UserName' => 'magazin@yourfish.ru',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$Password' => 'spartak1',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$RememberMe' => 'on',
    'ctl00$ctl00$cph1$cphMiddle$ctl00$LoginForm$LoginButton' => 'Войти в систему',
);

echo Parserlink::create()
    ->setBaseUrl('http://moscanella.ru')
    ->setUrl('http://moscanella.ru/Login.aspx')
    ->setPostData($data)
    ->send()
    ->sendNext()
    ->parse()
    ->getFullLink();

?>

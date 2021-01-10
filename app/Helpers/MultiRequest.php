<?php


namespace App\Helpers;


class MultiRequest
{
    /**
     * @var array
     */
    private static $data = array();
    /**
     * @var int
     */
    private $CURLOPT_TIMEOUT;
    /**
     * @var int
     */
    private $CURLOPT_CONNECTTIMEOUT;
    /**
     * @var bool
     */
    private $CURLINFO_HEADER_OUT;

    /**
     * MultiRequest constructor.
     * @param int $CURLOPT_TIMEOUT
     * @param int $CURLOPT_CONNECTTIMEOUT
     * @param bool $CURLINFO_HEADER_OUT
     */
    public function __construct(int $CURLOPT_TIMEOUT = 0, int $CURLOPT_CONNECTTIMEOUT = 0, bool $CURLINFO_HEADER_OUT = false)
    {
        $this->CURLOPT_TIMEOUT = $CURLOPT_TIMEOUT;
        $this->CURLOPT_CONNECTTIMEOUT = $CURLOPT_CONNECTTIMEOUT;
        $this->CURLINFO_HEADER_OUT = $CURLINFO_HEADER_OUT;
    }

    /**
     * @param string $method
     * @param string $url
     * @param string $responseKey
     * @param array $body
     * @param array $headers
     */
    public function setRequest(string $method, string $url, string $responseKey, array $body = [], array $headers = []): void
    {
        self::$data[] = [
            "method" => $method,
            "url" => $url,
            "key" => $responseKey,
            "body" => $body,
            "headers" => $headers
        ];
    }

    /**
     * @param bool $info
     * @return array
     */
    public function send(bool $info = false): array
    {
        $requests = array();
//Initiate a multiple cURL handle
        $mh = curl_multi_init();

        foreach (self::$data as $i => $datum) {
            $requests[$i] = array();
            $url = $datum['url'];
            if (strtoupper($datum['method']) === "GET" && !empty($datum['body'])) {
                $url .= "?" . http_build_query($datum['body']);
            }
            $requests[$i]['curl_handle'] = curl_init($url);
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_TIMEOUT, $this->CURLOPT_TIMEOUT);
            if (strtoupper($datum['method']) !== "GET") {
                curl_setopt($requests[$i]['curl_handle'], CURLOPT_POSTFIELDS, json_encode($datum['body']));
            }
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_CONNECTTIMEOUT, $this->CURLOPT_CONNECTTIMEOUT);
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($requests[$i]['curl_handle'], CURLOPT_PROXY, "http://scraperapi:080f17de9141bb43ed5571d5b0ce1f0e@proxy-server.scraperapi.com:8001");
            curl_setopt($requests[$i]['curl_handle'], CURLINFO_HEADER_OUT, $this->CURLINFO_HEADER_OUT);
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_CUSTOMREQUEST, strtoupper($datum['method']));
            curl_setopt($requests[$i]['curl_handle'], CURLOPT_HTTPHEADER, $datum['headers']);
            $requests[$i]['url'] = $url;
            $requests[$i]['method'] = strtoupper($datum['method']);
            $requests[$i]['key'] = $datum['key'];
            curl_multi_add_handle($mh, $requests[$i]['curl_handle']);
        }
        //Execute our requests using curl_multi_exec.
        $stillRunning = false;
        do {
            curl_multi_exec($mh, $stillRunning);
        } while ($stillRunning);
        $response = array();
        foreach ($requests as $k => $request) {
            curl_multi_remove_handle($mh, $request['curl_handle']);
            $response[$k]['response'] = curl_multi_getcontent($request['curl_handle']);
            $response[$k]['method'] = $request['method'];
            $response[$k]['key'] = $request['key'];
            $response[$k]['url'] = $request['url'];
            if ($info) {
                $response[$k]['info'] = curl_getinfo($request['curl_handle']);
            }
            curl_close($requests[$k]['curl_handle']);
        }
        curl_multi_close($mh);
        self::$data = [];
        return $response;
    }
}

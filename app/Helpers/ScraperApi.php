<?php


namespace App\Helpers;


class ScraperApi
{
    /**
     * @var string[]
     */
    private $proxies;

    public function __construct()
    {
        $proxies = array(
            "b6a324bdc258c1b18f5405b2f31f3cd6",
            "e2f83cda8a04980b1cedfb2643aeed8f",
            "984375ddf6dfd9ee7200ff589d639638",
            "c039b8ddfb5e6701f86e1f65b7f6e202",
            "ef8842e0e9d00ca4fbbb5bec90d7e0d9",
            "4e98571be9e9a2aaacc6bb52fc9cec71",
            "cf3c85621c3b92ac62e4f11cc3b90c5e",
            "349aa0ad8c25fa33fd6bf389b4568250",
            "d167c3a8e6ac0b529124bb6515d7dfbc",
            "24ab6250ed3e673aa271a45d41307aa8",
            "1066c3f7abc85686be742255dbd016cb",
            "d9fefe8d49c7bbec8ffed8e6e8700fec",
            "3c88850d8aae701dce7e1ea23902509c",
            "6f7adafe379d8df2faa8561a00bbc169",
            "080f17de9141bb43ed5571d5b0ce1f0e",
            "43a957720cdaff5d7a2721ff11f17d38",
            "6f54f4b7f076d698ba243fb899c670cc",
            "7409f2efdb86888d2dbb4c162c0c63a2",
            "c72aba45c9fd9dd2ba37c85eed0b8f96",
            "a13b5f0742df83bc5708d02f2230d881",
            "a9e73fce34fdefd81d45a0e2c80b280d",
            "663c6cc3a2b3fd2b993f2a94ad0c6a48",
            "8ce283828ea1fc95478e11b566cfa66c",
            "1e7de6f823c1a00b32aa759b884f2ed4",
            "b858c1256465c481288c394f88dfa77d",
            "3353be0a2bb80044c3afe816c94e3349",
            "0a157664c73740dfabca7b5af5396c74",
            "2024383edbac0bb431b13744cda3b974",
            "6e8c5b6743dc2b2e872dda6e0b5207f8",
            "1fef298501cbc4ed890f6483fb524e9d",
            "5c5b6dc485ba21781638bf43905ee6d8",
            "d2246731bccc3672e27a26939df4ad73",
            "c1088865881186518e893b001bb27650",
            "ca5a9e3f1fa7faeec71c9c537f18290e",
            "844f91862caf47e9ddea3801026e2b83",
            "9d4b9dc645bca06403cae8754568d127",
            "fc6144ae61633bfe7202f627d0507d8b",
            "20468f1cbb676de641c62646c590c07d",
            "5cabb8c22d54f1a691352a52888cea44",
            "dbbd97ca4ea1d81f8516b3226b7ac79c",
        );
        $this->proxies = $proxies;
    }

    public function getToken()
    {
        if ( count($this->proxies) > 0){
            $key = array_rand($this->proxies);
            $token = $this->proxies[$key];

            $res = file_get_contents("http://api.scraperapi.com/account?api_key=$token");
            $res = json_decode($res, true);
            if (is_array($res) && isset($res['requestCount']) && isset($res['requestLimit']) && $res['requestCount'] < $res['requestLimit']) {
                $res['activeCount'] =  $res['requestLimit'] - $res['requestCount'];
                $res['token'] =  $token;
                return $res;
            }
            if (isset($this->proxies[$key]) && count($this->proxies) > 1){
                unset($this->proxies[$key]);
                return $this->getToken();
            }
            return false;
        }
        return false;
    }
}

















//KEY:  b6a324bdc258c1b18f5405b2f31f3cd6
//KEY:  e2f83cda8a04980b1cedfb2643aeed8f
//KEY:  984375ddf6dfd9ee7200ff589d639638
//KEY:  c039b8ddfb5e6701f86e1f65b7f6e202
//KEY:  ef8842e0e9d00ca4fbbb5bec90d7e0d9
//KEY:  4e98571be9e9a2aaacc6bb52fc9cec71
//KEY:  cf3c85621c3b92ac62e4f11cc3b90c5e
//KEY:  349aa0ad8c25fa33fd6bf389b4568250
//KEY:  d167c3a8e6ac0b529124bb6515d7dfbc
//KEY:  24ab6250ed3e673aa271a45d41307aa8
//KEY:  1066c3f7abc85686be742255dbd016cb
//KEY:  d9fefe8d49c7bbec8ffed8e6e8700fec
//KEY:  3c88850d8aae701dce7e1ea23902509c
//KEY:  6f7adafe379d8df2faa8561a00bbc169
//KEY:  080f17de9141bb43ed5571d5b0ce1f0e
//KEY:  43a957720cdaff5d7a2721ff11f17d38
//KEY:  6f54f4b7f076d698ba243fb899c670cc
//KEY:  7409f2efdb86888d2dbb4c162c0c63a2
//KEY:  c72aba45c9fd9dd2ba37c85eed0b8f96
//KEY:  a13b5f0742df83bc5708d02f2230d881
//KEY:  a9e73fce34fdefd81d45a0e2c80b280d
//KEY:  663c6cc3a2b3fd2b993f2a94ad0c6a48
//KEY:  8ce283828ea1fc95478e11b566cfa66c
//KEY:  1e7de6f823c1a00b32aa759b884f2ed4
//KEY:  b858c1256465c481288c394f88dfa77d
//KEY:  3353be0a2bb80044c3afe816c94e3349
//KEY:  0a157664c73740dfabca7b5af5396c74
//KEY:  2024383edbac0bb431b13744cda3b974
//KEY:  6e8c5b6743dc2b2e872dda6e0b5207f8
//KEY:  1fef298501cbc4ed890f6483fb524e9d
//KEY:  5c5b6dc485ba21781638bf43905ee6d8
//KEY:  d2246731bccc3672e27a26939df4ad73
//KEY:  c1088865881186518e893b001bb27650
//KEY:  ca5a9e3f1fa7faeec71c9c537f18290e
//KEY:  844f91862caf47e9ddea3801026e2b83
//KEY:  9d4b9dc645bca06403cae8754568d127
//KEY:  fc6144ae61633bfe7202f627d0507d8b
//KEY:  20468f1cbb676de641c62646c590c07d
//KEY:  5cabb8c22d54f1a691352a52888cea44
//KEY:  dbbd97ca4ea1d81f8516b3226b7ac79c

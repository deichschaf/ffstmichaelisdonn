<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait FacebookTrait
{
    /**
     * @return string
     */
    private function getFacebookUrl(): string
    {
        return 'https://graph.facebook.com/'.env('FACEBOOK_PAGE_ID').'/';
    }

    /**
     * @return array
     */
    private function makeUserAccessToken():array
    {
        $url = 'https://graph.facebook.com/oauth/access_token';
        $url.= '?grant_type=fb_exchange_token';
        $url.= '&client_id='.env('FACEBOOK_APP_ID');
        $url.= '&client_secret='.env('FACEBOOK_APP_SECRET');
        $url.= '&fb_exchange_token=SHORT-LIVED-USER-ACCESS-TOKEN';
    }

    /**
     * @param string $userToken
     * @return array
     */
    private function makePageAccessToken(string $userToken=''):array
    {
        $url = $this->getFacebookUrl();
        $url.= '?fields=access_token';
        $url.= '&access_token='.$userToken;
    }

    /**
     * @return string
     */
    private function getPageAccessToken():string
    {
        $accessToken = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $accessToken = '';
                $response = $this->makeUserAccessToken();
                $accessToken = $this->makePageAccessToken($response['access_token']);
                return $accessToken;
            }
        );
        return $accessToken;
    }

    public function makeFacebookPost(array $data)
    {
    }

    public function getFacebookFeed()
    {
    }

    /**
     * @param array $data
     * @return string
     */
    private function buildFacebookQuery(array $data=[]):string
    {
        $data[]='access_token='.$this->getPageAccessToken();
        return '?'.implode('&', $data);
    }

    /**
     * @param string $page
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeFacebookGetConnect(string $page='feed', array $data=[])
    {
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('GET', 'https://www.google.com', ['connect_timeout' => 1]);
            $data = [
                'success'=>true,
                'code' =>$res->getStatusCode()
            ];
            return response()->json($data, 200);
        } catch (\GuzzleHttp\Exception\ConnectException $exception) {
            $data = [
                'success'=>false,
                'code'=>$exception->getCode(),
                'error'=>[
                    'message'=>'Offline',
                    'code'=>$exception->getCode()
                ]];
            return response()->json($data, 200);
        }
    }
    private function makeFacebookPostConnect(string $page='feed', array $data=[])
    {
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request('GET', 'https://www.google.com', ['connect_timeout' => 1]);
            $data = [
                'success'=>true,
                'code' =>$res->getStatusCode()
            ];
            return response()->json($data, 200);
        } catch (\GuzzleHttp\Exception\ConnectException $exception) {
            $data = [
                'success'=>false,
                'code'=>$exception->getCode(),
                'error'=>[
                    'message'=>'Offline',
                    'code'=>$exception->getCode()
                ]];
            return response()->json($data, 200);
        }
    }
}

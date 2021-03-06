<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{

    private $modules = [];
    
    /**
     * App constructor.
     * @param string[] $modules List des modules aà charger
     */

    public function __construct(array $modules = [])
    {
       foreach ($modules as $module) {
           $this->modules[] = new $module();
       }
    }

    public function run(ServerRequestInterface $request) : ResponseInterface
    {

        $uri =$request->getUri()->getPath();
    
        if (!empty($uri) && $uri[-1] === "/") {
            $response = new Response();
            $response = $response->withStatus(301);
            $response = $response->withHeader('Location', substr($uri, 0, -1));

            return $response;
        }

        if ($uri === '/blog') {
            return new Response(200, [], '<h1>Bienvenue sur le blog</h1>');
        }
        return new Response(404, [], "<h1>Error 404</h1>");
    }
}

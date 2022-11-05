<?php


class Router {
    
    public static function get(string $route, callable $handler){
        Router::run(['METHOD' => "GET", 'ROUTE' => $route, 'HANDLER' => $handler]);
    }
    public static function post(string $route, callable $handler){
        Router::run(['METHOD' => "POST", 'ROUTE' => $route, 'HANDLER' => $handler]);
    }
    public static function put(string $route, callable $handler){
        Router::run(['METHOD' => "PUT", 'ROUTE' => $route, 'HANDLER' => $handler]);
    }
    public static function patch(string $route, callable $handler){
        Router::run(['METHOD' => "PATCH", 'ROUTE' => $route, 'HANDLER' => $handler]);
    }
    public static function delete(string $route, callable $handler){
        Router::run(['METHOD' => "DELETE", 'ROUTE' => $route, 'HANDLER' => $handler]);
    }

    public static function run(array $route){
        if($_SERVER['REQUEST_METHOD'] !== $route['METHOD']) return;

        $url_part = parse_url($_SERVER['REQUEST_URI'])['path'];
        $url_parts = explode("/", $url_part);
        $route_part = $route['ROUTE'];
        $route_parts = explode("/", $route_part);

        if(count($route_parts) !== count($url_parts)) return;
        
        $vars = [];
        $new_route = $new_url = "";
        foreach($route_parts as $i => $r){
            if($i === 0) continue;
            if($r[0] === ":"){
                $vars[substr($r, 1)] = isset($url_parts[$i]) ? ($url_parts[$i] === "" ? null : $url_parts[$i]) : null;
                $new_route .= "/null";
                $new_url .= "/null";
            }
            else{
                $new_route .= "/$r";
                $new_url .= "/$url_parts[$i]";
            }
        }
        $req = [];
        $req['query'] = is_array($_GET) === false ? [] : $_GET;
        $req['data'] = json_decode(file_get_contents('php://input'), true) ?? [];
        $req['params'] = $vars;
        if($new_route === $new_url) call_user_func($route['HANDLER'], $req);
    }
}

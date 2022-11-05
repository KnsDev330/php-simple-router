Redirect all requests to a single page and use Router class methods.

In apache virtualhost or `.htaccess` config file add
```
FallbackResource /api.php
```

## Examples
```
Router::get('/users', function($req){
    $jsonReq = json_encode($req);
    exit($jsonReq);
})
```
```
Router::get('/users/:userId', function($req){
    $jsonReq = json_encode($req);
    exit($jsonReq);
})
```

```
Router::get('/posts/:postId', function($req){
    $jsonReq = json_encode($req);
    exit($jsonReq);
})
```
```
Router::get('/posts/:postId/comments', function($req){
    $jsonReq = json_encode($req);
    exit($jsonReq);
})
```

⚠️ Don't use `/` at the end of routes

<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Swagger UI</title>
    <link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' media='screen' rel='stylesheet' type='text/css'/>
    <link href='/vendor/l5-swagger/css/typography.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='/vendor/l5-swagger/css/reset.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='/vendor/l5-swagger/css/screen.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href='/vendor/l5-swagger/css/reset.css' media='print' rel='stylesheet' type='text/css'/>
    <link href='/vendor/l5-swagger/css/screen.css' media='print' rel='stylesheet' type='text/css'/>
    <script type="text/javascript" src="/vendor/l5-swagger/lib/shred.bundle.js"></script>
    <script src='/vendor/l5-swagger/lib/jquery-1.8.0.min.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/jquery.slideto.min.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/jquery.wiggle.min.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/jquery.ba-bbq.min.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/handlebars-2.0.0.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/underscore-min.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/backbone-min.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/swagger-client.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/swagger-ui.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/highlight.7.3.pack.js' type='text/javascript'></script>
    <script src='/vendor/l5-swagger/lib/marked.js' type='text/javascript'></script>

    <!-- enabling this will enable oauth2 implicit scope support -->
    <script src='/vendor/l5-swagger/lib/swagger-oauth.js' type='text/javascript'></script>
    <script type="text/javascript">
        $(function () {
            var url = window.location.search.match(/url=([^&]+)/);
            if (url && url.length > 1) {
                url = decodeURIComponent(url[1]);
            } else {
                url = "{{{ $urlToDocs }}}";
            }
            window.swaggerUi = new SwaggerUi({
                url: url,
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                onComplete: function(swaggerApi, swaggerUi){
                    @if(isset($requestHeaders))
                    @foreach($requestHeaders as $requestKey => $requestValue)
                    window.authorizations.add("{{$requestKey}}", new ApiKeyAuthorization("{{$requestKey}}", "{{$requestValue}}", "header"));
                    @endforeach
                    @endif
                    if(typeof initOAuth == "function") {
                        /*
                         initOAuth({
                         clientId: "your-client-id",
                         realm: "your-realms",
                         appName: "your-app-name"
                         });
                         */
                    }
                    $('pre code').each(function(i, e) {
                        hljs.highlightBlock(e)
                    });
                },
                onFailure: function(data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "none",
                sorter : "alpha"
            });

            function addApiKeyAuthorization() {
                var key = $('#input_apiKey')[0].value;
                log("key: " + key);
                if(key && key.trim() != "") {
                    log("added key " + key);
                    window.authorizations.add("api_key", new ApiKeyAuthorization("api_key", key, "query"));
                }
            }

            $('#input_apiKey').change(function() {
                addApiKeyAuthorization();
            });

            // if you have an apiKey you would like to pre-populate on the page for demonstration purposes...
            /*
             var apiKey = "myApiKeyXXXX123456789";
             $('#input_apiKey').val(apiKey);
             addApiKeyAuthorization();
             */

            window.swaggerUi.load();
        });
    </script>
</head>

<body class="swagger-section">
<div id='header'>
    <div class="swagger-ui-wrap">
        <a id="logo" href="http://swagger.io">swagger</a>
        <form id='api_selector'>
            <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
            <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
            <div class='input'><a id="explore" href="#">Explore</a></div>
        </form>
    </div>
</div>

<div id="message-bar" class="swagger-ui-wrap">&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
</body>
</html>

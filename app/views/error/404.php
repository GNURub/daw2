<html>
  <head>
    <title>Error 404</title>
    <link href="<?=URL; ?>css/error.css" rel="stylesheet">
  </head>
  <body>
    <div id="critical-error" style="display: block;">
        <h1>404 <small>Page Not Found</small></h1>

        <p>This is not the page you are looking for. Sorry about that!</p>
        <section class="additional-message">
            <h2>Additional info</h2>
            <p><?=isset($error) ? $error : 'The Box for this URL does not exist.';?></p>
        </section>

        <section class="links">
            <a href="<?=URL;?>"><span>«</span> back to homepage</a>
            | <a href="<?=URL;?>" target="_blank">Platform Status</a>
        </section>
    </div>
  </body>
</html>

<html>
  <head>
    <title>Error 500</title>
    <link href="<?=URL; ?>css/error.css" rel="stylesheet">
  </head>
  <body>
    <div id="critical-error" style="display: block;">
        <h1>500 <small>Internal server error</small></h1>

        <p>This request isn't good. Sorry about that!</p>
        <section class="additional-message">
            <h2>Additional info</h2>
            <p><?=isset($error) ? $error : '';?></p>
        </section>

        <section class="links">
            <a href="<?=URL;?>"><span>«</span> back to homepage</a>
            | <a href="<?=URL;?>" target="_blank">Platform Status</a>
        </section>
    </div>
  </body>
</html>

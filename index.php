<html>

  <head>
    <title>Zizim URL Shortener</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="loader.css" />

    <script src="jquery-1.11.0.min.js"></script>
    <script src="zizim.js"></script>

    <meta name="viewport" content="width=device-width">
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!--

    Apple icons
    Favicon
    Google Analytics
    Facebook Like / Tweet Button

    Store previously created shortcuts in a cookie? Show them on the homepage? 
  
    -->

  </head>

  <body>

    <div id="wrapper">

      <header>
        <h1 id="title">Zizim</h1>
        <p>Your friendly, neighbourhood, URL shortener.</p>
      </header>

      <article>
        <form method="post" action="index.php" id="shorten_form">

          <h2>Enter the URL you'd like to shorten below</h2>
          <span class="error">TEST</span>
          <input type="text" name="URL" id="URL" placeholder="http://" <? if ($_POST){ echo "value=\"".$_POST['URL']."\""; } ?> />
          <div class="custom_alias_wrapper">
            <h2 class="switch">Create a custom URL<span>Click here to add an alias to your shortened URL.<br>(e.g. ziz.im/customalias</span></h2>
            <div class="custom_alias">
              <h2>What would you like to set as your URL's alias?</h2>
              <input type="text" size="20" name="alias" id="alias" placeholder="alias" <? if ($_POST){ echo "value=\"".$_POST['alias']."\""; } ?> />
            </div>
          </div>
          <button id="generate_url">Generate</button>
        </form>
        <div class="loader">
          <h2>Processing..</h2>
          <div id="squaresWaveG">
            <div id="squaresWaveG_1" class="squaresWaveG"></div>
            <div id="squaresWaveG_2" class="squaresWaveG"></div>
            <div id="squaresWaveG_3" class="squaresWaveG"></div>
            <div id="squaresWaveG_4" class="squaresWaveG"></div>
            <div id="squaresWaveG_5" class="squaresWaveG"></div>
            <div id="squaresWaveG_6" class="squaresWaveG"></div>
            <div id="squaresWaveG_7" class="squaresWaveG"></div>
            <div id="squaresWaveG_8" class="squaresWaveG"></div>
          </div>
        </div>
        <div class="result">
          <h2>Behold, your shortened URL</h2>
          <span class="url"></span>
          <button id="resetForm">Create another</button>
        </div>
      </article>

      <footer>
      Copyright &copy; 2011 - 2014. <a href="http://smithyy.co.uk">Luke Smith</a>.
      </footer>

    </div>

  </body>

</html>
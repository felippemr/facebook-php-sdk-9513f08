﻿Facebook PHP SDK (v.3.0.0)
==========================

The new PHP SDK (v3.0.0) is a major upgrade to the older one (v2.2.x):

- Uses OAuth authentication flows instead of our legacy authentication flow
- Consists of two classes. The first (class BaseFacebook) maintains the core of the upgrade, and the second one (class Facebook) is a small subclass that uses PHP sessions to store the user id and access token.

If you’re currently using the PHP SDK (v2.2.x) for authentication, you will recall that the login code looked like this:

     $facebook = new Facebook(…);
     $session = $facebook->getSession();
     if ($session) {
       // proceed knowing you have a valid user session
     } else {
       // proceed knowing you require user login and/or authentication
     }

The login code is now:

     $facebook = new Facebook(…);
     $user = $facebook->getUser();
     if ($user) {
       // <!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>php-sdk</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    <!--
      We use the JS SDK to provide a richer user experience. For more info,
      look here: http://github.com/facebook/connect-js
    -->
    <div id="fb-root"></div>
    <script src="//connect.facebook.net/en_US/all.js">
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });


FB.login(function(response) {
  if (response.session) {
    if (response.perms) {
      // user is logged in and granted some permissions.
      // perms is a comma separated list of granted permissions
    } else {
      // user is logged in, but did not grant any permissions
    }
  } else {
    // user is not logged in
  }
}, {perms:'read_stream'});


        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>


    <h1>I love you</h1>

    <?php if ($me): ?>
    <a href="<?php echo $logoutUrl; ?>">
      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
    </a>
    <?php else: ?>
    <div>
      Using JavaScript &amp; XFBML: <fb:login-button></fb:login-button>
    </div>
    <?php endif ?>

    <h3>Session</h3>
    <?php if ($me): ?>
    <pre><?php print_r($session); ?></pre>

    <h3>You</h3>
    <img src="https://graph.facebook.com/<?php echo $uid; ?>/picture">
    <?php echo $me['name']; ?>

    <h3>Your User Object</h3>
    <pre><?php print_r($me); ?></pre>
    <?php else: ?>
    <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

  </body>
</html>
     } else {
       // erro
     }


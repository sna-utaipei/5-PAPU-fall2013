<!--link database-->
    <?
        session_start();
        $dbconn = pg_connect("host=clip.csie.org port=5432 dbname=postgres user=postgres password=tmuecs503")or die('Could not connect: ' . pg_last_error());
            if (!$dbconn) {
                echo "An error occurred.\n";
                exit;
        }
    ?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" 
xmlns:og="http://ogp.me/ns#" 
xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="og:description" content="This is PAPU!" />
    <meta property="og:title" content="PAPU!"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://sna-papu.herokuapp.com"/>
    <meta property="og:image" content="https://sna-papu.herokuapp.com/content/picture/papu.jpg"/>
    <meta property="og:site_name" content="PAPU!" />
      
    <link rel="shortcut icon" href="/logo/papu/ios/Icon-Small-20.png">

    <title>PAPU!</title>

    <!-- Bootstrap core CSS -->
    <!--<link href="../../dist/css/bootstrap.css" rel="stylesheet">-->
    <link href="content/css/bootstrap.css" rel="stylesheet">
    <link href="content/css/papu.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="content/js/bootstrap.js"></script>
    <!-- Custom styles for this template -->
    <link href="content/css/starter-template.css" rel="stylesheet">
    <link href="content/css/changePicture.css" rel="stylesheet"/>
    <script src="content/js/mapAnimation.js"></script>
    <!-- 載入 jQuery blockUI 的主程式碼 -->  
    <script src="content/js/jquery.blockUI.js"></script>
    <!-- 使用 Google AJAX API 取得 jQuery 框架 1.8.2 min 版本 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

	<!-- jQuery, -->
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<!-- Fotorama -->
	<link href="http://fotorama.s3.amazonaws.com/fotorama.css" rel="stylesheet">
	<script src="http://fotorama.s3.amazonaws.com/fotorama.js"></script><style type="text/css"></style>
        


    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
      
  </head>
  <body style="overflow-x: auto; overflow-y: hidden;">
    <style type=text/css> 
        body { font-family: 微軟正黑體,Times New Roman,新細明體;}
        A{color:black}
        A:hover {color: gray}
        h1,h2,h3,h4,h5{ font-family: 微軟正黑體,Times New Roman,新細明體;}
    </style>
      <?php
        // Remember to copy files from the SDK's src/ directory to a
        // directory in your application on the server, such as php-sdk/
        require_once('src/facebook.php');
        require_once('utils.php');
    
            
        $config = array(
            'appId' => '599502590123242',
            'secret' => '9cddb4ed5631ae8a5cb28291ea8324f4',
            //'allowSignedRequest' => false // optional but should be set to false for non-canvas apps
        );
            
        $facebook = new Facebook($config);
        $user_id = $facebook->getUser();
        if ($user_id) {
            try {
            // Fetch the viewer's basic information
            $user_profile = $facebook->api('/me','GET');
            } catch (FacebookApiException $e) {
                // If the user is logged out, you can have a 
                // user ID even though the access token is invalid.
                // In this case, we'll get an exception, so we'll
                // just ask the user to login again here.
                $login_url = $facebook->getLoginUrl(); 
                //echo "<center><img src='/logo/papu/sizes/papu-320.png'><br><br>";
                echo '<center><div class="fotorama">
                    <img src="./content/picture/doc00.png">
                    <img src="./content/picture/doc001.png">
                    <img src="./content/picture/doc003.png">
                    <img src="./content/picture/doc004.png">
                    <img src="./content/picture/doc005.png">
                    </div>';
                echo "<h2 style='color:white;font-family:微軟正黑體'>Hey, 快來跟大家一起PAPU!</h2><br>";
                echo '<a class="btn btn-primary" href="'.$login_url.'">Login with Facebook</a>';
                
                error_log($e->getType());
                error_log($e->getMessage());
            }
            $app_using_friends = $facebook->api(array(
                'method' => 'fql.query',
                'query' => 'SELECT uid, name FROM user WHERE uid IN(SELECT uid2 FROM friend WHERE uid1 = me()) AND is_app_user = 1'
              ));
        }else {
            // No user, print a link for the user to login
            $login_url = $facebook->getLoginUrl();
            //echo "<center><img src='/logo/papu/sizes/papu-320.png'><br><br>";
            echo '<center><div class="fotorama">
                  <img src="./content/picture/doc00.png">
                  <img src="./content/picture/doc001.png">
                  <img src="./content/picture/doc003.png">
                  <img src="./content/picture/doc004.png">
                  <img src="./content/picture/doc005.png">
                </div>';
            echo "<h2 style='color:white;font-family:微軟正黑體'>Hey, 快來跟大家一起PAPU!</h2><br>";
            echo '<a class="btn btn-primary" href="'.$login_url.'">Login with Facebook</a>';   
        }
        $search = pg_query ($dbconn, "SELECT user_location_app,user_hometown,user_pu,user_pa,fri_list,user_name,user_location,pa_num,pu_num FROM papu WHERE user_id = '$user_id';");
        $users =  pg_fetch_row($search);
        $_SESSION['uid']=$user_id;
    
        $uid =  $user_id;
        $uname = he(idx($user_profile, 'name'));
        $catchID = "INSERT INTO papu(user_id,user_name) VALUES ('$uid','$uname')"; 
        $useradd = pg_query ($catchID);
    
        if($users[0] == null)
        {
            echo "<script type='text/javascript'>";
            echo "window.location.href='signup/signup.php'";
            echo "</script>"; 
        }

        //auto update
        $user_t = pg_query ($dbconn, "SELECT user_time FROM papu WHERE user_id = '$user_id';");
        $user_time =  pg_fetch_row($user_t);
        date_default_timezone_set("Asia/Taipei");
        $t = time(); //now time

        $hr = $t - ($t % 3600); //On the hour
    
        $d = date("Y-m-d");
        $today = strtotime($d); //today 0:00
        $utime = $user_time[0]; //DB user time
        if($utime < $hr)
        {
            $getIdtmp = pg_query ($dbconn, "SELECT user_id FROM papu ORDER BY random() LIMIT 1;");
            $getId =  pg_fetch_row($getIdtmp);
            $pupu_update = pg_query ($dbconn, "UPDATE papu SET user_pufri = '$getId[0]' WHERE (user_id = '$uid');");
            $papu_update = pg_query ($dbconn, "UPDATE papu SET (user_pa,user_pu,user_time) = ('1','1','$t') WHERE (user_id = '$uid');");
            header("Location: https://sna-papu.herokuapp.com/"); 
        }

    ?>

      
      
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=599502590123242";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>  
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <div id="fb-root"></div>
    <script type="text/javascript">
      window.fbAsyncInit = function() {
          // init the FB JS SDK
          FB.init({
          appId      : '599502590123242',                    // App ID from the app dashboard
          cookie     : true,                                 // Allowed server-side to fetch fb auth cookie
          status     : true,                                 // Check Facebook Login status
          xfbml      : true                                  // Look for social plugins on the page
          });

          // Additional initialization code such as adding Event Listeners goes here
          window.fbLoaded();
          
      };

      // Load the SDK asynchronously
      (function(d, s, id){
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement(s); js.id = id;
          //js.src = "//connect.facebook.net/en_US/all.js";
          // Debug version of Facebook JS SDK
          js.src = "//connect.facebook.net/en_US/all/debug.js";
          fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>


    <script id="my-script-playground">
        window.fbLoaded = function(){
            // define the events when login status changed.
            FB.Event.subscribe('auth.login', function(response) {
                login_head();
                // when user has been logged in, this block will be triggered.
                var msg = "You're logged in.";
                $("#my-login-message").html(msg);
                console.log("Your login response:");
                console.log(response);
                
            });

            // define the action when user clicked the login button.
            $("#fb-login-in").click(function(){
                FB.getLoginStatus(function (response) {
                   if (response.status === 'connected') {  
                     login_head();      
                     var uid = response.authResponse.userID;
                     login_success(uid);                     
                   } else {
                        FB.login(function (response) {
                            if (response.authResponse) {
                                        var uid = response.authResponse.userID;
                                        var accessToken = response.authResponse.accessToken;                                        
                                login_success(uid);
                            } else {
                                alert('login failed!');
                            }
                        }, {
                            scope: 'publish_stream,user_hometown,user_location,user_photos,user_friends'
                        });
                   }

                })
                //FB.login();
            });




            $("#profile_hitting").click(function(){
                FB.api('/me', function (profile_response) {
                    var my_id = profile_response.id;
                    console.log(my_id); // You will get your id here.
                    fetch_my_profile();
                });
            });         

            FB.getLoginStatus(function(response) { //init
                if (response.status === 'connected') {

                            var uid = response.authResponse.userID;
                            var accessToken = response.authResponse.accessToken;
                            $("#my-login-message").html("You're logged in.");
                      } else {
                            FB.login(function(response) {                        
                             }, {scope: 'publish_stream,user_hometown,user_location,user_photos,user_friends'});
                      }
            });
            var fetch_my_profile = function () {
                /*
                Fetching profile information.
                For more detail, please vist the following url:

                (Graph API: User documentation)
                https://developers.facebook.com/docs/graph-api/reference/user/
                */
                FB.api('/me', function(response) {
                    var my_name = response.name;
                    var my_gender = response.gender;
                    var my_username = response.username;
                    var my_facebook_id = response.id;

                    $("#my-profile-name").html(my_name);
                    $("#my-profile-gender").html(my_gender);
                    $("#my-profile-username").html(my_username);
                    $("#my-profile-facebook-id").html(my_facebook_id);
               });
            };            
        };
                
        function savaData(quota, location, title){
              quota -= 1;
              var op = document.getElementById(location).style.opacity;
              var paQuota = <? echo $users[3]; ?>;
              if(paQuota == 0)
              {
                  $("#paC").html('<div style="text-align:center"><img src="/content/picture/ucannotpass.png"><br><br>你今天的額度已經用完! 不能再PA囉!</div><br>');
              }
              else if(op == 1 && paQuota > 0){
                  $("#paC").html('<center><div>你確定要PA!到</div><input class="form-control" readonly="true" id="upa" value=""><input class="form-control" id="showloca" readonly="true" value=""><br><input class="btn btn-success btn-lg" type="button" id="blockOK" onclick="Pa();" value="OK!"><br><img style="display:none" id="show" src="https://portal.ehawaii.gov/assets/images/loading.gif"></center>');
                  document.getElementById("upa").value = location;
                  document.getElementById("showloca").value = title;
                  
                  //location.href="./quota/update.php?upa=" upa;
              }
              else{
                  $("#paC").html('<div style="text-align:center"><img src="/content/picture/ucannotpass.png"><br>你不能PA!到非鄰近的區域!!</div><br>');
              }
        }
    </script> 
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<img src = "content/picture/icon.png" width="40" height="40" style="position: absolute; top:5px; left: 20px;">-->
          <div class="fb-like" data-href="http://sna-papu.herokuapp.com/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false" style="position: absolute; top:60px; left: 15px;"></div>
          <a class="navbar-brand" href="http://sna-papu.herokuapp.com/"> PAPU!</a>     
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <!--<li id="fb-login-in" class="active"><a href="javascript: return false;">FB login</a></li>-->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">連絡開發者</a>
                <ul class="dropdown-menu">
                <li><a target="_blank" href="https://www.facebook.com/casper.hsia?fref=ts"><img src="https://graph.facebook.com/100001450434541/picture?width=30&height=30"> CCHsia</a></li>
                <li><a target="_blank" href="https://www.facebook.com/profile.php?id=1821115566&fref=ts"><img src="https://graph.facebook.com/1821115566/picture?width=30&height=30"> TCWu</a></li>
                <li><a target="_blank" href="https://www.facebook.com/profile.php?id=100001552561699"><img src="https://graph.facebook.com/100001552561699/picture?width=30&height=30"> CYYang</a></li>
                <li class="divider"></li>
                <li><a href="mailto:taiwanpapu@gmail.com"><img src="content/picture/mail.png"> Send E-mail</a></li>
                </ul>
            </li>  
            <li><a href="#myintro" data-toggle="modal">說明文件</a></li>
            <li><a href="javascript: return false;">Hello, <? echo he($uname); ?></a></li>
            <li><img id="my-bighead-picture" class="img-bighead" src="https://graph.facebook.com/<?php echo $uid; ?>/picture?width=30&height=30"></li>
            
         </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

      <!--everyday PU! -->
      <?
        //$getIdtmp = pg_query ($dbconn, "SELECT user_id,user_name,user_hometown FROM papu ORDER BY random() LIMIT 1;");
        //$getId =  pg_fetch_row($getIdtmp);
        $getPuftmp = pg_query ($dbconn, "SELECT user_pufri FROM papu WHERE user_id = '$uid';");
        $getPuf =  pg_fetch_row($getPuftmp);
        $getPufIdtmp = pg_query ($dbconn, "SELECT user_id,user_name,user_hometown FROM papu WHERE user_id = '$getPuf[0]';");
        $getPufId =  pg_fetch_row($getPufIdtmp);
      ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="BACKGROUND-IMAGE:url(content/picture/cardBackground.png);">
            <div class="modal-header" style="text-align:center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">你今日PU!到的好友</h4>
            </div>
            <div class="modal-body" style="text-align:center"><br>
            <? 
                if($users[2] > 0)
                {
                    echo '<img src="https://graph.facebook.com/';
                    echo $getPufId[0];
                    echo '/picture?height=200&width=200"><h3>';
                    echo $getPufId[1]."</h3><h3>家鄉在：";
                    echo $getPufId[2]."</h3>";
                    echo '<br><button id="my-friend-button" onclick="beFriend();Pu()" class="btn btn-primary">跟他做朋友</button>';
                }
                else
                {
                    echo '  <h2>SORRY!你今天已經PU過了!</h2>';
                }
            ?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-lg" role="button" data-dismiss="modal">按我關掉</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
      
    <script>
        function beFriend(){

            FB.api('/me', function (profile_response) {
                var my_id = profile_response.id;
                console.log(my_id); // You will get your id here.
            });
            FB.ui({
                'method': 'friends',
                'id': <? echo $getPufId[0]; ?>
            }, function(friend_response) {
                // friend_response is the response after user answered the dialog you redirect them to.
            });
        }
    </script>
      
    <!-- friend list -->
    <div class="modal fade" id="myFriends" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          
          <div class="modal-body" style="bgcolor:#CDFEFF">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              
            <div class="bs-docs-example">
                  <ul id="myTab2" class="nav nav-tabs">
                      <li class="active"><a href="#rank-fri" data-toggle="tab">你的全部PAPU友</a></li>
                      <li class=""><a href="#rank-locafr" data-toggle="tab">在這邊的PAPU友</a></li>
                  </ul>
                  <div id="myTabContent2" class="tab-content">
                      <div class="tab-pane fade active in" id="rank-fri">
                         <ul class="friends">
                            <table class="table">
                                <tbody><tr>
                                    <?php
                                        $friend_count = 0;
                                        foreach ($app_using_friends as $auf) {
                                            // Extract the pieces of info we need from the requests above
                                            $id = idx($auf, 'uid');
                                            $name = idx($auf, 'name');
                                    ?>
                                            <!--<div style="display:inline;text-align:center">-->
                                            <td>
                                                <a href="https://www.facebook.com/<?php echo he($id); ?>" target="_top">
                                                    <img src="https://graph.facebook.com/<?php echo he($id) ?>/picture?type=square" alt="<?php echo he($name); ?>">
                                                    <?php echo he($name); ?>
                                                </a>
                                            </td>
                                            <!--</div>-->
                                            <?php
                                                $friend_count++;
                                                if($friend_count % 3 == 0){
                                                    echo "</tr><tr>";
                                                }
                                        }
                                        $fri_ranking = "UPDATE papu SET fri_list = '$friend_count' WHERE (user_id = '$uid');";
                                        $update_fri = pg_query ($fri_ranking);
                                        //if($friend_count %4 != 0)
                                        echo "</tr>";
                                    ?>
                                </tbody>
                            </table>
                        </ul>  
                      </div>
                      <div class="tab-pane fade" id="rank-locafr">
                        <ul class="friends">
                            <table class="table">
                                <tbody><tr>
                                    <?php
                                        $friend_count2 = 0;
                                        foreach ($app_using_friends as $auf) {
                                            // Extract the pieces of info we need from the requests above
                                            $id = idx($auf, 'uid');
                                            $name = idx($auf, 'name');
                                            $show_locf = pg_query ($dbconn, "SELECT user_id,user_name FROM papu WHERE user_location_app = '$users[0]';");
                                            while ($data = pg_fetch_object($show_locf))
                                            {
                                                if(($data->user_id) == (he($id))){
                                                    ?>
                                                    <td>
                                                        <a href="https://www.facebook.com/<?php echo he($id); ?>" target="_top">
                                                            <img src="https://graph.facebook.com/<?php echo he($id) ?>/picture?type=square" alt="<?php echo he($name); ?>">
                                                            <?php echo he($name); ?>
                                                        </a>
                                                    </td>
                                                    <?
                                                    $friend_count2++;
                                                    if($friend_count2 % 3 == 0){
                                                        echo "</tr><tr>";
                                                    }
                                                }
                                            }
                                        }
                                        echo "</tr>";
                                        ?>
                                </tbody>
                            </table>
                        </ul>   
                      </div>
                  </div>
              </div>  
              
          </div>
          <div class="modal-footer">
            <button class="btn btn-success btn-lg" role="button" data-dismiss="modal">按我關掉</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>  
      
      
    <!-- myProfile -->
    <div class="modal fade" id="myProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">我的檔案</h4>
          </div>
          <div class="modal-body" style="bgcolor:#CDFEFF">

              <div id="msgbox" style="text-align:center; font-size:15px">
                  <img id="my-profile-picture" class="img-bighead" src="https://graph.facebook.com/<?php echo $user_id; ?>/picture?height=200&width=200" alt="">
                  <br><br><br>
                  <dl class="dl-horizontal">
                      <dt>姓名</dt>
                      <dd id="my-profile-name"><? echo $users[5]; ?></dd>
                  </dl>
                  <dl class="dl-horizontal">
                      <dt>PAPU!友</dt>
                      <dd id="my-profile-friend"><? echo $users[4]; ?></dd>
                  </dl>
                  <dl class="dl-horizontal">
                      <dt>PA!數</dt>
                      <dd id="my-profile-pa"><? echo $users[7]; ?></dd>
                  </dl>
                  <dl class="dl-horizontal">
                      <dt>PU!數</dt>
                      <dd id="my-profile-pu"><? echo $users[8]; ?></dd>
                  </dl>
                  <dl class="dl-horizontal">
                      <dt>家鄉</dt>
                      <dd id="my-profile-hometown"><? echo $users[1]; ?></dd>
                  </dl>
                  <dl class="dl-horizontal">
                      <dt>所在地(PAPU!)</dt>
                      <dd id="my-profile-location_app"><? echo $users[0]; ?></dd>
                  </dl>
              </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success btn-lg" role="button" data-dismiss="modal">按我關掉</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>      
      
    <!-- ranking -->
    <div class="modal fade" id="myRank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <!--<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">Ranking</h4>
          </div>-->
          <div class="modal-body" style="bgcolor:#CDFEFF">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <div class="bs-docs-example">
                  <ul id="myTab" class="nav nav-tabs">
                      <li class="active"><a href="#rank-fr" data-toggle="tab">PAPU!友</a></li>
                      <li class=""><a href="#rank-pa" data-toggle="tab">PAPA! 王</a></li>
                      <li class=""><a href="#rank-pu" data-toggle="tab">PUPU! 王</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                      <div class="tab-pane fade active in" id="rank-fr">
                          <h2>擁有最多PAPU!友的人</h2>
                          <?
                                $show_rank = pg_query ($dbconn, "SELECT user_id,user_name,fri_list FROM papu ORDER BY fri_list DESC LIMIT 3;");
                                $rk = 1;
                                while ($data = pg_fetch_object($show_rank)) {
                          ?>
                                    <div>
                                    <h2>No.<? echo $rk ?> : <? echo $data->fri_list; ?> 人</h2>
                                    <a href="https://www.facebook.com/<? echo $data->user_id; ?>" target="_top">
                                        <img src="https://graph.facebook.com/<? echo $data->user_id; ?>/picture?type=square">
                                        <? echo $data->user_name; ?>
                                    </a><br></div>
                          <?
                                    $rk++;
                                }
                          ?>     
                      </div>
                      <div class="tab-pane fade" id="rank-pa">
                          <h2>PA!過最多地方的人</h2>
                          <?
                                $show_rankPA = pg_query ($dbconn, "SELECT user_id,user_name,pa_num FROM papu ORDER BY pa_num DESC LIMIT 3;");
                                $rkpa = 1;
                                while ($data = pg_fetch_object($show_rankPA)) {
                          ?>
                                    <div>
                                    <h2>No.<? echo $rkpa ?> : <? echo $data->pa_num; ?> 個地方</h2>
                                    <a href="https://www.facebook.com/<? echo $data->user_id; ?>" target="_top">
                                        <img src="https://graph.facebook.com/<? echo $data->user_id; ?>/picture?type=square">
                                        <? echo $data->user_name; ?>
                                    </a><br></div>
                          <?
                                    $rkpa++;
                                }
                          ?>
                          
                      </div>
                      <div class="tab-pane fade" id="rank-pu">
                          <h2>PU!過最多次的人</h2>
                          <?
                                $show_rankPU = pg_query ($dbconn, "SELECT user_id,user_name,pu_num FROM papu ORDER BY pu_num DESC LIMIT 3;");
                                $rkpu = 1;
                                while ($data = pg_fetch_object($show_rankPU)) {
                          ?>
                                    <div>
                                    <h2>No.<? echo $rkpu ?> : <? echo $data->pu_num; ?> 個人</h2>
                                    <a href="https://www.facebook.com/<? echo $data->user_id; ?>" target="_top">
                                        <img src="https://graph.facebook.com/<? echo $data->user_id; ?>/picture?type=square">
                                        <? echo $data->user_name; ?>
                                    </a><br></div>
                          <?
                                    $rkpu++;
                                }
                          ?>
                      </div>
                  </div>
              </div>
              
  
          </div>
          <div class="modal-footer">
            <button class="btn btn-success btn-lg" role="button" data-dismiss="modal">按我關掉</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
      
    <!-- quota -->
    <div class="modal fade" id="myQuota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">剩下的額度</h4>
          </div>
          <div class="modal-body" style="bgcolor:#CDFEFF">
              <h5>額度在每個整點會重製(MAX=1)</h5><br>
              <h3>你目前還可以再PA! <? echo $users[3]; ?> 次</h3><br>
              <h3>你目前還可以再PU! <? echo $users[2]; ?> 次</h3>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success btn-lg" role="button" data-dismiss="modal">按我關掉</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <!-- comment -->
    <div class="modal fade" id="myComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body" style="bgcolor:#CDFEFF">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>              
                  <div class="bs-docs-example">
                      <ul id="myTab" class="nav nav-tabs">
                          <li class="active"><a href="#papuB" data-toggle="tab">PAPU全域討論區</a></li>
                          <li class=""><a href="#localB" data-toggle="tab" ><? echo $users[0]; ?> 討論區</a></li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                          <div class="tab-pane fade active in" id="papuB">
                              <div class="fb-comments" data-href="http://sna-papu.herokuapp.com/" data-width="500" data-numposts="7" data-colorscheme="light"></div>
                          </div>
                          <div class="tab-pane fade" id="localB">
                              <div class="fb-comments" data-href="http://sna-papu.herokuapp.com/location/<? echo $users[0]; ?>.php" data-width="500" data-numposts="7" data-colorscheme="light"></div>
                          </div>
                      </div>
                  </div>
              
              
              
          </div>
          <div class="modal-footer">
            <button class="btn btn-success btn-lg" role="button" data-dismiss="modal">按我關掉</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>  
  
    <!--are you sure-->  
<div class="modal fade" id="myPA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">你目前還剩下： <? echo $users[3]; ?> 次 PA! 的機會!! </h4>
            </div>
            <div class="modal-body" style="bgcolor:#CDFEFF">
                <div id = "paC"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-lg" role="button" data-dismiss="modal" onclick="checkLocation('<? echo $users[0]; ?>')">按我關掉</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>    
      
      
    <!--introduction-->  
<div class="modal fade" id="myintro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">圖說PAPU!</h4>
            </div>
            <div class="modal-body" style="bgcolor:#CDFEFF">
                <center>
                <div class="fotorama">
                    <img src="./content/picture/doc00.png">
                    <img src="./content/picture/doc001.png">
                    <img src="./content/picture/doc003.png">
                    <img src="./content/picture/doc004.png">
                    <img src="./content/picture/doc005.png">
                </div>
                </center>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-lg" role="button" data-dismiss="modal" onclick="checkLocation('<? echo $users[0]; ?>')">按我關掉</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>    
      
      
      
      

    <?
        $puQuotatmp = pg_query ($dbconn, "SELECT COUNT(*) FROM papu WHERE user_id = '$uid';");
        $puQ =  pg_fetch_row($puQuotatmp);
    ?>
    <div class="container opacity">
      <div class="col-md-7">
         <div class="starter-template mapbox">          
          <div style="position: relative; width: 600px; height: 600px; top:0px; left: 0px;">

            <img id ="myPhoto" style="position: absolute; width:25px; height: 25px ; z-index: 20;" src = "https://graph.facebook.com/<?php echo $uid; ?>/picture?type=square"> <!-- set facebook photo and location variable -->
            <img src = "content/picture/map2/background2.png" alt="mpbg" width="580" height="550" style="position: absolute; top:0px; left:10px;"> 
            <a href="#myPA" data-toggle="modal"><img id ="Taipei" Title="台北" src = "content/picture/map2/Taipei.png" onClick="checkQuota('Taipei',<? echo $users[3]; ?>)" class='Taipei animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Taoyuan" Title="桃園" src = "content/picture/map2/Taoyuan.png" onClick="checkQuota('Taoyuan',<? echo $users[3]; ?>)" class='Taoyuan animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Ilan" Title="宜蘭" src = "content/picture/map2/Ilan.png" onClick="checkQuota('Ilan',<? echo $users[3]; ?>)" class='Ilan animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Hsinchu" Title="新竹" src = "content/picture/map2/Hsinchu.png" onClick="checkQuota('Hsinchu',<? echo $users[3]; ?>)" class='Hsinchu animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Miaoli" Title="苗栗" src = "content/picture/map2/Miaoli.png" onClick="checkQuota('Miaoli',<? echo $users[3]; ?>)" class='Miaoli animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Taichung" Title="台中" src = "content/picture/map2/Taichung.png" onClick="checkQuota('Taichung',<? echo $users[3]; ?>)" class='Taichung animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Hualien" Title="花蓮" src = "content/picture/map2/Hualien.png" onClick="checkQuota('Hualien',<? echo $users[3]; ?>)" class='Hualien animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Changhua" Title="彰化" src = "content/picture/map2/Changhua.png" onClick="checkQuota('Changhua',<? echo $users[3]; ?>)" class='Changhua animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Nantou" Title="南投" src = "content/picture/map2/Nantou.png" onClick="checkQuota('Nantou',<? echo $users[3]; ?>)" class='Nantou animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Yunlin" Title="雲林" src = "content/picture/map2/Yunlin.png" onClick="checkQuota('Yunlin',<? echo $users[3]; ?>)" class='Yunlin animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Chiayi" Title="嘉義" src = "content/picture/map2/Chiayi.png" onClick="checkQuota('Chiayi',<? echo $users[3]; ?>)" class='Chiayi animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Tainan" Title="台南" src = "content/picture/map2/Tainan.png" onClick="checkQuota('Tainan',<? echo $users[3]; ?>)" class='Tainan animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Kaohsiung" Title="高雄" src = "content/picture/map2/Kaohsiung.png" onClick="checkQuota('Kaohsiung',<? echo $users[3]; ?>)" class='Kaohsiung animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Pingtung" Title="屏東" src = "content/picture/map2/Pingtung.png" onClick="checkQuota('Pingtung',<? echo $users[3]; ?>)" class='Pingtung animated css'></a>
            <a href="#myPA" data-toggle="modal"><img id ="Taitung" Title="台東" src = "content/picture/map2/Taitung.png" onClick="checkQuota('Taitung',<? echo $users[3]; ?>)" class='Taitung animated css'></a>
              <img id ="trans" src = "content/picture/map2/trans.png" alt="mpbg" width="300" height="600" style="position: absolute; top:0px; left:210px; z-index: 30;"> 
              
              
              
            <!--toolbar-->
            <img src = "content/picture/map2/scorllbar2.png" alt="scorllbg" width="178" height="400" style="position: absolute; top:75px; left:30px;">
            <div style="position: absolute; top:124px; left:75px;">
                <div class="row">
                    <a href="javascript: return false;" onClick="checkLocation('<? echo $users[0]; ?>')" style="font-size:30px"><img src="content/picture/PA.png" width="120" height="39"></a>
                </div>
                <div class="row">
                    <a href="#myModal" data-toggle="modal" style="font-size:30px"><img src="content/picture/PU.png" width="120" height="39"></a>
                </div>
                <div class="row">
                    <a href="#myFriends" data-toggle="modal" style="font-size:30px"><img src="content/picture/frlist.png" width="120" height="39"></a>
                </div>
                <div class="row">
                    <a href="#myProfile" data-toggle="modal" style="font-size:30px"><img src="content/picture/profile.png" width="120" height="39"></a>
                </div>
                <div class="row">
                    <a href="#myRank" data-toggle="modal" style="font-size:30px"><img src="content/picture/ranking.png" width="120" height="39"></a>
                </div>
                <div class="row">
                    <a href="#myQuota" data-toggle="modal" style="font-size:30px"><img src="content/picture/cost.png" width="120" height="39"></a>
                </div>
                <div class="row">
                    <a href="#myComment" data-toggle="modal" style="font-size:30px"><img src="content/picture/board.png" width="120" height="39"></a>
                </div>
            </div>

          </div><!--/.container-->
        </div>
      </div>
      <div class="col-md-5">
        <div class="starter-template">

          <div id="msgbox" class="wh" style="position: relative; width: 400px; height: 550px;">
            <br>
            <div>
                <h3 style="color:red"><b>!!!緊急任務!!!</b></h3>
                <p style="color:white;font-size:16px">
                PAPU小精靈迷路了!<br>
                如果你能<b>PU!到他，並加他為好友</b><br>
                就可以跟小精靈領取神秘小禮物喔!!<br>
                <b>任務結束時間：2014/01/16 中午12:00</b><br>
                *PU!額度每小時會重置<br>
                *額度不會累積，敬請把握!!<br>
                </p><br><br>
                <img src="/logo/papu/sizes/papu-144.png">   
            </div>
          </div>

        </div>
      </div>

    </div><!-- /.container -->
    <script>
        initLocation('<? echo $users[0]; ?>');
    </script>
    
    <?
        pg_close($dbconn);
    ?>
  </body>
</html>
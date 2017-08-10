<?php
					function getPage()
					{
						return "<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <title>TRIPKLE | ADMIN | LOGIN</title>

    <!-- Bootstrap -->
    <link href='UserView/css/bootstrap.min.css' rel='stylesheet'>

    <!-- Custom Theme Style -->
    <link href='UserView/css/custom.min.css' rel='stylesheet'>
    <style type='text/css'>
      .login_btn
      {
        background: #09f;
        color: #fff;
        border: 1px solid #eee;
      }
      #progressHeader
      {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #eee;
        display: none;
      }
      #progressBar
      {
        float: left;
        height: 2px;
        width: 0%;
        box-shadow: 0px 0px 5px 0px #09f;
        -webkit-box-shadow: 0px 0px 5px 0px #09f;
        -moz-box-shadow: 0px 0px 5px 0px #09f;
        background-color: #09f;
      }
    </style>
  </head>
  <body class='login'>

  <h1>{{valaue}}</h1>
    <div id='progressHeader'>
      <div id='progressBar'></div>
    </div>

    <div>
      <div class='login_wrapper'>
        <div class='animate form login_form'>
          <section class='login_content'>
            <form id='sign_form'>
              <h1>SIGNIN</h1>
              <div id='login_msg' style='float: left;margin-bottom: 10px;color: #b20000;'></div>
              <div>
                <input type='text' class='form-control' placeholder='Email' id='username' />
              </div>
              <div>
                <input type='password' class='form-control' placeholder='Password' id='password' />
              </div>
              <div>
                <button type='button' class=' form-control login_btn' onclick='UserLogin();' id='loginBTN'>Login</button>
              </div>

              <div class='clearfix'></div>

              <div class='separator'>
                <div class='clearfix'></div>
                <br />

                <div>
                  <p>©2017 All Rights Reserved. Tripkle . <a href='hotels_privacy_terms'>Privacy and Terms</a></p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>

    <script type='text/javascript' src='UserView/js/fsn.minify.js'></script>
    <script type='text/javascript'>

    /*
      on window keyup if enter is pressed then login button is clicked
    */
    
      window.onkeyup = function(event)
      {
        if(event.keyCode == 13)
        {
          UserLogin();
        }
      };

      function UserLogin()
      {
        var username = fsn('#username').val();
        var password = fsn('#password').val();

        if(username == '' && password == '')
        {
          fsn('#login_msg').text('Please enter email address or mobile number or username and password');
          return false;
        }
        if(username == '')
        {
          fsn('#login_msg').text('Please enter email address or mobile number or username');
          return false;
        }

        if(password == '')
        {
          fsn('#login_msg').text('Please enter password');
          return false;
        }

        fsn('#login_msg').text('');

        fsn.http({
          url:'/tripkle_admin/',
          data:'&cortex=UserAuth&username='+username+'&password='+password,
          progressType:'Progressbar',
          ProgressContainer:'progressHeader',
          Progressbar:'progressBar',
          requestMethod:'POST',
          contentType:'url-encode',
          success:function(callback)
          {
            var obj = JSON.parse(callback);
            if(obj['status'])
            {
              window.location.reload(true);
            }
            else
            {
              fsn('#login_msg').text(obj['msg']);
            }
          }
        });
      }
    </script>
  </body>
</html>
";
					}
				?>
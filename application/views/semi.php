<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 위 3개의 메타 태그는 *반드시* head 태그의 처음에 와야합니다; 어떤 다른 콘텐츠들은 반드시 이 태그들 *다음에* 와야 합니다 -->
    <title>세미연수 로그인세션</title>

    <!-- 합쳐지고 최소화된 최신 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

    <!-- IE8 에서 HTML5 요소와 미디어 쿼리를 위한 HTML5 shim 와 Respond.js -->
    <!-- WARNING: Respond.js 는 당신이 file:// 을 통해 페이지를 볼 때는 동작하지 않습니다. -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style type="text/css">
    body {
      padding-top: 40px;
      padding-bottom: 40px;
      background-color: #eee;
    }
    .container {
      /*width: 970px;*/
    }
    .form-signin {
      max-width: 330px;
      padding: 15px;
      margin: 0 auto;
    }
    .form-signin input[type="text"] {
      margin-bottom: -1px;

    }
    .form-signin .form-control {
      position: relative;
      height: auto;
      padding: 10px;
      font-size: 16px;
    }
    .btn {
      margin-top: 10px;
      margin-bottom: 10px;
    }
  </style>
  <body>
    <div class="container">

      <div class="form-signin">
        <h2 class="form-signin-heading">세미연수 Local</h2>
        <label for="mb_id" class="sr-only">아이디</label>
        <input type="text" id="mb_id" class="form-control" placeholder="아이디" required autofocus>
        <label for="mb_pw" class="sr-only">비밀번호</label>
        <input type="password" id="mb_pw" class="form-control" placeholder="비밀번호" required>
        <button class="btn btn-lg btn-primary btn-block" id="btn_login">로그인</button>
      </div>

    </div> <!-- /container -->

    <!-- jQuery (부트스트랩의 자바스크립트 플러그인을 위해 필요합니다) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
      $(function(){
        $('#mb_id , #mb_pw').keypress(function (e) {
          var key = e.which;
          if(key == 13)  // the enter key code
           {
              login();
           }
        });

        $('#btn_login').click(function(){
          login();
        });
      });

      function login()
      {
        var mb_id = $('#mb_id').val();
        var mb_pw = $('#mb_pw').val();

        if(!mb_id || !mb_pw)
        {
          alert('로그인 정보를 입력하세요.');
          return false;
        }
        else
        {
            $.post(
              "<?=HOSTURL?>/ELO/Semi/RpcLogin"
              ,{
                   "mb_id" : $('#mb_id').val() 
                   ,"mb_pw" : $('#mb_pw').val() 
               }
              ,function(data, status) {
                  if (status == "success" && data.code == 1)
                  {
                      window.location.href="<?=HOSTURL?>/ELO/Semi/Main";
                  }
                  else
                  {
                      alert("로그인 정보를 확인 후 다시 로그인하세요.");
                  }
              }
            );
        }
      }
    </script>
  </body>
</html>
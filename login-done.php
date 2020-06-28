<html>

<head>
    <title>データ工学概論 201811417</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <!-- Material Components for the web -->
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700">
    <link rel="stylesheet" href="css/style.css">
</head>
<header>
    <div class="centering">
        <h1><a href="index.html">Discord Emoji</a></h1>
        <div class="madeby">201811417, 佐藤大樹</div>
    </div>
</header>

<body>
    <div class="centering">
        <?php
        session_start();

        //DB内でPOSTされたメールアドレスを検索
        $host = "localhost";
        if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
            die("MySQL接続エラー.<br />");
        }
        mysqli_select_db($conn, "s1811417");
        mysqli_set_charset($conn, "utf8");

        $userid = $_POST['userid'];
        $sql = "SELECT * FROM user where userid LIKE \"{$userid}\"";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        //emailがDB内に存在しているか確認
        if (!isset($row['userid'])) {
            echo 'ユーザーID又はパスワードが間違っています。';
            return false;
        }
        //パスワード確認後sessionにメールアドレスを渡す
        if (password_verify($_POST['password'], $row['password'])) {
            session_regenerate_id(true); //session_idを新しく生成し、置き換える
            $_SESSION['USERID'] = $row['userid'];
            print('<p>ログインしました</p>');
            print("<a href=\"index.html\">トップページへ</a>");
        } else {
            echo 'ユーザーID又はパスワードが間違っています。';
            return false;
        }
        ?>
    </div>
</body>

</html>
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
        <h2>サインアップ</h2>
        <?php
        //パスワードの正規表現
        if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        } else {
            print('パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。');
            return false;
        }
        $userid = $_POST['userid'];
        // ユーザーIDの被りを検出
        $sql = "SELECT COUNT(*) FROM emoji where userid LIKE \"{$userid}\"";
        print("ユーザーID: {$userid}<br>");
        //登録処理
        $host = "localhost";
        if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
            die("MySQL接続エラー.<br />");
        }
        mysqli_select_db($conn, "s1811417");
        mysqli_set_charset($conn, "utf8");
        $sql = "INSERT INTO user(userid, password) VALUES('" . $userid . "', '" . $password . "')";

        mysqli_query($conn, $sql) or die("登録できませんでした。");
        print("<p>登録完了</p>");
        print("<a href=\"login.php\">ログインして下さい。</a>");
        ?>
    </div>
</body>

</html>
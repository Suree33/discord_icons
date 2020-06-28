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
        function h($s)
        {
            return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
        }

        session_start();

        if (isset($_SESSION['USERID'])) {
            echo '<p>"' .  h($_SESSION['USERID']) . "\"としてログインしています</p>\n";
        } else {
            print("<p>ログインしていません。ログインして下さい。</p>");
            print("<a class=\"btn\" href=\"login.php\">ログイン</a>");
            exit;
        }
        $emoji_id = $_GET['emoji_id'];

        $host = "localhost";
        if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
            die("MySQL接続エラー.<br />");
        }
        mysqli_select_db($conn, "s1811417");
        mysqli_set_charset($conn, "utf8");

        $sql = "SELECT * FROM emoji WHERE id={$emoji_id}";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        if (strcmp($row['uploadedBy_id'], $_SESSION['USERID']) == 0) {
            $sql = "DELETE FROM emoji WHERE id={$emoji_id}";
            mysqli_query($conn, $sql) or die("削除できませんでした");
            print("削除しました。<a href=\"search.php\">検索ページ</a>で確認してください。");
        } else {
            print("<p>削除はアップロードしたユーザーのみが可能です。</p>");
            print("<p>この絵文字は{$row['uploadedBy_id']}によって追加されました。</p>");
            print("<a class=\"btn\" href=\"logout.php\">ログアウト</a>");
        }
        ?>
    </div>
</body>

</html>
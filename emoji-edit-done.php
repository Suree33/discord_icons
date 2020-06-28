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
        <h2>絵文字の追加</h2>
        <?php
        function h($s)
        {
            return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
        }

        session_start();

        if (isset($_SESSION['USERID'])) {
            echo '<p>"' .  h($_SESSION['USERID']) . "\"としてログインしています</p><br>";
        } else {
            echo '<p>ログインしていません。ログインして下さい。</p>';
            echo '<a class="btn" href="login.php">ログイン</a>';
            exit;
        }

        // htmlページから値の受け取り
        $title = $_POST['title'];
        $shortcut = $_POST['shortcut'];
        $genre = $_POST['genre'];
        $emoji_id = $_GET['emoji_id'];

        // dbに接続
        $host = "localhost";
        if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
            die("MySQL接続エラー.<br />");
        }
        mysqli_select_db($conn, "s1811417");
        mysqli_set_charset($conn, "utf8");


        // ショートカットの被りを検出
        $sql_count = "SELECT COUNT(shortcut) AS shortcut_count FROM emoji WHERE shortcut LIKE \"" . $shortcut . "\"";
        $res_count = mysqli_query($conn,  $sql_count);
        $row_count = mysqli_fetch_array($res_count);
        // 自分自身かどうかも確認
        $sql = "SELECT * FROM emoji WHERE shortcut LIKE \"" . $shortcut . "\"";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        if ($row["shortcut_count"] >= 1 && $row["id"] != $emoji_id) {
            die("同名のショートカット「" . $shortcut . "」を持つデータが既に登録されています。");
        }

        // dbに登録
        $sql = "UPDATE emoji SET title='{$title}',shortcut='{$shortcut}',genre_id={$genre} WHERE id={$emoji_id}";

        mysqli_query($conn, $sql) or die("登録できませんでした。");
        print("登録しました。<a href=\"search.php\">検索ページ</a>で確認できます。");
        ?>
    </div>
</body>

</html>
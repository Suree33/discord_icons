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

        // dbに接続
        $host = "localhost";
        if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
            die("MySQL接続エラー.<br />");
        }
        mysqli_select_db($conn, "s1811417");
        mysqli_set_charset($conn, "utf8");

        // ショートカットの被りを検出
        $sql = "SELECT COUNT(shortcut) AS shortcut_count FROM emoji WHERE shortcut LIKE \"" . $shortcut . "\"";
        $r = mysqli_query($conn,  $sql);
        $row = mysqli_fetch_array($r);
        if ($row["shortcut_count"] >= 1) {
            die("同名のショートカット「" . $shortcut . "」を持つデータが既に登録されています。");
        }

        // ファイルの処理 START
        // ファイルサイズ
        $filesize = $_FILES['emoji_file']['size'] / 1000;
        if ($filesize > 256) {
            die("ファイルサイズが大きすぎます(" . $filesize . "KB)。<br>256KB以下の画像を使用して下さい。");
        }
        print("Size: " . $filesize . "KB<br>");
        $file = $_FILES['emoji_file']['tmp_name'];
        $data = file_get_contents($_FILES['emoji_file']['tmp_name']);
        list($image_width, $image_height) = getimagesizefromstring($data);
        if ($image_width > 128 || $image_height > 128) {
            die("画像の解像度が大きすぎます({$image_width}×{$image_height})。<br>128×128以下の画像を使用して下さい。");
        }
        // アップロード先フォルダ
        $uploadTo = "img/emojis/";
        // 拡張子を取得
        $upfilename = $_FILES['emoji_file']['name'];
        print($upfilename . "<br>");
        $pos = strrpos($upfilename, ".");
        $ext = substr($upfilename, $pos + 1, strlen($upfilename) - $pos);

        // ファイル名を作成
        $filename = $uploadTo . $shortcut . "." . $ext;
        print($filename . "<br>");

        // アップロードを実行
        if (move_uploaded_file($_FILES['emoji_file']['tmp_name'], $filename) == FALSE) {
            print("画像のアップロードに失敗しました。<br>");
            print($_FILES['emoji_file']['error']);
        } else {
            print("<strong>" . $filename . "</strong>は正しくアップロードされました。<br>");
        }
        // ファイルの処理 END

        // dbに登録
        $sql = "INSERT INTO emoji(title, image_path, shortcut, uploadedBy_id, genre_id) VALUES('$title', '$filename', '$shortcut', '{$_SESSION['USERID']}', '$genre')";

        mysqli_query($conn, $sql) or die("登録できませんでした。");

        // 自分がアップロードした最新の1件を取得
        $sql = "SELECT * FROM emoji WHERE uploadedBy_id LIKE \"{$_SESSION['USERID']}\" ORDER BY id DESC LIMIT 1";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        print("データベースに登録しました。<a href=\"emoji.php?emojiID={$row['id']}\">絵文字の詳細ページ</a>で確認できます。");
        ?>
    </div>
</body>

</html>
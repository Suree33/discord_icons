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
        ?>
        <form method="POST" enctype="multipart/form-data" action="uploaded_emoji.php">
            <table class="input-form">
                <tr>
                    <th>絵文字ファイル</th>
                    <td class="file-upload"><input required type="file" accept="image/png, image/jpeg, image/gif" name="emoji_file"></td>
                </tr>
                <tr>
                    <th>タイトル</th>
                    <td><input autofocus required type="text" name="title" placeholder="32文字以内" maxlength="32"></td>
                    <td>絵文字の名前</td>
                </tr>
                <tr>
                    <th>ショートカット</th>
                    <td><input required pattern="^[a-zA-Z_0-9]+$" type="text" name="shortcut" placeholder="英数字とアンダーバーのみ、2~32文字" maxlength="32"></td>
                    <td>絵文字を入力するときのキー</td>
                </tr>
                <tr>
                    <th>ジャンル</th>
                    <td>
                        <select required class="genre" name="genre">
                            <?php
                            $host = "localhost";
                            if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
                                die("MySQL接続エラー.<br />");
                            }
                            mysqli_select_db($conn, "s1811417");
                            mysqli_set_charset($conn, "utf8");
                            $sql = "SELECT * FROM genre";
                            $res = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($res)) {
                                print("<option value=\"" . $row['id'] . "\">" . $row['genre_name'] . "</option>\n");
                            }
                            mysqli_free_result($res);
                            ?>
                        </select>
                    </td>
                    <td>絵文字のジャンル</td>
                </tr>
                <tr>
                    <th></th>
                    <td><input class="btn" type="submit" value="追加"></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>
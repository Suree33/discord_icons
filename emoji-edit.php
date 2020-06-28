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
            echo '<p>ログインしていません。ログインして下さい。</p>';
            echo '<a class="btn" href="login.php">ログイン</a>';
            exit;
        }

        $host = "localhost";
        if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
            die("MySQL接続エラー.<br />");
        }
        mysqli_select_db($conn, "s1811417");
        mysqli_set_charset($conn, "utf8");

        $emoji_id = $_GET['emoji_id'];

        $sql = "SELECT * FROM emoji where id=" . $emoji_id;
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        if (strcmp($row['uploadedBy_id'], $_SESSION['USERID']) != 0) {
            print("<p>編集はアップロードしたユーザーのみが可能です。</p>");
            print("<p>この絵文字は{$row['uploadedBy_id']}によって追加されました。</p>");
            print("<a class=\"btn\" href=\"logout.php\">ログアウト</a>");
            exit;
        }

        print("<form class=\"emoji-detail edit\" action=\"emoji-edit-done.php?emoji_id={$_GET['emoji_id']}\" method=\"post\">\n<table class=\"input-form\">\n<tr>\n<th>絵文字ファイル</th>\n");
        print("<td class=\"preview-wrapper\">\n");
        print("<div class=\"preview-item dark\">\n");
        print("<img src=\"" . $row['image_path'] . "\">\n");
        print("</div>\n");
        print("<div class=\"preview-item light\">\n");
        print("<img src=\"" . $row['image_path'] . "\">\n");
        print("</div>\n");
        print("</td>\n");
        print("<tr>\n<th>タイトル</th>\n");
        print("<td><input autofocus required type=\"text\" name=\"title\" placeholder=\"32文字以内\" maxlength=\"32\" value=\"{$row['title']}\"></td>");
        print("<td>絵文字の名前</td>\n</tr>\n<tr>\n<th>ショートカット</th>\n");
        print("<td><input required pattern=\"^[a-zA-Z_0-9]+$\" type=\"text\" name=\"shortcut\" placeholder=\"英数字とアンダーバーのみ、2~32文字\" maxlength=\"32\" value={$row['shortcut']}></td>");
        print("<td>絵文字を入力するときのキー</td>\n</tr>\n<tr>\n<th>ジャンル</th>\n<td>\n<select required class=\"genre\" name=\"genre\">");

        $sql_genre = "SELECT * FROM genre";
        $res_genre = mysqli_query($conn, $sql_genre);
        while ($row_genre = mysqli_fetch_array($res_genre)) {
            print("<option value=\"{$row_genre['id']}\"");
            if ($row_genre['id'] == $row['genre_id']) {
                print(" selected>{$row_genre['genre_name']}</option>\n");
            } else {
                print(">{$row_genre['genre_name']}</option>");
            }
        }
        mysqli_free_result($res);
        ?>
        </select>
        </td>
        <td>絵文字のジャンル</td>
        </tr>
        <tr>
            <th></th>
            <td><input class="btn" type="submit" value="更新"></td>
        </tr>
        </table>
        </form>
    </div>
</body>

</html>
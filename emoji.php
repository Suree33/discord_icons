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
        <div class="emoji-detail">
            <table>
                <?php
                $host = "localhost";
                if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
                    die("MySQL接続エラー.<br />");
                }
                mysqli_select_db($conn, "s1811417");
                mysqli_set_charset($conn, "utf8");

                $emoji_id = $_GET['emojiID'];

                $sql = "SELECT * FROM emoji where id=" . $emoji_id;
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($res);

                $sql_genre = "SELECT * FROM genre where id=" . $row['genre_id'];
                $res_genre = mysqli_query($conn, $sql_genre);
                $row_genre = mysqli_fetch_array($res_genre);

                print("<h2>" . $row["title"] . "</h2>\n");
                print("<div class=\"uploadedBy\">by " . $row['uploadedBy_id'] . "</div>\n");
                print("<div class=\"genre\">{$row_genre['genre_name']}</div>\n");
                print("<div class=\"shortcut\">:{$row['shortcut']}:</div>\n");
                print("<div class=\"preview-wrapper\">\n");
                print("<div class=\"preview-item dark\">\n");
                print("<img src=\"" . $row['image_path'] . "\">\n");
                print("</div>\n");
                print("<div class=\"preview-item light\">\n");
                print("<img src=\"" . $row['image_path'] . "\">\n");
                print("</div>\n");
                print("</div>\n");
                print("<a class=\"btn\" href=\"emoji-edit.php?emoji_id={$emoji_id}\">編集</a>");
                print("<a class=\"btn outlined\" href=\"emoji-delete.php?emoji_id={$emoji_id}\">削除</a>");

                mysqli_free_result($res);
                ?>
        </div>
    </div>
</body>

</html>
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
        <h2>検索</h2>
        <p>絵文字の名前で検索が出来ます。</p>
        <form action="search-emoji.php" method="POST">
            <div class="search-bar">
                <input class="search-input" type="text" name="search-input">
                <input class="material-icons search-submit" type="submit" name="submit" value="search">
            </div>
            <div class="chips-genre">
                <?php
                $host = "localhost";
                if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
                    die("MySQL接続エラー.<br />");
                }
                mysqli_select_db($conn, "s1811417");
                mysqli_set_charset($conn, "utf8"); //utf8コードの利用にはこれが必要
                $sql = "SELECT * FROM genre";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($res)) {
                    print("<input type=\"radio\" id=\"" . $row['id'] . "\" name=\"genre\" value=\"" . $row['id'] . "\"><label for=\"" . $row['id'] . "\">" . $row["genre_name"] . "</label><br>");
                }
                mysqli_free_result($res);
                ?>
            </div>
        </form>
    </div>
</body>

</html>
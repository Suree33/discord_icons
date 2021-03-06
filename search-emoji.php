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
        $host = "localhost";
        if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")) {
            die("MySQL接続エラー.<br />");
        }
        mysqli_select_db($conn, "s1811417");
        mysqli_set_charset($conn, "utf8");

        $condition = "";

        if (isset($_POST["search-input"]) && ($_POST["search-input"] != "")) {
            $input = mysqli_escape_string($conn, $_POST["search-input"]);
            $input = str_replace("%", "\%", $input);
            $condition = "WHERE title LIKE \"%" . $input . "%\"";
        }
        if (isset($_POST["genre"]) && ($_POST["genre"] != "")) {
            $genre = $_POST["genre"];
            if ($condition == "") {
                $condition = "WHERE genre_id=" . $genre;
            } else {
                $condition = $condition . "AND genre_id=" . $genre;
            }
        }

        $sql = "SELECT * FROM emoji " . $condition . " ORDER BY id DESC";
        $res = mysqli_query($conn, $sql);

        print("<ul class=\"emoji-list\">\n");
        print("");
        while ($row = mysqli_fetch_array($res)) {
            print("<li class=\"emoji-list-item\">\n");
            print("<a href=\"emoji.php?emojiID=" . $row["id"] . "\">\n");
            print("<img class=\"emoji-list-image\" src=\"" . $row["image_path"] . "\" >\n");
            print("<div class=\"emoji-list-text\">\n");
            print("<div class=\"title\">" . $row["title"] . "</div>\n");
            print("<div class=\"shortcut\">:" . $row["shortcut"] . ":</div>\n");
            print("</div>\n");
            print("</a>\n");
            print("</li>\n");
        }
        print("</ul>");
        mysqli_free_result($res);
        ?>
    </div>
</body>

</html>
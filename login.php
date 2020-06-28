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
        //ログイン済みの場合
        if (isset($_SESSION['USERID'])) {
            echo '<p>"' .  h($_SESSION['USERID']) . "\"としてログインしています</p><br>";
            echo "<a class=\"btn\" href='logout.php'>ログアウト</a>";
            exit;
        }
        ?>
        <h2>ログイン</h2>
        <form action="login-done.php" method="post">
            <table class="input-form">
                <tr>
                    <th><label for="userid">ユーザー ID</label></th>
                    <td><input type="text" name="userid" pattern="^[0-9A-Za-z]+$" minlength="1" maxlength="256" required></td>
                </tr>
                <tr>
                    <th><label for="password">パスワード</label></th>
                    <td><input type="password" name="password" minlength="8" maxlength="256" required></td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input class="btn" type="submit" value="サインイン">
                    </td>
                </tr>
            </table>
        </form>
        <h2>初めての方はこちら</h2>
        <form action="signup.php" method="post">
            <table class="input-form">
                <tr>
                    <th><label for="userid">ユーザー ID</label></th>
                    <td><input type="text" name="userid" pattern="^[0-9A-Za-z]+$" maxlength="256" required></td>
                </tr>
                <tr>
                    <th><label for="password">パスワード</label></th>
                    <td><input type="password" name="password" minlength="8" maxlength="256" required></td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input class="btn" type="submit" value="サインアップ">
                    </td>
                </tr>
            </table>
            <p>※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
        </form>
    </div>
</body>

</html>
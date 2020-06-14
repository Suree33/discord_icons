<html>
<head><title>配列データの取得</title></head>
<body>
<table border="1">
<tr>
<th>id</th>
<th>username</th>
<th>icon_path</th>
</tr>
<?php
$host = "localhost";
if (!$conn = mysqli_connect($host, "s1811417", "std3590", "s1811417")){
    die("MySQL接続エラー.<br />");
}
mysqli_select_db($conn, "s1811417");
mysqli_set_charset($conn, "utf8"); //utf8コードの利用にはこれが必要
$sql = "SELECT * FROM user";
$res = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($res)) {
    print("<tr>");
    print("<td>".$row["id"]."</td>");
    print("<td>".$row["username"]."</td>");
    print("<td><img src=\"".$row["icon_path"]."\"/></td>");
    print("</tr>\n");
}
mysqli_free_result($res);
?>
</table>
</body>
</html>

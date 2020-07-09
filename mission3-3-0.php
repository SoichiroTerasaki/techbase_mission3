<!--3-3は3-2の続きから書き始めます。下記は3-2-1,2,3,4.phpと同じです。-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-2</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前">
        <input type="text" name="str" placeholder="コメント">
        <input type="submit" name="submit">
    </form>
    <?php
        $filename = "mission_3-2.txt";
        $name = $_POST["name"]; #名前を取得
        $str = $_POST["str"]; #コメント内容を取得
        $date = date("Y年m月d日 H:i:s"); #date : 投稿日時
        #num : 投稿番号
        $num = 1;
        if (file_exists($filename)){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            $num = count($lines) + 1; #ファイルの行数を数え、行数+1を投稿番号にします。
        }
        
        $new_line = $num."<>".$name."<>".$str."<>".$date.PHP_EOL; #new_line : 書き込む行
        
        if (empty($_POST) == false){ #もし送信されたものがあれば
            $fp = fopen($filename, "a"); #追記モードでファイルを開き

            fwrite($fp, $new_line); #ファイルに書き込みます
            fclose($fp);
            echo "ok<br>";
        }
        
        $lines = file($filename,FILE_IGNORE_NEW_LINES); #ファイルを1行ずつ読み込み、配列変数$linesに代入する
        foreach($lines as $line){                       #ファイルを読み込んだ配列を、配列の数（＝行数）だけループさせる
            $elems = explode("<>",$line);               #ループ処理内：区切り文字「<>」で分割して、それぞれの値$elemsを取得
            foreach($elems as $elem){
                echo $elem." ";                         #同・ループ処理内：上記で取得した値$elemをecho等を用いて表示
            }
            echo "<br>";
        }
        
    ?>
</body>
</html>
© 2020 GitHub, Inc.

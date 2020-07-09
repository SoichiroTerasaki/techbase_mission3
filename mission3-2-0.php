<!--3-2は3-1の続きから書き始めます-->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-1</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前"> <!--コメントフォームの作成-->
        <input type="text" name="str" placeholder="コメント">
        <input type="submit" name="submit">
    </form>
    
    <?php
        $filename = "mission_3-1.txt";
        $date = date("Y年m月d日 H:i:s"); #date : 投稿日時の値を取得
        $name = $_POST["name"]; #名前を取得
        $str = $_POST["str"]; #コメント内容を取得
        
        $num = 1; #num : 投稿番号
        if (file_exists($filename)){ #もし、事前に投稿されていたら
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            $num = count($lines) + 1; #ファイルの行数を数え、行数+1を投稿番号にします。
        }
        
        $new_line = $num."<>".$name."<>".$str."<>".$date.PHP_EOL; #new_line : 書き込む行
        
        if (empty($_POST) == false){
            $fp = fopen($filename, "a"); #文末への追記モードで開いて
            fwrite($fp, $new_line); #書き込みます。
            fclose($fp); #ファイルを閉じます。
            
            #echo $new_line."<br>";
            echo "ok";
        }
        
    ?>

</body>
</html>

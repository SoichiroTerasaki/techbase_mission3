<!--【ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数に代入する。 ファイルを開き、先ほどの配列の要素数（＝行数）だけループさせる】-->
<!--【ループ処理内：区切り文字「<>」で分割して、投稿番号を取得】-->
<!--【同・ループ処理内：投稿番号と削除対象番号を比較。等しくない場合は、ファイルに追加書き込みを行う】-->
<!--3-3-3で作った大枠の中に処理を書き加えていきます（44~59行目）-->


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-3</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前">
        <input type="text" name="str" placeholder="コメント">
        <input type="submit" name="submit">
        
        <input type="number" name="submit_num" placeholder="数字"> <!--削除フォームの作成-->
        <input type="submit" name="delete" value="削除">
    </form>
    <?php
        $filename = "mission_3-3.txt";
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
        
        if (isset($_POST["submit"])){ #もし送信されたものがあれば
            $fp = fopen($filename, "a"); #追記モードでファイルを開き

            fwrite($fp, $new_line); #ファイルに書き込みます
            fclose($fp);
            echo "ok<br>";
        }
        
        else if (isset($_POST["delete"])){
            $delete_num = $_POST["submit_num"]; #入力された数字の値を取得
            $lines = file($filename,FILE_IGNORE_NEW_LINES);                #ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数に代入する。
            
            $fp = fopen($filename, "w");                                   #先頭への追記モードでファイルを開き
            #削除番号と等しい投稿番号があるかどうか、1行ずつ確認します。
            foreach($lines as $line){                                      #先ほどの配列の要素数（＝行数）だけループさせる
                $contents = explode("<>",$line);                           #ループ処理内：区切り文字「<>」で分割して
                $number = $contents[0];                                    #投稿番号を取得
                if ($contents[0] != $delete_num){                          #同・ループ処理内：投稿番号と削除対象番号を比較。等しくない場合は
                    fwrite($fp, $line.PHP_EOL);                            #ファイルに追加書き込みを行う(もとのまま書き込みます)
                }
            }
            fclose($fp);                                                   #ファイルを閉じて終了します。
            echo "ok";
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

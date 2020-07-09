<!--【既存の投稿フォームに、上記で取得した「名前」と「コメント」の内容が既に入っている状態で表示させる】-->
<!--<form>の内部でphpの処理結果を使いたので、<form>の部分をphpの後に移動します。-->
<!--コメントフォームの<input value>の値を設定します（88,89行目）-->



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-4</title>
</head>
<body>
    
    <?php
        $filename = "mission_3-4.txt";
        $name = $_POST["name"]; #名前を取得
        $str = $_POST["str"]; #コメント内容を取得
        $date = date("Y年m月d日 H:i:s"); #date : 投稿日時

        if (file_exists($filename)){
            $lines = file($filename,FILE_IGNORE_NEW_LINES); #ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数に代入する。
            $last_line = end($lines);                       #最後の行だけを取り出す
            $contents = explode("<>",$last_line);                #最後の行を<>で分割する。
            $last_num = $contents[0];                       #$contents[0]は最後の行の投稿番号になっている
            $num = $last_num + 1;                           #投稿番号$numは、最後の行の投稿番号に+1したものになる
        }
        else {                                              #ファイルが存在しなかった場合
            $num = 1; #num : 投稿番号
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
        
        else if (isset($_POST["edit"])){
            $edit_num = $_POST["submit_edit_num"];                      #入力された数値を取得
            $lines = file($filename,FILE_IGNORE_NEW_LINES);             #ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数に代入する。
            $fp = fopen($filename, "r");                                #読取モードでファイルを開き
            foreach($lines as $line){                                   #先ほどの配列の要素数（＝行数）だけループさせる
                $contents = explode("<>",$line);                        #区切り文字「<>」で分割して
                $number = $contents[0];                                 #投稿番号を取得
                if ($number == $edit_num){                              #投稿番号と編集対象番号を比較。イコールの場合は
                    $edit_name = $contents[1];                          #その投稿の「名前」と
                    $edit_comment = $contents[2];                       #「コメント」を取得
                }
            }
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
    
    <form action="" method="post">
        <!--コメントフォームの作成-->
        <input type="num" name="option" value="<?php echo $edit_num; ?>"> <!-- php内の$edit_numを表示 -->
        <input type="text" name="name" value="<?php echo $edit_name; ?>" placeholder="名前"> <!--  php内の$edit_nameを表示-->
        <input type="text" name="comment" value="<?php echo $edit_comment; ?>" placeholder="コメント"> <!--  php内の$edit_commentを表示-->
        <input type="submit" name="submit" value="送信"><br>
        <!--削除フォームの作成-->
        <input type="number" name="submit_num" placeholder="削除したい番号を入力">
        <input type="submit" name="delete" value="削除"><br>
        <!--編集フォームの作成-->
        <input type="number" name="submit_edit_num" placeholder="編集したい番号を入力">
        <input type="submit" name="edit" value="編集">
    </form>
    
    
</body>
</html>

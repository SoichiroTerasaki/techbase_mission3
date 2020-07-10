<!--【テキストファイルに保存する文字列を改修する】-->
<!--$passwordの定義：20行目、書き込む行の改修：33行目-->



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    
    <?php
        $filename = "mission_3-5.txt";
        $name = $_POST["name"]; #名前を取得
        $str = $_POST["str"]; #コメント内容を取得
        $date = date("Y年m月d日 H:i:s"); #date : 投稿日時
        $option = $_POST["option"];
        $password = $_POST["password"]; #password : パスワードを取得

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
        
        $new_line = $num."<>".$name."<>".$str."<>".$date."<>".$password."<>"PHP_EOL; #「投稿番号・名前・コメント・投稿日時・パスワード」に改修する
        #このとき、パスワードの後ろ(右側)にも区切り文字「<>」を付けておくと安全。文字列の最後にある「改行」も一種の文字として扱われるため、改行が付いていると文字列が一致しないと判断される。「<>」を付けることで改行を切り離すことができる。
        
        if (isset($_POST["submit"])){ #もし送信されたものがあれば
        
            if ($option != ""){                                                  #オプションが空かどうか確認する。空でないときは
                $lines = file($filename,FILE_IGNORE_NEW_LINES);                  #テキストファイルの中身を取り出し
                $fp = fopen($filename, "w");                                     #先頭への追記モードでファイルを開き
                foreach($lines as $line){
                    $contents = explode("<>",$line);
                    $number = $contents[0];                                      #各行の投稿番号を
                    if ($number == $option){                                     #比較。一致した時のみ
                        $re_line = $option."<>".$name."<>".$comment."<>".$date;  #編集のフォームから送信された値と
                        fwrite($fp, $re_line.PHP_EOL);                           #差し替える。
                    }
                    else {                                                       #投稿番号と一致しないときは
                        fwrite($fp, $line.PHP_EOL);                              #もとのまま書き込む
                    }
                }
            }
            
            else{                            #オプションがない、つまり普通の新規書き込みの場合
                $fp = fopen($filename, "a"); #追記モードでファイルを開き

                fwrite($fp, $new_line); #ファイルに書き込みます
                fclose($fp);
                echo "ok<br>";
            }
        }
        
        else if (isset($_POST["delete"])){
            $delete_num = $_POST["submit_num"]; #入力された数字の値を取得
            $lines = file($filename,FILE_IGNORE_NEW_LINES);                #ファイル読み込み関数で、ファイルの中身を1行1要素として配列変数に代入する。
            
            $fp = fopen($filename, "w");                                   #先頭への追記モードでファイルを開き
            #削除番号と等しい投稿番号があるかどうか、1行ずつ確認します。
            foreach($lines as $line){                                      #先ほどの配列の要素数（＝行数）だけループさせる
                $contents = explode("<>",$line);                           #ループ処理内：区切り文字「<>」で分割して
                $number = $contents[0];                                    #投稿番号を取得
                if ($number != $delete_num){                               #同・ループ処理内：投稿番号と削除対象番号を比較。等しくない場合は
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
        <input type="text" name="str" value="<?php echo $edit_comment; ?>" placeholder="コメント"> <!--  php内の$edit_commentを表示-->
        <input type="text" name="password" placeholder="パスワード">
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
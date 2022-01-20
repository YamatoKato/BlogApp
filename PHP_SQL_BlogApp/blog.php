<?php

require_once("dbc.php");

class Blog extends Dbc{  //データ処理系のクラスを継承した
    //3.カテゴリ名を表示
    //引数：数字
    //返り値：カテゴリーの文字列
    public function setCategoryName($category){   //値が変化しない(静的)関数はstaticでもおk
        if($category === "1"){
            return "日常";
        } elseif($category === "2"){
            return "プログラミング";
        } else {
            return "その他";
        }
            

    }

    public function blogCreate($blogs){
        $sql = "INSERT INTO 
            $this->table_name(title,content,category,publish_status)
        VALUES
            (:title,:content,:category,:publish_status)";
    
        $dbh = $this->dbConnect();
        $dbh ->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":title",$blogs["title"],\PDO::PARAM_STR);
            $stmt->bindValue(":content",$blogs["content"],\PDO::PARAM_STR);
            $stmt->bindValue(":category",$blogs["category"],\PDO::PARAM_INT);
            $stmt->bindValue(":publish_status",$blogs["publish_status"],\PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
            echo "ブログを投稿しました!";
        }catch(PDOException $e){
            $dbh->rollBack();
            exit($e);
        }
    }

    public function blogUpdate($blogs){
        $sql = "UPDATE $this->table_name SET 
            title = :title,content = :content,category = :category,publish_status = :publish_status
        WHERE
            id = :id";

    
        $dbh = $this->dbConnect();
        $dbh ->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(":title",$blogs["title"],\PDO::PARAM_STR);
            $stmt->bindValue(":content",$blogs["content"],\PDO::PARAM_STR);
            $stmt->bindValue(":category",$blogs["category"],\PDO::PARAM_INT);
            $stmt->bindValue(":publish_status",$blogs["publish_status"],\PDO::PARAM_INT);
            $stmt->bindValue(":id",$blogs["id"],\PDO::PARAM_INT);
            $stmt->execute();
            $dbh->commit();
            echo "ブログを更新しました!";
        }catch(PDOException $e){
            $dbh->rollBack();
            exit($e);
        }
    }
    



    //ブログのバリデーション
    function blogValidate($blogs){
        if(empty($blogs["title"])){
            exit("タイトルを入力してください。");
        }
    
        if(mb_strlen($blogs["title"]) > 191){
            exit("191文字以下に設定してください。");
        }
    
        if(empty($blogs["content"])){
            exit("本文を入力してください。");
        }
    
        if(empty($blogs["category"])){
            exit("カテゴリーを選んでください。");
        }
    
        if(empty($blogs["publish_status"])){
            exit("公開ステータスは必須です");
        }
    }
}

?>
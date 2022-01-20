<?php
//namespace Blog\Dbc; //最初に適当に宣言,大規模開発でよく使う
require_once("env.php");
class Dbc
{
    protected $table_name = "blog";   //今回はブログとしてのデータ処理。

    // function __construct($table_name){
    //     $this->$table_name = $table_name;     //呼び出し時にtable_nameを初期化したいからコンストラクタへ
    // }
    //1.データベース接続
    //引数:なし
    //返り値:接続結果を返す。
    protected function dbConnect(){    //自クラス内でしか使わないメソッドはprivate
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        
        try{


            $dbh = new \PDO($dsn,$user,$pass,[
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ]);
            
        }catch(PDOException $e){
            echo "接続失敗".$e->getMessage();
            exit();
        
        };

        return $dbh;
    }

    //2.データを取得する
    //引数：なし
    //戻り値:取得したデータを返す。
    public function getAll(){
        $dbh = $this->dbConnect();
        //①SQL文の準備
        $sql = "SELECT * FROM $this->table_name";
        
        //②SQLの実行
        $stmt = $dbh->query($sql);

        //③SQLの結果を受け取る
        $result = $stmt->fetchall(\PDO::FETCH_ASSOC);
        
        return $result;

        $dbh = null;

    }


    

    //引数：$id
    //戻り値：$result

    public function getById($id){
        if(empty($id)){
            exit("IDが不正です。");
        }
        
        
        $dbh = $this->dbConnect();
        
        //SQL準備
        $stmt = $dbh->prepare("SELECT * FROM $this->table_name Where id = :id"); //プレースホルダー(:id)直で入れずに後から入れる
        $stmt->bindValue(":id",(int)$id,\PDO::PARAM_INT);
        //SQL実行
        $stmt->execute();
        //結果取得
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if(!$result){
            exit("ブログがありません。");
        }

        return $result;
    }

    public function delete($id){
        if(empty($id)){
            exit("IDが不正です。");
        }
        
        
        $dbh = $this->dbConnect();
        
        //SQL準備
        $stmt = $dbh->prepare("DELETE FROM $this->table_name Where id = :id"); //プレースホルダー(:id)直で入れずに後から入れる
        $stmt->bindValue(":id",(int)$id,\PDO::PARAM_INT);
        //SQL実行
        $stmt->execute();
        echo "ブログを削除しました";

    }
    
}



?>



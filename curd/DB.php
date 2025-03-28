<?php
   if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class DB
{ 
    private static $connection = null;
    // biến static giúp đảm bảo chỉ có một kết nối duy nhất tới databasedatabase

    const DB_TYPE = "mysql";
    const DB_HOST = "127.0.0.1";
    const DB_NAME = "crud";
    CONST USER_NAME = "root";
    CONST USER_PASSWORD = "123456";
    //các hằng số kết nối

   
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    self::DB_TYPE . ":host=" . self::DB_HOST . ";dbname=" . self::DB_NAME, 
                    self::USER_NAME, 
                    self::USER_PASSWORD
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Lỗi kết nối database: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
    public static function execute($sql, $data = [], $single = false) {
        $statement = self::getConnection()->prepare($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute($data);
        
        return $single ? $statement->fetch() : $statement->fetchAll();
    }

    public static function searchByName($query) {
        $sql = "SELECT * FROM users WHERE name LIKE :query";
        $params = ['query' => "%$query%"];
        return self::execute($sql, $params);
    }
    public static function resetAutoIncrement()
{
    // Lấy ID lớn nhất trong bảng
    $result = self::execute("SELECT MAX(id) as max_id FROM users");
    $maxId = $result[0]['max_id'] ?? 0;

    // Nếu bảng không có bản ghi nào, đặt AUTO_INCREMENT về 1
    $newAutoIncrement = ($maxId > 0) ? ($maxId + 1) : 1;

    // Đặt lại AUTO_INCREMENT
    self::getConnection()->exec("ALTER TABLE users AUTO_INCREMENT = $newAutoIncrement");
}


 }?>

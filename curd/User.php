<?php
include_once __DIR__.'/DB.php';
class User
{
    static public function all()
{
    $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $row = 3; // Số dòng mỗi trang
    $from = ($page - 1) * $row;

    $sql = "SELECT * FROM users ORDER BY id ASC LIMIT $from, $row";
    $users = DB::execute($sql);

    $totalUsers = self::countUsers();
    $totalPages = ceil($totalUsers / $row);

    return [
        'users' => $users,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ];
}

    static public function create($dataCreate) //để chèn cơ sở dữ liệuliệu
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        DB::execute($sql, $dataCreate);
        
    }

    static public function find($id)
    {
        $sql = "select * from users where id=:id";
        $dataFind = ['id' => $id];
        $user = DB::execute($sql, $dataFind);
        return count($user) > 0 ? $user[0] : [];
    } 

    static public function update($dataUpdate){
        $sql = "UPDATE users set name=:name, email=:email, password=:password where id=:id";
        DB::execute($sql,$dataUpdate);
    }
    static public function destroy($id)
{
    $sql = "DELETE FROM users WHERE id = :id;";
    $dataDelete = ['id' => $id]; // Truyền tham số đúng với câu SQL
    DB::execute($sql, $dataDelete);
}
static public function getAllSorted()
{
    $sql = "SELECT * FROM users ORDER BY id ASC"; // ID từ bé đến lớn
    return DB::execute($sql);
}
static public function countUsers()
{
    $sql = "SELECT COUNT(*) as total FROM users";
    $result = DB::execute($sql);
    return $result[0]['total'] ?? 0;
}

public static function resetAutoIncrement()
{
    $db = DB::getConnection();

    // Kiểm tra xem bảng có dữ liệu không
    $result = DB::execute("SELECT MAX(id) as max_id FROM users");
    $maxId = $result[0]['max_id'] ?? 0;

    // Nếu bảng có dữ liệu, sắp xếp lại ID từ 1
    if ($maxId > 0) {
        $db->exec("SET @count = 0;");
        $db->exec("UPDATE users SET id = (@count := @count + 1) ORDER BY id;");
        $db->exec("ALTER TABLE users AUTO_INCREMENT = " . ($maxId + 1));
    } else {
        // Nếu không có dữ liệu, đặt lại AUTO_INCREMENT về 1
        $db->exec("ALTER TABLE users AUTO_INCREMENT = 1");
    }
}

    static public function searchByName($name)
{
    $sql = "SELECT * FROM users WHERE name LIKE :name";
    return DB::execute($sql, ['name' => "%$name%"]);
}
}


<?php

class Query
{
  private $user = 'root';
  private $pass = 'root';
  private $db = 'users';
  private $host = 'localhost';

  public $conn;

  public function __construct()
  {
    try {
      $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

  public function testInput($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
    return $data;
  }

  public function sql_details()
  {
    return array(
      'user' => $this->user,
      'pass' => $this->pass,
      'db'   => $this->db,
      'host' => $this->host
    );
  }

  public function ssdt($table, $pk, $cols)
  {
    require('./libs/ssp.class.php');

    return json_encode(
      SSP::complex($_GET, $this->sql_details(), $table, $pk, $cols)
    );
  }

  public function fetchUsers()
  {
    $sql = "SELECT 
              id,
              name,
              email,
              post,
              created_at
            FROM users
            LEFT JOIN post
              ON post.user_id = users.id";

    $table = "($sql) as temp";

    $pk = 'id';

    $cols = array(
      array('db' => 'id', 'dt' => 0),
      array('db' => 'name',  'dt' => 1),
      array('db' => 'email',   'dt' => 2),
      array(
        'db' => 'created_at',
        'dt' => 3,
        'formatter' => function ($d, $row) {
          return date('M d, Y', strtotime($d));
        }
      ),
      array('db' => 'post',   'dt' => 4),
      array(
        'db' => 'id',
        'dt' => 5,
        'formatter' => function ($d, $row) {
          return <<<EOD
            <a href="#" class="btn btn-primary">View</a>
          EOD;
        }
      ),
    );

    return $this->ssdt($table, $pk, $cols);
  }
}

<?php

require_once 'query.php';

$query = new Query();

if ($_GET['action'] == 'fetchUsers') {
  echo $query->fetchUsers();
}

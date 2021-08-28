<?php
session_start();
class Database
{
  private $dsn = "mysql:host=localhost;charset=utf8;dbname=db02",
    $username = "root",
    $password = "",
    $handler,
    $table;

  private $sql,
    $whereSql,
    $limitSql,
    $orderbySql;


  function __construct($table)
  {
    try {
      $this->handler = new PDO($this->dsn, $this->username, $this->password);
      $this->handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->table = $table;
    } catch (PDOException $e) {
      die("Error:{$e->getMessage()}");
    }
  }

  function fetchAll()
  {
    $this->sql = sprintf(
      "SELECT * FROM `%s` %s %s %s",
      $this->table,
      $this->whereSql ? 'where ' . $this->whereSql : '',
      $this->orderbySql ? 'order by ' . $this->orderbySql : '',
      $this->limitSql ? 'limit ' . $this->limitSql : '',
    );

    $stmt = $this->handler->prepare($this->sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  function fetch()
  {
    $rows = $this->fetchAll();
    return $rows ? $rows[0] : [];
  }

  function create(array $data)
  {
    array_walk($data, function (&$v) {
      $v = sprintf("'%s'", $v);
    });

    $this->sql = sprintf(
      "INSERT INTO `%s` (%s) VALUES(%s)",
      $this->table,
      implode(',', array_keys($data)),
      implode(',', array_values($data))
    );
    $stmt = $this->handler->prepare($this->sql);
    $stmt->execute();
    return $this->handler->lastInsertId();
  }

  function delete()
  {
    $this->sql = sprintf(
      "DELETE FROM `%s` %s",
      $this->table,
      $this->whereSql ? 'where ' . $this->whereSql : ''
    );
    $stmt = $this->handler->prepare($this->sql);
    $stmt->execute();
  }

  function update(array $data)
  {
    array_walk($data, function (&$v, $k) {
      $v = sprintf("`%s`='%s'", $k, $v);
    });

    $this->sql = sprintf(
      "UPDATE `%s` SET %s %s",
      $this->table,
      implode(', ', array_values($data)),
      $this->whereSql ? 'where ' . $this->whereSql : '',
    );
    $stmt = $this->handler->prepare($this->sql);
    $stmt->execute();
  }

  // 條件函式
  // 二維陣列
  function setWhere(array $stats)
  {
    array_walk($stats, function (&$v) {
      $v = sprintf("`%s`%s'%s'", $v[0], $v[1], $v[2]);
    });

    $this->whereSql = implode(' AND ', $stats);
  }

  function setOrderby(array $stat)
  {
    $this->orderbySql = sprintf("%s %s", $stat[0], $stat[1]);
  }

  function setLimit(array $stat)
  {
    $this->limitSql = sprintf("%s,%s", $stat[0], $stat[1]);
  }

  // 特殊函式
  function math(string $math, string $column)
  {
    $this->sql = sprintf(
      "SELECT %s(%s) as result FROM `%s` %s",
      $math,
      $column,
      $this->table,
      $this->whereSql ? 'where ' . $this->whereSql : ''
    );
    $stmt = $this->handler->prepare($this->sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row['result'];
  }

  // 自訂查詢
  function customQuery($sql)
  {
    $stmt = $this->handler->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

function dd($var)
{
  die(sprintf("<pre>%s</pre>", var_export($var, true)));
}

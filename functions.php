<?php
function sql(
  string $command,
  ?string $query = null, // SQL query or file name
  ?array $parameter = null // Parameters for the query
) { // BEGIN function mysql
  global $c, $mysqlSession;
  $preparedQuery = @file_get_contents(__DIR__ . '/sql/' . ($query ?? DB_QUERY_SEARCH_QUESTION));
  switch ($command) { //Fall unterscheidung
    case "connect":
      $mysqlSession = mysqli_connect(
        hostname: $c['host'],
        username: $c['user'],
        password: $c['password'],
        database: $c['database'],
        port: 3306,
      );
      if (null === $mysqlSession) {
        die("Keine Verbindung zum MySQL Server oder Zugangsdaten falsch.");
      }
      mysqli_set_charset($mysqlSession, "utf8");
      break;


    case "query":
      list($query, $types, $values) = prepare_named_query($preparedQuery, $parameter);
      $stmt = mysqli_prepare($mysqlSession, $query);
      if ($types) {
        mysqli_stmt_bind_param($stmt, $types, ...$values);
      }
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_object($result);
      } else {
        return mysqli_fetch_array($result);
      }
      // break;


    case "table":
      list($query, $types, $values) = prepare_named_query($preparedQuery, $parameter);
      $stmt = mysqli_prepare($mysqlSession, $query);
      if ($types) {
        mysqli_stmt_bind_param($stmt, $types, ...$values);
      }
      if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        //echo $abfrage."<br>\n";
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
      } else {
        return [];
      }
      // break;
    case "save":
      list($query, $types, $values) = prepare_named_query($preparedQuery, $parameter);
      $stmt = mysqli_prepare($mysqlSession, $query);
      if ($types) {
        mysqli_stmt_bind_param($stmt, $types, ...$values);
      }
      return mysqli_stmt_execute($stmt);
      // break;  
    case "insert":
      list($query, $types, $values) = prepare_named_query($preparedQuery, $parameter);
      $stmt = mysqli_prepare($mysqlSession, $query);
      if ($types) {
        mysqli_stmt_bind_param($stmt, $types, ...$values);
      }
      if (mysqli_stmt_execute($stmt)) {
        return mysqli_insert_id($mysqlSession);
      }
      // break;  
    default:
      break;
  }
} // END function mysql

/**
 * Builds the site by replacing placeholders in a template file with actual content.
 * @param string $file The path to the template file.
 * @param array $replace An associative array where keys are placeholders and values are the content to replace them with.
 */
function build_site($file, $replace)
{ // BEGIN function build_site
  $file = file_get_contents("./templates/" . $file);
  echo str_replace(
    array_keys($replace),
    array_values($replace),
    $file
  );
} // END function build_site
function prepare_named_query($sql, $params)
{
  preg_match_all('/:(\w+)/', $sql, $matches);
  $ordered_values = [];
  $types = '';
  foreach ($matches[1] as $name) {
    $value = $params[$name];
    $ordered_values[] = $value;
    $types .= is_int($value) ? 'i' : 's';
  }
  $sql = preg_replace('/:\w+/', '?', $sql);
  return [$sql, $types, $ordered_values];
}

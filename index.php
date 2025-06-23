<?php
//header('Content-Type: text/html; charset=UTF-8');
include 'config.php';
include './functions.php';
include './prepare.php';
$idChain = filter_input(INPUT_GET, 'idChain', FILTER_VALIDATE_REGEXP, [
  "options" => [
    "default" => '0',
    "regexp" => "/^\d+(?:-\d+)*$/"
  ]
]);

$ids = explode('-', $idChain);
$id = end($ids);

if ($idChain === '0') {
  $result = sql("query", DB_QUERY_SEARCH_QUESTION, ['id' => 0]);
  $replace = [
    "{Order}" => '',
    "{id}" => $result->id,
    "{Titel}" => $result->antwort,
    "{Frage}" => $result->frage,
    "{Text}" => $result->text
  ];
  $ids = [0];
  $id = 0;
}
//Breadcrumbs
$breadcrumbs = [];
foreach ($ids as $key => $value) {
  $result = sql("query", DB_QUERY_SEARCH_QUESTION, ['id' => $value]);
  $link = implode('-', array_slice($ids, 0, $key + 1));
  $breadcrumbs[] = "<a href=\"index.php?idChain=" . $link . "\">" . $result->antwort . "</a>";
}
$breadcrumbs = implode('<span class="sep">›</span>', $breadcrumbs);

$result = sql("query", DB_QUERY_SEARCH_QUESTION, ['id' => $ids[(count($ids) - 1)]]);
$replace["{Order}"] = $breadcrumbs;
$replace["{id}"] = $id = $result->id;
$replace["{Titel}"] = $result->antwort;
$replace["{Frage}"] = $result->frage;
$replace["{Text}"] = nl2br($result->text);


if (isset($ids) or is_numeric($result->id)) {
  $antworten = '';
  $result = sql("table", DB_QUERY_ANSWERS,  ['id' => $ids[(count($ids) - 1)]]);
  foreach ($result as $row) {
    $antworten .= "<li><a href=\"index.php?idChain=" . $idChain . "-" . $row["id"] . "\">" . htmlentities($row["antwort"]) . "</a></li>\n";
  }
  $antworten .= "<li><a href=\"edit.php?id=&idChain=" . $idChain . "\">&#x270D;</a></li>\n";
  $replace["{Antworten}"] = $antworten;
}
$replace["{idChain}"] = $idChain;
build_site("index.html", $replace);

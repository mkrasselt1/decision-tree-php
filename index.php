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
$sw = (int)($result->schwierigkeit ?? 0);
$swPageLabels = [
  1 => ['Ein Handgriff &ndash; Das kann jeder selbst erledigen', '#e8f5e9', '#2e7d32'],
  2 => ['Einfach &ndash; Selbst l&ouml;sbar mit etwas Aufwand', '#f1f8e9', '#558b2f'],
  3 => ['Mittel &ndash; Erfahrung hilfreich, ggf. Techniker', '#fff3e0', '#e65100'],
  4 => ['Schwierig &ndash; Techniker empfohlen', '#fbe9e7', '#bf360c'],
  5 => ['Techniker erforderlich', '#fce4ec', '#c62828'],
];
$replace["{Schwierigkeit}"] = isset($swPageLabels[$sw])
  ? '<div style="margin:1em 0;padding:0.6em 1em;border-radius:var(--radius);background:'
    . $swPageLabels[$sw][1] . ';color:' . $swPageLabels[$sw][2]
    . ';font-weight:500;">' . $swPageLabels[$sw][0] . '</div>'
  : '';

if (isset($ids) or is_numeric($result->id)) {
  $antworten = '';
  $result = sql("table", DB_QUERY_ANSWERS,  ['id' => $ids[(count($ids) - 1)]]);
  foreach ($result as $row) {
    $sw = (int)($row["schwierigkeit"] ?? 0);
    $swLabels = [0 => '', 1 => '1-Handgriff', 2 => '2-Einfach', 3 => '3-Mittel', 4 => '4-Schwierig', 5 => '5-Techniker'];
    $swColors = [0 => '', 1 => '#4caf50', 2 => '#8bc34a', 3 => '#ff9800', 4 => '#f44336', 5 => '#9c27b0'];
    $swBadge = $sw > 0 ? ' <span style="font-size:0.75em;background:' . $swColors[$sw] . ';color:#fff;padding:0.15em 0.5em;border-radius:8px;margin-left:0.5em;vertical-align:middle;">' . $swLabels[$sw] . '</span>' : '';
    $antworten .= "<li><a href=\"index.php?idChain=" . $idChain . "-" . $row["id"] . "\">" . htmlentities($row["antwort"]) . $swBadge . "</a></li>\n";
  }
  $antworten .= "<li><a href=\"edit.php?id=&idChain=" . $idChain . "\">&#x270D;</a></li>\n";
  $replace["{Antworten}"] = $antworten;
}
$replace["{idChain}"] = $idChain;
build_site("index.html", $replace);

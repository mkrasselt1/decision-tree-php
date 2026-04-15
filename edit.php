<?php
include 'config.php';
include 'functions.php';
include 'prepare.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
	"options" => ["default" => null, "min_range" => 0, "max_range" => 9999999999]
]);
$idChain = filter_input(INPUT_GET, 'idChain', FILTER_VALIDATE_REGEXP, [
	"options" => ["default" => '0', "regexp" => "/^\d+(-\d+)*$/"]
]);

$fields = ['text', 'titel', 'frage'];
foreach ($fields as $field) {
	$$field = filter_input(INPUT_POST, $field, FILTER_UNSAFE_RAW, [
		"options" => ["default" => null]
	]);
}
$schwierigkeit = filter_input(INPUT_POST, 'schwierigkeit', FILTER_VALIDATE_INT, [
	"options" => ["default" => 0, "min_range" => 0, "max_range" => 5]
]);

$replace = array_fill_keys(
	['{id}', '{Titel}', '{Frage}', '{Text}', '{lastid}',
	 '{sel0}', '{sel1}', '{sel2}', '{sel3}', '{sel4}', '{sel5}'],
	''
);
$replace["{idChain}"] = $idChain;
if (isset($_POST["save"])) {
	if (!is_null($id)) {
		if (sql("save", DB_QUERY_UPDATE_TEXT, [
			"id" => $id,
			'titel' => $titel,
			'frage' => $frage,
			'text' => $text,
			'schwierigkeit' => $schwierigkeit
		])) {
			header("Location: index.php?idChain=" . $idChain);
			exit;
		}
	} else {
		$id = sql(
			"insert",
			DB_QUERY_INSERT_TEXT,
			[
				'id' => null,
				'titel' => $titel,
				'frage' => $frage,
				'text' => $text,
				'schwierigkeit' => $schwierigkeit
			]
		);
		$ids = explode("-", $idChain);
		$lastId = end($ids);
		reset($ids);
		if ($id) {
			sql("insert", DB_QUERY_INSERT_RELATION, [
				'id' => $id,
				'lastid' => $lastId
			]);
			header("Location: index.php?idChain=" . $idChain);
			exit;
		}
	}
}
if ($id !== null) {
	$result = sql("query", DB_QUERY_SEARCH_QUESTION, ['id' => $id]);
	$replace["{id}"] = $result->id;
	$replace["{Titel}"] = $result->antwort;
	$replace["{Frage}"] = $result->frage;
	$replace["{Text}"] = $result->text;
	$replace["{eid}"] = $result->id;
	$sw = (int)($result->schwierigkeit ?? 0);
	$replace["{sel$sw}"] = 'selected';
}
$replace["{id}"] = $id;
$search["{idChain}"] = $idChain;

build_site("edit.html", $replace);

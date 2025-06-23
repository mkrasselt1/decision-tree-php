<?php
include 'config.php';
include 'functions.php';
include 'prepare.php';

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ["options" => ["default" => null, "min_range" => 0, "max_range" => 9999999999]]);
$text = filter_input(INPUT_POST, 'text', FILTER_UNSAFE_RAW, ["options" => ["default" => null]]);
$titel = filter_input(INPUT_POST, 'titel', FILTER_UNSAFE_RAW, ["options" => ["default" => null]]);
$frage = filter_input(INPUT_POST, 'frage', FILTER_UNSAFE_RAW, ["options" => ["default" => null]]);
$idChain = filter_input(INPUT_GET, 'idChain', FILTER_VALIDATE_REGEXP, ["options" => ["default" => '0', "regexp" => "/^\d+(-{1}\d+)*$/"]]);
$replace["{id}"] = $replace["{Titel}"] = $replace["{Frage}"] = $replace["{Text}"] = $replace["{lastid}"] = '';
$replace["{idChain}"] = $idChain;
if (isset($_POST["save"])) {
	if (!is_null($id)) {
		if (sql("save", DB_QUERY_UPDATE_TEXT, [
			"id" => $id,
			'titel' => $titel,
			'frage' => $frage,
			'text' => $text
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
				'text' => $text
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
if ($id) {
	$result = sql("query", DB_QUERY_SEARCH_QUESTION, ['id' => $id]);
	$replace["{id}"] = $result->id;
	$replace["{Titel}"] = $result->antwort;
	$replace["{Frage}"] = $result->frage;
	$replace["{Text}"] = $result->text;
	$replace["{eid}"] = $result->id;
}
$replace["{id}"] = $id;
$search["{idChain}"] = $idChain;

build_site("edit.html", $replace);

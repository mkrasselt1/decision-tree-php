<?php
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(-1);
// Konfiguration für die Datenbankverbindung und Skripte
// Datenbank-Konfiguration aus externer Datei laden
$c = require __DIR__ . '/dbconfig.php';

const DB_QUERY_START_RESULTS = 'start_results_query.sql';
const DB_QUERY_SEARCH_QUESTION = 'search_question_query.sql';
const DB_QUERY_ANSWERS 	= 'answers_query.sql';
const DB_QUERY_UPDATE_TEXT 	= 'update_text.sql';
const DB_QUERY_INSERT_TEXT 	= 'insert_text.sql';
const DB_QUERY_INSERT_RELATION 	= 'insert_relation.sql';
const DB_QUERY_UPPER_ID 	= 'upper_id_query.sql';
const DB_QUERY_INITIAL_TEXT = 'initial_text.sql';

/**
 * @var mysqli|null $mysqlSession
 */
$mysqlSession = null;

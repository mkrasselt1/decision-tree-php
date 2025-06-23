UPDATE
    `texte`
SET
    `antwort` = :titel,
    `frage` = :frage,
    `text` = :text
WHERE
    `texte`.`id` = :id;
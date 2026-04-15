UPDATE
    `texte`
SET
    `antwort` = :titel,
    `frage` = :frage,
    `text` = :text,
    `schwierigkeit` = :schwierigkeit
WHERE
    `texte`.`id` = :id;
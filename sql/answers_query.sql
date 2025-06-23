SELECT
    p.*
FROM
    `texte` t
    INNER JOIN relation r ON t.id = r.upperid
    INNER JOIN texte p ON r.lowerid = p.id
WHERE
    t.id = :id
ORDER BY
    `p`.`answer` ASC
SELECT
    upperid
FROM
    `relation` t
WHERE
    lowerid = :id
LIMIT
    0 1
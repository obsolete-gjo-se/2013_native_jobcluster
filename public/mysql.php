<?php
    $title = 'Testaufgabe 1 - MySQL';
    require_once '../application/bootstrap.php';
    require_once '../application/includes/header.php';
    require_once '../application/includes/navigation.php';
?>

<ol>
    <li>A</li>
    <ol>
        <li>Projekt anlegen</li>
        <li>Ordnerstruktur schaffen</li>
        <li>xls zusätzliche Spalte "id" einfügen, ohne Inhalte</li>
        <li>.xls als .csv speichern</li>
        <li>CLI bzw. mySQL-Workbench</li>
        <ol>
            <li>CREATE SCHEMA jobcluster;</li>
            <li>USE jobcluster;</li>
            <li><pre>CREATE TABLE `hits` (
            `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
            `job_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Anzahl Hits',
            `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            PRIMARY KEY (`id`)
           ) ENGINE=InnoDB DEFAULT CHARSET=utf8;</pre></li>
            <li><pre>LOAD DATA INFILE
               'path/to/hits.csv'
               INTO TABLE hits
               FIELDS TERMINATED BY ';'
               LINES TERMINATED BY '\r\n'
               IGNORE 1 LINES;</pre></li>
        </ol>
    </ol>
    <li>B</li>
    <ol>
        <li><pre>SELECT date_format(`date_time`, '%Y-%m-%d') AS Date, SUM(job_id) AS Hits
    FROM hits
    GROUP BY date_format(`date_time`, '%Y-%m-%d')
    ORDER BY date_format(`date_time`, '%Y-%m-%d');</pre></li>
    </ol>

</ol>

<?php require_once '../application/includes/footer.php';?>

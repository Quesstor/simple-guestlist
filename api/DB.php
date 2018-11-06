<?php
class DB
{
    /** @return PDO */
    public static function openNewPDO(){
        $settings = (object) $GLOBALS["settings"]["DB"];
        // die($settings->db);
        return new PDO("mysql:host=$settings->url;dbname=$settings->db;charset=utf8", $settings->name, $settings->pw, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
    }
    /** @return PDO */
    private static function pdo()
    {
        if (!isset($GLOBALS["DBPDO"])) {$GLOBALS["DBPDO"] = DB::openNewPDO();}
        return $GLOBALS["DBPDO"];
    }
    /** @return PDOStatement */
    public static function query(string $statement, array $params = null)
    {
        try {
            $stmt = DB::pdo()->prepare($statement);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Logger::error("Query failed: " . $e->getMessage() . "\nStatement: \t$statement\nParams: \t" . print_r($params, true), $e);
            http_response_code(500);
            throw $e;
        }
    }
    /** @return bool */
    public static function beginTransaction()
    {
        return DB::pdo()->beginTransaction();
    }
    /** @return bool */
    public static function commit()
    {
        return DB::pdo()->commit();
    }
    /** @return string */
    public static function get_last_insert_id()
    {
        return DB::pdo()->lastInsertId();
    }
    public static function fetch_all(string $statement, array $params = null)
    {
        $r = DB::query($statement, $params);
        $list = array();
        while ($row = $r->fetch()) {
            array_push($list, $row);
        }
        return $list;
    }
    public static function fetch_all_dict(string $key, string $statement, array $params = null)
    {
        $r = DB::query($statement, $params);
        $dict = array();
        while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
            $dict[$row[$key]] = (object) $row;
        }

        return $dict;
    }

    public static function fetch_1D_list(string $key, string $statement, array $params = null)
    {
        $r = DB::query($statement, $params);
        $list = array();
        while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
            array_push($list, $row[$key]);
        }

        return $list;
    }
    public static function fetch(string $statement, array $params = null)
    {
        $r = DB::query($statement, $params);
        return $r->fetch();
    }

    public static function clean($string, $type = null)
    {
        if ($string === null) {
            return null;
        }

        if ($type == "Decimal" || $type == "Money") {
            $string = str_replace(",", ".", $string);
        }

        if ($type == "Date") {
            $string = date("Y-m-d", strtotime($string));
        }

        $string = trim($string);
        $string = htmlentities($string); //Escape XSS
        $specialChars = DB::specialChars();
        $string = str_replace($specialChars->html, $specialChars->chars, $string); //Get Umlaute back from htmlentities

        if ($type == "Money") {
            $string = (double) $string;
            $string = 100 * $string;
            $string = (int) $string;
        }
        return $string;
    }
    public static function specialChars()
    {
        return (object) [
            "chars" => array("ü", "Ü", "ö", "Ö", "ä", "Ä", "ß", "€", "ò", "ó", "í", "î", '"', "â", "ô", "ú", "ù", "û", "à", "á", "ñ", "&"),
            "html" => array("&uuml;", "&Uuml;", "&ouml;", "&Ouml;", "&auml;", "&Auml;",
                "&szlig;", "&euro;", "&ograve;", "&oacute;", "&iacute;",
                "&icirc;", "&quot;", "&acirc;", "&ocirc;", "&uacute;",
                "&ugrave;", "&ucirc;", "&agrave;", "&aacute;", "&ntilde;", "&amp;"),
        ];
    }
}

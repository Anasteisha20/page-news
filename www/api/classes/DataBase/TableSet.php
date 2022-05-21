<?
namespace Api\classes\DataBase;
use PDO;

class TableSet
{
    public $pdo, $sortTable, $count;
    public static $table;

    function __construct()
    {
        try {
            $pdo = new PDO('mysql:dbname=page_news;host=localhost;port=3307', 'root', 'root');
            $this->pdo = $pdo;
            return  $pdo;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function selectAllDB()
    {
        $query = $this->pdo -> prepare('SELECT * FROM news');
//        $query = $this->pdo -> prepare('SELECT * FROM news ORDER BY idate DESC'); //второй способ сортировки через SQL-запрос
        $query->execute();
        $table = [];
        $tableId = [];
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

            $table[$row["id"]] =
                [
                    "ID" => $row["id"],
                    "DATE" => gmdate("d.m.Y", $row["idate"]),
                    "NAME" => $row["title"],
                    "PREVIEW_TEXT" => $row["announce"],
                    "DETAIL_TEXT" => $row["content"]
                ];
            $tableId[$row["id"]] = $row["idate"];
        }
        $this->sortDB($tableId, $table);
        $this->countPage($table);

        $arResult['COUNT_PAGES'] = $this->count;
        $arResult['ITEMS'] = $this->sortTable;
        self::$table = $this->sortTable;

        return $arResult;
    }

    private function sortDB($tableId, $table)
    {
        arsort($tableId);
        foreach ($tableId as $keyId => $value) {
            $this->sortTable[$keyId] = $table[$keyId];
        }
        return $this->sortTable;
    }

    private function countPage($table)
    {
        $this->count = ceil(count ($table) /5);
        return $this->count;
    }

    public static function navPages($numberPage)
    {
        return array_slice(self::$table, ($numberPage-1) * 5, 5,true);
    }

    public function detailNews($id)
    {
        $query = $this->pdo -> prepare('SELECT title, content FROM news WHERE id = :code');
        $query->execute(['code' => $id]);

        if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            return $row;
        }
    }

}

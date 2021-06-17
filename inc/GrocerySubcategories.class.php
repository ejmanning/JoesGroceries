<?php
class GrocerySubcategories
{
    var $subcategoryData = array();
    var $errors = array();

    var $db = null;

    function __construct()
     {
       //local
       /*$this->db = new PDO('mysql:host=localhost;dbname=JoesGroceries;charset=utf8',
           'erica', 'Frozen21!');*/
       //host
       $this->db = new PDO('mysql:host=localhost;dbname=emanning11_joesgroceries;charset=utf8',
           'emanning11_joesgroceries', 'Frozen21!');
     }

    function set($dataArray)
    {
        $this->subcategoryData = $dataArray;
    }

    function sanitize($dataArray)
    {
        // sanitize data based on rules
        $dataArray['subcategoryName'] = filter_var($dataArray['subcategoryName'], FILTER_SANITIZE_STRING);
        $dataArray['categoryID'] = filter_var($dataArray['categoryID'], FILTER_SANITIZE_NUMBER_INT);

        return $dataArray;
    }

    function load($subcategoryID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM grocerySubcategories WHERE subcategoryID=?");
        $stmt->execute(array($subcategoryID));

        if ($stmt->rowCount() == 1)
        {
            $dataArray = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($dataArray);
            $this->set($dataArray);

            $isLoaded = true;
        }

        //var_dump($stmt->rowCount());

        return $isLoaded;
    }

    function loadByCategory($categoryID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM grocerySubcategories WHERE categoryID=?");
        $stmt->execute(array($categoryID));

        if ($stmt->rowCount() == 1)
        {
            $dataArray = $stmt->fetch(PDO::FETCH_ASSOC);
            //var_dump($dataArray);
            $this->set($dataArray);

            $isLoaded = true;
        }

        //var_dump($stmt->rowCount());

        return $isLoaded;
    }

    function save()
    {
        $isSaved = false;

        // determine if insert or update based on articleID
        // save data from articleData property to database
        if (empty($this->subcategoryData['subcategoryID']))
        {

            $stmt = $this->db->prepare(
                "INSERT INTO grocerySubcategories
                    (subcategoryName, categoryID)
                 VALUES (?, ?)");

            $isSaved = $stmt->execute(array(
                    $this->subcategoryData['subcategoryName'],
                    $this->subcategoryData['categoryID']
                )
            );

            if ($isSaved)
            {
                $this->subcategoryData['subcategoryID'] = $this->db->lastInsertId();
            }
        }
        else
        {
            $stmt = $this->db->prepare(
                "UPDATE grocerySubcategories SET
                    subcategoryName = ?,
                    categoryID = ?,
                WHERE subcategoryID = ?"
            );

            $isSaved = $stmt->execute(array(
                    $this->subcategoryData['subcategoryName'],
                    $this->subcategoryData['categoryID'],
                    $this->subcategoryData['subcategoryID']
                )
            );
        }

        return $isSaved;
    }

    function validate()
    {
        $isValid = true;

        // if an error, store to errors using column name as key

        // validate the data elements in articleData property
        if (empty($this->subcategoryData['subcategoryName']))
        {
            $this->errors['subcategoryName'] = "Please enter a name for the subcategory";
            $isValid = false;
        }

        if (empty($this->subcategoryData['categoryID']))
        {
            $this->errors['categoryID'] = "Please enter a category for the subcategory";
            $isValid = false;
        }

        return $isValid;
    }

    function getList($sortColumn = null, $sortDirection = null, $filterColumn = null, $filterText = null, $page = null)
    {
        $subcategoryList = array();

        $sql = "SELECT * FROM grocerySubcategories ";

        if (!is_null($filterColumn) && !is_null($filterText))
        {
            $sql .= " WHERE " . $filterColumn . " = " . $filterText;
        }

        if (!is_null($sortColumn))
        {
            $sql .= " ORDER BY " . $sortColumn;

            if (!is_null($sortDirection))
            {
                $sql .= " " . $sortDirection;
            }
        }

        // setup paging if passed
    		if (!is_null($page)) {
          //var_dump($page);
    			$sql .= " LIMIT " . ((2 * $page) - 2) . ",2";
          //var_dump($sql);
          $total_pages_sql = "SELECT COUNT(*) FROM grocerySubcategories";
          $stmtPages = $this->db->prepare($total_pages_sql);
          $numberOfRows = $this->db->query($total_pages_sql)->fetchColumn();
          $numberOfRows = (int)$numberOfRows;
          $numberOfPages = $numberOfRows/2;
    		}

        $stmt = $this->db->prepare($sql);

        if ($stmt)
        {
            $stmt->execute(array('%' . $filterText . '%'));
            //var_dump($filterText);
            $subcategoryList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($stmt);


        return $subcategoryList;
    }

  }

?>

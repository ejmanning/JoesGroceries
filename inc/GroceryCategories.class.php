<?php
class GroceryCategories
{
    var $categoryData = array();
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
        $this->categoryData = $dataArray;
    }

    function sanitize($dataArray)
    {
        // sanitize data based on rules
        $dataArray['categoryName'] = filter_var($dataArray['categoryName'], FILTER_SANITIZE_STRING);

        return $dataArray;
    }

    function load($categoryID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM groceryCategories WHERE categoryID=?");
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
        if (empty($this->categoryData['categoryID']))
        {

            $stmt = $this->db->prepare(
                "INSERT INTO groceryCategories
                    (categoryName)
                 VALUES (?)");

            $isSaved = $stmt->execute(array(
                    $this->categoryData['categoryName']
                )
            );

            if ($isSaved)
            {
                $this->categoryData['categoryID'] = $this->db->lastInsertId();
            }
        }
        else
        {
            $stmt = $this->db->prepare(
                "UPDATE groceryCategories SET
                    categoryName = ?
                WHERE categoryID = ?"
            );

            $isSaved = $stmt->execute(array(
                    $this->categoryData['categoryName'],
                    $this->categoryData['categoryID']
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
        if (empty($this->categoryData['categoryName']))
        {
            $this->errors['categoryName'] = "Please enter a name for the category";
            $isValid = false;
        }

        return $isValid;
    }

    function getList($sortColumn = null, $sortDirection = null, $filterColumn = null, $filterText = null, $page = null)
    {
        $categoryList = array();

        $sql = "SELECT * FROM groceryCategories ";

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
          $total_pages_sql = "SELECT COUNT(*) FROM groceryCategories";
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
            $categoryList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($stmt);


        return $categoryList;
    }

  }

?>

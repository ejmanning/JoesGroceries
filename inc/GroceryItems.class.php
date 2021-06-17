<?php
class GroceryItems
{
    var $itemData = array();
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
        $this->itemData = $dataArray;
    }

    function sanitize($dataArray)
    {
        // sanitize data based on rules
        $dataArray['itemName'] = filter_var($dataArray['itemName'], FILTER_SANITIZE_STRING);
        $dataArray['subcategoryID'] = filter_var($dataArray['subcategoryID'], FILTER_SANITIZE_NUMBER_INT);

        return $dataArray;
    }

    function load($itemID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM groceryItems WHERE itemID=?");
        $stmt->execute(array($itemID));

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

    function loadBySubcategory($subcategoryID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM groceryItems WHERE subcategoryID=?");
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

    function save()
    {
        $isSaved = false;

        // determine if insert or update based on articleID
        // save data from articleData property to database
        if (empty($this->itemData['itemID']))
        {

            $stmt = $this->db->prepare(
                "INSERT INTO groceryItems
                    (itemName, subcategoryID)
                 VALUES (?, ?)");

            $isSaved = $stmt->execute(array(
                    $this->itemData['itemName'],
                    $this->itemData['subcategoryID']
                )
            );

            if ($isSaved)
            {
                $this->itemData['itemID'] = $this->db->lastInsertId();
            }
        }
        else
        {
            $stmt = $this->db->prepare(
                "UPDATE groceryItems SET
                    itemName = ?,
                    subcategoryID = ?,
                WHERE itemID = ?"
            );

            $isSaved = $stmt->execute(array(
                    $this->itemData['itemName'],
                    $this->itemData['subcategoryID'],
                    $this->itemData['itemID']
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
        if (empty($this->itemData['itemName']))
        {
            $this->errors['itemName'] = "Please enter a name for the item";
            $isValid = false;
        }

        if (empty($this->itemData['subcategoryID']))
        {
            $this->errors['subcategoryID'] = "Please enter a subcategory for the item";
            $isValid = false;
        }

        return $isValid;
    }

    function getList($sortColumn = null, $sortDirection = null, $filterColumn = null, $filterText = null, $page = null)
    {
        $itemList = array();

        $sql = "SELECT * FROM groceryItems ";

        if (!is_null($filterColumn) && !is_null($filterText))
        {
          //var_dump($filterText);
            $sql .= " WHERE " . $filterColumn . " LIKE ?";
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
          $total_pages_sql = "SELECT COUNT(*) FROM groceryItems";
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
            $itemList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($stmt);


        return $itemList;
    }

    function getListArray($sortColumn = null, $sortDirection = null, $filterColumn = null, $filterText = null, $page = null)
    {
        $itemList = array();

        $sql = "SELECT * FROM groceryItems ";

        if (!is_null($filterColumn) && !is_null($filterText))
        {

            //var_dump($filterText[0]);
            $arrayGoThrough = count($filterText) - 1;
            $sql .= " WHERE ";
            for ($x = 0; $x <= $arrayGoThrough; $x++) {
              $sql .= $filterColumn . " = " . $filterText[$x];
              if($x!=$arrayGoThrough) {
                $sql .= " OR ";
              }
            }
            //var_dump($sql);
            //$sql .= " WHERE " . $filterColumn . " LIKE ?";
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
          $total_pages_sql = "SELECT COUNT(*) FROM groceryItems";
          $stmtPages = $this->db->prepare($total_pages_sql);
          $numberOfRows = $this->db->query($total_pages_sql)->fetchColumn();
          $numberOfRows = (int)$numberOfRows;
          $numberOfPages = $numberOfRows/2;
    		}

        $stmt = $this->db->prepare($sql);
        //var_dump($stmt);

        if ($stmt)
        {
            $stmt->execute(array());
            //var_dump($filterText);
            $itemList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($stmt);


        return $itemList;
    }

  }

?>

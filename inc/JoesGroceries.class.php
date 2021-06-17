<?php
class JoesGroceries
{
    var $joesGroceryItemsData = array();
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
        $this->joesGroceryItemsData = $dataArray;
    }

    function sanitize($dataArray)
    {
        // sanitize data based on rules
        $dataArray['itemID'] = filter_var($dataArray['itemID'], FILTER_SANITIZE_STRING);
        $dataArray['itemQuantity'] = filter_var($dataArray['itemQuantity'], FILTER_SANITIZE_STRING);
        $dataArray['itemMeasurement'] = filter_var($dataArray['itemMeasurement'], FILTER_SANITIZE_STRING);
        $dataArray['listID'] = filter_var($dataArray['listID'], FILTER_SANITIZE_NUMBER_INT);

        return $dataArray;
    }

    function load($itemID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM joesGroceries WHERE itemID = ?");
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

    function loadByList($listID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM joesGroceries WHERE listID = ?");
        $stmt->execute(array($listID));

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

    function loadByListCheckedStatus($listID, $checkedStatus)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM joesGroceries WHERE listID=? AND checked = ?");
        $stmt->execute(array($listID, $checkedStatus));

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
        if (empty($this->joesGroceryItemsData['itemID']))
        {

            $stmt = $this->db->prepare(
                "INSERT INTO joesGroceries
                    (itemID, itemQuantity, itemMeasurement, checked, listID)
                 VALUES (?, ?, ?, ?, ?)");

            $isSaved = $stmt->execute(array(
                    $this->joesGroceryItemsData['itemID'],
                    $this->joesGroceryItemsData['itemQuantity'],
                    $this->joesGroceryItemsData['itemMeasurement'],
                    $this->joesGroceryItemsData['checked'],
                    $this->joesGroceryItemsData['listID']

                )
            );

            if ($isSaved)
            {
                $this->joesGroceryItemsData['listID'] = $this->db->lastInsertId();
            }
        }
        else
        {
            $stmt = $this->db->prepare(
                "UPDATE joesGroceries SET
                    itemQuantity = ?,
                    itemMeasurement = ?,
                    checked = ?,
                    listID = ?
                WHERE itemID = ?"
            );

            $isSaved = $stmt->execute(array(
                    $this->joesGroceryItemsData['itemQuantity'],
                    $this->joesGroceryItemsData['itemMeasurement'],
                    $this->joesGroceryItemsData['checked'],
                    $this->joesGroceryItemsData['listID'],
                    $this->joesGroceryItemsData['itemID']
                )
            );
        }

        return $isSaved;
    }

    function saveToGroceryList()
    {
        $isSaved = false;

        // determine if insert or update based on articleID
        // save data from articleData property to database


            $stmt = $this->db->prepare(
                "INSERT INTO joesGroceries
                    (itemID, itemQuantity, itemMeasurement, checked, listID)
                 VALUES (?, ?, ?, ?, ?)");

            $isSaved = $stmt->execute(array(
                    $this->joesGroceryItemsData['itemID'],
                    $this->joesGroceryItemsData['itemQuantity'],
                    $this->joesGroceryItemsData['itemMeasurement'],
                    $this->joesGroceryItemsData['checked'],
                    $this->joesGroceryItemsData['listID']

                )
            );

            if ($isSaved)
            {
                $this->joesGroceryItemsData['listID'] = $this->db->lastInsertId();
            }

        return $isSaved;
    }

    function validate()
    {
        $isValid = true;

        // if an error, store to errors using column name as key

        // validate the data elements in articleData property
        if (empty($this->joesGroceryItemsData['itemID']))
        {
            $this->errors['itemID'] = "Please enter a name/ID for the item you are adding to your list";
            $isValid = false;
        }

        if (empty($this->joesGroceryItemsData['itemQuantity']))
        {
            $this->errors['itemQuantity'] = "Please enter the quantity";
            $isValid = false;
        }

        if (empty($this->joesGroceryItemsData['itemMeasurement']))
        {
            $this->errors['itemMeasurement'] = "Please enter the measurement";
            $isValid = false;
        }

        return $isValid;
    }

    function getList($sortColumn = null, $sortDirection = null, $filterColumn = null, $filterText = null, $page = null)
    {
        $joesGroceryList = array();

        $sql = "SELECT * FROM joesGroceries ";

        if (!is_null($filterColumn) && !is_null($filterText))
        {
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
          $total_pages_sql = "SELECT COUNT(*) FROM joesGroceries";
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
            $joesGroceryList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($stmt);


        return $joesGroceryList;
    }

    function getListArray($sortColumn = null, $sortDirection = null, $filterColumn = null, $filterText = null, $page = null)
    {
        $itemList = array();

        $sql = "SELECT * FROM joesGroceries ";

        if (!is_null($filterColumn) && !is_null($filterText))
        {

            //var_dump($filterText[1]);
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
            $joesGroceryList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($stmt);


        return $joesGroceryList;
    }

  }

?>

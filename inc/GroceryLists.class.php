<?php
class GroceryLists
{
    var $listData = array();
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
        $this->listData = $dataArray;
    }

    function sanitize($dataArray)
    {
        // sanitize data based on rules
        $dataArray['listDate'] = filter_var($dataArray['listDate'], FILTER_SANITIZE_STRING);
        $dataArray['status'] = filter_var($dataArray['status'], FILTER_SANITIZE_STRING);

        return $dataArray;
    }

    function load($listID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM groceryLists WHERE listID=?");
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

    function loadAllByUser($userID)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM groceryLists WHERE userID=?");
        $stmt->execute(array($userID));

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

    function loadByStatusForUser($userID, $status)
    {
        $isLoaded = false;

        // load from database
        $stmt = $this->db->prepare("SELECT * FROM groceryLists WHERE userID=? AND status=?");
        $stmt->execute(array($userID, $status));

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
        if (empty($this->listData['listID']))
        {

            $stmt = $this->db->prepare(
                "INSERT INTO groceryLists
                    (listDate, status, userID)
                 VALUES (?, ?, ?)");

            $isSaved = $stmt->execute(array(
                    $this->listData['listDate'],
                    $this->listData['status'],
                    $this->listData['userID']
                )
            );

            if ($isSaved)
            {
                $this->listData['listID'] = $this->db->lastInsertId();
            }
        }
        else
        {
            $stmt = $this->db->prepare(
                "UPDATE groceryLists SET
                    listDate = ?,
                    status = ?,
                    userID = ?
                WHERE listID = ?"
            );

            $isSaved = $stmt->execute(array(
                    $this->listData['listDate'],
                    $this->listData['status'],
                    $this->listData['userID'],
                    $this->listData['listID']
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
        if (empty($this->listData['listDate']))
        {
            $this->errors['listDate'] = "Please enter the date";
            $isValid = false;
        }

        return $isValid;
    }

    function getList($sortColumn = null, $sortDirection = null, $filterColumn = null, $filterText = null, $page = null)
    {
        $listList = array();

        $sql = "SELECT * FROM groceryLists ";

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
          $total_pages_sql = "SELECT COUNT(*) FROM groceryLists";
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
            $listList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        //var_dump($stmt);


        return $listList;
    }

    function getListInfo($inStatus, $inDate){
      $listID=null;
      $checkListsql="SELECT *
                    FROM groceryLists
                    WHERE status = :status
                    AND listDate = :listDate";
                    $query= $this->db->prepare($checkListsql);
                                        $query->bindParam('status', $inStatus, PDO::PARAM_STR);
                                        $query->bindValue('listDate', $inDate, PDO::PARAM_STR);
                                        $query->execute();

                                        $count = $query->rowCount();
                                        //var_dump($count);
                                        $row = $query->fetch(PDO::FETCH_ASSOC);
                                        //var_dump($row['listID']);die;

              if ($row!=false) {
                $listID = $row['listID'];

              } else {
                //$user_info = false;
              }
                return $listID;
        }

  }

?>

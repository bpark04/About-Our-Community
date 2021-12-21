<?php
    require_once('logging/logging.php');
    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    
    function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
        // echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr); 
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }

        return $statement;
    }

    function executeBoundSQL($cmdstr, $list) {
        /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
    In this case you don't need to create the statement several times. Bound variables cause a statement to only be
    parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
    See the sample code below for how this function is used */

        global $db_conn, $success;
        $statement = OCIParse($db_conn, $cmdstr);
        echo $cmdstr;
        echo $statement;

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn);
            echo htmlentities($e['message']);
            $success = False;
        }

        foreach ($list as $tuple) {
            foreach ($tuple as $bind => $val) {
                //echo $val;
                //echo "<br>".$bind."<br>";
                OCIBindByName($statement, $bind, $val);
                unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            debug_to_console($statement);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                echo htmlentities($e['message']);
                echo "<br>";
                $success = False;
            }
        }
    }

    function printResidentResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table Resident:<br>";
        echo "<table>";
        echo "<tr><th>Name</th><th>SIN</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]" 
        }

        echo "</table>";
    }

    function printCafeResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table Cafe:<br>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Rating</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]" 
        }

        echo "</table>";
    }

    function printVisitedResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table Visited:<br>";
        echo "<table>";
        echo "<tr><th>SIN</th><th>Cafe</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[1] . "</td><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]" 
        }

        echo "</table>";
    }

    function printResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table Drink:<br>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Price</th><th>Rating</th><th>HotOrCold</th><th>Calories</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td></tr>"; 
        }

        echo "</table>";
    }

    function printTeaResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table Tea:<br>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Tea Type</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";
    }

    function connectToDB() {
        global $db_conn;

        // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_bpark03", "a79290409", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    // drop sql 
    function disconnectFromDB() {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }



    function handleInsertRequest() {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array (
            ":bind1" => $_POST['insName'],
            ":bind2" => $_POST['insPrice'],
            ":bind3" => $_POST['insRating'],
            ":bind4" => $_POST['insHotOrCold'],
            ":bind5" => $_POST['insCalories']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into DRINK values (:bind1, :bind2,:bind3, :bind4,:bind5)", $alltuples);
        OCICommit($db_conn);
    }

    function handleInsertResidentRequest() {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array (
            ":bind1" => $_POST['resName'],
            ":bind2" => $_POST['resSin'],
            ":bind3" => $_POST['resCity'],
            ":bind4" => $_POST['resStreet'],
            ":bind5" => $_POST['resHouseNum']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into RESIDENT values (:bind2, :bind1, :bind3, :bind4, :bind5)", $alltuples);
        OCICommit($db_conn);
    }

    function handleInsertCafeRequest() {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array (
            ":bind1" => $_POST['cafeName'],
            ":bind2" => $_POST['cafeRating']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into Cafe values (:bind1, :bind2)", $alltuples);
        OCICommit($db_conn);
    }

    function handleInsertVisitedRequest() {
        global $db_conn;

        //Getting the values from user and insert data into the table
        $tuple = array (
            ":bind1" => $_POST['visitedSin'],
            ":bind2" => $_POST['visitedCafe']
        );

        $alltuples = array (
            $tuple
        );

        executeBoundSQL("insert into Visited values (:bind2, :bind1)", $alltuples);
        OCICommit($db_conn);
    }

    function handleShowResidentTuplesRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT resident_name, resident_sin FROM Resident");

        printResidentResult($result);
    }

    function handleShowCafeTuplesRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Cafe");

        printCafeResult($result);
    }

    function handleShowVisitedTuplesRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Visited");

        printVisitedResult($result);
    }

    function handleShowTuplesRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Drink");

        printResult($result);
    }

    function handleShowTeaTuplesRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM Tea");

        printTeaResult($result);
    }

    function handleDeleteDrinkRequest() {
        global $db_conn;

        $id = $_POST["delName"];

        executePlainSQL("DELETE FROM Drink WHERE drinkName = '$id'");

        echo("Delete '$id' sucessful");

        OCICommit($db_conn);
    }

    function handleUpdateRequest() {
        global $db_conn;
        $drink_to_update = $_POST["updateDN"];
        echo($drink_to_update);

        $new_value = $_POST['newValue'];

        $attribute = $_POST['drink_options'];

        executePlainSQL("UPDATE Drink SET $attribute = '$new_value' WHERE $attribute = '$drink_to_update'");
        echo("Update '$drink_to_update' sucessful");
        OCICommit($db_conn);
    }

    function  handleProjectAttributeRequest() {
        global $db_conn;

        $projectionArray = array();
        if (isset($_POST["drinkName"])) {
            array_push($projectionArray,"drinkName");
        } 
        if (isset($_POST["price"])) {
            array_push($projectionArray,"price");
        } 
        if (isset($_POST["rating"])) {
            array_push($projectionArray,"rating");
        } 
        if (isset($_POST["hotOrCold"])){
            array_push($projectionArray,"hotOrCold");
        } 
        if(isset($_POST["calories"])) {
            array_push($projectionArray,"calories");
        }

        $priceInput = $_POST['price'];
        $hotColdInput = $_POST['hotOrCold_drink'];

        $str = implode(",", $projectionArray);
        echo("SELECT $str FROM Drink WHERE hotOrCold = '$hotColdInput' AND price <= $priceInput");
        $result = executePlainSQL("SELECT $str FROM Drink WHERE hotOrCold = '$hotColdInput' AND price <= $priceInput"); 

        printProjectionResult($result, $projectionArray);

        OCICommit($db_conn);
    }

    function printProjectionResult($result, $projectionArray) { //prints results from a projection statement
        echo "<table>";
        $titleString = "<tr><th>".implode("<th>", $projectionArray)."<tr>";
        echo($titleString);
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
             $length = count($projectionArray);

            $contentString = "<tr>";
            for ($x = 0; $x < $length; $x++) {
                $contentString = $contentString."<td>".$row[$x]."</td>";
            }
            $contentString = $contentString."</tr>";
             echo($contentString);
        }

        echo "</table>";
    }

    function handleJoinRequest() {
        global $db_conn;
        $result = executePlainSQL("SELECT r.resident_name, c.cafe_name FROM Resident r, Visited v, Cafe c WHERE r.resident_sin = v.resident_sin AND v.cafe_name = c.cafe_name AND c.rating >= 3");

        printJoinResult($result);
    }

    function handleJoin2Request() {
        global $db_conn;

        $rating = $_POST['userRating'];
        $result = executePlainSQL("SELECT r.resident_name, c.cafe_name FROM Resident r, Visited v, Cafe c WHERE r.resident_sin = v.resident_sin AND v.cafe_name = c.cafe_name AND c.rating >= '" . $rating . "'");
        printJoinResult($result);
    }

    function printJoinResult($result) { //prints results from a select statement
        echo "<br>Join:<br>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Cafe</th><th>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
        }
        echo "</table>";
    }

    function handleNestedAggre() {
        global $db_conn;

        $result = executePlainSQL("SELECT d1.rating, CAST(AVG(d1.price) AS DECIMAL (10,2)), CAST(AVG(d1.calories)AS DECIMAL(10,2))
        FROM Drink d1
        GROUP BY d1.rating 
        HAVING 1 < (SELECT COUNT(*)
                    FROM Drink d2
                    WHERE d1.rating = d2.rating) 
        ORDER BY d1.rating ASC"           );
        $titles = array("rating", "average price", "average calories");
        printProjectionResult($result,$titles);            
        OCICommit($db_conn); // TODO: ? 
    }

    function handleAggreWithHaving() {
        global $db_conn;  //drinkName

        $result = executePlainSQL("SELECT hotOrCold, min(calories), max(rating)
        FROM Drink
        WHERE price < 5
        GROUP BY hotOrCold
        HAVING COUNT(*)>1
        ");

        printAggreWithHavingResult($result);
    }

    function handleAggreWithHavingForTea() {
        global $db_conn;  

        $result = executePlainSQL("SELECT t.tea_type, CAST(avg(rating) AS DECIMAL(10,2)), CAST(avg(price) AS DECIMAL(10,2))
        FROM Drink d, Tea t
        WHERE t.tname = d.drinkName
        GROUP BY t.tea_type
        HAVING COUNT(*)>1
");
        $titles = array("Tea Types", "Average Rating", "Average Price");
        printProjectionResult($result,$titles);     
    }

    function printAggreWithHavingResult($result) { 
        echo "<br>Aggregation With Having:<br>";
        echo "<table>";
        echo "<tr><th>HotOrCold</th><th>Calories</th><th>Rating</th><tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1]. "</td><td>" . $row[2]."</td></tr>"; 
        }
        echo "</table>";
    }

    function handleDivisionRequest() {
        global $db_conn;
        $result = executePlainSQL("SELECT r.resident_name FROM Resident r WHERE NOT EXISTS (SELECT c.cafe_name FROM Cafe c WHERE NOT EXISTS(SELECT v.cafe_name FROM Visited v WHERE c.cafe_name = v.cafe_name AND v.resident_sin = r.resident_sin))");
        
        
        // EXCEPT (SELECT v.cafe_name FROM Visited v WHERE v.resident_sin = r.resident_sin))");

        printDivisionResult($result);
    }


    function printDivisionResult($result) { //prints results from a select statement
        echo "<br>Show all names of people who have visited all cafes:<br>";
        echo "<table>";
        echo "<tr><th>Name</th><th>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>"; //or just use "echo $row[0]"
        }
        echo "</table>";
    }

    function handleAggregationWithGroupByRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT TEA_TYPE, MAX(Price) FROM Drink INNER JOIN Tea ON Drink.drinkName=Tea.tname GROUP BY TEA_TYPE");
        printAggregationWithGroupByResult($result);
    }

    function printAggregationWithGroupByResult($result) {
        echo "<br>Joined table:<br>";
        echo "<table>";
        echo "<tr><th>Tea Type</th><th>Max Price</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["TEA_TYPE"] . "</td><td>" . $row["MAX(PRICE)"] . "</td></tr>"; //or just use "echo $row[0]" 
        }

        echo "</table>";


    }

    function handleSelectRequest() {
        global $db_conn;

        $selectedTable = $_POST["table_options"];

        $selectedCols = $_POST["col"];

        $colsAsStr = implode(",", $selectedCols);

        $filterCol = $_POST["col_filter_options"];

        $operator = $_POST["operator_options"];

        $user_input = $_POST["selectUserInput"];

        $filterCol2 = $_POST["col_filter_options2"];

        $operator2 = $_POST["operator_options2"];

        $user_input2 = $_POST["selectUserInput2"];

        $query = "SELECT $colsAsStr FROM $selectedTable WHERE $filterCol $operator $user_input AND $filterCol2 $operator2 $user_input2";
        $result = executePlainSQL($query);
        echo $query;
        printProjectionResult($result, $selectedCols);
    }

    // HANDLE ALL POST ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handlePOSTRequest() {
        if (connectToDB()) {
            if (array_key_exists('resetTablesRequest', $_POST)) {
                handleResetRequest();
            } else if (array_key_exists('updateQueryRequest', $_POST)) {
                handleUpdateRequest();
            } else if (array_key_exists('insertResidentRequest', $_POST)) {
                handleInsertResidentRequest();
            } else if (array_key_exists('insertCafeRequest', $_POST)) {
                handleInsertCafeRequest();
            } else if (array_key_exists('insertVisitedRequest', $_POST)) {
                handleInsertVisitedRequest();
            } else if (array_key_exists('insertQueryRequest', $_POST)) {
                handleInsertRequest();
            } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                handleDeleteDrinkRequest();
            }  else if (array_key_exists('selectQueryRequest', $_POST)) {
                handleSelectRequest();
            } else if (array_key_exists('projectAttributeRequest', $_POST)) {
                handleProjectAttributeRequest();
            }  else if (array_key_exists('join2Request', $_POST)) {
                handleJoin2Request();
            }
            disconnectFromDB();
        }
    }

    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
    function handleGETRequest() {
        if (connectToDB()) {
            if (array_key_exists('countTuples', $_GET)) {
                handleCountRequest();
            } else if (array_key_exists('showResidentTuples', $_GET)) {
                handleShowResidentTuplesRequest();
            } else if (array_key_exists('showCafeTuples', $_GET)) {
                handleShowCafeTuplesRequest();
            } else if (array_key_exists('showVisitedTuples', $_GET)) {
                handleShowVisitedTuplesRequest();
            } else if (array_key_exists('showTuples', $_GET)) {
                handleShowTuplesRequest();
            } else if (array_key_exists('showTeaTuples', $_GET)) {
                handleShowTeaTuplesRequest();
            } else if (array_key_exists('nestedAggregation', $_GET)) {
                handleNestedAggre();
            } else if (array_key_exists('joinRequest', $_GET)) {
                handleJoinRequest();
            } else if (array_key_exists('aggregationWithHaving', $_GET)) {
                handleAggreWithHaving();
            } else if (array_key_exists('divRequest', $_GET)) {
                handleDivisionRequest();
            } else if (array_key_exists('aggregationWithHavingForTea', $_GET)) {
                handleAggreWithHavingForTea();
            } else if (array_key_exists('aggregationWithGroupByQueryRequest', $_GET)) {
                handleAggregationWithGroupByRequest();
            }

            disconnectFromDB();
        }
    }

    if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['ResidentSubmit']) || isset($_POST['insertSubmit']) 
    || isset($_POST['CafeSubmit']) || isset($_POST['VisitedSubmit']) || isset($_POST['deleteSubmit']) 
    || isset($_POST['join2Submit'])|| isset($_POST['projectSubmit']) || isset($_POST['selectSubmit'])) {
        handlePOSTRequest();
    } else if (isset($_GET['countTupleRequest']) || isset($_GET['showResidentTuplesRequest']) || isset($_GET['showCafeTuplesRequest']) 
    || isset($_GET["showVisitedTuplesRequest"]) || isset($_GET['showTuplesRequest']) 
    || isset($_GET['showTeaTuplesRequest']) || isset($_GET["joinSubmit"]) || isset($_GET["nestedAggreSubmit"])
    || isset($_GET['aggreWithHavingSubmit']) || isset($_GET["divSubmit"]) 
    || isset($_GET["aggreWithHavingForTeaSubmit"])|| isset($_GET["aggregationWithGroupBySubmit"])) {
        handleGETRequest();
    }
?>
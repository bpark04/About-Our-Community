  <html>
    <head>
        <title>About Our Community</title>
        <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
        <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
        <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
    </head>

    <body>

        <h2>Show the tuples in Resident</h2>
        <form method="GET" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="showResidentTuplesRequest" name="showResidentTuplesRequest">
            <input type="submit" name="showResidentTuples"></p>
        </form>

        <h2>Show the tuples in Cafe</h2>
        <form method="GET" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="showCafeTuplesRequest" name="showCafeTuplesRequest">
            <input type="submit" name="showCafeTuples"></p>
        </form>

        <h2>Show the tuples in Visit History</h2>
        <form method="GET" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="showVisitedTuplesRequest" name="showVisitedTuplesRequest">
            <input type="submit" name="showVisitedTuples"></p>
        </form>
        
        <h2>Show the tuples in Drink</h2>
        <form method="GET" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="showTuplesRequest" name="showTuplesRequest">
            <input type="submit" name="showTuples"></p>
        </form>

        <h2>Show the tuples in Tea</h2>
        <form method="GET" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="showTeaTuplesRequest" name="showTeaTuplesRequest">
            <input type="submit" name="showTeaTuples"></p>
        </form>

        <h2>Insert Values into Resident</h2>
        <form method="POST" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertResidentRequest" name="insertResidentRequest">
            Name: <input type="text" name="resName"> <br /><br />
            SIN: <input type="text" name="resSin"> <br /><br />
            City: <input type="text" name="resCity"> <br /><br />
            Street: <input type="text" name="resStreet"> <br /><br />
            House Number: <input type="text" name="resHouseNum"> <br /><br />

            <input type="submit" value="InsertResident" name="ResidentSubmit"></p>
        </form>

        <h2>Insert Values into Cafe</h2>
        <form method="POST" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertCafeRequest" name="insertCafeRequest">
            Name: <input type="text" name="cafeName"> <br /><br />
            Rating: <input type="text" name="cafeRating"> <br /><br />

            <input type="submit" value="InsertCafe" name="CafeSubmit"></p>
        </form>

        <h2>Insert Values into Drink</h2>
        <form method="POST" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Name: <input type="text" name="insName"> <br /><br />
            Price: <input type="text" name="insPrice"> <br /><br />
            Rating: <input type="text" name="insRating"> <br /><br />
            HotOrCold: <input type="text" name="insHotOrCold"> hot or cold in lower case<br /><br />
            Calories: <input type="text" name="insCalories"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <h2>Insert Values into Visit History</h2>
        <form method="POST" action="index.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertVisitedRequest" name="insertVisitedRequest">
            SIN: <input type="text" name="visitedSin"> <br /><br />
            Cafe: <input type="text" name="visitedCafe"> <br /><br />

            <input type="submit" value="InsertVisited" name="VisitedSubmit"></p>
        </form>

        <h2>Update Drink Name</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="index.php">
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Old Value: <input type="text" name="updateDN"> <br /><br />
            <label for="drink_options">Choose an attribute:</label>
            <select name="drink_options" id="drink_options">
                <option value="drinkName">Drink Name</option>
                <option value="price">Price</option>
                <option value="rating">Rating</option>
                <option value="hotOrCold">HotOrCold</option>
                <option value="calories">Calories</option>
            </select>
            <br><br>
            <!-- Old Value: <input type="text" name="oldValue"> <br /><br /> -->
            New Value: <input type="text" name="newValue"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <h2>Delete Drink by name</h2>
        <form method="POST" action="index.php">
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            Name: <input type="text" name="delName"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <h2>Project Drink Attribute</h2>
        <p> Project the selecteed attributes of drink that satifiy the user's input of temperature and type 
            with price lower than or equal to user input<p>
        <form method="POST" action="index.php">
            <input type="hidden" id="projectAttributeRequest" name="projectAttributeRequest">
        <p> Choose the attributes that you would like to project: <p>
            <div>
                <input type="checkbox" id="drinkName" name="drinkName">
                <label for="drinkName">Drink Name<label>
            <div>  
                
            <div>
                <input type="checkbox" id="price" name="price">
                <label for="price">Price<label>
            <div>  

            <div>
                <input type="checkbox" id="rating" name="rating">
                <label for="rating">Rating<label>
            <div>      
                
            <div>
                <input type="checkbox" id="hotOrCold" name="hotOrCold">
                <label for="hot/cold">HotOrCold<label>
            <div>   

            <div>
                <input type="checkbox" id="calories" name="calories">
                <label for="calorie">Calories<label>
            <div>  

        <br><br>

        </select>
		<label for="hotORCold_drink">Choose a type of drink:</label>
            	<select name="hotOrCold_drink" id="hotOrCold_drink">
               	 <option value="hot">Hot</option>
                <option value="cold">Cold</option>
	    </select>
		
            <br><br>
            Price: <input type="text" name="price"> <br /><br />
            <input type="submit" value="Project" name="projectSubmit"></p>
        </form>

        <h2>Join - Set Rating</h2>
        <p>Show the name of residents and their visited cafe with a rating greater than 3</p>
        <form method="GET" action="index.php">
            <input type="hidden" id="joinRequest" name="joinRequest">
            <input type="submit" value="Join" name="joinSubmit"></p>
        </form>

        <h2>Join - User's Input</h2>
        <p>Show the name of residents and their visited cafe with a rating greater than unser's input</p>
        <form method="POST" action="index.php">
            <input type="hidden" id="join2Request" name="join2Request">
            Rating: <input type="text" name="userRating"> <br /><br />
            <input type="submit" value="Join2" name="join2Submit"></p>
        </form>

        <h2>Nested Aggregation With Group by</h2>
        <p>Calculate the average price of drinks in each rating category</p>
        <form method="GET" action="index.php">
            <input type="hidden" id="nestedAggregation" name="nestedAggregation">
            <input type="submit" value="NestedAggre" name="nestedAggreSubmit"></p>
        </form>

        <h2>Aggregation With Having</h2>
        <p> First Time to our community?  Try our drinks that is cheaper than $5 with minimum calories yet highest rating recommaned by residents</p>
        <form method="GET" action="index.php">
            <input type="hidden" id="aggregationWithHaving" name="aggregationWithHaving">
            <input type="submit" value="AggreWithHaving" name="aggreWithHavingSubmit"></p>
        </form>

        <h2>Aggregation With Having For Tea</h2>
        <p> Return the avgerage rating and price for each tea category</p>
        <form method="GET" action="index.php">
            <input type="hidden" id="aggregationWithHavingForTea" name="aggregationWithHavingForTea">
            <input type="submit" value="AggreWithHavingForTea" name="aggreWithHavingForTeaSubmit"></p>
        </form>

        <h2>Division</h2>
        <p>Show all names of people who have visited all cafes</p>
        <form method="GET" action="index.php">
            <input type="hidden" id="divRequest" name="divRequest">
            <input type="submit" value="Division" name="divSubmit"></p>
        </form>

        <h2>Aggregation with group by</h2>
        <p>Get the price of the most expensive tea(s) grouped by tea type</p>
        <form method="GET" action="index.php">
            <input type="hidden" id="aggregationWithGroupByQueryRequest" name="aggregationWithGroupByQueryRequest">
            <input type="submit" value="Submit" name="aggregationWithGroupBySubmit">
        </form>

        <div id="like_button_container"></div>
            
                    

        <?php
        require_once('db/db.php');
        
		?>

        <script type="text/babel" src="like_button.js"></script>
	</body>
    
</html>




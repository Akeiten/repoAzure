<html>
 <head>
  <Title>Search</Title>
  <style type="text/css">
    body {
     background-color: #fff; border-top: solid 10px #000;
     color: #333; font-size: .85em; margin: 20; padding: 20;
     font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
  </style>
 </head>

 <body>
  <h1>Database Search!</h1>
  <h3>Use the search box with the radio button to view data in the database.</h3>
   <form method="post" action="index.php" enctype="multipart/form-data" >
      Search Box:</br>
      <input type="text" name="search" id="search"/></br></br>
      Column:</br>
      Name <input type="radio" name="name" id="name"/></br>
      Email <input type="radio" name="email" id="email"/></br>
      Company_Name <input type="radio" name="companyName" id="companyName"/></br>
      Date <input type="radio" name="date" id="date"/></br></br>
      <input type="submit" name="submit" value="Submit" />
  </form>

      	

  <?php
      if (!empty($_POST)) {
        $search = $_POST['search'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $company = $_POST['companyName'];
        $date = $_POST['date'];

        if ($search) {
         if (!$name &&!$email&&!$companyName&&!$date) {
         echo "<h3>Please select a radio button.</h3>";
         } else {
         // Connect to database.
         $host = "eu-cdbr-azure-west-b.cloudapp.net";
         $user = "bfff0fde04a6ca";
         $pwd = "5be560d8";
         $db = "zcabxtlMySQL";
         try {
         $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
         $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
         } catch(Exception $e){
         die(var_dump($e));
         }


         //Get SQL statement
         $column_name = "";
         if ($name) {
         $column_name = "name";
         } else if ($email){
              $column_name = "email";
         } else if ($company) {
         $column_name = "company";
         } else {
         $column_name = "date";
         }
         $sql_stmt = "SELECT * FROM registration_tbl WHERE $column_name='$search'";


         //Retrieve data
         $stmt = $conn->query($sql_stmt);
         $registrants = $stmt->fetchAll();
         if(count($registrants) > 0) {
         echo "<h2>Data Found:</h2>";
         echo "<table>";
         echo "<tr><th>Name</th>";
         echo "<th>Email</th>";
         echo "<th>Company_Name</th>";
         echo "<th>Date</th></tr>";
         foreach($registrants as $registrant) {
                echo "<tr><td>".$registrant['name']."</td>";
                echo "<td>".$registrant['email']."</td>";
                echo "<td>".$registrant['company']."</td>";
                echo "<td>".$registrant['date']."</td></tr>";
         }
         echo "</table>";
         } else {
         echo "<h3>Value does not exist in the database.</h3>";
         }

         }
        } else {
         echo "Please type in a value in the Search Box.";
        }
        
      }

  ?>
</body>

</html>

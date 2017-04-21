<?php
/** <Author> Joshua Standiford </Author>
 ** <Date Modified> 7/27/2016 </Date Modified>
 ** <Description>
 ** Database.php acts as a class file used for database functions.
 ** Collection of connection methods and helper functions populate this
 ** file
 ** </Description>
 */
class DB {

    /* Constructor for Database class
     *
     *
     */
    function DB() {

    }


    /**
     * Desc: This function connects to the database
     * Called on creation of the database class
     * Preconditions: None
     * Postconditions: Either a new PDO connection is returned or null
     * @return null|PDO
     * Known bugs:
     * THead  tag in index is empty, reading from dbkey.ini sometimes causes failures in populating data tables.
     * Solution: hard code the connect() credentials.
     */
    private function connect(){
        $cred = parse_ini_file(dirname(__FILE__) . "/../db_key.ini");

        $servername = $cred["servername"];
        $username = $cred["username"];
        $password = $cred["password"];
        $dbname = $cred["dbname"];

        try{
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
        return null;
    }

    /**
     * @param $data - Contains $_POST data of users information
     * @return bool - true if the submission was a success
     * @Description: This will submit a new account to the database.
     * The password is salted and hashed and encrypted with blowfish
     * encryption.
     */
    public function submitNewAccount($data){
        $table = "accounts";
        try{
            $conn = $this->connect();
            $stmt = $conn->prepare("INSERT INTO accounts (email, password, firstname)
                                    VALUES (:email, :password, :firstname)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':firstname', $firstname);

            $email = $data["email"];
            $password = $data["password"];
            $firstname = $data["firstname"];

            $stmt->execute();
        }
        catch(PDOException $e){
            return false;
        }
        return true;
    }

    /**
     * @param $user
     * @param $pass
     * @return array|bool
     */
    public function authorize($ID, $pass){
        $table = "accounts";
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("select password from $table WHERE email = '" . $ID . "'");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $result = $stmt->fetchAll();

            $conn = null;

            return $result[0]["password"];
        }
        catch(PDOException $e){
            return false;
        }
    }

    /**
     * @param $ID
     * @return array|bool|string
     */
    public function test(){
        $table = "live_stats";
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("SELECT * FROM $table");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            $conn = null;

            return $result;
        }
        catch(PDOException $e){
            echo $e;
            return null;
        }
    }


    /**
     * @param $ID
     * @return array|bool|string
     */
    public function getName($ID){
        $table = "accounts";
        try {
            $conn = $this->connect();
            $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = '" . $ID . "'");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            $conn = null;
            foreach ($result as $k => $v) {
                return $v["firstname"];
            }

            return $result;
        }
        catch(PDOException $e){
            echo $e;
            return null;
        }
    }

    public function archive($ID, $CODE, $USER){
        $table = "LIBRARY_Student_Apps";
        try {
            $conn = $this->connect();
            $stmt = "";
            if(strcmp($CODE, "pending")){

                $stmt = $conn->prepare("UPDATE $table SET archived = '" . date("Y-m-d") . "', appStatus = '" . $CODE . "', manager= '" . $USER . "' WHERE campusID = '" . $ID . "'");
            }
            elseif(strcmp($CODE, "new")){
                echo $CODE;
                $stmt = $conn->prepare("UPDATE $table SET archived = '" . date("Y-m-d") . "', appStatus = '" . $CODE . "', manager= '" . $USER . "' WHERE campusID = '" . $ID . "'");
            }
            else{
                $stmt = $conn->prepare("UPDATE $table SET appStatus = '" . $CODE . "', manager= '" . $USER . "' WHERE campusID = '" . $ID . "'");
            }

            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            $conn = null;

            return true;
        }
        catch(PDOException $e){
            echo $e;
            return false;
        }
    }


    public function denyApp($ID, $comment, $USER){
        $table = "LIBRARY_Student_Apps";
        try {
            $conn = $this->connect();

            $stmt = $conn->prepare("UPDATE $table SET appStatus = 'denied', manager= '" . $USER . "' WHERE campusID = '" . $ID . "'");
            $stmt->execute();
            $stmt = $conn->prepare("UPDATE $table SET comments = '" . $comment . "' WHERE campusID = '" . $ID . "'");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            $conn = null;

            return true;
        }
        catch(PDOException $e){
            echo $e;
            return false;
        }

    }

    /**
     * Submits a query to the database
     */
    public function selectAll(){
        $table = "LIBRARY_Student_Apps";
        $conn = $this->connect();
        $stmt = $conn->prepare("select * from $table");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;
        return $result;
    }

    public function selectAllWorkData(){
        $table = "LIBRARY_Student_App_Work";
        $conn = $this->connect();
        $stmt = $conn->prepare("select * from $table");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;
        return $result;
    }

    /**
     * Submits a query to the database
     */
    public function selectAllID($id){
        $table = "LIBRARY_Student_Apps";
        $conn = $this->connect();
        $stmt = $conn->prepare("select * from $table WHERE campusID = '" . $id . "'");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;
        return $result;
    }

    public function selectDepartment($department){
        echo $department;
        $table = "LIBRARY_Student_Apps";
        $conn = $this->connect();
        $stmt = $conn->prepare("select * from $table where dept like '%$department%'");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;

        return $result;

    }

    public function getAppData($ID){
        $table = "LIBRARY_Student_Apps";
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM $table WHERE campusID = '" . $ID ."'");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;

        foreach($result as $k=>$v) {
            return $v;
        }

        return $result;
    }

    public function getWorkAppData($ID){
        $table = "LIBRARY_Student_App_Work";
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM $table WHERE campusID = '" . $ID ."'");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;

        foreach($result as $k=>$v) {

            return $v;
        }

        return $result;
    }

    /**
     * @param $UMBCID - The UMBC ID of the user checking their application status
     * @return array - Associate array containing the application status
     */
    public function getAppStatus($UMBCID){
        $table = "LIBRARY_Student_Apps";
        $conn = $this->connect();
        $stmt = $conn->prepare("select * from $table WHERE campusID = '" . $UMBCID . "'");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;

        if($stmt->rowCount() == 0)
        {
            return false;
        }

        return $result;
    }

    /**
     * @param $UMBCID
     * @return bool - True if the user already applied
     *              - False if the user hasn't applied yet
     */
    public function applied($UMBCID){
        $table = "LIBRARY_Student_Apps";
        $conn = $this->connect();
        $stmt = $conn->prepare("select * from $table WHERE campusID = '" . $UMBCID . "'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $conn = null;

        if($result){
            return true;
        }
        return false;
    }

    public function submitComments($data){
        $table = "LIBRARY_Student_App_Comments";
        try{
            $conn = $this->connect();
            $stmt = $conn->prepare("INSERT INTO LIBRARY_Student_App_Comments (campusID, comment, author)
                                    VALUES (:campusID, :comment, :author)");
            $stmt->bindParam(':campusID', $campusID);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':author', $author);

            $campusID = $data["campusID"];
            $comment = $data["comment"];
            $author = $data["author"];

            $stmt->execute();
        }
        catch(PDOException $e){
            return false;
        }
        return true;
    }

    public function getComments($ID){
        $table = "LIBRARY_Student_App_Comments";
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT comment FROM $table WHERE campusID = '" . $ID ."'");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        $conn = null;



        return $result;
    }

    /**
     * This function takes the user data from the client side
     * and submits it to the database.
     * @param $data - Information pertaining to the user applying
     * @return bool - Return's true if the app was submitted successfully
     *              - Return's false if the ID already exists or an error occurred
     */
    public function submitApp($data){
        if($this->applied($data["campusID"])){
            echo "Application already submitted";
            return false;
        }
        try {
            $table = "LIBRARY_Student_Apps";
            $conn = $this->connect();
            $stmt = $conn->prepare("INSERT INTO LIBRARY_Student_Apps (lastname, firstname, phone, email, campusID, dept, appStatus, dateApplied, offcampusPhone)
                                VALUES (:lastname, :firstname, :phone, :email, :campusID, :dept, :status, :dateApplied, :offcampusPhone)");
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':campusID', $campusID);
            $stmt->bindParam(':dept', $dept);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':dateApplied', $date);
            $stmt->bindParam(':offcampusPhone', $offPhone);
            $date = date("Y-m-d");
            $lastname = $data["lName"];
            $firstname = $data["fName"];
            $email = $data["email"];
            $campusID = $data["campusID"];
            $phone = $data["locPhone"];
            $offPhone = $data["permPhone"];

            if(isset($data['dept'])){
                foreach($data['dept'] as $selected){
                    $dept .= $selected . ", ";
                }
            }
            else{
                $dept = "None";
            }

            $status = "new";
            $NA = "N/A";

            $stmt->execute();
        }
        catch(PDOException $e){
            return false;
        }
        return true;
    }

    public function submitWorkStudy($data){
        if($this->applied($data["campusID"])){
            return false;
        }
        try {
            $table = "LIBRARY_Student_App_Work";
            $conn = $this->connect();
            $stmt = $conn->prepare("INSERT INTO LIBRARY_Student_App_Work (campusID, semesterApplied, 
                                                                          mondayOne, mondayTwo, mondayThree, mondayFour,
                                                                          tuesdayOne, tuesdayTwo, tuesdayThree, tuesdayFour, 
                                                                          wednesdayOne, wednesdayTwo, wednesdayThree, wednesdayFour, 
                                                                          thursdayOne, thursdayTwo, thursdayThree, thursdayFour, 
                                                                           fridayOne, fridayTwo, fridayThree, fridayFour,
                                                                           saturdayOne, saturdayTwo, saturdayThree, saturdayFour,
                                                                           sundayOne, sundayTwo, sundayThree, sundayFour, 
                                                                           workedBefore, workedBeforeWhere, currentlyWorking,
                                                                           currentlyWhere, computerExp, officeEquipment, publicExp,
                                                                           foreignLang, specialSkills, recentEmployer, employerAddress, 
                                                                           supervisorName, position, employedFrom, employedTo, reasonForLeaving,
                                                                           academicStatus, anticipatedGrad, major, addWork, FWSA, FAFSA, FWS)
                                                                          VALUES(:campusID, :semesterApplied, 
                                                                          :mondayOne, :mondayTwo, :mondayThree, :mondayFour,
                                                                          :tuesdayOne, :tuesdayTwo, :tuesdayThree, :tuesdayFour,
                                                                          :wednesdayOne, :wednesdayTwo, :wednesdayThree, :wednesdayFour,
                                                                          :thursdayOne, :thursdayTwo, :thursdayThree, :thursdayFour,
                                                                          :fridayOne, :fridayTwo, :fridayThree, :fridayFour,
                                                                          :saturdayOne, :saturdayTwo, :saturdayThree, :saturdayFour,
                                                                          :sundayOne, :sundayTwo,:sundayThree, :sundayFour,
                                                                          :workedBefore, :workedBeforeWhere, :currentlyWorking,
                                                                          :currentlyWhere, :computerExp, :officeEquipment, :publicExp,
                                                                          :foreignLang, :specialSkills, :recentEmployer, :employerAddress, 
                                                                          :supervisorName, :position, :employedFrom, :employedTo, :reasonForLeaving,
                                                                          :academicStatus, :anticipatedGrad, :major, :addWork, :FWSA, :FAFSA, :FWS)");
            $stmt->bindParam(':campusID', $campusID);
            $stmt->bindParam(':semesterApplied', $semesterApplied);
            $stmt->bindParam(':mondayOne', $mondayOne);
            $stmt->bindParam(':mondayTwo', $mondayTwo);
            $stmt->bindParam(':mondayThree', $mondayThree);
            $stmt->bindParam(':mondayFour', $mondayFour);
            $stmt->bindParam(':tuesdayOne', $tuesdayOne);
            $stmt->bindParam(':tuesdayTwo', $tuesdayTwo);
            $stmt->bindParam(':tuesdayThree', $tuesdayThree);
            $stmt->bindParam(':tuesdayFour', $tuesdayFour);
            $stmt->bindParam(':wednesdayOne', $wednesdayOne);
            $stmt->bindParam(':wednesdayTwo', $wednesdayTwo);
            $stmt->bindParam(':wednesdayThree', $wednesdayThree);
            $stmt->bindParam(':wednesdayFour', $wednesdayFour);
            $stmt->bindParam(':thursdayOne', $thursdayOne);
            $stmt->bindParam(':thursdayTwo', $thursdayTwo);
            $stmt->bindParam(':thursdayThree', $thursdayThree);
            $stmt->bindParam(':thursdayFour', $thursdayFour);
            $stmt->bindParam(':fridayOne', $fridayOne);
            $stmt->bindParam(':fridayTwo', $fridayTwo);
            $stmt->bindParam(':fridayThree', $fridayThree);
            $stmt->bindParam(':fridayFour', $fridayFour);
            $stmt->bindParam(':saturdayOne', $saturdayOne);
            $stmt->bindParam(':saturdayTwo', $saturdayTwo);
            $stmt->bindParam(':saturdayThree', $saturdayThree);
            $stmt->bindParam(':saturdayFour', $saturdayFour);
            $stmt->bindParam(':sundayOne', $sundayOne);
            $stmt->bindParam(':sundayTwo', $sundayTwo);
            $stmt->bindParam(':sundayThree', $sundayThree);
            $stmt->bindParam(':sundayFour', $sundayFour);
            $stmt->bindParam(':workedBefore', $workedBefore);
            $stmt->bindParam(':workedBeforeWhere', $workedBeforeWhere);
            $stmt->bindParam(':currentlyWorking', $currentlyWorking);
            $stmt->bindParam(':currentlyWhere', $currentlyWhere);
            $stmt->bindParam(':computerExp', $computerExp);
            $stmt->bindParam(':officeEquipment', $officeEquipment);
            $stmt->bindParam(':publicExp', $publicExp);
            $stmt->bindParam(':foreignLang', $foreignLang);
            $stmt->bindParam(':specialSkills', $specialSkills);
            $stmt->bindParam(':recentEmployer', $recentEmployer);
            $stmt->bindParam(':employerAddress', $employerAddress);
            $stmt->bindParam(':supervisorName', $supervisorName);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':employedFrom', $employedFrom);
            $stmt->bindParam(':employedTo', $employedTo);
            $stmt->bindParam(':reasonForLeaving', $reasonForLeaving);
            $stmt->bindParam(':academicStatus', $academicStatus);
            $stmt->bindParam(':anticipatedGrad', $anticipatedGrad);
            $stmt->bindParam(':major', $major);
            $stmt->bindParam(':addWork', $addWork);
            $stmt->bindParam(':FWSA', $FWSA);
            $stmt->bindParam(':FAFSA', $FAFSA);
            $stmt->bindParam(':FWS', $FWS);


            $campusID = $data["campusID"];
            $semesterApplied = $data["semester"];
            $mondayOne = $data["Monday1"];
            $mondayTwo = $data["Monday2"];
            $mondayThree = $data["Monday3"];
            $mondayFour = $data["Monday4"];
            $tuesdayOne = $data["Tuesday1"];
            $tuesdayTwo = $data["Tuesday2"];
            $tuesdayThree = $data["Tuesday3"];
            $tuesdayFour = $data["Tuesday4"];
            $wednesdayOne = $data["Wednesday1"];
            $wednesdayTwo = $data["Wednesday2"];
            $wednesdayThree = $data["Wednesday3"];
            $wednesdayFour = $data["Wednesday4"];
            $thursdayOne = $data["Thursday1"];
            $thursdayTwo = $data["Thursday2"];
            $thursdayThree = $data["Thursday3"];
            $thursdayFour = $data["Thursday4"];
            $fridayOne = $data["Friday1"];
            $fridayTwo = $data["Friday2"];
            $fridayThree = $data["Friday3"];
            $fridayFour = $data["Friday4"];
            $saturdayOne = $data["Saturday1"];
            $saturdayTwo = $data["Saturday2"];
            $saturdayThree = $data["Saturday3"];
            $saturdayFour = $data["Saturday4"];
            $sundayOne = $data["Sunday1"];
            $sundayTwo = $data["Sunday2"];
            $sundayThree = $data["Sunday3"];
            $sundayFour = $data["Sunday4"];
            $workedBefore = $data["prior"];
            $workedBeforeWhere = $data["priorInfo"];
            $currentlyWorking = $data["else"];
            $currentlyWhere = $data["whereElse"];
            $computerExp = $data["compExp"];
            $officeEquipment = $data["ofmacExp"];
            $publicExp = $data["psExp"];
            $foreignLang = $data["languages"];
            $specialSkills = $data["skills"];
            $recentEmployer = $data["recEmp"];
            $employerAddress = $data["recEmpAd"];
            $supervisorName = $data["recEmpSup"];
            $position = $data["recEmpDut"];
            $employedFrom = $data["recEmpd1"];
            $employedTo = $data["recEmpd2"];
            $reasonForLeaving = $data["recEmplv"];
            $academicStatus = $data["status"];
            $anticipatedGrad = $data["grad"];
            $major = $data["field"];
            $addWork = $data["addWork"];
            $FWSA = $data["workstudy"];
            $FAFSA = $data["fafsa"];
            $FWS = $data["WSI"];


            $stmt->execute();
        }
        catch(PDOException $e){
            echo $e;
            return false;
        }
        return true;
    }
}
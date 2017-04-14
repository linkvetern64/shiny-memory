/**
 * Created by Josh on 10/6/2016.
 */
var id;
var pageNum = -1;
var MAX_LIST_SIZE = 5;

function getMaxSize(){
    return MAX_LIST_SIZE;
}

function updateView(){
    MAX_LIST_SIZE = document.getElementById("display-results").value;

    page(pageNum);
}


function updateCart(){
    var id = 1;
    new Ajax.Request( "cart.php",
        {
            method: "get",
            parameters: {id : id},
            onSuccess: cartSuccess
        }
    );
}

function cartSuccess(ajax){
    document.getElementById("cartSize").innerHTML = ajax.responseText;
}

/*page(var int);
 *Parameters(pageNo), number, which will determine which page to load
 *Desc: Used to paginate the active listings on the profile screen
 *
 */
function page(pageNo){

    pageNum = pageNo;
     new Ajax.Request( "paginate.php",
        {
            method: "get",
            parameters: {pageNo : pageNo},
            onSuccess: pageSuccess,
            onFailure: pageFailure
        }
    );
}

/* pageSuccess(var Ajax)
 * Desc: pageSuccess will be used to populate the
 *       homepage with active items
 */
function pageSuccess(ajax){

    var items = JSON.parse(ajax.responseText);
    if(items.length > 0) {
        var myNode = document.getElementById("list-content");
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }
        for (var i = ((pageNum - 1) * MAX_LIST_SIZE); i < (pageNum * MAX_LIST_SIZE); i++) {

            //items[index][mySQL att.]
            var row = document.createElement('span');

            row.className = 'list-group-item spacing w3-hover-light-blue';
            row.innerHTML = "<a class='avis portfolio-link' data-toggle='modal' onclick='popEdit(\"" + items[i]["unique"] + "\");' href='#editItem'>" +
                                "<span style='float:left;' class='glyphicon glyphicon-pencil listing-left hov-blue'></span>" +
                            "</a>" +
                            "<span style='float:left;' onclick='removeRow(\"" + items[i]["unique"] + "\");' class='glyphicon glyphicon-remove listing-left hov-red'></span>" +
                            items[i]["good"];

            document.getElementById('list-content').appendChild(row);
        }
    }
    else{
        document.getElementById("list-content").innerHTML = "There appears to be nothing here.<br/> " +
                                                            "<a data-toggle='modal' href='#editItem'>Create Listing?</a>";
    }
}

/**
 * This function calls Ajax to remove a row from the DB
 * @param id
 */
function removeRow(id){
    new Ajax.Request( "removeItem.php",
        {
            method: "get",
            parameters: {id : id},
            onSuccess: removeSuccess
        }
    );
}

function removeSuccess(ajax){
    console.log(ajax.responseText);
    page(1);
    //bootstrap alert, item removed successfully.
}

function popEdit(id){
    console.log(id + " : SUCCESS");
}

/** pageFailure(var Ajax)
 * Desc: will be used as a test-function only
 * @param ajax
 */
function pageFailure(ajax){
    console.log(ajax.responseText + " : FAILURE");
}

/**
 * check(var ID)
 * Desc: will be used to check if pre-existing values
 * already exist in the database and alert user on registration
 * @param ID
 */
function check(ID){
    var val = document.getElementById(ID).value;
    console.log(ID);
    if(ID == "emailIn"){
        //Test regex for email
        new Ajax.Request( "check.php",
            {
                method: "get",
                parameters: {ID : ID,
                    val : val},
                onSuccess: checkSuccess,
                onFailure: checkFailure
            }
        );
    }
    else if(ID == "campusID"){
        //Sanitize before
        new Ajax.Request( "check.php",
            {
                method: "get",
                parameters: {ID : ID,
                    val : val},
                onSuccess: campusSuccess,
                onFailure: checkFailure
            }
        );
    }
}

/*
 * Update glyphicon image @ id
 */
function checkSuccess(ajax){

        document.getElementById("emailCheck").className = "";
        if(ajax.responseText == 1){
            document.getElementById("emailCheck").className = "glyphicon glyphicon-remove-circle";
            document.getElementById("emailCheck").style.color = "red";

        }
        else{
            document.getElementById("emailCheck").className = "glyphicon glyphicon-ok-circle";
            document.getElementById("emailCheck").style.color = "green";
        }
}

function checkFailure(){
    console.log("Failure @ __LINE__");
}

function campusSuccess(ajax){
    document.getElementById("campusIDCheck").className = "";
    if(ajax.responseText == 1){
        document.getElementById("campusIDCheck").className = "glyphicon glyphicon-remove-circle";
        document.getElementById("campusIDCheck").style.color = "red";

    }
    else{
        document.getElementById("campusIDCheck").className = "glyphicon glyphicon-ok-circle";
        document.getElementById("campusIDCheck").style.color = "green";
    }
}

/*Used to gather active goods in their respective categories*/
function populate(code){
    id = code;
    new Ajax.Request( "populate.php",
        {
            method: "get",
            parameters: {code : code},
            onSuccess: worked,
            onFailure: failed
        }
    );
}

/**
 * Ajax on Success function
 */
function worked(ajax){
    var res = ajax.responseText;
}

/**
 * Print failure to console
 * @param ajax
 */
function failed(ajax){
    console.log("AJAX FAILED");
    console.log(ajax.responseText);
}
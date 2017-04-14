/**
 * Created by Josh on 11/3/2016.
 */

/**
 * This function checks user input to validate and clean
 * @returns {boolean} True if user input passes, false otherwise.
 */
function validate(){
    /* Include Fname and LName in verification*/
    return true;
    /* Call the functions of ajax validation in here. */
    if(document.getElementById("password").value != document.getElementById("passwordRetype").value){
        console.log("Incorrect passwords");
        return false;
    }
    return true;
}

function passwordVerify(){
    var password = document.getElementById("password").value;
    var passwordVerify = document.getElementById("passwordRetype").value;

    if(password.length >= 8 && passwordVerify.length >= 8){
        document.getElementById("wrongPassReg").className = "";
        if(password != passwordVerify){
            document.getElementById("wrongPassReg").className = "glyphicon glyphicon-remove-circle";
            document.getElementById("wrongPassReg").style.color = "red";

        }
        else{
            document.getElementById("wrongPassReg").className = "glyphicon glyphicon-ok-circle";
            document.getElementById("wrongPassReg").style.color = "green";
        }
    }
}
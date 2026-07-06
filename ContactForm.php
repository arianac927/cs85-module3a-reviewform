<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Contact Me</title>
</head>
    <body>
<?php

//Validates each input field
function validateInput($data, $fieldName) {
    global $errorCount;
    //Displays message if there is no input
    if (empty($data)) {
        echo "\"$fieldName\" is a required field.<br />\n";
        ++$errorCount;
        $retval = "";
    }
    //Cleans up input by removing unnecessary characters
    else {
        $retval = trim($data);
        $retval = stripslashes($retval);
    }
    return($retval);
}

//Validates email field
function validateEmail($data, $fieldName) {
    global $errorCount;
    //Displys message if there is no input
    if (empty($data)) {
        echo "\"$fieldName\" is a required field.<br />\n";
        ++$errorCount; $retval = "";
    }
    //Removes characters not allowed within an email address
    else {
        $retval = filter_var($data, FILTER_SANITIZE_EMAIL);
    //Displays message if email format is invalid
        if (!filter_var($retval, FILTER_VALIDATE_EMAIL)) {
            echo "\"$fieldName\" is not a valid e-mail address.<br />\n";
        }
    }
    return($retval);
}

/*
Display form to the user,
with 'Clear Form' button to reset form,
and 'Send Form' button to submit the message
*/
function displayForm($Sender, $Email, $Subject, $Message) {
    ?> <h2 style = "text-align:center">Contact Me</h2>
    <form name="contact" action="ContactForm.php" method="post">
        <p>Your Name:
            <input type="text" name="Sender" value="<?php echo $Sender; ?>" /></p>
        <p>Your E-mail:
            <input type="text" name="Email" value="<?php echo $Email; ?>" /></p>
        <p>Subject:
            <input type="text" name="Subject" value="<?php echo $Subject; ?>" /></p>
        <p>Message:<br />
            <textarea name="Message"><?php echo $Message; ?></textarea></p>
        <p><input type="reset" value="Clear Form" />&nbsp; &nbsp;
            <input type="submit" name="Submit" value="Send Form" /></p>
    </form>

    <?php
}

//Default input for each field
$ShowForm = TRUE;
$errorCount = 0;
$Sender = "";
$Email = "";
$Subject = "";
$Message = "";

//Goes through each Validation function when 'Send Form' is selected
if (isset($_POST['Submit'])) {
    $Sender = validateInput($_POST['Sender'],"Your Name");
    $Email = validateEmail($_POST['Email'],"Your E-mail");
    $Subject = validateInput($_POST['Subject'],"Subject");
    $Message = validateInput($_POST['Message'],"Message");
    if ($errorCount==0)
        $ShowForm = FALSE;
    else
        $ShowForm = TRUE;
}

//Displays message if any field had invalid input, reloads form
if ($ShowForm == TRUE) {
    if ($errorCount>0)
        echo "<p>Please re-enter the form information below.</p>\n";
    displayForm($Sender, $Email, $Subject, $Message);
}
/*
Displays 'Thank you' message if each field has no errors
and successfully sends message,
displays 'Error' message if failed to send message
*/
else {
    $SenderAddress = "$Sender <$Email>";
    $Headers = "From: $SenderAddress\nCC: $SenderAddress\n";

    $result = mail("recipient@example.com", $Subject, $Message, $Headers);

    if ($result)
        echo "<p>Your message has been sent. Thank you, " . $Sender . ".</p>\n";
    else
        echo "<p>There was an error sending your message, " . $Sender . ".</p>\n";
}

/*
REFLECTION:
The main two functions validate user input in each field.
The 'displayForm' function displays the form to the user.
Several if/else statements are here to prevent user
input that may be empty or invalid. There are two buttons
for the user to either 'Send Form' or 'Clear Form,' which
function exactly as described. User data is protected with
the '$_POST' array, which helps to handle sensitive data
like passwords through its non-repeatability. I was a little
confused after submitting the form myself as a test run and
kept receiving an error message within my browser. I genuinely
don't know if I mistyped something or if there's something
wrong with the code since the instructions say not to adjust
anything, so I feel like this could either be improved or
I've made a mistake somewhere, but I understand what the code
is supposed to do after typing it out and adding comments. I
think a copy of the form being sent to the sender is nice to
give the user confirmation that their form was successfully
filled out correctly and submitted in order for the user to
avoid resubmitting sensitive information for no valid reason.
*/

?>
    </body>
</html>
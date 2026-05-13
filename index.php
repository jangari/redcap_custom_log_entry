<div class="projhdr">
    <div style="float:left;">
        <i class="fas fa-clipboard-list"></i> Custom Log Entry
    </div>
    <br><br>
</div>
<p>Use this form to log a custom log entry, which will appear in the logging for this project. This may be useful if you would like to log some custom note for auditing purposes. Examples include explaining why users were suspended, why records were deleted, or why the project was moved to analysis/cleanup mode. In short, automatic logging records <em>what</em> happened; custom log entries can be used to keep a record of <em>why</em> those things happened.</p>
<p>These entries are logged against the current date and time, your username (<?php echo USERID ?>), and with the description "Note". You may also select a record from the dropdown if the entry is associated with a specific record, or choose "Not applicable" if the entry pertains to the project as a whole. Entries linked to a record will be filterable by that record on the Logging page.</p>

<?php
$allowNonLoggingUsers = $module->getProjectSetting('non-logging-user');

// 1. Process Form Submission
if (isset($_POST['logging_note']) && !empty($_POST['logging_note'])) {
    
    $submittedRecord = $_POST['logging_record'];
    $note = $_POST['logging_note'];
    
    // Check if a record was actually selected (it's not empty and not the 'blank' placeholder)
    $hasRecord = (!empty($submittedRecord) && $submittedRecord !== '[blank]');

    if ($hasRecord) {
        $pid = $module->getProjectId(); 
        $recordExists = \Records::recordExists($project_id, $submittedRecord);

        if (!$recordExists) {
            header("Location: " . $module->getUrl("index.php") . "&msg=error");
            exit;
        }
    }

    \REDCap::logEvent("Note", $note, null, ($hasRecord ? $submittedRecord : null));
    header("Location: " . $module->getUrl("index.php") . "&msg=success");
    exit;
}

// 2. Display Status Messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        echo '<div id="status-message" class="darkgreen" style="margin:20px 0;padding:10px;">
                <img src="' . APP_PATH_IMAGES . 'tick.png"> 
                <b>Success:</b> The log entry was recorded successfully.
              </div>';
    } else if ($_GET['msg'] == 'error') {
        echo '<div id="status-message" class="red" style="margin:20px 0;padding:10px;">
                <img src="' . APP_PATH_IMAGES . 'exclamation.png"> 
                <b>Error:</b> The record you entered does not exist in this project.
              </div>';
    }

}

// Define an empty var or two
$logging_record = null;
$logging_note = null;
?>
<form method="post" action="">


<table>
    <tbody>
        <tr>
            <td width='100px'>
<label for="logging_note" style="font-weight: bold; color: #880000;">Note:</label><p style="color: grey; font-style: italic; font-size: 80%;">500 char max</p></td> <td><textarea id="logging_note" name="logging_note" rows="4" cols="60" maxlength="500" style="resize: both; min-width: 443px; min-height: 77px; max-width: 730px; max-height: 400px;"><?php echo $logging_note;?></textarea></td>
        </tr>
         <tr><td style="padding-bottom:10px">
             <label for="logging_record" style="font-weight: bold; color: #880000;">Record:</label>
         </td>
        <td style="padding-bottom:10px"><table><tbody><tr><td>
<?php

print Records::renderRecordListAutocompleteDropdown($project_id, true, 5000, "logging_record", "x-form-text x-form-field", "font-size:11px;", "", " - not applicable - ", "","name='logging_record'");

?>
</td><td style="font-size:11px;color:#666;padding-left:10px;" valign="top">
    Select a record if log entry is associated with existing record
    </td></tr></tbody></table></td>
    </tr>
<td></td>
<td><input type="submit" name="submit" value="Submit" style="font-weight: bold; color: #880000;"></td>  
    </tbody>
    </table>
</form>
<script type="text/javascript">
    $(function() {
        var statusMsg = $('#status-message');
        
        if (statusMsg.length) {
            // 1. Remove "?msg=success" or "&msg=success" from the URL 
            // without refreshing the page
            if (window.history.replaceState) {
                var url = window.location.href;
                // Use regex to strip the msg param
                var cleanUrl = url.replace(/[&?]msg=success/, "").replace(/[&?]msg=error/, "");
                window.history.replaceState({}, document.title, cleanUrl);
            }

            // 2. Wait 3 seconds, then slide up to "disappear" the message
            setTimeout(function() {
                statusMsg.slideUp(500);
            }, 3000);
        }
    });
</script>

<div class="projhdr">
    <div style="float:left;">
        <i class="fas fa-clipboard-list"></i> Custom Log Entry
    </div>
    <br><br>
</div>
<p>Use this form to log a custom log entry, which will appear in the logging for this project. This may be useful if you would like to log some custom note for auditing purposes. Examples include explaining why users were suspended, why records were deleted, or why the project was moved to analysis/cleanup mode. In short, automatic logging records <em>what</em> happened; custom log entries can be used to keep a record of <em>why</em> those things happened.</p>
<p>These entries are logged against the current date and time, your username (<?php echo USERID ?>), and with the description "Note". You may also select a record from the dropdown if the entry is associated with a specific record, or choose "Not applicable" if the entry pertains to the project as a whole. Entries linked to a record will be filterable by that record on the Logging page.</p>

<?php


if (isset($_POST['logging_note'])) {
    REDCap::logEvent("Note", $_POST['logging_note'], $sql = NULL, $record = $_POST['logging_record'], $event = NULL);
}
// Define an empty var or two
$logging_record = "";
$logging_note = "";
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
  <td><input type="submit" name="submit" value="Submit" style="font-weight: bold; color: #880000;"> and go to Logging</td>  
    </tbody>
    </table>
</form>
<?php
if (isset($_POST['logging_note'])) {
    ?>
<script type="text/javascript">
    window.location = "<?php echo APP_PATH_WEBROOT ?>/Logging/index.php?pid=<?php echo $project_id ?>";
</script>
    <?php
};
?>

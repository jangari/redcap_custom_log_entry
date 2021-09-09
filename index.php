<div class="projhdr">
    <div style="float:left;">
        <i class="fas fa-clipboard-list"></i> Custom Log Entry
    </div>
    <br><br>
</div>
<p>Use this form to log a custom log entry, which will appear in the logging for this project. This may be useful if you would like to log some custom note for auditing purposes. Examples include explaining why users were suspended, why records were deleted, or why the project was moved to analysis/cleanup mode. In short, automatic logging records <em>what</em> happened; custom log entries can be used to keep a record of <em>why</em> those things happened.</p>
<p>These entries are logged against the current date and time, your username (<?php echo USERID ?>), and with the description "Custom Log Entry". You may also select a Record ID from the dropdown if the entry pertains to a record, or choose "Not applicable" if the entry pertains to the project as a whole. Entries linked to a Record ID will be filterable by that Record ID on the Logging page.</p>

<?php
// Get the project's Record ID field
$record_id_field = REDCap::getRecordIdField();

// Get the project ID for redirection to logging page later.
$projectVals = Project::getProjectVals();
$project_id = $projectVals["project_id"];

// Export data in array format for all records for only the Record ID field
$data = REDCap::getData('array', null, $record_id_field);

// Since the data was returned as an array with multi-level keys, obtain the record names
// from the 1st-level array keys in $data via array_keys() and place them in a separate array.
$record_names = array_keys($data);

// Display all the record names on the page
/* var_dump($record_names); */

if (isset($_POST['logging_note'])) {
    REDCap::logEvent("Custom Log Entry", $_POST['logging_note'], $sql = NULL, $record = $_POST['logging_record'], $event = NULL);
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
<label for="logging_note" style="font-weight: bold; color: #880000;">Log Entry:</label><p style="color: grey; font-style: italic; font-size: 80%;">500 char max</p></td> <td><textarea id="logging_note" name="logging_note" rows="3" cols="60" maxlength="500" style="resize: vertical;"><?php echo $logging_note;?></textarea></td>
        </tr>
         <tr><td style="padding-bottom:10px">
             <label for="logging_record" style="font-weight: bold; color: #880000;">Record ID:</label>
         </td>
        <td style="padding-bottom:10px"><table><tbody><tr><td><select id="logging_record" name="logging_record" class="x-form-text x-form-field" style="font-size:11px;">
        <option value="">- not applicable -</option>
<?php
foreach ($record_names as $record_name){
    echo "<option value='".$record_name."'>".$record_name."</option>";
};
?>
    </select></td><td style="font-size:11px;color:#666;padding-left:10px;" valign="top">
    Select from drop-down if event is for existing Record ID
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

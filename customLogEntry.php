<?php

namespace INTERSECT\customLogEntry;

use \REDCap as REDCap;
use \Records as Records;

class customLogEntry extends \ExternalModules\AbstractExternalModule {

    function redcap_module_api($action, $payload, $project_id, $user_id, $format, $returnFormat, $csvDelim) {
        if ($action === 'add') {
            return $this->handleApiLogEntry($payload, $user_id, $project_id);
        }
        
        return $this->framework->apiErrorResponse("Action '$action' not found.", 404);
    }

    private function handleApiLogEntry($payload, $user_id, $project_id) {
        $allowNonLoggingUsers = $this->getProjectSetting('non-logging-user');
        $rights = REDCap::getUserRights($user_id);
        $hasLoggingRights = ($rights[$user_id]['data_logging'] == '1');
        $isSuperUser = (defined('SUPER_USER') && SUPER_USER == 1);

        if (!$isSuperUser && !$hasLoggingRights && !$allowNonLoggingUsers) {
            return $this->framework->apiErrorResponse("You do not have permission to add log entries", 403);
        }

        $comment = $payload['comment'] ?? '';
        $record = $payload['record'] ?? null;
        $recordExists = Records::recordExists($project_id, $record);
        if (!empty($record) && !$recordExists) {
            return $this->framework->apiErrorResponse("Record '$record' not found", 404);
        }
        if (empty($comment)) {
            return $this->framework->apiErrorResponse("The 'comment' parameter is required", 400);
        }
        REDCap::logEvent("Note", $comment, $sql = NULL, $record = $record, $event = NULL);
        return "Log entry added successfully" . (!empty($record) ? " for record $record" : "");
    }

    public function redcap_module_link_check_display($project_id, $link) {
        $allowNonLoggingUsers = $this->getProjectSetting('non-logging-user');
        $user_id = USERID;
        $rights = REDCap::getUserRights($user_id);
        $hasLoggingRights = ($rights[$user_id]['data_logging'] == '1');
        $isSuperUser = (defined('SUPER_USER') && SUPER_USER == 1);

        if (!$isSuperUser && !$hasLoggingRights && !$allowNonLoggingUsers) {
            return 0;
        }    
        return $link;
    }

}

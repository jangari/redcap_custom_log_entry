<?php

namespace INTERSECT\customLogEntry;

use \REDCap as REDCap;

class customLogEntry extends \ExternalModules\AbstractExternalModule {

    public function redcap_module_link_check_display($project_id, $link) {
        $this_user = USERID;
        $rights = REDCap::getUserRights($this_user);
        if ($rights[$this_user]['data_logging']){
            return $link;
        } else if (SUPER_USER){
            return $link;
        } else {
            return 0;
        }
    }

}

<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/feeddb.php');
function mobileGetFeed($id, $feedtype, $firstPostDate=null, $lastPostDate=null,$loadBottom=null) {
    if (strlen($id)<1) {
        return null;
    }
    if ($feedtype == "friends") {
        return getFriendsFeed($id, $firstPostDate, $lastPostDate, $loadBottom);
    } else if ($feedtype == "world") {
        return getWorldFeed();//will always be new until changes
    } else {
        return null;
    }
}
?>

<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/controller/includes/helper.php');

function renderSubPage($info,$profposts,$profpicurl) {
    render("profileSubpages/postsSubpage",array("id"=>$info['_id']->{'$id'},"info"=>$info,"profposts"=>$profposts,"profpicurl"=>$profpicurl));
}



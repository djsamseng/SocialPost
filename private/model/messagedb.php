<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/mongodatabase.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/SocialPostCurrent/private/model/picturedb.php');


function createNewMessage($id,$addToMessageId) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    $messageId = new MongoId();
    try {
        if ($id != $addToMessageId) {
        $result = $db->messages->insert(
            array(
                '_id'=>$messageId,
                'users'=>array(new MongoId($id),new MongoId($addToMessageId)),
                'messages'=>array(),
                'loc'=>array()
            ),
            array('w'=>true)
        );
        } else {
        $result = $db->messages->insert(
            array(
                '_id'=>$messageId,
                'users'=>array(new MongoId($id)),
                'messages'=>array(),
                'loc'=>array()
            ),
            array('w'=>true)
        );
        }
    } catch (Exception $e) {
        echo "Error creating new message";
        return null;
    }
    if (!(isset($result) && $result["ok"] == 1)) {
        return null;
    }
    try {//replace this into a single update
        $db->users->update(
            array(
                '_id'=>new MongoId($id)
            ),
            array(
                '$push'=>array(
                    'messages'=>$messageId
                )
            )
        );
        if ($id != $addToMessageId) {
        $db->users->update(
            array(
                '_id'=>new MongoId($addToMessageId)
            ),
            array(
                '$push'=>array(
                    'messages'=>$messageId
                )
            )
        );
        }
    } catch (Exception $e) {
        echo "error adding conversation id to users";
        return null;
    }
    return $messageId;
}

function addIdToMessage($id,$messageId,$addToMessageId) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    try {
        $result = $db->messages->update(
            array(
                '_id'=>new MongoId($messageId),
                'users'=>new MongoId($id),
                'users'=>array('$ne'=>new MongoId($addToMessageId))
            ),
            array(
                '$push'=>array(
                    'users'=>new MongoId($addToMessageId)
                )
            )
        );
    } catch (Exception $e) {
        echo "Error adding users to conversation";
        return false;
    }
    try {
        $result = $db->users->update(
            array(
                '_id'=>new MongoId($addToMessageId)
            ),
            array(
                '$push'=>array(
                    'messages'=>new MongoId($messageId)
                )
            )
        );
    } catch (Exception $e) {
        echo "Error adding conversation to user";
        return false;
    }               
    return true;
}

function getUserMessageData($id) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    try {
        $results=$db->users->findOne(
            array(
                '_id'=>new MongoId($id)
            ),
            array(
                'messages'=>1
            )
        );
    } catch (Exception $e) {
        echo "error getting user messages";
    }
    $limit = count($results['messages']);
    $final = array();
    try {
        for ($i=0;$i<$limit;$i++) {
            $final[$i]=$db->messages->findOne(//change to aggregate to only get 1 message per conversation
                array(
                    '_id'=>$results['messages'][$i]
                )
            );
            for ($j=0;$j<count($final[$i]['users']);$j++) {
                $final[$i]['users'][$j]=getProfileInfo($id,$final[$i]['users'][$j]->{'$id'});
                $final[$i]['users'][$j]['profPicUrl']=getProfilePictures($id,$final[$i]['users'][$j]['_id']->{'$id'});
            }
        }
    } catch (Exception $e) {
        echo "error getting message details";
        print_r($e);
        return null;
    }
    return $final;
}

function addMessage($messageId,$id,$text,$expiration) {
    $db = connect();
    if ($db == null) {
        return false;
    }
    date_default_timezone_set('EST');
    if ($expiration == "") {    
        $expiration = new MongoDate(strtotime("2114-01-01 00:00:00"));
    } else {
        $expiration = new MongoDate($expiration);
    }
    try {
        $db->messages->update(
            array(
                '_id'=>new MongoId($messageId),
                'users'=>new MongoId($id)
            ),
            array(
                '$push'=>array(
                    'messages'=>array(
                        'userId'=>new MongoId($id),
                        'text'=>$text,
                        'date'=>new MongoDate(),
                        'expiration'=>$expiration
                    )
                )
            )
        );
    } catch (Exception $e) {
        echo "error adding message to conversation";
        return false;
    }
    return true;
}

function getMessage($messageId,$id,$limit=20) {
    $db = connect();
    if ($db == null) {
        return null;
    }
    try {
        $result = $db->messages->aggregate(
            array(
                array(
                    '$match'=>array(
                        '_id'=>new MongoId($messageId),
                        'users'=>new MongoId($id)
                    )
                ),
                array(
                    '$unwind'=>'$messages'
                ),
                array(
                    '$match'=>array(
                        'messages.expiration'=>array(
                            '$gte'=>new MongoDate()
                        )
                    )
                ),
                array(
                    '$sort'=>array(
                        'messages.date'=>1
                    )
                ),
                array(
                    '$limit'=>$limit
                )
            )
        );
    } catch (Exception $e) {
        echo "Error getting conversation";
        return null;
    }
    for ($i=0;$i<count($result['result']);$i++) {
        $info = getProfileInfo($id, $result['result'][$i]['messages']['userId']->{'$id'});
        $prof = getProfilePictures($id, $result['result'][$i]['messages']['userId']->{'$id'});
        $result['result'][$i]['messages']['firstname'] = $info['firstname'];
        $result['result'][$i]['messages']['lastname'] = $info['lastname'];
        $result['result'][$i]['messages']['profPicUrl'] = "../private/model/pictures/".$result['result'][$i]['messages']['userId']->{'$id'}."/profilepictures/".$prof;
    }
    //print_r($result['result'][0]['messages']);
    return $result['result'];
}

?>



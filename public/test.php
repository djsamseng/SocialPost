<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once('../../AWSSDKforPHP/sdk.class.php');
require('../../AWSSDKforPHP/aws/aws-autoloader.php');
use Aws\DynamoDb\DynamoDbClient;
use Aws\Common\Enum\Region;
use Aws\DynamoDb\Enum\KeyType;
use Aws\DynamoDb\Enum\Type;
use Aws\DynamoDb\Enum\ComparisonOperator;

$aws = Aws\Common\Aws::factory("./config.php");
$client = $aws->get("dynamodb");

$fourteenDaysAgo = date("Y-m-d H:i:s", strtotime("-14 days"));

$response = $client->query(array(
    "TableName" => "Reply",
    "KeyConditions" => array(
        "Id" => array(
            "ComparisonOperator" => ComparisonOperator::EQ,
            "AttributeValueList" => array(
                array(Type::STRING => "Amazon DynamoDB#DynamoDB Thread 2")
            )
	),
        "ReplyDateTime" => array(
            "ComparisonOperator" => ComparisonOperator::GE, 
            "AttributeValueList" => array(
                array(Type::STRING => $fourteenDaysAgo)
            )
        )
    )	
 ));

print_r ($response['Items']);

?>

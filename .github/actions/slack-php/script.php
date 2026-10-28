<?php
/*
 * GitHub Actions automatically sets the GITHUB_* environment variables shown below.
 * Their values are provided by the runner, so this action does not need to define
 * variables such as GITHUB_REPOSITORY, GITHUB_EVENT_NAME, GITHUB_REF, or GITHUB_SHA.
 * Examples: GITHUB_REPOSITORY contains "owner/repository", while GITHUB_SHA contains
 * the commit SHA that started the workflow.
 *
 * Inputs declared in action.yaml are also made available as environment variables.
 * GitHub converts the input name to uppercase and prefixes it with INPUT_. For
 * example, the action input "message" becomes INPUT_MESSAGE and "slack_webhook"
 * becomes INPUT_SLACK_WEBHOOK. The action must declare each input before GitHub
 * exposes it to the Docker container.
 */
require_once 'vendor/rmccue/requests/src/Autoload.php';
WpOrg\Requests\Autoload::register();


echo "::debug::Sending a request to slack\n";

$response =  WpOrg\Requests\Requests::post(
  $_ENV['INPUT_SLACK_WEBHOOK'],
  array(
    'Content-Type' => 'application/json'
  ),
  json_encode(array (
    'blocks' => 
        array (
            array (
                "type" => "section",
                "text" => array (
                    "type" => "mrkdwn",
                    "text" => $_ENV["INPUT_MESSAGE"],
                ),
            ),
            array (
                "type" => "section",
                "fields" => array (
                    array (
                        "type" => "mrkdwn",
                        // Concatenate the Slack label and GitHub value with PHP's dot operator (.).
                        // This avoids placing an array expression inside a double-quoted string,
                        // which can make the intended variable interpolation ambiguous or invalid.
                        "text" => "*Repository:*\n" . $_ENV['GITHUB_REPOSITORY'],
                    ),
                    array (
                        "type" => "mrkdwn",
                        "text" => "*Event:*\n" . $_ENV['GITHUB_EVENT_NAME'],
                    ),
                    array (
                        "type" => "mrkdwn",
                        "text" => "*Ref:*\n" . $_ENV['GITHUB_REF'],
                    ),
                    array (
                        "type" => "mrkdwn",
                        "text" => "*SHA:*\n" . $_ENV['GITHUB_SHA'],
                    ),
                ),
            ),
        ),
))
);

echo "::group::Slack Response\n";
var_dump($response);
echo "::endgroup::\n";

if(!$response->success) {
  echo $response->body;
  exit(1);
}
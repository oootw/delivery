# IIKO\NotificationsApi

Notifications API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1NotificationsSendPost()**](NotificationsApi.md#api1NotificationsSendPost) | **POST** /api/1/notifications/send | Send notification to external systems. |


## `api1NotificationsSendPost()`

```php
api1NotificationsSendPost($authorization, $timeout, $iiko_transport_public_api_contracts_notifications_send_notification_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Send notification to external systems.

> Restriction group: `Notifications`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\NotificationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_notifications_send_notification_request = new \IIKO\Model\IikoTransportPublicApiContractsNotificationsSendNotificationRequest(); // \IIKO\Model\IikoTransportPublicApiContractsNotificationsSendNotificationRequest

try {
    $result = $apiInstance->api1NotificationsSendPost($authorization, $timeout, $iiko_transport_public_api_contracts_notifications_send_notification_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling NotificationsApi->api1NotificationsSendPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_notifications_send_notification_request** | [**\IIKO\Model\IikoTransportPublicApiContractsNotificationsSendNotificationRequest**](../Model/IikoTransportPublicApiContractsNotificationsSendNotificationRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse**](../Model/IikoTransportPublicApiContractsCommonCorrelationIdResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

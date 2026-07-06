# IIKO\MessagesApi

Loyalty systems API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1LoyaltyIikoCheckSmsSendingPossibilityPost()**](MessagesApi.md#api1LoyaltyIikoCheckSmsSendingPossibilityPost) | **POST** /api/1/loyalty/iiko/check_sms_sending_possibility | Check sms sending possibility. |
| [**api1LoyaltyIikoCheckSmsStatusPost()**](MessagesApi.md#api1LoyaltyIikoCheckSmsStatusPost) | **POST** /api/1/loyalty/iiko/check_sms_status | Check SMS status. |
| [**api1LoyaltyIikoMessageSendEmailPost()**](MessagesApi.md#api1LoyaltyIikoMessageSendEmailPost) | **POST** /api/1/loyalty/iiko/message/send_email | Send email. |
| [**api1LoyaltyIikoMessageSendSmsPost()**](MessagesApi.md#api1LoyaltyIikoMessageSendSmsPost) | **POST** /api/1/loyalty/iiko/message/send_sms | Send sms. |


## `api1LoyaltyIikoCheckSmsSendingPossibilityPost()`

```php
api1LoyaltyIikoCheckSmsSendingPossibilityPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSmsSendingPossibilityResponse
```

Check sms sending possibility.

Check sms sending possibility before send sms message.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MessagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCheckSmsSendingPossibilityPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MessagesApi->api1LoyaltyIikoCheckSmsSendingPossibilityPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSmsSendingPossibilityResponse**](../Model/IikoNetServiceContractsApiIikoTransportNotificationSmsSendingPossibilityResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCheckSmsStatusPost()`

```php
api1LoyaltyIikoCheckSmsStatusPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_notification_check_sms_status_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusResponse
```

Check SMS status.

Check the status of sending SMS messages.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MessagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_notification_check_sms_status_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCheckSmsStatusPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_notification_check_sms_status_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MessagesApi->api1LoyaltyIikoCheckSmsStatusPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_notification_check_sms_status_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusRequest**](../Model/IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusResponse**](../Model/IikoNetServiceContractsApiIikoTransportNotificationCheckSmsStatusResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoMessageSendEmailPost()`

```php
api1LoyaltyIikoMessageSendEmailPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_notification_send_email_request): object
```

Send email.

Send email message to specified email address. Sending proceed according iikoCard organization's settings.   > Restriction group: `Loyalty: messages`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MessagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_notification_send_email_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendEmailRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendEmailRequest

try {
    $result = $apiInstance->api1LoyaltyIikoMessageSendEmailPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_notification_send_email_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MessagesApi->api1LoyaltyIikoMessageSendEmailPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_notification_send_email_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendEmailRequest**](../Model/IikoNetServiceContractsApiIikoTransportNotificationSendEmailRequest.md)|  | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoMessageSendSmsPost()`

```php
api1LoyaltyIikoMessageSendSmsPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_notification_send_sms_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendSmsResponse
```

Send sms.

Send sms message to specified phone number. Sending proceed according iikoCard organization's settings.   > Restriction group: `Loyalty: messages`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MessagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_notification_send_sms_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendSmsRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendSmsRequest

try {
    $result = $apiInstance->api1LoyaltyIikoMessageSendSmsPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_notification_send_sms_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MessagesApi->api1LoyaltyIikoMessageSendSmsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_notification_send_sms_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendSmsRequest**](../Model/IikoNetServiceContractsApiIikoTransportNotificationSendSmsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportNotificationSendSmsResponse**](../Model/IikoNetServiceContractsApiIikoTransportNotificationSendSmsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

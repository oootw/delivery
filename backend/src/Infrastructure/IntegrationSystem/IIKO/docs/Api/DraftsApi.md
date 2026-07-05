# IIKO\DraftsApi

Drafts API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1DeliveriesDraftsByFilterPost()**](DraftsApi.md#api1DeliveriesDraftsByFilterPost) | **POST** /api/1/deliveries/drafts/by_filter | Retrieve order drafts list by parameters. |
| [**api1DeliveriesDraftsByIdPost()**](DraftsApi.md#api1DeliveriesDraftsByIdPost) | **POST** /api/1/deliveries/drafts/by_id | Retrieve order draft by ID. |
| [**api1DeliveriesDraftsCommitPost()**](DraftsApi.md#api1DeliveriesDraftsCommitPost) | **POST** /api/1/deliveries/drafts/commit | Admit order draft changes and send them to Front. |
| [**api1DeliveriesDraftsCreatePost()**](DraftsApi.md#api1DeliveriesDraftsCreatePost) | **POST** /api/1/deliveries/drafts/create | Create delivery order draft. |
| [**api1DeliveriesDraftsDeletePost()**](DraftsApi.md#api1DeliveriesDraftsDeletePost) | **POST** /api/1/deliveries/drafts/delete | Delete order draft. |
| [**api1DeliveriesDraftsLockPost()**](DraftsApi.md#api1DeliveriesDraftsLockPost) | **POST** /api/1/deliveries/drafts/lock | Lock order draft. |
| [**api1DeliveriesDraftsSavePost()**](DraftsApi.md#api1DeliveriesDraftsSavePost) | **POST** /api/1/deliveries/drafts/save | Update existing delivery order draft. |
| [**api1DeliveriesDraftsUnlockPost()**](DraftsApi.md#api1DeliveriesDraftsUnlockPost) | **POST** /api/1/deliveries/drafts/unlock | Unlock order draft. |


## `api1DeliveriesDraftsByFilterPost()`

```php
api1DeliveriesDraftsByFilterPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_filter_drafts_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsResponse
```

Retrieve order drafts list by parameters.

> Restriction group: `Drafts: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_filter_drafts_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsByFilterPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_filter_drafts_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsByFilterPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_filter_drafts_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsResponse**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsFilterDraftsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesDraftsByIdPost()`

```php
api1DeliveriesDraftsByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsGetDraftResponse
```

Retrieve order draft by ID.

> Restriction group: `Drafts: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsByIdPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsGetDraftResponse**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsGetDraftResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesDraftsCommitPost()`

```php
api1DeliveriesDraftsCommitPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_commit_draft_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderResponse
```

Admit order draft changes and send them to Front.

> Restriction group: `Drafts: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_commit_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCommitDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCommitDraftRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsCommitPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_commit_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsCommitPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_commit_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCommitDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsCommitDraftRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrderResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesDraftsCreatePost()`

```php
api1DeliveriesDraftsCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_create_draft_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse
```

Create delivery order draft.

> Restriction group: `Drafts: creating`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_create_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCreateDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCreateDraftRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_create_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_create_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCreateDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsCreateDraftRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesDraftsDeletePost()`

```php
api1DeliveriesDraftsDeletePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Delete order draft.

> Restriction group: `Drafts: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsDeletePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsDeletePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest.md)|  | [optional] |

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

## `api1DeliveriesDraftsLockPost()`

```php
api1DeliveriesDraftsLockPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Lock order draft.

> Restriction group: `Drafts: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsLockPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsLockPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest.md)|  | [optional] |

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

## `api1DeliveriesDraftsSavePost()`

```php
api1DeliveriesDraftsSavePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_save_draft_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse
```

Update existing delivery order draft.

> Restriction group: `Drafts: creating`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_save_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsSaveDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsSaveDraftRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsSavePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_save_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsSavePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_save_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsSaveDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsSaveDraftRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsCreateOrSaveDraftResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesDraftsUnlockPost()`

```php
api1DeliveriesDraftsUnlockPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Unlock order draft.

> Restriction group: `Drafts: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DraftsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest

try {
    $result = $apiInstance->api1DeliveriesDraftsUnlockPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DraftsApi->api1DeliveriesDraftsUnlockPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest.md)|  | [optional] |

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

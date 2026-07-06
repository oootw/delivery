# IIKO\OrganizationsApi

Organizations API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1OrganizationsPost()**](OrganizationsApi.md#api1OrganizationsPost) | **POST** /api/1/organizations | Returns organizations available to api-login user. |
| [**api1OrganizationsSettingsPost()**](OrganizationsApi.md#api1OrganizationsSettingsPost) | **POST** /api/1/organizations/settings | Returns available to api-login user organizations specified settings. |


## `api1OrganizationsPost()`

```php
api1OrganizationsPost($authorization, $timeout, $iiko_transport_public_api_contracts_organizations_get_organizations_request): \IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse
```

Returns organizations available to api-login user.

> Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrganizationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_organizations_get_organizations_request = new \IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest

try {
    $result = $apiInstance->api1OrganizationsPost($authorization, $timeout, $iiko_transport_public_api_contracts_organizations_get_organizations_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrganizationsApi->api1OrganizationsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_organizations_get_organizations_request** | [**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest**](../Model/IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse**](../Model/IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1OrganizationsSettingsPost()`

```php
api1OrganizationsSettingsPost($authorization, $timeout, $iiko_transport_public_api_contracts_organizations_organizations_settings_request): \IIKO\Model\IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsResponse
```

Returns available to api-login user organizations specified settings.

> Restriction group: `Organizations: settings`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrganizationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_organizations_organizations_settings_request = new \IIKO\Model\IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsRequest

try {
    $result = $apiInstance->api1OrganizationsSettingsPost($authorization, $timeout, $iiko_transport_public_api_contracts_organizations_organizations_settings_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrganizationsApi->api1OrganizationsSettingsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_organizations_organizations_settings_request** | [**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsRequest**](../Model/IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsResponse**](../Model/IikoTransportPublicApiContractsOrganizationsOrganizationsSettingsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

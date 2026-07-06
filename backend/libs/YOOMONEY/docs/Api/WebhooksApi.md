# YOOMONEY\WebhooksApi

Аутентификация только по OAuth-токену. Доступно в рамках API для партнеров: https://yookassa.ru/developers/solutions-for-platforms/partners-api/basics Webhook — это механизм автоматического оповещения вашей системы о событиях, которые происходят с созданными объектами. Например, ЮKassa может сообщить, когда объект платежа: https://yookassa.ru/developers/api#payment_object, созданный в вашем приложении, перейдет в статус waiting_for_capture. С помощью API вы можете настроить webhook (создать, удалить, просмотреть список созданных) для переданного OAuth-токена. Подробнее об уведомлениях API ЮKassa: https://yookassa.ru/developers/using-api/webhooks

All URIs are relative to https://api.yookassa.ru/v3, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**webhooksGet()**](WebhooksApi.md#webhooksGet) | **GET** /webhooks | Список созданных webhook |
| [**webhooksPost()**](WebhooksApi.md#webhooksPost) | **POST** /webhooks | Создание webhook |
| [**webhooksWebhookIdDelete()**](WebhooksApi.md#webhooksWebhookIdDelete) | **DELETE** /webhooks/{webhook_id} | Удаление webhook |


## `webhooksGet()`

```php
webhooksGet(): \YOOMONEY\Model\WebhookList
```

Список созданных webhook

Запрос позволяет узнать, какие webhook есть для переданного OAuth-токена.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2
$config = YOOMONEY\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure HTTP basic authorization: BasicAuth
$config = YOOMONEY\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new YOOMONEY\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->webhooksGet();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\YOOMONEY\Model\WebhookList**](../Model/WebhookList.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksPost()`

```php
webhooksPost($idempotence_key, $create_webhook_request): \YOOMONEY\Model\Webhook
```

Создание webhook

Запрос позволяет подписаться на уведомления о событиях: https://yookassa.ru/developers/using-api/webhooks#events (например, переход платежа в статус succeeded). C помощью webhook можно подписаться только на события платежей и возвратов. Если вы хотите получать уведомления о нескольких событиях, вам нужно для каждого из них создать свой webhook. Для каждого OAuth-токена нужно создавать свой набор webhook.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2
$config = YOOMONEY\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure HTTP basic authorization: BasicAuth
$config = YOOMONEY\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new YOOMONEY\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$create_webhook_request = new \YOOMONEY\Model\CreateWebhookRequest(); // \YOOMONEY\Model\CreateWebhookRequest

try {
    $result = $apiInstance->webhooksPost($idempotence_key, $create_webhook_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **create_webhook_request** | [**\YOOMONEY\Model\CreateWebhookRequest**](../Model/CreateWebhookRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\Webhook**](../Model/Webhook.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `webhooksWebhookIdDelete()`

```php
webhooksWebhookIdDelete($webhook_id): object
```

Удаление webhook

Запрос позволяет отписаться от уведомлений о событии для переданного OAuth-токена. Чтобы удалить webhook, вам нужно передать в запросе его идентификатор.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure OAuth2 access token for authorization: OAuth2
$config = YOOMONEY\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

// Configure HTTP basic authorization: BasicAuth
$config = YOOMONEY\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new YOOMONEY\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$webhook_id = '1da5c87d-0984-50e8-a7f3-8de646dd9ec9'; // string | Идентификатор webhook-a.

try {
    $result = $apiInstance->webhooksWebhookIdDelete($webhook_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->webhooksWebhookIdDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **webhook_id** | **string**| Идентификатор webhook-a. | [default to &#39;1da5c87d-0984-50e8-a7f3-8de646dd9ec9&#39;] |

### Return type

**object**

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

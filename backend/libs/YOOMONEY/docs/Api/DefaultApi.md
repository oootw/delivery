# YOOMONEY\DefaultApi



All URIs are relative to https://api.yookassa.ru/v3, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**dealsDealIdGet()**](DefaultApi.md#dealsDealIdGet) | **GET** /deals/{deal_id} | Информация о сделке |
| [**dealsGet()**](DefaultApi.md#dealsGet) | **GET** /deals | Список сделок |
| [**dealsPost()**](DefaultApi.md#dealsPost) | **POST** /deals | Создание сделки |
| [**invoicesInvoiceIdGet()**](DefaultApi.md#invoicesInvoiceIdGet) | **GET** /invoices/{invoice_id} | Информация о счете |
| [**invoicesPost()**](DefaultApi.md#invoicesPost) | **POST** /invoices | Создание счета |
| [**meGet()**](DefaultApi.md#meGet) | **GET** /me | Информация о настройках магазина или шлюза |
| [**paymentMethodsPaymentMethodIdGet()**](DefaultApi.md#paymentMethodsPaymentMethodIdGet) | **GET** /payment_methods/{payment_method_id} | Информация о способе оплаты |
| [**paymentMethodsPost()**](DefaultApi.md#paymentMethodsPost) | **POST** /payment_methods | Создание способа оплаты |
| [**payoutsGet()**](DefaultApi.md#payoutsGet) | **GET** /payouts | List of payouts |
| [**payoutsPayoutIdGet()**](DefaultApi.md#payoutsPayoutIdGet) | **GET** /payouts/{payout_id} | Информация о выплате |
| [**payoutsPost()**](DefaultApi.md#payoutsPost) | **POST** /payouts | Создание выплаты |
| [**payoutsSearchGet()**](DefaultApi.md#payoutsSearchGet) | **GET** /payouts/search | Search for payouts |
| [**personalDataPersonalDataIdGet()**](DefaultApi.md#personalDataPersonalDataIdGet) | **GET** /personal_data/{personal_data_id} | Информация о персональных данных |
| [**personalDataPost()**](DefaultApi.md#personalDataPost) | **POST** /personal_data | Создание персональных данных |
| [**posLinksPosLinkIdActivatePost()**](DefaultApi.md#posLinksPosLinkIdActivatePost) | **POST** /pos_links/{pos_link_id}/activate | Активация ранее деактивированной кассовой ссылки |
| [**posLinksPosLinkIdDeactivatePost()**](DefaultApi.md#posLinksPosLinkIdDeactivatePost) | **POST** /pos_links/{pos_link_id}/deactivate | Деактивация кассовой ссылки |
| [**posLinksPosLinkIdGet()**](DefaultApi.md#posLinksPosLinkIdGet) | **GET** /pos_links/{pos_link_id} | Информация о кассовой ссылке |
| [**posLinksPosLinkIdRecipientPost()**](DefaultApi.md#posLinksPosLinkIdRecipientPost) | **POST** /pos_links/{pos_link_id}/recipient | Изменение торговой точки, привязанной к кассовой ссылке |
| [**posLinksPost()**](DefaultApi.md#posLinksPost) | **POST** /pos_links | Активация кассовой ссылки |
| [**receiptsGet()**](DefaultApi.md#receiptsGet) | **GET** /receipts | Список чеков |
| [**receiptsPost()**](DefaultApi.md#receiptsPost) | **POST** /receipts | Создание чека |
| [**receiptsReceiptIdGet()**](DefaultApi.md#receiptsReceiptIdGet) | **GET** /receipts/{receipt_id} | Информация о чеке |
| [**refundsGet()**](DefaultApi.md#refundsGet) | **GET** /refunds | Список возвратов |
| [**refundsPost()**](DefaultApi.md#refundsPost) | **POST** /refunds | Создание возврата |
| [**refundsRefundIdGet()**](DefaultApi.md#refundsRefundIdGet) | **GET** /refunds/{refund_id} | Информация о возврате |
| [**sbpBanksGet()**](DefaultApi.md#sbpBanksGet) | **GET** /sbp_banks | Список участников СБП |


## `dealsDealIdGet()`

```php
dealsDealIdGet($deal_id): \YOOMONEY\Model\SafeDeal
```

Информация о сделке

Запрос позволяет получить информацию о текущем состоянии сделки по ее уникальному идентификатору.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$deal_id = 'deal_id_example'; // string

try {
    $result = $apiInstance->dealsDealIdGet($deal_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dealsDealIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **deal_id** | **string**|  | |

### Return type

[**\YOOMONEY\Model\SafeDeal**](../Model/SafeDeal.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `dealsGet()`

```php
dealsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $expires_at_gte, $expires_at_gt, $expires_at_lte, $expires_at_lt, $status, $full_text_search, $limit, $cursor): \YOOMONEY\Model\DealList
```

Список сделок

Запрос позволяет получить список сделок, отфильтрованный по заданным критериям. Подробнее о работе со списками: https://yookassa.ru/developers/using-api/lists

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$created_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte=2018-07-18T10:51:18.139Z
$created_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt=2018-07-18T10:51:18.139Z
$created_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte=2018-07-18T10:51:18.139Z
$created_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt=2018-07-18T10:51:18.139Z
$expires_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени автоматического закрытия сделки: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.gte=2018-07-18T10:51:18.139Z
$expires_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени автоматического закрытия сделки: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.gt=2018-07-18T10:51:18.139Z
$expires_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени автоматического закрытия сделки: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.lte=2018-07-18T10:51:18.139Z
$expires_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени автоматического закрытия сделки: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.lt=2018-07-18T10:51:18.139Z
$status = new \YOOMONEY\Model\\YOOMONEY\Model\DealStatus(); // \YOOMONEY\Model\DealStatus | Фильтр по статусу сделки. Пример: status=closed
$full_text_search = 'full_text_search_example'; // string | Фильтр по описанию сделки — параметру description (например, идентификатор сделки на стороне вашей интернет-площадки в ЮKassa, идентификатор покупателя или продавца). От 4 до 128 символов. Пример: 123554642-2432FF344R
$limit = 10; // int | Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit=50 Значение по умолчанию: 10
$cursor = 'cursor_example'; // string | Указатель на следующий фрагмент списка. Пример: cursor=37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination

try {
    $result = $apiInstance->dealsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $expires_at_gte, $expires_at_gt, $expires_at_lte, $expires_at_lt, $status, $full_text_search, $limit, $cursor);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dealsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **created_at_gte** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_gt** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lte** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lt** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **expires_at_gte** | **\DateTime**| Фильтр по времени автоматического закрытия сделки: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **expires_at_gt** | **\DateTime**| Фильтр по времени автоматического закрытия сделки: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **expires_at_lte** | **\DateTime**| Фильтр по времени автоматического закрытия сделки: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **expires_at_lt** | **\DateTime**| Фильтр по времени автоматического закрытия сделки: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: expires_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **status** | [**\YOOMONEY\Model\DealStatus**](../Model/.md)| Фильтр по статусу сделки. Пример: status&#x3D;closed | [optional] |
| **full_text_search** | **string**| Фильтр по описанию сделки — параметру description (например, идентификатор сделки на стороне вашей интернет-площадки в ЮKassa, идентификатор покупателя или продавца). От 4 до 128 символов. Пример: 123554642-2432FF344R | [optional] |
| **limit** | **int**| Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit&#x3D;50 Значение по умолчанию: 10 | [optional] [default to 10] |
| **cursor** | **string**| Указатель на следующий фрагмент списка. Пример: cursor&#x3D;37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination | [optional] |

### Return type

[**\YOOMONEY\Model\DealList**](../Model/DealList.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `dealsPost()`

```php
dealsPost($idempotence_key, $safe_deal_request): \YOOMONEY\Model\SafeDeal
```

Создание сделки

Запрос позволяет создать сделку, в рамках которой необходимо принять оплату от покупателя и перечислить ее продавцу.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$safe_deal_request = new \YOOMONEY\Model\SafeDealRequest(); // \YOOMONEY\Model\SafeDealRequest

try {
    $result = $apiInstance->dealsPost($idempotence_key, $safe_deal_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dealsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **safe_deal_request** | [**\YOOMONEY\Model\SafeDealRequest**](../Model/SafeDealRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\SafeDeal**](../Model/SafeDeal.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `invoicesInvoiceIdGet()`

```php
invoicesInvoiceIdGet($invoice_id): \YOOMONEY\Model\Invoice
```

Информация о счете

Используйте этот запрос, чтобы получить информацию о текущем состоянии счета по его уникальному идентификатору.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: BasicAuth
$config = YOOMONEY\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$invoice_id = 'in-e44e8088-bd73-43b1-959a-954f3a7d0c54?>'; // string | Invoice ID in YooMoney.

try {
    $result = $apiInstance->invoicesInvoiceIdGet($invoice_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->invoicesInvoiceIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **invoice_id** | **string**| Invoice ID in YooMoney. | [default to &#39;in-e44e8088-bd73-43b1-959a-954f3a7d0c54?&gt;&#39;] |

### Return type

[**\YOOMONEY\Model\Invoice**](../Model/Invoice.md)

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `invoicesPost()`

```php
invoicesPost($idempotence_key, $create_invoice_request): \YOOMONEY\Model\Invoice
```

Создание счета

Используйте этот запрос, чтобы создать в ЮKassa объект счета: https://yookassa.ru/developers/api#invoice_object. В запросе необходимо передать данные о заказе, которые отобразятся на странице счета, и данные для проведения платежа.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: BasicAuth
$config = YOOMONEY\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$create_invoice_request = new \YOOMONEY\Model\CreateInvoiceRequest(); // \YOOMONEY\Model\CreateInvoiceRequest

try {
    $result = $apiInstance->invoicesPost($idempotence_key, $create_invoice_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->invoicesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **create_invoice_request** | [**\YOOMONEY\Model\CreateInvoiceRequest**](../Model/CreateInvoiceRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\Invoice**](../Model/Invoice.md)

### Authorization

[BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `meGet()`

```php
meGet($on_behalf_of): \YOOMONEY\Model\Me
```

Информация о настройках магазина или шлюза

С помощью этого запроса вы можете получить информацию о магазине или шлюзе: * Для Сплитования платежей: https://yookassa.ru/developers/solutions-for-platforms/split-payments/basics: в запросе необходимо передать параметр on_behalf_of с идентификатором магазина продавца и ваши данные для аутентификации: https://yookassa.ru/developers/using-api/interaction-format#auth (идентификатор и секретный ключ вашей платформы). * Для партнеров: https://yookassa.ru/developers/solutions-for-platforms/partners-api/basics: в запросе необходимо передать OAuth-токен магазина. * Для выплат: https://yookassa.ru/developers/payouts/overview: в запросе необходимо передать ваши данные для аутентификации: https://yookassa.ru/developers/using-api/interaction-format#auth (идентификатор и секретный ключ вашего шлюза).

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$on_behalf_of = 'on_behalf_of_example'; // string | Только для тех, кто использует Сплитование платежей: https://yookassa.ru/developers/solutions-for-platforms/split-payments/basics. Идентификатор магазина продавца, подключенного к вашей платформе, информацию о котором вы хотите узнать.

try {
    $result = $apiInstance->meGet($on_behalf_of);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->meGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **on_behalf_of** | **string**| Только для тех, кто использует Сплитование платежей: https://yookassa.ru/developers/solutions-for-platforms/split-payments/basics. Идентификатор магазина продавца, подключенного к вашей платформе, информацию о котором вы хотите узнать. | [optional] |

### Return type

[**\YOOMONEY\Model\Me**](../Model/Me.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `paymentMethodsPaymentMethodIdGet()`

```php
paymentMethodsPaymentMethodIdGet($payment_method_id): \YOOMONEY\Model\PaymentMethodsPost200Response
```

Информация о способе оплаты

Используйте этот запрос, чтобы получить информацию о текущем состоянии способа оплаты по его уникальному идентификатору.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payment_method_id = 'payment_method_id_example'; // string | Идентификатор сохраненного способа оплаты.

try {
    $result = $apiInstance->paymentMethodsPaymentMethodIdGet($payment_method_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->paymentMethodsPaymentMethodIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **payment_method_id** | **string**| Идентификатор сохраненного способа оплаты. | |

### Return type

[**\YOOMONEY\Model\PaymentMethodsPost200Response**](../Model/PaymentMethodsPost200Response.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `paymentMethodsPost()`

```php
paymentMethodsPost($idempotence_key, $payment_methods_post_request): \YOOMONEY\Model\PaymentMethodsPost200Response
```

Создание способа оплаты

Используйте этот запрос, чтобы создать в ЮKassa объект способа оплаты: https://yookassa.ru/developers/api#payment_method_object. В запросе необходимо передать код способа оплаты, который вы хотите сохранить, и при необходимости дополнительные параметры, связанные с той функциональностью, которую вы хотите использовать. Идентификатор созданного способа оплаты вы можете использовать при проведении автоплатежей: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/create-recurring или выплат: https://yookassa.ru/developers/payouts/scenario-extensions/multipurpose-token.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$payment_methods_post_request = new \YOOMONEY\Model\PaymentMethodsPostRequest(); // \YOOMONEY\Model\PaymentMethodsPostRequest

try {
    $result = $apiInstance->paymentMethodsPost($idempotence_key, $payment_methods_post_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->paymentMethodsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **payment_methods_post_request** | [**\YOOMONEY\Model\PaymentMethodsPostRequest**](../Model/PaymentMethodsPostRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\PaymentMethodsPost200Response**](../Model/PaymentMethodsPost200Response.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `payoutsGet()`

```php
payoutsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $succeeded_at_gte, $succeeded_at_gt, $succeeded_at_lte, $succeeded_at_lt, $payout_destination_type, $status, $limit, $cursor): \YOOMONEY\Model\PayoutsList
```

List of payouts

Use this request to get a list of payouts. You can download payments created over the last 3 years. You can filter the list by specified criteria. Request authentication details: https://yookassa.ru/developers/using-api/interaction-format#auth depend on which payment solution you are using: basic payouts: https://yookassa.ru/developers/payouts/overview or payouts within the Safe Deal: https://yookassa.ru/developers/solutions-for-platforms/safe-deal/basics. More about working with lists: https://yookassa.ru/developers/using-api/lists

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$created_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte=2018-07-18T10:51:18.139Z
$created_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt=2018-07-18T10:51:18.139Z
$created_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte=2018-07-18T10:51:18.139Z
$created_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt=2018-07-18T10:51:18.139Z
$succeeded_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of a successful payout processing: time must be greater than the specified value or equal (\"from a certain moment inclusive\"). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.gte=2018-07-18T10:51:18.139Z
$succeeded_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of a successful payout processing: time must be greater than the specified value (\"from a certain moment exclusive\"). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.gt=2018-07-18T10:51:18.139Z
$succeeded_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of a successful payout processing: time must be less than the specified value or equal (\"until a certain moment inclusive\"). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.lte=2018-07-18T10:51:18.139Z
$succeeded_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of a successful payout processing: time must be less than the specified value (\"until a certain moment exclusive\"). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.lt=2018-07-18T10:51:18.139Z
$payout_destination_type = new \YOOMONEY\Model\\YOOMONEY\Model\PayoutDestinationDataType(); // \YOOMONEY\Model\PayoutDestinationDataType | Filter by the method of receiving the payout: https://yookassa.ru/developers/payouts/getting-started/payout-types-and-limits#types-destination code. Example: payout_destination.type=bank_card
$status = new \YOOMONEY\Model\\YOOMONEY\Model\PayoutStatus(); // \YOOMONEY\Model\PayoutStatus | Filter by payout status: https://yookassa.ru/developers/api#payout_object_status. Example: status=succeeded
$limit = 10; // int | Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit=50 Значение по умолчанию: 10
$cursor = 'cursor_example'; // string | Указатель на следующий фрагмент списка. Пример: cursor=37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination

try {
    $result = $apiInstance->payoutsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $succeeded_at_gte, $succeeded_at_gt, $succeeded_at_lte, $succeeded_at_lt, $payout_destination_type, $status, $limit, $cursor);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->payoutsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **created_at_gte** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_gt** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lte** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lt** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **succeeded_at_gte** | **\DateTime**| Filter by time of a successful payout processing: time must be greater than the specified value or equal (\&quot;from a certain moment inclusive\&quot;). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **succeeded_at_gt** | **\DateTime**| Filter by time of a successful payout processing: time must be greater than the specified value (\&quot;from a certain moment exclusive\&quot;). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **succeeded_at_lte** | **\DateTime**| Filter by time of a successful payout processing: time must be less than the specified value or equal (\&quot;until a certain moment inclusive\&quot;). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **succeeded_at_lt** | **\DateTime**| Filter by time of a successful payout processing: time must be less than the specified value (\&quot;until a certain moment exclusive\&quot;). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: succeeded_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **payout_destination_type** | [**\YOOMONEY\Model\PayoutDestinationDataType**](../Model/.md)| Filter by the method of receiving the payout: https://yookassa.ru/developers/payouts/getting-started/payout-types-and-limits#types-destination code. Example: payout_destination.type&#x3D;bank_card | [optional] |
| **status** | [**\YOOMONEY\Model\PayoutStatus**](../Model/.md)| Filter by payout status: https://yookassa.ru/developers/api#payout_object_status. Example: status&#x3D;succeeded | [optional] |
| **limit** | **int**| Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit&#x3D;50 Значение по умолчанию: 10 | [optional] [default to 10] |
| **cursor** | **string**| Указатель на следующий фрагмент списка. Пример: cursor&#x3D;37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination | [optional] |

### Return type

[**\YOOMONEY\Model\PayoutsList**](../Model/PayoutsList.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `payoutsPayoutIdGet()`

```php
payoutsPayoutIdGet($payout_id): \YOOMONEY\Model\Payout
```

Информация о выплате

Используйте этот запрос, чтобы получить информацию о текущем состоянии выплаты по ее уникальному идентификатору. Данные для аутентификации: https://yookassa.ru/developers/using-api/interaction-format#auth запросов зависят от того, какое платежное решение вы используете — обычные выплаты: https://yookassa.ru/developers/payouts/overview или выплаты в рамках Безопасной сделки: https://yookassa.ru/developers/solutions-for-platforms/safe-deal/basics.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payout_id = 'payout_id_example'; // string

try {
    $result = $apiInstance->payoutsPayoutIdGet($payout_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->payoutsPayoutIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **payout_id** | **string**|  | |

### Return type

[**\YOOMONEY\Model\Payout**](../Model/Payout.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `payoutsPost()`

```php
payoutsPost($idempotence_key, $payout_request): \YOOMONEY\Model\Payout
```

Создание выплаты

Используйте этот запрос, чтобы создать в ЮKassa объект выплаты: https://yookassa.ru/developers/api#payout_object. В запросе необходимо передать сумму выплаты, данные о способе получения выплаты (например, номер кошелька ЮMoney), описание выплаты и при необходимости дополнительные параметры, связанные с той функциональностью, которую вы хотите использовать. Передаваемые параметры и данные для аутентификации: https://yookassa.ru/developers/using-api/interaction-format#auth запросов зависят от того, какое платежное решение вы используете — обычные выплаты: https://yookassa.ru/developers/payouts/overview или выплаты в рамках Безопасной сделки: https://yookassa.ru/developers/solutions-for-platforms/safe-deal/basics.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$payout_request = new \YOOMONEY\Model\PayoutRequest(); // \YOOMONEY\Model\PayoutRequest

try {
    $result = $apiInstance->payoutsPost($idempotence_key, $payout_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->payoutsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **payout_request** | [**\YOOMONEY\Model\PayoutRequest**](../Model/PayoutRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\Payout**](../Model/Payout.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `payoutsSearchGet()`

```php
payoutsSearchGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $metadata, $limit, $cursor): \YOOMONEY\Model\PayoutsList
```

Search for payouts

Use this request to search for payouts by the specified criteria. Available only for payouts created over the last 3 months. At this time, only search by the metadata parameter is available. You can also specify the date and time when the payout was created (the created_at parameter). Request authentication details: https://yookassa.ru/developers/using-api/interaction-format#auth depend on which payment solution you are using: basic payouts: https://yookassa.ru/developers/payouts/overview or payouts within the Safe Deal: https://yookassa.ru/developers/solutions-for-platforms/safe-deal/basics.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$created_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte=2018-07-18T10:51:18.139Z
$created_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt=2018-07-18T10:51:18.139Z
$created_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte=2018-07-18T10:51:18.139Z
$created_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt=2018-07-18T10:51:18.139Z
$metadata = array('key' => 'metadata_example'); // array<string,string> | Filter by the metadata object. Strict \"key-value\" pair search: objects that have an exact key and value match in metadata are returned. Restrictions: you can specify a maximum of one \"key-value\" pair, the key name must not be longer than 32 characters, the key value must not be longer than 512 characters, and the data type is a string in UTF-8 format in URL-encoded form. Template: metadata[key]=value Example: metadata%5Boperation_id%5D=e2ab2e1c-776d-4376-aba8-d2099243d1f6
$limit = 10; // int | Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit=50 Значение по умолчанию: 10
$cursor = 'cursor_example'; // string | Указатель на следующий фрагмент списка. Пример: cursor=37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination

try {
    $result = $apiInstance->payoutsSearchGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $metadata, $limit, $cursor);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->payoutsSearchGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **created_at_gte** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_gt** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lte** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lt** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **metadata** | [**array<string,string>**](../Model/string.md)| Filter by the metadata object. Strict \&quot;key-value\&quot; pair search: objects that have an exact key and value match in metadata are returned. Restrictions: you can specify a maximum of one \&quot;key-value\&quot; pair, the key name must not be longer than 32 characters, the key value must not be longer than 512 characters, and the data type is a string in UTF-8 format in URL-encoded form. Template: metadata[key]&#x3D;value Example: metadata%5Boperation_id%5D&#x3D;e2ab2e1c-776d-4376-aba8-d2099243d1f6 | [optional] |
| **limit** | **int**| Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit&#x3D;50 Значение по умолчанию: 10 | [optional] [default to 10] |
| **cursor** | **string**| Указатель на следующий фрагмент списка. Пример: cursor&#x3D;37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination | [optional] |

### Return type

[**\YOOMONEY\Model\PayoutsList**](../Model/PayoutsList.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personalDataPersonalDataIdGet()`

```php
personalDataPersonalDataIdGet($personal_data_id): \YOOMONEY\Model\PersonalData
```

Информация о персональных данных

С помощью этого запроса вы можете получить информацию о текущем статусе объекта персональных данных по его уникальному идентификатору.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$personal_data_id = 'personal_data_id_example'; // string

try {
    $result = $apiInstance->personalDataPersonalDataIdGet($personal_data_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->personalDataPersonalDataIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **personal_data_id** | **string**|  | |

### Return type

[**\YOOMONEY\Model\PersonalData**](../Model/PersonalData.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `personalDataPost()`

```php
personalDataPost($idempotence_key, $personal_data_post_request): \YOOMONEY\Model\PersonalData
```

Создание персональных данных

Используйте этот запрос, чтобы создать в ЮKassa объект персональных данных: https://yookassa.ru/developers/api#personal_data_object. В запросе необходимо указать тип данных (с какой целью они будут использоваться) и передать информацию о пользователе: фамилию, имя, отчество и другие — в зависимости от выбранного типа. Идентификатор созданного объекта персональных данных необходимо использовать в запросе на создание выплаты: https://yookassa.ru/developers/api#create_payout.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$personal_data_post_request = new \YOOMONEY\Model\PersonalDataPostRequest(); // \YOOMONEY\Model\PersonalDataPostRequest

try {
    $result = $apiInstance->personalDataPost($idempotence_key, $personal_data_post_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->personalDataPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **personal_data_post_request** | [**\YOOMONEY\Model\PersonalDataPostRequest**](../Model/PersonalDataPostRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\PersonalData**](../Model/PersonalData.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `posLinksPosLinkIdActivatePost()`

```php
posLinksPosLinkIdActivatePost($pos_link_id): \YOOMONEY\Model\PosLinkInfo
```

Активация ранее деактивированной кассовой ссылки

Используйте этот запрос, чтобы активировать ранее деактивированную кассовую ссылку и возобновить прием платежей по этой платежной табличке. В запросе передайте идентификатор кассовой ссылки, которую вы ранее деактивировали.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pos_link_id = 'pos_link_id_example'; // string

try {
    $result = $apiInstance->posLinksPosLinkIdActivatePost($pos_link_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->posLinksPosLinkIdActivatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **pos_link_id** | **string**|  | |

### Return type

[**\YOOMONEY\Model\PosLinkInfo**](../Model/PosLinkInfo.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `posLinksPosLinkIdDeactivatePost()`

```php
posLinksPosLinkIdDeactivatePost($pos_link_id): \YOOMONEY\Model\PosLinkInfo
```

Деактивация кассовой ссылки

Используйте этот запрос, чтобы деактивировать кассовую ссылку и приостановить прием платежей по этой платежной табличке. В запросе передайте идентификатор кассовой ссылки, которую хотите деактивировать. При необходимости вы можете активировать ранее деактивированную кассовую ссылку: https://yookassa.ru/developers/api#activate_pos_link.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pos_link_id = 'pos_link_id_example'; // string

try {
    $result = $apiInstance->posLinksPosLinkIdDeactivatePost($pos_link_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->posLinksPosLinkIdDeactivatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **pos_link_id** | **string**|  | |

### Return type

[**\YOOMONEY\Model\PosLinkInfo**](../Model/PosLinkInfo.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `posLinksPosLinkIdGet()`

```php
posLinksPosLinkIdGet($pos_link_id): \YOOMONEY\Model\PosLinkInfo
```

Информация о кассовой ссылке

Используйте этот запрос, чтобы получить информацию о текущем состоянии кассовой ссылки по ее уникальному идентификатору.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pos_link_id = 'pos_link_id_example'; // string

try {
    $result = $apiInstance->posLinksPosLinkIdGet($pos_link_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->posLinksPosLinkIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **pos_link_id** | **string**|  | |

### Return type

[**\YOOMONEY\Model\PosLinkInfo**](../Model/PosLinkInfo.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `posLinksPosLinkIdRecipientPost()`

```php
posLinksPosLinkIdRecipientPost($pos_link_id, $idempotence_key, $recipient_pos_link_request): \YOOMONEY\Model\PosLinkInfo
```

Изменение торговой точки, привязанной к кассовой ссылке

Используйте этот запрос, чтобы привязать к кассовой ссылке другую торговую точку. В запросе необходимо передать идентификатор торговой точки, которую вы хотите привязать к кассовой ссылке. После привязки кассовой ссылки перенесите платежную табличку на новую торговую точку (например, если привязали к ссылке новую кассу, переместите табличку туда).

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$pos_link_id = 'pos_link_id_example'; // string
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$recipient_pos_link_request = new \YOOMONEY\Model\RecipientPosLinkRequest(); // \YOOMONEY\Model\RecipientPosLinkRequest

try {
    $result = $apiInstance->posLinksPosLinkIdRecipientPost($pos_link_id, $idempotence_key, $recipient_pos_link_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->posLinksPosLinkIdRecipientPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **pos_link_id** | **string**|  | |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **recipient_pos_link_request** | [**\YOOMONEY\Model\RecipientPosLinkRequest**](../Model/RecipientPosLinkRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\PosLinkInfo**](../Model/PosLinkInfo.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `posLinksPost()`

```php
posLinksPost($idempotence_key, $create_pos_link_request): \YOOMONEY\Model\PosLinkInfo
```

Активация кассовой ссылки

Используйте этот запрос, чтобы создать в ЮKassa объект кассовой ссылки: https://yookassa.ru/developers/api#pos_link_object и активировать кассовую ссылку для последующего приема платежей по платежным табличкам: https://yookassa.ru/developers/offline-payments/getting-started/basics. В запросе необходимо передать кассовую ссылку и идентификатор торговой точки.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$create_pos_link_request = new \YOOMONEY\Model\CreatePosLinkRequest(); // \YOOMONEY\Model\CreatePosLinkRequest

try {
    $result = $apiInstance->posLinksPost($idempotence_key, $create_pos_link_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->posLinksPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **create_pos_link_request** | [**\YOOMONEY\Model\CreatePosLinkRequest**](../Model/CreatePosLinkRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\PosLinkInfo**](../Model/PosLinkInfo.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `receiptsGet()`

```php
receiptsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $status, $payment_id, $refund_id, $limit, $cursor): \YOOMONEY\Model\ReceiptList
```

Список чеков

Запрос позволяет получить список чеков, отфильтрованный по заданным критериям. Можно запросить чеки по конкретному платежу, чеки по конкретному возврату или все чеки магазина. Подробнее о работе со списками: https://yookassa.ru/developers/using-api/lists

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$created_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte=2018-07-18T10:51:18.139Z
$created_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt=2018-07-18T10:51:18.139Z
$created_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte=2018-07-18T10:51:18.139Z
$created_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt=2018-07-18T10:51:18.139Z
$status = new \YOOMONEY\Model\\YOOMONEY\Model\ReceiptRegistrationStatus(); // \YOOMONEY\Model\ReceiptRegistrationStatus | Фильтр по статусу чека. Возможные значения: pending — в обработке, succeeded — успешно зарегистрирован, canceled — отменен. Пример: status=succeeded
$payment_id = 'payment_id_example'; // string | Фильтр по идентификатору платежа: https://yookassa.ru/developers/api#payment_object_id (получить все чеки для указанного платежа). Пример: payment_id=1da5c87d-0984-50e8-a7f3-8de646dd9ec9 В запросе можно передать только что-то одно: или идентификатор платежа, или идентификатор возврата.
$refund_id = 'refund_id_example'; // string | Фильтр по идентификатору возврата: https://yookassa.ru/developers/api#refund_object_id (получить все чеки для указанного возврата). Пример: refund_id=1da5c87d-0984-50e8-a7f3-8de646dd9ec9 В запросе можно передать только что-то одно: или идентификатор платежа, или идентификатор возврата.
$limit = 10; // int | Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit=50 Значение по умолчанию: 10
$cursor = 'cursor_example'; // string | Указатель на следующий фрагмент списка. Пример: cursor=37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination

try {
    $result = $apiInstance->receiptsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $status, $payment_id, $refund_id, $limit, $cursor);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->receiptsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **created_at_gte** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_gt** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lte** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lt** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **status** | [**\YOOMONEY\Model\ReceiptRegistrationStatus**](../Model/.md)| Фильтр по статусу чека. Возможные значения: pending — в обработке, succeeded — успешно зарегистрирован, canceled — отменен. Пример: status&#x3D;succeeded | [optional] |
| **payment_id** | **string**| Фильтр по идентификатору платежа: https://yookassa.ru/developers/api#payment_object_id (получить все чеки для указанного платежа). Пример: payment_id&#x3D;1da5c87d-0984-50e8-a7f3-8de646dd9ec9 В запросе можно передать только что-то одно: или идентификатор платежа, или идентификатор возврата. | [optional] |
| **refund_id** | **string**| Фильтр по идентификатору возврата: https://yookassa.ru/developers/api#refund_object_id (получить все чеки для указанного возврата). Пример: refund_id&#x3D;1da5c87d-0984-50e8-a7f3-8de646dd9ec9 В запросе можно передать только что-то одно: или идентификатор платежа, или идентификатор возврата. | [optional] |
| **limit** | **int**| Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit&#x3D;50 Значение по умолчанию: 10 | [optional] [default to 10] |
| **cursor** | **string**| Указатель на следующий фрагмент списка. Пример: cursor&#x3D;37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination | [optional] |

### Return type

[**\YOOMONEY\Model\ReceiptList**](../Model/ReceiptList.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `receiptsPost()`

```php
receiptsPost($idempotence_key, $post_receipt_data): \YOOMONEY\Model\Receipt
```

Создание чека

Используйте этот запрос при оплате с соблюдением требований 54-ФЗ: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/basics, чтобы создать чек зачета предоплаты. Если вы работаете по сценарию Сначала платеж, потом чек: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/other-services/basics#receipt-after-payment, в запросе также нужно передавать данные для формирования чека прихода и чека возврата прихода.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$post_receipt_data = new \YOOMONEY\Model\PostReceiptData(); // \YOOMONEY\Model\PostReceiptData

try {
    $result = $apiInstance->receiptsPost($idempotence_key, $post_receipt_data);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->receiptsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **post_receipt_data** | [**\YOOMONEY\Model\PostReceiptData**](../Model/PostReceiptData.md)|  | |

### Return type

[**\YOOMONEY\Model\Receipt**](../Model/Receipt.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `receiptsReceiptIdGet()`

```php
receiptsReceiptIdGet($receipt_id): \YOOMONEY\Model\Receipt
```

Информация о чеке

Запрос позволяет получить информацию о текущем состоянии чека по его уникальному идентификатору.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$receipt_id = 'receipt_id_example'; // string | Идентификатор чека.

try {
    $result = $apiInstance->receiptsReceiptIdGet($receipt_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->receiptsReceiptIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **receipt_id** | **string**| Идентификатор чека. | |

### Return type

[**\YOOMONEY\Model\Receipt**](../Model/Receipt.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `refundsGet()`

```php
refundsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $payment_id, $status, $limit, $cursor): \YOOMONEY\Model\RefundList
```

Список возвратов

Use this request to get a list of refunds. You can download refunds created over the last 3 years. You can filter the list by specified criteria. More about working with lists: https://yookassa.ru/developers/using-api/lists

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$created_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte=2018-07-18T10:51:18.139Z
$created_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt=2018-07-18T10:51:18.139Z
$created_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte=2018-07-18T10:51:18.139Z
$created_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt=2018-07-18T10:51:18.139Z
$payment_id = 'payment_id_example'; // string | Фильтр по идентификатору платежа: https://yookassa.ru/developers/api#payment_object_id (получить все возвраты по платежу). Пример: payment_id=1da5c87d-0984-50e8-a7f3-8de646dd9ec9
$status = new \YOOMONEY\Model\\YOOMONEY\Model\RefundStatus(); // \YOOMONEY\Model\RefundStatus | Фильтр по статусу возврата. Возможные значения: pending — в обработке, succeeded — успешно выполнен, canceled — отменен. Пример: status=succeeded
$limit = 10; // int | Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit=50 Значение по умолчанию: 10
$cursor = 'cursor_example'; // string | Указатель на следующий фрагмент списка. Пример: cursor=37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination

try {
    $result = $apiInstance->refundsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $payment_id, $status, $limit, $cursor);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->refundsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **created_at_gte** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_gt** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lte** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lt** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **payment_id** | **string**| Фильтр по идентификатору платежа: https://yookassa.ru/developers/api#payment_object_id (получить все возвраты по платежу). Пример: payment_id&#x3D;1da5c87d-0984-50e8-a7f3-8de646dd9ec9 | [optional] |
| **status** | [**\YOOMONEY\Model\RefundStatus**](../Model/.md)| Фильтр по статусу возврата. Возможные значения: pending — в обработке, succeeded — успешно выполнен, canceled — отменен. Пример: status&#x3D;succeeded | [optional] |
| **limit** | **int**| Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit&#x3D;50 Значение по умолчанию: 10 | [optional] [default to 10] |
| **cursor** | **string**| Указатель на следующий фрагмент списка. Пример: cursor&#x3D;37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination | [optional] |

### Return type

[**\YOOMONEY\Model\RefundList**](../Model/RefundList.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `refundsPost()`

```php
refundsPost($idempotence_key, $refund_request): \YOOMONEY\Model\Refund
```

Создание возврата

Создает возврат успешного платежа на указанную сумму. Платеж можно вернуть только в течение трех лет с момента его создания: https://yookassa.ru/developers/api#create_payment. Комиссия ЮKassa за проведение платежа не возвращается.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$refund_request = new \YOOMONEY\Model\RefundRequest(); // \YOOMONEY\Model\RefundRequest

try {
    $result = $apiInstance->refundsPost($idempotence_key, $refund_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->refundsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **refund_request** | [**\YOOMONEY\Model\RefundRequest**](../Model/RefundRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\Refund**](../Model/Refund.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `refundsRefundIdGet()`

```php
refundsRefundIdGet($refund_id): \YOOMONEY\Model\Refund
```

Информация о возврате

Запрос позволяет получить информацию о текущем состоянии возврата по его уникальному идентификатору.

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$refund_id = 'cae993f2-eb15-45f5-91c5-efb87107ae10'; // string | Идентификатор возврата.

try {
    $result = $apiInstance->refundsRefundIdGet($refund_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->refundsRefundIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **refund_id** | **string**| Идентификатор возврата. | [default to &#39;cae993f2-eb15-45f5-91c5-efb87107ae10&#39;] |

### Return type

[**\YOOMONEY\Model\Refund**](../Model/Refund.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `sbpBanksGet()`

```php
sbpBanksGet(): \YOOMONEY\Model\GetSbpBanksResponse
```

Список участников СБП

С помощью этого запроса вы можете получить актуальный список всех участников СБП. Список нужно вывести получателю выплаты, идентификатор выбранного участника СБП необходимо использовать в запросе на создание выплаты: https://yookassa.ru/developers/api#create_payout. Подробнее о выплатах через СБП: https://yookassa.ru/developers/payouts/making-payouts/sbp

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


$apiInstance = new YOOMONEY\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->sbpBanksGet();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->sbpBanksGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\YOOMONEY\Model\GetSbpBanksResponse**](../Model/GetSbpBanksResponse.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

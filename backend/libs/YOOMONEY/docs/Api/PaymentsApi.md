# YOOMONEY\PaymentsApi

The API allows you to create, capture, and cancel payments, as well as receive payment information. How to process a payment: https://yookassa.ru/developers/payment-acceptance/getting-started/quick-start

All URIs are relative to https://api.yookassa.ru/v3, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**paymentsGet()**](PaymentsApi.md#paymentsGet) | **GET** /payments | List payments |
| [**paymentsPaymentIdCancelPost()**](PaymentsApi.md#paymentsPaymentIdCancelPost) | **POST** /payments/{payment_id}/cancel | Cancel a payment |
| [**paymentsPaymentIdCapturePost()**](PaymentsApi.md#paymentsPaymentIdCapturePost) | **POST** /payments/{payment_id}/capture | Capture a payment |
| [**paymentsPaymentIdGet()**](PaymentsApi.md#paymentsPaymentIdGet) | **GET** /payments/{payment_id} | Get payment information |
| [**paymentsPost()**](PaymentsApi.md#paymentsPost) | **POST** /payments | Create a payment |


## `paymentsGet()`

```php
paymentsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $captured_at_gte, $captured_at_gt, $captured_at_lte, $captured_at_lt, $payment_method, $status, $limit, $cursor): \YOOMONEY\Model\PaymentList
```

List payments

Use this request to get a list of payments. You can download payments created over the last 3 years. You can filter the list by specified criteria. More about working with lists: https://yookassa.ru/developers/using-api/lists

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


$apiInstance = new YOOMONEY\Api\PaymentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$created_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte=2018-07-18T10:51:18.139Z
$created_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt=2018-07-18T10:51:18.139Z
$created_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte=2018-07-18T10:51:18.139Z
$created_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt=2018-07-18T10:51:18.139Z
$captured_at_gte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of payment capture: time must be greater than the specified value or equal (\"from a certain moment inclusive\"). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.gte=2018-07-18T10:51:18.139Z
$captured_at_gt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of payment capture: time must be greater than the specified value (\"from a certain moment exclusive\"). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.gt=2018-07-18T10:51:18.139Z
$captured_at_lte = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of payment capture: time must be less than the specified value or equal (\"until a certain moment inclusive\"). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.lte=2018-07-18T10:51:18.139Z
$captured_at_lt = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | Filter by time of payment capture: time must be less than the specified value (\"until a certain moment exclusive\") Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.lt=2018-07-18T10:51:18.139Z
$payment_method = new \YOOMONEY\Model\\YOOMONEY\Model\PaymentMethodType(); // \YOOMONEY\Model\PaymentMethodType | Filter by payment method: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-methods#all code. Example: payment_method=bank_card
$status = new \YOOMONEY\Model\\YOOMONEY\Model\PaymentStatus(); // \YOOMONEY\Model\PaymentStatus | Filter by payment status: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#lifecycle. Example: status=succeeded
$limit = 10; // int | Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit=50 Значение по умолчанию: 10
$cursor = 'cursor_example'; // string | Указатель на следующий фрагмент списка. Пример: cursor=37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination

try {
    $result = $apiInstance->paymentsGet($created_at_gte, $created_at_gt, $created_at_lte, $created_at_lt, $captured_at_gte, $captured_at_gt, $captured_at_lte, $captured_at_lt, $payment_method, $status, $limit, $cursor);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PaymentsApi->paymentsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **created_at_gte** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения или равно ему («с такого-то момента включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_gt** | **\DateTime**| Фильтр по времени создания: время должно быть больше указанного значения («с такого-то момента, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lte** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения или равно ему («по такой-то момент включительно»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **created_at_lt** | **\DateTime**| Фильтр по времени создания: время должно быть меньше указанного значения («по такой-то момент, не включая его»). Указывается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Пример: created_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **captured_at_gte** | **\DateTime**| Filter by time of payment capture: time must be greater than the specified value or equal (\&quot;from a certain moment inclusive\&quot;). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.gte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **captured_at_gt** | **\DateTime**| Filter by time of payment capture: time must be greater than the specified value (\&quot;from a certain moment exclusive\&quot;). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.gt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **captured_at_lte** | **\DateTime**| Filter by time of payment capture: time must be less than the specified value or equal (\&quot;until a certain moment inclusive\&quot;). Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.lte&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **captured_at_lt** | **\DateTime**| Filter by time of payment capture: time must be less than the specified value (\&quot;until a certain moment exclusive\&quot;) Specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: captured_at.lt&#x3D;2018-07-18T10:51:18.139Z | [optional] |
| **payment_method** | [**\YOOMONEY\Model\PaymentMethodType**](../Model/.md)| Filter by payment method: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-methods#all code. Example: payment_method&#x3D;bank_card | [optional] |
| **status** | [**\YOOMONEY\Model\PaymentStatus**](../Model/.md)| Filter by payment status: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#lifecycle. Example: status&#x3D;succeeded | [optional] |
| **limit** | **int**| Размер выдачи результатов запроса — количество объектов, передаваемых в ответе. Возможные значения: от 1 до 100. Пример: limit&#x3D;50 Значение по умолчанию: 10 | [optional] [default to 10] |
| **cursor** | **string**| Указатель на следующий фрагмент списка. Пример: cursor&#x3D;37a5c87d-3984-51e8-a7f3-8de646d39ec15 В качестве указателя необходимо использовать значение параметра next_cursor, полученное в ответе на предыдущий запрос. Используется, если в списке больше объектов, чем может поместиться в выдаче (limit), и конец выдачи не достигнут. Пример использования: https://yookassa.ru/developers/using-api/lists#pagination | [optional] |

### Return type

[**\YOOMONEY\Model\PaymentList**](../Model/PaymentList.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `paymentsPaymentIdCancelPost()`

```php
paymentsPaymentIdCancelPost($payment_id, $idempotence_key): \YOOMONEY\Model\Payment
```

Cancel a payment

Cancel payments with the waiting_for_capture status. Payment cancelation means you are not ready to dispatch a product or to provide a service to the user. Once you cancel the payment, we will start returning the money to the payer’s account. If the payment was made from a bank card, a YooMoney wallet, or via SberPay, the money will be refunded instantly. If the payment was made using other payment methods, the process can take up to several days. More about capturing and canceling payments: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-and-cancel

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


$apiInstance = new YOOMONEY\Api\PaymentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payment_id = 'payment_id_example'; // string | Идентификатор платежа.
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7

try {
    $result = $apiInstance->paymentsPaymentIdCancelPost($payment_id, $idempotence_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PaymentsApi->paymentsPaymentIdCancelPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **payment_id** | **string**| Идентификатор платежа. | |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |

### Return type

[**\YOOMONEY\Model\Payment**](../Model/Payment.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `paymentsPaymentIdCapturePost()`

```php
paymentsPaymentIdCapturePost($payment_id, $idempotence_key, $payment_capture_request): \YOOMONEY\Model\Payment
```

Capture a payment

Confirm you’re ready to accept the payment. Once the payment is captured, the status will change to succeeded. After that, you can provide the customer with the product or service. You can only capture payments with the waiting_for_capture status, and only for a certain amount of time (depending on the payment method). If you do not capture the payment within the allotted time, the status will change to canceled, and the money will be returned to the user. More about capturing and canceling payments: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-and-cancel

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


$apiInstance = new YOOMONEY\Api\PaymentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payment_id = 'payment_id_example'; // string | Идентификатор платежа.
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$payment_capture_request = new \YOOMONEY\Model\PaymentCaptureRequest(); // \YOOMONEY\Model\PaymentCaptureRequest

try {
    $result = $apiInstance->paymentsPaymentIdCapturePost($payment_id, $idempotence_key, $payment_capture_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PaymentsApi->paymentsPaymentIdCapturePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **payment_id** | **string**| Идентификатор платежа. | |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **payment_capture_request** | [**\YOOMONEY\Model\PaymentCaptureRequest**](../Model/PaymentCaptureRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\Payment**](../Model/Payment.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `paymentsPaymentIdGet()`

```php
paymentsPaymentIdGet($payment_id): \YOOMONEY\Model\Payment
```

Get payment information

This request allows you to get the information about the current payment status by its unique ID.

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


$apiInstance = new YOOMONEY\Api\PaymentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$payment_id = 'payment_id_example'; // string | Идентификатор платежа.

try {
    $result = $apiInstance->paymentsPaymentIdGet($payment_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PaymentsApi->paymentsPaymentIdGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **payment_id** | **string**| Идентификатор платежа. | |

### Return type

[**\YOOMONEY\Model\Payment**](../Model/Payment.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `paymentsPost()`

```php
paymentsPost($idempotence_key, $create_payment_request): \YOOMONEY\Model\Payment
```

Create a payment

To accept a payment, you need to create a payment object: https://yookassa.ru/developers/api#payment_object, Payment. It contains all the necessary payment information (amount, currency, and status). Payments have a linear life cycle, going from one status to the next sequentially.

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


$apiInstance = new YOOMONEY\Api\PaymentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$idempotence_key = 018e5f0a-1b2c-7d4e-9f0a-1b2c3d4e5f6a; // string | Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7
$create_payment_request = new \YOOMONEY\Model\CreatePaymentRequest(); // \YOOMONEY\Model\CreatePaymentRequest

try {
    $result = $apiInstance->paymentsPost($idempotence_key, $create_payment_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PaymentsApi->paymentsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **idempotence_key** | **string**| Ключ идемпотентности. Рекомендуется использовать строку вида UUID v7 | |
| **create_payment_request** | [**\YOOMONEY\Model\CreatePaymentRequest**](../Model/CreatePaymentRequest.md)|  | |

### Return type

[**\YOOMONEY\Model\Payment**](../Model/Payment.md)

### Authorization

[OAuth2](../../README.md#OAuth2), [BasicAuth](../../README.md#BasicAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

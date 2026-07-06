# PaymentMethodsPostRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | **string** |  |
**holder** | [**\YOOMONEY\Model\Recipient**](Recipient.md) | Данные магазина, для которого сохраняется способ оплаты. | [optional]
**client_ip** | **string** | IPv4 или IPv6-адрес пользователя. Если не указан, используется IP-адрес TCP-подключения. | [optional]
**confirmation** | [**\YOOMONEY\Model\SavePaymentMethodDataConfirmation**](SavePaymentMethodDataConfirmation.md) |  | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**card** | [**\YOOMONEY\Model\CardRequestDataWithCsc**](CardRequestDataWithCsc.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

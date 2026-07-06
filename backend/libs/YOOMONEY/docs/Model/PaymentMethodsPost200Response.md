# PaymentMethodsPost200Response

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\YOOMONEY\Model\SavePaymentMethodType**](SavePaymentMethodType.md) |  |
**id** | **string** | Идентификатор сохраненного способа оплаты. |
**saved** | **bool** | Признак сохранения способа оплаты для автоплатежей: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/pay-with-saved. Возможные значения: * true — способ оплаты сохранен для автоплатежей и выплат; * false — способ оплаты не сохранен. |
**status** | [**\YOOMONEY\Model\PaymentMethodStatus**](PaymentMethodStatus.md) |  |
**holder** | [**\YOOMONEY\Model\SavePaymentMethodHolder**](SavePaymentMethodHolder.md) |  |
**title** | **string** | Название способа оплаты. | [optional]
**confirmation** | [**\YOOMONEY\Model\SavePaymentMethodConfirmation**](SavePaymentMethodConfirmation.md) |  | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**card** | [**\YOOMONEY\Model\BankCardData**](BankCardData.md) |  | [optional]
**payer_bank_details** | [**\YOOMONEY\Model\SavePaymentMethodSbpPayerBankDetails**](SavePaymentMethodSbpPayerBankDetails.md) | Реквизиты счета, который использовался для привязки. Обязательный параметр при успешном сохранении способа оплаты (status&#x3D;active). В остальных случаях может отсутствовать. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

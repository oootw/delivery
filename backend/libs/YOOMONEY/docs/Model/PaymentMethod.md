# PaymentMethod

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\YOOMONEY\Model\PaymentMethodType**](PaymentMethodType.md) |  |
**id** | **string** | Payment method ID. |
**saved** | **bool** | Признак сохранения способа оплаты для автоплатежей: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/pay-with-saved. Возможные значения: * true — способ оплаты сохранен для автоплатежей и выплат; * false — способ оплаты не сохранен. |
**status** | [**\YOOMONEY\Model\PaymentMethodStatus**](PaymentMethodStatus.md) | Статус проверки и сохранения способа оплаты. Возможные значения: * pending — ожидает действий от пользователя; * active — способ оплаты сохранен, его можно использовать для автоплатежей или выплат; * inactive — способ оплаты не сохранен: возникла ошибка или не было попытки сохранения способа оплаты. |
**title** | **string** | Название способа оплаты. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

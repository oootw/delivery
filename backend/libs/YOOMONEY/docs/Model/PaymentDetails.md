# PaymentDetails

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор платежа в ЮKassa. |
**status** | [**\YOOMONEY\Model\PaymentStatus**](PaymentStatus.md) | Статус платежа. Возможные значения: * waiting_for_capture — для платежей в две стадии: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-and-cancel: платеж оплачен, деньги авторизованы, вам необходимо списать оплату или отменить платеж; * succeeded — платеж успешно завершен, деньги будут перечислены на ваш расчетный счет в соответствии с вашим договором с ЮKassa (финальный и неизменяемый статус); * canceled — для платежей в две стадии: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-process#capture-and-cancel: вы отменили платеж по API (финальный и неизменяемый статус). |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

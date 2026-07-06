# SavePaymentMethodDataConfirmation

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\YOOMONEY\Model\PaymentMethodsConfirmationType**](PaymentMethodsConfirmationType.md) |  |
**enforce** | **bool** | Запрос на проведение привязки с аутентификацией по 3-D Secure. Будет работать, если оплату банковской картой вы по умолчанию принимаете без подтверждения платежа пользователем. В остальных случаях аутентификацией по 3-D Secure будет управлять ЮKassa. Если хотите принимать платежи и создавать привязки без дополнительного подтверждения пользователем, напишите вашему менеджеру ЮKassa. | [optional]
**return_url** | **string** | Адрес страницы, на которую пользователь вернется после подтверждения или отмены привязки в приложении участника СБП. Например, если хотите вернуть пользователя на сайт, вы можете передать URL, если в мобильное приложение — диплинк. URI должен соответствовать стандарту RFC-3986: https://www.ietf.org/rfc/rfc3986.txt. Не более 2048 символов. Доступно только для привязок счета СБП: https://yookassa.ru/developers/payment-acceptance/scenario-extensions/recurring-payments/save-payment-method/save-without-payment/sbp. |
**locale** | [**\YOOMONEY\Model\Locale**](Locale.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

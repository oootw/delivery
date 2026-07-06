# PaymentMethodsConfirmationDataRedirect

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**enforce** | **bool** | Запрос на проведение привязки с аутентификацией по 3-D Secure. Будет работать, если оплату банковской картой вы по умолчанию принимаете без подтверждения платежа пользователем. В остальных случаях аутентификацией по 3-D Secure будет управлять ЮKassa. Если хотите принимать платежи и создавать привязки без дополнительного подтверждения пользователем, напишите вашему менеджеру ЮKassa. | [optional]
**return_url** | **string** | URL, на который вернется пользователь после подтверждения или отмены привязки на веб-странице. Не более 2048 символов. |
**locale** | [**\YOOMONEY\Model\Locale**](Locale.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

# CreatePaymentRequestConfirmation

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\YOOMONEY\Model\ConfirmationDataType**](ConfirmationDataType.md) |  |
**locale** | [**\YOOMONEY\Model\Locale**](Locale.md) |  | [optional]
**enforce** | **bool** | Запрос на проведение платежа с аутентификацией по 3-D Secure. Будет работать, если оплату банковской картой вы по умолчанию принимаете без подтверждения платежа пользователем. В остальных случаях аутентификацией по 3-D Secure будет управлять ЮKassa. Если хотите принимать платежи без дополнительного подтверждения пользователем, напишите вашему менеджеру ЮKassa. | [optional] [default to false]
**return_url** | **string** | URL or deep link, to which user will return after confirming or canceling the payment in the app. Send the URL if the payment was made via the mobile version of the website, or send the deep link if the payment was made via mobile app. Maximum 255 characters for payments made via SberPay: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/manual-integration/sberpay#create-payment-mobile-application. Maximum 2,048 characters for other payment methods: https://yookassa.ru/developers/payment-acceptance/getting-started/payment-methods#all. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

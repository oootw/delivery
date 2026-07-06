# Payment

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор платежа в ЮKassa. |
**status** | [**\YOOMONEY\Model\PaymentStatus**](PaymentStatus.md) |  |
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Payment amount. Sometimes YooMoney&#39;s partners charge additional commission from the users that is not included in this amount. The amount is specified with the currency code. It should match the currency of your subaccount (recipient.gateway_id) if you separate payment flows, or the currency of the account (shopId in the Merchant Profile) if you don&#39;t. |
**income_amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма платежа, которую получит магазин, — значение amount за вычетом комиссии ЮKassa и суммы НДС с этой комиссии. Если вы партнер: https://yookassa.ru/developers/solutions-for-platforms/partners-api/basics и для аутентификации запросов используете OAuth-токен, запросите у магазина право: https://yookassa.ru/developers/solutions-for-platforms/partners-api/oauth/basics на получение информации о комиссиях при платежах. | [optional]
**description** | **string** | Описание транзакции (не более 128 символов), которое вы увидите в личном кабинете ЮKassa, а пользователь — при оплате. Например: «Оплата заказа № 72 для user@yoomoney.ru». | [optional]
**recipient** | [**\YOOMONEY\Model\PaymentRecipient**](PaymentRecipient.md) |  |
**payment_method** | [**\YOOMONEY\Model\PaymentPaymentMethod**](PaymentPaymentMethod.md) |  | [optional]
**captured_at** | **\DateTime** | Time of payment capture, based on UTC: https://en.wikipedia.org/wiki/Coordinated_Universal_Time and specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. | [optional]
**created_at** | **\DateTime** | Time of order creation, based on UTC: https://en.wikipedia.org/wiki/Coordinated_Universal_Time and specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: 2017-11-03T11:52:31.827Z |
**expires_at** | **\DateTime** | The period during which you can cancel or capture a payment for free. The payment with the waiting_for_capture status will be automatically canceled at the specified time. Based on UTC: https://en.wikipedia.org/wiki/Coordinated_Universal_Time and specified in the ISO 8601: https://en.wikipedia.org/wiki/ISO_8601 format. Example: 2017-11-03T11:52:31.827Z | [optional]
**confirmation** | [**\YOOMONEY\Model\PaymentConfirmation**](PaymentConfirmation.md) |  | [optional]
**test** | **bool** | Признак тестовой операции. |
**refunded_amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | The amount refunded to the user. Specified if the payment has successful refunds. | [optional]
**paid** | **bool** | The attribute of a paid order. |
**refundable** | **bool** | Availability of the option to make a refund via API. |
**receipt_registration** | [**\YOOMONEY\Model\ReceiptRegistrationStatus**](ReceiptRegistrationStatus.md) | Статус регистрации чека. Возможные значения: pending — данные в обработке; succeeded — чек успешно зарегистрирован; canceled — чек зарегистрировать не удалось; если используете Чеки от ЮKassa: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/basics, обратитесь в техническую поддержку, в остальных случаях сформируйте чек вручную. Присутствует, если вы используете решения ЮKassa для отправки чеков в налоговую: https://yookassa.ru/developers/payment-acceptance/receipts/basics. | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]
**cancellation_details** | [**\YOOMONEY\Model\PaymentCancellationDetails**](PaymentCancellationDetails.md) |  | [optional]
**authorization_details** | [**\YOOMONEY\Model\AuthorizationDetails**](AuthorizationDetails.md) |  | [optional]
**transfers** | [**\YOOMONEY\Model\Transfer[]**](Transfer.md) | Information about money distribution: the amounts of transfers and the stores to be transferred to. Specified if you use Split payments: https://yookassa.ru/developers/solutions-for-platforms/split-payments/basics. | [optional]
**deal** | [**\YOOMONEY\Model\PaymentDealInfo**](PaymentDealInfo.md) | The deal within which the payment is being carried out. Specified if you use Safe deal: https://yookassa.ru/developers/solutions-for-platforms/safe-deal/basics. | [optional]
**merchant_customer_id** | **string** | The identifier of the customer in your system, such as email address or phone number. No more than 200 characters. Specified if you want to save a bank card and offer it for a recurring payment in the YooMoney payment widget: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/widget/basics. | [optional]
**invoice_details** | [**\YOOMONEY\Model\PaymentInvoiceDetails**](PaymentInvoiceDetails.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

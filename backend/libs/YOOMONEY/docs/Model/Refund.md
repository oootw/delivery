# Refund

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор возврата платежа в ЮKassa. |
**payment_id** | **string** | Идентификатор платежа в ЮKassa. |
**status** | [**\YOOMONEY\Model\RefundStatus**](RefundStatus.md) |  |
**cancellation_details** | [**\YOOMONEY\Model\RefundCancellationDetails**](RefundCancellationDetails.md) |  | [optional]
**receipt_registration** | [**\YOOMONEY\Model\ReceiptRegistrationStatus**](ReceiptRegistrationStatus.md) | Статус регистрации чека. Возможные значения: pending — данные в обработке; succeeded — чек успешно зарегистрирован; canceled — чек зарегистрировать не удалось; если используете Чеки от ЮKassa: https://yookassa.ru/developers/payment-acceptance/receipts/54fz/yoomoney/basics, обратитесь в техническую поддержку, в остальных случаях сформируйте чек вручную. Присутствует, если вы используете решения ЮKassa для отправки чеков в налоговую: https://yookassa.ru/developers/payment-acceptance/receipts/basics. | [optional]
**created_at** | **\DateTime** | Время создания возврата. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601, например 2017-11-03T11:52:31.827Z |
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма, возвращенная пользователю. |
**description** | **string** | Основание для возврата денег пользователю. | [optional]
**sources** | [**\YOOMONEY\Model\RefundSourcesData[]**](RefundSourcesData.md) | Данные о том, с какого магазина и какую сумму нужно удержать для проведения возврата. Присутствует, если вы используете Сплитование платежей: https://yookassa.ru/developers/solutions-for-platforms/split-payments/basics. | [optional]
**deal** | [**\YOOMONEY\Model\RefundDealInfo**](RefundDealInfo.md) |  | [optional]
**refund_method** | [**\YOOMONEY\Model\RefundRefundMethod**](RefundRefundMethod.md) |  | [optional]
**refund_authorization_details** | [**\YOOMONEY\Model\RefundAuthorizationDetails**](RefundAuthorizationDetails.md) |  | [optional]
**metadata** | **array<string,string>** | Любые дополнительные данные, которые нужны вам для работы (например, ваш внутренний идентификатор заказа). Передаются в виде набора пар «ключ-значение» и возвращаются в ответе от ЮKassa. Ограничения: максимум 16 ключей, имя ключа не больше 32 символов, значение ключа не больше 512 символов, тип данных — строка в формате UTF-8. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

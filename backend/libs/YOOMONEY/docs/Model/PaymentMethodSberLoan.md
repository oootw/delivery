# PaymentMethodSberLoan

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**loan_option** | **string** | Тариф кредита, который пользователь выбрал при оплате. Возможные значения: loan — кредит; installments_XX — рассрочка, где XX — количество месяцев для выплаты рассрочки. Например, installments_3 — рассрочка на 3 месяца. Присутствует для платежей в статусе waiting_for_capture и succeeded. | [optional]
**discount_amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма скидки для рассрочки. Присутствует для платежей в статусе waiting_for_capture и succeeded, если пользователь выбрал рассрочку. | [optional]
**suspended_until** | **\DateTime** | Время, когда заканчивается период охлаждения: https://yookassa.ru/docs/support/payments/credit-purchases-by-sberbank-with-cooling-off кредита или рассрочки. Указывается по UTC: https://ru.wikipedia.org/wiki/%D0%92%D1%81%D0%B5%D0%BC%D0%B8%D1%80%D0%BD%D0%BE%D0%B5_%D0%BA%D0%BE%D0%BE%D1%80%D0%B4%D0%B8%D0%BD%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%BD%D0%BE%D0%B5_%D0%B2%D1%80%D0%B5%D0%BC%D1%8F и передается в формате ISO 8601: https://en.wikipedia.org/wiki/ISO_8601. Присутствует для платежей в статусе pending, которые по закону: https://www.consultant.ru/document/cons_doc_LAW_498604/ попадают под процедуру охлаждения. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

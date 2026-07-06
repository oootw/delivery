# ElectronicCertificateRefundMethodData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**electronic_certificate** | [**\YOOMONEY\Model\ElectronicCertificateRefundDataRequest**](ElectronicCertificateRefundDataRequest.md) |  | [optional]
**articles** | [**\YOOMONEY\Model\ElectronicCertificateRefundArticle[]**](ElectronicCertificateRefundArticle.md) | Корзина возврата (в терминах НСПК) — список возвращаемых товаров, для оплаты которых использовался электронный сертификат. Данные должны соответствовать товарам из одобренной корзины покупки (articles в объекте платежа: https://yookassa.ru/developers/api#payment_object). Необходимо передавать только при оплате на готовой странице ЮKassa: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/manual-integration/other/electronic-certificate/ready-made-payment-form. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

# PaymentMethodDataElectronicCertificate

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**card** | [**\YOOMONEY\Model\CardRequestDataWithCsc**](CardRequestDataWithCsc.md) |  | [optional]
**electronic_certificate** | [**\YOOMONEY\Model\ElectronicCertificatePaymentData**](ElectronicCertificatePaymentData.md) |  | [optional]
**articles** | [**\YOOMONEY\Model\ElectronicCertificateArticle[]**](ElectronicCertificateArticle.md) | Корзина покупки (в терминах НСПК) — список товаров, которые можно оплатить по сертификату. Необходимо передавать только при оплате на готовой странице ЮKassa: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/manual-integration/other/electronic-certificate/ready-made-payment-form. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

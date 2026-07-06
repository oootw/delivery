# PaymentMethodElectronicCertificate

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**card** | [**\YOOMONEY\Model\BankCardData**](BankCardData.md) | Данные банковской карты «Мир». | [optional]
**electronic_certificate** | [**\YOOMONEY\Model\ElectronicCertificatePayment**](ElectronicCertificatePayment.md) |  | [optional]
**articles** | [**\YOOMONEY\Model\ElectronicCertificateApprovedPaymentArticle[]**](ElectronicCertificateApprovedPaymentArticle.md) | Одобренная корзина покупки — список товаров, одобренных к оплате по электронному сертификату. Присутствует только при оплате на готовой странице ЮKassa: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/manual-integration/other/electronic-certificate/ready-made-payment-form. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

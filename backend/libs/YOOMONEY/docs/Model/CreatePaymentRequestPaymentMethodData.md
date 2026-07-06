# CreatePaymentRequestPaymentMethodData

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | **string** |  |
**card** | [**\YOOMONEY\Model\CardRequestDataWithCsc**](CardRequestDataWithCsc.md) |  | [optional]
**phone** | **string** | The user&#39;s phone number. Sent to the partner and used for authorization in the \&quot;Pay in installments\&quot; service. Maximum 15 characters. Specified in the ITU-T E.164: https://ru.wikipedia.org/wiki/E.164 format. Example: 79000000000. |
**payment_purpose** | **string** | Назначение платежа (не больше 210 символов). |
**vat_data** | [**\YOOMONEY\Model\PaymentMethodDataB2bSberbankAllOfVatData**](PaymentMethodDataB2bSberbankAllOfVatData.md) |  |
**electronic_certificate** | [**\YOOMONEY\Model\ElectronicCertificatePaymentData**](ElectronicCertificatePaymentData.md) |  | [optional]
**articles** | [**\YOOMONEY\Model\ElectronicCertificateArticle[]**](ElectronicCertificateArticle.md) | Корзина покупки (в терминах НСПК) — список товаров, которые можно оплатить по сертификату. Необходимо передавать только при оплате на готовой странице ЮKassa: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/manual-integration/other/electronic-certificate/ready-made-payment-form. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

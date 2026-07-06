# RefundRefundMethod

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\YOOMONEY\Model\RefundMethodType**](RefundMethodType.md) |  |
**sbp_operation_id** | **string** | Идентификатор операции в СБП (НСПК). Пример: 1027088AE4CB48CB81287833347A8777. Обязательный параметр для возвратов в статусе succeeded. В остальных случаях может отсутствовать. | [optional]
**electronic_certificate** | [**\YOOMONEY\Model\ElectronicCertificateRefundDataResponse**](ElectronicCertificateRefundDataResponse.md) |  | [optional]
**articles** | [**\YOOMONEY\Model\ElectronicCertificateRefundArticle[]**](ElectronicCertificateRefundArticle.md) | Корзина возврата — список возвращаемых товаров, для оплаты которых использовался электронный сертификат. Присутствует, если оплата была на готовой странице ЮKassa: https://yookassa.ru/developers/payment-acceptance/integration-scenarios/manual-integration/other/electronic-certificate/ready-made-payment-form. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

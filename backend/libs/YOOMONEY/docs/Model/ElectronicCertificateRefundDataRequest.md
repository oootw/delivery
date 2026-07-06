# ElectronicCertificateRefundDataRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**amount** | [**\YOOMONEY\Model\MonetaryAmount**](MonetaryAmount.md) | Сумма, которая вернется на электронный сертификат, — значение totalCertAmount, которое вы получили в ФЭС НСПК в запросе на предварительное одобрение возврата (Refund Pre-Auth): https://www.nspk.ru/developer/api-fes#tag/Protokol-FES-NSPK-v1/operation/preAuthReturn. |
**basket_id** | **string** | Идентификатор корзины возврата, сформированной в НСПК, — значение returnBasketId, которое вы получили в ФЭС НСПК в запросе на предварительное одобрение возврата (Refund Pre-Auth): https://www.nspk.ru/developer/api-fes#tag/Protokol-FES-NSPK-v1/operation/preAuthReturn. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

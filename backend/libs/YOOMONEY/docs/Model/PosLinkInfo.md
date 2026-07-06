# PosLinkInfo

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**id** | **string** | Идентификатор кассовой ссылки в ЮKassa. |
**status** | [**\YOOMONEY\Model\PosLinkStatus**](PosLinkStatus.md) |  |
**type** | [**\YOOMONEY\Model\PosLinkType**](PosLinkType.md) |  |
**recipient** | [**\YOOMONEY\Model\Recipient**](Recipient.md) | Идентификатор торговой точки: https://yookassa.ru/developers/offline-payments/getting-started/basics#how-it-works-tablet, которая привязана к кассовой ссылке. |
**payment** | [**\YOOMONEY\Model\PosLinkLastPayment**](PosLinkLastPayment.md) | Данные о последнем платеже, который прошел по этой кассовой ссылке. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

# PayoutToSbpDestination

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**phone** | **string** | Телефон, к которому привязан счет получателя выплаты в системе участника СБП. Указывается в формате ITU-T E.164: https://ru.wikipedia.org/wiki/E.164, например 79000000000. |
**bank_id** | **string** | Идентификатор участника СБП — банка или платежного сервиса, подключенного к сервису. |
**sbp_operation_id** | **string** | ID of the transaction in FPS (NSPK). Example: 1027088AE4CB48CB81287833347A8777. Required parameter for payments with the succeeded status. In other cases, it might be missing. | [optional]
**recipient_checked** | **bool** | Проверка получателя выплаты: https://yookassa.ru/developers/payouts/scenario-extensions/recipient-check: true — выплата проходила с проверкой получателя, false — выплата проходила без проверки получателя. |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

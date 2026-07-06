# Airline

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**ticket_number** | **string** | Unique ticket number. If you already know the ticket number during payment creation, ticket_number is a required parameter. If you don&#39;t, specify booking_reference instead of ticket_number. | [optional]
**booking_reference** | **string** | Booking reference number, required if ticket_number is not specified. | [optional]
**passengers** | [**\YOOMONEY\Model\AirlinePassenger[]**](AirlinePassenger.md) | List of passengers. | [optional]
**legs** | [**\YOOMONEY\Model\AirlineLeg[]**](AirlineLeg.md) | List of flight legs. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)

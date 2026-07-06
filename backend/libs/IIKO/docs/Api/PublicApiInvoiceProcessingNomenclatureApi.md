# IIKO\PublicApiInvoiceProcessingNomenclatureApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1NomenclatureUpdateBarcodesPost()**](PublicApiInvoiceProcessingNomenclatureApi.md#apiInventoryV1NomenclatureUpdateBarcodesPost) | **POST** /api/inventory/v1/nomenclature/update_barcodes | Update product barcodes |


## `apiInventoryV1NomenclatureUpdateBarcodesPost()`

```php
apiInventoryV1NomenclatureUpdateBarcodesPost($update_product_barcodes_request): \IIKO\Model\UpdateProductBarcodesResponse
```

Update product barcodes

Updates product barcodes in the nomenclature

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingNomenclatureApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$update_product_barcodes_request = new \IIKO\Model\UpdateProductBarcodesRequest(); // \IIKO\Model\UpdateProductBarcodesRequest | Product barcode update request

try {
    $result = $apiInstance->apiInventoryV1NomenclatureUpdateBarcodesPost($update_product_barcodes_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingNomenclatureApi->apiInventoryV1NomenclatureUpdateBarcodesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **update_product_barcodes_request** | [**\IIKO\Model\UpdateProductBarcodesRequest**](../Model/UpdateProductBarcodesRequest.md)| Product barcode update request | |

### Return type

[**\IIKO\Model\UpdateProductBarcodesResponse**](../Model/UpdateProductBarcodesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

trait CatalogProducts
{
    /**
     * Create a product.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/catalog-products/v1/#products_create
     */
    public function createProduct(array $data, string $request_id)
    {
        $this->apiEndPoint = 'v1/catalogs/products';

        $this->options['headers']['PayPal-Request-Id'] = $request_id;
        $this->options['json'] = $data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * List products.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/catalog-products/v1/#products_list
     */
    public function listProducts(int $page = 1, int $size = 20, bool $totals = true)
    {
        $totals = ($totals === true) ? 'true' : 'false';

        $this->apiEndPoint = "v1/catalogs/products?page={$page}&page_size={$size}&total_required={$totals}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Update a product.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/catalog-products/v1/#products_patch
     */
    public function updateProduct(string $product_id, array $data)
    {
        $this->apiEndPoint = "v1/catalogs/products/{$product_id}";

        $this->options['json'] = $data;

        $this->verb = 'patch';

        return $this->doPayPalRequest(false);
    }

    /**
     * Get product details.
     *
     *
     * @return array|\Psr\Http\Message\StreamInterface|string
     *
     * @throws \Throwable
     *
     * @see https://developer.paypal.com/docs/api/catalog-products/v1/#products_get
     */
    public function showProductDetails(string $product_id)
    {
        $this->apiEndPoint = "v1/catalogs/products/{$product_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}

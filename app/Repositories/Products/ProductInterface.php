<?php

namespace App\Repositories\Products;

interface ProductInterface
{

    public function create(array $data);

    public function createImage(array $data);

    public function insertPayment($product_id, $payment_id);

    public function getProducts($store_branch_id);

    public function getAllProducts($store_branch_id);

    public function getTaggableProduct($store_branch_id);

    public function getProductByCategory($category_id, $branch);

    public function deleteProduct($product_id);

    public function getOne($product);

    public function updateProduct(array $where, array $data);

    public function deleteProductPayment($product_id, $payment_id);

    public function allocateTag($product_id, $tag_id);

    public function getCategories($branch_id);

    public function productCount($branch_id, $category_id);

    public function getProduct($product_id);

    public function countProducts($store_branch_id);

    public function checkStock($product_id);

    public function saveBarcode($product_id, $barcode);

    public function getProductByBarcode($barcode, $branch);

    public function getProductCountByBarcode($barcode, $branch);

    public function getProductModelByBarcode($barcode, $branch);

    public function reduceQuantity($product, $quantity);

    public function getProductByRfid($rfid, $branch);

    public function getProductByCode($code, $branch);

    public function getBranchId($product_id);

    public function getProductByUniqueId($uniqueCode, $branch);

    public function deleteProductsByBranch($branch);
}

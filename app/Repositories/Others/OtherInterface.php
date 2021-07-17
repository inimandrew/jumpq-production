<?php

namespace App\Repositories\Others;

interface OtherInterface {

    public function create(array $data);

    public function getAll();

    public function showPaymentTypes();

    public function deleteCategory($id);

    public function updateCategory(array $where,array $data);

    public function createTag(array $data);

    public function countAvailableTags($store_branch_id);

    public function getAvailableTags($store_branch_id);

    public function getSalesRecordsAll($store_branch_id,$start_date,$end_date);

    public function getAllSales($store_branch_id,$start_date,$end_date);

    public function countSales($store_branch_id);

    public function addToCart($user,$cart,$branch);

    public function addNormalUserToCart($user,$cart,$branch);

    public function getCart($user);

    public function checkCart($user,$product);

    public function deleteCart($cart_id);

    public function addBuyer($buyer);

    public function addPayment($payer,array $payment);

    public function getCheckOutCart($user);

    public function getProductTagId($tag,$branch);

    public function checkOutTags($branch);

    public function checkTagStatus($tag,$branch);

    public function checkOutCart($cart);

    public function getSale($transaction_id);

    public function clearPayment($transaction_id,$staff_id);

    public function getTransactions($user);

    public function verifyTransaction($transaction_id);

    public function getProductId($tag,$branch);

    public function updateCart($user,$cart);

    public function activateCampaign($campaign_id);

}

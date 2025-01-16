<?php
#App\Plugins\Payment\BankTransfer\Controllers\FrontController.php
namespace App\Plugins\Payment\BankTransfer\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CartController;

class FrontController extends Controller
{
    /**
     * Process order
     *
     * @return  [type]  [return description]
     */
    public function processOrder(){
        
        return (new CartController)->completeOrder();
    }
}

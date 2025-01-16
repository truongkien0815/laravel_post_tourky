<?php
#App\Plugins\Payment\Cash\Controllers\FrontController.php
namespace App\Plugins\Payment\Cash\Controllers;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
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

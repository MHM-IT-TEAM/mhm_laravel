<?php
namespace App\Service\V1\Traits;

use App\Models\GraceCsbTransactionDetail;
use App\Models\inventory_system\GraceCsbTransaction;
use Illuminate\Database\Eloquent\Model;

trait GraceCsbTransactionTrait{
    public function transaction($request,$admission_id){
        $transaction= new GraceCsbTransaction();
        $transaction->admission_id=$admission_id;
        $transaction->done=0;
        $transaction->save();
        foreach($request as $line){
            $line['grace_csb_transaction_id']=$transaction->id;
            GraceCsbTransactionDetail::create_detail($line,);
        }
    }

}

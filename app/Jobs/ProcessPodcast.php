<?php

namespace App\Jobs;

use App\Pedidos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\CarrinhoAbandonado;

class ProcessPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 60;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Pedidos $pedidos)
    {
        $this->pedido = $pedidos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        if($this->pedido->carrinho_abandonado == 0){
            $this->pedido->RelationCliente->notify(new CarrinhoAbandonado($this->pedido));
        }else{
            $this->pedido->RelationCliente->notify(new NovoPedidoCliente($this->pedido));
        }
        
    }
}

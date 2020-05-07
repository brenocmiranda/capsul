<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Pedidos;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Pedidos $pedido)
    {
        if($pedido->carrinho_abadonado == 1){
            $pedido->RelationCliente->notify(new CarrinhoAbandonado($pedido)); 
       }else{
            $pedido->RelationCliente->notify(new NovoPedidoCliente($pedido));
       }
    }
}

@extends('template.index')

@section('title')
Visão Geral
@endsection

@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <div class="mx-3">
        <h1>Dashboard</h1>

        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item"><a href="{{route('home')}}">Início</a></div>
          <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
        </div>
      </div>
    </div>
    <input type="hidden" id="pedidos" value="{{ $pedidos ?? '' }}"/>
    <div class="section-body">
      <div class="col-12">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-stats">
                <div class="card-stats-title text-uppercase"><b> VENDAS / HOJE </b></div>
                <div class="card-valor col-12">
                </div>
                <div class="card-total col-12">

                </div>
                <div class="card-grafic m-3">
                  <canvas id="myChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-stats">
                <div class="card-stats-title text-uppercase"><b> VENDAS / NO MÊS </b></div>
                <div class="card-valor col-12">

                </div>
                <div class="card-total col-12">

                </div>
                <div class="card-grafic m-3">
                  <canvas id="myChart1"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-stats">
                <div class="card-stats-title text-uppercase"><b> RECEITA / NO MÊS </b></div>
                <div class="card-valor col-12">

                </div>
                <div class="card-total col-12">

                </div>
                <div class="card-grafic m-3">
                  <canvas id="myChart2"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('support')
<script src="{{ asset('public/page/modules-chartjs.js')}}"></script>
<script src="{{ asset('public/modules/chart.min.js') }}"></script>

<script type="text/javascript">
 $(document).ready(function (){
  var pedidos = $('#pedidos').val()
  console.log({pedidos})
  if(pedidos != '')
    pedidos = JSON.parse(pedidos)
  let data = new Date();
  let dias = 30
  let vendas_dias = {
    labels: [],
    data: []
  }
  let vendas_mes = {
    labels: [],
    data: []
  }
  let receitas_mes = {
    labels: [],
    data: []
  }
  do{
    let pedidos_dia = pedidos.filter(item => item.created_at.toISOString().slice(0,10) == data.toISOString().slice(0,10)).length
    if(pedidos_dia > 0){
      vendas_dias.labels.push(data.toLocaleDateString('pt-BR').slice(0, 5))
      vendas_dias.data.push(pedidos_dia)
    }
    data.setDate(data.getDate()-1)
    dia--
  }while(dias > 0)
  let meses = 11
  do{
    let pedidos_mes = pedidos.filter(item => item.created_at.toISOString().slice(0,7) == data.toISOString().slice(0,7))
    if(pedidos_mes.length > 0){
      vendas_mes.labels.push(data.toLocaleDateString('pt-BR').slice(0, 5))
      vendas_mes.data.push(pedidos_mes.reduce((acum, item) => {return acum + item.valor_compra;}, [0]))
    }
    pedidos_mes = pedidos_mes.filter(item => item.transacao_pagarme)
    if(pedidos_mes.length > 0){
      receitas_mes.labels.push(data.toLocaleDateString('pt-BR').slice(3, 10))
      receitas_mes.data.push(pedidos_mes.reduce((acum, item) => {return acum + item.valor_compra;}, [0]))
    }
    data.setDate(data.getDate()-1)
    dia--
  }while(mes >= 0)
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: vendas_dias.labels,
      datasets: [{
        label: '',
        data: vendas_dias.data,
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(54, 162, 235, 0.2)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 0
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: vendas_mes.labels,
      datasets: [{
        label: '',
        data: vendas_mes.data,
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(54, 162, 235, 0.2)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 0
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });

  var ctx = document.getElementById('myChart1').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: receitas_mes.labels,
      datasets: [{
        label: '',
        data: receitas_mes.data,
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(54, 162, 235, 0.2)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 0
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });

  var ctx = document.getElementById('myChart2').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
        label: '',
        data: [2, 1, 3, 5, 25, 3],
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(54, 162, 235, 0.2)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 0
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });

});
</script>
@endsection
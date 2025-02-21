<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Transações</title>

    <!-- Load the Google Charts API -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawCharts);

      function drawCharts() {
        var rawData = {{ data | raw }}; // Pegando os dados do PHP como JSON

        drawTransactionChart(rawData.transactions);
        drawIncomeOutcomeChart(rawData.income, rawData.outcome);
      }

      function drawTransactionChart(transactions) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Item');
        data.addColumn('number', 'Quantidade Vendida');

        transactions.forEach(function(row) {
          data.addRow([row.name_item, parseInt(row['COUNT(fk_item)'])]);
        });

        var options = {
          title: 'Quantidade de Itens Vendidos',
          width: 500,
          height: 350
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_transactions'));
        chart.draw(data, options);
      }

      function drawIncomeOutcomeChart(income, outcome) {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Data');
      data.addColumn('number', 'Entradas (Income)');
      data.addColumn('number', 'Saídas (Outcome)');

      var transactions = {};

      // Processando Entradas (Income)
      income.forEach(function(row) {
        var date = row.transaction_date;
        var value = parseFloat(row.total_amount);

        if (!transactions[date]) {
          transactions[date] = { income: 0, outcome: 0 };
        }
        transactions[date].income += value;
      });

      // Processando Saídas (Outcome)
      outcome.forEach(function(row) {
        var date = row.transaction_date;
        var value = parseFloat(row.total_amount);

        if (!transactions[date]) {
          transactions[date] = { income: 0, outcome: 0 };
        }
        transactions[date].outcome += value;
      });

      // Criando um array para o gráfico e garantindo a ordenação correta das datas
      var chartData = [];
      Object.keys(transactions).sort().forEach(function(date) {
        chartData.push([date, transactions[date].income, transactions[date].outcome]);
      });

      // Adicionando as linhas ao gráfico
      chartData.forEach(function(row) {
        data.addRow(row);
      });

      var options = {
        title: 'Entradas vs. Saídas por Dia',
        legend: { position: 'bottom' },
        width: 600,
        height: 400,
        hAxis: { title: 'Data', slantedText: true, slantedTextAngle: 45 },
        vAxis: { title: 'Valor (R$)' },
        colors: ['#28a745', '#dc3545'],
        bar: { groupWidth: '50%' },
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('chart_income_outcome'));
      chart.draw(data, options);
    }
    </script>
  </head>

  <body>
    <a href="/financial-control-system/financial">Voltar</a>

    <div id="chart_transactions" class="chart-container"></div>

    <div id="chart_income_outcome" class="chart-container"></div>
  </body>
</html>

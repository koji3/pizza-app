<!doctype html>
<html ng-app="pizza-app">
	<head>
		<title>Extremely Simple Pizzas</title>
		<link rel="stylesheet" type="text/css" href="<?= URL::asset('css/compiled.css') ?>" />
	</head>
	<body ng-controller="MainController">
		<div id="main" class="container">
			<h1 id="title">Extremely Simple Pizzas</h1>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<strong>Your Order</strong>
						<span class="pull-right"><strong>Total Cost:</strong> ${{ total() }}</span>
					</h3>
				</div>
				<div class="panel-body" ng-if="step == 1">
					<p ng-if="!order.pizzas.length">Please click the below button to add a pizza to your order.</p>
					<a class="btn btn-primary" href="" ng-click="addPizza()"><i class="glyphicon glyphicon-plus"></i> Add Pizza</a>
					<table id="pizzas" class="table table-condensed" ng-if="order.pizzas.length">
						<tr>
							<th>&nbsp;</th>
							<th>Size</th>
							<th>Base</th>
							<th>Toppings</th>
							<th style="text-align: right;">Total</th>
						</tr>
						<tr ng-repeat="pizza in order.pizzas">
							<td><a ng-click="removePizzaFromOrder(pizza)" class="btn btn-danger btn-xs" href="">&times;</a></td>
							<td>
								<select class="form-control input-sm" ng-model="pizza.size" ng-options="size.name + ' ($' + size.price + ')' for size in sizes">
									<option value="">Please choose</option>
								</select>
							</td>
							<td>
								<select class="form-control input-sm" ng-disabled="pizza.size.price == 0" ng-model="pizza.base" ng-options="base.name + ' ($' + base.price + ')' for base in bases">
									<option value="">Please choose</option>
								</select>
							</td>
							<td class="toppings">
								<select class="form-control input-sm" ng-disabled="pizza.base.price == 0" ng-model="pizza.current_topping" ng-options="topping.name + ' ($' + topping.price + ')' for topping in toppings" ng-change="addToppingToPizza(pizza, pizza.current_topping)">
									<option value="">Please choose</option>
								</select>
								<ul ng-repeat="topping in pizza.toppings">
									<li><strong>{{ topping.name }}</strong> - ${{ topping.price }} <a class="btn btn-danger btn-xs" ng-click="removeToppingFromPizza(pizza, topping)" href="">&times;</a></li>
								</ul>
							</td>
							<td>
								<span class="pull-right">$ {{ totalForPizza(pizza) }}</span>
							</td>
						</tr>
					</table>
				</div>
				<div class="panel-body" ng-if="step == 2">
					<p>These are the pizzas you are ordering:</p>
					<table class="table table-condensed">
						<tr>
							<th>Size</th>
							<th>Base</th>
							<th>Toppings</th>
							<th style="text-align: right;">Total</th>
						</tr>
						<tr ng-repeat="pizza in order.pizzas">
							<td>{{ pizza.size.name }}</td>
							<td>{{ pizza.base.name }}</td>
							<td>
								<ul ng-repeat="topping in pizza.toppings">
									<li><strong>{{ topping.name }}</strong> - ${{ topping.price }}</a></li>
								</ul>
							</td>
							<td>
								<span class="pull-right">$ {{ totalForPizza(pizza) }}</span>
							</td>
						</tr>
					</table>
					<p>Please enter your delivery details:</p>
					<div style="width: 40%">
						<label>Your Name</label>
						<input class="form-control" type="text" ng-model="order.customer_name" />
					</div>
					<div style="width: 40%">
						<label>Your Address</label>
						<textarea rows="4" class="form-control" ng-model="order.customer_address"></textarea>
					</div>
				</div>
				<div class="panel-body" ng-if="step == 3">
					<div class="alert alert-success">
						<p>Your order has been submitted!</p>
					</div>
					<p>The delivery man will be around soon to deliver it.</p>
					<p>The delivery name is: {{ order.customer_name }}</p>
					<p>The delivery address is:<br />
						{{ order.customer_address }}
					</p>
				</div>
			</div>
			<a ng-if="hasCompletedPizzas() && step == 1" class="btn btn-success pull-right" href="" ng-click="advanceToDeliveryDetails()">I am happy with my order!</a>
			<a ng-if="hasCompletedDeliveryDetails() && step == 2" class="btn btn-success pull-right" href="" ng-click="submitOrder()">Send me my pizza!</a>
			<img class="loader pull-right" ng-if="submitting" src="<?= URL::asset('images/ajax-loader.gif') ?>" />
		</div>
		<script type="text/javascript" src="<?= URL::asset('js/compiled.js') ?>"></script>
	</body>
</html>
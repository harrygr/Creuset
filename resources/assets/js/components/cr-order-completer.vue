<template>
	<button class="btn btn-default" @click="completeOrder"><i class="fa fa-check"></i></button>
</template>

<script>
	module.exports = {
		props: ['orderid'],

		data: function() {
			return {
				orderStatus: null,
			};
		},
		methods: {
			completeOrder: function() {
				this.$http.patch('/api/orders/' + this.orderid, {
					status: 'completed',
				}).success(this.orderCompleted)
				  .error(this.orderError);
			},
			orderCompleted: function(response) {
				window.location.reload();
			},
			orderError: function(response) {
				
			}
		},
	}
</script>
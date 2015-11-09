<template>
    <div class="form-group">
        <label for="{{ name }}">{{ title }}</label>
        <div class="date">
        	<input type="datetime-local" name="{{ name }}" value="{{ value }}" class="form-control">
        </div>
    </div>
</template>

<script>
	module.exports = {
		props: ['name', 'value', 'title'],

		data: function() {

		},
	}
</script>
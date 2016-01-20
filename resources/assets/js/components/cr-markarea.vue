<template>
	<div>
		<div>
			<label for="{{ name }}" class="sr-only">Content</label>
			<textarea class="form-control" name="{{ name }}" placeholder="Content (Markdown/HTML)" v-model="value" cols="50" rows="10">
			</textarea>
		</div>

		<div class="panel panel-default top-buffer">                    
			<div class="panel-body" v-html="value | marked"></div>
		</div>
	</div>
</template>

<script>
	module.exports = {
		props: ['name', 'title', 'value'],

		data: function() {
			return {
				
			};
		},
		filters: {
			marked: require('marked'),
		},
	}
</script>
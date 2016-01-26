<template>
	<div class="form-group">
		<label for="title" class="sr-only">{{ name | capitalize }}</label>
		<input 
		type="text" 
		name="{{ name }}" 
		class="post-title-input" 
		placeholder="{{ name | capitalize }}" 
		v-model="value" 
		@blur= "setNewSlug()">                 
	</div>
	<div class="form-group">
	<label for="slug" class="sr-only">Slug</label>
	<div class="input-group input-group-sm">
  
		<input type="text" name="slug" class="form-control" placeholder="slug" v-model="slug">

		<span class="input-group-btn refresh-slug">
			<button class="btn btn-default" value="{{ slug }}" type="button" @click="sluggifyTitle"><i class="fa fa-refresh"></i></button>
		</span>
	</div>
	</div>
</template>

<script>
	var sluggify = require('../filters/sluggify.js');

	module.exports = {
		props: ['value', 'slug', 'name'],

		data: function() {
			return {
				hasSlug: false,
			};
		},

		ready: function()
		{
			if (this.slug != '') this.hasSlug = true;
		},
		methods: {
			sluggifyTitle: function(e)
			{
				if (e) e.preventDefault();
				this.slug = sluggify(this.value);
			},
			setNewSlug: function(e)
			{
				if (this.slug == '')
				{
					this.sluggifyTitle(e);
				}
			}
		}
	}
</script>
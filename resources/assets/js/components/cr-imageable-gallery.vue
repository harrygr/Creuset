<template>
	<!-- Post images -->  
	<div class="panel panel-default" id="post-images">
		<div class="panel-heading">
			Attached Images
		</div>

		<div class="panel-heading" v-if="selectedImage.id">

			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" @click="selectedImage = {}">&times;</span></button>

			<div class="row">
				<div class="col-md-4">
					<img class="media-object img-thumbnail img-responsive" v-bind:src="selectedImage.thumbnail_url" alt=""> 
				</div>
				<div  class="col-md-8">
					<div class="form-group">
						<label>URL: </label>
						<input type="text" class="form-control input-sm" readonly value="{{ selectedImage.url }}">
					</div>    

					<div class="form-group">
						<label>Thumbnail: </label>
						<input type="text" class="form-control input-sm" readonly value="{{ selectedImage.thumbnail_url }}">
					</div>

					<div class="form-group">
						<label>Image Title</label>
						<input type="text" v-model="selectedImage.title" class="form-control">
					</div>

					<div class="form-group">
						<label>Caption</label>
						<textarea v-model="selectedImage.caption" class="form-control"></textarea>
					</div>
					
					<button @click="updateImage" class="btn btn-primary">Update Image</button>
					<a @click="deleteImage" class="btn btn-danger">Delete Image</a>
					<button @click="selectedImage = {}" class="btn btn-link">Cancel</button>

					<p class="form-group">
					<span v-if="imageUpdating"><i class="fa fa-circle-o-notch fa-spin"></i> Working...</span>
					<span class="text-success" v-if="imageUpdatedMessage"> <i class="fa fa-check"></i> {{ imageUpdatedMessage }}</span>
					</p>
				</div>
			</div>
		</div>

		<div class="panel-body">

			<span v-if="imagesLoading"><i class="fa fa-circle-o-notch fa-spin"></i> Loading images...</span>

			<div class="row" v-if="hasImages">
			<div class="col-md-2 col-sm-3 col-xs-6 top-buffer" v-for="image in images">
					<img v-bind:src="image.thumbnail_url" alt="" class="img-responsive img-thumbnail selectable" v-bind:class="{'selected': isSelected(image.id)}" @click="selectImage(image)">
				</div>
			</div>

			<span v-if="!hasImages">No Images yet</span>

		</div>
	</div>
</template>

<script>
	module.exports = {
		props: ['imageableUrl'],

		data: function () {
			return {
				images: [],
				selectedImage: {},
				imagesLoading: false,
				imageUpdating: false,
				imageUpdatedMessage: false,
			}
		},

		computed: {
			hasImages: function()
			{
				return this.images.length > 0;
			}
		},

		ready: function()
		{
			this.fetchImages();
		},

		methods: {
			fetchImages: function()
			{
				this.imagesLoading = true;

				this.$http.get(this.imageableUrl).success(function(response)
				{
					this.images = response;
					this.imagesLoading = false;

				});

			},

			updateImage: function(e)
			{
				e.preventDefault();
				this.imageUpdating = true;
				this.$http.patch('/api/images/' + this.selectedImage.id, this.selectedImage).success(function(response)
				{
					this.imageUpdating = false;
					this.showMessage('Done');
				});
			},

			deleteImage: function(e)
			{
				e.preventDefault();
				if (confirm("Are you sure?")) {
					this.$http.delete('/api/images/' + this.selectedImage.id).success(function(response) {
						this.showMessage(response);
						this.fetchImages();
						this.selectedImage = {};
					});
				}
			},

			showMessage: function(message) {
				this.imageUpdatedMessage = message;
				setTimeout(function(){ this.imageUpdatedMessage = false}.bind(this), 5000);
			},

			selectImage(image)
			{
				this.selectedImage = image;
			},

			isSelected: function(id)
			{
				return this.selectedImage.id == id;
			},

			url: function(image, thumbnail)
			{
				thumbnail = thumbnail || false;

				var url = '/images/' + image.id;
				if (thumbnail) {
					url += '?thumbnail=1';
				}
				return url;
			}
		}
	};
</script>